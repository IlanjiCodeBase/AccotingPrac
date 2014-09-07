<?php 
class Business_CustomerController extends Zend_Controller_Action {
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
		$this->receiptPath = Zend_Registry::get('receiptuploadpath');
		$this->account     = new Account();
		$this->business    = new Business();
		$this->approval    = new Approval();
		$this->settings    = new Settings();
		$this->accountData = new Account_Data();
		if(Zend_Session::namespaceIsset('sess_login')) {
			$logSession = new Zend_Session_Namespace('sess_login');	
			if($logSession->type==0 && !isset($logSession->proxy_type)) {
				$this->_redirect('developer');
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
			if(Zend_Session::namespaceIsset('delete_success_customer')) {
				$this->view->success = 'Customer deleted successfully';
				Zend_Session::namespaceUnset('delete_success_customer');
			}
			if(Zend_Session::namespaceIsset('delete_error_customer')) {
				$this->view->error = 'Customer is already associated with income or invoice or receipts so unable to delete';
				Zend_Session::namespaceUnset('delete_error_customer');
			}
			if(Zend_Session::namespaceIsset('insert_success_customer')) {
				$this->view->success = 'Customer Created Successfully';
				Zend_Session::namespaceUnset('insert_success_customer');
			}
			$delid   = base64_decode($this->_getParam('delid'));
			$delname = $this->_getParam('delname');
			if(isset($delid) && !empty($delid)) {
				$deleteStatus = $this->business->deleteCustomer($delid);
				$auditLog  = $this->settings->insertAuditLog(3,6,$delname,$delid);
				if($deleteStatus && $deleteStatus==1) {
					$sessSuccess = new Zend_Session_Namespace('delete_success_customer');
					$sessSuccess->status = 1;
					$this->_redirect('business/customer');
				} elseif ($deleteStatus && $deleteStatus==3) {
					$sessError = new Zend_Session_Namespace('delete_error_customer');
					$sessError->status = 1;
					$this->_redirect('business/customer');
				}
			}
			$this->view->result 	=  $this->business->getCustomers();
			//echo '<pre>'; print_r($this->view->result); echo '</pre>';
		}
	}

	public function addAction() {
		if(!Zend_Session::namespaceIsset('sess_login')) {
			 $this->_redirect('index');
		} else {
			$logSession = new Zend_Session_Namespace('sess_login');
			if($logSession->type==5 || $logSession->proxy_type==5) {
				$this->_redirect('business/customer');
			}
			$logSession = new Zend_Session_Namespace('sess_login');
			$getAccountArray         =  $this->accountData->getData(array('country','currencies'));
			$this->view->countries   =  $getAccountArray['country'];
			$this->view->currencies  =  $getAccountArray['currencies'];
			$this->view->customer_id = $this->business->getCustomerID();
			$this->view->otherReceivable = $this->business->getOtherReceivables();
			if(isset($logSession->proxy_cid) && !empty($logSession->proxy_cid)) {
				$cid = $logSession->proxy_cid;
			} else {
				$cid = $logSession->cid;
			}
			if($this->_request->isPost()) {
				$postArray  =   $this->getRequest()->getPost();
				//$postArray['other_coa'] = implode(",", $postArray['other_coa_link']);
				//echo '<pre>'; print_r($postArray); echo '</pre>'; die();
				$this->customer = $this->business->insertCustomer($postArray,$cid);
				$auditLog  = $this->settings->insertAuditLog(1,6,$postArray['customer_name'],$this->customer);
				if(isset($this->customer) && !empty($this->customer)) {
					$sessSuccess = new Zend_Session_Namespace('insert_success_customer');
				    $sessSuccess->status = 1;
					$this->_redirect('business/customer/');	
				} else {
					$this->view->error = 'Customer cannot be created. Kindly try again later';
				}
			}
		}
	}


