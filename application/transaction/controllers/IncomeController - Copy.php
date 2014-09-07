<?php 
class Transaction_IncomeController extends Zend_Controller_Action {
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
		$this->cacheUrl    = Zend_Registry::get('cacheurl');
		$this->business    = new Business();
		$this->settings    = new Settings();
		$this->transaction = new Transaction();
		$this->accountData = new Account_Data();
		if(Zend_Session::namespaceIsset('sess_login')) {
			$logSession = new Zend_Session_Namespace('sess_login');	
			if($logSession->type==0 && !isset($logSession->companySet)) {
				$this->_redirect('developer');
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
			//$test = array('1' => "ddf", '2' =>"afddf" );

			$logSession = new Zend_Session_Namespace('sess_login');
			$cid = $logSession->cid;

			$this->view->filepath    =  $this->uploadPath.$logSession->cid."/receipts/";
			$this->view->nextId 	 =  $this->transaction->getNextIncomeTransaction();
			if($this->_request->isPost()) {
				$postArray  				= $this->getRequest()->getPost();
				if(isset($postArray['add_payment']) && !empty($postArray['add_payment'])) {
					$postArray['discount'] = 0;
					$postArray['ref_id']   = $postArray['income_id'];
					$postArray['date'] 	   = date("Y-m-d",strtotime(trim($postArray['date'])));
					if(isset($postArray['payment_discount']) && $postArray['payment_discount']==1 && isset($postArray['discount_payment_amount'])) {
						$postArray['discount'] = $postArray['discount_payment_amount'];
					}
					$addPayment = $this->transaction->addPayment($postArray,1);
					if($addPayment) {
						$sessSuccess = new Zend_Session_Namespace('add_payment_success');
						$sessSuccess->status = 1;
					} else {
						$sessSuccess = new Zend_Session_Namespace('add_payment_success');
						$sessSuccess->status = 2;
					}
					$this->_redirect('transaction/income/');
				} else {

					$adapter    =  new Zend_File_Transfer_Adapter_Http();
					$fileInfo 	=  $adapter->getFileInfo('file'); 
					if(isset($fileInfo['file']['name']) && ($fileInfo['file']['name'] != '')) {
						$adapter->addValidator('Count', false, array('min' =>1, 'max' => 2))
						        ->addValidator('Size',false,array('max'=>2024000),'file')
								->addValidator('Extension',false,'pdf,jpg,doc,docx,png','file');
						$adapter->setDestination("..".$this->view->filepath,'file');
						$fileInfo 	         	  =   $adapter->getFileInfo('file');
						$fileArray		  		  =   explode('.',$fileInfo['file']['name']);
						$postArray['extension']   =   $fileArray['1'];
						$renameFile 		  	  =   trim($this->view->nextId."_".rand(10,10000)."_".$this->view->nextId.".".$fileArray['1']);
						$postArray['receipt_id']  =   $renameFile;
						$adapter->addFilter('Rename',"..".$this->view->filepath.$renameFile);
							if ($adapter->isValid('file') && $adapter->receive('file')) {
								$postArray['receipt_id'] =   $renameFile;
							} else {
								$postArray['receipt_id'] =   '';
							}
					} else {
						$postArray['receipt_id'] =   '';
					}

					$postArray['tax_id'] = ' ';
					$postArray['tax_percentage'] = ' ';
					$postArray['date'] = date("Y-m-d",strtotime(trim($postArray['date'])));
					$taxes = explode("_",$postArray['tax_code']);
					$postArray['tax_id'] = $taxes[0];
					if(isset($taxes[1]) && !empty($taxes[1])) {
						$postArray['tax_percentage'] = $taxes[1];
					}
					$postArray['amount'] = str_replace(",","",$postArray['amount']);
					$payment_account = explode("_", $postArray['payment_account']);
					$postArray['pay_account'] = $payment_account[0];
					//echo '<pre>'; print_r($postArray); echo '</pre>'; die();
					if(isset($postArray['approve_income']) && !empty($postArray['approve_income'])) {
					 	$postArray['approval_for'] = $logSession->id;
						$incomeTransaction = $this->transaction->insertIncomeTransaction($postArray,$cid,1);
					}  else if(isset($postArray['unapprove_save']) && !empty($postArray['unapprove_save'])) {
						$incomeTransaction = $this->transaction->insertIncomeTransaction($postArray,$cid,2);
					}
					if($incomeTransaction) {
						$sessSuccess = new Zend_Session_Namespace('insert_success_income');
						$sessSuccess->status = 1;
						$this->_redirect('transaction/income/');
					} else {
							$this->view->error = 'Income Transaction cannot be added. Kindly try again later';
					}
				}
				//echo '<pre>'; print_r($postArray); echo '</pre>'; die();
			}
			if(Zend_Session::namespaceIsset('insert_success_income')) {
				$this->view->success = 'Income Transaction Added successfully';
				Zend_Session::namespaceUnset('insert_success_income');
			}
			if(Zend_Session::namespaceIsset('delete_success_income_transaction')) {
				$this->view->success = 'Transaction deleted successfully';
				Zend_Session::namespaceUnset('delete_success_income_transaction');
			}
			if(Zend_Session::namespaceIsset('add_payment_success')) {
				$sessCheck = new Zend_Session_Namespace('add_payment_success');
				if($sessCheck->status==1) {
					$this->view->success = 'Payment successfully added';
					Zend_Session::namespaceUnset('add_payment_success');
				} else if($sessCheck->status==2) {
					$this->view->error = 'Payment cannot be added. Kindly try again later';
					Zend_Session::namespaceUnset('add_payment_success');
				}
			}
			if(Zend_Session::namespaceIsset('verify_success_income_transaction')) {
				$this->view->success = 'Transaction verified successfully';
				Zend_Session::namespaceUnset('verify_success_income_transaction');
			}
			if(Zend_Session::namespaceIsset('unverify_success_income_transaction')) {
				$this->view->success = 'Transaction unverified successfully';
				Zend_Session::namespaceUnset('unverify_success_income_transaction');
			}
			if(Zend_Session::namespaceIsset('sess_draft_income_insert')) {
				$this->view->success = 'Income Transaction saved as draft';
				Zend_Session::namespaceUnset('sess_draft_income_insert');
			}
			$delid = base64_decode($this->_getParam('delid'));
			if(isset($delid) && !empty($delid)) {
				$deleteStatus = $this->transaction->deleteIncomeTransaction($delid,1);
				if($deleteStatus) {
					$sessSuccess = new Zend_Session_Namespace('delete_success_income_transaction');
					$sessSuccess->status = 1;
				}
					$this->_redirect('transaction/income');
			}
			$verifyid  = base64_decode($this->_getParam('verifyid'));
			$status    = $this->_getParam('status');
			if(isset($verifyid) && !empty($verifyid) && isset($status) && !empty($status)) {
				$changeStatus = $this->transaction->changeIncomeTransactionStatus($verifyid,$status);
				if($changeStatus) {
					if($status==1) {
						$sessSuccess = new Zend_Session_Namespace('verify_success_income_transaction');
						$sessSuccess->status = 1;
					} else if($status==2) {
						$sessSuccess = new Zend_Session_Namespace('unverify_success_income_transaction');
						$sessSuccess->status = 2;
					}
				}
					$this->_redirect('transaction/income');
			}
			$getAccountArray            =  $this->accountData->getData(array('currencies','creditTermArray','payMethod'));
			$this->view->currencies     =  $getAccountArray['currencies'];
			$this->view->creditTerm     =  $getAccountArray['creditTermArray'];
			$this->view->payMethod      =  $getAccountArray['payMethod'];
			$this->view->payAccount		=  $this->transaction->getPaymentAccount();
			$this->view->approveUser	=  $this->settings->getApproveUsers($cid);
			$this->view->customer 		=  $this->transaction->getCustomerDetails();
			$this->view->receipts 		=  $this->business->getReceipts('',1);
			$this->view->incomeAccount	=  $this->transaction->getIncomeAccount();
			$this->view->taxCode    	=  $this->transaction->getTax();
			$this->view->creditSet 		=  3;
			$this->view->result 		=  $this->transaction->getIncomeTransaction();
			$this->view->payments 		=  $this->transaction->getPaymentDetails('',1);
			//echo '<pre>'; print_r($this->view->approveUser); echo '</pre>'; die();
		}
	}

