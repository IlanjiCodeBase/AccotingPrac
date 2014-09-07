<?php 
class SettingsController extends Zend_Controller_Action {
	/**
     * @var result
    */
	protected $result;
	
	/**
    * @var $postArray
    */
	protected $postArray;
	
	public function init() {
		$this->root 	   = Zend_Registry::get('path');
		$this->uploadPath  = Zend_Registry::get('uploadpath');
		$this->account 	   = new Account();
		$this->settings    = new Settings();
		$this->accountData = new Account_Data();
		if(Zend_Session::namespaceIsset('sess_login')) {
			$logSession = new Zend_Session_Namespace('sess_login');
			if($logSession->type==0 && !isset($logSession->companySet)) {
				$this->_redirect('developer');
			}
			if($logSession->type==3 || $logSession->type==4 || $logSession->type==5) {
				$this->_redirect('index');
			}
		} else {
			$this->_redirect('index');
		}
 	}
	/**
    * @param $method action
    */
	
	public function __call($method, $args) {
			// If an unmatched 'Action' method was requested, pass on to the
			// default action method:
			if ('Action' == substr($method, -6)) {
				return $this->_redirect('index/error/');
			}
			throw new Zend_Controller_Exception('Invalid method called');
	}

	public function indexAction() {
	      if(!Zend_Session::namespaceIsset('sess_login')) {
	            $this->_redirect('index');
	      } else {
	      	$logSession = new Zend_Session_Namespace('sess_login');
	      }
    }

    public function companyAction() {
	if(!Zend_Session::namespaceIsset('sess_login')) {
	            $this->_redirect('index');
	      } else {
	      	if(Zend_Session::namespaceIsset('update_success_company')) {
				$this->view->success = 'Company Details Updated Successfully';
				Zend_Session::namespaceUnset('update_success_company');
			}
			$getAccountArray            =  $this->accountData->getData(array('country','currencies'));
			$this->view->countries      =  $getAccountArray['country'];
			$this->view->currencies     =  $getAccountArray['currencies'];
			$logSession = new Zend_Session_Namespace('sess_login');
			$id = $logSession->cid;
			if(!isset($id) || $id=='') {
				$this->_redirect('settings');
			} else {
				$this->view->result 		 =  $this->account->getCompany($id);
				if(!$this->view->result) {
					$this->_redirect('settings');
				}
			}
		//	echo '<pre>'; print_r($this->view->result); echo '</pre>';
			if($this->_request->isPost()) {
				$postArray  				= $this->getRequest()->getPost();
				//echo '<pre>'; print_r($postArray); echo '</pre>'; die();
					$result					= $this->settings->updateCompany($postArray,$id);
					if($result) {
						if($logSession->status==2) {
							$logSession->status   = 1;
							$logSession->currency = $postArray['currency'];
							$sessSuccess = new Zend_Session_Namespace('update_success_company');
							$sessSuccess->status = 1;
							$this->_redirect('settings/account/');
						} else {
							$sessSuccess = new Zend_Session_Namespace('update_success_company');
							$sessSuccess->status = 1;
							$this->_redirect('settings/company/');
						}
					} else {
						$this->view->error = 'Company cannot be updated. Kindly try again later';
					}
			}
	      }
    }