	public function editAction() {
		if(!Zend_Session::namespaceIsset('sess_login')) {
			 $this->_redirect('index');
		} else {
			$logSession = new Zend_Session_Namespace('sess_login');
			if($logSession->type==5 || $logSession->proxy_type==5) {
				$this->_redirect('business/customer');
			}
			if(Zend_Session::namespaceIsset('update_success_customer')) {
				$this->view->success = 'Customer Updated Successfully';
				Zend_Session::namespaceUnset('update_success_customer');
			}
			$logSession = new Zend_Session_Namespace('sess_login');
			$getAccountArray         =  $this->accountData->getData(array('country','currencies'));
			$this->view->countries   =  $getAccountArray['country'];
			$this->view->currencies  =  $getAccountArray['currencies'];
			$this->view->otherReceivable = $this->business->getOtherReceivables();
			$id = base64_decode($this->_getParam('id'));
			if(!isset($id) || $id=='') {
				$this->_redirect('business/customer/');
			} else {
				$this->view->customer  =  $this->business->getCustomers($id);
				//echo '<pre>'; print_r($this->view->customer); echo '</pre>';
				if(!$this->view->customer) {
					$this->_redirect('business/customer/');
				} else {
					$this->view->shipping  =  $this->business->getShippingAddress($id);
					$this->view->contacts  =  $this->business->getKeyContacts($id,1);
					$this->view->income    =  $this->business->getIncomeCount($id);
					$this->view->invoice   =  $this->business->getInvoiceCount($id);
					//echo '<pre>'; print_r($this->view->income); echo '</pre>';
					//echo '<pre>'; print_r($this->view->invoice); echo '</pre>';
				}
			}
			if($this->_request->isPost()) {
				$postArray  =   $this->getRequest()->getPost();
				//$postArray['other_coa'] = implode(",", $postArray['other_coa_link']);
				$this->customer = $this->business->updateCustomer($postArray,$id);
				$auditLog  = $this->settings->insertAuditLog(2,6,$postArray['customer_name'],$id);

				if(isset($this->customer) && !empty($this->customer)) {
					$sessSuccess = new Zend_Session_Namespace('update_success_customer');
				    $sessSuccess->status = 1;
					$this->_redirect('business/customer/edit/id/'.$this->_getParam('id'));	
				} else {
					$this->view->error = 'Customer cannot be updated. Kindly try again later';
				}
			}
		}
	}

	public function copyAction() {
		if(!Zend_Session::namespaceIsset('sess_login')) {
			 $this->_redirect('index');
		} else {
			$logSession = new Zend_Session_Namespace('sess_login');
			if($logSession->type==5 ||  $logSession->proxy_type==5) {
				$this->_redirect('business/customer');
			}
			$logSession = new Zend_Session_Namespace('sess_login');
			if(isset($logSession->proxy_cid) && !empty($logSession->proxy_cid)) {
				$cid = $logSession->proxy_cid;
			} else {
				$cid = $logSession->cid;
			}
			$getAccountArray         =  $this->accountData->getData(array('country','currencies'));
			$this->view->countries   =  $getAccountArray['country'];
			$this->view->currencies  =  $getAccountArray['currencies'];
			$this->view->otherReceivable = $this->business->getOtherReceivables();
			$id = base64_decode($this->_getParam('id'));
			if(!isset($id) || $id=='') {
				$this->_redirect('business/customer/');
			} else {
				$this->view->customer  =  $this->business->getCustomers($id);
				//echo '<pre>'; print_r($this->view->customer); echo '</pre>';
				if(!$this->view->customer) {
					$this->_redirect('business/customer/');
				} else {
					$this->view->shipping  =  $this->business->getShippingAddress($id);
					$this->view->contacts  =  $this->business->getKeyContacts($id,1);
					//echo '<pre>'; print_r($this->view->shipping); echo '</pre>';
					//echo '<pre>'; print_r($this->view->contacts); echo '</pre>';
				}
			}
			if($this->_request->isPost()) {
				$postArray  =   $this->getRequest()->getPost();
				//$postArray['other_coa'] = implode(",", $postArray['other_coa_link']);
				$this->customer = $this->business->insertCustomer($postArray,$cid);
				$auditLog  = $this->settings->insertAuditLog(1,6,$postArray['customer_name'],$this->customer);
				if(isset($this->customer) && !empty($this->customer)) {
					$sessSuccess = new Zend_Session_Namespace('insert_success_customer');
				    $sessSuccess->status = 1;
					$this->_redirect('business/customer/');	
				} else {
					$this->view->error = 'Customer cannot be added. Kindly try again later';
				}
			}
		}
	}