	public function viewAction() {
		if(!Zend_Session::namespaceIsset('sess_login')) {
			 $this->_redirect('index');
		} else {
			$logSession = new Zend_Session_Namespace('sess_login');
			$cid = $logSession->cid;
			$this->view->filepath    =  $this->uploadPath.$logSession->cid."/receipts/";
			if($this->_request->isPost()) {
				$postArray  				= $this->getRequest()->getPost();
				$postArray['discount'] = 0;
				$postArray['date'] 	   = date("Y-m-d",strtotime(trim($postArray['date'])));
				if(isset($postArray['payment_discount']) && $postArray['payment_discount']==1 && isset($postArray['discount_amount'])) {
					$postArray['discount'] = $postArray['discount_amount'];
				}
				$updatePayment = $this->transaction->updatePayment($postArray,1);
				if($updatePayment) {
					$sessSuccess = new Zend_Session_Namespace('update_payment_success');
					$sessSuccess->status = 1;
				} else {
					$sessSuccess = new Zend_Session_Namespace('update_payment_success');
					$sessSuccess->status = 2;
				}
			}
			if(Zend_Session::namespaceIsset('update_payment_success')) {
				$sessCheck = new Zend_Session_Namespace('update_payment_success');
				if($sessCheck->status==1) {
					$this->view->success = 'Payment successfully updated';
					Zend_Session::namespaceUnset('update_payment_success');
				} else if($sessCheck->status==2) {
					$this->view->error = 'Payment cannot be updated. Kindly try again later';
					Zend_Session::namespaceUnset('update_payment_success');
				}
			}
			$getAccountArray            =  $this->accountData->getData(array('currencies','creditTermArray','payMethod'));
			$this->view->currencies     =  $getAccountArray['currencies'];
			$this->view->creditTerm     =  $getAccountArray['creditTermArray'];
			$this->view->payMethod      =  $getAccountArray['payMethod'];
			$this->view->approveUser	=  $this->settings->getApproveUsers($cid);
			$this->view->payAccount		=  $this->transaction->getPaymentAccount();
			$this->view->customer 		=  $this->transaction->getCustomerDetails();
			$this->view->incomeAccount	=  $this->transaction->getIncomeAccount();
			$this->view->taxCode    	=  $this->transaction->getTax();
			$id = base64_decode($this->_getParam('id'));
			$this->view->inc_id = $id;
			if(!isset($id) || $id=='') {
				$this->_redirect('transaction/income');
			} else {
				$this->view->income  =  $this->transaction->getIncomeTransaction($id);
				if(!$this->view->income) {
					$this->_redirect('transaction/income');
				}  else {
					$this->view->incomePayment =  $this->transaction->getPaymentDetails($id,1);
				}
			}
			
		}
	}