    public function accountAction() {
		if(!Zend_Session::namespaceIsset('sess_login')) {
		            $this->_redirect('index');
		      } else {

		      	$logSession = new Zend_Session_Namespace('sess_login');
				$cid = $logSession->cid;
		      	$this->json    =  "..".$this->uploadPath.$logSession->cid."/accounts.json";
		      	$test = array();
		      	$phpNative = Zend_Json::decode(file_get_contents($this->json));
		      	//echo $phpNative['Assets']['Current Assets']['Cash and Cash Equivalents'][1];
		      	echo '<pre>'; print_r($phpNative); echo '</pre>';  
		      	foreach ($phpNative as  $key => $value) {
		      	 if($key=='Assets') {
		      		foreach ($value as $keys => $values) {
		      			if($keys=='Bank') {
		      				foreach ($values as $key1 => $value1) {
		      					foreach ($value1 as $key2 => $value2) {
		      						$test[$key]["test"][$key1][$key2] = $value2;
		      					}
		      				}
		      			} else {
		      				foreach ($values as $key1 => $value1) {
		      					foreach ($value1 as $key2 => $value2) {
		      						$test[$key][$keys][$key1][$key2] = $value2;
		      					}
		      				}
		      			}
		      		}
		      	 } else {
		      	 	foreach ($value as $keys => $values) {
		      			
		      				foreach ($values as $key1 => $value1) {
		      					foreach ($value1 as $key2 => $value2) {
		      						$test[$key][$keys][$key1][$key2] = $value2;
		      					}
		      				}
		      		}
		      	 }
		      	}
		      	echo '<pre>'; print_r($test); echo '</pre>'; 
		      	$ss = file_put_contents("..".$this->uploadPath.$logSession->cid."/accounts.json",Zend_Json::encode($test));
		      	$logSession = new Zend_Session_Namespace('sess_login');
		      	if(Zend_Session::namespaceIsset('update_success_company')) {
					$this->view->success = 'Company Details Updated Successfully';
					Zend_Session::namespaceUnset('update_success_company');
				}
				if(Zend_Session::namespaceIsset('insert_success_account')) {
					$this->view->success = 'Account Added Successfully';
					Zend_Session::namespaceUnset('insert_success_account');
				}
				if(Zend_Session::namespaceIsset('update_success_account')) {
					$this->view->success = 'Account Updated Successfully';
					Zend_Session::namespaceUnset('update_success_account');
				}
				if(Zend_Session::namespaceIsset('delete_success_account')) {
					$deleteSuccess = new Zend_Session_Namespace('delete_success_account');
					$this->view->success = 'Account <i>'.$deleteSuccess->accName.'</i> Deleted Successfully';
					Zend_Session::namespaceUnset('delete_success_account');
				}
				if(Zend_Session::namespaceIsset('delete_failure_account')) {
					$deleteSuccess = new Zend_Session_Namespace('delete_failure_account');
					$this->view->error = 'Account <i>'.$deleteSuccess->accName.'</i> cannot be deleted. It\'s already associated with income/invoice/expense or payment';
					Zend_Session::namespaceUnset('delete_failure_account');
				}
				if(Zend_Session::namespaceIsset('delete_error_account')) {
					$deleteError = new Zend_Session_Namespace('delete_error_account');
					$this->view->error = 'Account <i>'.$deleteError->accName.'</i> cannot be deleted because it\'s already associated with product <i>'.$deleteError->prodName.'</i>';
					Zend_Session::namespaceUnset('delete_error_account');
				}
				$delid 	 = base64_decode($this->_getParam('delid'));
				$delname = base64_decode($this->_getParam('delname'));
				$deltype = base64_decode($this->_getParam('deltype'));
				if(isset($delid) && !empty($delid) && isset($delname) && !empty($delname) && isset($deltype) && !empty($deltype)) { 
					if($deltype == 3 || $deltype==4) {
						$checkProduct = $this->settings->checkProduct($delid);
					} else {
						$checkProduct = '';
					}
					if(isset($checkProduct) && (empty($checkProduct) || $checkProduct=='' || $checkProduct==0)) {
						$deleteStatus = $this->settings->deleteAccount($delid);
						if($deleteStatus && $deleteStatus==1) {
							$sessSuccess = new Zend_Session_Namespace('delete_success_account');
							$sessSuccess->status  = 1;
							$sessSuccess->accName = $delname;
							$this->_redirect('settings/account');
						} else if($deleteStatus && $deleteStatus==3) {
							$sessError = new Zend_Session_Namespace('delete_failure_account');
							$sessError->status  = 1;
							$sessError->accName = $delname;
							$this->_redirect('settings/account');
						}
					} else {
						$sessError = new Zend_Session_Namespace('delete_error_account');
						$sessError->status   = 1;
						$sessError->accName  = $delname;
						$sessError->prodName = $checkProduct;
					}
					$this->_redirect('settings/account');
				}
				if($this->_request->isPost()) {
					$postArray  				= $this->getRequest()->getPost();
					if(isset($postArray['action']) && !empty($postArray['action']) && $postArray['action']=='inc_exp') {
						$postArray['currency'] = '';
						$postArray['account_type'] 	 = $postArray['inc_exp_acc_type'];
						$postArray['account_id']  	 = $postArray['inc_exp_acc_val'];
						$postArray['account_name']   = $postArray['inc_exp_acc_name'];
						$postArray['pay_status']	 = 2;
						$postArray['company_id']	 = $logSession->cid;
						$result						 = $this->settings->insertAccount($postArray);
						if($result) {
								$sessSuccess = new Zend_Session_Namespace('insert_success_account');
								$sessSuccess->status = 1;
								$this->_redirect('settings/account/');
						} else {  
							$this->view->error = 'Account cannot be added. Kindly try again later';
						}
					} else if(isset($postArray['action']) && !empty($postArray['action']) && $postArray['action']=='others') {
						$postArray['account_type'] 	 = $postArray['oth_acc_type'];
						$postArray['account_id']  	 = $postArray['oth_acc_val'];
						$postArray['account_name']   = $postArray['oth_acc_name'];
						if(isset($postArray['pay_account']) && !empty($postArray['pay_account'])) {
							$postArray['pay_status']	 = 1;
						} else {
							$postArray['pay_status']	 = 2;
						}
						$postArray['company_id']	 = $logSession->cid;
						$result					= $this->settings->insertAccount($postArray);
						if($result) {
								$sessSuccess = new Zend_Session_Namespace('insert_success_account');
								$sessSuccess->status = 1;
								$this->_redirect('settings/account/');
						} else {  
							$this->view->error = 'Account cannot be added. Kindly try again later';
						}
					}  else if(isset($postArray['action']) && !empty($postArray['action']) && $postArray['action']=='edit') {
						$postArray['account_name']   = $postArray['edit_acc_name'];
						$accId   					 = $postArray['edit_acc_id'];
						if(isset($postArray['edit_pay_account']) && !empty($postArray['edit_pay_account'])) {
							$postArray['pay_status']	 = 1;
						} else {
							$postArray['pay_status']	 = 2;
						}
						$result					= $this->settings->updateAccount($postArray,$accId);
						if($result) {
								$sessSuccess = new Zend_Session_Namespace('update_success_account');
								$sessSuccess->status = 1;
								$this->_redirect('settings/account/');
						} else {  
							$this->view->error = 'Account cannot be updated. Kindly try again later';
						}
					}

				}
				$getAccountArray        =  $this->accountData->getData(array('accountArray','assetArray','liabilityArray','incomeArray','expenseArray','equityArray','currencies'));
				$this->view->currencies =  $getAccountArray['currencies'];
				$this->view->account    =  $getAccountArray['accountArray'];
				$this->view->asset      =  $getAccountArray['assetArray'];
				$this->view->liability  =  $getAccountArray['liabilityArray'];
				$this->view->income     =  $getAccountArray['incomeArray'];
				$this->view->expense    =  $getAccountArray['expenseArray'];
				$this->view->equity     =  $getAccountArray['equityArray'];
				$this->view->getAccount	=  $this->settings->getAccounts();
			//	echo '<pre>'; print_r($this->view->account); echo '</pre>';
			//	echo '<pre>'; print_r($this->view->asset); echo '</pre>';
			//	echo '<pre>'; print_r($this->view->liability); echo '</pre>';
			//	echo '<pre>'; print_r($this->view->income); echo '</pre>';
			//	echo '<pre>'; print_r($this->view->expense); echo '</pre>';
			//	echo '<pre>'; print_r($this->view->equity); echo '</pre>';
			//	echo '<pre>'; print_r($this->view->getAccount); echo '</pre>';
			  }
	}

