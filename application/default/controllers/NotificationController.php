<?php 
class NotificationController extends Zend_Controller_Action {
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
		$this->transaction = new Transaction();
		$this->approval    = new Approval();
		$this->accountData = new Account_Data();	
		$this->uploadPath  = Zend_Registry::get('uploadpath');

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
	


	public function transactionsAction() {
		if(!Zend_Session::namespaceIsset('sess_login')) {
			$this->_redirect('index');
		} else {
			$logSession = new Zend_Session_Namespace('sess_login');
			if(($logSession->type==0 || $logSession->type==1) && !isset($logSession->proxy_type)) {
				$this->_redirect('index/dashboard');
			} else if(($logSession->type==0 || $logSession->type==1) && isset($logSession->proxy_type) && ($logSession->proxy_type==4 || $logSession->proxy_type==5)) {
				$this->_redirect('index/dashboard');
			} else if(($logSession->type==4 || $logSession->type==5)) {
				$this->_redirect('index/dashboard');
			} else {
				if(isset($logSession->proxy_id) && !empty($logSession->proxy_id)) {
					$id = $logSession->proxy_id;
				} else {
					$id = $logSession->id;
				}

				if(Zend_Session::namespaceIsset('approve_success_transaction')) {
					$this->view->success = 'Transactions Approved successfully';
					Zend_Session::namespaceUnset('approve_success_transaction');
				}

				if($this->_request->isPost()) {
					$postArray  = $this->getRequest()->getPost();
					$approve    = $this->transaction->approveTransaction($postArray);
					if($approve) {
						$sessSuccess = new Zend_Session_Namespace('approve_success_transaction');
						$sessSuccess->status = 1;
						$this->_redirect('notification/transactions/');
					}
					//echo '<pre>'; print_r($postArray); echo '</pre>';
				}

				$pendingTransaction = array();
				$maximumInv       	= array();
				$maximumCre       	= array();
				$maximumExp       	= array();

				$pendingIncome  = $this->approval->pendingIncomeTransactions($id);
				$pendingExpense = $this->approval->pendingExpenseTransactions($id);
				$pendingInvoice = $this->approval->pendingInvoiceTransactions($id);
				$pendingCredit  = $this->approval->pendingCreditTransactions($id);
				$pendingJournal = $this->approval->pendingJournalTransactions($id);
				$maxExpense     = $this->approval->getMaxExpenseTransaction($id);
				$maxInvoice     = $this->approval->getMaxInvoiceTransaction($id);
				$maxCredit      = $this->approval->getMaxCreditTransaction($id);
				
				if(isset($maxInvoice) && !empty($maxInvoice)) {
					foreach ($maxInvoice as $maxInv) {
						if(!array_key_exists($maxInv['fkinvoice_id'], $maximumInv)) {
							$maximumInv[$maxInv['fkinvoice_id']]['income_account'] = $maxInv['account_name'];
						}
					}
				}

				if(isset($maxCredit) && !empty($maxCredit)) {
					foreach ($maxCredit as $maxCre) {
						if(!array_key_exists($maxCre['fkcredit_id'], $maximumCre)) {
							$maximumCre[$maxCre['fkcredit_id']]['income_account'] = $maxCre['account_name'];
						}
					}
				}


				if(isset($maxExpense) && !empty($maxExpense)) {
					foreach ($maxExpense as $maxExp) {
						if(!array_key_exists($maxExp['fkexpense_id'], $maximumExp)) {
							$maximumExp[$maxExp['fkexpense_id']]['expense_account'] = $maxExp['account_name'];
						}
					}
				}

				if(isset($pendingIncome) && !empty($pendingIncome)) {
					foreach ($pendingIncome as $income) {

						$tax_amount     = ($income['amount'] * $income['tax_value'] / 100);
						if($income['transaction_currency']!='SGD') {
							$total_amount   = ($income['amount'] + $tax_amount) * $income['exchange_rate'];
						} else {
							$total_amount   = $income['amount'] + $tax_amount;
						}
	                    

	                    $pendingTransaction[$income['income_no']]['label'] = 'Income';
						$pendingTransaction[$income['income_no']]['id'] = $income['id'];
						$pendingTransaction[$income['income_no']]['amount'] = $total_amount;
						$pendingTransaction[$income['income_no']]['business'] = $income['customer_name'];
						$pendingTransaction[$income['income_no']]['account'] = $income['account_name'];
						$pendingTransaction[$income['income_no']]['date'] = $income['date'];

					}
				}

				if(isset($pendingExpense) && !empty($pendingExpense)) {
					foreach ($pendingExpense as $expense) {

						if($expense['transaction_currency']!='SGD') {
							if($expense['total_gst']!=0.00) {
								$total_amount   = ($expense['amount'] * $expense['exchange_rate']) + $expense['total_gst'];
							} else {
								$total_amount   = ($expense['amount'] + $expense['tax_amount']) * $expense['exchange_rate'];
							}
							
						} else {
							$total_amount   = $expense['amount'] + $expense['tax_amount'];
						}


	                    $pendingTransaction[$expense['expense_no']]['label'] = 'Expense';
						$pendingTransaction[$expense['expense_no']]['id'] = $expense['id'];
						$pendingTransaction[$expense['expense_no']]['amount'] = $total_amount;
						$pendingTransaction[$expense['expense_no']]['business'] = $expense['vendor_name'];
						$pendingTransaction[$expense['expense_no']]['account'] = $maximumExp[$expense['id']]['expense_account'];
						$pendingTransaction[$expense['expense_no']]['date'] = $expense['date'];

					}
				}

				if(isset($pendingInvoice) && !empty($pendingInvoice)) {
					foreach ($pendingInvoice as $invoice) {

						if($invoice['transaction_currency']!='SGD') {
							$total_amount   = ($invoice['amount'] + $invoice['tax_amount']) * $invoice['exchange_rate'];
						} else {
							$total_amount   = $invoice['amount'] + $invoice['tax_amount'];
						}
	                   

	                    $pendingTransaction[$invoice['invoice_no']]['label'] = 'Invoice';
						$pendingTransaction[$invoice['invoice_no']]['id'] = $invoice['id'];
						$pendingTransaction[$invoice['invoice_no']]['amount'] = $total_amount;
						$pendingTransaction[$invoice['invoice_no']]['business'] = $invoice['customer_name'];
						$pendingTransaction[$invoice['invoice_no']]['account'] = $maximumInv[$invoice['id']]['income_account'];
						$pendingTransaction[$invoice['invoice_no']]['date'] = $invoice['date'];

					}
				}


				if(isset($pendingCredit) && !empty($pendingCredit)) {
					foreach ($pendingCredit as $credit) {

						if($credit['transaction_currency']!='SGD') {
							$total_amount   = ($credit['amount'] + $credit['tax_amount']) * $credit['exchange_rate'];
						} else {
							$total_amount   = $credit['amount'] + $credit['tax_amount'];
						}


	                    $pendingTransaction[$credit['credit_no']]['label'] = 'Credit Note';
						$pendingTransaction[$credit['credit_no']]['id'] = $credit['id'];
						$pendingTransaction[$credit['credit_no']]['amount'] = $total_amount;
						$pendingTransaction[$credit['credit_no']]['business'] = $credit['customer_name'];
						$pendingTransaction[$credit['credit_no']]['account'] = $maximumCre[$credit['id']]['income_account'];
						$pendingTransaction[$credit['credit_no']]['date'] = $credit['date'];

					}
				}

				if(isset($pendingJournal) && !empty($pendingJournal)) {
					foreach ($pendingJournal as $journal) {

	                    $pendingTransaction[$journal['journal_no']]['label'] = 'Journal Entry';
						$pendingTransaction[$journal['journal_no']]['id'] = $journal['id'];
						$pendingTransaction[$journal['journal_no']]['amount'] = $journal['total_debit'];
						$pendingTransaction[$journal['journal_no']]['business'] = '';
						$pendingTransaction[$journal['journal_no']]['account'] = $journal['description'];
						$pendingTransaction[$journal['journal_no']]['date'] = $journal['date'];

					}
				}

				$this->view->result = $pendingTransaction;
			//	echo '<pre>'; print_r($pendingTransaction); echo '</pre>';
			}
		}
	}