	public function editAction() {
		if(!Zend_Session::namespaceIsset('sess_login')) {
			 $this->_redirect('index');
		} else {
			if(Zend_Session::namespaceIsset('update_success_income')) {
				$this->view->success = 'Income Transaction Updated successfully';
				Zend_Session::namespaceUnset('update_success_income');
			}
			$logSession = new Zend_Session_Namespace('sess_login');
			$cid = $logSession->cid;
			$this->view->filepath    =  $this->uploadPath.$logSession->cid."/receipts/";
			$id = base64_decode($this->_getParam('id'));
			if(!isset($id) || $id=='') {
				$this->_redirect('transaction/income');
			} else {
				$this->view->income  =  $this->transaction->getIncomeTransaction($id);
				if(!$this->view->income) {
					$this->_redirect('transaction/income');
				} 
			}
			if($this->_request->isPost()) {
				$postArray  				= $this->getRequest()->getPost();

				$adapter    =  new Zend_File_Transfer_Adapter_Http();
				$fileInfo 	=  $adapter->getFileInfo('file'); 
				if(isset($fileInfo['file']['name']) && ($fileInfo['file']['name'] != '')) {
					$adapter->addValidator('Count', false, array('min' =>1, 'max' => 2))
					        ->addValidator('Size',false,array('max'=>2024000),'file')
							->addValidator('Extension',false,'pdf,jpg,doc,docx,png','file');
					$adapter->setDestination("..".$this->view->filepath,'file');
					$fileInfo 	         	  =   $adapter->getFileInfo('file');
					$fileArray		  		  =   explode('.',$fileInfo['file']['name']);
					$postArray['extension']   =   $fileArray['1'];
					$renameFile 		  	  =   trim($id."_".rand(10,10000)."_".$id.".".$fileArray['1']);
					$postArray['receipt_id']  =   $renameFile;
					$adapter->addFilter('Rename',"..".$this->view->filepath.$renameFile);
						if ($adapter->isValid('file') && $adapter->receive('file')) {
							//unlink($this->view->fileuploadpath.$postArray['attachment']);
							$postArray['receipt_id'] =   $renameFile;
						} else {
							$postArray['receipt_id'] =  $postArray['attachment'];
						}
				} else {
					$postArray['receipt_id'] =  $postArray['attachment'];
				}


				$postArray['tax_id'] = ' ';
				$postArray['tax_percentage'] = ' ';
				$postArray['date'] = date("Y-m-d",strtotime(trim($postArray['date'])));
				$taxes = explode("_",$postArray['tax_code']);
				$postArray['tax_id'] = $taxes[0];
				if(isset($taxes[1]) && !empty($taxes[1])) {
					$postArray['tax_percentage'] = $taxes[1];
				}
				$postArray['amount'] = str_replace(",","",$postArray['amount']);
				$payment_account = explode("_", $postArray['payment_account']);
				$postArray['pay_account'] = $payment_account[0];
				//echo '<pre>'; print_r($postArray); echo '</pre>'; die();
				if(isset($postArray['unapprove_save']) && !empty($postArray['unapprove_save'])) {
					$incomeTransaction = $this->transaction->updateIncomeTransaction($postArray,$id,2);
				} else if(isset($postArray['approve_income']) && !empty($postArray['approve_income'])) {
					$postArray['approval_for'] = $logSession->id;
					$incomeTransaction = $this->transaction->updateIncomeTransaction($postArray,$id,1);
				}
				if($incomeTransaction) {
					$sessSuccess = new Zend_Session_Namespace('update_success_income');
					$sessSuccess->status = 1;
					$this->_redirect('transaction/income/edit/id/'.$this->_getParam('id'));
				} else {
						$this->view->error = 'Income Transaction cannot be updated. Kindly try again later';
				}
				
			}
			$getAccountArray            =  $this->accountData->getData(array('currencies','creditTermArray'));
			$this->view->currencies     =  $getAccountArray['currencies'];
			$this->view->creditTerm     =  $getAccountArray['creditTermArray'];
			$this->view->approveUser	=  $this->settings->getApproveUsers($cid);
			$this->view->payAccount		=  $this->transaction->getPaymentAccount();
			$this->view->customer 		=  $this->transaction->getCustomerDetails();
			$this->view->receipts 		=  $this->business->getReceipts('',1);
			$this->view->creditSet 		=  3;
			$this->view->incomeAccount	=  $this->transaction->getIncomeAccount();
			$this->view->taxCode    	=  $this->transaction->getTax();
			//echo '<pre>'; print_r($this->view->income); echo '</pre>'; 
		}
	}