	public function productsAction() {
		if(!Zend_Session::namespaceIsset('sess_login')) {
			 $this->_redirect('index');
		} else {
			$getAccountArray        =  $this->accountData->getData(array('accountArray','incomeArray','currencies'));
			$this->view->income     =  $getAccountArray['incomeArray'];
			$this->view->currencies =  $getAccountArray['currencies'];
			if(Zend_Session::namespaceIsset('delete_success_product')) {
				$this->view->success = 'Product deleted successfully';
				Zend_Session::namespaceUnset('delete_success_product');
			}
			if(Zend_Session::namespaceIsset('delete_error_product')) {
				$this->view->error = 'Product cannot be deleted. It\'s already associated with invoice';
				Zend_Session::namespaceUnset('delete_error_product');
			}
			$delid = base64_decode($this->_getParam('delid'));
			if(isset($delid) && !empty($delid)) {
				//check invoice code to be added
			//	$checkInvoice =  $this->settings->checkInvoice($delid);
				$deleteStatus = $this->settings->deleteProduct($delid);
				if($deleteStatus && $deleteStatus==1) {
					$sessSuccess = new Zend_Session_Namespace('delete_success_product');
					$sessSuccess->status = 1;
				    $this->_redirect('settings/products');
				} else if($deleteStatus && $deleteStatus==3) {
					$sessError = new Zend_Session_Namespace('delete_error_product');
					$sessError->status = 1;
				    $this->_redirect('settings/products');
				}
			}
			$this->view->result 	        =  $this->settings->getProducts();
			$this->view->incomeSelected 	=  $this->settings->getIncomeAccounts();
		//	echo '<pre>'; print_r($this->view->result); echo '</pre>';
		}
	}