	public function viewAction() {
		if(!Zend_Session::namespaceIsset('sess_login')) {
			 $this->_redirect('index');
		} else {
			$logSession = new Zend_Session_Namespace('sess_login');
			$getAccountArray         =  $this->accountData->getData(array('country'));
			$this->view->countries   =  $getAccountArray['country'];
			$this->view->otherReceivable = $this->business->getOtherReceivables();
			$id = base64_decode($this->_getParam('id'));
			if(!isset($id) || $id=='') {
				$this->_redirect('business/customer/');
			} else {
				$this->view->customer  =  $this->business->getCustomers($id);
				//echo '<pre>'; print_r($this->view->customer); echo '</pre>';
				if(!$this->view->customer) {
					$this->_redirect('business/customer/');
				} else {
					$this->view->shipping  =  $this->business->getShippingAddress($id);
					$this->view->contacts  =  $this->business->getKeyContacts($id,1);
					//echo '<pre>'; print_r($this->view->shipping); echo '</pre>';
					//echo '<pre>'; print_r($this->view->contacts); echo '</pre>';
				}
			}
			
		}
	}

	public function printAction() {
		if(!Zend_Session::namespaceIsset('sess_login')) {
			 $this->_redirect('index');
		} else {
			$logSession = new Zend_Session_Namespace('sess_login');
			$getAccountArray         =  $this->accountData->getData(array('country'));
			$this->view->countries   =  $getAccountArray['country'];
			$this->view->otherReceivable = $this->business->getOtherReceivables();
			$id = base64_decode($this->_getParam('id'));
			if(!isset($id) || $id=='') {
				$this->_redirect('business/customer/');
			} else {
				$this->view->customer  =  $this->business->getCustomers($id);
				//echo '<pre>'; print_r($this->view->customer); echo '</pre>';
				if(!$this->view->customer) {
					$this->_redirect('business/customer/');
				} else {
					$this->view->shipping  =  $this->business->getShippingAddress($id);
					$this->view->contacts  =  $this->business->getKeyContacts($id,1);
					//echo '<pre>'; print_r($this->view->shipping); echo '</pre>';
					//echo '<pre>'; print_r($this->view->contacts); echo '</pre>';
				}
			}
			
		}
	}


	public function receiptsAction() {
		if(!Zend_Session::namespaceIsset('sess_login')) {
			 $this->_redirect('index');
		} else {
			$logSession = new Zend_Session_Namespace('sess_login');
			$this->fileuploadpath    =  $this->receiptPath.$logSession->cid."/";
			$this->view->receiptsPath=  $this->fileuploadpath;
			if(Zend_Session::namespaceIsset('delete_success_receipt_customer')) {
				$this->view->success = 'Receipts deleted successfully';
				Zend_Session::namespaceUnset('delete_success_receipt_customer');
			}
			if(Zend_Session::namespaceIsset('delete_error_receipt_customer')) {
				$this->view->error = 'Receipts already associated in income so unable to delete';
				Zend_Session::namespaceUnset('delete_error_receipt_customer');
			}
			
			$getAccountArray         =  $this->accountData->getData(array('country'));
			$this->view->countries   =  $getAccountArray['country'];
			$id = base64_decode($this->_getParam('id'));
			$this->view->rid = $id;
			if(!isset($id) || $id=='') {
				$this->_redirect('business/customer/');
			} else {
				$this->view->customer  =  $this->business->getCustomerDetails($id);
				//echo '<pre>'; print_r($this->view->customer); echo '</pre>';
				if(!$this->view->customer) {
					$this->_redirect('business/customer/');
				} else {
					$this->view->result  =  $this->business->getReceipts($id,1);
					//echo '<pre>'; print_r($this->view->result); echo '</pre>';
				}
			}

			$delid   = base64_decode($this->_getParam('delid'));
			$receipt = base64_decode($this->_getParam('receipt'));
			if(isset($delid) && !empty($delid) && isset($receipt) && !empty($receipt)) {
				$checkReceipt = $this->business->checkReceipt($delid,1);
				if($checkReceipt==0) {
					if(unlink($this->fileuploadpath.$receipt)) {
						$deleteStatus = $this->business->deleteReceipt($delid);
						if($deleteStatus) {
							$sessSuccess = new Zend_Session_Namespace('delete_success_receipt_customer');
							$sessSuccess->status = 1;
						}
							$this->_redirect('business/customer/receipts/id/'.$this->_getParam('id'));
					} else {
						$this->view->error = 'Receipt cannot be deleted. Kindly try again later';
					}
				} else {
					$sessSuccess = new Zend_Session_Namespace('delete_error_receipt_customer');
					$sessSuccess->status = 1;
					$this->_redirect('business/customer/receipts/id/'.$this->_getParam('id'));
				}
			}

		}
	}