	public function copyAction() {
		if(!Zend_Session::namespaceIsset('sess_login')) {
			 $this->_redirect('index');
		} else {
			$logSession = new Zend_Session_Namespace('sess_login');
			$cid = $logSession->cid;
			$this->view->filepath    =  $this->uploadPath.$logSession->cid."/receipts/";
			$this->view->nextId 	 =  $this->transaction->getNextIncomeTransaction();
			$id = base64_decode($this->_getParam('id'));
			if(!isset($id) || $id=='') {
				$this->_redirect('transaction/income');
			} else {
				$this->view->income  =  $this->transaction->getIncomeTransaction($id);
				if(!$this->view->income) {
					$this->_redirect('transaction/income');
				} 
			}
			if($this->_request->isPost()) {
					$postArray  				= $this->getRequest()->getPost();

					
					$adapter    =  new Zend_File_Transfer_Adapter_Http();
					$fileInfo 	=  $adapter->getFileInfo('file'); 
					if(isset($fileInfo['file']['name']) && ($fileInfo['file']['name'] != '')) {
						$adapter->addValidator('Count', false, array('min' =>1, 'max' => 2))
						        ->addValidator('Size',false,array('max'=>2024000),'file')
								->addValidator('Extension',false,'pdf,jpg,doc,docx,png','file');
						$adapter->setDestination("..".$this->view->filepath,'file');
						$fileInfo 	         	  =   $adapter->getFileInfo('file');
						$fileArray		  		  =   explode('.',$fileInfo['file']['name']);
						$postArray['extension']   =   $fileArray['1'];
						$renameFile 		  	  =   trim($this->view->nextId."_".rand(10,10000)."_".$this->view->nextId.".".$fileArray['1']);
						$postArray['receipt_id']  =   $renameFile;
						$adapter->addFilter('Rename',"..".$this->view->filepath.$renameFile);
							if ($adapter->isValid('file') && $adapter->receive('file')) {
								$postArray['receipt_id'] =   $renameFile;
							} else {
								$postArray['receipt_id'] =  $postArray['attachment'];
							}
					} else {
						$postArray['receipt_id'] =  $postArray['attachment'];
					}

					
					$postArray['tax_id'] = ' ';
					$postArray['tax_percentage'] = ' ';
					$postArray['date'] = date("Y-m-d",strtotime(trim($postArray['date'])));
					$taxes = explode("_",$postArray['tax_code']);
					$postArray['tax_id'] = $taxes[0];
					if(isset($taxes[1]) && !empty($taxes[1])) {
						$postArray['tax_percentage'] = $taxes[1];
					}
					$postArray['amount'] = str_replace(",","",$postArray['amount']);
					$payment_account = explode("_", $postArray['payment_account']);
					$postArray['pay_account'] = $payment_account[0];
					//echo '<pre>'; print_r($postArray); echo '</pre>'; die();
					 if(isset($postArray['approve_income']) && !empty($postArray['approve_income'])) {
					 	$postArray['approval_for'] = $logSession->id;
						$incomeTransaction = $this->transaction->insertIncomeTransaction($postArray,$cid,1);
					}  else if(isset($postArray['unapprove_save']) && !empty($postArray['unapprove_save'])) {
						$incomeTransaction = $this->transaction->insertIncomeTransaction($postArray,$cid,2);
					}
					if($incomeTransaction) {
						$sessSuccess = new Zend_Session_Namespace('insert_success_income');
						$sessSuccess->status = 1;
						$this->_redirect('transaction/income/');
					} else {
							$this->view->error = 'Income Transaction cannot be added. Kindly try again later';
					}
				
			}
			$getAccountArray            =  $this->accountData->getData(array('currencies','creditTermArray'));
			$this->view->currencies     =  $getAccountArray['currencies'];
			$this->view->creditTerm     =  $getAccountArray['creditTermArray'];
			$this->view->approveUser	=  $this->settings->getApproveUsers($cid);
			$this->view->payAccount		=  $this->transaction->getPaymentAccount();
			$this->view->customer 		=  $this->transaction->getCustomerDetails();
			$this->view->creditSet 		=  3;
			$this->view->receipts 		=  $this->business->getReceipts('',1);
			$this->view->incomeAccount	=  $this->transaction->getIncomeAccount();
			$this->view->taxCode    	=  $this->transaction->getTax();
			//echo '<pre>'; print_r($this->view->income); echo '</pre>'; 
		}
	}