	public function addProductAction() {
		if(!Zend_Session::namespaceIsset('sess_login')) {
			 $this->_redirect('index');
		} else {
			$logSession = new Zend_Session_Namespace('sess_login');
			$getAccountArray        =  $this->accountData->getData(array('accountArray','incomeArray','currencies'));
			$this->view->income     =  $getAccountArray['incomeArray'];
			$this->view->currencies =  $getAccountArray['currencies'];
			$cid = $logSession->cid;
			//echo '<pre>'; print_r($this->view->income); echo '</pre>';
			if(Zend_Session::namespaceIsset('insert_success_product')) {
				$this->view->success = 'Product added successfully';
				Zend_Session::namespaceUnset('insert_success_product');
			}
			if($this->_request->isPost()) {
				$postArray  =   $this->getRequest()->getPost();
				//echo '<pre>'; print_r($postArray); echo '</pre>';
				$this->product = $this->settings->insertProduct($postArray,$cid);
				if(isset($this->product) && !empty($this->product)) {
					$sessSuccess = new Zend_Session_Namespace('insert_success_product');
				    $sessSuccess->status = 1;
					$this->_redirect('settings/add-product');	
				} else {
					$this->view->error = 'Product cannot be added. Kindly try again later';
				}
			}
			$this->view->incomeSelected 	=  $this->settings->getIncomeAccounts();
			//echo '<pre>'; print_r($this->view->incomeSelected); echo '</pre>';
		}
	}


	public function editProductAction() {
		if(!Zend_Session::namespaceIsset('sess_login')) {
			 $this->_redirect('index');
		} else {
			$getAccountArray        =  $this->accountData->getData(array('accountArray','incomeArray','currencies'));
			$this->view->income     =  $getAccountArray['incomeArray'];
			$this->view->currencies =  $getAccountArray['currencies'];
			$id = base64_decode($this->_getParam('id'));
			if(!isset($id) || $id=='') {
				$this->_redirect('settings/products/');
			} else {
				$this->view->result  =  $this->settings->getProducts($id);
				//echo '<pre>'; print_r($this->view->result); echo '</pre>';
				if(!$this->view->result) {
					$this->_redirect('settings/products/');
				}
			}
			//echo '<pre>'; print_r($this->view->income); echo '</pre>';
			if(Zend_Session::namespaceIsset('update_success_product')) {
				$this->view->success = 'Product updated successfully';
				Zend_Session::namespaceUnset('update_success_product');
			}
			if($this->_request->isPost()) {
				$postArray  =   $this->getRequest()->getPost();
				//echo '<pre>'; print_r($postArray); echo '</pre>';
				$this->product = $this->settings->updateProduct($postArray,$id);
				if(isset($this->product) && !empty($this->product)) {
					$sessSuccess = new Zend_Session_Namespace('update_success_product');
				    $sessSuccess->status = 1;
					$this->_redirect('settings/edit-product/id/'.$this->_getParam('id'));		
				} else {
					$this->view->error = 'Product cannot be updated. Kindly try again later';
				}
			}
			$this->view->incomeSelected 	=  $this->settings->getIncomeAccounts();
		}
	}