	public function messagesAction() {
		if(!Zend_Session::namespaceIsset('sess_login')) {
			$this->_redirect('index');
		} else {
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
						}
						$notify[$notification['id']]['subject'] = $notification['subject'];
						$notify[$notification['id']]['message'] = $notification['message'];
						$notify[$notification['id']]['date']    = $notification['date_created'];
					}
				}
			}

			$this->view->notifyMessages = $notify;

		}
	}

	public function messageAction() {
    	if(!Zend_Session::namespaceIsset('sess_login')) {
	            $this->_redirect('index');
	      } else {

	      	$logSession = new Zend_Session_Namespace('sess_login');

	      	if(Zend_Session::namespaceIsset('update-success-announcement')) {
				$this->view->success = 'Details Updated Successfully';
				Zend_Session::namespaceUnset('update-success-announcement');
			}


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

			$this->view->companies   =  $this->account->getCompanies();
			$mid = base64_decode($this->_getParam('id'));
			if(!isset($mid) || $mid=='') {
				$this->_redirect('notification/messages');
			} else {
				$this->view->result 		 =  $this->approval->getNotificationAnnouncements($mid);
				if(!$this->view->result) {
					//$this->_redirect('notification/messages');
				} else {
					$this->view->userList  =  $this->account->getCompanyUserDetails($this->view->result[0]['fkcompany_id']);
				}
			}

		 if(isset($this->view->result) && !empty($this->view->result)) {
		 	if(isset($this->view->result[0]['seenusers']) && !empty($this->view->result[0]['seen_users'])) {
				$seen_users = explode(",", $this->view->result[0]['seen_users']);
			} else {
				$seen_users = array();
			}
			if(!in_array($id, $seen_users)) {
				$seen_users[] = $id;
				$seenusers    = implode(",", $seen_users);
				$markseen     = $this->approval->markMessageSeen($mid,$seenusers);
			}
		}


			if($this->_request->isPost()) {
				$postArray  				= $this->getRequest()->getPost();
					$result					= $this->account->updateAnnouncement($postArray,$id);
					if($result) {
						$sessSuccess = new Zend_Session_Namespace('update-success-announcement');
						$sessSuccess->status = 1;
						$this->_redirect('developer/edit-announcement/aid/'.$this->_getParam('aid'));
					} else {
						$this->view->error = 'Details cannot be updated right now. Kindly try again later';
					}
			}
	      }
	}

	public function searchAction() {
		if(!Zend_Session::namespaceIsset('sess_login')) {
			$this->_redirect('index');
		} else {
			$logSession = new Zend_Session_Namespace('sess_login');
			$search  	= $this->_getParam('search');
			$this->view->search = $search;
			$result     = array();
			$income  	= $this->approval->searchIncomeTransactions($search);
			$expense 	= $this->approval->searchExpenseTransactions($search);
			$invoice 	= $this->approval->searchInvoiceTransactions($search);
			$credit 	= $this->approval->searchCreditTransactions($search);
			$journal 	= $this->approval->searchJournalTransactions($search);
			$customer 	= $this->approval->searchCustomers($search);
			$vendor 	= $this->approval->searchVendors($search);
			$product 	= $this->approval->searchProducts($search);

			if(isset($income) && !empty($income)) {
				foreach ($income as $incomes) {
					$result[$incomes['income_no']]['type'] = 'Income';
					$result[$incomes['income_no']]['act']  = '1';
					$result[$incomes['income_no']]['date'] =  $incomes['date'];
					$result[$incomes['income_no']]['name'] =  $incomes['customer_name'];
					$result[$incomes['income_no']]['id']   =  $incomes['id'];
				}
			}

			if(isset($expense) && !empty($expense)) {
				foreach ($expense as $expenses) {
					$result[$expenses['expense_no']]['type'] = 'Expense';
					$result[$expenses['expense_no']]['act']  = '2';
					$result[$expenses['expense_no']]['date'] =  $expenses['date'];
					$result[$expenses['expense_no']]['name'] =  $expenses['vendor_name'];
					$result[$expenses['expense_no']]['id']   =  $expenses['id'];
				}
			}

			if(isset($invoice) && !empty($invoice)) {
				foreach ($invoice as $invoices) {
					$result[$invoices['invoice_no']]['type'] = 'Invoice';
					$result[$invoices['invoice_no']]['act']  = '3';
					$result[$invoices['invoice_no']]['date'] =  $invoices['date'];
					$result[$invoices['invoice_no']]['name'] =  $invoices['customer_name'];
					$result[$invoices['invoice_no']]['id']   =  $invoices['id'];
				}
			}

			if(isset($credit) && !empty($credit)) {
				foreach ($credit as $credits) {
					$result[$credits['credit_no']]['type'] = 'Credit Note';
					$result[$credits['credit_no']]['act']  = '4';
					$result[$credits['credit_no']]['date'] =  $credits['date'];
					$result[$credits['credit_no']]['name'] =  $credits['customer_name'];
					$result[$credits['credit_no']]['id']   =  $credits['id'];
				}
			}

			if(isset($journal) && !empty($journal)) {
				foreach ($journal as $journals) {
					$result[$journals['journal_no']]['type'] = 'Journal Entry';
					$result[$journals['journal_no']]['act']  = '5';
					$result[$journals['journal_no']]['date'] =  $journals['date'];
					$result[$journals['journal_no']]['name'] =  '';
					$result[$journals['journal_no']]['id']   =  $journals['id'];
				}
			}

			if(isset($customer) && !empty($customer)) {
				foreach ($customer as $customers) {
					$result[$customers['customer_id']]['type'] = 'Customer';
					$result[$customers['customer_id']]['act']  = '6';
					$result[$customers['customer_id']]['date'] =  $customers['date_created'];
					$result[$customers['customer_id']]['name'] =  $customers['customer_name'];
					$result[$customers['customer_id']]['id']   =  $customers['id'];
				}
			}

			if(isset($vendor) && !empty($vendor)) {
				foreach ($vendor as $vendors) {
					$result[$vendors['vendor_id']]['type'] = 'Vendor';
					$result[$vendors['vendor_id']]['act']  = '7';
					$result[$vendors['vendor_id']]['date'] =  $vendors['date_created'];
					$result[$vendors['vendor_id']]['name'] =  $vendors['vendor_name'];
					$result[$vendors['vendor_id']]['id']   =  $vendors['id'];
				}
			}

			if(isset($product) && !empty($product)) {
				foreach ($product as $products) {
					$result[$products['product_id']]['type'] = 'Product';
					$result[$products['product_id']]['act']  = '8';
					$result[$products['product_id']]['date'] =  $products['date_created'];
					$result[$products['product_id']]['name'] =  $products['name'];
					$result[$products['product_id']]['id']   =  $products['id'];
				}
			}
			
			$this->view->result = $result;
			//echo '<pre>'; print_r($result); echo '</pre>';
		}
	}


}

?>