	public function ajaxCallAction() {
		$this->_helper->getHelper('layout')->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		$logSession = new Zend_Session_Namespace('sess_login');
		$cid = $logSession->cid;
		if($this->_request->isXmlHttpRequest()) {
			if ($this->_request->isPost()) {
				$ajaxVal = $this->getRequest()->getPost();
				if($ajaxVal['action']=='save_draft_income') {
					$ajaxVal['tax_id'] = ' ';
					$ajaxVal['tax_percentage'] = ' ';
					$ajaxVal['date'] = date("Y-m-d",strtotime(trim($ajaxVal['date'])));
					$taxes = explode("_",$ajaxVal['tax_code']);
					$ajaxVal['tax_id'] = $taxes[0];
					if(isset($taxes[1]) && !empty($taxes[1])) {
						$ajaxVal['tax_percentage'] = $taxes[1];
					}
					if(isset($ajaxVal['customer']) && !empty($ajaxVal['customer'])) {
						$ajaxVal['customer'] = trim($ajaxVal['customer']);
					} else {
						$ajaxVal['customer'] = NULL;
					}
					if(isset($ajaxVal['payment_account']) && !empty($ajaxVal['payment_account'])) {
						$payment_account = explode("_", $ajaxVal['payment_account']);
					    $ajaxVal['pay_account'] = $payment_account[0];
					} else {
						$ajaxVal['pay_account'] = NULL;
					}
					if(isset($ajaxVal['receipt_id']) && !empty($ajaxVal['receipt_id'])) {
						$ajaxVal['receipt_id'] = trim($ajaxVal['receipt_id']);
					} else {
						$ajaxVal['receipt_id'] = NULL;
					}
					$incomeTransaction = $this->transaction->insertIncomeTransaction($ajaxVal,$cid,3);
					if($incomeTransaction) {
						$sessDraft = new Zend_Session_Namespace('sess_draft_income_insert');
						$sessDraft->status = 1;
						echo "success";
					} else {
						echo "Failure";
					}
				} else if($ajaxVal['action']=='update_draft_income') {
					$ajaxVal['tax_id'] = ' ';
					$ajaxVal['tax_percentage'] = ' ';
					$ajaxVal['date'] = date("Y-m-d",strtotime(trim($ajaxVal['date'])));
					$taxes = explode("_",$ajaxVal['tax_code']);
					$ajaxVal['tax_id'] = $taxes[0];
					if(isset($taxes[1]) && !empty($taxes[1])) {
						$ajaxVal['tax_percentage'] = $taxes[1];
					}
					if(isset($ajaxVal['customer']) && !empty($ajaxVal['customer'])) {
						$ajaxVal['customer'] = trim($ajaxVal['customer']);
					} else {
						$ajaxVal['customer'] = NULL;
					}
					if(isset($ajaxVal['payment_account']) && !empty($ajaxVal['payment_account'])) {
						$payment_account = explode("_", $ajaxVal['payment_account']);
					    $ajaxVal['pay_account'] = $payment_account[0];
					} else {
						$ajaxVal['pay_account'] = NULL;
					}
					if(isset($ajaxVal['receipt_id']) && !empty($ajaxVal['receipt_id'])) {
						$ajaxVal['receipt_id'] = trim($ajaxVal['receipt_id']);
					} else {
						$ajaxVal['receipt_id'] = NULL;
					}
					$incomeTransaction = $this->transaction->updateIncomeTransaction($ajaxVal,$ajaxVal['income_id'],3);
					if($incomeTransaction) {
						$sessDraft = new Zend_Session_Namespace('sess_draft_income_insert');
						$sessDraft->status = 1;
						echo "success";
					} else {
						echo "Failure";
					}
				} 
			}
		} 
	}

		
}

?>