	public function taxAction() {
		if(!Zend_Session::namespaceIsset('sess_login')) {
			 $this->_redirect('index');
		} else {
 			if(Zend_Session::namespaceIsset('set_success_tax')) {
				$this->view->success = 'Tax Code has been set as active successfully';
				Zend_Session::namespaceUnset('set_success_tax');
			}
			if(Zend_Session::namespaceIsset('unset_success_tax')) {
				$this->view->success = 'Tax Code has been unset successfully';
				Zend_Session::namespaceUnset('unset_success_tax');
			}
			if(Zend_Session::namespaceIsset('delete_success_tax')) {
				$this->view->success = 'Tax Code deleted successfully';
				Zend_Session::namespaceUnset('delete_success_tax');
			}
			if(Zend_Session::namespaceIsset('delete_error_tax')) {
				$this->view->error = 'Tax Code cannot be deleted. It\'s already associated with income/invoice/expense';
				Zend_Session::namespaceUnset('delete_error_tax');
			}
			if(Zend_Session::namespaceIsset('insert_success_tax')) {
				$this->view->success = 'Tax added successfully';
				Zend_Session::namespaceUnset('insert_success_tax');
			}
			$taxid  = base64_decode($this->_getParam('set-tax-id'));
			$status = $this->_getParam('status');
			if(isset($taxid) && !empty($taxid) && isset($status) && !empty($status)) {
				$setTax = $this->settings->setTax($taxid,$status);
				if($setTax) {
					if($status==1) {
						$sessSuccess = new Zend_Session_Namespace('set_success_tax');
						$sessSuccess->status = 1;
					} else if($status==2) {
						$sessSuccess = new Zend_Session_Namespace('unset_success_tax');
						$sessSuccess->status = 1;
					}
				}
					$this->_redirect('settings/tax');
			}
			$delid = base64_decode($this->_getParam('delid'));
			if(isset($delid) && !empty($delid)) {
				//check transaction invoice code to be added
			//	$checkTransaction =  $this->settings->checkTransaction($delid);
				$deleteStatus = $this->settings->deleteTax($delid);
				if($deleteStatus && $deleteStatus==1) {
					$sessSuccess = new Zend_Session_Namespace('delete_success_tax');
					$sessSuccess->status = 1;
					$this->_redirect('settings/tax');
				} else if($deleteStatus && $deleteStatus==3) {
					$sessError = new Zend_Session_Namespace('delete_error_tax');
					$sessError->status = 1;
					$this->_redirect('settings/tax');
				} 
			}
			$this->view->taxes 	   =  $this->settings->getTax();
		//	echo '<pre>'; print_r($this->view->result); echo '</pre>';
		}
	}

	public function addTaxAction() {
		if(!Zend_Session::namespaceIsset('sess_login')) {
			 $this->_redirect('index');
		} else {
			$logSession = new Zend_Session_Namespace('sess_login');
			$cid = $logSession->cid;
			//echo '<pre>'; print_r($this->view->income); echo '</pre>';
			
			if($this->_request->isPost()) {
				$postArray  =   $this->getRequest()->getPost();
				//echo '<pre>'; print_r($postArray); echo '</pre>';
				$this->tax = $this->settings->insertTax($postArray,$cid);
				if(isset($this->tax) && !empty($this->tax)) {
					$sessSuccess = new Zend_Session_Namespace('insert_success_tax');
				    $sessSuccess->status = 1;
					$this->_redirect('settings/tax');	
				} else {
					$this->view->error = 'Tax cannot be added. Kindly try again later';
				}
			}
		}
	}

	public function editTaxAction() {
		if(!Zend_Session::namespaceIsset('sess_login')) {
			 $this->_redirect('index');
		} else {
			$id = base64_decode($this->_getParam('id'));
			if(!isset($id) || $id=='') {
				$this->_redirect('settings/tax/');
			} else {
				$this->view->result  =  $this->settings->getAllTax($id);
				//echo '<pre>'; print_r($this->view->result); echo '</pre>';
				if(!$this->view->result) {
					$this->_redirect('settings/tax/');
				}
			}
			//echo '<pre>'; print_r($this->view->income); echo '</pre>';
			if(Zend_Session::namespaceIsset('update_success_tax')) {
				$this->view->success = 'Tax updated successfully';
				Zend_Session::namespaceUnset('update_success_tax');
			}
			if($this->_request->isPost()) {
				$postArray  =   $this->getRequest()->getPost();
				//echo '<pre>'; print_r($postArray); echo '</pre>';
				$this->tax = $this->settings->updateTax($postArray,$id);
				if(isset($this->tax) && !empty($this->tax)) {
					$sessSuccess = new Zend_Session_Namespace('update_success_tax');
				    $sessSuccess->status = 1;
					$this->_redirect('settings/edit-tax/id/'.$this->_getParam('id'));		
				} else {
					$this->view->error = 'Tax cannot be updated. Kindly try again later';
				}
			}
		}
	}