	public function receiptAddAction() {
		if(!Zend_Session::namespaceIsset('sess_login')) {
			 $this->_redirect('index');
		} else {
			$logSession = new Zend_Session_Namespace('sess_login');
			if($logSession->type==5) {
				$this->_redirect('business/customer');
			}
			if(Zend_Session::namespaceIsset('insert_success_customer_receipt')) {
				$this->view->success = 'Receipt Uploaded Successfully';
				Zend_Session::namespaceUnset('insert_success_customer_receipt');
			}
			$logSession = new Zend_Session_Namespace('sess_login');
			$this->fileuploadpath    =  $this->receiptPath.$logSession->cid."/";
			//echo $this->fileuploadpath;
			$getAccountArray         =  $this->accountData->getData(array('country'));
			$this->view->countries   =  $getAccountArray['country'];
			$id = base64_decode($this->_getParam('id'));
			if(!isset($id) || $id=='') {
				$this->_redirect('business/customer/');
			} else {
				$this->view->customer  =  $this->business->getCustomerDetails($id);
				//echo '<pre>'; print_r($this->view->customer); echo '</pre>';
				if(!$this->view->customer) {
					$this->_redirect('business/customer/');
				} else {
					$this->view->result  =  $this->business->getReceipts($id,1);
					//echo '<pre>'; print_r($this->view->result); echo '</pre>';
				}
			}
			if($this->_request->isPost()) {
				$postArray  =   $this->getRequest()->getPost();
				//echo '<pre>'; print_r($_FILES); echo '</pre>'; die();
  //echo $this->fileuploadpath; die();
				$adapter    =  new Zend_File_Transfer_Adapter_Http();
				$adapter->addValidator('Count', false, array('min' =>1, 'max' => 2))
				        ->addValidator('Size',false,array('max'=>2024000),'file')
						->addValidator('Extension',false,'pdf,jpg','file');
				$adapter->setDestination("..".$this->fileuploadpath,'file');
				$fileInfo 	         	  =   $adapter->getFileInfo('file');
				$fileArray		  		  =   explode('.',$fileInfo['file']['name']);
				$postArray['extension']   =   $fileArray['1'];
				$renameFile 		  	  =   trim($id."_".rand(10,10000)."_".$id.".".$fileArray['1']);
				$postArray['attach_file'] =   $renameFile;
				$adapter->addFilter('Rename',"..".$this->fileuploadpath.$renameFile);
               
				if ($adapter->isValid('file') && isset($postArray['extension']) && !empty($postArray['extension']) && isset($postArray['attach_file']) && !empty($postArray['attach_file'])) {
					$adapter->receive('file');

					$this->customer = $this->business->insertReceipt($postArray,$id,1);

					if(isset($this->customer) && !empty($this->customer)) {
						$sessSuccess = new Zend_Session_Namespace('insert_success_customer_receipt');
					    $sessSuccess->status = 1;
						$this->_redirect('business/customer/receipt-add/id/'.$this->_getParam('id'));	
					} else {
						$this->view->error = 'Receipt cannot be uploaded. Kindly try again later';
					}
				}
			}
		}
	}

	public function ajaxCallAction() {
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
				if($ajaxVal['action']=='check_customer') {
					$checkCustomer = $this->business->checkCustomer($ajaxVal['customer_name']);
					if($checkCustomer) {
						echo "2";
					} else {
						echo "1";
					}
				} else if($ajaxVal['action']=='check_customer_update') {
					$checkCustomer = $this->business->checkCustomer($ajaxVal['customer_name'],$ajaxVal['customer_id']);
					if($checkCustomer) {
						echo "2";
					} else {
						echo "1";
					}
				}  else if($ajaxVal['action']=='add_coa') {
					$postArray['account_type'] 	 = $ajaxVal['oth_acc_type'];
					$postArray['level1']  	     = $ajaxVal['oth_acc_l1'];
					$postArray['level2']  	     = $ajaxVal['oth_acc_l2'];
					$postArray['account_name']   = $ajaxVal['oth_acc_name'];
					$postArray['currency']   	 = $ajaxVal['currency'];
					$checkAccount	= $this->settings->checkAccountName($postArray);
					if(!$checkAccount) {
						$addCoa = $this->settings->insertAccount($postArray);
						if($addCoa) {
							echo $addCoa;
						} else {
							echo "false";
						}
					} else {
						echo "false1";
					}
				}
			}
		}
	}


	
}

?>