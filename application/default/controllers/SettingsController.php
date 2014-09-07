<?php 
require_once "Account/Uploader.php";
require_once "Account/DbBackup.php";
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
		 $front      = Zend_Controller_Front::getInstance(); 
  		 //getting current module and action names
		$action     = $front->getRequest()->getActionName();
	    $module     = $front->getRequest()->getModuleName();
		$controller = $front->getRequest()->getControllerName();
		$this->root 	   = Zend_Registry::get('path');
		$this->uploadPath  = Zend_Registry::get('uploadpath');
		$this->account 	   = new Account();
		$this->settings    = new Settings();
		$this->transaction = new Transaction();
		$this->approval    = new Approval();
		$this->accountData = new Account_Data();
		if(Zend_Session::namespaceIsset('sess_login')) {
			$logSession = new Zend_Session_Namespace('sess_login');
			if($logSession->type==0 && !isset($logSession->proxy_type)) {
				$this->_redirect('developer');
			} else if($logSession->type==0 && isset($logSession->proxy_type) && ($logSession->proxy_type==3 || $logSession->proxy_type==4 || $logSession->proxy_type==5)) {
				$this->_redirect('developer');
			}
			if(($logSession->type==3 || $logSession->type==4 || $logSession->proxy_type==3 || $logSession->proxy_type==4) && ($action!='account' && $action!='add-product')) {
				$this->_redirect('index');
			}
		} else {
			$this->_redirect('index');
		}

			$logSession = new Zend_Session_Namespace('sess_login');

			if(isset($logSession->proxy_id) && !empty($logSession->proxy_id)) {
				$id = $logSession->proxy_id;
			} else {
				$id = $logSession->id;
			}

			if(isset($logSession->proxy_cid) && !empty($logSession->proxy_cid)) {
				$cid = $logSession->proxy_cid;
			} else {
				$cid = $logSession->cid;
			}

			$notify = array();
			$countMessage = 0; 
			$countUnseenMessage = 0; 

			$this->view->defaultTheme = $this->account->getDefaultTheme();
			$this->view->companyLogo  = $this->account->getCompanyLogo();
			$this->view->logopath     = $this->uploadPath.$cid."/";
			$this->notifications = $this->approval->getNotificationMessage($cid,$id);
			if(isset($this->notifications) && !empty($this->notifications)) {
				foreach ($this->notifications as $notification) {
					$users 			= explode(",", $notification['users']);
					$seen_users 	= explode(",", $notification['seen_users']);
					if(in_array($id,$users) || $notification['users']=='all') {
						if(in_array($id, $seen_users)) {
							$notify[$notification['id']]['seen'] = 1;
						} else {
							$notify[$notification['id']]['seen'] = 2;
							$countUnseenMessage++;
						}
						$countMessage++; 
						$notify[$notification['id']]['subject'] = $notification['subject'];
						$notify[$notification['id']]['message'] = $notification['message'];
						$notify[$notification['id']]['date']    = $notification['date_created'];
					}
				}
			}

			$this->view->notifyMessage  	   = $countMessage;
			$this->view->notifyUnseenMessage   = $countUnseenMessage;
			$this->view->notifyHeaderMessage   = $notify;

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

    public function downloadAction() {
    	  $this->_helper->getHelper('layout')->disableLayout();
		  $this->_helper->viewRenderer->setNoRender(true);
	      if(!Zend_Session::namespaceIsset('sess_login')) {
	            $this->_redirect('index');
	      } else {
	      	$logSession = new Zend_Session_Namespace('sess_login');
	      	$id = base64_decode($this->_getParam('id'));
	      	header("Content-disposition: attachment; filename=backup.sql");
			header("Content-type: application/sql");
			readfile("'.$id.'");
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
			if(isset($logSession->proxy_cid) && !empty($logSession->proxy_cid)) {
				$id = $logSession->proxy_cid;
			} else {
				$id = $logSession->cid;
			}
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
				$start_date	 = date('d-m-Y',strtotime($postArray['start_date']));
				$end_date	 = date('d-m-Y',strtotime($postArray['end_date']));
				$start = strtotime($start_date);
                $end   = strtotime($end_date);
                $days_between = ceil(abs($end - $start) / 86400); 
               // echo $days_between; die();
                if($days_between=='364' || $days_between=='1') {
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
				} else {
					$this->view->error = 'Financial start and end date should be exactly one year';
				}
			}
	      }
    }

    public function accountAction() {
		if(!Zend_Session::namespaceIsset('sess_login')) {
		            $this->_redirect('index');
		      } else {

		      	$logSession = new Zend_Session_Namespace('sess_login');
		      	if(isset($logSession->proxy_cid) && !empty($logSession->proxy_cid)) {
		      		$cid = $logSession->proxy_cid;
			      	$this->json    =  "..".$this->uploadPath.$logSession->proxy_cid."/accounts.json";
		      	} else {
					$cid = $logSession->cid;
			      	$this->json    =  "..".$this->uploadPath.$logSession->cid."/accounts.json";
			    }
		      	$asset     = array();
		      	$liability = array();
		      	$income    = array();
		      	$expense   = array();
		      	$equity    = array();
		      	$phpNative = Zend_Json::decode(file_get_contents($this->json));
		      	//echo '<pre>'; print_r($phpNative); echo '</pre>';
		      	foreach ($phpNative as  $key => $value) {
		      	 if($key=='Assets') {
		      		foreach ($value as $keys => $values) {
		      				foreach ($values as $key1 => $value1) {
		      					foreach ($value1 as $key2 => $value2) {
		      						$asset[$keys][$key1][$key2] = $value2;
		      					}
		      				}
		      		}
		      	 }  else  if($key=='Liabilities') {
		      		foreach ($value as $keys => $values) {
		      				foreach ($values as $key1 => $value1) {
		      					foreach ($value1 as $key2 => $value2) {
		      						$liability[$keys][$key1][$key2] = $value2;
		      					}
		      				}
		      		}
		      	 }  else  if($key=='Income') {
		      		foreach ($value as $keys => $values) {
		      				foreach ($values as $key1 => $value1) {
		      					foreach ($value1 as $key2 => $value2) {
		      						$income[$keys][$key1][$key2] = $value2;
		      					}
		      				}
		      		}
		      	 }  else  if($key=='Expense') {
		      		foreach ($value as $keys => $values) {
		      				foreach ($values as $key1 => $value1) {
		      					foreach ($value1 as $key2 => $value2) {
		      						$expense[$keys][$key1][$key2] = $value2;
		      					}
		      				}
		      		}
		      	 }  else  if($key=='Equity') {
		      		foreach ($value as $keys => $values) {
		      				foreach ($values as $key1 => $value1) {
		      					foreach ($value1 as $key2 => $value2) {
		      						$equity[$keys][$key1][$key2] = $value2;
		      					}
		      				}
		      		}
		      	 } 
		      	}
		      	$this->view->asset 	   = $asset;
		      	$this->view->liability = $liability;
		      	$this->view->income    = $income;
		      	$this->view->expense   = $expense;
		      	$this->view->equity    = $equity;

		      	/*echo '<pre>'; print_r($asset); echo '</pre>';
		      	echo '<pre>'; print_r($liability); echo '</pre>';
		      	echo '<pre>'; print_r($income); echo '</pre>';
		      	echo '<pre>'; print_r($expense); echo '</pre>';
		      	echo '<pre>'; print_r($equity); echo '</pre>';*/
		      	//echo $phpNative['Assets']['Current Assets']['Cash and Cash Equivalents'][1];
		      	/*echo '<pre>'; print_r($phpNative); echo '</pre>';  
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
		      	echo '<pre>'; print_r($test); echo '</pre>'; */
		      	//$ss = file_put_contents("..".$this->uploadPath.$logSession->cid."/accounts.json",Zend_Json::encode($test));
		      	$logSession = new Zend_Session_Namespace('sess_login');
		      	if(Zend_Session::namespaceIsset('update_success_company')) {
					$this->view->success = 'Company Details Updated Successfully';
					Zend_Session::namespaceUnset('update_success_company');
				}
				if(Zend_Session::namespaceIsset('insert_success_account')) {
					$this->view->success = 'Account Added Successfully';
					Zend_Session::namespaceUnset('insert_success_account');
				}
				if(Zend_Session::namespaceIsset('insert_success_opening_balance')) {
					$this->view->success = 'Account Successfully Updated With Opening Balance';
					Zend_Session::namespaceUnset('insert_success_opening_balance');
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
						$auditLog	  = $this->settings->insertAuditLog(3,8,$delname,$delid);
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
						if(isset($logSession->proxy_cid) && !empty($logSession->proxy_cid)) {
							$postArray['company_id']	 = $logSession->proxy_cid;
						} else {
							$postArray['company_id']	 = $logSession->cid;
						}
						$checkAccount	= $this->settings->checkAccountName($postArray);
						if($checkAccount) {
							$result	    = $this->settings->insertAccount($postArray);
							$auditLog	= $this->settings->insertAuditLog(1,8,$postArray['account_name'],$result);
							if($result) {
									$sessSuccess = new Zend_Session_Namespace('insert_success_account');
									$sessSuccess->status = 1;
									$this->_redirect('settings/account/');
							} else {  
								$this->view->error = 'Account cannot be added. Kindly try again later';
							}
						} else {
							$this->view->error = 'Account Name already exists. Kindly try with different name';
						}
					} else if(isset($postArray['action']) && !empty($postArray['action']) && $postArray['action']=='others') {
						$postArray['account_type'] 	 = $postArray['oth_acc_type'];
						$postArray['level1']  	     = $postArray['oth_acc_l1'];
						$postArray['level2']  	     = $postArray['oth_acc_l2'];
						$postArray['account_name']   = $postArray['oth_acc_name'];

						/*if(isset($postArray['pay_account']) && !empty($postArray['pay_account'])) {
							$postArray['pay_status']	 = 1;
						} else {
							$postArray['pay_status']	 = 2;
						}*/

						//if($postArray['account_type']==3 || $postArray['account_type']==4) {
							$postArray['pay_status']  = 2;
						//}
						if(isset($logSession->proxy_cid) && !empty($logSession->proxy_cid)) {
							$postArray['company_id']	 = $logSession->proxy_cid;
						} else {
							$postArray['company_id']	 = $logSession->cid;
						}
						$checkAccount	= $this->settings->checkAccountName($postArray);
						if(!$checkAccount) {
							$result		= $this->settings->insertAccount($postArray);
							$auditLog	= $this->settings->insertAuditLog(1,8,$postArray['account_name'],$result);
							if($result) {
									$sessSuccess = new Zend_Session_Namespace('insert_success_account');
									$sessSuccess->status = 1;
									$this->_redirect('settings/account/');
							} else {  
								$this->view->error = 'Account cannot be added. Kindly try again later';
							}
						} else {
							$this->view->error = 'Account Name already exists. Kindly try with different name';
						}
					}  else if(isset($postArray['action']) && !empty($postArray['action']) && $postArray['action']=='edit') {
						$postArray['account_name']   = $postArray['edit_acc_name'];
						$accId   					 = $postArray['edit_acc_id'];
						if(isset($postArray['edit_pay_account']) && !empty($postArray['edit_pay_account'])) {
							$postArray['pay_status']	 = 1;
						} else {
							$postArray['pay_status']	 = 2;
						}
						if($postArray['account_type']==3 || $postArray['account_type']==4) {
							$postArray['pay_status']  = 2;
							$postArray['currency']	  = NULL;
						}
						$checkAccount	= $this->settings->checkAccountName($postArray,$accId);
						if(!$checkAccount) {
							$result		= $this->settings->updateAccount($postArray,$accId);
							$auditLog	= $this->settings->insertAuditLog(2,8,$postArray['account_name'],$accId);
							if($result) {
									$sessSuccess = new Zend_Session_Namespace('update_success_account');
									$sessSuccess->status = 1;
									$this->_redirect('settings/account/');
							} else {  
								$this->view->error = 'Account cannot be updated. Kindly try again later';
							}
						} else {
							$this->view->error = 'Account Name already exists. Kindly try with different name';
						}
					} else if(isset($postArray['action']) && !empty($postArray['action']) && $postArray['action']=='opening_balance') {

							$accId      = $postArray['balance_account_id'];
							$result	    = $this->settings->updateOpeningBalance($postArray,$accId);
							$auditLog	= $this->settings->insertAuditLog(2,8,$postArray['balance_account_name'],$accId);
							if($result) {
									$sessSuccess = new Zend_Session_Namespace('insert_success_opening_balance');
									$sessSuccess->status = 1;
									$this->_redirect('settings/account/');
							} else {  
								$this->view->error = 'Account cannot be updated with opening balance. Kindly try again later';
							}

					}  else if(isset($postArray['action']) && !empty($postArray['action']) && $postArray['action']=='account_level') {
						foreach ($phpNative as  $key => $value) {
					      	 if($key==ucfirst($postArray['acc_level_type'])) {

					      	  if($postArray['acc_level_hierarchy']==2) {
						      		foreach ($value as $keys => $values) {
						      			if($keys==$postArray['original_acc_name']) {
						      				foreach ($values as $key1 => $value1) {
						      					foreach ($value1 as $key2 => $value2) {
						      						$final[$key][$postArray['acc_level_name']][$key1][$key2] = $value2;
						      					}
						      				}
						      			} else {
						      				foreach ($values as $key1 => $value1) {
						      					foreach ($value1 as $key2 => $value2) {
						      						$final[$key][$keys][$key1][$key2] = $value2;
						      					}
						      				}
						      			}
						      		}
					      	  } else if($postArray['acc_level_hierarchy']==3) {
						      		foreach ($value as $keys => $values) {
						      				foreach ($values as $key1 => $value1) {
						      					if($key1==$postArray['original_acc_name']) {
							      					foreach ($value1 as $key2 => $value2) {
							      						$final[$key][$keys][$postArray['acc_level_name']][$key2] = $value2;
							      					}
						      				 } else {
						      				 	foreach ($value1 as $key2 => $value2) {
							      					$final[$key][$keys][$key1][$key2] = $value2;
							      				}
						      				 }
						      			} 
						      		}
					      	  }

					      	 } else {
					      	 	foreach ($value as $keys => $values) {
					      				foreach ($values as $key1 => $value1) {
					      					foreach ($value1 as $key2 => $value2) {
					      						$final[$key][$keys][$key1][$key2] = $value2;
					      					}
					      				}
					      		}
					      	 }
					      	}
					   if(isset($logSession->proxy_cid) && !empty($logSession->proxy_cid)) {
					   	 	$file = "..".$this->uploadPath.$logSession->proxy_cid."/accounts.json";
						   $newfile = "..".$this->uploadPath.$logSession->proxy_cid."/accounts.json.bak";
						   copy($file, $newfile);  
			      	       $json_insert = file_put_contents("..".$this->uploadPath.$logSession->proxy_cid."/accounts.json",Zend_Json::encode($final));
					   } else {
						   $file = "..".$this->uploadPath.$logSession->cid."/accounts.json";
						   $newfile = "..".$this->uploadPath.$logSession->cid."/accounts.json.bak";
						   copy($file, $newfile);  
			      	       $json_insert = file_put_contents("..".$this->uploadPath.$logSession->cid."/accounts.json",Zend_Json::encode($final));
		      	       }
		      	       if($json_insert) {
		      	       		$sessSuccess = new Zend_Session_Namespace('update_success_account');
							$sessSuccess->status = 1;
							$this->_redirect('settings/account/');
						} else {  
							$this->view->error = 'Account Details cannot be updated. Kindly try again later';
						}
					}
				}
				$getAccountArray        =  $this->accountData->getData(array('purchaseTaxCodes','supplyTaxCodes','accountArray','assetArray','liabilityArray','incomeArray','expenseArray','equityArray','currencies'));
				$this->view->currencies =  $getAccountArray['currencies'];
				$this->view->account    =  $getAccountArray['accountArray'];
				$this->view->purchase   =  $getAccountArray['purchaseTaxCodes'];
				$this->view->supply     =  $getAccountArray['supplyTaxCodes'];
				$this->view->taxes 	    =  $this->settings->getTax();
				//$this->view->asset      =  $getAccountArray['assetArray'];
				//$this->view->liability  =  $getAccountArray['liabilityArray'];
				//$this->view->income     =  $getAccountArray['incomeArray'];
				//$this->view->expense    =  $getAccountArray['expenseArray'];
				//$this->view->equity     =  $getAccountArray['equityArray'];
				$this->view->getAccount	 =  $this->settings->getAccounts();
			//	echo '<pre>'; print_r($this->view->account); echo '</pre>';
			//	echo '<pre>'; print_r($this->view->asset); echo '</pre>';
			//	echo '<pre>'; print_r($this->view->liability); echo '</pre>';
			//	echo '<pre>'; print_r($this->view->income); echo '</pre>';
			//	echo '<pre>'; print_r($this->view->expense); echo '</pre>';
			//	echo '<pre>'; print_r($this->view->equity); echo '</pre>';
			//	echo '<pre>'; print_r($this->view->taxes); echo '</pre>';
			  }
	}


    public function openingBalanceAction() {
		if(!Zend_Session::namespaceIsset('sess_login')) {
		            $this->_redirect('index');
		      } else {

		      	$logSession = new Zend_Session_Namespace('sess_login');
		      	if(isset($logSession->proxy_cid) && !empty($logSession->proxy_cid)) {
		      		$cid = $logSession->proxy_cid;
			      	$this->json    =  "..".$this->uploadPath.$logSession->proxy_cid."/accounts.json";
		      	} else {
					$cid = $logSession->cid;
			      	$this->json    =  "..".$this->uploadPath.$logSession->cid."/accounts.json";
			    }
		      	$asset     = array();
		      	$liability = array();
		      	$income    = array();
		      	$expense   = array();
		      	$equity    = array();
		      	$phpNative = Zend_Json::decode(file_get_contents($this->json));
		      	//echo '<pre>'; print_r($phpNative); echo '</pre>';
		      	foreach ($phpNative as  $key => $value) {
		      	 if($key=='Assets') {
		      		foreach ($value as $keys => $values) {
		      				foreach ($values as $key1 => $value1) {
		      					foreach ($value1 as $key2 => $value2) {
		      						$asset[$keys][$key1][$key2] = $value2;
		      					}
		      				}
		      		}
		      	 }  else  if($key=='Liabilities') {
		      		foreach ($value as $keys => $values) {
		      				foreach ($values as $key1 => $value1) {
		      					foreach ($value1 as $key2 => $value2) {
		      						$liability[$keys][$key1][$key2] = $value2;
		      					}
		      				}
		      		}
		      	 }  else  if($key=='Income') {
		      		foreach ($value as $keys => $values) {
		      				foreach ($values as $key1 => $value1) {
		      					foreach ($value1 as $key2 => $value2) {
		      						$income[$keys][$key1][$key2] = $value2;
		      					}
		      				}
		      		}
		      	 }  else  if($key=='Expense') {
		      		foreach ($value as $keys => $values) {
		      				foreach ($values as $key1 => $value1) {
		      					foreach ($value1 as $key2 => $value2) {
		      						$expense[$keys][$key1][$key2] = $value2;
		      					}
		      				}
		      		}
		      	 }  else  if($key=='Equity') {
		      		foreach ($value as $keys => $values) {
		      				foreach ($values as $key1 => $value1) {
		      					foreach ($value1 as $key2 => $value2) {
		      						$equity[$keys][$key1][$key2] = $value2;
		      					}
		      				}
		      		}
		      	 } 
		      	}
		      	$this->view->asset 	   = $asset;
		      	$this->view->liability = $liability;
		      	$this->view->income    = $income;
		      	$this->view->expense   = $expense;
		      	$this->view->equity    = $equity;
		      
		      	$logSession = new Zend_Session_Namespace('sess_login');
		      	
				if(Zend_Session::namespaceIsset('update_success_opening_balance')) {
					$this->view->success = 'Accounts Opening Balance Updated Successfully';
					Zend_Session::namespaceUnset('update_success_opening_balance');
				}

				$delid 	 = base64_decode($this->_getParam('delid'));
				$delname = base64_decode($this->_getParam('delname'));
				$deltype = base64_decode($this->_getParam('deltype'));
				
				if($this->_request->isPost()) {
					$postArray  				= $this->getRequest()->getPost();
					//echo '<pre>'; print_r($postArray); echo '</pre>';
					/*foreach ($postArray['account_debit'] as $key => $value) {
						echo $postArray['account_credit'][$key].'<br/>';
					}*/
					$this->updateOpeningBalance = $this->settings->updateOpeningBalance($postArray);
					if($this->updateOpeningBalance) {
						$sessSuccess = new Zend_Session_Namespace('update_success_opening_balance');
						$sessSuccess->status = 1;
					    $this->_redirect('settings/opening-balance');
					}
				}
				$getAccountArray        =  $this->accountData->getData(array('accountArray','assetArray','liabilityArray','incomeArray','expenseArray','equityArray','currencies'));
				$this->view->currencies =  $getAccountArray['currencies'];
				$this->view->account    =  $getAccountArray['accountArray'];
				$this->view->getAccount	=  $this->settings->getAccounts();
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
			if(Zend_Session::namespaceIsset('insert_success_product')) {
				$this->view->success = 'Product added successfully';
				Zend_Session::namespaceUnset('insert_success_product');
			}
			$delid   = base64_decode($this->_getParam('delid'));
			$delname = base64_decode($this->_getParam('delname'));
			if(isset($delid) && !empty($delid)) {
				//check invoice code to be added
			//	$checkInvoice =  $this->settings->checkInvoice($delid);
				$deleteStatus = $this->settings->deleteProduct($delid);
				$auditLog	= $this->settings->insertAuditLog(3,10,$delname,$delid);
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
			$this->view->product      	    =  $this->settings->getInvoiceCustomization();
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
			if(isset($logSession->proxy_cid) && !empty($logSession->proxy_cid)) {
				$cid = $logSession->proxy_cid;
			} else {
				$cid = $logSession->cid;
			}

			if(isset($logSession->proxy_currency) && !empty($logSession->proxy_currency)) {
		      	$this->view->currency = $logSession->proxy_currency;
		    } else {
				$this->view->currency = $logSession->currency;
		     }
			//echo '<pre>'; print_r($this->view->income); echo '</pre>';
			
			if($this->_request->isPost()) {
				$postArray  =   $this->getRequest()->getPost();
				//echo '<pre>'; print_r($postArray); echo '</pre>';
				$postArray['price'] = str_replace(",","",$postArray['price']);
				$this->product = $this->settings->insertProduct($postArray,$cid);
				$auditLog	   = $this->settings->insertAuditLog(1,10,$postArray['product_name'],$this->product);
				if(isset($this->product) && !empty($this->product)) {
					$sessSuccess = new Zend_Session_Namespace('insert_success_product');
				    $sessSuccess->status = 1;
					$this->_redirect('settings/products');	
				} else {
					$this->view->error = 'Product cannot be added. Kindly try again later';
				}
			}
			$this->view->incomeSelected =  $this->settings->getIncomeAccounts();
			$this->view->product      	=  $this->settings->getInvoiceCustomization();
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
				$postArray['price'] = str_replace(",","",$postArray['price']);
				$this->product = $this->settings->updateProduct($postArray,$id);
				$auditLog	   = $this->settings->insertAuditLog(2,10,$postArray['product_name'],$id);
				if(isset($this->product) && !empty($this->product)) {
					$sessSuccess = new Zend_Session_Namespace('update_success_product');
				    $sessSuccess->status = 1;
					$this->_redirect('settings/edit-product/id/'.$this->_getParam('id'));		
				} else {
					$this->view->error = 'Product cannot be updated. Kindly try again later';
				}
			}
			$this->view->incomeSelected =  $this->settings->getIncomeAccounts();
			$this->view->product      	=  $this->settings->getInvoiceCustomization();
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
			$taxid    = base64_decode($this->_getParam('set-tax-id'));
			$taxname  = base64_decode($this->_getParam('tax-name'));
			$status = $this->_getParam('status');
			if(isset($taxid) && !empty($taxid) && isset($status) && !empty($status)) {
				$setTax = $this->settings->setTax($taxid,$status);
				if($setTax) {
					if($status==1) {
						$auditLog	 = $this->settings->insertAuditLog(4,9,$taxname,$taxid);
						$sessSuccess = new Zend_Session_Namespace('set_success_tax');
						$sessSuccess->status = 1;
					} else if($status==2) {
						$auditLog	 = $this->settings->insertAuditLog(5,9,$taxname,$taxid);
						$sessSuccess = new Zend_Session_Namespace('unset_success_tax');
						$sessSuccess->status = 1;
					}
				}
					$this->_redirect('settings/tax');
			}
			$delid   = base64_decode($this->_getParam('delid'));
			$delname = base64_decode($this->_getParam('delname'));
			if(isset($delid) && !empty($delid)) {
				//check transaction invoice code to be added
			//	$checkTransaction =  $this->settings->checkTransaction($delid);
				$deleteStatus  = $this->settings->deleteTax($delid);
				$auditLog	   = $this->settings->insertAuditLog(3,9,$delname,$delid);
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
			$getAccountArray        =  $this->accountData->getData(array('purchaseTaxCodes','supplyTaxCodes'));
			//$this->view->purchase   =  $getAccountArray['purchaseTaxCodes'];
			//$this->view->supply     =  $getAccountArray['supplyTaxCodes'];
			$supply 			    = array();
			$purchase 				= array();
			$this->irasSupply 	    		=  $this->transaction->getIrasTax(2);
			foreach ($this->irasSupply as $irasSupply) {
				$supply[$irasSupply['id']]['name']	      = $irasSupply['name'];
				$supply[$irasSupply['id']]['percentage']  = $irasSupply['percentage'];
				$supply[$irasSupply['id']]['description'] = $irasSupply['description'];
			}
			$this->irasPurchase 	    		=  $this->transaction->getIrasTax(1);
			foreach ($this->irasPurchase as $irasPurchase) {
				$purchase[$irasPurchase['id']]['name']	      = $irasPurchase['name'];
				$purchase[$irasPurchase['id']]['percentage']  = $irasPurchase['percentage'];
				$purchase[$irasPurchase['id']]['description'] = $irasPurchase['description'];
			}
			$this->view->supply     = $supply;
			$this->view->purchase 	= $purchase;
			$this->view->taxes 	    =  $this->settings->getTax();
		//	echo '<pre>'; print_r($this->view->result); echo '</pre>';
		}
	}

	public function addTaxAction() {
		if(!Zend_Session::namespaceIsset('sess_login')) {
			 $this->_redirect('index');
		} else {
			$logSession = new Zend_Session_Namespace('sess_login');
			if(isset($logSession->proxy_cid) && !empty($logSession->proxy_cid)) {
				$cid = $logSession->proxy_cid;
			} else {
				$cid = $logSession->cid;
			}
			$getAccountArray        =  $this->accountData->getData(array('purchaseTaxCodes','supplyTaxCodes'));
			//$this->view->purchase   =  $getAccountArray['purchaseTaxCodes'];
			//$this->view->supply     =  $getAccountArray['supplyTaxCodes'];
			$supply 			    = array();
			$purchase 				= array();
			$this->irasSupply 	    		=  $this->transaction->getIrasTax(2);
			foreach ($this->irasSupply as $irasSupply) {
				$supply[$irasSupply['id']]['name']	      = $irasSupply['name'];
				$supply[$irasSupply['id']]['percentage']  = $irasSupply['percentage'];
				$supply[$irasSupply['id']]['description'] = $irasSupply['description'];
			}
			$this->irasPurchase 	    		=  $this->transaction->getIrasTax(1);
			foreach ($this->irasPurchase as $irasPurchase) {
				$purchase[$irasPurchase['id']]['name']	      = $irasPurchase['name'];
				$purchase[$irasPurchase['id']]['percentage']  = $irasPurchase['percentage'];
				$purchase[$irasPurchase['id']]['description'] = $irasPurchase['description'];
			}
			$this->view->supply     = $supply;
			$this->view->purchase 	= $purchase;
		//	echo '<pre>'; print_r($this->view->supply); echo '</pre>';
			
			if($this->_request->isPost()) {
				$postArray  =   $this->getRequest()->getPost();
				//echo '<pre>'; print_r($postArray); echo '</pre>';
				$taxcode = explode("_", $postArray['category_code']);
				$postArray['tax_code'] = $taxcode[0];
				$postArray['description'] = str_replace("\r\n", " ", $postArray['description']);
				$this->tax = $this->settings->insertTax($postArray,$cid);
				$auditLog  = $this->settings->insertAuditLog(1,9,$postArray['tax_code'],$this->tax);
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
			$getAccountArray        =  $this->accountData->getData(array('purchaseTaxCodes','supplyTaxCodes'));
			//$this->view->purchase   =  $getAccountArray['purchaseTaxCodes'];
			//$this->view->supply     =  $getAccountArray['supplyTaxCodes'];
			$supply 			    = array();
			$purchase 				= array();
			$this->irasSupply 	    		=  $this->transaction->getIrasTax(2);
			foreach ($this->irasSupply as $irasSupply) {
				$supply[$irasSupply['id']]['name']	      = $irasSupply['name'];
				$supply[$irasSupply['id']]['percentage']  = $irasSupply['percentage'];
				$supply[$irasSupply['id']]['description'] = $irasSupply['description'];
			}
			$this->irasPurchase 	    		=  $this->transaction->getIrasTax(1);
			foreach ($this->irasPurchase as $irasPurchase) {
				$purchase[$irasPurchase['id']]['name']	      = $irasPurchase['name'];
				$purchase[$irasPurchase['id']]['percentage']  = $irasPurchase['percentage'];
				$purchase[$irasPurchase['id']]['description'] = $irasPurchase['description'];
			}
			$this->view->supply     = $supply;
			$this->view->purchase 	= $purchase;
			if($this->_request->isPost()) {
				$postArray  =   $this->getRequest()->getPost();
				//echo '<pre>'; print_r($postArray); echo '</pre>';
				$taxcode = explode("_", $postArray['category_code']);
				$postArray['tax_code'] = $taxcode[0];
				$postArray['description'] = str_replace("\r\n", " ", $postArray['description']);
				$this->tax = $this->settings->updateTax($postArray,$id);
				$auditLog  = $this->settings->insertAuditLog(2,9,$postArray['tax_code'],$id);
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
 			if(isset($logSession->proxy_cid) && !empty($logSession->proxy_cid)) {
 				$cid = $logSession->proxy_cid;
 			} else {
 				$cid = $logSession->cid;
 			}
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
			if(isset($logSession->proxy_cid) && !empty($logSession->proxy_cid)) {
				$cid = $logSession->proxy_cid;
			} else {
 				$cid = $logSession->cid;
 			}
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
			if(isset($logSession->proxy_cid) && !empty($logSession->proxy_cid)) {
				$cid = $logSession->proxy_cid;
			} else {
 				$cid = $logSession->cid;
 			}
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

	public function invoiceAndCreditNoteCustomizationAction() {
		if(!Zend_Session::namespaceIsset('sess_login')) {
			 $this->_redirect('index');
		} else {
			$accImage     =  new Account_Image();
			$logSession = new Zend_Session_Namespace('sess_login');
			if(isset($logSession->proxy_cid) && !empty($logSession->proxy_cid)) {
				$cid = $logSession->proxy_cid;
	 			$this->view->filepath   	=  $this->uploadPath.$logSession->proxy_cid."/";
			} else {
	 			$cid = $logSession->cid;
	 			$this->view->filepath   	=  $this->uploadPath.$logSession->cid."/";
	 		}
 			$getAccountArray            =  $this->accountData->getData(array('currencies','creditTermArray','supplyTaxCodes','purchaseTaxCodes'));
			$this->view->currencies     =  $getAccountArray['currencies'];
			$this->view->creditTerm     =  $getAccountArray['creditTermArray'];
			//$this->view->supply         =  $getAccountArray['supplyTaxCodes'];
			//$this->view->purchase       =  $getAccountArray['purchaseTaxCodes'];
			//$this->view->taxCode    	=  $this->transaction->getTax();
			$this->view->invoiceNext    =  $this->settings->getInvoiceNextNumber();
			$this->view->creditNext     =  $this->settings->getCreditNextNumber();
			$supply = array();
			$this->iras 	    		=  $this->transaction->getIrasTax(2);
			foreach ($this->iras as $iras) {
				$supply[$iras['id']]['name']	    = $iras['name'];
				$supply[$iras['id']]['percentage']  = $iras['percentage'];
				$supply[$iras['id']]['description'] = $iras['description'];
			}
			$this->view->supply 		= $supply;
			$this->view->taxCode    	=  $this->transaction->getSalesTax(2);

			if(Zend_Session::namespaceIsset('update_success_customize')) {
				$this->view->success = 'Customization Updated Successfully';
				Zend_Session::namespaceUnset('update_success_customize');
			}
			if(Zend_Session::namespaceIsset('sess_file_resize_error')) {
				$this->view->success = 'Resizing of logo image failed. Kindly upload a logo of less than 10mb size';
				Zend_Session::namespaceUnset('sess_file_resize_error');
			}
			if(Zend_Session::namespaceIsset('sess_file_valid_error')) {
				$this->view->success = 'Logo is not a valid image. Kindly upload a jpg/png type of image';
				Zend_Session::namespaceUnset('sess_file_valid_error');
			}

			if($this->_request->isPost()) {
				$postArray  	  = $this->getRequest()->getPost();

				$adapter    =  new Zend_File_Transfer_Adapter_Http();
					$fileInfo 	=  $adapter->getFileInfo('file'); 
					if(isset($fileInfo['file']['name']) && ($fileInfo['file']['name'] != '')) {
						$adapter->addValidator('Count', false, array('min' =>1, 'max' => 2))
						        ->addValidator('Size',false,array('max'=>2024000),'file')
								->addValidator('Extension',false,'jpg,png','file');
						$adapter->setDestination("..".$this->view->filepath,'file');
						$fileInfo 	         	  =   $adapter->getFileInfo('file');
						$fileArray		  		  =   explode('.',$fileInfo['file']['name']);
						$postArray['extension']   =   $fileArray['1'];
						$renameFile 		  	  =   trim("logo".$cid.".".$fileArray['1']);
						$adapter->addFilter('Rename',"..".$this->view->filepath.$renameFile);
							if ($adapter->isValid()) {
								$accImage->resize($fileInfo['file']['tmp_name'], "..".$this->view->filepath.$renameFile, 75, 40);
								$postArray['logo']   =   $renameFile;
							} else {
								$sessError = new Zend_Session_Namespace('sess_file_valid_error');
								$sessError->status = 1;
							    $this->_redirect('settings/invoice-and-credit-note-customization');	
							}
					} 

				if(isset($postArray['display_logo']) && !empty($postArray['display_logo'])) {
				   $postArray['display_logo'] = 1;
				} else {
					$postArray['display_logo'] = 2;
				}

				$this->customize  = $this->settings->updateInvoiceCustomization($postArray,$cid);
				if(isset($this->customize) && !empty($this->customize)) {
					$sessSuccess = new Zend_Session_Namespace('update_success_customize');
				    $sessSuccess->status = 1;
					$this->_redirect('settings/invoice-and-credit-note-customization');	
				} else {
					$this->view->error = 'Customization cannot be updated. Kindly try again later';
				}
			}

			/*if(isset($this->invoiceNext) && !empty($this->invoiceNext)) {
				$invoiceNumber = explode("-", $this->invoiceNext);
				$this->view->invoicePrefix = $invoiceNumber[0];
				$this->view->runningNumber = ++$this->invoiceNext;
			} else {
				$this->view->runningNumber = '0000000001';
			}*/
			$this->view->path   		=  $this->uploadPath;
			$this->view->result      	=  $this->settings->getInvoiceCustomization();
		
		}	
   }

   public function notificationAction() {
    	if(!Zend_Session::namespaceIsset('sess_login')) {
	            $this->_redirect('index');
	      } else {
	      	$logSession = new Zend_Session_Namespace('sess_login');
			if(isset($logSession->proxy_cid) && !empty($logSession->proxy_cid)) {
				$cid = $logSession->proxy_cid;
			} else {
	 			$cid = $logSession->cid;
	 		}
	 		if(Zend_Session::namespaceIsset('update_notifiation_success')) {
				$this->view->success = 'Notification Settings Updated Successfully';
				Zend_Session::namespaceUnset('update_notifiation_success');
			}
	 		if($this->_request->isPost()) {
				$postArray  				= $this->getRequest()->getPost();
					$result					= $this->settings->updateNotification($postArray);
					if($result) {
						$sessSuccess = new Zend_Session_Namespace('update_notifiation_success');
						$sessSuccess->status = 1;
						$this->_redirect('settings/notification');
					} else {
						$this->view->error = 'Notification cannot be updated. Kindly try again later';
					}
			}
			$this->view->notification    =  $this->settings->getNotificationSettings();
	      }
	}

	public function themeAction() {
    	if(!Zend_Session::namespaceIsset('sess_login')) {
	            $this->_redirect('index');
	      } else {
	      	$logSession = new Zend_Session_Namespace('sess_login');
			if(isset($logSession->proxy_cid) && !empty($logSession->proxy_cid)) {
				$cid = $logSession->proxy_cid;
			} else {
	 			$cid = $logSession->cid;
	 		}
	 		if(Zend_Session::namespaceIsset('update_theme_success')) {
				$this->view->success = 'Theme Settings Updated Successfully';
				Zend_Session::namespaceUnset('update_theme_success');
			}
	 		if($this->_request->isPost()) {
				$postArray  				= $this->getRequest()->getPost();
					$result					= $this->settings->updateThemes($postArray);
					if($result) {
						$sessSuccess = new Zend_Session_Namespace('update_theme_success');
						$sessSuccess->status = 1;
						$this->_redirect('settings/notification');
					} else {
						$this->view->error = 'Theme cannot be updated. Kindly try again later';
					}
			}
			$this->view->filepath  =  $this->uploadPath.$cid."/";
			$this->view->company   =  $this->account->getCompany($cid);
			$this->view->themes    =  $this->settings->getAllThemes();
			//print_r($this->view->themes);
	      }
	}

	public function backupAction() {
    	if(!Zend_Session::namespaceIsset('sess_login')) {
	            $this->_redirect('index');
	      } else {
	      	$logSession = new Zend_Session_Namespace('sess_login');
			if(isset($logSession->proxy_cid) && !empty($logSession->proxy_cid)) {
				$cid = $logSession->proxy_cid;
			} else {
	 			$cid = $logSession->cid;
	 		}

	 	$this->view->filepath   	=  $this->uploadPath.$cid."/sql/";
	 	$this->view->backups 		=  scandir("../".$this->view->filepath);

	 	if(Zend_Session::namespaceIsset('sess_file_invalid_content')) {
				$this->view->error = 'File you have uploaded doesnot contain a valid data. Kindly upload a valid sql file';
				Zend_Session::namespaceUnset('sess_file_invalid_content');
			}

			if(Zend_Session::namespaceIsset('sess_file_valid_content')) {
				$this->view->success = 'Backup file uploaded successfully';
				Zend_Session::namespaceUnset('sess_file_valid_content');
			}

			if(Zend_Session::namespaceIsset('sess_file_delete')) {
				$this->view->success = 'Backup file Deleted successfully';
				Zend_Session::namespaceUnset('sess_file_delete');
			}

		if(Zend_Session::namespaceIsset('sess_file_valid_error')) {
				$this->view->error = 'File cannot be upload. Kindly upload a valid sql file or try again later';
				Zend_Session::namespaceUnset('sess_file_valid_error');
		}

	 	/*$sql_contents = file_get_contents("../".$this->uploadPath.$cid."/sql/db-backup-1405345153-cf44295c692e41aada857aa7377e9935.sql");
		$sql_contents = explode(";", $sql_contents);
		$i = 0;
		foreach ($sql_contents as $key => $value) {
			if (strpos($value, "CREATE TABLE")) {
				$i++;
			}
		}
		echo $i;
		echo '<pre>'; print_r($sql_contents); echo '</pre>';*/

		if($this->_request->isPost()) {
				$postArray  	  = $this->getRequest()->getPost();

				$adapter    =  new Zend_File_Transfer_Adapter_Http();
					$fileInfo 	=  $adapter->getFileInfo('file'); 
					if(isset($fileInfo['file']['name']) && ($fileInfo['file']['name'] != '')) {
						$adapter->addValidator('Count', false, array('min' =>1, 'max' => 2))
						        ->addValidator('Size',false,array('max'=>2024000),'file')
								->addValidator('Extension',false,'sql','file');
						$adapter->setDestination("..".$this->view->filepath,'file');
						$fileInfo 	         	  =   $adapter->getFileInfo('file');
						$fileArray		  		  =   explode('.',$fileInfo['file']['name']);
						$postArray['extension']   =   $fileArray['1'];
						$renameFile 		  	  =   trim('db-backup-'.time().".".$fileArray['1']);
						//echo '<pre>'; print_r($fileInfo); echo '</pre>'; die();
						$adapter->addFilter('Rename',"..".$this->view->filepath.$renameFile);
							if ($adapter->receive()) {
								$sql_contents = file_get_contents("../".$this->view->filepath.$renameFile);
								$sql_contents = explode(";", $sql_contents);
								$i = 0;
								foreach ($sql_contents as $key => $value) {
									if (strpos($value, "CREATE TABLE")) {
										$i++;
									}
								}
//								echo $id; die();
								if($i==33) {
									$sessSuccess = new Zend_Session_Namespace('sess_file_valid_content');
									$sessSuccess->status = 1;
								    $this->_redirect('settings/backup');
								} else {
									unlink("../".$this->view->filepath.$renameFile);
									$sessError = new Zend_Session_Namespace('sess_file_invalid_content');
									$sessError->status = 1;
								    $this->_redirect('settings/backup');
								}
							} else {
								$sessError = new Zend_Session_Namespace('sess_file_valid_error');
								$sessError->status = 1;
							    $this->_redirect('settings/backup');	
							}
					} 

				
			}

		$deleteBackup = base64_decode($this->_getParam('deleteBackup'));

		if((isset($deleteBackup) && $deleteBackup!='')) {

			if(file_exists("../".$this->view->filepath.$deleteBackup)) {
				unlink("../".$this->view->filepath.$deleteBackup);
				$sessSuccess = new Zend_Session_Namespace('sess_file_delete');
				$sessSuccess->status = 1;
				$this->_redirect('settings/backup');
			}

		}

		$remoteSession = new Zend_Session_Namespace('sess_remote_database');
			/* fill in your database name */
		$database_name = $remoteSession->dataBase;

		$restoreDb = base64_decode($this->_getParam('restoreDb'));

		if((isset($restoreDb) && $restoreDb!='')) {

			if(file_exists("../".$this->view->filepath."$restoreDb")) {	
			  
			/* connect to MySQL */
			if (!$link = mysql_connect($remoteSession->hostName, $remoteSession->userName, $remoteSession->password)) {
			  die("Could not connect: " . mysql_error());
			}
			  
			/* query all tables */
			$sql = "SHOW TABLES FROM $database_name";
			if($result = mysql_query($sql)){
			  /* add table name to array */
			  while($row = mysql_fetch_row($result)){
			    $found_tables[]=$row[0];
			  }
			}
			else{
			  die("Error, could not list tables. MySQL Error: " . mysql_error());
			}
			  $sql = mysql_query("SET FOREIGN_KEY_CHECKS = 0");
			/* loop through and drop each table */
			foreach($found_tables as $table_name){

			  $sql = "DROP TABLE $database_name.$table_name";
			  if($result = mysql_query($sql)){
			   // echo "Success - table $table_name deleted.";
			  }
			  else{
			   // echo "Error deleting $table_name. MySQL Error: " . mysql_error() . "";
			  }
			}


			$sql_contents = file_get_contents("../".$this->uploadPath.$cid."/sql/".$restoreDb);
			$sql_contents = explode(";", $sql_contents);
			 
			$this->dynamicDb = new Zend_Db_Adapter_Pdo_Mysql(array(
							    'host'     =>  $remoteSession->hostName,
							    'username' =>  $remoteSession->userName,
						        'password' =>  $remoteSession->password,
								'dbname'   =>  $remoteSession->dataBase
								)); 
			$authAdapter = new Zend_Auth_Adapter_DbTable($this->dynamicDb);
			$set =   $this->dynamicDb->query("SET FOREIGN_KEY_CHECKS = 0");
			
			foreach($sql_contents as $queries){
				if(trim($queries)!='') {
					$result = $this->dynamicDb->query($queries);
					if(!$result) {
						$status = 1;
					}
				}
			  }
			  $set =   $this->dynamicDb->query("SET FOREIGN_KEY_CHECKS = 1");

			  $sessSuccess = new Zend_Session_Namespace('restore_success');
			  $sessSuccess->status = 1;
			  $this->_redirect('settings/backup');
			}

		}


	 		if(Zend_Session::namespaceIsset('backup_success')) {
				$this->view->success = 'Database Backup Taken Successfully';
				Zend_Session::namespaceUnset('backup_success');
			}

			if(Zend_Session::namespaceIsset('restore_success')) {
				$this->view->success = 'Database Restored Successfully';
				Zend_Session::namespaceUnset('restore_success');
			}

			$backupdb = $this->_getParam('backupdb');
			if((isset($backupdb) && $backupdb!='' && $backupdb=='take')) {
				error_reporting(0);
		 		backup_tables($remoteSession->hostName, $remoteSession->userName, $remoteSession->password,$remoteSession->dataBase,'',"../".$this->view->filepath);
		 		$sessSuccess = new Zend_Session_Namespace('backup_success');
				$sessSuccess->status = 1;
				$this->_redirect('settings/backup');
		 	}


			$deleteDb = $this->_getParam('deleteDb');
			if((isset($deleteDb) && $deleteDb!='' && $deleteDb=='clear')) {
				$dropDatabase = $this->account->dropDatabase();
				if(isset($logSession->type) && $logSession->type==0) {
					if($dropDatabase) {
						unset($logSession->proxy_cid);
						unset($logSession->proxy_name);
						unset($logSession->proxy_id);
						unset($logSession->proxy_type);
						unset($logSession->proxy_currency);
						$sessSuccess = new Zend_Session_Namespace('success_proxy_unset_delete');
						$sessSuccess->status = 1;
						$this->_redirect('developer/proxy-settings');
					}
				} else {
					if($dropDatabase && Zend_Session::destroy()) {
						$this->_redirect('index');
					} else {
						$this->_redirect('index');
					}
				}
			} 
	 		/*if($this->_request->isPost()) {
				$postArray  				= $this->getRequest()->getPost();
					$result					= $this->settings->updateThemes($postArray);
					if($result) {
						$sessSuccess = new Zend_Session_Namespace('update_theme_success');
						$sessSuccess->status = 1;
						$this->_redirect('settings/notification');
					} else {
						$this->view->error = 'Theme cannot be updated. Kindly try again later';
					}
			}*/
			/*$this->filepath  =  $this->uploadPath.$cid."/sql/";*/
			$this->view->company   =  $this->account->getCompany($cid);
			/*$files1 = scandir("../".$this->filepath,1);*/
			//echo '<pre>'; print_r($files1); echo '</pre>';
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


	public function auditTrailAction() {
	      if(!Zend_Session::namespaceIsset('sess_login')) {
	            $this->_redirect('index');
	      } else {
	      	$logSession = new Zend_Session_Namespace('sess_login');
	      	if(isset($logSession->proxy_cid) && !empty($logSession->proxy_cid)) {
				$cid = $logSession->proxy_cid;
			} else {
 				$cid = $logSession->cid;
 			}
 			if(isset($logSession->proxy_id) && !empty($logSession->proxy_id)) {
				$id = $logSession->proxy_id;
			} else {
 				$id = $logSession->id;
 			}
 			if($this->_request->isPost()) {
				$postArray  				= $this->getRequest()->getPost();
				//echo '<pre>'; print_r($postArray); echo '</pre>';
				if(isset($postArray['system_log'])) {
					$this->view->audit   = $this->settings->getSystemAuditLog($postArray['filter_type']);
					$this->view->type 	 = 1;
				} else if(isset($postArray['transaction_log'])) {
					$this->view->audit   = $this->settings->getTransactionAuditLog($postArray['filter_type']);
					$this->view->type 	 = 2;
				}
				$this->view->filter = $postArray['filter_type'];
			} else {
 				$this->view->audit   = $this->settings->getAuditLog();
 			}
 			//echo '<pre>'; print_r($this->view->audit); echo '</pre>';
 			$this->view->users	 = $this->settings->getUserList($cid);
	      }
    }



	public function auditHistoryAction() {
	      if(!Zend_Session::namespaceIsset('sess_login')) {
	            $this->_redirect('index');
	      } else {
	      	$logSession = new Zend_Session_Namespace('sess_login');
	      	$this->view->type = $this->_getParam('type');
	      	$this->view->id   = $this->_getParam('id');
	      	if($this->view->type=='' || $this->view->id=='') {
	      		$this->_redirect('settings/audit-trial');
	      	}
	      	if(isset($logSession->proxy_cid) && !empty($logSession->proxy_cid)) {
				$cid = $logSession->proxy_cid;
			} else {
 				$cid = $logSession->cid;
 			}
 			if(isset($logSession->proxy_id) && !empty($logSession->proxy_id)) {
				$id = $logSession->proxy_id;
			} else {
 				$id = $logSession->id;
 			}
 			$this->view->audit   = $this->settings->getAuditLog();
 			$this->view->users	 = $this->settings->getUserList($cid);
	      }
    }


    public function auditIncomeAction() {
		if(!Zend_Session::namespaceIsset('sess_login')) {
			 $this->_redirect('index');
		} else {
			$logSession = new Zend_Session_Namespace('sess_login');
			if(isset($logSession->proxy_cid) && !empty($logSession->proxy_cid)) {
				$cid = $logSession->proxy_cid;
			} else {
				$cid = $logSession->cid;
			}
			$this->view->filepath    =  $this->uploadPath.$cid."/receipts/";
			
			
			$getAccountArray            =  $this->accountData->getData(array('currencies','creditTermArray','payMethod','supplyTaxCodes'));
			$this->view->currencies     =  $getAccountArray['currencies'];
			$this->view->creditTerm     =  $getAccountArray['creditTermArray'];
			$this->view->payMethod      =  $getAccountArray['payMethod'];
			$supply 					= array();
			//$this->view->supply         =  $getAccountArray['supplyTaxCodes'];
			$this->view->approveUser	=  $this->settings->getApproveUsers();
			$this->view->payAccount		=  $this->transaction->getPaymentAccount();
			$this->view->customer 		=  $this->transaction->getCustomerDetails();
			$this->view->incomeAccount	=  $this->transaction->getIncomeAccount();
			$this->iras 	    		=  $this->transaction->getIrasTax(2);
			foreach ($this->iras as $iras) {
				$supply[$iras['id']]['name']	    = $iras['name'];
				$supply[$iras['id']]['percentage']  = $iras['percentage'];
				$supply[$iras['id']]['description'] = $iras['description'];
			}
			$this->view->supply 		= $supply;
			$this->view->taxCode    	=  $this->transaction->getSalesTax(2);
			$id = base64_decode($this->_getParam('id'));
			$this->view->inc_id = $id;
			if(!isset($id) || $id=='') {
				$this->_redirect('settings/audit-trial');
			} else {
				$this->view->income  =  $this->transaction->getIncomeAuditTransaction($id);
				if(!$this->view->income) {
					$this->_redirect('settings/audit-trial');
				}  else {
					foreach ($this->view->income as $value) {
						$inc_id = $value['fkincome_id'];
					}
					$this->view->income_no = $this->transaction->getTransactionNo($inc_id,1);
					//$this->view->incomePayment =  $this->transaction->getPaymentDetails($id,1);
				}
			}
			
		}
	}



	public function auditExpenseAction() {
		if(!Zend_Session::namespaceIsset('sess_login')) {
			 $this->_redirect('index');
		} else {
			$logSession = new Zend_Session_Namespace('sess_login');
			if(isset($logSession->proxy_cid) && !empty($logSession->proxy_cid)) {
				$cid = $logSession->proxy_cid;
			} else {
				$cid = $logSession->cid;
			}
			$this->view->filepath    	=  $this->uploadPath.$cid."/receipts/";
			$getAccountArray            =  $this->accountData->getData(array('currencies','creditTermArray','payMethod','purchaseTaxCodes'));
			$this->view->currencies     =  $getAccountArray['currencies'];
			$this->view->creditTerm     =  $getAccountArray['creditTermArray'];
			$this->view->payMethod      =  $getAccountArray['payMethod'];
			$purchase 					= array();
			//$this->view->purchase       =  $getAccountArray['purchaseTaxCodes'];
			$this->view->approveUser	=  $this->settings->getApproveUsers();
			$this->view->payAccount		=  $this->transaction->getPaymentAccount();
			$this->view->vendor 		=  $this->transaction->getVendorDetails();
			$this->view->expenseAccount	=  $this->transaction->getExpenseAccount();
		//	$this->view->receipts 		=  $this->business->getReceipts('',2);
			$this->iras 	    		=  $this->transaction->getIrasTax(1);
			foreach ($this->iras as $iras) {
				$purchase[$iras['id']]['name']	    = $iras['name'];
				$purchase[$iras['id']]['percentage']  = $iras['percentage'];
				$purchase[$iras['id']]['description'] = $iras['description'];
			}
			$this->view->purchase 		= $purchase;
			$this->view->taxCode    	=  $this->transaction->getSalesTax(1);
			
			
			$id = base64_decode($this->_getParam('id'));
			$this->view->exp_id = $id;
			if(!isset($id) || $id=='') {
				$this->_redirect('settings/audit-trial');
			} else {
				$this->view->expense  =  $this->transaction->getExpenseAuditTransaction($id);
				if(!$this->view->expense) {
					$this->_redirect('settings/audit-trial');
				} else {
					$this->view->expenseList    =  $this->transaction->getExpenseAuditTransactionList($id);
					foreach ($this->view->expense as $value) {
						$exp_id = $value['fkexpense_id'];
					}
					$this->view->expense_no = $this->transaction->getTransactionNo($exp_id,2);
					//$this->view->expensePayment =  $this->transaction->getPaymentDetails($id,2);
					if(!$this->view->expense) {
					$this->_redirect('settings/audit-trial');
					} 
				}
				//echo '<pre>'; print_r($this->view->expensePayment); echo '</pre>';
			}
					
		}
	}



	public function auditInvoiceAction() {
		if(!Zend_Session::namespaceIsset('sess_login')) {
			 $this->_redirect('index');
		} else {
			$logSession = new Zend_Session_Namespace('sess_login');
			if(isset($logSession->proxy_cid) && !empty($logSession->proxy_cid)) {
				$cid = $logSession->proxy_cid;
			} else {
				$cid = $logSession->cid;
			}
			
			
			$id = base64_decode($this->_getParam('id'));
			$this->view->inv_id = $id;
			if(!isset($id) || $id=='') {
				$this->_redirect('settings/audit-trial');
			} else {
				$this->view->invoice  =  $this->transaction->getInvoiceAuditTransaction($id);
				if(!$this->view->invoice) {
					$this->_redirect('settings/audit-trial');
				} else {
					$this->view->invoiceProductList  =  $this->transaction->getInvoiceAuditProductList($id);
					foreach ($this->view->invoice as $value) {
						$inv_id = $value['fkinvoice_id'];
					}
					$this->view->invoice_no = $this->transaction->getTransactionNo($inv_id,3);
					//$this->view->invoicePayment      =  $this->transaction->getPaymentDetails($id,3);
					//$this->view->invoiceCredit  	 =  $this->transaction->getInvoiceCredit($id);
					$this->view->shipping 			 =  $this->transaction->getParticularShippingDetails($this->view->invoice[0]['fkshipping_address']);
					if(!$this->view->invoiceProductList) {
						$this->_redirect('settings/audit-trial');
					} 
				}
			}	
			
			$getAccountArray            =  $this->accountData->getData(array('currencies','creditTermArray','payMethod','supplyTaxCodes','country'));
			$this->view->country     	=  $getAccountArray['country'];
			$this->view->currencies     =  $getAccountArray['currencies'];
			$this->view->creditTerm     =  $getAccountArray['creditTermArray'];
			$this->view->payMethod      =  $getAccountArray['payMethod'];
			//$this->view->supply         =  $getAccountArray['supplyTaxCodes'];
			$supply 					= array();
			$this->view->filepath    	=  $this->uploadPath.$cid;
			$this->view->company		=  $this->account->getCompany($cid);
			$this->view->approveUser	=  $this->settings->getApproveUsers();
			$this->view->cashAccount	=  $this->transaction->getCashAccount();
			$this->view->payAccount		=  $this->transaction->getPaymentIncomeAccount();
			/*$this->view->customer 		=  $this->transaction->getCustomerDetails();*/
			$this->view->product 		=  $this->transaction->getProductDetails();
		//	$this->view->expenseAccount	=  $this->transaction->getExpenseAccount();
			$this->iras 	    		=  $this->transaction->getIrasTax(2);
			foreach ($this->iras as $iras) {
				$supply[$iras['id']]['name']	    = $iras['name'];
				$supply[$iras['id']]['percentage']  = $iras['percentage'];
				$supply[$iras['id']]['description'] = $iras['description'];
			}
			$this->view->supply 		= $supply;
			$this->view->taxCode    	=  $this->transaction->getSalesTax(2);
			$this->view->product 	    =  $this->settings->getProducts();
			$this->view->invoiceCustom	=  $this->settings->getInvoiceCustomization();
			$this->view->creditSet 		=  1;
			//print_r($this->view->shipping);
		}
	}



	public function auditCreditAction() {
		if(!Zend_Session::namespaceIsset('sess_login')) {
			 $this->_redirect('index');
		} else {
			$logSession = new Zend_Session_Namespace('sess_login');
			if(isset($logSession->proxy_cid) && !empty($logSession->proxy_cid)) {
				$cid = $logSession->proxy_cid;
			} else {
				$cid = $logSession->cid;
			}
			
			$id = base64_decode($this->_getParam('id'));
			if(!isset($id) || $id=='') {
				$this->_redirect('settings/audit-trial');
			} else {
				$this->view->credit  =  $this->transaction->getCreditAuditTransaction($id);
				if(!$this->view->credit) {
					$this->_redirect('settings/audit-trial');
				} else {
					$this->view->creditProductList  =  $this->transaction->getCreditAuditProductList($id);
					foreach ($this->view->credit as $value) {
						$cre_id = $value['fkcredit_id'];
					}
					$this->view->credit_no = $this->transaction->getTransactionNo($cre_id,4);
					//$this->view->shipping 			=  $this->transaction->getParticularShippingDetails($this->view->credit[0]['fkshipping_address']);
					if(!$this->view->creditProductList) {
						$this->_redirect('settings/audit-trial');
					} 
				}
			}	
			
			$getAccountArray            =  $this->accountData->getData(array('currencies','supplyTaxCodes','country'));
			$this->view->currencies     =  $getAccountArray['currencies'];
			$this->view->country     	=  $getAccountArray['country'];
			$supply 					= array();
			//$this->view->supply         =  $getAccountArray['supplyTaxCodes'];
			$this->view->filepath    	=  $this->uploadPath.$cid;
			$this->view->approveUser	=  $this->settings->getApproveUsers();
			$this->view->company		=  $this->account->getCompany($cid);
			$this->iras 	    		=  $this->transaction->getIrasTax(2);
			foreach ($this->iras as $iras) {
				$supply[$iras['id']]['name']	    = $iras['name'];
				$supply[$iras['id']]['percentage']  = $iras['percentage'];
				$supply[$iras['id']]['description'] = $iras['description'];
			}
			$this->view->supply 		= $supply;
			$this->view->taxCode    	=  $this->transaction->getSalesTax(2);
			$this->view->product 	    =  $this->settings->getProducts();
			$this->view->invoiceCustom	=  $this->settings->getInvoiceCustomization();
			$this->view->creditSet 		=  1;
		}
	}




	public function auditJournalAction() {
		if(!Zend_Session::namespaceIsset('sess_login')) {
			 $this->_redirect('index');
		} else {
			$logSession = new Zend_Session_Namespace('sess_login');
			if(isset($logSession->proxy_cid) && !empty($logSession->proxy_cid)) {
				$cid = $logSession->proxy_cid;
			} else {
				$cid = $logSession->cid;
			}
			$this->view->fileuploadpath    =  $this->uploadPath.$cid."/journal/";
			$id = base64_decode($this->_getParam('id'));
			if(!isset($id) || $id=='') {
				$this->_redirect('settings/audit-trial');
			} else {
				$this->view->journal  =  $this->transaction->getJournalAuditTransaction($id);
				if(!$this->view->journal) {
					$this->_redirect('settings/audit-trial');
				} else {
					$this->view->journalEntryList  =  $this->transaction->getJournalAuditEntryList($id);
					foreach ($this->view->journal as $value) {
						$jou_id = $value['fkjournal_id'];
					}
					$this->view->journal_no = $this->transaction->getTransactionNo($jou_id,5);
					if(!$this->view->journalEntryList) {
						$this->_redirect('settings/audit-trial');
					} 
				}
			}
			$this->view->approveUser	=  $this->settings->getApproveUsers();
			$this->view->payAccount		=  $this->transaction->getAllAccount();
		}
	}


	public function auditPaymentAction() {
		if(!Zend_Session::namespaceIsset('sess_login')) {
			 $this->_redirect('index');
		} else {
			$logSession = new Zend_Session_Namespace('sess_login');
			if(isset($logSession->proxy_cid) && !empty($logSession->proxy_cid)) {
				$cid = $logSession->proxy_cid;
			} else {
				$cid = $logSession->cid;
			}
			$id = base64_decode($this->_getParam('id'));
			if(!isset($id) || $id=='') {
				$this->_redirect('settings/audit-trial');
			} else {
				$this->view->payment  =  $this->transaction->getPaymentAudit($id);
				if(!$this->view->payment) {
					$this->_redirect('settings/audit-trial');
				} 
			}
			$getAccountArray            =  $this->accountData->getData(array('payMethod'));
			$this->view->payMethod      =  $getAccountArray['payMethod'];
			$this->view->approveUser	=  $this->settings->getApproveUsers();
			$this->view->cashAccount	=  $this->transaction->getCashAccount();
		}
	}









	public function ajaxRefreshAction() {
		$this->_helper->getHelper('layout')->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		$logSession = new Zend_Session_Namespace('sess_login');
		if(isset($logSession->proxy_cid) && !empty($logSession->proxy_cid)) {
			$cid = $logSession->proxy_cid;
		} else {
			$cid = $logSession->cid;
		}
		if($this->_request->isXmlHttpRequest()) {
			if ($this->_request->isPost()) {
				$ajaxVal = $this->getRequest()->getPost();
				if($ajaxVal['action']=='customerRefresh') {
					$this->customer 	=  $this->transaction->getCustomerDetails();
					if($this->customer) {
							echo '<select class="select2 form-control" name="customer" id="customer" onchange="return getReceipt(this.value);">';
							echo '<option value="">Select</option>';
						foreach ($this->customer as $customer) {
							if($ajaxVal['id']==$customer['id'])
                                $customerSelect = 'selected';
                            else
                                $customerSelect = '';
							echo '<option value='.$customer['id'].' '.$customerSelect.'>'.$customer['customer_name'].'</option>';
						}
						echo '</select>';
					}
				} else if($ajaxVal['action']=='payaccountRefresh') {
					$this->payAccount		=  $this->transaction->getPaymentAccount();
					if($this->payAccount) {
							echo '<select class="form-control" name="payment_account" id="payment_account" onchange="triggerPayment();">';
							echo '<option value="">Select</option>';
						foreach ($this->payAccount as $pay) {
							$pays = $pay['id']."_".$pay['account_id']."_".$pay['account_type'];
							if($ajaxVal['id']==$pays)
                                $paySelect = 'selected';
                            else
                                $paySelect = '';
							echo '<option value='.$pay['id']."_".$pay['account_id']."_".$pay['account_type'].' '.$paySelect.'>'.$pay['account_name'].'</option>';
						}
						echo '</select>';
					}
				} else if($ajaxVal['action']=='incomeRefresh') {
					$this->incomeAccount	=  $this->transaction->getIncomeAccount();
					if($this->incomeAccount) {
						echo '<select class="form-control" name="income_account" id="income_account">';
						foreach ($this->incomeAccount as $income) {
							if($ajaxVal['id']==$income['id'])
                                $incomeSelect = 'selected';
                            else
                                $incomeSelect = '';
							echo '<option value='.$income['id'].' '.$incomeSelect.'>'.$income['account_name'].'</option>';
						}
						echo '</select>';
					}
				}  else if($ajaxVal['action']=='changeTheme') {
					$this->updateTheme = $this->settings->updateTheme($ajaxVal['activeid'],$ajaxVal['id']);
					if($this->updateTheme) {
						echo "1";
					} else {
						echo "2";
					}
				}
			}
		}
	}

	public function ajaxDisplayAction() {
		$this->_helper->getHelper('layout')->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		$logSession = new Zend_Session_Namespace('sess_login');
		$action   = $this->_getParam('ajaxAction');
		$acc_type = $this->_getParam('acc_type');
		$accId  = base64_decode($this->_getParam('id'));
		if($action=='edit-account') {
			$getAccountArray        =  $this->accountData->getData(array('currencies'));
			$this->currencies 		=  $getAccountArray['currencies'];
			$this->accounts 		=  $this->settings->getAccounts($accId);
			if(isset($this->accounts) && !empty($this->accounts)) {
				echo '<div class="form-group">';
            	echo '<label class="col-lg-3 control-label">Account Name</label>';
              	echo '<div class="col-lg-7">';
                echo '<input type="hidden" name="action" id="action" value="edit">';
                echo '<input type="hidden" name="account_type" id="account_type" value="'.$acc_type.'" />';
                echo '<input type="hidden" name="edit_acc_id" id="edit_acc_id" value="'.$accId.'" />';
                echo '<input type="hidden" name="level1" id="level1" value="'.$this->accounts[0]['level1'].'" />';
                echo '<input type="hidden" name="level2" id="level2" value="'.$this->accounts[0]['level2'].'" />';
                echo '<input type="text" name="edit_acc_name" id="edit_acc_name" class="form-control" value="'.$this->accounts[0]['account_name'].'" />';
                echo '</div>';
        	    echo '</div>';
        	    //if($acc_type==3 || $acc_type==4) {
        	    	echo '<div class="form-group">';
	            	echo '<label class="col-lg-3 control-label">Currency</label>';
	                echo '<div class="col-lg-5">';
	                echo '<select name="edit_currency" class="form-control" >';
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
        	    /*} else {
        		echo '<div class="form-group">';
            	echo '<label class="col-lg-3 control-label">Payment / Accruals Account</label>';
                echo '<div class="col-lg-7">';
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
            	echo '<label class="col-lg-3 control-label">Currency</label>';
                echo '<div class="col-lg-5">';
                echo '<select name="edit_currency" class="form-control" >';
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
                	}*/
					echo '<div class="form-group">';
    				echo '<label class="col-lg-2 control-label">&nbsp;</label>';
    				echo '<div class="col-lg-3">';
       				echo '<div class="form-actions">';
          			echo '<button type="submit" id="save" class="btn btn-primary">Save</button>';
          			echo ' <button type="reset" class="btn b-close">Close</button>';
      				echo '</div>';
   					echo '</div>';
  					echo '</div>';
			}
		}
	}


	public function ajaxCheckAction() {
		$this->_helper->getHelper('layout')->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		$logSession = new Zend_Session_Namespace('sess_login');
		if(isset($logSession->proxy_cid) && !empty($logSession->proxy_cid)) {
			$cid = $logSession->proxy_cid;
		} else {
			$cid = $logSession->cid;
		}
		if($this->_request->isXmlHttpRequest()) {
			if ($this->_request->isPost()) {
				$ajaxVal = $this->getRequest()->getPost();
				if($ajaxVal['action']=='check_product_name') {
					$checkProduct = $this->settings->checkProductName($ajaxVal['product_name']);
					if($checkProduct) {
						echo "2";
					} else {
						echo "1";
					}
				} else if($ajaxVal['action']=='check_product_id') {
					$checkProduct = $this->settings->checkProductId($ajaxVal['product_id']);
					if($checkProduct) {
						echo "2";
					} else {
						echo "1";
					}
				} else if($ajaxVal['action']=='check_product_name_update') {
					$checkProduct = $this->settings->checkProductName($ajaxVal['product_name'],$ajaxVal['pid']);
					if($checkProduct) {
						echo "2";
					} else {
						echo "1";
					}
				} else if($ajaxVal['action']=='check_product_id_update') {
					$checkProduct = $this->settings->checkProductId($ajaxVal['product_id'],$ajaxVal['pid']);
					if($checkProduct) {
						echo "2";
					} else {
						echo "1";
					}
				} 
			}
		}
	}


	public function ajaxUploadAction() {

		$this->_helper->getHelper('layout')->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);

		$logSession = new Zend_Session_Namespace('sess_login');
		if(isset($logSession->proxy_cid) && !empty($logSession->proxy_cid)) {
			$cid = $logSession->proxy_cid;
		} else {
			$cid = $logSession->cid;
		}
		$this->view->filepath    =  "..".$this->uploadPath.$cid;
		$action = $this->_getParam('operation');

		if($action=='upload') {

				$uploader = new FileUpload('uploadfile');   
				$uploader->allowedExtensions = array('jpg', 'jpeg', 'png', 'gif');
				$uploader->sizeLimit = 10485760;
				$extension = $uploader->getExtension();
				$newfilename  = $cid."_themelogo.".$extension;
				$uploader->newFileName = $newfilename;
				$result = $uploader->handleUpload($this->view->filepath);

				if (!$result) {

				  echo json_encode(array(

				          'status' => "failure",

				          'file' => $uploader->getErrorMsg()

				       ));    

				} else {

					$updateCompanyLogo = $this->account->updateLogo($uploader->getFileName());
				    echo json_encode(array ( 'data' => array(

				            'status' => "success",

				            'file' => $uploader->getFileName()

				         )));

				}
		} 
	}

	public function ajaxRemoveAction() {

		$this->_helper->getHelper('layout')->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		$logSession = new Zend_Session_Namespace('sess_login');
		if(isset($logSession->proxy_cid) && !empty($logSession->proxy_cid)) {
			$cid = $logSession->proxy_cid;
		} else {
			$cid = $logSession->cid;
		}
		$this->view->filepath    =  "..".$this->uploadPath.$cid."/";
		if($this->_request->isXmlHttpRequest()) {
			if ($this->_request->isPost()) {
				$ajaxVal = $this->getRequest()->getPost();
				if($ajaxVal['action']=='fileRemove') {
					$updateCompanyLogo = $this->account->updateLogo();
					$unlinkFile = unlink($this->view->filepath.$ajaxVal['id']);
					if($unlinkFile) {
						echo "success";
					} else {
						echo "failure";
					}
				}
			}
		}

	}


}

?>