	public function userProfilesAction() {
		if(!Zend_Session::namespaceIsset('sess_login')) {
			 $this->_redirect('index');
		} else {

	      	if(Zend_Session::namespaceIsset('insert_success_user')) {
				$this->view->success = 'User Created Successfully';
				Zend_Session::namespaceUnset('insert_success_user');
			}
 			$logSession = new Zend_Session_Namespace('sess_login');
 			$cid = $logSession->cid;
 			if(Zend_Session::namespaceIsset('delete_success_user')) {
				$this->view->success = 'User deleted successfully';
				Zend_Session::namespaceUnset('delete_success_user');
			}
			$delid = base64_decode($this->_getParam('delid'));
			if(isset($delid) && !empty($delid)) {
				$deleteStatus = $this->account->deleteUser($delid);
				if($deleteStatus) {
					$sessSuccess = new Zend_Session_Namespace('delete_success_user');
					$sessSuccess->status = 1;
				}
					$this->_redirect('settings/user-profiles');
			}
 			$getAccountArray       	   =  $this->accountData->getData(array('account_types'));
			$this->view->account_types =  $getAccountArray['account_types'];
			$this->view->result	   	   =  $this->settings->getUserLists($cid);
			//echo '<pre>'; print_r($this->view->result); echo '</pre>';
		}
	}


	public function addUserAction() {
    	if(!Zend_Session::namespaceIsset('sess_login')) {
	            $this->_redirect('index');
	      } else {
	      	$getMoneyArray           =  $this->accountData->getData(array('country','account_types'));
			$this->view->countries   =  $getMoneyArray['country'];
			$this->view->accTypes    =  $getMoneyArray['account_types'];
			$logSession = new Zend_Session_Namespace('sess_login');
 			$cid = $logSession->cid;
			if($this->_request->isPost()) {
				$postArray  				= $this->getRequest()->getPost();
				$checkUsername			= $this->account->checkLogin($postArray['username']);
				if(!$checkUsername) {
					$result					= $this->account->insertLogin($postArray,$cid);
					if($result) {
						$sessSuccess = new Zend_Session_Namespace('insert_success_user');
						$sessSuccess->status = 1;
						$this->_redirect('settings/user-profiles');
					} else {
						$this->view->error = 'User cannot be created. Kindly try again later';
					}
				} else {
					$this->view->error = 'Email ID already exists. Kindly try some other email address';
				}
			}
	      }
	}


	public function editUserAction() {
    	if(!Zend_Session::namespaceIsset('sess_login')) {
	            $this->_redirect('index');
	      } else {
	      	if(Zend_Session::namespaceIsset('update_success_user')) {
				$this->view->success = 'User Updated Successfully';
				Zend_Session::namespaceUnset('update_success_user');
			}
	      	$getMoneyArray           =  $this->accountData->getData(array('country','account_types'));
			$this->view->countries   =  $getMoneyArray['country'];
			$this->view->accTypes    =  $getMoneyArray['account_types'];
			$logSession = new Zend_Session_Namespace('sess_login');
 			$cid = $logSession->cid;
			$id = base64_decode($this->_getParam('id'));
			if((!isset($id) || $id=='')) {
				$this->_redirect('settings/user-profiles');
			} else {
				$this->view->login    =  $this->account->getLoginDetails($id);
				if(!$this->view->login) {
					$this->_redirect('settings/user-profiles');
				}
			}
			if($this->_request->isPost()) {
				$postArray  				= $this->getRequest()->getPost();
				$checkUsername			= $this->account->checkLogin($postArray['username'],$id);
				if(!$checkUsername) {
					$result					= $this->account->updateLogin($postArray,$id);
					if($result) {
						$sessSuccess = new Zend_Session_Namespace('update_success_user');
						$sessSuccess->status = 1;
						$this->_redirect('settings/edit-user/id/'.$this->_getParam('id'));
					} else {
						$this->view->error = 'User cannot be updated. Kindly try again later';
					} 
				} else {
					$this->view->error = 'Email ID already exists. Kindly try some other email address';
				}
			}
		}
	}


