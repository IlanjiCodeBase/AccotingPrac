<?php 
class Transaction_InvoiceController extends Zend_Controller_Action {
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
		$this->account 	   = new Account();
		$this->business    = new Business();
		$this->transaction = new Transaction();
		$this->settings    = new Settings();
		$this->approval    = new Approval();
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
			$logSession = new Zend_Session_Namespace('sess_login');
			if(isset($logSession->proxy_cid) && !empty($logSession->proxy_cid)) {
				$cid = $logSession->proxy_cid;
			} else {
				$cid = $logSession->cid;
			}
			$sort   = $this->_getParam('sort');
			if(isset($sort) && !empty($sort) && ($sort==1 || $sort==2)) {
				$sort   = $this->_getParam('sort');
			} else {
				$sort = '';
			}

			$this->view->sort = $sort;
			if($this->_request->isPost()) {
				$postArray  				= $this->getRequest()->getPost();
				$postArray['discount'] = 0;
				$postArray['ref_id']   = $postArray['invoice_id'];
				$postArray['date'] 	   = date("Y-m-d",strtotime(trim($postArray['date'])));
				if(isset($postArray['payment_discount']) && $postArray['payment_discount']==1 && isset($postArray['discount_payment_amount'])) {
					$postArray['discount'] = $postArray['discount_payment_amount'];
				}
				$addPayment = $this->transaction->addPayment($postArray,3);
				$auditId      = $this->transaction->addPaymentAudit($postArray,3);
				$accountEntry = $this->transaction->accountEntry($postArray['ref_id'],3);
				$auditLog	  = $this->settings->insertAuditLog(1,11,'Invoice',$auditId);
				if($addPayment) {
					$sessSuccess = new Zend_Session_Namespace('add_payment_success');
					$sessSuccess->status = 1;
				} else {
					$sessSuccess = new Zend_Session_Namespace('add_payment_success');
					$sessSuccess->status = 2;
				}
				$this->_redirect('transaction/invoice/');
			}
			if(Zend_Session::namespaceIsset('insert_success_invoice')) {
				$this->view->success = 'Invoice Added successfully';
				Zend_Session::namespaceUnset('insert_success_invoice');
			}
			if(Zend_Session::namespaceIsset('delete_success_invoice_transaction')) {
				$this->view->success = 'Invoice deleted successfully';
				Zend_Session::namespaceUnset('delete_success_invoice_transaction');
			}
			if(Zend_Session::namespaceIsset('mark_success_invoice_transaction')) {
				$this->view->success = 'Invoice marked successfully';
				Zend_Session::namespaceUnset('mark_success_invoice_transaction');
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
			if(Zend_Session::namespaceIsset('verify_success_invoice_transaction')) {
				$this->view->success = 'Invoice verified successfully';
				Zend_Session::namespaceUnset('verify_success_invoice_transaction');
			}
			if(Zend_Session::namespaceIsset('unverify_success_invoice_transaction')) {
				$this->view->success = 'Invoice unverified successfully';
				Zend_Session::namespaceUnset('unverify_success_invoice_transaction');
			}
			if(Zend_Session::namespaceIsset('sess_draft_invoice_insert')) {
				$this->view->success = 'Invoice saved as draft';
				Zend_Session::namespaceUnset('sess_draft_invoice_insert');
			}
			$sentid = base64_decode($this->_getParam('sentid'));
			if(isset($sentid) && !empty($sentid)) {
				$markStatus = $this->transaction->markInvoiceTransaction($sentid,1);
				if($markStatus) {
					$sessSuccess = new Zend_Session_Namespace('mark_success_invoice_transaction');
					$sessSuccess->status = 1;
				}
					$this->_redirect('transaction/invoice');
			}
			$delid = base64_decode($this->_getParam('delid'));
			if(isset($delid) && !empty($delid)) {
				$deleteStatus = $this->transaction->deleteInvoiceTransaction($delid,2);
				$auditLog	  = $this->settings->insertAuditLog(3,3,'Invoice',$delid);
				if($deleteStatus) {
					$sessSuccess = new Zend_Session_Namespace('delete_success_invoice_transaction');
					$sessSuccess->status = 1;
				}
					$this->_redirect('transaction/invoice');
			}
			$verifyid  = base64_decode($this->_getParam('verifyid'));
			$status    = $this->_getParam('status');
			if(isset($verifyid) && !empty($verifyid) && isset($status) && !empty($status)) {
				$changeStatus = $this->transaction->changeInvoiceTransactionStatus($verifyid,$status);
				if($changeStatus) {
					if($status==1) {
						$accountEntry = $this->transaction->accountEntry($verifyid,3);
						$auditLog	  = $this->settings->insertAuditLog(6,3,'Invoice',$verifyid);
						$sessSuccess = new Zend_Session_Namespace('verify_success_invoice_transaction');
						$sessSuccess->status = 1;
					} else if($status==2) {
						$accountEntryExpired = $this->transaction->accountEntryExpired($verifyid,3);
						$auditLog	  = $this->settings->insertAuditLog(7,3,'Invoice',$verifyid);
						$sessSuccess = new Zend_Session_Namespace('unverify_success_invoice_transaction');
						$sessSuccess->status = 2;
					}
				}
					$this->_redirect('transaction/invoice');
			}
			$getAccountArray            =  $this->accountData->getData(array('currencies','creditTermArray','payMethod'));
			$this->view->currencies     =  $getAccountArray['currencies'];
			$this->view->creditTerm     =  $getAccountArray['creditTermArray'];
			$this->view->payMethod      =  $getAccountArray['payMethod'];
			$this->view->approveUser	=  $this->settings->getApproveUsers($cid);
			$this->view->cashAccount	=  $this->transaction->getCashAccount();
			$this->view->payAccount		=  $this->transaction->getPaymentIncomeAccount();
			$this->view->vendor 		=  $this->transaction->getVendorDetails();
			//$this->view->expenseAccount	=  $this->transaction->getExpenseAccount();
			/*$this->view->taxCode    	=  $this->transaction->getTax();*/
			$this->view->invoice 		=  $this->transaction->getInvoiceTransaction($id='',$sort);
			$this->view->invoiceCredit  =  $this->transaction->getInvoiceCredit();
			$this->view->payments 		=  $this->transaction->getPaymentDetails('',3);
			//echo '<pre>'; print_r($this->view->invoice); echo '</pre>';
		}
	}

	public function addAction() {
		if(!Zend_Session::namespaceIsset('sess_login')) {
			 $this->_redirect('index');
		} else {
			$logSession = new Zend_Session_Namespace('sess_login');
			if(isset($logSession->proxy_cid) && !empty($logSession->proxy_cid)) {
				$cid = $logSession->proxy_cid;
			} else {
				$cid = $logSession->cid;
			}
			$this->currency_id = $this->_getParam('currency');
			if(isset($this->currency_id) && !empty($this->currency_id)) {
			    $this->view->currency_id = $this->_getParam('currency');
			}
			$this->customer_id = $this->_getParam('customer');
			if(isset($this->customer_id) && !empty($this->customer_id)) {
			    $this->view->customer_id = $this->_getParam('customer');
			    $this->view->shippings   = $this->transaction->getCustomerShippingDetails($this->view->customer_id);
			} 
			$this->date = $this->_getParam('date');
			$this->due  = $this->_getParam('due');
			if(isset($this->date) && !empty($this->date) && isset($this->due) && !empty($this->due)) {
				$this->view->date = $this->_getParam('date');
				$this->view->due  = $this->_getParam('due');
			}
			//$this->view->customer_id = base64_decode($this->_getParam('cid'));
			if($this->_request->isPost()) {
				$postArray  				= $this->getRequest()->getPost();
				$postArray['date'] 	   = date("Y-m-d",strtotime(trim($postArray['date'])));
				$postArray['due_date'] = date("Y-m-d",strtotime(trim($postArray['due_date'])));
				//echo '<pre>'; print_r($postArray); echo '</pre>'; die();
				if(isset($postArray['unapprove_save']) && !empty($postArray['unapprove_save'])) {
					$invoiceTransaction = $this->transaction->insertInvoiceTransaction($postArray,$cid,2);
					$auditId = $this->transaction->insertInvoiceAuditTransaction($postArray,$invoiceTransaction,2);
					$sendNotify		   = $this->sendMail($postArray['approval_for']);
					$auditLog	  = $this->settings->insertAuditLog(1,3,'Invoice',$auditId);
				} else if(isset($postArray['approve_invoice']) && !empty($postArray['approve_invoice'])) {
					//$postArray['approval_for'] = $logSession->id;
					$invoiceTransaction = $this->transaction->insertInvoiceTransaction($postArray,$cid,1);
					$auditId = $this->transaction->insertInvoiceAuditTransaction($postArray,$invoiceTransaction,1);
					$accountEntry = $this->transaction->accountEntry($invoiceTransaction,3);
					$auditLog	  = $this->settings->insertAuditLog(1,3,'Invoice',$auditId);
					$auditLog	  = $this->settings->insertAuditLog(6,3,'Invoice',$invoiceTransaction);
				} else if(isset($postArray['save_sent']) && !empty($postArray['save_sent'])) {
					$invoiceTransaction = $this->transaction->insertInvoiceTransaction($postArray,$cid,3);
				}
				if($invoiceTransaction) {
					$sessSuccess = new Zend_Session_Namespace('insert_success_invoice');
					$sessSuccess->status = 1;
					$this->_redirect('transaction/invoice/');
				} else {
						$this->view->error = 'Invoice cannot be added. Kindly try again later';
				}
				//echo '<pre>'; print_r($postArray); echo '</pre>'; die();
			}
			if(Zend_Session::namespaceIsset('insert_success_invoice')) {
				$this->view->success = 'Invoice Added successfully';
				Zend_Session::namespaceUnset('insert_success_invoice');
			}
			
			$getAccountArray            =  $this->accountData->getData(array('currencies','creditTermArray','payMethod','supplyTaxCodes'));
			$this->view->currencies     =  $getAccountArray['currencies'];
			$this->view->creditTerm     =  $getAccountArray['creditTermArray'];
			$this->view->payMethod      =  $getAccountArray['payMethod'];
			$supply 					= array();
			//$this->view->supply         =  $getAccountArray['supplyTaxCodes'];
			$this->view->invoiceNo    	=  $this->transaction->generateInvoiceNo();
			$this->view->invoiceCustom	=  $this->settings->getInvoiceCustomization();
			$this->view->approveUser	=  $this->settings->getApproveUsers($cid);
			$this->view->cashAccount	=  $this->transaction->getCashAccount();
			$this->view->payAccount		=  $this->transaction->getPaymentIncomeAccount();
			$this->view->customer 		=  $this->transaction->getCustomerDetails();
			$this->view->shipping 		=  $this->transaction->getShippingDetails();
			if(isset($this->view->currency_id) && !empty($this->view->currency_id)) {
				$this->view->product 		=  $this->transaction->getCurrencyProductDetails($this->view->currency_id);
				$this->view->ajaxCurrency   =  $this->view->currency_id;
			} else if(isset($this->invoiceCustom[0]['default_currency']) && !empty($this->invoiceCustom[0]['default_currency'])) {
				$this->view->product 		=  $this->transaction->getCurrencyProductDetails($this->invoiceCustom[0]['default_currency']);
				$this->view->ajaxCurrency   =  $this->invoiceCustom[0]['default_currency'];
			} else {
				$this->view->product 		=  $this->transaction->getCurrencyProductDetails('SGD');
				$this->view->ajaxCurrency   =  'SGD';
			}
		//	$this->view->expenseAccount	=  $this->transaction->getExpenseAccount();
			$this->iras 	    		=  $this->transaction->getIrasTax(2);
			foreach ($this->iras as $iras) {
				$supply[$iras['id']]['name']	    = $iras['name'];
				$supply[$iras['id']]['percentage']  = $iras['percentage'];
				$supply[$iras['id']]['description'] = $iras['description'];
			}
			$this->view->supply 		= $supply;
			$this->view->taxCode    	=  $this->transaction->getSalesTax(2);
		//	$this->view->product 	    =  $this->settings->getProducts();
			$this->view->creditSet 		=  1;
			//echo '<pre>'; print_r($this->view->product); echo '</pre>';
			//echo '<pre>'; print_r($this->view->shipping); echo '</pre>';
		}
	}

	public function viewAction() {
		if(!Zend_Session::namespaceIsset('sess_login')) {
			 $this->_redirect('index');
		} else {
			$logSession = new Zend_Session_Namespace('sess_login');
			if(isset($logSession->proxy_cid) && !empty($logSession->proxy_cid)) {
				$cid = $logSession->proxy_cid;
			} else {
				$cid = $logSession->cid;
			}
			if($this->_request->isPost()) {
				$postArray  				= $this->getRequest()->getPost();
				$postArray['discount'] = 0;
				$postArray['date'] 	   = date("Y-m-d",strtotime(trim($postArray['date'])));
				if(isset($postArray['payment_discount']) && $postArray['payment_discount']==1 && isset($postArray['discount_amount'])) {
					$postArray['discount'] = $postArray['discount_amount'];
				}
				$updatePayment = $this->transaction->updatePayment($postArray,3);
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
			if(Zend_Session::namespaceIsset('delete_success_invoice_payment')) {
				$this->view->success = 'Invoice Payment Deleted successfully';
				Zend_Session::namespaceUnset('delete_success_invoice_payment');
			}
			$id = base64_decode($this->_getParam('id'));
			$this->view->inv_id = $id;
			if(!isset($id) || $id=='') {
				$this->_redirect('transaction/invoice');
			} else {
				$this->view->invoice  =  $this->transaction->getInvoiceTransaction($id);
				if(!$this->view->invoice) {
					$this->_redirect('transaction/invoice');
				} else {
					$this->view->invoiceProductList  =  $this->transaction->getInvoiceProductList($id);
					$this->view->invoicePayment      =  $this->transaction->getPaymentDetails($id,3);
					$this->view->invoiceCredit  	 =  $this->transaction->getInvoiceCredit($id);
					$this->view->shipping 			 =  $this->transaction->getParticularShippingDetails($this->view->invoice[0]['fkshipping_address']);
					if(!$this->view->invoiceProductList) {
						$this->_redirect('transaction/invoice');
					} 
				}
			}	
			$delid = base64_decode($this->_getParam('delid'));
			if(isset($delid) && !empty($delid)) {
				$deleteStatus = $this->transaction->deletePayment($delid);
				if($deleteStatus) {
					$sessSuccess = new Zend_Session_Namespace('delete_success_invoice_payment');
					$sessSuccess->status = 1;
				}
					$this->_redirect('transaction/invoice/view/id/'.$this->_getParam('id'));
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


	public function editAction() {
		if(!Zend_Session::namespaceIsset('sess_login')) {
			 $this->_redirect('index');
		} else {
			if(Zend_Session::namespaceIsset('update_success_invoice')) {
				$this->view->success = 'Invoice Updated successfully';
				Zend_Session::namespaceUnset('update_success_invoice');
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
			if(Zend_Session::namespaceIsset('delete_success_invoice_payment')) {
				$this->view->success = 'Invoice Payment Deleted successfully';
				Zend_Session::namespaceUnset('delete_success_invoice_payment');
			}
			$logSession = new Zend_Session_Namespace('sess_login');
			if(isset($logSession->proxy_cid) && !empty($logSession->proxy_cid)) {
				$cid = $logSession->proxy_cid;
			} else {
				$cid = $logSession->cid;
			}
			$id = base64_decode($this->_getParam('id'));
			$this->view->inv_id = $id;
			if(!isset($id) || $id=='') {
				$this->_redirect('transaction/invoice');
			} else {
				$this->view->invoice  =  $this->transaction->getInvoiceTransaction($id);
				if(!$this->view->invoice) {
					$this->_redirect('transaction/invoice');
				} else {
					$this->view->invoiceProductList  =  $this->transaction->getInvoiceProductList($id);
					$this->view->invoicePayment =  $this->transaction->getPaymentDetails($id,3);
					//print_r($this->view->invoicePayment);
					$this->view->invoiceCredit  =  $this->transaction->getInvoiceCredit($id);
					if(!$this->view->invoiceProductList) {
						$this->_redirect('transaction/invoice');
					} 
				}
			}	
			if($this->_request->isPost()) {
				$postArray  		   = $this->getRequest()->getPost();
				if(isset($postArray['action']) && $postArray['action']=='add_payment') {
					$postArray['discount'] = 0;
					$postArray['date'] 	   = date("Y-m-d",strtotime(trim($postArray['pay_date'])));
					if(isset($postArray['payment_discount']) && $postArray['payment_discount']==1 && isset($postArray['discount_amount'])) {
						$postArray['discount'] = $postArray['discount_amount'];
					}
					$updatePayment = $this->transaction->updatePayment($postArray,3);
					$auditId      = $this->transaction->addPaymentAudit($postArray,3);
					$accountEntry  = $this->transaction->accountEntry($id,3);
					$auditLog	   = $this->settings->insertAuditLog(2,11,'Invoice',$auditId);
					if($updatePayment) {
						$sessSuccess = new Zend_Session_Namespace('update_payment_success');
						$sessSuccess->status = 1;
						$this->_redirect('transaction/invoice/edit/id/'.$this->_getParam('id'));
					} else {
						$sessSuccess = new Zend_Session_Namespace('update_payment_success');
						$sessSuccess->status = 2;
						$this->_redirect('transaction/invoice/edit/id/'.$this->_getParam('id'));
					}
				} else {
				$postArray['date']	   = date("Y-m-d",strtotime(trim($postArray['date'])));
				$postArray['due_date'] = date("Y-m-d",strtotime(trim($postArray['due_date'])));
				if(isset($postArray['unapprove_save']) && !empty($postArray['unapprove_save'])) {
					$invoiceTransaction = $this->transaction->updateInvoiceTransaction($postArray,$id,2);
					$auditId = $this->transaction->insertInvoiceAuditTransaction($postArray,$id,2);
					$sendNotify		   = $this->sendMail($postArray['approval_for']);
					$auditLog	   = $this->settings->insertAuditLog(2,3,'Invoice',$auditId);
				} else if(isset($postArray['approve_invoice']) && !empty($postArray['approve_invoice'])) {
					//$postArray['approval_for'] = $logSession->id;
					$invoiceTransaction = $this->transaction->updateInvoiceTransaction($postArray,$id,1);
					$auditId = $this->transaction->insertInvoiceAuditTransaction($postArray,$id,1);
					$accountEntry  = $this->transaction->accountEntry($id,3);
					$auditLog	   = $this->settings->insertAuditLog(2,3,'Invoice',$auditId);
					$auditLog	   = $this->settings->insertAuditLog(6,3,'Invoice',$id);
				} 
				if($invoiceTransaction) {
					$sessSuccess = new Zend_Session_Namespace('update_success_invoice');
					$sessSuccess->status = 1;
					$this->_redirect('transaction/invoice/edit/id/'.$this->_getParam('id'));
				} else {
					$this->view->error = 'Invoice cannot be updated. Kindly try again later';
				}
			}
			}
			$delid = base64_decode($this->_getParam('delid'));
			$payid = base64_decode($this->_getParam('payid'));
			if(isset($delid) && !empty($delid)) {
				$deleteStatus = $this->transaction->deletePayment($delid,$id,3,$payid);
				$auditLog	   = $this->settings->insertAuditLog(3,11,'Invoice',$id);
				if($deleteStatus) {
					$sessSuccess = new Zend_Session_Namespace('delete_success_invoice_payment');
					$sessSuccess->status = 1;
				}
					$this->_redirect('transaction/invoice/edit/id/'.$this->_getParam('id'));
			}
			$getAccountArray            =  $this->accountData->getData(array('currencies','creditTermArray','payMethod','supplyTaxCodes'));
			$this->view->currencies     =  $getAccountArray['currencies'];
			$this->view->creditTerm     =  $getAccountArray['creditTermArray'];
			$this->view->payMethod      =  $getAccountArray['payMethod'];
			$supply 					= array();
			//$this->view->supply         =  $getAccountArray['supplyTaxCodes'];
			$this->view->approveUser	=  $this->settings->getApproveUsers($cid);
			$this->view->cashAccount	=  $this->transaction->getCashAccount();
			$this->view->payAccount		=  $this->transaction->getPaymentIncomeAccount();
			$this->view->customer 		=  $this->transaction->getCustomerDetails();
			$this->view->shipping 		=  $this->transaction->getShippingDetails();
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
		}
	}

	public function copyAction() {
		if(!Zend_Session::namespaceIsset('sess_login')) {
			 $this->_redirect('index');
		} else {
			if(Zend_Session::namespaceIsset('insert_success_invoice')) {
				$this->view->success = 'Invoice Added successfully';
				Zend_Session::namespaceUnset('insert_success_invoice');
			}
			$logSession = new Zend_Session_Namespace('sess_login');
			if(isset($logSession->proxy_cid) && !empty($logSession->proxy_cid)) {
				$cid = $logSession->proxy_cid;
			} else {
				$cid = $logSession->cid;
			}
			$id = base64_decode($this->_getParam('id'));
			if(!isset($id) || $id=='') {
				$this->_redirect('transaction/invoice');
			} else {
				$this->view->invoice  =  $this->transaction->getInvoiceTransaction($id);
				if(!$this->view->invoice) {
					$this->_redirect('transaction/invoice');
				} else {
					$this->view->invoiceProductList  =  $this->transaction->getInvoiceProductList($id);
					if(!$this->view->invoiceProductList) {
						$this->_redirect('transaction/invoice');
					} 
				}
			}	
			if($this->_request->isPost()) {
				$postArray  		   = $this->getRequest()->getPost();
				$postArray['date']	   = date("Y-m-d",strtotime(trim($postArray['date'])));
				$postArray['due_date'] = date("Y-m-d",strtotime(trim($postArray['due_date'])));
				if(isset($postArray['unapprove_save']) && !empty($postArray['unapprove_save'])) {
					$invoiceTransaction = $this->transaction->insertInvoiceTransaction($postArray,$cid,2);
					$auditId = $this->transaction->insertInvoiceAuditTransaction($postArray,$invoiceTransaction,2);
					$sendNotify		   = $this->sendMail($postArray['approval_for']);
					$auditLog	   = $this->settings->insertAuditLog(1,3,'Invoice',$auditId);
				} else if(isset($postArray['approve_invoice']) && !empty($postArray['approve_invoice'])) {
					//$postArray['approval_for'] = $logSession->id;
					$invoiceTransaction = $this->transaction->insertInvoiceTransaction($postArray,$cid,1);
					$auditId = $this->transaction->insertInvoiceAuditTransaction($postArray,$invoiceTransaction,1);
					$accountEntry  = $this->transaction->accountEntry($invoiceTransaction,3);
					$auditLog	   = $this->settings->insertAuditLog(1,3,'Invoice',$auditId);
					$auditLog	   = $this->settings->insertAuditLog(6,3,'Invoice',$invoiceTransaction);
				} 
				if($invoiceTransaction) {
					$sessSuccess = new Zend_Session_Namespace('insert_success_invoice');
					$sessSuccess->status = 1;
					$this->_redirect('transaction/invoice');
				} else {
						$this->view->error = 'Invoice cannot be added. Kindly try again later';
				}
			}
			$getAccountArray            =  $this->accountData->getData(array('payMethod','currencies','creditTermArray','supplyTaxCodes'));
			$this->view->currencies     =  $getAccountArray['currencies'];
			$this->view->creditTerm     =  $getAccountArray['creditTermArray'];
			$this->view->payMethod      =  $getAccountArray['payMethod'];
			$supply 					= array();
			//$this->view->supply         =  $getAccountArray['supplyTaxCodes'];
			$this->view->approveUser	=  $this->settings->getApproveUsers($cid);
			$this->view->invoiceNo    	=  $this->transaction->generateInvoiceNo();
			$this->view->cashAccount	=  $this->transaction->getCashAccount();
			$this->view->payAccount		=  $this->transaction->getPaymentIncomeAccount();
			$this->view->customer 		=  $this->transaction->getCustomerDetails();
			$this->view->shipping 		=  $this->transaction->getShippingDetails();
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
		}
	}

	public function sendMail($userid) {
		if(!Zend_Session::namespaceIsset('sess_login')) {
			 $this->_redirect('index');
		} else {
			$logSession = new Zend_Session_Namespace('sess_login');
			if(isset($logSession->proxy_cid) && !empty($logSession->proxy_cid)) {
				$cid = $logSession->proxy_cid;
			} else {
				$cid = $logSession->cid;
			}
			$id = $logSession->id;
				$userEmail = $this->transaction->getApproveUserEmail($userid);
				$user      = $this->transaction->getApproveUserEmail($id);
				$mail = new Zend_Mail();
				$bodyContent = 'Dear User, <br/> Invoice Transaction has been created by user '.$user.' and is awaiting for your approval. <a href='.$this->view->sitePath."default/notification/transactions".'>Click here </a> to approve the transaction.';
				$subject 	 = 'Notification for Transaction Approval - Immediate';
				$config = array('ssl' => 'tls', 'port' => '587', 'auth' => 'login', 'username' => 'divagar.umm@gmail.com', 'password' => 'UMMdivagar');
				$transport = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $config);
				$mail->addTo($userEmail, '');
				$mail->setFrom('Accounting', 'no-reply');
				$mail->setSubject($subject);
				$mail->setBodyHtml($bodyContent);
				$mail->send(/*$transport*/);
				return true;
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
						//	echo '<select class="select2 form-control" name="customer" id="customer" onchange="return shippingAddress(this.value);">';
							echo '<option value="">Select</option>';
						foreach ($this->customer as $customer) {
							$coa = $customer['coa_link'].",".$customer['other_coa_link'];
							if($ajaxVal['id']==$customer['id'])
                                $customerSelect = 'selected';
                            else
                                $customerSelect = '';
							echo '<option value='.$customer['id'].' '.$customerSelect.' data-coa='.$coa.'>'.$customer['customer_name'].'</option>';
						}
					//	echo '</select>';
					}
				} else if($ajaxVal['action']=='productRefresh') {
					$this->product 		=  $this->transaction->getCurrencyProductDetails($ajaxVal['cur_id']);
					if($this->product) {
						$jsonEncode = json_encode($this->product);
						echo $jsonEncode;
						/*echo '<select class="form-control" name="product_description_'.$ajaxVal['product'].'" id="product_description_'.$ajaxVal['product'].'" required  onchange="return productSelect('.$ajaxVal['product'].',this.value);">';
						echo '<option value="">Select</option>';
						foreach ($this->product as $product) {
							$prod = $product['id']."_".$product['product_id']."_".$product['price'];
							if($ajaxVal['id']==$prod)
                                $productSelect = 'selected';
                            else
                                $productSelect = '';
							echo '  <option value='.$product['id']."_".$product['product_id']."_".$product['price'].' '.$productSelect.'>'.ucfirst($product['name']).'</option>';
						}
						echo '</select>';*/
					}
				} else if($ajaxVal['action']=='getPayAccount') {
					$this->cashAccount	=  $this->transaction->getCashAccount();
					$this->payAccount	=  $this->transaction->getPaymentIncomeAccount($ajaxVal['coa']);
					$opt1 = 0;
					$opt2 = 0;
					if($this->cashAccount || $this->payAccount) {
						//echo '<select class="form-control" name="payment_account" id="payment_account" onchange="triggerPayment();">';
						echo '<option value="">Select</option>';
						echo '<optgroup label="Cash and Cash Equivalents">';
						foreach ($this->cashAccount as $cash) {
							$pays = $cash['id']."_".$cash['level2']."_".$cash['account_type'];
							echo '<option value='.$cash['id']."_".$cash['level2']."_".$cash['account_type'].'>'.ucfirst($cash['account_name']).'</option>';
						}
						echo '</optgroup>';
						foreach ($this->payAccount as $pay) {
							$pays = $pay['id']."_".$pay['level2']."_".$pay['account_type'];
							if($pay['level2']==4 && $opt1!=1) {
								echo '<optgroup label="Trade Receivables">';
								$opt1=1;
							}
							if($pay['level2']==5 && $opt2!=1) {
								echo '<optgroup label="Other Receivables">';
								$opt2=1;
							}
							echo '<option value='.$pay['id']."_".$pay['level2']."_".$pay['account_type'].'>'.ucfirst($pay['account_name']).'</option>';
						}
						//echo '</select>';
					}
				} else if($ajaxVal['action']=='getPayAccount_update') {
					$this->cashAccount	=  $this->transaction->getCashAccount();
					$this->payAccount	=  $this->transaction->getPaymentIncomeAccount($ajaxVal['coa']);
					$opt1 = 0;
					$opt2 = 0;
					if($this->cashAccount || $this->payAccount) {
						//echo '<select class="form-control" name="payment_account" id="payment_account" onchange="triggerPayment();">';
						//echo '<option value="">Select</option>';
						echo '<optgroup label="Cash and Cash Equivalents">';
						foreach ($this->cashAccount as $cash) {
							$pays = $cash['id']."_".$cash['level2']."_".$cash['account_type'];
							if($ajaxVal['payId']==$cash['id']) 
								$paySelect = 'selected';
							else
								$paySelect = '';
							echo '<option value='.$cash['id']."_".$cash['level2']."_".$cash['account_type'].' '.$paySelect.'>'.ucfirst($cash['account_name']).'</option>';
						}
						echo '</optgroup>';
						foreach ($this->payAccount as $pay) {
							$pays = $pay['id']."_".$pay['level2']."_".$pay['account_type'];
							if($pay['level2']==4 && $opt1!=1) {
								echo '<optgroup label="Trade Receivables">';
								$opt1=1;
							}
							if($pay['level2']==5 && $opt2!=1) {
								echo '<optgroup label="Other Receivables">';
								$opt2=1;
							}
							if($ajaxVal['payId']==$pay['id']) 
								$paySelect = 'selected';
							else
								$paySelect = '';
							echo '<option value='.$pay['id']."_".$pay['level2']."_".$pay['account_type'].' '.$paySelect.'>'.ucfirst($pay['account_name']).'</option>';
						}
						//echo '</select>';
					}
				} else if($ajaxVal['action']=='shippingDetails') {
					$this->shipping 	=  $this->transaction->getCustomerShippingDetails($ajaxVal['cust_id']);
					if(isset($this->shipping)) {
						//	echo '<select class="select2 form-control" name="customer" id="customer" onchange="return shippingAddress(this.value);">';
							echo '<option value="0">Default Shipping Address</option>';
							$i = 1;
						foreach ($this->shipping as $shipping) {
							echo '<option value='.$shipping['id'].' >Shipping Address '.$i.'</option>';
							$i++;
						}
					//	echo '</select>';
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
				if($ajaxVal['action']=='save_draft_invoice') {
					$ajaxVal['date'] 	 = date("Y-m-d",strtotime(trim($ajaxVal['date'])));
					$ajaxVal['due_date'] = date("Y-m-d",strtotime(trim($ajaxVal['due_date'])));
					if(isset($ajaxVal['customer']) && !empty($ajaxVal['customer'])) {
						$ajaxVal['customer'] = trim($ajaxVal['customer']);
					} else {
						$ajaxVal['customer'] = NULL;
					}
					$invoiceTransaction = $this->transaction->insertInvoiceTransaction($ajaxVal,$cid,3);
					$auditId = $this->transaction->insertInvoiceAuditTransaction($ajaxVal,$invoiceTransaction,3);
					$auditLog	   = $this->settings->insertAuditLog(8,3,'Invoice',$auditId);
					if($invoiceTransaction) {
						$sessDraft = new Zend_Session_Namespace('sess_draft_invoice_insert');
						$sessDraft->status = 1;
						echo "success";
					} else {
						echo "Failure";
					}
				} else if($ajaxVal['action']=='update_draft_invoice') {
					$ajaxVal['date'] 	 = date("Y-m-d",strtotime(trim($ajaxVal['date'])));
					$ajaxVal['due_date'] = date("Y-m-d",strtotime(trim($ajaxVal['due_date'])));
					if(isset($ajaxVal['customer']) && !empty($ajaxVal['customer'])) {
						$ajaxVal['customer'] = trim($ajaxVal['customer']);
					} else {
						$ajaxVal['customer'] = NULL;
					}
					$invoiceTransaction = $this->transaction->updateInvoiceTransaction($ajaxVal,$ajaxVal['invoice_id'],3);
					$auditId = $this->transaction->insertInvoiceAuditTransaction($ajaxVal,$ajaxVal['invoice_id'],3);
					$auditLog	   = $this->settings->insertAuditLog(8,3,'Invoice',$auditId);
					if($invoiceTransaction) {
						$sessDraft = new Zend_Session_Namespace('sess_draft_invoice_insert');
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