	public function resetPasswordAction() {
    	if(!Zend_Session::namespaceIsset('sess_login')) {
	            $this->_redirect('index');
	      } else {
	      	if(Zend_Session::namespaceIsset('reset_success_user_password')) {
				$this->view->success = 'Password reset Successfully';
				Zend_Session::namespaceUnset('reset_success_user_password');
			}
	      	$getMoneyArray           =  $this->accountData->getData(array('country','account_types'));
			$this->view->countries   =  $getMoneyArray['country'];
			$this->view->accTypes    =  $getMoneyArray['account_types'];
			$id = base64_decode($this->_getParam('id'));
			if((!isset($id) || $id=='')) {
				$this->_redirect('settings/user-profiles');
			} else {
				$this->view->login    =  $this->account->getLoginDetails($id);
				if(!$this->view->login) {
					$this->_redirect('settings/user-profiles');
				}
			}
			if($this->_request->isPost()) {
				$postArray  				= $this->getRequest()->getPost();
					$result					= $this->account->resetPassword($postArray,$id);
					if($result) {
						$sessSuccess = new Zend_Session_Namespace('reset_success_user_password');
						$sessSuccess->status = 1;
						$this->_redirect('settings/reset-password/id/'.$this->_getParam('id'));
					} else {
						$this->view->error = 'Password cannot be reset. Kindly try again later';
					}
			}
	      }
	}


	public function ajaxDisplayAction() {
		$this->_helper->getHelper('layout')->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		$logSession = new Zend_Session_Namespace('sess_login');
		$action = $this->_getParam('ajaxAction');
		$accId  = base64_decode($this->_getParam('id'));
		if($action=='edit-account') {
			$getAccountArray        =  $this->accountData->getData(array('currencies'));
			$this->currencies =  $getAccountArray['currencies'];
			$this->accounts 		= $this->settings->getAccounts($accId);
			if(isset($this->accounts) && !empty($this->accounts)) {
				echo '<div class="form-group">';
            	echo '<label class="col-lg-2 control-label">Account Name</label>';
              	echo '<div class="col-lg-5">';
                echo '<input type="hidden" name="action" id="action" value="edit">';
                echo '<input type="hidden" name="edit_acc_id" id="edit_acc_id" value="'.$accId.'" />';
                echo '<input type="text" name="edit_acc_name" id="edit_acc_name" class="form-control" value="'.$this->accounts[0]['account_name'].'" />';
                echo '</div>';
        	    echo '</div>';
        		echo '<div class="form-group">';
            	echo '<label class="col-lg-2 control-label">Payment / Accruals Account</label>';
                echo '<div class="col-lg-6">';
                if($this->accounts[0]['pay_status'] == 1) {
                	$checked = "checked";
                } else {
                	$checked = "";
                }
                echo '<input type="checkbox" name="edit_pay_account" id="edit_acc_name" value="1" '.$checked.' />
               		  &nbsp; This account is for receipt / payment of money (e.g., cash equivalents) or  to record receivables/ payables';
              	echo '</div>';
        	  	echo '</div>';
        		echo '<div class="form-group">';
            	echo '<label class="col-lg-2 control-label">Currency</label>';
                echo '<div class="col-lg-5">';
                echo '<select name="edit_currency" class="form-control" disabled>';
                              $logSession = new Zend_Session_Namespace('sess_login');
                               $currencySelect = '';
                                if(isset($this->currencies) && !empty($this->currencies)) {
                                foreach ($this->currencies as $key => $currencies) {
                                  if(isset($this->accounts[0]['currency']) && !empty($this->accounts[0]['currency'])  && $key==$this->accounts[0]['currency'] ) {
                                            $currencySelect = 'selected';
                                   } else{ 
                                            $currencySelect = '';
                                    }
                    echo '<option value="'.$key.'" '.$currencySelect.'>'.$currencies.'</option>';
                                    }
                                } 
                    echo '</select>';  
                 	echo '</div>';
                	echo '</div>';
					echo '<div class="form-group">';
    				echo '<label class="col-lg-2 control-label">&nbsp;</label>';
    				echo '<div class="col-lg-3">';
       				echo '<div class="form-actions">';
          			echo '<button type="submit" id="save" class="btn btn-primary">Save</button>';
          			echo '<button type="reset" class="btn b-close">Close</button>';
      				echo '</div>';
   					echo '</div>';
  					echo '</div>';
			}
		}
	}
  

}

?>