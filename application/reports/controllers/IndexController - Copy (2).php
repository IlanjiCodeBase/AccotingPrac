<?php 
class Reports_IndexController extends Zend_Controller_Action {
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
		$this->report      = new Reports();
		$this->transaction = new Transaction();
		$this->business    = new Business();
		$this->account     = new Account();
		$this->settings    = new Settings();
		$this->approval    = new Approval();
		$this->accountData = new Account_Data();
		if(Zend_Session::namespaceIsset('sess_login')) {
			$logSession = new Zend_Session_Namespace('sess_login');
			if($logSession->type==0 && !isset($logSession->proxy_type)) {
				$this->_redirect('developer');
			}
			if($logSession->type==0 && isset($logSession->proxy_type) && $logSession->proxy_type==4 || $logSession->proxy_type==5) {
				$this->_redirect('index');
			} 
			if($logSession->type==4 || $logSession->type==5) {
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

		}
	}

	public function incomeStatementAction() {
		if(!Zend_Session::namespaceIsset('sess_login')) {
			 $this->_redirect('index');
		} else {
			$incomeType = array();
			$expenseType = array();
			$from = date('Y-01-01');
			$to = date('Y-m-d');
			if($this->_request->isPost()) {
				$postArray  = $this->getRequest()->getPost();
				$from = date('Y-m-d',strtotime($postArray['from_date']));
				$to = date('Y-m-d',strtotime($postArray['to_date']));
			}
			$this->view->from = date('d-m-Y',strtotime($from));
			$this->view->to = date('d-m-Y',strtotime($to));
			//echo $this->convertCurrency(1, "USD");
			$incomeAccount = $this->report->getIncomeAccountIncomes($from,$to);
			$incomeAccountInvoice = $this->report->getIncomeAccountInvoice($from,$to);
			$incomeAccountCredit  = $this->report->getIncomeAccountCredit($from,$to);
			$expenseAccount  = $this->report->getExpenseAccountExpenses($from,$to);
			$this->view->incomeCoa  = $this->transaction->getIncomeAccount();
			$this->view->expenseCoa = $this->transaction->getExpenseAccount();
			$incomeJournalAccount  = $this->report->getIncomeJournalAccount($from,$to);
			$expenseJournalAccount  = $this->report->getExpenseJournalAccount($from,$to);

			if(isset($incomeAccount) && !empty($incomeAccount)) {
				foreach ($incomeAccount as $income) {
					$tax_amount = ($income['amount'] * $income['tax_value'] / 100);
					$total_income = $income['amount'];
					//echo $total_income."<br/>";
					if($income['transaction_currency']!='SGD') {
						$converted_amount = $this->convertCurrency($total_income,$income['transaction_currency']);
						//echo $converted_amount;
					} else {
						$converted_amount = $total_income;
					}
					if(isset($incomeType[$income['fkincome_type']])) {
						$incomeType[$income['fkincome_type']]['credit_amount'] += $converted_amount;
					} else {
						$incomeType[$income['fkincome_type']]['credit_amount'] = 0.00;
						$incomeType[$income['fkincome_type']]['debit_amount'] = 0.00;
						$incomeType[$income['fkincome_type']]['credit_amount'] += $converted_amount;
					}
				}
			}

			if(isset($incomeAccountInvoice) && !empty($incomeAccountInvoice)) {
				foreach ($incomeAccountInvoice as $invoice) {
					$amount = ($invoice['unit_price'] * $invoice['quantity'] - $invoice['discount_amount']);
					$tax_amount = ($amount * $invoice['tax_value'] / 100);
					$total_income = $amount;
					if($invoice['transaction_currency']!='SGD') {
						$converted_amount = $this->convertCurrency($total_income,$invoice['transaction_currency']);
						//echo $converted_amount;
					} else {
						$converted_amount = $total_income;
					}
					if(isset($incomeType[$invoice['fkincomeaccount_id']])) {
						$incomeType[$invoice['fkincomeaccount_id']]['credit_amount'] += $converted_amount;
					} else {
						$incomeType[$invoice['fkincomeaccount_id']]['credit_amount'] = 0.00;
						$incomeType[$invoice['fkincomeaccount_id']]['debit_amount'] = 0.00;
						$incomeType[$invoice['fkincomeaccount_id']]['credit_amount'] += $converted_amount;
					}
				}
			}

			if(isset($incomeAccountCredit) && !empty($incomeAccountCredit)) {
				foreach ($incomeAccountCredit as $credit) {
					$amount = ($credit['unit_price'] * $credit['quantity']);
					$tax_amount = ($amount * $credit['tax_value'] / 100);
					$total_income = $amount;
					if($credit['transaction_currency']!='SGD') {
						$converted_amount = $this->convertCurrency($total_income,$credit['transaction_currency']);
						//echo $converted_amount;
					} else {
						$converted_amount = $total_income;
					}
					if(isset($incomeType[$credit['fkincomeaccount_id']])) {
						$incomeType[$credit['fkincomeaccount_id']]['debit_amount'] += $converted_amount;
					} else {
						$incomeType[$credit['fkincomeaccount_id']]['debit_amount'] = 0.00;
						$incomeType[$credit['fkincomeaccount_id']]['credit_amount'] = 0.00;
						$incomeType[$credit['fkincomeaccount_id']]['debit_amount'] += $converted_amount;
					}
				}
			}

			if(isset($expenseAccount) && !empty($expenseAccount)) {
				foreach ($expenseAccount as $expense) {
					$amount = ($expense['unit_price'] * $expense['quantity']);
					$tax_amount = ($amount * $expense['tax_value'] / 100);
					$total_income = $amount + $tax_amount;
					if($expense['transaction_currency']!='SGD') {
						$converted_amount = $this->convertCurrency($total_income,$expense['transaction_currency']);
						//echo $converted_amount;
					} else {
						$converted_amount = $total_income;
					}
					if(isset($expenseType[$expense['fkexpense_type']])) {
						$expenseType[$expense['fkexpense_type']]['debit_amount'] += $converted_amount;
					} else {
						$expenseType[$expense['fkexpense_type']]['debit_amount'] = 0.00;
						$expenseType[$expense['fkexpense_type']]['credit_amount'] = 0.00;
						$expenseType[$expense['fkexpense_type']]['debit_amount'] += $converted_amount;
					}
				}
			}

			
			if(isset($incomeJournalAccount) && !empty($incomeJournalAccount)) {
				foreach ($incomeJournalAccount as $incomeJournal) {
					if(isset($incomeType[$incomeJournal['fkaccount_id']])) {
						$incomeType[$incomeJournal['fkaccount_id']]['debit_amount'] += $incomeJournal['debit'];
						$incomeType[$incomeJournal['fkaccount_id']]['credit_amount'] += $incomeJournal['credit'];
					} else {
						$incomeType[$incomeJournal['fkaccount_id']]['debit_amount'] = 0.00;
						$incomeType[$incomeJournal['fkaccount_id']]['credit_amount'] = 0.00;
						$incomeType[$incomeJournal['fkaccount_id']]['debit_amount'] += $incomeJournal['debit'];
						$incomeType[$incomeJournal['fkaccount_id']]['credit_amount'] += $incomeJournal['credit'];
					}
				}
			} 

			if(isset($expenseJournalAccount) && !empty($expenseJournalAccount)) {
				foreach ($expenseJournalAccount as $expenseJournal) {
					if(isset($expenseType[$expenseJournal['fkaccount_id']])) {
						$expenseType[$expenseJournal['fkaccount_id']]['debit_amount'] += $expenseJournal['debit'];
						$expenseType[$expenseJournal['fkaccount_id']]['credit_amount'] += $expenseJournal['credit'];
					} else {
						$expenseType[$expenseJournal['fkaccount_id']]['debit_amount'] = 0.00;
						$expenseType[$expenseJournal['fkaccount_id']]['credit_amount'] = 0.00;
						$expenseType[$expenseJournal['fkaccount_id']]['debit_amount'] += $expenseJournal['debit'];
						$expenseType[$expenseJournal['fkaccount_id']]['credit_amount'] += $expenseJournal['credit'];
					}
				}
			} 

			$this->view->incomeAcc  = $incomeType;
			$this->view->expenseAcc = $expenseType;
			//echo '<pre>'; print_r($incomeAccount); echo '</pre>';
			//echo '<pre>'; print_r($incomeAccountInvoice); echo '</pre>';
			//echo '<pre>'; print_r($incomeAccountCredit); echo '</pre>';
			//echo '<pre>'; print_r($expenseAccount); echo '</pre>';
			//echo '<pre>'; print_r($this->view->incomeCoa); echo '</pre>';
			//echo '<pre>'; print_r($this->view->expenseCoa); echo '</pre>';
			//echo '<pre>'; print_r($incomeType); echo '</pre>';
			//echo '<pre>'; print_r($expenseType); echo '</pre>';
			//echo '<pre>'; print_r($incomeJournalAccount); echo '</pre>';
		}
	}

	public function incomeByCustomerAction() {
		if(!Zend_Session::namespaceIsset('sess_login')) {
			 $this->_redirect('index');
		} else {
			$customers = array();
			$from = date('Y-01-01');
			$to = date('Y-m-d');
			if($this->_request->isPost()) {
				$postArray  = $this->getRequest()->getPost();
				$from = date('Y-m-d',strtotime($postArray['from_date']));
				$to = date('Y-m-d',strtotime($postArray['to_date']));
			}
			$this->view->from = date('d-m-Y',strtotime($from));
			$this->view->to = date('d-m-Y',strtotime($to));

			$incomeAccountCustomer = $this->report->getIncomeAccountIncomesCustomer($from,$to);
			$incomeAccountInvoiceCustomer = $this->report->getIncomeAccountInvoiceCustomer($from,$to);
			$incomeAccountCreditCustomer  = $this->report->getIncomeAccountCreditCustomer($from,$to);
			$this->view->customerList  = $this->business->getCustomers();

			if(isset($incomeAccountCustomer) && !empty($incomeAccountCustomer)) {
				foreach ($incomeAccountCustomer as $income) {
					$tax_amount = ($income['amount'] * $income['tax_value'] / 100);
					$total_income = $income['amount'] - $tax_amount;
					//echo $total_income."<br/>";
					if($income['transaction_currency']!='SGD') {
						$converted_amount = $this->convertCurrency($total_income,$income['transaction_currency']);
						//echo $converted_amount;
					} else {
						$converted_amount = $total_income;
					}
					if(isset($customers[$income['fkcustomer_id']])) {
						$customers[$income['fkcustomer_id']] += $converted_amount;
					} else {
						$customers[$income['fkcustomer_id']] = 0.00;
						$customers[$income['fkcustomer_id']] += $converted_amount;
					}
				}
			}

			if(isset($incomeAccountInvoiceCustomer) && !empty($incomeAccountInvoiceCustomer)) {
				foreach ($incomeAccountInvoiceCustomer as $invoice) {
					$amount = ($invoice['unit_price'] * $invoice['quantity'] - $invoice['discount_amount']);
					$tax_amount = ($amount * $invoice['tax_value'] / 100);
					$total_income = $amount - $tax_amount;
					if($invoice['transaction_currency']!='SGD') {
						$converted_amount = $this->convertCurrency($total_income,$invoice['transaction_currency']);
						//echo $converted_amount;
					} else {
						$converted_amount = $total_income;
					}
					if(isset($customers[$invoice['fkcustomer_id']])) {
						$customers[$invoice['fkcustomer_id']] += $converted_amount;
					} else {
						$customers[$invoice['fkcustomer_id']] = 0.00;
						$customers[$invoice['fkcustomer_id']] += $converted_amount;
					}
				}
			}

			if(isset($incomeAccountCreditCustomer) && !empty($incomeAccountCreditCustomer)) {
				foreach ($incomeAccountCreditCustomer as $credit) {
					$amount = ($credit['unit_price'] * $credit['quantity']);
					$tax_amount = ($amount * $credit['tax_value'] / 100);
					$total_income = $amount - $tax_amount;
					if($credit['transaction_currency']!='SGD') {
						$converted_amount = $this->convertCurrency($total_income,$credit['transaction_currency']);
						//echo $converted_amount;
					} else {
						$converted_amount = $total_income;
					}
					if(isset($customers[$credit['fkcustomer_id']])) {
						$customers[$credit['fkcustomer_id']] += $converted_amount;
					} else {
						$customers[$credit['fkcustomer_id']] = 0.00;
						$customers[$credit['fkcustomer_id']] += $converted_amount;
					}
				}
			}
			$this->view->customers = $customers;
			//echo '<pre>'; print_r($incomeAccountCustomer); echo '</pre>';
			//echo '<pre>'; print_r($incomeAccountInvoiceCustomer); echo '</pre>';
			//echo '<pre>'; print_r($incomeAccountCreditCustomer); echo '</pre>';
			//echo '<pre>'; print_r($this->view->customerList); echo '</pre>';
			//echo '<pre>'; print_r($this->view->customers); echo '</pre>';
		}
	}

	public function expenseByVendorAction() {
		if(!Zend_Session::namespaceIsset('sess_login')) {
			 $this->_redirect('index');
		} else {
			$vendors = array();
			$from = date('Y-01-01');
			$to = date('Y-m-d');
			if($this->_request->isPost()) {
				$postArray  = $this->getRequest()->getPost();
				$from = date('Y-m-d',strtotime($postArray['from_date']));
				$to = date('Y-m-d',strtotime($postArray['to_date']));
			}
			$this->view->from = date('d-m-Y',strtotime($from));
			$this->view->to = date('d-m-Y',strtotime($to));

			$expenseAccountVendor  = $this->report->getExpenseAccountExpensesVendor($from,$to);
			$this->view->vendorList  = $this->business->getVendors();

			if(isset($expenseAccountVendor) && !empty($expenseAccountVendor)) {
				foreach ($expenseAccountVendor as $expense) {
					$amount = ($expense['unit_price'] * $expense['quantity']);
					$tax_amount = ($amount * $expense['tax_value'] / 100);
					$total_income = $amount - $tax_amount;
					if($expense['transaction_currency']!='SGD') {
						$converted_amount = $this->convertCurrency($total_income,$expense['transaction_currency']);
						//echo $converted_amount;
					} else {
						$converted_amount = $total_income;
					}
					if(isset($vendors[$expense['fkvendor_id']])) {
						$vendors[$expense['fkvendor_id']] += $converted_amount;
					} else {
						$vendors[$expense['fkvendor_id']] = 0.00;
						$vendors[$expense['fkvendor_id']] += $converted_amount;
					}
				}
			}
			
			$this->view->vendors = $vendors;
			//echo '<pre>'; print_r($expenseAccountVendor); echo '</pre>';
			//echo '<pre>'; print_r($vendors); echo '</pre>';
		}
	}

	public function accountReceivablesAction() {
		if(!Zend_Session::namespaceIsset('sess_login')) {
			 $this->_redirect('index');
		} else {
			$incomeReceivable = array();
			$from = date('Y-01-01');
			$to = date('Y-m-d');
			if($this->_request->isPost()) {
				$postArray  = $this->getRequest()->getPost();
				$from = date('Y-m-d',strtotime($postArray['from_date']));
				$to = date('Y-m-d',strtotime($postArray['to_date']));
			}
			$this->view->from = date('d-m-Y',strtotime($from));
			$this->view->to = date('d-m-Y',strtotime($to));
			$getAccountArray            =  $this->accountData->getData(array('creditTermArray'));
			$this->view->creditTerm     =  $getAccountArray['creditTermArray'];
			$incomeAccountReceivable = $this->report->getIncomeAccountReceivables($from,$to);
			$incomeAccountCash = $this->report->getIncomeAccountCash();
			$incomeAccountInvoiceReceivable = $this->report->getIncomeAccountInvoiceReceivables($from,$to);
			$incomeAccountInvoiceCash = $this->report->getIncomeAccountInvoiceCash();

			foreach ($incomeAccountReceivable as $incomeReceive) {
					if($incomeReceive['transaction_currency']!='SGD') {
						$converted_pending_amount = $this->convertCurrency($incomeReceive['amount'],$incomeReceive['transaction_currency']);
					} else {
						$converted_pending_amount = $incomeReceive['amount'];
					}
					$inc_date = $incomeReceive['inc_date'];
					$days     = $this->view->creditTerm[$incomeReceive['credit_term']];
					$due_date = date('Y-m-d', strtotime("$inc_date +$days day")); 
					$incomeReceivable[$incomeReceive['income_no']] = array('due_date' => $due_date,'amount' => $incomeReceive['amount'],'currency' => $incomeReceive['transaction_currency'],'paid' => '0.00','pending' => $converted_pending_amount);
			}

			foreach ($incomeAccountCash as $incomeCash) {
				if(array_key_exists($incomeCash['income_no'], $incomeReceivable)) {
					$incomeReceivable[$incomeCash['income_no']]['paid'] += $incomeCash['amount'];
					$totalAmount = $incomeReceivable[$incomeCash['income_no']]['amount'] - $incomeReceivable[$incomeCash['income_no']]['paid'];
					if($incomeReceivable[$incomeCash['income_no']]['currency']!='SGD') {
						$converted_amount = $this->convertCurrency($totalAmount,$incomeReceivable[$incomeCash['income_no']]['currency']);
					} else {
						$converted_amount = $totalAmount;
					}
					$incomeReceivable[$incomeCash['income_no']]['pending']  = $converted_amount;
				}
			}

			foreach ($incomeAccountInvoiceReceivable as $incomeInvoiceReceive) {
				if($incomeInvoiceReceive['transaction_currency']!='SGD') {
					$converted_pending_amount = $this->convertCurrency($incomeInvoiceReceive['amount'],$incomeInvoiceReceive['transaction_currency']);
				} else {
					$converted_pending_amount = $incomeInvoiceReceive['amount'];
				}
				$incomeReceivable[$incomeInvoiceReceive['invoice_no']] = array('due_date' => $incomeInvoiceReceive['due_date'],'amount' => $incomeInvoiceReceive['amount'],'currency' => $incomeInvoiceReceive['transaction_currency'],'paid' => '0.00','pending' => $converted_pending_amount);
			}

			foreach ($incomeAccountInvoiceCash as $incomeInvoiceCash) {
				if(array_key_exists($incomeInvoiceCash['invoice_no'], $incomeReceivable)) {
					$incomeReceivable[$incomeInvoiceCash['invoice_no']]['paid'] += $incomeInvoiceCash['amount'];
					$totalAmount = $incomeReceivable[$incomeInvoiceCash['invoice_no']]['amount'] - $incomeReceivable[$incomeInvoiceCash['invoice_no']]['paid'];
					if($incomeReceivable[$incomeInvoiceCash['invoice_no']]['currency']!='SGD') {
						$converted_amount = $this->convertCurrency($totalAmount,$incomeReceivable[$incomeInvoiceCash['invoice_no']]['currency']);
					} else {
						$converted_amount = $totalAmount;
					}
					$incomeReceivable[$incomeInvoiceCash['invoice_no']]['pending']  = $converted_amount;
				}
			}

			$this->view->accountReceivables = $incomeReceivable;
			
			//echo '<pre>'; print_r($incomeAccountReceivable); echo '</pre>';
			//echo '<pre>'; print_r($incomeAccountCash); echo '</pre>';
			//echo '<pre>'; print_r($incomeAccountInvoiceReceivable); echo '</pre>';
			//echo '<pre>'; print_r($incomeAccountInvoiceCash); echo '</pre>';
			//echo '<pre>'; print_r($incomeReceivable); echo '</pre>';
		}
	}

	public function accountPayablesAction() {
		if(!Zend_Session::namespaceIsset('sess_login')) {
			 $this->_redirect('index');
		} else {
			$expensePayable = array();
			$from = date('Y-01-01');
			$to = date('Y-m-d');
			if($this->_request->isPost()) {
				$postArray  = $this->getRequest()->getPost();
				$from = date('Y-m-d',strtotime($postArray['from_date']));
				$to = date('Y-m-d',strtotime($postArray['to_date']));
			}
			$this->view->from = date('d-m-Y',strtotime($from));
			$this->view->to = date('d-m-Y',strtotime($to));
			$getAccountArray            =  $this->accountData->getData(array('creditTermArray'));
			$this->view->creditTerm     =  $getAccountArray['creditTermArray'];
			$expenseAccountPayable = $this->report->getExpenseAccountPayables($from,$to);
			$expenseAccountCash = $this->report->getExpenseAccountCash();
     		
			foreach ($expenseAccountPayable as $expensePay) {
					if($expensePay['transaction_currency']!='SGD') {
						$converted_pending_amount = $this->convertCurrency($expensePay['amount'],$expensePay['transaction_currency']);
					} else {
						$converted_pending_amount = $expensePay['amount'];
					}
					$expensePayable[$expensePay['expense_no']] = array('due_date' => $expensePay['due_date'],'amount' => $expensePay['amount'],'currency' => $expensePay['transaction_currency'],'paid' => '0.00','pending' => $converted_pending_amount);
			}

			foreach ($expenseAccountCash as $expenseCash) {
				if(array_key_exists($expenseCash['expense_no'], $expensePayable)) {
					$expensePayable[$expenseCash['expense_no']]['paid'] += $expenseCash['amount'];
					$totalAmount = $expensePayable[$expenseCash['expense_no']]['amount'] - $expensePayable[$expenseCash['expense_no']]['paid'];
					if($expensePayable[$expenseCash['expense_no']]['currency']!='SGD') {
						$converted_amount = $this->convertCurrency($totalAmount,$expensePayable[$expenseCash['expense_no']]['currency']);
					} else {
						$converted_amount = $totalAmount;
					}
					$expensePayable[$expenseCash['expense_no']]['pending']  = $converted_amount;
				} 
			}


			$this->view->accountPayables = $expensePayable;
			
/*			echo '<pre>'; print_r($expenseAccountPayable); echo '</pre>';
			echo '<pre>'; print_r($expenseAccountCash); echo '</pre>';
			echo '<pre>'; print_r($expensePayable); echo '</pre>';*/
		}
	}

	public function cashflowAction() {
		if(!Zend_Session::namespaceIsset('sess_login')) {
			 $this->_redirect('index');
		} else {
			$incomeReceivable = array();
			$from = date('Y-01-01');
			$to = date('Y-m-d');
			if($this->_request->isPost()) {
				$postArray  = $this->getRequest()->getPost();
				$from = date('Y-m-d',strtotime($postArray['from_date']));
				$to = date('Y-m-d',strtotime($postArray['to_date']));
			}
			$this->view->from = date('d-m-Y',strtotime($from));
			$this->view->to = date('d-m-Y',strtotime($to));
			$getAccountArray            =  $this->accountData->getData(array('creditTermArray'));
			$this->view->creditTerm     =  $getAccountArray['creditTermArray'];
			$incomeCash 				=  $this->report->getCashFlowIncome($from,$to);
			echo '<pre>'; print_r($incomeCash); echo '</pre>';
		}
	}


	public function balanceSheetCopyAction() {
		if(!Zend_Session::namespaceIsset('sess_login')) {
		            $this->_redirect('index');
		      } else {

		      	$balanceSheet = array();
				$from = date('Y-01-01');
				$to = date('Y-m-d');
				if($this->_request->isPost()) {
					$postArray  = $this->getRequest()->getPost();
					$from = date('Y-m-d',strtotime($postArray['from_date']));
					$to = date('Y-m-d',strtotime($postArray['to_date']));
				}
				$this->view->from = date('d-m-Y',strtotime($from));
				$this->view->to = date('d-m-Y',strtotime($to));

		      	$logSession = new Zend_Session_Namespace('sess_login');
				if(isset($logSession->proxy_cid) && !empty($logSession->proxy_cid)) {
					$cid = $logSession->proxy_cid;
				} else {
					$cid = $logSession->cid;
				}
		      	$this->json    =  "..".$this->uploadPath.$cid."/accounts.json";
		      	$asset     = array();
		      	$liability = array();
		      	$equity    = array();
		      	$phpNative = Zend_Json::decode(file_get_contents($this->json));
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
		      	$this->view->equity    = $equity;
		      	
		      	$logSession = new Zend_Session_Namespace('sess_login');
		      	
				$getAccountArray        =  $this->accountData->getData(array('accountArray'));
				$this->view->account    =  $getAccountArray['accountArray'];

				$this->view->getAccount	=  $this->settings->getAccounts();
				$this->incomePayments   =  $this->report->getIncomePaymentAccounts($from,$to);
				$this->expensePayments  =  $this->report->getExpensePaymentAccounts($from,$to);
				$this->invoicePayments  =  $this->report->getInvoicePaymentAccounts($from,$to);

				foreach ($this->incomePayments as $incPayment) {
					$amount = $incPayment['payment_amount'];
					if($incPayment['transaction_currency']!='SGD') {
						$converted_amount = $this->convertCurrency($amount,$incPayment['transaction_currency']);
					} else {
						$converted_amount = $amount;
					}
					if(isset($balanceSheet[$incPayment['fkpayment_account']])) {
						$balanceSheet[$incPayment['fkpayment_account']] += $converted_amount;
					} else {
						$balanceSheet[$incPayment['fkpayment_account']] = 0.00;
						$balanceSheet[$incPayment['fkpayment_account']] += $converted_amount;
					}
				}
				foreach ($this->expensePayments as $expPayment) {
					$amount = $expPayment['payment_amount'];
					if($expPayment['transaction_currency']!='SGD') {
						$converted_amount = $this->convertCurrency($amount,$expPayment['transaction_currency']);
					} else {
						$converted_amount = $amount;
					}
					if(isset($balanceSheet[$expPayment['fkpayment_account']])) {
						$balanceSheet[$expPayment['fkpayment_account']] -= $converted_amount;
					} else {
						$balanceSheet[$expPayment['fkpayment_account']] = 0.00;
						$balanceSheet[$expPayment['fkpayment_account']] -= $converted_amount;
					}
				}
				foreach ($this->invoicePayments as $invPayment) {
					$amount = $invPayment['payment_amount'];
					if($invPayment['transaction_currency']!='SGD') {
						$converted_amount = $this->convertCurrency($amount,$invPayment['transaction_currency']);
					} else {
						$converted_amount = $amount;
					}
					if(isset($balanceSheet[$invPayment['fkpayment_account']])) {
						$balanceSheet[$invPayment['fkpayment_account']] += $converted_amount;
					} else {
						$balanceSheet[$invPayment['fkpayment_account']] = 0.00;
						$balanceSheet[$invPayment['fkpayment_account']] += $converted_amount;
					}
				}

				$this->view->paymentAccount = $balanceSheet;

				//echo '<pre>'; print_r($this->incomePayments); echo '</pre>';
				//echo '<pre>'; print_r($this->expensePayments); echo '</pre>';
				//echo '<pre>'; print_r($this->invoicePayments); echo '</pre>';
				//echo '<pre>'; print_r($balanceSheet); echo '</pre>';

			  }
	}

	public function balanceSheetAction() {
		if(!Zend_Session::namespaceIsset('sess_login')) {
		            $this->_redirect('index');
		      } else {

		      	$balanceSheet = array();
				$accountId      = array();
				$from = date('Y-01-01');
				$to = date('Y-m-d');
				if($this->_request->isPost()) {
					$postArray  = $this->getRequest()->getPost();
					$from = date('Y-m-d',strtotime($postArray['from_date']));
					$to = date('Y-m-d',strtotime($postArray['to_date']));
				}
				$this->view->from = date('d-m-Y',strtotime($from));
				$this->view->to = date('d-m-Y',strtotime($to));

		      	$logSession = new Zend_Session_Namespace('sess_login');
				if(isset($logSession->proxy_cid) && !empty($logSession->proxy_cid)) {
					$cid = $logSession->proxy_cid;
				} else {
					$cid = $logSession->cid;
				}
		      	$this->json    =  "..".$this->uploadPath.$cid."/accounts.json";
		      	$asset     = array();
		      	$liability = array();
		      	$equity    = array();
		      	$phpNative = Zend_Json::decode(file_get_contents($this->json));
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
		      	$this->view->equity    = $equity;
		      	
		      	$logSession = new Zend_Session_Namespace('sess_login');
		      	
				$getAccountArray        =  $this->accountData->getData(array('accountArray'));
				$this->view->account    =  $getAccountArray['accountArray'];

				$this->view->getAccount	=  $this->settings->getAccounts();
				/*$this->incomePayments   =  $this->report->getIncomePaymentAccounts($from,$to);
				$this->expensePayments  =  $this->report->getExpensePaymentAccounts($from,$to);
				$this->invoicePayments  =  $this->report->getInvoicePaymentAccounts($from,$to);

				foreach ($this->incomePayments as $incPayment) {
					$amount = $incPayment['payment_amount'];
					if($incPayment['transaction_currency']!='SGD') {
						$converted_amount = $this->convertCurrency($amount,$incPayment['transaction_currency']);
					} else {
						$converted_amount = $amount;
					}
					if(isset($balanceSheet[$incPayment['fkpayment_account']])) {
						$balanceSheet[$incPayment['fkpayment_account']] += $converted_amount;
					} else {
						$balanceSheet[$incPayment['fkpayment_account']] = 0.00;
						$balanceSheet[$incPayment['fkpayment_account']] += $converted_amount;
					}
				}
				foreach ($this->expensePayments as $expPayment) {
					$amount = $expPayment['payment_amount'];
					if($expPayment['transaction_currency']!='SGD') {
						$converted_amount = $this->convertCurrency($amount,$expPayment['transaction_currency']);
					} else {
						$converted_amount = $amount;
					}
					if(isset($balanceSheet[$expPayment['fkpayment_account']])) {
						$balanceSheet[$expPayment['fkpayment_account']] -= $converted_amount;
					} else {
						$balanceSheet[$expPayment['fkpayment_account']] = 0.00;
						$balanceSheet[$expPayment['fkpayment_account']] -= $converted_amount;
					}
				}
				foreach ($this->invoicePayments as $invPayment) {
					$amount = $invPayment['payment_amount'];
					if($invPayment['transaction_currency']!='SGD') {
						$converted_amount = $this->convertCurrency($amount,$invPayment['transaction_currency']);
					} else {
						$converted_amount = $amount;
					}
					if(isset($balanceSheet[$invPayment['fkpayment_account']])) {
						$balanceSheet[$invPayment['fkpayment_account']] += $converted_amount;
					} else {
						$balanceSheet[$invPayment['fkpayment_account']] = 0.00;
						$balanceSheet[$invPayment['fkpayment_account']] += $converted_amount;
					}
				}

				$this->view->paymentAccount = $balanceSheet;*/


			$incomeAccountIncome  = $this->report->getGeneralIncomeAccount($from,$to);
			$incomeAccountInvoice = $this->report->getGeneralInvoiceIncomeAccount($from,$to);
			$incomeAccountCredit  = $this->report->getGeneralCreditAccount($from,$to);
			$expenseAccount  = $this->report->getGeneralExpenseAccount($from,$to);
			$journalAccount  = $this->report->getGeneralJournalAccount($from,$to);

			$incomeAccountIncomePay  = $this->report->getGeneralIncomePayAccount($from,$to);
			$expenseAccountPay  =  $this->report->getExpensePayAccounts($from,$to);
			$incomeAccountInvoicePay  =  $this->report->getInvoicePayAccounts($from,$to);

			$incomeAccountEntry = $this->report->getAccountingEntriesIncome($from,$to);
			$expenseAccountEntry = $this->report->getAccountingEntriesExpense($from,$to);
			$invoiceAccountEntry = $this->report->getAccountingEntriesInvoice($from,$to);
			$creditAccountEntry = $this->report->getAccountingEntriesCredit($from,$to);

			$accountId['income'][] = 'NULL';
			if(isset($incomeAccountIncome) && !empty($incomeAccountIncome)) {
				foreach ($incomeAccountIncome as $income) {
					$accountId['income'][] = $income['inc_id'];
					$tax_amount = ($income['amount'] * $income['tax_value'] / 100);
					$total_income = $income['amount'];
					if($income['transaction_currency']!='SGD') {
						$converted_amount = $this->convertCurrency($total_income,$income['transaction_currency']);
					} else {
						$converted_amount = $total_income;
					}
					if(isset($balanceSheet[$income['fkincome_type']])) {
						$balanceSheet[$income['fkincome_type']]['credit_amount'] += $converted_amount;
						//$generalLedger[$income['fkincome_type']]['debit_amount'] = 0.00;
					} else {
						$balanceSheet[$income['fkincome_type']]['credit_amount'] = 0.00;
						$balanceSheet[$income['fkincome_type']]['debit_amount'] = 0.00;
						$balanceSheet[$income['fkincome_type']]['credit_amount'] += $converted_amount;
					}
				}
			}
			$accountId['invoice'][] = 'NULL';
			if(isset($incomeAccountInvoice) && !empty($incomeAccountInvoice)) {
				foreach ($incomeAccountInvoice as $invoice) {
					$accountId['invoice'][] = $invoice['inv_id'];
					$amount = ($invoice['unit_price'] * $invoice['quantity'] - $invoice['discount_amount']);
					$tax_amount = ($amount * $invoice['tax_value'] / 100);
					$total_income = $amount;
					if($invoice['transaction_currency']!='SGD') {
						$converted_amount = $this->convertCurrency($total_income,$invoice['transaction_currency']);
					} else {
						$converted_amount = $total_income;
					}
					if(isset($balanceSheet[$invoice['fkincomeaccount_id']])) {
						$balanceSheet[$invoice['fkincomeaccount_id']]['credit_amount'] += $converted_amount;
						//$generalLedger[$invoice['fkincomeaccount_id']]['debit_amount'] = 0.00;
					} else {
						$balanceSheet[$invoice['fkincomeaccount_id']]['credit_amount'] = 0.00;
						$balanceSheet[$invoice['fkincomeaccount_id']]['debit_amount'] = 0.00;
						$balanceSheet[$invoice['fkincomeaccount_id']]['credit_amount'] += $converted_amount;
					}
				}
			}

			if(isset($incomeAccountCredit) && !empty($incomeAccountCredit)) {
				foreach ($incomeAccountCredit as $credit) {
					$amount = ($credit['unit_price'] * $credit['quantity']);
					$tax_amount = ($amount * $credit['tax_value'] / 100);
					$total_income = $amount;
					if($credit['transaction_currency']!='SGD') {
						$converted_amount = $this->convertCurrency($total_income,$credit['transaction_currency']);
					} else {
						$converted_amount = $total_income;
					}
					//echo '<br/>'.$converted_amount;
					if(isset($balanceSheet[$credit['fkincomeaccount_id']])) {
						$balanceSheet[$credit['fkincomeaccount_id']]['debit_amount'] += $converted_amount;
						//$generalLedger[$credit['fkincomeaccount_id']]['credit_amount'] = 0.00;
					} else {
						$balanceSheet[$credit['fkincomeaccount_id']]['credit_amount'] = 0.00;
						$balanceSheet[$credit['fkincomeaccount_id']]['debit_amount'] = 0.00;
						$balanceSheet[$credit['fkincomeaccount_id']]['debit_amount'] += $converted_amount;
					}
				}
			}

			$accountId['expense'][] = 'NULL';
			if(isset($expenseAccount) && !empty($expenseAccount)) {
				foreach ($expenseAccount as $expense) {
					$accountId['expense'][] = $expense['exp_id'];
					$amount = ($expense['unit_price'] * $expense['quantity']);
					$tax_amount = ($amount * $expense['tax_value'] / 100);
					$total_income = $amount + $tax_amount;
					if($expense['transaction_currency']!='SGD') {
						$converted_amount = $this->convertCurrency($total_income,$expense['transaction_currency']);
					} else {
						$converted_amount = $total_income;
					}
					if(isset($balanceSheet[$expense['fkexpense_type']])) {
						$balanceSheet[$expense['fkexpense_type']]['debit_amount'] += $converted_amount;
						//$generalLedger[$expense['fkexpense_type']]['credit_amount'] = 0.00;
					} else {
						$balanceSheet[$expense['fkexpense_type']]['debit_amount'] = 0.00;
						$balanceSheet[$expense['fkexpense_type']]['credit_amount'] = 0.00;
						$balanceSheet[$expense['fkexpense_type']]['debit_amount'] += $converted_amount;
					}
				}
			}

			$accountId['income_pay'][] = 'NULL';
			$accountId['income_paid'][] = 'NULL';
			if(isset($incomeAccountIncomePay) && !empty($incomeAccountIncomePay)) {
				foreach ($incomeAccountIncomePay as $incPayment) {
						$accountId['income_pay'][] = $incPayment['inc_id'];
						$amount = $incPayment['payment_amount'];
						if($incPayment['transaction_currency']!='SGD') {
							$converted_amount = $this->convertCurrency($amount,$incPayment['transaction_currency']);
						} else {
							$converted_amount = $amount;
						}
						if(isset($accountId['income_paid'][$incPayment['inc_id']])) {
							$accountId['income_paid'][$incPayment['inc_id']] += $converted_amount;
						} else {
							$accountId['income_paid'][$incPayment['inc_id']] = 0.0;
							$accountId['income_paid'][$incPayment['inc_id']] += $converted_amount;
						}
						if(isset($balanceSheet[$incPayment['fkpayment_account']])) {
							$balanceSheet[$incPayment['fkpayment_account']]['debit_amount'] += $converted_amount;
							//$generalLedger[$incPayment['fkpayment_account']]['credit_amount'] += 0.00;
						} else {
							$balanceSheet[$incPayment['fkpayment_account']]['debit_amount'] = 0.00;
							$balanceSheet[$incPayment['fkpayment_account']]['credit_amount'] = 0.00;
							$balanceSheet[$incPayment['fkpayment_account']]['debit_amount'] += $converted_amount;
						}
				}
			}

			$accountId['expense_pay'][] = 'NULL';
			$accountId['expense_paid'][] = 'NULL';
			if(isset($expenseAccountPay) && !empty($expenseAccountPay)) {
				foreach ($expenseAccountPay as $expPayment) {
						$accountId['expense_pay'][] = $expPayment['exp_id'];
						$amount = $expPayment['payment_amount'];
						if($expPayment['transaction_currency']!='SGD') {
							$converted_amount = $this->convertCurrency($amount,$expPayment['transaction_currency']);
						} else {
							$converted_amount = $amount;
						}
						if(isset($accountId['expense_paid'][$expPayment['exp_id']])) {
							$accountId['expense_paid'][$expPayment['exp_id']] += $converted_amount;
						} else {
							$accountId['expense_paid'][$expPayment['exp_id']] = 0.0;
							$accountId['expense_paid'][$expPayment['exp_id']] += $converted_amount;
						}
						if(isset($balanceSheet[$expPayment['fkpayment_account']])) {
							$balanceSheet[$expPayment['fkpayment_account']]['credit_amount'] += $converted_amount;
							//$generalLedger[$expPayment['fkpayment_account']]['debit_amount'] += 0.00;
						} else {
							$balanceSheet[$expPayment['fkpayment_account']]['credit_amount'] = 0.00;
							$balanceSheet[$expPayment['fkpayment_account']]['debit_amount'] = 0.00;
							$balanceSheet[$expPayment['fkpayment_account']]['credit_amount'] += $converted_amount;
						}
					}
			}

			$accountId['invoice_pay'][] = 'NULL';
			$accountId['invoice_paid'][] = 'NULL';
			if(isset($incomeAccountInvoicePay) && !empty($incomeAccountInvoicePay)) {
				foreach ($incomeAccountInvoicePay as $invPayment) {
						$accountId['invoice_pay'][] = $invPayment['inv_id'];
						$amount = $invPayment['payment_amount'];
						if($invPayment['transaction_currency']!='SGD') {
							$converted_amount = $this->convertCurrency($amount,$invPayment['transaction_currency']);
						} else {
							$converted_amount = $amount;
						}
						if(isset($accountId['invoice_paid'][$invPayment['inv_id']])) {
							$accountId['invoice_paid'][$invPayment['inv_id']] += $converted_amount;
						} else {
							$accountId['invoice_paid'][$invPayment['inv_id']] = 0.0;
							$accountId['invoice_paid'][$invPayment['inv_id']] += $converted_amount;
						}
						if(isset($balanceSheet[$invPayment['fkpayment_account']])) {
							$balanceSheet[$invPayment['fkpayment_account']]['debit_amount'] += $converted_amount;
							//$generalLedger[$invPayment['fkpayment_account']]['credit_amount'] += 0.00;
						} else {
							$balanceSheet[$invPayment['fkpayment_account']]['debit_amount'] = 0.00;
							$balanceSheet[$invPayment['fkpayment_account']]['credit_amount'] = 0.00;
							$balanceSheet[$invPayment['fkpayment_account']]['debit_amount'] += $converted_amount;
						}
					}
			}


			if(isset($journalAccount) && !empty($journalAccount)) {
				foreach ($journalAccount as $journal) {
					if(isset($balanceSheet[$journal['fkaccount_id']])) {
						$balanceSheet[$journal['fkaccount_id']]['debit_amount'] += $journal['debit'];
						$balanceSheet[$journal['fkaccount_id']]['credit_amount'] += $journal['credit'];
					} else {
						$balanceSheet[$journal['fkaccount_id']]['debit_amount'] = 0.00;
						$balanceSheet[$journal['fkaccount_id']]['credit_amount'] = 0.00;
						$balanceSheet[$journal['fkaccount_id']]['debit_amount'] += $journal['debit'];
						$balanceSheet[$journal['fkaccount_id']]['credit_amount'] += $journal['credit'];
					}
				}
			}

			$balanceSheet['accountReceivables']['debit_amount'] = 0.00;
			$balanceSheet['accountReceivables']['credit_amount'] = 0.00;
			$balanceSheet['accountPayables']['debit_amount'] = 0.00;
			$balanceSheet['accountPayables']['credit_amount'] = 0.00;
		//	$generalLedger['cash']['debit_amount'] = 0.00;
		//	$generalLedger['cash']['credit_amount'] = 0.00;
			$balanceSheet['gstPayables']['debit_amount'] = 0.00;
			$balanceSheet['gstPayables']['credit_amount'] = 0.00;
		//	$generalLedger['sales']['debit_amount'] = 0.00;
		//	$generalLedger['sales']['credit_amount'] = 0.00;

			/* if(isset($incomeAccountEntry) && !empty($incomeAccountEntry)) {
				foreach ($incomeAccountEntry as $incomeEntry) {
						$amount = $incomeEntry['amount'];
						if($incomeEntry['transaction_currency']!='SGD') {
							$converted_amount = $this->convertCurrency($amount,$incomeEntry['transaction_currency']);
						} else {
							$converted_amount = $amount;
						}
					if((!in_array($incomeEntry['inc_id'], $accountId['income']))) {
						if(($incomeEntry['account_entry_id']==3) && (in_array($incomeEntry['inc_id'], $accountId['income_pay'])) && (isset($accountId['income_paid'][$incomeEntry['inc_id']]))) {
							$balanceSheet['accountReceivables']['credit_amount'] += $accountId['income_paid'][$incomeEntry['inc_id']];
						} 
					} else {
						if($incomeEntry['account_entry_id']==1) {
							$balanceSheet['accountReceivables']['debit_amount'] += $converted_amount;
							
						} else if($incomeEntry['account_entry_id']==3) {
								$balanceSheet['accountReceivables']['credit_amount'] += $converted_amount;
							
						} else if($incomeEntry['account_entry_id']==4) {
								$balanceSheet['gstPayables']['credit_amount'] += $converted_amount;
						}	
					}
				}
			}

			if(isset($expenseAccountEntry) && !empty($expenseAccountEntry)) {
				foreach ($expenseAccountEntry as $expenseEntry) {
					$amount = $expenseEntry['amount'];
					if($expenseEntry['transaction_currency']!='SGD') {
						$converted_amount = $this->convertCurrency($amount,$expenseEntry['transaction_currency']);
					} else {
						$converted_amount = $amount;
					}
					if((!in_array($expenseEntry['exp_id'], $accountId['expense']))) {
						if(($expenseEntry['account_entry_id']==3) && (in_array($expenseEntry['exp_id'], $accountId['expense_pay'])) && isset($accountId['expense_paid'][$expenseEntry['exp_id']])) {
							$balanceSheet['accountPayables']['debit_amount'] += $accountId['expense_paid'][$expenseEntry['exp_id']];
						} 
					} else {
						if($expenseEntry['account_entry_id']==2) {
								$balanceSheet['accountPayables']['credit_amount'] += $converted_amount;
						} else if($expenseEntry['account_entry_id']==3) {
								$balanceSheet['accountPayables']['debit_amount'] += $converted_amount;
							
						} 	
					}
				}
			}

			if(isset($invoiceAccountEntry) && !empty($invoiceAccountEntry)) {
				foreach ($invoiceAccountEntry as $invoiceEntry) {
					$amount = $invoiceEntry['amount'];
					if($invoiceEntry['transaction_currency']!='SGD') {
						$converted_amount = $this->convertCurrency($amount,$invoiceEntry['transaction_currency']);
					} else {
						$converted_amount = $amount;
					}
					if((!in_array($invoiceEntry['inv_id'], $accountId['invoice']))) {
						if(($invoiceEntry['account_entry_id']==3) && (in_array($invoiceEntry['inv_id'], $accountId['invoice_pay'])) && (isset($accountId['invoice_paid'][$invoiceEntry['inv_id']]))) {
							$balanceSheet['accountReceivables']['credit_amount'] += $accountId['invoice_paid'][$invoiceEntry['inv_id']];
						} 
					} else {
						if($invoiceEntry['account_entry_id']==1) {
							$balanceSheet['accountReceivables']['debit_amount'] += $converted_amount;
							
						} else if($invoiceEntry['account_entry_id']==3) {
								$balanceSheet['accountReceivables']['credit_amount'] += $converted_amount;
							
						} else if($invoiceEntry['account_entry_id']==4) {
								$balanceSheet['gstPayables']['credit_amount'] += $converted_amount;
						}
					}	
				}
			} */

			if(isset($incomeAccountEntry) && !empty($incomeAccountEntry)) {
				foreach ($incomeAccountEntry as $incomeEntry) {
					//echo $incomeEntry['inc_id'];
						$amount = $incomeEntry['amount'];
						if($incomeEntry['transaction_currency']!='SGD') {
							$converted_amount = $this->convertCurrency($amount,$incomeEntry['transaction_currency']);
						} else {
							$converted_amount = $amount;
						}
					//if((!in_array($incomeEntry['inc_id'], $accountId['income']))) {
					//	if(($incomeEntry['account_entry_id']==3) && (in_array($incomeEntry['inc_id'], $accountId['income_pay'])) && (isset($accountId['income_paid'][$incomeEntry['inc_id']]))) {
					  if(($incomeEntry['account_entry_id']==3) && (isset($accountId['income_paid'][$incomeEntry['inc_id']]))) {
							$balanceSheet['accountReceivables']['credit_amount'] += $accountId['income_paid'][$incomeEntry['inc_id']];
					  }
					/*	} 
					} else {*/
						if($incomeEntry['account_entry_id']==1 && (in_array($incomeEntry['inc_id'], $accountId['income']))) {
							$balanceSheet['accountReceivables']['debit_amount'] += $converted_amount;
							
						} else if($incomeEntry['account_entry_id']==3) {
								//$generalLedger['accountReceivables']['credit_amount'] += $converted_amount;
							
						} else if($incomeEntry['account_entry_id']==4 && (in_array($incomeEntry['inc_id'], $accountId['income']))) {
								$balanceSheet['gstPayables']['credit_amount'] += $converted_amount;
						}	
					//}
				}
			}

			if(isset($expenseAccountEntry) && !empty($expenseAccountEntry)) {
				foreach ($expenseAccountEntry as $expenseEntry) {
					$amount = $expenseEntry['amount'];
					if($expenseEntry['transaction_currency']!='SGD') {
						$converted_amount = $this->convertCurrency($amount,$expenseEntry['transaction_currency']);
					} else {
						$converted_amount = $amount;
					}
				//	if((!in_array($expenseEntry['exp_id'], $accountId['expense']))) {
				//		if(($expenseEntry['account_entry_id']==3) && (in_array($expenseEntry['exp_id'], $accountId['expense_pay'])) && isset($accountId['expense_paid'][$expenseEntry['exp_id']])) {
					   if(($expenseEntry['account_entry_id']==3) && isset($accountId['expense_paid'][$expenseEntry['exp_id']])) {	
							$balanceSheet['accountPayables']['debit_amount'] += $accountId['expense_paid'][$expenseEntry['exp_id']];
						}
					/*		} 
					} else {*/
						if($expenseEntry['account_entry_id']==2 && (in_array($expenseEntry['exp_id'], $accountId['expense']))) {
								$balanceSheet['accountPayables']['credit_amount'] += $converted_amount;
						} else if($expenseEntry['account_entry_id']==3 && (in_array($expenseEntry['exp_id'], $accountId['expense']))) {
							//	$generalLedger['accountPayables']['debit_amount'] += $converted_amount;
							
						} 	
					//}
				}
			}

			if(isset($invoiceAccountEntry) && !empty($invoiceAccountEntry)) {
				foreach ($invoiceAccountEntry as $invoiceEntry) {
					$amount = $invoiceEntry['amount'];
					if($invoiceEntry['transaction_currency']!='SGD') {
						$converted_amount = $this->convertCurrency($amount,$invoiceEntry['transaction_currency']);
					} else {
						$converted_amount = $amount;
					}
					//if((!in_array($invoiceEntry['inv_id'], $accountId['invoice']))) {
					//	if(($invoiceEntry['account_entry_id']==3) && (in_array($invoiceEntry['inv_id'], $accountId['invoice_pay'])) && (isset($accountId['invoice_paid'][$invoiceEntry['inv_id']]))) {
						if(($invoiceEntry['account_entry_id']==3) && (isset($accountId['invoice_paid'][$invoiceEntry['inv_id']]))) {

							$balanceSheet['accountReceivables']['credit_amount'] += $accountId['invoice_paid'][$invoiceEntry['inv_id']];
						}
					/*	} 
					} else { */
						if($invoiceEntry['account_entry_id']==1 && (in_array($invoiceEntry['inv_id'], $accountId['invoice']))) {
							$balanceSheet['accountReceivables']['debit_amount'] += $converted_amount;
							
						} else if($invoiceEntry['account_entry_id']==3) {
								//$generalLedger['accountReceivables']['credit_amount'] += $converted_amount;
							
						} else if($invoiceEntry['account_entry_id']==4 && (in_array($invoiceEntry['inv_id'], $accountId['invoice']))) {
								$balanceSheet['gstPayables']['credit_amount'] += $converted_amount;
						}
					//}	
				}
			}


			if(isset($creditAccountEntry) && !empty($creditAccountEntry)) {
				foreach ($creditAccountEntry as $creditEntry) {
					$amount = $creditEntry['amount'];
					if($creditEntry['transaction_currency']!='SGD') {
						$converted_amount = $this->convertCurrency($amount,$creditEntry['transaction_currency']);
					} else {
						$converted_amount = $amount;
					}
					//echo '<br/>'.$converted_amount;
					if($creditEntry['account_entry_id']==1) {
						$balanceSheet['accountReceivables']['credit_amount'] += $converted_amount;
					} else if($creditEntry['account_entry_id']==4) {
						$balanceSheet['gstPayables']['debit_amount'] += $converted_amount;
					}	
				}
			}



			$this->view->getAccount	=  $this->report->getAllAccounts();
			$this->view->paymentAccount	=  $balanceSheet;

				//echo '<pre>'; print_r($this->incomePayments); echo '</pre>';
				//echo '<pre>'; print_r($this->expensePayments); echo '</pre>';
				//echo '<pre>'; print_r($this->invoicePayments); echo '</pre>';
				//echo '<pre>'; print_r($balanceSheet); echo '</pre>';

			  }
	}

	public function generalLedgerAction() {
		if(!Zend_Session::namespaceIsset('sess_login')) {
		   $this->_redirect('index');
		} else {
			$generalLedger = array();
			$accountId      = array();
			$from = date('Y-01-01');
			$to = date('Y-m-d');
			if($this->_request->isPost()) {
				$postArray  = $this->getRequest()->getPost();
				$from = date('Y-m-d',strtotime($postArray['from_date']));
				$to = date('Y-m-d',strtotime($postArray['to_date']));
			}
			$this->view->from = date('d-m-Y',strtotime($from));
			$this->view->to = date('d-m-Y',strtotime($to));

			$incomeAccountIncome  = $this->report->getGeneralIncomeAccount($from,$to);
			$incomeAccountInvoice = $this->report->getGeneralInvoiceIncomeAccount($from,$to);
			$incomeAccountCredit  = $this->report->getGeneralCreditAccount($from,$to);
			$expenseAccount  = $this->report->getGeneralExpenseAccount($from,$to);
			$journalAccount  = $this->report->getGeneralJournalAccount($from,$to);

			$incomeAccountIncomePay  = $this->report->getGeneralIncomePayAccount($from,$to);
			$expenseAccountPay  =  $this->report->getExpensePayAccounts($from,$to);
			$incomeAccountInvoicePay  =  $this->report->getInvoicePayAccounts($from,$to);

			$incomeAccountEntry = $this->report->getAccountingEntriesIncome($from,$to);
			$expenseAccountEntry = $this->report->getAccountingEntriesExpense($from,$to);
			$invoiceAccountEntry = $this->report->getAccountingEntriesInvoice($from,$to);
			$creditAccountEntry = $this->report->getAccountingEntriesCredit($from,$to);

			$accountId['income'][] = 'NULL';
			if(isset($incomeAccountIncome) && !empty($incomeAccountIncome)) {
				foreach ($incomeAccountIncome as $income) {
					$accountId['income'][] = $income['inc_id'];
					$tax_amount = ($income['amount'] * $income['tax_value'] / 100);
					$total_income = $income['amount'];
					if($income['transaction_currency']!='SGD') {
						$converted_amount = $this->convertCurrency($total_income,$income['transaction_currency']);
					} else {
						$converted_amount = $total_income;
					}
					if(isset($generalLedger[$income['fkincome_type']])) {
						$generalLedger[$income['fkincome_type']]['credit_amount'] += $converted_amount;
						//$generalLedger[$income['fkincome_type']]['debit_amount'] = 0.00;
					} else {
						$generalLedger[$income['fkincome_type']]['credit_amount'] = 0.00;
						$generalLedger[$income['fkincome_type']]['debit_amount'] = 0.00;
						$generalLedger[$income['fkincome_type']]['credit_amount'] += $converted_amount;
					}
				}
			}



			$accountId['invoice'][] = 'NULL';
			if(isset($incomeAccountInvoice) && !empty($incomeAccountInvoice)) {
				foreach ($incomeAccountInvoice as $invoice) {
					$accountId['invoice'][] = $invoice['inv_id'];
					$amount = ($invoice['unit_price'] * $invoice['quantity'] - $invoice['discount_amount']);
					$tax_amount = ($amount * $invoice['tax_value'] / 100);
					$total_income = $amount;
					if($invoice['transaction_currency']!='SGD') {
						$converted_amount = $this->convertCurrency($total_income,$invoice['transaction_currency']);
					} else {
						$converted_amount = $total_income;
					}
					if(isset($generalLedger[$invoice['fkincomeaccount_id']])) {
						$generalLedger[$invoice['fkincomeaccount_id']]['credit_amount'] += $converted_amount;
						//$generalLedger[$invoice['fkincomeaccount_id']]['debit_amount'] = 0.00;
					} else {
						$generalLedger[$invoice['fkincomeaccount_id']]['credit_amount'] = 0.00;
						$generalLedger[$invoice['fkincomeaccount_id']]['debit_amount'] = 0.00;
						$generalLedger[$invoice['fkincomeaccount_id']]['credit_amount'] += $converted_amount;
					}
				}
			}



			if(isset($incomeAccountCredit) && !empty($incomeAccountCredit)) {
				foreach ($incomeAccountCredit as $credit) {
					$amount = ($credit['unit_price'] * $credit['quantity']);
					$tax_amount = ($amount * $credit['tax_value'] / 100);
					$total_income = $amount;
					if($credit['transaction_currency']!='SGD') {
						$converted_amount = $this->convertCurrency($total_income,$credit['transaction_currency']);
					} else {
						$converted_amount = $total_income;
					}
					//echo '<br/>'.$converted_amount;
					if(isset($generalLedger[$credit['fkincomeaccount_id']])) {
						$generalLedger[$credit['fkincomeaccount_id']]['debit_amount'] += $converted_amount;
						//$generalLedger[$credit['fkincomeaccount_id']]['credit_amount'] = 0.00;
					} else {
						$generalLedger[$credit['fkincomeaccount_id']]['credit_amount'] = 0.00;
						$generalLedger[$credit['fkincomeaccount_id']]['debit_amount'] = 0.00;
						$generalLedger[$credit['fkincomeaccount_id']]['debit_amount'] += $converted_amount;
					}
				}
			}



			$accountId['expense'][] = 'NULL';
			if(isset($expenseAccount) && !empty($expenseAccount)) {
				foreach ($expenseAccount as $expense) {
					$accountId['expense'][] = $expense['exp_id'];
					$amount = ($expense['unit_price'] * $expense['quantity']);
					$tax_amount = ($amount * $expense['tax_value'] / 100);
					$total_income = $amount + $tax_amount;
					if($expense['transaction_currency']!='SGD') {
						$converted_amount = $this->convertCurrency($total_income,$expense['transaction_currency']);
					} else {
						$converted_amount = $total_income;
					}
					if(isset($generalLedger[$expense['fkexpense_type']])) {
						$generalLedger[$expense['fkexpense_type']]['debit_amount'] += $converted_amount;
						//$generalLedger[$expense['fkexpense_type']]['credit_amount'] = 0.00;
					} else {
						$generalLedger[$expense['fkexpense_type']]['debit_amount'] = 0.00;
						$generalLedger[$expense['fkexpense_type']]['credit_amount'] = 0.00;
						$generalLedger[$expense['fkexpense_type']]['debit_amount'] += $converted_amount;
					}
				}
			}

			$accountId['income_pay'][] = 'NULL';
			$accountId['income_paid'][] = 'NULL';
			if(isset($incomeAccountIncomePay) && !empty($incomeAccountIncomePay)) {
				foreach ($incomeAccountIncomePay as $incPayment) {
						$accountId['income_pay'][] = $incPayment['inc_id'];
						$amount = $incPayment['payment_amount'];
						if($incPayment['transaction_currency']!='SGD') {
							$converted_amount = $this->convertCurrency($amount,$incPayment['transaction_currency']);
						} else {
							$converted_amount = $amount;
						}
						if(isset($accountId['income_paid'][$incPayment['inc_id']])) {
							$accountId['income_paid'][$incPayment['inc_id']] += $converted_amount;
						} else {
							$accountId['income_paid'][$incPayment['inc_id']] = 0.0;
							$accountId['income_paid'][$incPayment['inc_id']] += $converted_amount;
						}
						if(isset($generalLedger[$incPayment['fkpayment_account']])) {
							$generalLedger[$incPayment['fkpayment_account']]['debit_amount'] += $converted_amount;
							//$generalLedger[$incPayment['fkpayment_account']]['credit_amount'] += 0.00;
						} else {
							$generalLedger[$incPayment['fkpayment_account']]['debit_amount'] = 0.00;
							$generalLedger[$incPayment['fkpayment_account']]['credit_amount'] = 0.00;
							$generalLedger[$incPayment['fkpayment_account']]['debit_amount'] += $converted_amount;
						}
				}
			}


			$accountId['expense_pay'][] = 'NULL';
			$accountId['expense_paid'][] = 'NULL';
			if(isset($expenseAccountPay) && !empty($expenseAccountPay)) {
				foreach ($expenseAccountPay as $expPayment) {
						$accountId['expense_pay'][] = $expPayment['exp_id'];
						$amount = $expPayment['payment_amount'];
						if($expPayment['transaction_currency']!='SGD') {
							$converted_amount = $this->convertCurrency($amount,$expPayment['transaction_currency']);
						} else {
							$converted_amount = $amount;
						}
						if(isset($accountId['expense_paid'][$expPayment['exp_id']])) {
							$accountId['expense_paid'][$expPayment['exp_id']] += $converted_amount;
						} else {
							$accountId['expense_paid'][$expPayment['exp_id']] = 0.0;
							$accountId['expense_paid'][$expPayment['exp_id']] += $converted_amount;
						}
						if(isset($generalLedger[$expPayment['fkpayment_account']])) {
							$generalLedger[$expPayment['fkpayment_account']]['credit_amount'] += $converted_amount;
							//$generalLedger[$expPayment['fkpayment_account']]['debit_amount'] += 0.00;
						} else {
							$generalLedger[$expPayment['fkpayment_account']]['credit_amount'] = 0.00;
							$generalLedger[$expPayment['fkpayment_account']]['debit_amount'] = 0.00;
							$generalLedger[$expPayment['fkpayment_account']]['credit_amount'] += $converted_amount;
						}
					}
			}

			$accountId['invoice_pay'][] = 'NULL';
			$accountId['invoice_paid'][] = 'NULL';
			if(isset($incomeAccountInvoicePay) && !empty($incomeAccountInvoicePay)) {
				foreach ($incomeAccountInvoicePay as $invPayment) {
						$accountId['invoice_pay'][] = $invPayment['inv_id'];
						$amount = $invPayment['payment_amount'];
						if($invPayment['transaction_currency']!='SGD') {
							$converted_amount = $this->convertCurrency($amount,$invPayment['transaction_currency']);
						} else {
							$converted_amount = $amount;
						}
						if(isset($accountId['invoice_paid'][$invPayment['inv_id']])) {
							$accountId['invoice_paid'][$invPayment['inv_id']] += $converted_amount;
						} else {
							$accountId['invoice_paid'][$invPayment['inv_id']] = 0.0;
							$accountId['invoice_paid'][$invPayment['inv_id']] += $converted_amount;
						}
						if(isset($generalLedger[$invPayment['fkpayment_account']])) {
							$generalLedger[$invPayment['fkpayment_account']]['debit_amount'] += $converted_amount;
							//$generalLedger[$invPayment['fkpayment_account']]['credit_amount'] += 0.00;
						} else {
							$generalLedger[$invPayment['fkpayment_account']]['debit_amount'] = 0.00;
							$generalLedger[$invPayment['fkpayment_account']]['credit_amount'] = 0.00;
							$generalLedger[$invPayment['fkpayment_account']]['debit_amount'] += $converted_amount;
						}
					}
			}


			if(isset($journalAccount) && !empty($journalAccount)) {
				foreach ($journalAccount as $journal) {
					if(isset($generalLedger[$journal['fkaccount_id']])) {
						$generalLedger[$journal['fkaccount_id']]['debit_amount'] += $journal['debit'];
						$generalLedger[$journal['fkaccount_id']]['credit_amount'] += $journal['credit'];
					} else {
						$generalLedger[$journal['fkaccount_id']]['debit_amount'] = 0.00;
						$generalLedger[$journal['fkaccount_id']]['credit_amount'] = 0.00;
						$generalLedger[$journal['fkaccount_id']]['debit_amount'] += $journal['debit'];
						$generalLedger[$journal['fkaccount_id']]['credit_amount'] += $journal['credit'];
					}
				}
			}



			$generalLedger['accountReceivables']['debit_amount'] = 0.00;
			$generalLedger['accountReceivables']['credit_amount'] = 0.00;
			$generalLedger['accountPayables']['debit_amount'] = 0.00;
			$generalLedger['accountPayables']['credit_amount'] = 0.00;
		//	$generalLedger['cash']['debit_amount'] = 0.00;
		//	$generalLedger['cash']['credit_amount'] = 0.00;
			$generalLedger['gstPayables']['debit_amount'] = 0.00;
			$generalLedger['gstPayables']['credit_amount'] = 0.00;
		//	$generalLedger['sales']['debit_amount'] = 0.00;
		//	$generalLedger['sales']['credit_amount'] = 0.00;

		/*	echo '<pre>'; print_r($accountId); echo '</pre>';
			if(in_array(5, $accountId['income'])) {
				echo "string";
			}*/

			if(isset($incomeAccountEntry) && !empty($incomeAccountEntry)) {
				foreach ($incomeAccountEntry as $incomeEntry) {
					//echo $incomeEntry['inc_id'];
						$amount = $incomeEntry['amount'];
						if($incomeEntry['transaction_currency']!='SGD') {
							$converted_amount = $this->convertCurrency($amount,$incomeEntry['transaction_currency']);
						} else {
							$converted_amount = $amount;
						}
					//if((!in_array($incomeEntry['inc_id'], $accountId['income']))) {
					//	if(($incomeEntry['account_entry_id']==3) && (in_array($incomeEntry['inc_id'], $accountId['income_pay'])) && (isset($accountId['income_paid'][$incomeEntry['inc_id']]))) {
					  if(($incomeEntry['account_entry_id']==3) && (isset($accountId['income_paid'][$incomeEntry['inc_id']]))) {
							$generalLedger['accountReceivables']['credit_amount'] += $accountId['income_paid'][$incomeEntry['inc_id']];
					  }
					/*	} 
					} else {*/
						if($incomeEntry['account_entry_id']==1 && (in_array($incomeEntry['inc_id'], $accountId['income']))) {
							$generalLedger['accountReceivables']['debit_amount'] += $converted_amount;
							
						} else if($incomeEntry['account_entry_id']==3) {
								//$generalLedger['accountReceivables']['credit_amount'] += $converted_amount;
							
						} else if($incomeEntry['account_entry_id']==4 && (in_array($incomeEntry['inc_id'], $accountId['income']))) {
								$generalLedger['gstPayables']['credit_amount'] += $converted_amount;
						}	
					//}
				}
			}

			if(isset($expenseAccountEntry) && !empty($expenseAccountEntry)) {
				foreach ($expenseAccountEntry as $expenseEntry) {
					$amount = $expenseEntry['amount'];
					if($expenseEntry['transaction_currency']!='SGD') {
						$converted_amount = $this->convertCurrency($amount,$expenseEntry['transaction_currency']);
					} else {
						$converted_amount = $amount;
					}
				//	if((!in_array($expenseEntry['exp_id'], $accountId['expense']))) {
				//		if(($expenseEntry['account_entry_id']==3) && (in_array($expenseEntry['exp_id'], $accountId['expense_pay'])) && isset($accountId['expense_paid'][$expenseEntry['exp_id']])) {
					   if(($expenseEntry['account_entry_id']==3) && isset($accountId['expense_paid'][$expenseEntry['exp_id']])) {	
							$generalLedger['accountPayables']['debit_amount'] += $accountId['expense_paid'][$expenseEntry['exp_id']];
						}
					/*		} 
					} else {*/
						if($expenseEntry['account_entry_id']==2 && (in_array($expenseEntry['exp_id'], $accountId['expense']))) {
								$generalLedger['accountPayables']['credit_amount'] += $converted_amount;
						} else if($expenseEntry['account_entry_id']==3 && (in_array($expenseEntry['exp_id'], $accountId['expense']))) {
							//	$generalLedger['accountPayables']['debit_amount'] += $converted_amount;
							
						} 	
					//}
				}
			}

			if(isset($invoiceAccountEntry) && !empty($invoiceAccountEntry)) {
				foreach ($invoiceAccountEntry as $invoiceEntry) {
					$amount = $invoiceEntry['amount'];
					if($invoiceEntry['transaction_currency']!='SGD') {
						$converted_amount = $this->convertCurrency($amount,$invoiceEntry['transaction_currency']);
					} else {
						$converted_amount = $amount;
					}
					//if((!in_array($invoiceEntry['inv_id'], $accountId['invoice']))) {
					//	if(($invoiceEntry['account_entry_id']==3) && (in_array($invoiceEntry['inv_id'], $accountId['invoice_pay'])) && (isset($accountId['invoice_paid'][$invoiceEntry['inv_id']]))) {
						if(($invoiceEntry['account_entry_id']==3) && (isset($accountId['invoice_paid'][$invoiceEntry['inv_id']]))) {

							$generalLedger['accountReceivables']['credit_amount'] += $accountId['invoice_paid'][$invoiceEntry['inv_id']];
						}
					/*	} 
					} else { */
						if($invoiceEntry['account_entry_id']==1 && (in_array($invoiceEntry['inv_id'], $accountId['invoice']))) {
							$generalLedger['accountReceivables']['debit_amount'] += $converted_amount;
							
						} else if($invoiceEntry['account_entry_id']==3) {
								//$generalLedger['accountReceivables']['credit_amount'] += $converted_amount;
							
						} else if($invoiceEntry['account_entry_id']==4 && (in_array($invoiceEntry['inv_id'], $accountId['invoice']))) {
								$generalLedger['gstPayables']['credit_amount'] += $converted_amount;
						}
					//}	
				}
			}

			if(isset($creditAccountEntry) && !empty($creditAccountEntry)) {
				foreach ($creditAccountEntry as $creditEntry) {
					$amount = $creditEntry['amount'];
					if($creditEntry['transaction_currency']!='SGD') {
						$converted_amount = $this->convertCurrency($amount,$creditEntry['transaction_currency']);
					} else {
						$converted_amount = $amount;
					}
					//echo '<br/>'.$converted_amount;
					if($creditEntry['account_entry_id']==1) {
						$generalLedger['accountReceivables']['credit_amount'] += $converted_amount;
					} else if($creditEntry['account_entry_id']==4) {
						$generalLedger['gstPayables']['debit_amount'] += $converted_amount;
					}	
				}
			}


		/*	$debit_amount = 0;
			$credit_amount = 0;

			foreach ($generalLedger as $gl) {
				$debit_amount += $gl['debit_amount'];
				$credit_amount += $gl['credit_amount'];
			} */

			$this->view->getAccount	=  $this->report->getAllAccounts();
			if(isset($this->view->getAccount) && !empty($this->view->getAccount)) {
				$this->view->generalAccount	=  $generalLedger; 
			} else {
				$this->view->generalAccount	=  array(); 
			}
			
			//echo $debit_amount.'<br/>';
			//echo $credit_amount;

			/*echo '<pre>'; print_r($incomeAccountIncome); echo '</pre>';
			echo '<pre>'; print_r($incomeAccountInvoice); echo '</pre>';
			echo '<pre>'; print_r($incomeAccountCredit); echo '</pre>';
			echo '<pre>'; print_r($expenseAccount); echo '</pre>';
			echo '<pre>'; print_r($incomeAccountIncomePay); echo '</pre>';
			echo '<pre>'; print_r($expenseAccountPay); echo '</pre>';
			echo '<pre>'; print_r($incomeAccountInvoicePay); echo '</pre>';
			echo '<pre>'; print_r($journalAccount); echo '</pre>';
			echo '<pre>'; print_r($incomeAccountIncomePay); echo '</pre>';
			echo '<pre>'; print_r($expenseAccountEntry); echo '</pre>';
			echo '<pre>'; print_r($creditAccountEntry); echo '</pre>';
			echo '<pre>'; print_r($incomeAccountCredit); echo '</pre>';
			echo '<pre>'; print_r($accountId); echo '</pre>';
			echo '<pre>'; print_r($expenseAccount); echo '</pre>';
			echo '<pre>'; print_r($expenseAccountPay); echo '</pre>';
			echo '<pre>'; print_r($expenseAccountEntry); echo '</pre>';
			echo '<pre>'; print_r($this->view->getAccount); echo '</pre>';
			echo '<pre>'; print_r($this->view->generalAccount); echo '</pre>';*/
			//echo '<pre>'; print_r($incomeAccountIncome); echo '</pre>';
			//echo '<pre>'; print_r($incomeAccountIncomePay); echo '</pre>';
			//echo '<pre>'; print_r($incomeAccountEntry); echo '</pre>';
			
		}
    }



    public function accountTransactionsAction() {
		if(!Zend_Session::namespaceIsset('sess_login')) {
		   $this->_redirect('index');
		} else {
			$generalLedger = array();
			$accountId      = array();
			$from = date('Y-01-01');
			$to = date('Y-m-d');
			if($this->_request->isPost()) {
				$postArray  = $this->getRequest()->getPost();
				$from = date('Y-m-d',strtotime($postArray['from_date']));
				$to = date('Y-m-d',strtotime($postArray['to_date']));
				$this->view->generalAccount = $postArray['account'];
			}
			$this->view->from = date('d-m-Y',strtotime($from));
			$this->view->to = date('d-m-Y',strtotime($to));

			$incomeAccountIncome  = $this->report->getGeneralIncomeAccount($from,$to);
			$incomeAccountInvoice = $this->report->getGeneralInvoiceIncomeAccount($from,$to);
			$incomeAccountCredit  = $this->report->getGeneralCreditAccount($from,$to);
			$expenseAccount  = $this->report->getGeneralExpenseAccount($from,$to);
			$journalAccount  = $this->report->getGeneralJournalAccount($from,$to);

			$incomeAccountIncomePay  = $this->report->getGeneralIncomePayAccount($from,$to);
			$expenseAccountPay  =  $this->report->getExpensePayAccounts($from,$to);
			$incomeAccountInvoicePay  =  $this->report->getInvoicePayAccounts($from,$to);

			$incomeAccountEntry = $this->report->getAccountingEntriesIncome($from,$to);
			$expenseAccountEntry = $this->report->getAccountingEntriesExpense($from,$to);
			$invoiceAccountEntry = $this->report->getAccountingEntriesInvoice($from,$to);
			$creditAccountEntry = $this->report->getAccountingEntriesCredit($from,$to);

			

			$accountId['income'][] = 'NULL';
			if(isset($incomeAccountIncome) && !empty($incomeAccountIncome)) {
				foreach ($incomeAccountIncome as $income) {
					$accountId['income'][] = $income['inc_id'];
					$tax_amount = ($income['amount'] * $income['tax_value'] / 100);
					$total_income = $income['amount'];
					if($income['transaction_currency']!='SGD') {
						$converted_amount = $this->convertCurrency($total_income,$income['transaction_currency']);
					} else {
						$converted_amount = $total_income;
					}
						$generalLedger[$income['income_no']]['account_type'] = $income['fkincome_type'];
						$generalLedger[$income['income_no']]['date'] = $income['date'];
						$generalLedger[$income['income_no']]['transaction'] = "Income No ".$income['income_no'];
						$generalLedger[$income['income_no']]['credit_amount'] = $converted_amount;
						$generalLedger[$income['income_no']]['debit_amount'] = 0.00;
				}
			}
			
			$accountId['invoice'][] = 'NULL';
			if(isset($incomeAccountInvoice) && !empty($incomeAccountInvoice)) {
				foreach ($incomeAccountInvoice as $invoice) {
					$accountId['invoice'][] = $invoice['inv_id'];
					$amount = ($invoice['unit_price'] * $invoice['quantity'] - $invoice['discount_amount']);
					$tax_amount = ($amount * $invoice['tax_value'] / 100);
					$total_income = $amount;
					if($invoice['transaction_currency']!='SGD') {
						$converted_amount = $this->convertCurrency($total_income,$invoice['transaction_currency']);
					} else {
						$converted_amount = $total_income;
					}
						$invoice_id = $invoice['invoice_no']."_".$invoice['pid'];
						$generalLedger[$invoice_id]['account_type'] = $invoice['fkincomeaccount_id'];
						$generalLedger[$invoice_id]['date'] = $invoice['date'];
						$generalLedger[$invoice_id]['transaction'] = "Invoice No ".$invoice['invoice_no'];
						$generalLedger[$invoice_id]['credit_amount'] = $converted_amount;
						$generalLedger[$invoice_id]['debit_amount'] = 0.00;

				}
			}

			if(isset($incomeAccountCredit) && !empty($incomeAccountCredit)) {
				foreach ($incomeAccountCredit as $credit) {
					$amount = ($credit['unit_price'] * $credit['quantity']);
					$tax_amount = ($amount * $credit['tax_value'] / 100);
					$total_income = $amount;
					if($credit['transaction_currency']!='SGD') {
						$converted_amount = $this->convertCurrency($total_income,$credit['transaction_currency']);
					} else {
						$converted_amount = $total_income;
					}
						$credit_id = $credit['credit_no']."_".$credit['pid'];
						$generalLedger[$credit_id]['account_type'] = $credit['fkincomeaccount_id'];
						$generalLedger[$credit_id]['date'] = $credit['date'];
						$generalLedger[$credit_id]['transaction'] = "Credit No ".$credit['credit_no'];
						$generalLedger[$credit_id]['credit_amount'] = 0.00;
						$generalLedger[$credit_id]['debit_amount'] = $converted_amount;
					
				}
			}

			$accountId['expense'][] = 'NULL';
			if(isset($expenseAccount) && !empty($expenseAccount)) {
				foreach ($expenseAccount as $expense) {
					$accountId['expense'][] = $expense['exp_id'];
					$amount = ($expense['unit_price'] * $expense['quantity']);
					$tax_amount = ($amount * $expense['tax_value'] / 100);
					$total_income = $amount + $tax_amount;
					if($expense['transaction_currency']!='SGD') {
						$converted_amount = $this->convertCurrency($total_income,$expense['transaction_currency']);
					} else {
						$converted_amount = $total_income;
					}
					$expense_id = $expense['expense_no']."_".$expense['pid'];
					$generalLedger[$expense_id]['account_type'] = $expense['fkexpense_type'];
					$generalLedger[$expense_id]['date'] = $expense['date'];
					$generalLedger[$expense_id]['transaction'] = "Expense No ".$expense['expense_no'];
					$generalLedger[$expense_id]['credit_amount'] = 0.00;
					$generalLedger[$expense_id]['debit_amount'] = $converted_amount;
	
				}
			}
			$accountId['income_pay'][] = 'NULL';
			$accountId['income_paid'][] = 'NULL';
			if(isset($incomeAccountIncomePay) && !empty($incomeAccountIncomePay)) {
				foreach ($incomeAccountIncomePay as $incPayment) {
						$accountId['income_pay'][] = $incPayment['inc_id'];
						$amount = $incPayment['payment_amount'];
						if($incPayment['transaction_currency']!='SGD') {
							$converted_amount = $this->convertCurrency($amount,$incPayment['transaction_currency']);
						} else {
							$converted_amount = $amount;
						}
						if(isset($accountId['income_paid'][$incPayment['inc_id']])) {
							$accountId['income_paid'][$incPayment['inc_id']] += $converted_amount;
						} else {
							$accountId['income_paid'][$incPayment['inc_id']] = 0.0;
							$accountId['income_paid'][$incPayment['inc_id']] += $converted_amount;
						}

					$payId = $incPayment['id']."_".$incPayment['income_no']."_pay";
					$entryId = $incPayment['id']."_".$incPayment['income_no']."_payentry";
					$generalLedger[$payId]['account_type'] = $incPayment['fkpayment_account'];
					$generalLedger[$payId]['date'] = $incPayment['pay_date'];
					$generalLedger[$payId]['transaction'] = "Payment for Income No ".$incPayment['income_no'];
					$generalLedger[$payId]['credit_amount'] = 0.00;
					$generalLedger[$payId]['debit_amount'] = $converted_amount;

					$generalLedger[$entryId]['account_type'] = 'accountReceivables';
					$generalLedger[$entryId]['date'] = $incPayment['pay_date'];
				    $generalLedger[$entryId]['transaction'] = "Income No ".$incPayment['income_no'];
					$generalLedger[$entryId]['credit_amount'] = $converted_amount;
					$generalLedger[$entryId]['debit_amount'] = 0.00;

				}
			}

			$accountId['expense_pay'][] = 'NULL';
			$accountId['expense_paid'][] = 'NULL';
			if(isset($expenseAccountPay) && !empty($expenseAccountPay)) {
				foreach ($expenseAccountPay as $expPayment) {
						$accountId['expense_pay'][] = $expPayment['exp_id'];
						$amount = $expPayment['payment_amount'];
						if($expPayment['transaction_currency']!='SGD') {
							$converted_amount = $this->convertCurrency($amount,$expPayment['transaction_currency']);
						} else {
							$converted_amount = $amount;
						}
						if(isset($accountId['expense_paid'][$expPayment['exp_id']])) {
							$accountId['expense_paid'][$expPayment['exp_id']] += $converted_amount;
						} else {
							$accountId['expense_paid'][$expPayment['exp_id']] = 0.0;
							$accountId['expense_paid'][$expPayment['exp_id']] += $converted_amount;
						}
					$payId = $expPayment['id']."_".$expPayment['expense_no']."_pay";
					$entryId = $expPayment['id']."_".$expPayment['expense_no']."_payentry";
					$generalLedger[$payId]['account_type'] = $expPayment['fkpayment_account'];
					$generalLedger[$payId]['date'] = $expPayment['pay_date'];
					$generalLedger[$payId]['transaction'] = "Payment for Expense No ".$expPayment['expense_no'];
					$generalLedger[$payId]['credit_amount'] = $converted_amount;
					$generalLedger[$payId]['debit_amount'] = 0.00;

					$generalLedger[$entryId]['account_type'] = 'accountPayables';
					$generalLedger[$entryId]['date'] = $expPayment['pay_date'];
					$generalLedger[$entryId]['transaction'] = "Expense No ".$expPayment['expense_no'];
					$generalLedger[$entryId]['credit_amount'] = 0.00;
					$generalLedger[$entryId]['debit_amount'] = $converted_amount;	
				}
			}

			$accountId['invoice_pay'][] = 'NULL';
			$accountId['invoice_paid'][] = 'NULL';
			if(isset($incomeAccountInvoicePay) && !empty($incomeAccountInvoicePay)) {
				foreach ($incomeAccountInvoicePay as $invPayment) {
						$accountId['invoice_pay'][] = $invPayment['inv_id'];
						$amount = $invPayment['payment_amount'];
						if($invPayment['transaction_currency']!='SGD') {
							$converted_amount = $this->convertCurrency($amount,$invPayment['transaction_currency']);
						} else {
							$converted_amount = $amount;
						}
						if(isset($accountId['invoice_paid'][$invPayment['inv_id']])) {
							$accountId['invoice_paid'][$invPayment['inv_id']] += $converted_amount;
						} else {
							$accountId['invoice_paid'][$invPayment['inv_id']] = 0.0;
							$accountId['invoice_paid'][$invPayment['inv_id']] += $converted_amount;
						}
					$payId = $invPayment['id']."_".$invPayment['invoice_no']."_pay";
					$entryId = $invPayment['id']."_".$invPayment['invoice_no']."_payentry";
					$generalLedger[$payId]['account_type'] = $invPayment['fkpayment_account'];
					$generalLedger[$payId]['date'] = $invPayment['pay_date'];
					$generalLedger[$payId]['transaction'] = "Payment for Invoice No ".$invPayment['invoice_no'];
					$generalLedger[$payId]['credit_amount'] = 0.00; 
					$generalLedger[$payId]['debit_amount'] = $converted_amount;

					$generalLedger[$entryId]['account_type'] = 'accountReceivables';
					$generalLedger[$entryId]['date'] = $invPayment['pay_date'];
					$generalLedger[$entryId]['transaction'] = "Invoice No ".$invPayment['invoice_no'];
					$generalLedger[$entryId]['credit_amount'] = $converted_amount;
				    $generalLedger[$entryId]['debit_amount'] = 0.00;	

					}
			}


			if(isset($journalAccount) && !empty($journalAccount)) {
				foreach ($journalAccount as $journal) {
					$journId = $journal['jid']."_".$journal['journal_no'];
					$generalLedger[$journId]['account_type'] = $journal['fkaccount_id'];
					$generalLedger[$journId]['transaction'] = "Journal No ".$journal['journal_no'];
					$generalLedger[$journId]['credit_amount'] = $journal['credit']; 
					$generalLedger[$journId]['debit_amount'] = $journal['debit'];
					$generalLedger[$journId]['date'] = $journal['date'];

				}
			}
/*
			$generalLedger['accountReceivables']['debit_amount'] = 0.00;
			$generalLedger['accountReceivables']['credit_amount'] = 0.00;
			$generalLedger['accountPayables']['debit_amount'] = 0.00;
			$generalLedger['accountPayables']['credit_amount'] = 0.00;
			$generalLedger['gstPayables']['debit_amount'] = 0.00;
			$generalLedger['gstPayables']['credit_amount'] = 0.00;
*/

			if(isset($incomeAccountEntry) && !empty($incomeAccountEntry)) {
				foreach ($incomeAccountEntry as $incomeEntry) {
					//echo $incomeEntry['inc_id'];
						$amount = $incomeEntry['amount'];
						$entryId = $incomeEntry['id']."_".$incomeEntry['income_no']."_entry";
						if($incomeEntry['transaction_currency']!='SGD') {
							$converted_amount = $this->convertCurrency($amount,$incomeEntry['transaction_currency']);
						} else {
							$converted_amount = $amount;
						}
					//if((!in_array($incomeEntry['inc_id'], $accountId['income']))) {
					//	if(($incomeEntry['account_entry_id']==3) && (in_array($incomeEntry['inc_id'], $accountId['income_pay'])) && (isset($accountId['income_paid'][$incomeEntry['inc_id']]))) {
					/*  if(($incomeEntry['account_entry_id']==3) && (isset($accountId['income_paid'][$incomeEntry['inc_id']]))) {
							$generalLedger[$entryId]['account_type'] = 'accountReceivables';
							$generalLedger[$entryId]['transaction'] = "journal No ".$journal['journal_no'];
							$generalLedger[$entryId]['credit_amount'] = $accountId['income_paid'][$incomeEntry['inc_id']];
							$generalLedger[$entryId]['debit_amount'] = 0.00;
					  }*/
					/*	} 
					} else {*/
						if($incomeEntry['account_entry_id']==1 && (in_array($incomeEntry['inc_id'], $accountId['income']))) {
							$generalLedger[$entryId]['account_type'] = 'accountReceivables';
							$generalLedger[$entryId]['date'] = $incomeEntry['inc_date'];
							$generalLedger[$entryId]['transaction'] = "Income No ".$incomeEntry['income_no'];
							$generalLedger[$entryId]['credit_amount'] = 0.00;
							$generalLedger[$entryId]['debit_amount'] = $converted_amount;
							
						} else if($incomeEntry['account_entry_id']==3) {
								//$generalLedger['accountReceivables']['credit_amount'] += $converted_amount;
							
						} else if($incomeEntry['account_entry_id']==4 && (in_array($incomeEntry['inc_id'], $accountId['income']))) {
								$generalLedger[$entryId]['account_type'] = 'gstPayables';
								$generalLedger[$entryId]['date'] = $incomeEntry['inc_date'];
								$generalLedger[$entryId]['transaction'] = "Income No ".$incomeEntry['income_no'];
								$generalLedger[$entryId]['credit_amount'] = $converted_amount;
								$generalLedger[$entryId]['debit_amount'] = 0.00;
						}	
					//}
				}
			}

			if(isset($expenseAccountEntry) && !empty($expenseAccountEntry)) {
				foreach ($expenseAccountEntry as $expenseEntry) {
					$amount = $expenseEntry['amount'];
					$entryId = $expenseEntry['id']."_".$expenseEntry['expense_no']."_entry";
					if($expenseEntry['transaction_currency']!='SGD') {
						$converted_amount = $this->convertCurrency($amount,$expenseEntry['transaction_currency']);
					} else {
						$converted_amount = $amount;
					}
				//	if((!in_array($expenseEntry['exp_id'], $accountId['expense']))) {
				//		if(($expenseEntry['account_entry_id']==3) && (in_array($expenseEntry['exp_id'], $accountId['expense_pay'])) && isset($accountId['expense_paid'][$expenseEntry['exp_id']])) {
					/*   if(($expenseEntry['account_entry_id']==3) && isset($accountId['expense_paid'][$expenseEntry['exp_id']])) {
					   		$generalLedger[$entryId]['account_type'] = 'accountPayables';
							$generalLedger[$entryId]['credit_amount'] = 0.00;
							$generalLedger[$entryId]['debit_amount'] = $accountId['expense_paid'][$expenseEntry['exp_id']];	
						}*/
					/*		} 
					} else {*/
						if($expenseEntry['account_entry_id']==2 && (in_array($expenseEntry['exp_id'], $accountId['expense']))) {
									$generalLedger[$entryId]['account_type'] = 'accountPayables';
									$generalLedger[$entryId]['date'] = $expenseEntry['exp_date'];
									$generalLedger[$entryId]['transaction'] = "Expense No ".$expenseEntry['expense_no'];
									$generalLedger[$entryId]['credit_amount'] = $converted_amount;
									$generalLedger[$entryId]['debit_amount'] = 0.00;	
						} else if($expenseEntry['account_entry_id']==3 && (in_array($expenseEntry['exp_id'], $accountId['expense']))) {
							//	$generalLedger['accountPayables']['debit_amount'] += $converted_amount;
							
						} 	
					//}
				}
			}

			if(isset($invoiceAccountEntry) && !empty($invoiceAccountEntry)) {
				foreach ($invoiceAccountEntry as $invoiceEntry) {
					$amount = $invoiceEntry['amount'];
					$entryId = $invoiceEntry['id']."_".$invoiceEntry['invoice_no']."_entry";
					if($invoiceEntry['transaction_currency']!='SGD') {
						$converted_amount = $this->convertCurrency($amount,$invoiceEntry['transaction_currency']);
					} else {
						$converted_amount = $amount;
					}
					//if((!in_array($invoiceEntry['inv_id'], $accountId['invoice']))) {
					//	if(($invoiceEntry['account_entry_id']==3) && (in_array($invoiceEntry['inv_id'], $accountId['invoice_pay'])) && (isset($accountId['invoice_paid'][$invoiceEntry['inv_id']]))) {
						/*if(($invoiceEntry['account_entry_id']==3) && (isset($accountId['invoice_paid'][$invoiceEntry['inv_id']]))) {

							$generalLedger[$entryId]['account_type'] = 'accountReceivables';
							$generalLedger[$entryId]['credit_amount'] = $accountId['invoice_paid'][$invoiceEntry['inv_id']];
							$generalLedger[$entryId]['debit_amount'] = 0.00;	

						}*/
					/*	} 
					} else { */
						if($invoiceEntry['account_entry_id']==1 && (in_array($invoiceEntry['inv_id'], $accountId['invoice']))) {

							$generalLedger[$entryId]['account_type'] = 'accountReceivables';
							$generalLedger[$entryId]['date'] = $invoiceEntry['inv_date'];
							$generalLedger[$entryId]['transaction'] = "Invoice No ".$invoiceEntry['invoice_no'];
							$generalLedger[$entryId]['credit_amount'] = 0.00;
							$generalLedger[$entryId]['debit_amount'] = $converted_amount;	

							
						} else if($invoiceEntry['account_entry_id']==3) {
								//$generalLedger['accountReceivables']['credit_amount'] += $converted_amount;
							
						} else if($invoiceEntry['account_entry_id']==4 && (in_array($invoiceEntry['inv_id'], $accountId['invoice']))) {
								
							$generalLedger[$entryId]['account_type'] = 'gstPayables';
							$generalLedger[$entryId]['date'] = $invoiceEntry['inv_date'];
							$generalLedger[$entryId]['transaction'] = "Invoice No ".$invoiceEntry['invoice_no'];
							$generalLedger[$entryId]['credit_amount'] = $converted_amount;
							$generalLedger[$entryId]['debit_amount'] = 0.00;	

						}
					//}	
				}
			}

			if(isset($creditAccountEntry) && !empty($creditAccountEntry)) {
				foreach ($creditAccountEntry as $creditEntry) {
					$amount = $creditEntry['amount'];
					$entryId = $creditEntry['id']."_".$creditEntry['credit_no']."_entry";
					if($creditEntry['transaction_currency']!='SGD') {
						$converted_amount = $this->convertCurrency($amount,$creditEntry['transaction_currency']);
					} else {
						$converted_amount = $amount;
					}
					//echo '<br/>'.$converted_amount;
					if($creditEntry['account_entry_id']==1) {

						$generalLedger[$entryId]['account_type'] = 'accountReceivables';
						$generalLedger[$entryId]['date'] = $creditEntry['cre_date'];
						$generalLedger[$entryId]['transaction'] = "Credit No ".$creditEntry['credit_no'];
						$generalLedger[$entryId]['credit_amount'] = $converted_amount;
						$generalLedger[$entryId]['debit_amount'] = 0.00;	

					} else if($creditEntry['account_entry_id']==4) {

						$generalLedger[$entryId]['account_type'] = 'gstPayables';
						$generalLedger[$entryId]['date'] = $creditEntry['cre_date'];
						$generalLedger[$entryId]['transaction'] = "Credit No ".$creditEntry['credit_no'];
						$generalLedger[$entryId]['credit_amount'] = 0.00;
						$generalLedger[$entryId]['debit_amount'] = $converted_amount;	

					}	
				}
			}




			$this->view->getAccount	=  $this->report->getAllAccounts();
			if(isset($this->view->getAccount) && !empty($this->view->getAccount)) {
				$this->view->generalTransaction	=  $generalLedger; 
			} else {
				$this->view->generalTransaction	=  array(); 
			}
			
			//echo '<pre>'; print_r($this->view->getAccount); echo '</pre>';
		}
    }


    public function irasAuditFileAction() {
		if(!Zend_Session::namespaceIsset('sess_login')) {
			 $this->_redirect('index');
		} else {
			$logSession = new Zend_Session_Namespace('sess_login');
			if(isset($logSession->proxy_cid) && !empty($logSession->proxy_cid)) {
				$id = $logSession->proxy_cid;
			} else {
				$id = $logSession->cid;
			}
		    $generalLedger = array();
			$accountId      = array();
			$from = date('Y-01-01');
			$to = date('Y-m-d');
			if($this->_request->isPost()) {
				$postArray  = $this->getRequest()->getPost();
				$from = date('Y-m-d',strtotime($postArray['from_date']));
				$to = date('Y-m-d',strtotime($postArray['to_date']));
			}
			$this->view->from = date('d-m-Y',strtotime($from));
			$this->view->to = date('d-m-Y',strtotime($to));
/*
			$incomeAccountIncome  = $this->report->getGeneralIncomeAccount($from,$to);
			$incomeAccountInvoice = $this->report->getGeneralInvoiceIncomeAccount($from,$to);
			$incomeAccountCredit  = $this->report->getGeneralCreditAccount($from,$to);
			$expenseAccount  = $this->report->getGeneralExpenseAccount($from,$to);
			$journalAccount  = $this->report->getGeneralJournalAccount($from,$to);

			$incomeAccountIncomePay  = $this->report->getGeneralIncomePayAccount($from,$to);
			$expenseAccountPay  =  $this->report->getExpensePayAccounts($from,$to);
			$incomeAccountInvoicePay  =  $this->report->getInvoicePayAccounts($from,$to);

			$incomeAccountEntry = $this->report->getAccountingEntriesIncome($from,$to);
			$expenseAccountEntry = $this->report->getAccountingEntriesExpense($from,$to);
			$invoiceAccountEntry = $this->report->getAccountingEntriesInvoice($from,$to);
			$creditAccountEntry = $this->report->getAccountingEntriesCredit($from,$to);

			$accountId['income'][] = 'NULL';
			if(isset($incomeAccountIncome) && !empty($incomeAccountIncome)) {
				foreach ($incomeAccountIncome as $income) {
					$accountId['income'][] = $income['inc_id'];
					$tax_amount = ($income['amount'] * $income['tax_value'] / 100);
					$total_income = $income['amount'];
					if($income['transaction_currency']!='SGD') {
						$converted_amount = $this->convertCurrency($total_income,$income['transaction_currency']);
					} else {
						$converted_amount = $total_income;
					}
					if(isset($generalLedger[$income['fkincome_type']])) {
						$generalLedger[$income['fkincome_type']]['credit_amount'] += $converted_amount;
					} else {
						$generalLedger[$income['fkincome_type']]['credit_amount'] = 0.00;
						$generalLedger[$income['fkincome_type']]['debit_amount'] = 0.00;
						$generalLedger[$income['fkincome_type']]['credit_amount'] += $converted_amount;
					}
				}
			}
			$accountId['invoice'][] = 'NULL';
			if(isset($incomeAccountInvoice) && !empty($incomeAccountInvoice)) {
				foreach ($incomeAccountInvoice as $invoice) {
					$accountId['invoice'][] = $invoice['inv_id'];
					$amount = ($invoice['unit_price'] * $invoice['quantity'] - $invoice['discount_amount']);
					$tax_amount = ($amount * $invoice['tax_value'] / 100);
					$total_income = $amount;
					if($invoice['transaction_currency']!='SGD') {
						$converted_amount = $this->convertCurrency($total_income,$invoice['transaction_currency']);
					} else {
						$converted_amount = $total_income;
					}
					if(isset($generalLedger[$invoice['fkincomeaccount_id']])) {
						$generalLedger[$invoice['fkincomeaccount_id']]['credit_amount'] += $converted_amount;
					} else {
						$generalLedger[$invoice['fkincomeaccount_id']]['credit_amount'] = 0.00;
						$generalLedger[$invoice['fkincomeaccount_id']]['debit_amount'] = 0.00;
						$generalLedger[$invoice['fkincomeaccount_id']]['credit_amount'] += $converted_amount;
					}
				}
			}

			if(isset($incomeAccountCredit) && !empty($incomeAccountCredit)) {
				foreach ($incomeAccountCredit as $credit) {
					$amount = ($credit['unit_price'] * $credit['quantity']);
					$tax_amount = ($amount * $credit['tax_value'] / 100);
					$total_income = $amount;
					if($credit['transaction_currency']!='SGD') {
						$converted_amount = $this->convertCurrency($total_income,$credit['transaction_currency']);
					} else {
						$converted_amount = $total_income;
					}
					if(isset($generalLedger[$credit['fkincomeaccount_id']])) {
						$generalLedger[$credit['fkincomeaccount_id']]['debit_amount'] += $converted_amount;
					} else {
						$generalLedger[$credit['fkincomeaccount_id']]['credit_amount'] = 0.00;
						$generalLedger[$credit['fkincomeaccount_id']]['debit_amount'] = 0.00;
						$generalLedger[$credit['fkincomeaccount_id']]['debit_amount'] += $converted_amount;
					}
				}
			}

			$accountId['expense'][] = 'NULL';
			if(isset($expenseAccount) && !empty($expenseAccount)) {
				foreach ($expenseAccount as $expense) {
					$accountId['expense'][] = $expense['exp_id'];
					$amount = ($expense['unit_price'] * $expense['quantity']);
					$tax_amount = ($amount * $expense['tax_value'] / 100);
					$total_income = $amount + $tax_amount;
					if($expense['transaction_currency']!='SGD') {
						$converted_amount = $this->convertCurrency($total_income,$expense['transaction_currency']);
					} else {
						$converted_amount = $total_income;
					}
					if(isset($generalLedger[$expense['fkexpense_type']])) {
						$generalLedger[$expense['fkexpense_type']]['debit_amount'] += $converted_amount;
					} else {
						$generalLedger[$expense['fkexpense_type']]['debit_amount'] = 0.00;
						$generalLedger[$expense['fkexpense_type']]['credit_amount'] = 0.00;
						$generalLedger[$expense['fkexpense_type']]['debit_amount'] += $converted_amount;
					}
				}
			}

			$accountId['income_pay'][] = 'NULL';
			$accountId['income_paid'][] = 'NULL';
			if(isset($incomeAccountIncomePay) && !empty($incomeAccountIncomePay)) {
				foreach ($incomeAccountIncomePay as $incPayment) {
						$accountId['income_pay'][] = $incPayment['inc_id'];
						$amount = $incPayment['payment_amount'];
						if($incPayment['transaction_currency']!='SGD') {
							$converted_amount = $this->convertCurrency($amount,$incPayment['transaction_currency']);
						} else {
							$converted_amount = $amount;
						}
						if(isset($accountId['income_paid'][$incPayment['inc_id']])) {
							$accountId['income_paid'][$incPayment['inc_id']] += $converted_amount;
						} else {
							$accountId['income_paid'][$incPayment['inc_id']] = 0.0;
							$accountId['income_paid'][$incPayment['inc_id']] += $converted_amount;
						}
						if(isset($generalLedger[$incPayment['fkpayment_account']])) {
							$generalLedger[$incPayment['fkpayment_account']]['debit_amount'] += $converted_amount;
						} else {
							$generalLedger[$incPayment['fkpayment_account']]['debit_amount'] = 0.00;
							$generalLedger[$incPayment['fkpayment_account']]['credit_amount'] = 0.00;
							$generalLedger[$incPayment['fkpayment_account']]['debit_amount'] += $converted_amount;
						}
				}
			}

			$accountId['expense_pay'][] = 'NULL';
			$accountId['expense_paid'][] = 'NULL';
			if(isset($expenseAccountPay) && !empty($expenseAccountPay)) {
				foreach ($expenseAccountPay as $expPayment) {
						$accountId['expense_pay'][] = $expPayment['exp_id'];
						$amount = $expPayment['payment_amount'];
						if($expPayment['transaction_currency']!='SGD') {
							$converted_amount = $this->convertCurrency($amount,$expPayment['transaction_currency']);
						} else {
							$converted_amount = $amount;
						}
						if(isset($accountId['expense_paid'][$expPayment['exp_id']])) {
							$accountId['expense_paid'][$expPayment['exp_id']] += $converted_amount;
						} else {
							$accountId['expense_paid'][$expPayment['exp_id']] = 0.0;
							$accountId['expense_paid'][$expPayment['exp_id']] += $converted_amount;
						}
						if(isset($generalLedger[$expPayment['fkpayment_account']])) {
							$generalLedger[$expPayment['fkpayment_account']]['credit_amount'] += $converted_amount;
						} else {
							$generalLedger[$expPayment['fkpayment_account']]['credit_amount'] = 0.00;
							$generalLedger[$expPayment['fkpayment_account']]['debit_amount'] = 0.00;
							$generalLedger[$expPayment['fkpayment_account']]['credit_amount'] += $converted_amount;
						}
					}
			}

			$accountId['invoice_pay'][] = 'NULL';
			$accountId['invoice_paid'][] = 'NULL';
			if(isset($incomeAccountInvoicePay) && !empty($incomeAccountInvoicePay)) {
				foreach ($incomeAccountInvoicePay as $invPayment) {
						$accountId['invoice_pay'][] = $invPayment['inv_id'];
						$amount = $invPayment['payment_amount'];
						if($invPayment['transaction_currency']!='SGD') {
							$converted_amount = $this->convertCurrency($amount,$invPayment['transaction_currency']);
						} else {
							$converted_amount = $amount;
						}
						if(isset($accountId['invoice_paid'][$invPayment['inv_id']])) {
							$accountId['invoice_paid'][$invPayment['inv_id']] += $converted_amount;
						} else {
							$accountId['invoice_paid'][$invPayment['inv_id']] = 0.0;
							$accountId['invoice_paid'][$invPayment['inv_id']] += $converted_amount;
						}
						if(isset($generalLedger[$invPayment['fkpayment_account']])) {
							$generalLedger[$invPayment['fkpayment_account']]['debit_amount'] += $converted_amount;
						} else {
							$generalLedger[$invPayment['fkpayment_account']]['debit_amount'] = 0.00;
							$generalLedger[$invPayment['fkpayment_account']]['credit_amount'] = 0.00;
							$generalLedger[$invPayment['fkpayment_account']]['debit_amount'] += $converted_amount;
						}
					}
			}


			if(isset($journalAccount) && !empty($journalAccount)) {
				foreach ($journalAccount as $journal) {
					if(isset($generalLedger[$journal['fkaccount_id']])) {
						$generalLedger[$journal['fkaccount_id']]['debit_amount'] += $journal['debit'];
						$generalLedger[$journal['fkaccount_id']]['credit_amount'] += $journal['credit'];
					} else {
						$generalLedger[$journal['fkaccount_id']]['debit_amount'] = 0.00;
						$generalLedger[$journal['fkaccount_id']]['credit_amount'] = 0.00;
						$generalLedger[$journal['fkaccount_id']]['debit_amount'] += $journal['debit'];
						$generalLedger[$journal['fkaccount_id']]['credit_amount'] += $journal['credit'];
					}
				}
			}

			$generalLedger['accountReceivables']['debit_amount'] = 0.00;
			$generalLedger['accountReceivables']['credit_amount'] = 0.00;
			$generalLedger['accountPayables']['debit_amount'] = 0.00;
			$generalLedger['accountPayables']['credit_amount'] = 0.00;
			$generalLedger['gstPayables']['debit_amount'] = 0.00;
			$generalLedger['gstPayables']['credit_amount'] = 0.00;


			if(isset($incomeAccountEntry) && !empty($incomeAccountEntry)) {
				foreach ($incomeAccountEntry as $incomeEntry) {
						$amount = $incomeEntry['amount'];
						if($incomeEntry['transaction_currency']!='SGD') {
							$converted_amount = $this->convertCurrency($amount,$incomeEntry['transaction_currency']);
						} else {
							$converted_amount = $amount;
						}
					  if(($incomeEntry['account_entry_id']==3) && (isset($accountId['income_paid'][$incomeEntry['inc_id']]))) {
							$generalLedger['accountReceivables']['credit_amount'] += $accountId['income_paid'][$incomeEntry['inc_id']];
					  }
						if($incomeEntry['account_entry_id']==1 && (in_array($incomeEntry['inc_id'], $accountId['income']))) {
							$generalLedger['accountReceivables']['debit_amount'] += $converted_amount;
							
						} else if($incomeEntry['account_entry_id']==3) {
							
						} else if($incomeEntry['account_entry_id']==4 && (in_array($incomeEntry['inc_id'], $accountId['income']))) {
								$generalLedger['gstPayables']['credit_amount'] += $converted_amount;
						}	
				}
			}

			if(isset($expenseAccountEntry) && !empty($expenseAccountEntry)) {
				foreach ($expenseAccountEntry as $expenseEntry) {
					$amount = $expenseEntry['amount'];
					if($expenseEntry['transaction_currency']!='SGD') {
						$converted_amount = $this->convertCurrency($amount,$expenseEntry['transaction_currency']);
					} else {
						$converted_amount = $amount;
					}
					   if(($expenseEntry['account_entry_id']==3) && isset($accountId['expense_paid'][$expenseEntry['exp_id']])) {	
							$generalLedger['accountPayables']['debit_amount'] += $accountId['expense_paid'][$expenseEntry['exp_id']];
						}
						if($expenseEntry['account_entry_id']==2 && (in_array($expenseEntry['exp_id'], $accountId['expense']))) {
								$generalLedger['accountPayables']['credit_amount'] += $converted_amount;
						} else if($expenseEntry['account_entry_id']==3 && (in_array($expenseEntry['exp_id'], $accountId['expense']))) {
							
						} 	
				}
			}

			if(isset($invoiceAccountEntry) && !empty($invoiceAccountEntry)) {
				foreach ($invoiceAccountEntry as $invoiceEntry) {
					$amount = $invoiceEntry['amount'];
					if($invoiceEntry['transaction_currency']!='SGD') {
						$converted_amount = $this->convertCurrency($amount,$invoiceEntry['transaction_currency']);
					} else {
						$converted_amount = $amount;
					}
						if(($invoiceEntry['account_entry_id']==3) && (isset($accountId['invoice_paid'][$invoiceEntry['inv_id']]))) {

							$generalLedger['accountReceivables']['credit_amount'] += $accountId['invoice_paid'][$invoiceEntry['inv_id']];
						}
						if($invoiceEntry['account_entry_id']==1 && (in_array($invoiceEntry['inv_id'], $accountId['invoice']))) {
							$generalLedger['accountReceivables']['debit_amount'] += $converted_amount;
							
						} else if($invoiceEntry['account_entry_id']==3) {
							
						} else if($invoiceEntry['account_entry_id']==4 && (in_array($invoiceEntry['inv_id'], $accountId['invoice']))) {
								$generalLedger['gstPayables']['credit_amount'] += $converted_amount;
						}
				}
			}

			if(isset($creditAccountEntry) && !empty($creditAccountEntry)) {
				foreach ($creditAccountEntry as $creditEntry) {
					$amount = $creditEntry['amount'];
					if($creditEntry['transaction_currency']!='SGD') {
						$converted_amount = $this->convertCurrency($amount,$creditEntry['transaction_currency']);
					} else {
						$converted_amount = $amount;
					}
					if($creditEntry['account_entry_id']==1) {
						$generalLedger['accountReceivables']['credit_amount'] += $converted_amount;
					} else if($creditEntry['account_entry_id']==4) {
						$generalLedger['gstPayables']['debit_amount'] += $converted_amount;
					}	
				}
			}




			$this->getAccount	=  $this->report->getAllAccounts();
			$this->generalAccount	=  $generalLedger; 


			$company  =  $this->account->getCompany($id);
			$customers  =  $this->report->getCustomers();
			$vendors  =  $this->report->getVendors();

				$objPHPExcel  =new PHPExcel();


				 $product_version = "Xpand Accounting V-".$company[0]['id'];
				 $iras_version = "V1.0.0.";
				 $address = $company[0]['block_no'].' '.$company[0]['street_name'].' '.$company[0]['level'].' '.$company[0]['unit_no'].' '.$company[0]['city'].' '.$company[0]['zip_code'].' '.$company[0]['region'].' '.$company[0]['country'];
			     $objWorkSheet = $objPHPExcel->createSheet(0);

			     $objWorkSheet->setCellValue('A2', 'Master Company Data');

			     $objWorkSheet->setCellValue('A4', 'Company Name');
			     $objWorkSheet->setCellValue('B4', $company[0]['company_name']);
			     $objWorkSheet->setCellValue('A5', 'Company UEN');
			     $objWorkSheet->setCellValue('B5', $company[0]['company_uen']);
			     $objWorkSheet->setCellValue('A6', 'Company GST No');
			     $objWorkSheet->setCellValue('B6', $company[0]['company_gst']);
			     $objWorkSheet->setCellValue('A7', 'Company Address');
			     $objWorkSheet->setCellValue('B7', $address);
			     $objWorkSheet->setCellValue('A8', 'Financial Year');
			     $objWorkSheet->setCellValue('B8', date('Y'));
			     $objWorkSheet->setCellValue('A9', 'Start Date');
			     $objWorkSheet->setCellValue('B9', $company[0]['financial_year_start_date']);
			     $objWorkSheet->setCellValue('A10', 'End Date');
			     $objWorkSheet->setCellValue('B10', $company[0]['financial_year_end_date']);
			     $objWorkSheet->setCellValue('A11', 'Currency Code');
			     $objWorkSheet->setCellValue('B11', $company[0]['currency']);
			     $objWorkSheet->setCellValue('A12', 'Product Version');
			     $objWorkSheet->setCellValue('B12', $product_version);
			     $objWorkSheet->setCellValue('A13', 'IAF Version');
			     $objWorkSheet->setCellValue('B13', $iras_version);

			     $objWorkSheet->setTitle('Company Master');

			     $objWorkSheet = $objPHPExcel->createSheet(1);

			     $objWorkSheet->setCellValue('A2', 'Master Supplier Data');

			     $objWorkSheet->setCellValue('A4', 'Supplier ID');
			     $objWorkSheet->setCellValue('B4', 'Supplier Name');
			     $objWorkSheet->setCellValue('C4', 'Supplier UEN');
			     $objWorkSheet->setCellValue('D4', 'Supplier GST No');
			     $objWorkSheet->setCellValue('E4', 'Date GST Status Verified');
			     $objWorkSheet->setCellValue('F4', 'Address');
			     $objWorkSheet->setCellValue('G4', 'Telephone');
			     $objWorkSheet->setCellValue('H4', 'Fax');
			     $objWorkSheet->setCellValue('I4', 'Email');
			     $objWorkSheet->setCellValue('J4', 'Website');

			     $i =5;
			     foreach ($vendors as $vendor) {
			     	 $address = 
			     	 $objWorkSheet->setCellValue('A'.$i, $vendor['vendor_id']);
				     $objWorkSheet->setCellValue('B'.$i, $vendor['vendor_name']);
				     $objWorkSheet->setCellValue('C'.$i, $vendor['company_registration_no']);
				     $objWorkSheet->setCellValue('D'.$i, $vendor['company_gst_no']);
				     $objWorkSheet->setCellValue('E'.$i, date('d-m-Y',strtotime($vendor['gst_verified_date'])));
				     $objWorkSheet->setCellValue('F'.$i, $vendor['address1']);
				     $objWorkSheet->setCellValue('G'.$i, $vendor['office_number']);
				     $objWorkSheet->setCellValue('H'.$i, $vendor['fax_number']);
				     $objWorkSheet->setCellValue('I'.$i, $vendor['email']);
				     $objWorkSheet->setCellValue('J'.$i, $vendor['website']);
				     $i++;
			     }

			     $objWorkSheet->setTitle('Supplier Master');


			     $objWorkSheet = $objPHPExcel->createSheet(2);

			     $objWorkSheet->setCellValue('A2', 'Master Customer Data');

			     $objWorkSheet->setCellValue('A4', 'Customer ID');
			     $objWorkSheet->setCellValue('B4', 'Customer Name');
			     $objWorkSheet->setCellValue('C4', 'Customer UEN');
			     $objWorkSheet->setCellValue('D4', 'Customer GST No');
			     $objWorkSheet->setCellValue('E4', 'Date GST Status Verified');
			     $objWorkSheet->setCellValue('F4', 'Address');
			     $objWorkSheet->setCellValue('G4', 'Telephone');
			     $objWorkSheet->setCellValue('H4', 'Fax');
			     $objWorkSheet->setCellValue('I4', 'Email');
			     $objWorkSheet->setCellValue('J4', 'Website');

			     $i =5;
			     foreach ($customers as $customer) {
			     	 $objWorkSheet->setCellValue('A'.$i, $customer['customer_id']);
				     $objWorkSheet->setCellValue('B'.$i, $customer['customer_name']);
				     $objWorkSheet->setCellValue('C'.$i, $customer['company_registration_no']);
				     $objWorkSheet->setCellValue('D'.$i, $customer['company_gst_no']);
				     $objWorkSheet->setCellValue('E'.$i, date('d-m-Y',strtotime($customer['gst_verified_date'])));
				     $objWorkSheet->setCellValue('F'.$i, $customer['address1']);
				     $objWorkSheet->setCellValue('G'.$i, $customer['office_number']);
				     $objWorkSheet->setCellValue('H'.$i, $customer['fax_number']);
				     $objWorkSheet->setCellValue('I'.$i, $customer['email']);
				     $objWorkSheet->setCellValue('J'.$i, $customer['website']);
				     $i++;
			     }

			     $objWorkSheet->setTitle('Customer Master');


			     $objWorkSheet = $objPHPExcel->createSheet(3);

			     $objWorkSheet->setCellValue('A2', 'Master General Ledger Data');

			     $objWorkSheet->setCellValue('A4', 'Account Name');
			     $objWorkSheet->setCellValue('B4', 'Account Type');
			     $objWorkSheet->setCellValue('C4', 'Opening Debit Balance');
			     $objWorkSheet->setCellValue('D4', 'Opening Credit Balance');

                  $debit_amount = 0.00;
                  $credit_amount = 0.00;
                  $j=5;
                  foreach ($this->generalAccount as $key => $general) {
                    $i = 0;
                    $debit_amount += $general['debit_amount'];
                    $credit_amount += $general['credit_amount'];
                       foreach ($this->getAccount as $account) {
                          if($key==$account['id']) {
                            $acc_type = $account['account_type'];
                             $objWorkSheet->setCellValue('A'.$j, $account['account_name']);
                            $i=1;
                          }
                       }

                       if($i==0) {
                          if($key=='accountReceivables') {
                            $acc_type = 1;
                            $objWorkSheet->setCellValue('A'.$j, "Account Receivables");
                          } else if($key=='accountPayables') {
                            $acc_type = 2;
                            $objWorkSheet->setCellValue('A'.$j, "Account Payables");
                          } else if($key=='gstPayables') {
                            $acc_type = 3;
                            $objWorkSheet->setCellValue('A'.$j, "GST Payables");
                          }
                       }

                    if($acc_type==1) {
                    	$objWorkSheet->setCellValue('B'.$j, "Assets");
                    } else if($acc_type==2) {
                    	$objWorkSheet->setCellValue('B'.$j, "Liabilities");
                    } else if($acc_type==3) {
                    	$objWorkSheet->setCellValue('B'.$j, "Income");
                    } else if($acc_type==4) {
                    	$objWorkSheet->setCellValue('B'.$j, "Expense");
                    } else if($acc_type==5) {
                    	$objWorkSheet->setCellValue('B'.$j, "Equity");
                    }

                   $objWorkSheet->setCellValue('C'.$j, $general['debit_amount']);
                   $objWorkSheet->setCellValue('D'.$j, $general['credit_amount']);

                   $j++;
                   }

                    $objWorkSheet->setTitle('General Ledger');

                   


					$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 


                    if(!$objWriter->save('public/uploads/'.$logSession->cid.'/irasexcel.xlsx')) {
					
						$this->view->excel = 'public/uploads/'.$logSession->cid.'/irasexcel.xlsx';	
				
					}		*/
			//echo '<pre>'; print_r($company); echo '</pre>';
           // echo '<pre>'; print_r($customers); echo '</pre>';
           // echo '<pre>'; print_r($vendors); echo '</pre>';
		}
	}

	public function irasAuditFileExcelAction($fromDate='',$toDate='',$reportType='') {
		if(!Zend_Session::namespaceIsset('sess_login')) {
			 $this->_redirect('index');
		} else {
			$logSession = new Zend_Session_Namespace('sess_login');
			if(isset($logSession->proxy_cid) && !empty($logSession->proxy_cid)) {
				$id = $logSession->proxy_cid;
			} else {
				$id = $logSession->cid;
			}
		    $generalLedger = array();
			$accountId      = array();
			$report    = $this->_getParam('reportType');
			$fromDate  = $this->_getParam('fromDate');
			$toDate    = $this->_getParam('toDate');
			$reportArray = explode(',', $report);
		//	print_r($reportArray); 

			if(isset($fromDate) && isset($toDate) && !empty($fromDate) && !empty($toDate)) {
				$from = date('Y-m-d',strtotime($fromDate));
				$to = date('Y-m-d',strtotime($toDate));
			} else {
				$from = date('Y-01-01');
			    $to = date('Y-m-d');
			}
			if($this->_request->isPost()) {
				$postArray  = $this->getRequest()->getPost();
				$from = date('Y-m-d',strtotime($postArray['from_date']));
				$to = date('Y-m-d',strtotime($postArray['to_date']));
			}
			$this->view->from = date('d-m-Y',strtotime($from));
			$this->view->to = date('d-m-Y',strtotime($to));

			if(in_array(4, $reportArray) || in_array(5, $reportArray)) {	

			$incomeAccountIncome  = $this->report->getGeneralIncomeAccount($from,$to);
			$incomeAccountInvoice = $this->report->getGeneralInvoiceIncomeAccount($from,$to);
			$incomeAccountCredit  = $this->report->getGeneralCreditAccount($from,$to);
			$expenseAccount  = $this->report->getGeneralExpenseAccount($from,$to);
			$journalAccount  = $this->report->getGeneralJournalAccount($from,$to);

			$incomeAccountIncomePay  = $this->report->getGeneralIncomePayAccount($from,$to);
			$expenseAccountPay  =  $this->report->getExpensePayAccounts($from,$to);
			$incomeAccountInvoicePay  =  $this->report->getInvoicePayAccounts($from,$to);

			$incomeAccountEntry = $this->report->getAccountingEntriesIncome($from,$to);
			$expenseAccountEntry = $this->report->getAccountingEntriesExpense($from,$to);
			$invoiceAccountEntry = $this->report->getAccountingEntriesInvoice($from,$to);
			$creditAccountEntry = $this->report->getAccountingEntriesCredit($from,$to);

			$accountId['income'][] = 'NULL';
			if(isset($incomeAccountIncome) && !empty($incomeAccountIncome)) {
				foreach ($incomeAccountIncome as $income) {
					$accountId['income'][] = $income['inc_id'];
					$tax_amount = ($income['amount'] * $income['tax_value'] / 100);
					$total_income = $income['amount'];
					if($income['transaction_currency']!='SGD') {
						$converted_amount = $this->convertCurrency($total_income,$income['transaction_currency']);
					} else {
						$converted_amount = $total_income;
					}
					if(isset($generalLedger[$income['fkincome_type']])) {
						$generalLedger[$income['fkincome_type']]['credit_amount'] += $converted_amount;
						//$generalLedger[$income['fkincome_type']]['debit_amount'] = 0.00;
					} else {
						$generalLedger[$income['fkincome_type']]['credit_amount'] = 0.00;
						$generalLedger[$income['fkincome_type']]['debit_amount'] = 0.00;
						$generalLedger[$income['fkincome_type']]['credit_amount'] += $converted_amount;
					}
				}
			}
			$accountId['invoice'][] = 'NULL';
			if(isset($incomeAccountInvoice) && !empty($incomeAccountInvoice)) {
				foreach ($incomeAccountInvoice as $invoice) {
					$accountId['invoice'][] = $invoice['inv_id'];
					$amount = ($invoice['unit_price'] * $invoice['quantity'] - $invoice['discount_amount']);
					$tax_amount = ($amount * $invoice['tax_value'] / 100);
					$total_income = $amount;
					if($invoice['transaction_currency']!='SGD') {
						$converted_amount = $this->convertCurrency($total_income,$invoice['transaction_currency']);
					} else {
						$converted_amount = $total_income;
					}
					if(isset($generalLedger[$invoice['fkincomeaccount_id']])) {
						$generalLedger[$invoice['fkincomeaccount_id']]['credit_amount'] += $converted_amount;
						//$generalLedger[$invoice['fkincomeaccount_id']]['debit_amount'] = 0.00;
					} else {
						$generalLedger[$invoice['fkincomeaccount_id']]['credit_amount'] = 0.00;
						$generalLedger[$invoice['fkincomeaccount_id']]['debit_amount'] = 0.00;
						$generalLedger[$invoice['fkincomeaccount_id']]['credit_amount'] += $converted_amount;
					}
				}
			}

			if(isset($incomeAccountCredit) && !empty($incomeAccountCredit)) {
				foreach ($incomeAccountCredit as $credit) {
					$amount = ($credit['unit_price'] * $credit['quantity']);
					$tax_amount = ($amount * $credit['tax_value'] / 100);
					$total_income = $amount;
					if($credit['transaction_currency']!='SGD') {
						$converted_amount = $this->convertCurrency($total_income,$credit['transaction_currency']);
					} else {
						$converted_amount = $total_income;
					}
					//echo '<br/>'.$converted_amount;
					if(isset($generalLedger[$credit['fkincomeaccount_id']])) {
						$generalLedger[$credit['fkincomeaccount_id']]['debit_amount'] += $converted_amount;
						//$generalLedger[$credit['fkincomeaccount_id']]['credit_amount'] = 0.00;
					} else {
						$generalLedger[$credit['fkincomeaccount_id']]['credit_amount'] = 0.00;
						$generalLedger[$credit['fkincomeaccount_id']]['debit_amount'] = 0.00;
						$generalLedger[$credit['fkincomeaccount_id']]['debit_amount'] += $converted_amount;
					}
				}
			}

			$accountId['expense'][] = 'NULL';
			if(isset($expenseAccount) && !empty($expenseAccount)) {
				foreach ($expenseAccount as $expense) {
					$accountId['expense'][] = $expense['exp_id'];
					$amount = ($expense['unit_price'] * $expense['quantity']);
					$tax_amount = ($amount * $expense['tax_value'] / 100);
					$total_income = $amount + $tax_amount;
					if($expense['transaction_currency']!='SGD') {
						$converted_amount = $this->convertCurrency($total_income,$expense['transaction_currency']);
					} else {
						$converted_amount = $total_income;
					}
					if(isset($generalLedger[$expense['fkexpense_type']])) {
						$generalLedger[$expense['fkexpense_type']]['debit_amount'] += $converted_amount;
						//$generalLedger[$expense['fkexpense_type']]['credit_amount'] = 0.00;
					} else {
						$generalLedger[$expense['fkexpense_type']]['debit_amount'] = 0.00;
						$generalLedger[$expense['fkexpense_type']]['credit_amount'] = 0.00;
						$generalLedger[$expense['fkexpense_type']]['debit_amount'] += $converted_amount;
					}
				}
			}

			$accountId['income_pay'][] = 'NULL';
			$accountId['income_paid'][] = 'NULL';
			if(isset($incomeAccountIncomePay) && !empty($incomeAccountIncomePay)) {
				foreach ($incomeAccountIncomePay as $incPayment) {
						$accountId['income_pay'][] = $incPayment['inc_id'];
						$amount = $incPayment['payment_amount'];
						if($incPayment['transaction_currency']!='SGD') {
							$converted_amount = $this->convertCurrency($amount,$incPayment['transaction_currency']);
						} else {
							$converted_amount = $amount;
						}
						if(isset($accountId['income_paid'][$incPayment['inc_id']])) {
							$accountId['income_paid'][$incPayment['inc_id']] += $converted_amount;
						} else {
							$accountId['income_paid'][$incPayment['inc_id']] = 0.0;
							$accountId['income_paid'][$incPayment['inc_id']] += $converted_amount;
						}
						if(isset($generalLedger[$incPayment['fkpayment_account']])) {
							$generalLedger[$incPayment['fkpayment_account']]['debit_amount'] += $converted_amount;
							//$generalLedger[$incPayment['fkpayment_account']]['credit_amount'] += 0.00;
						} else {
							$generalLedger[$incPayment['fkpayment_account']]['debit_amount'] = 0.00;
							$generalLedger[$incPayment['fkpayment_account']]['credit_amount'] = 0.00;
							$generalLedger[$incPayment['fkpayment_account']]['debit_amount'] += $converted_amount;
						}
				}
			}

			$accountId['expense_pay'][] = 'NULL';
			$accountId['expense_paid'][] = 'NULL';
			if(isset($expenseAccountPay) && !empty($expenseAccountPay)) {
				foreach ($expenseAccountPay as $expPayment) {
						$accountId['expense_pay'][] = $expPayment['exp_id'];
						$amount = $expPayment['payment_amount'];
						if($expPayment['transaction_currency']!='SGD') {
							$converted_amount = $this->convertCurrency($amount,$expPayment['transaction_currency']);
						} else {
							$converted_amount = $amount;
						}
						if(isset($accountId['expense_paid'][$expPayment['exp_id']])) {
							$accountId['expense_paid'][$expPayment['exp_id']] += $converted_amount;
						} else {
							$accountId['expense_paid'][$expPayment['exp_id']] = 0.0;
							$accountId['expense_paid'][$expPayment['exp_id']] += $converted_amount;
						}
						if(isset($generalLedger[$expPayment['fkpayment_account']])) {
							$generalLedger[$expPayment['fkpayment_account']]['credit_amount'] += $converted_amount;
							//$generalLedger[$expPayment['fkpayment_account']]['debit_amount'] += 0.00;
						} else {
							$generalLedger[$expPayment['fkpayment_account']]['credit_amount'] = 0.00;
							$generalLedger[$expPayment['fkpayment_account']]['debit_amount'] = 0.00;
							$generalLedger[$expPayment['fkpayment_account']]['credit_amount'] += $converted_amount;
						}
					}
			}

			$accountId['invoice_pay'][] = 'NULL';
			$accountId['invoice_paid'][] = 'NULL';
			if(isset($incomeAccountInvoicePay) && !empty($incomeAccountInvoicePay)) {
				foreach ($incomeAccountInvoicePay as $invPayment) {
						$accountId['invoice_pay'][] = $invPayment['inv_id'];
						$amount = $invPayment['payment_amount'];
						if($invPayment['transaction_currency']!='SGD') {
							$converted_amount = $this->convertCurrency($amount,$invPayment['transaction_currency']);
						} else {
							$converted_amount = $amount;
						}
						if(isset($accountId['invoice_paid'][$invPayment['inv_id']])) {
							$accountId['invoice_paid'][$invPayment['inv_id']] += $converted_amount;
						} else {
							$accountId['invoice_paid'][$invPayment['inv_id']] = 0.0;
							$accountId['invoice_paid'][$invPayment['inv_id']] += $converted_amount;
						}
						if(isset($generalLedger[$invPayment['fkpayment_account']])) {
							$generalLedger[$invPayment['fkpayment_account']]['debit_amount'] += $converted_amount;
							//$generalLedger[$invPayment['fkpayment_account']]['credit_amount'] += 0.00;
						} else {
							$generalLedger[$invPayment['fkpayment_account']]['debit_amount'] = 0.00;
							$generalLedger[$invPayment['fkpayment_account']]['credit_amount'] = 0.00;
							$generalLedger[$invPayment['fkpayment_account']]['debit_amount'] += $converted_amount;
						}
					}
			}


			if(isset($journalAccount) && !empty($journalAccount)) {
				foreach ($journalAccount as $journal) {
					if(isset($generalLedger[$journal['fkaccount_id']])) {
						$generalLedger[$journal['fkaccount_id']]['debit_amount'] += $journal['debit'];
						$generalLedger[$journal['fkaccount_id']]['credit_amount'] += $journal['credit'];
					} else {
						$generalLedger[$journal['fkaccount_id']]['debit_amount'] = 0.00;
						$generalLedger[$journal['fkaccount_id']]['credit_amount'] = 0.00;
						$generalLedger[$journal['fkaccount_id']]['debit_amount'] += $journal['debit'];
						$generalLedger[$journal['fkaccount_id']]['credit_amount'] += $journal['credit'];
					}
				}
			}

			$generalLedger['accountReceivables']['debit_amount'] = 0.00;
			$generalLedger['accountReceivables']['credit_amount'] = 0.00;
			$generalLedger['accountPayables']['debit_amount'] = 0.00;
			$generalLedger['accountPayables']['credit_amount'] = 0.00;
		//	$generalLedger['cash']['debit_amount'] = 0.00;
		//	$generalLedger['cash']['credit_amount'] = 0.00;
			$generalLedger['gstPayables']['debit_amount'] = 0.00;
			$generalLedger['gstPayables']['credit_amount'] = 0.00;
		//	$generalLedger['sales']['debit_amount'] = 0.00;
		//	$generalLedger['sales']['credit_amount'] = 0.00;

		/*	echo '<pre>'; print_r($accountId); echo '</pre>';
			if(in_array(5, $accountId['income'])) {
				echo "string";
			}*/

			if(isset($incomeAccountEntry) && !empty($incomeAccountEntry)) {
				foreach ($incomeAccountEntry as $incomeEntry) {
					//echo $incomeEntry['inc_id'];
						$amount = $incomeEntry['amount'];
						if($incomeEntry['transaction_currency']!='SGD') {
							$converted_amount = $this->convertCurrency($amount,$incomeEntry['transaction_currency']);
						} else {
							$converted_amount = $amount;
						}
					//if((!in_array($incomeEntry['inc_id'], $accountId['income']))) {
					//	if(($incomeEntry['account_entry_id']==3) && (in_array($incomeEntry['inc_id'], $accountId['income_pay'])) && (isset($accountId['income_paid'][$incomeEntry['inc_id']]))) {
					  if(($incomeEntry['account_entry_id']==3) && (isset($accountId['income_paid'][$incomeEntry['inc_id']]))) {
							$generalLedger['accountReceivables']['credit_amount'] += $accountId['income_paid'][$incomeEntry['inc_id']];
					  }
					/*	} 
					} else {*/
						if($incomeEntry['account_entry_id']==1 && (in_array($incomeEntry['inc_id'], $accountId['income']))) {
							$generalLedger['accountReceivables']['debit_amount'] += $converted_amount;
							
						} else if($incomeEntry['account_entry_id']==3) {
								//$generalLedger['accountReceivables']['credit_amount'] += $converted_amount;
							
						} else if($incomeEntry['account_entry_id']==4 && (in_array($incomeEntry['inc_id'], $accountId['income']))) {
								$generalLedger['gstPayables']['credit_amount'] += $converted_amount;
						}	
					//}
				}
			}

			if(isset($expenseAccountEntry) && !empty($expenseAccountEntry)) {
				foreach ($expenseAccountEntry as $expenseEntry) {
					$amount = $expenseEntry['amount'];
					if($expenseEntry['transaction_currency']!='SGD') {
						$converted_amount = $this->convertCurrency($amount,$expenseEntry['transaction_currency']);
					} else {
						$converted_amount = $amount;
					}
				//	if((!in_array($expenseEntry['exp_id'], $accountId['expense']))) {
				//		if(($expenseEntry['account_entry_id']==3) && (in_array($expenseEntry['exp_id'], $accountId['expense_pay'])) && isset($accountId['expense_paid'][$expenseEntry['exp_id']])) {
					   if(($expenseEntry['account_entry_id']==3) && isset($accountId['expense_paid'][$expenseEntry['exp_id']])) {	
							$generalLedger['accountPayables']['debit_amount'] += $accountId['expense_paid'][$expenseEntry['exp_id']];
						}
					/*		} 
					} else {*/
						if($expenseEntry['account_entry_id']==2 && (in_array($expenseEntry['exp_id'], $accountId['expense']))) {
								$generalLedger['accountPayables']['credit_amount'] += $converted_amount;
						} else if($expenseEntry['account_entry_id']==3 && (in_array($expenseEntry['exp_id'], $accountId['expense']))) {
							//	$generalLedger['accountPayables']['debit_amount'] += $converted_amount;
							
						} 	
					//}
				}
			}

			if(isset($invoiceAccountEntry) && !empty($invoiceAccountEntry)) {
				foreach ($invoiceAccountEntry as $invoiceEntry) {
					$amount = $invoiceEntry['amount'];
					if($invoiceEntry['transaction_currency']!='SGD') {
						$converted_amount = $this->convertCurrency($amount,$invoiceEntry['transaction_currency']);
					} else {
						$converted_amount = $amount;
					}
					//if((!in_array($invoiceEntry['inv_id'], $accountId['invoice']))) {
					//	if(($invoiceEntry['account_entry_id']==3) && (in_array($invoiceEntry['inv_id'], $accountId['invoice_pay'])) && (isset($accountId['invoice_paid'][$invoiceEntry['inv_id']]))) {
						if(($invoiceEntry['account_entry_id']==3) && (isset($accountId['invoice_paid'][$invoiceEntry['inv_id']]))) {

							$generalLedger['accountReceivables']['credit_amount'] += $accountId['invoice_paid'][$invoiceEntry['inv_id']];
						}
					/*	} 
					} else { */
						if($invoiceEntry['account_entry_id']==1 && (in_array($invoiceEntry['inv_id'], $accountId['invoice']))) {
							$generalLedger['accountReceivables']['debit_amount'] += $converted_amount;
							
						} else if($invoiceEntry['account_entry_id']==3) {
								//$generalLedger['accountReceivables']['credit_amount'] += $converted_amount;
							
						} else if($invoiceEntry['account_entry_id']==4 && (in_array($invoiceEntry['inv_id'], $accountId['invoice']))) {
								$generalLedger['gstPayables']['credit_amount'] += $converted_amount;
						}
					//}	
				}
			}

			if(isset($creditAccountEntry) && !empty($creditAccountEntry)) {
				foreach ($creditAccountEntry as $creditEntry) {
					$amount = $creditEntry['amount'];
					if($creditEntry['transaction_currency']!='SGD') {
						$converted_amount = $this->convertCurrency($amount,$creditEntry['transaction_currency']);
					} else {
						$converted_amount = $amount;
					}
					//echo '<br/>'.$converted_amount;
					if($creditEntry['account_entry_id']==1) {
						$generalLedger['accountReceivables']['credit_amount'] += $converted_amount;
					} else if($creditEntry['account_entry_id']==4) {
						$generalLedger['gstPayables']['debit_amount'] += $converted_amount;
					}	
				}
			}


		/*	$debit_amount = 0;
			$credit_amount = 0;

			foreach ($generalLedger as $gl) {
				$debit_amount += $gl['debit_amount'];
				$credit_amount += $gl['credit_amount'];
			} */

			$this->getAccount	=  $this->report->getAllAccounts();
			$this->generalAccount	=  $generalLedger; 

		}

		if(in_array(1, $reportArray) || in_array(5, $reportArray)) {	

			$company  =  $this->account->getCompany($id);

		}
		if(in_array(3, $reportArray) || in_array(5, $reportArray)) {	
			$customers  =  $this->report->getCustomers();
		}
		if(in_array(2, $reportArray) || in_array(5, $reportArray)) {	
			$vendors  =  $this->report->getVendors();
		}

		$j=0;

				$objPHPExcel  =new PHPExcel();

			    //$sheet = $objPHPExcel->getActiveSheet();

				if(isset($company) && !empty($company)) {
					 $product_version = "Xpand Accounting V-".$company[0]['id'];
					 $iras_version = "V1.0.0.";
					 $address = $company[0]['block_no'].' '.$company[0]['street_name'].' '.$company[0]['level'].' '.$company[0]['unit_no'].' '.$company[0]['city'].' '.$company[0]['zip_code'].' '.$company[0]['region'].' '.$company[0]['country'];
				     $objWorkSheet = $objPHPExcel->createSheet($j);

				     $objWorkSheet->setCellValue('A2', 'Master Company Data');

				     $objWorkSheet->setCellValue('A4', 'Company Name');
				     $objWorkSheet->setCellValue('B4', $company[0]['company_name']);
				     $objWorkSheet->setCellValue('A5', 'Company UEN');
				     $objWorkSheet->setCellValue('B5', $company[0]['company_uen']);
				     $objWorkSheet->setCellValue('A6', 'Company GST No');
				     $objWorkSheet->setCellValue('B6', $company[0]['company_gst']);
				     $objWorkSheet->setCellValue('A7', 'Company Address');
				     $objWorkSheet->setCellValue('B7', $address);
				     $objWorkSheet->setCellValue('A8', 'Financial Year');
				     $objWorkSheet->setCellValue('B8', date('Y'));
				     $objWorkSheet->setCellValue('A9', 'Start Date');
				     $objWorkSheet->setCellValue('B9', $company[0]['financial_year_start_date']);
				     $objWorkSheet->setCellValue('A10', 'End Date');
				     $objWorkSheet->setCellValue('B10', $company[0]['financial_year_end_date']);
				     $objWorkSheet->setCellValue('A11', 'Currency Code');
				     $objWorkSheet->setCellValue('B11', $company[0]['currency']);
				     $objWorkSheet->setCellValue('A12', 'Product Version');
				     $objWorkSheet->setCellValue('B12', $product_version);
				     $objWorkSheet->setCellValue('A13', 'IAF Version');
				     $objWorkSheet->setCellValue('B13', $iras_version);

				     $objWorkSheet->setTitle('Company Master');
				     $j++;
				}

				if(isset($vendors) && !empty($vendors)) {

			     $objWorkSheet = $objPHPExcel->createSheet($j);

			     $objWorkSheet->setCellValue('A2', 'Master Supplier Data');

			     $objWorkSheet->setCellValue('A4', 'Supplier ID');
			     $objWorkSheet->setCellValue('B4', 'Supplier Name');
			     $objWorkSheet->setCellValue('C4', 'Supplier UEN');
			     $objWorkSheet->setCellValue('D4', 'Supplier GST No');
			     $objWorkSheet->setCellValue('E4', 'Date GST Status Verified');
			     $objWorkSheet->setCellValue('F4', 'Address');
			     $objWorkSheet->setCellValue('G4', 'Telephone');
			     $objWorkSheet->setCellValue('H4', 'Fax');
			     $objWorkSheet->setCellValue('I4', 'Email');
			     $objWorkSheet->setCellValue('J4', 'Website');

			     $i =5;
			     foreach ($vendors as $vendor) {
			     	 $address = 
			     	 $objWorkSheet->setCellValue('A'.$i, $vendor['vendor_id']);
				     $objWorkSheet->setCellValue('B'.$i, $vendor['vendor_name']);
				     $objWorkSheet->setCellValue('C'.$i, $vendor['company_registration_no']);
				     $objWorkSheet->setCellValue('D'.$i, $vendor['company_gst_no']);
				     $objWorkSheet->setCellValue('E'.$i, date('d-m-Y',strtotime($vendor['gst_verified_date'])));
				     $objWorkSheet->setCellValue('F'.$i, $vendor['address1']);
				     $objWorkSheet->setCellValue('G'.$i, $vendor['office_number']);
				     $objWorkSheet->setCellValue('H'.$i, $vendor['fax_number']);
				     $objWorkSheet->setCellValue('I'.$i, $vendor['email']);
				     $objWorkSheet->setCellValue('J'.$i, $vendor['website']);
				     $i++;
			     }

			     $objWorkSheet->setTitle('Supplier Master');
			     $j++;
			  }

			  if(isset($customers) && !empty($customers)) {

			     $objWorkSheet = $objPHPExcel->createSheet($j);

			     $objWorkSheet->setCellValue('A2', 'Master Customer Data');

			     $objWorkSheet->setCellValue('A4', 'Customer ID');
			     $objWorkSheet->setCellValue('B4', 'Customer Name');
			     $objWorkSheet->setCellValue('C4', 'Customer UEN');
			     $objWorkSheet->setCellValue('D4', 'Customer GST No');
			     $objWorkSheet->setCellValue('E4', 'Date GST Status Verified');
			     $objWorkSheet->setCellValue('F4', 'Address');
			     $objWorkSheet->setCellValue('G4', 'Telephone');
			     $objWorkSheet->setCellValue('H4', 'Fax');
			     $objWorkSheet->setCellValue('I4', 'Email');
			     $objWorkSheet->setCellValue('J4', 'Website');

			     $i =5;
			     foreach ($customers as $customer) {
			     	 $objWorkSheet->setCellValue('A'.$i, $customer['customer_id']);
				     $objWorkSheet->setCellValue('B'.$i, $customer['customer_name']);
				     $objWorkSheet->setCellValue('C'.$i, $customer['company_registration_no']);
				     $objWorkSheet->setCellValue('D'.$i, $customer['company_gst_no']);
				     $objWorkSheet->setCellValue('E'.$i, date('d-m-Y',strtotime($customer['gst_verified_date'])));
				     $objWorkSheet->setCellValue('F'.$i, $customer['address1']);
				     $objWorkSheet->setCellValue('G'.$i, $customer['office_number']);
				     $objWorkSheet->setCellValue('H'.$i, $customer['fax_number']);
				     $objWorkSheet->setCellValue('I'.$i, $customer['email']);
				     $objWorkSheet->setCellValue('J'.$i, $customer['website']);
				     $i++;
			     }

			     $objWorkSheet->setTitle('Customer Master');
			     $j++;
			 }

			 if(isset($this->generalAccount) && !empty($this->generalAccount)) {
			     $objWorkSheet = $objPHPExcel->createSheet($j);

			     $objWorkSheet->setCellValue('A2', 'Master General Ledger Data');

			     $objWorkSheet->setCellValue('A4', 'Account Name');
			     $objWorkSheet->setCellValue('B4', 'Account Type');
			     $objWorkSheet->setCellValue('C4', 'Opening Debit Balance');
			     $objWorkSheet->setCellValue('D4', 'Opening Credit Balance');

                  $debit_amount = 0.00;
                  $credit_amount = 0.00;
                  $j=5;
                  foreach ($this->generalAccount as $key => $general) {
                    $i = 0;
                    $debit_amount += $general['debit_amount'];
                    $credit_amount += $general['credit_amount'];
                       foreach ($this->getAccount as $account) {
                          if($key==$account['id']) {
                            $acc_type = $account['account_type'];
                             $objWorkSheet->setCellValue('A'.$j, $account['account_name']);
                            $i=1;
                          }
                       }

                       if($i==0) {
                          if($key=='accountReceivables') {
                            $acc_type = 1;
                            $objWorkSheet->setCellValue('A'.$j, "Account Receivables");
                          } else if($key=='accountPayables') {
                            $acc_type = 2;
                            $objWorkSheet->setCellValue('A'.$j, "Account Payables");
                          } else if($key=='gstPayables') {
                            $acc_type = 3;
                            $objWorkSheet->setCellValue('A'.$j, "GST Payables");
                          }
                       }

                    if($acc_type==1) {
                    	$objWorkSheet->setCellValue('B'.$j, "Assets");
                    } else if($acc_type==2) {
                    	$objWorkSheet->setCellValue('B'.$j, "Liabilities");
                    } else if($acc_type==3) {
                    	$objWorkSheet->setCellValue('B'.$j, "Income");
                    } else if($acc_type==4) {
                    	$objWorkSheet->setCellValue('B'.$j, "Expense");
                    } else if($acc_type==5) {
                    	$objWorkSheet->setCellValue('B'.$j, "Equity");
                    }

                   $objWorkSheet->setCellValue('C'.$j, $general['debit_amount']);
                   $objWorkSheet->setCellValue('D'.$j, $general['credit_amount']);

                   $j++;
                   }

                    $objWorkSheet->setTitle('General Ledger');
                 }

                   

				 /*   //Start adding next sheets
				    $i=0;
				    while ($i < 10) {

				    // Add new sheet
				    $objWorkSheet = $objPHPExcel->createSheet($i); //Setting index when creating

				    //Write cells
				    $objWorkSheet->setCellValue('A1', 'Hello'.$i)
				            ->setCellValue('B2', 'world!')
				            ->setCellValue('C1', 'Hello')
				            ->setCellValue('D2', 'world!');

				    // Rename sheet
				    $objWorkSheet->setTitle("$i");

				    $i++;
				    } */
				    if(isset($logSession->proxy_cid) && !empty($logSession->proxy_cid)) {
						$cid = $logSession->proxy_cid;
					} else {
						$cid = $logSession->cid;
					}

					$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); 


                    if(!$objWriter->save('public/uploads/'.$cid.'/irasexcel.xlsx')) {
					
						$this->view->excel = 'public/uploads/'.$cid.'/irasexcel.xlsx';	
						$this->_redirect($this->sitePath.$this->view->excel);
				
					}		
			//echo '<pre>'; print_r($company); echo '</pre>';
           // echo '<pre>'; print_r($customers); echo '</pre>';
           // echo '<pre>'; print_r($vendors); echo '</pre>';
		}
	}

	public function irasAuditFileXmlAction($fromDate='',$toDate='',$reportType='') {
		if(!Zend_Session::namespaceIsset('sess_login')) {
			 $this->_redirect('index');
		} else {
			$logSession = new Zend_Session_Namespace('sess_login');
			if(isset($logSession->proxy_cid) && !empty($logSession->proxy_cid)) {
				$id = $logSession->proxy_cid;
			} else {
				$id = $logSession->cid;
			}
			$generalLedger  = array();
			$supplier       = array();
			$customer       = array();
			$maximumInv       = array();
			$maximumCre       = array();
			$maximumExp       = array();
			$accountId      = array();
			$customerPurchase = 0.00;
			$customerGst = 0.00;
			$customerTotal = 0;
			$supplierPurchase = 0.00;
			$supplierGst = 0.00;
			$supplierTotal = 0;
			$report    = $this->_getParam('reportType');
			$fromDate  = $this->_getParam('fromDate');
			$toDate    = $this->_getParam('toDate');
			$reportArray = explode(',', $report);
		//	print_r($reportArray); 

			if(isset($fromDate) && isset($toDate) && !empty($fromDate) && !empty($toDate)) {
				$from = date('Y-m-d',strtotime($fromDate));
				$to = date('Y-m-d',strtotime($toDate));
			} else {
				$from = date('Y-01-01');
			    $to = date('Y-m-d');
			}
			
			if($this->_request->isPost()) {
				$postArray  = $this->getRequest()->getPost();
				$from = date('Y-m-d',strtotime($postArray['from_date']));
				$to = date('Y-m-d',strtotime($postArray['to_date']));
			}
			$this->view->from = date('d-m-Y',strtotime($from));
			$this->view->to = date('d-m-Y',strtotime($to));


/*
$xml = new SimpleXMLElement('<xml/>');

for ($i = 1; $i <= 8; ++$i) {
    $track = $xml->addChild('track');
    $track->addChild('path', "song$i.mp3");
    $track->addChild('title', "Track $i - Track Title");
}
$xml->asXML("test.xml"); */
//Header('Content-type: text/xml');
//print($xml->asXML()); 


			if(in_array(1, $reportArray) || in_array(5, $reportArray)) {			

				$company  =  $this->account->getCompany($id);

			}


			if(in_array(3, $reportArray) || in_array(5, $reportArray)) {	
				$incomeIafCustomer  = $this->report->getIafIncomeCustomer($from,$to);
				$invoiceIafCustomer = $this->report->getIafInvoiceCustomer($from,$to);
				$creditIafCustomer = $this->report->getIafCreditCustomer($from,$to);
				$maxInvoice  	=  $this->report->getMaxInvoiceTransaction();
				$maxCredit  	=  $this->report->getMaxCreditTransaction();
			}

			if(in_array(2, $reportArray) || in_array(5, $reportArray)) {	
				$expenseIafVendor = $this->report->getIafExpenseVendor($from,$to);
				$maxExpense  	=  $this->report->getMaxExpenseTransaction();
			}

			//echo '<pre>'; print_r($expenseIafVendor); echo '</pre>'; die();

			if(isset($maxInvoice) && !empty($maxInvoice)) {
				foreach ($maxInvoice as $maxInv) {
					if(!array_key_exists($maxInv['fkinvoice_id'], $maximumInv)) {
						$maximumInv[$maxInv['fkinvoice_id']]['product_description'] = $maxInv['product_description'];
						$maximumInv[$maxInv['fkinvoice_id']]['tax_code'] = $maxInv['tax_code'];
					}
				}
			}

			if(isset($maxCredit) && !empty($maxCredit)) {
				foreach ($maxCredit as $maxCre) {
					if(!array_key_exists($maxCre['fkcredit_id'], $maximumCre)) {
						$maximumCre[$maxCre['fkcredit_id']]['product_description'] = $maxCre['product_description'];
						$maximumCre[$maxCre['fkcredit_id']]['tax_code'] = $maxCre['tax_code'];
					}
				}
			}


			if(isset($maxExpense) && !empty($maxExpense)) {
				foreach ($maxExpense as $maxExp) {
					if(!array_key_exists($maxExp['fkexpense_id'], $maximumExp)) {
						$maximumExp[$maxExp['fkexpense_id']]['product_description'] = $maxExp['product_description'];
						$maximumExp[$maxExp['fkexpense_id']]['tax_code'] = $maxExp['tax_code'];
					}
				}
			}

			if(isset($incomeIafCustomer) && !empty($incomeIafCustomer)) {
				foreach ($incomeIafCustomer as $income) {
					$tax_amount = ($income['amount'] * $income['tax_value'] / 100);
					$total_income = $income['amount'];
					if($income['transaction_currency']!='SGD') {
						$converted_amount = $this->convertCurrency($total_income,$income['transaction_currency']);
						$gst_amount = $this->convertCurrency($tax_amount,$income['transaction_currency']);
						$customer[$income['income_no']]['amount'] =  $converted_amount;
					    $customer[$income['income_no']]['gst'] =  $gst_amount;
					    $customer[$income['income_no']]['famount'] =  $income['amount'];
					    $customer[$income['income_no']]['fgst'] =  $income['tax_amount'];
					    $customer[$income['income_no']]['fcurrency'] =  $income['transaction_currency'];
					} else {
						$converted_amount = $total_income;
						$gst_amount = $tax_amount;
						$customer[$income['income_no']]['amount'] =  $converted_amount;
					    $customer[$income['income_no']]['gst'] =  $gst_amount;
					    $customer[$income['income_no']]['famount'] =  0;
					    $customer[$income['income_no']]['fgst'] =  0;
					    $customer[$income['income_no']]['fcurrency'] =  'XXX';
					}

					$customer[$income['income_no']]['currency'] =  $income['transaction_currency'];
					$customer[$income['income_no']]['description'] =  $income['transaction_description'];
					$customer[$income['income_no']]['date'] =  $income['date'];
					$customer[$income['income_no']]['taxcode'] =  $income['tax_code'];
					$customer[$income['income_no']]['customerName'] =  $income['customer_name'];
					$customer[$income['income_no']]['customerUEN'] =  $income['company_registration_no'];
					$customer[$income['income_no']]['lineNo'] =  1;

					$customerPurchase += $converted_amount;
					$customerGst += $gst_amount;
					$customerTotal++;

				}
			}


			if(isset($invoiceIafCustomer) && !empty($invoiceIafCustomer)) {
				foreach ($invoiceIafCustomer as $invoice) {
					$tax_amount = $invoice['tax_amount'];
					$total_income = $invoice['amount'];
					if($invoice['transaction_currency']!='SGD') {
						$converted_amount = $this->convertCurrency($total_income,$invoice['transaction_currency']);
						$gst_amount = $this->convertCurrency($tax_amount,$invoice['transaction_currency']);
						$customer[$invoice['invoice_no']]['amount'] =  $converted_amount;
					    $customer[$invoice['invoice_no']]['gst'] =  $gst_amount;
					    $customer[$invoice['invoice_no']]['famount'] =  $invoice['amount'];
					    $customer[$invoice['invoice_no']]['fgst'] =  $invoice['tax_amount'];
					    $customer[$invoice['invoice_no']]['fcurrency'] =  $invoice['transaction_currency'];
					} else {
						$converted_amount = $total_income;
						$gst_amount = $tax_amount;
						$customer[$invoice['invoice_no']]['amount'] =  $converted_amount;
					    $customer[$invoice['invoice_no']]['gst'] =  $gst_amount;
					    $customer[$invoice['invoice_no']]['famount'] =  0;
					    $customer[$invoice['invoice_no']]['fgst'] =  0;
					    $customer[$invoice['invoice_no']]['fcurrency'] =  'XXX';
					}


					$customer[$invoice['invoice_no']]['description'] =  $maximumInv[$invoice['inv_id']]['product_description'];
					$customer[$invoice['invoice_no']]['taxcode'] =  $maximumInv[$invoice['inv_id']]['tax_code'];
					$customer[$invoice['invoice_no']]['currency'] =  $invoice['transaction_currency'];
					$customer[$invoice['invoice_no']]['date'] =  $invoice['date'];
					$customer[$invoice['invoice_no']]['customerName'] =  $invoice['customer_name'];
					$customer[$invoice['invoice_no']]['customerUEN'] =  $invoice['company_registration_no'];
					$customer[$invoice['invoice_no']]['lineNo'] =  $invoice['total_count'];

					$customerPurchase += $converted_amount;
					$customerGst += $gst_amount;
					$customerTotal++;

				}
			}


			if(isset($creditIafCustomer) && !empty($creditIafCustomer)) {
				foreach ($creditIafCustomer as $credit) {
					$tax_amount = $credit['tax_amount'];
					$total_income = $credit['amount'];
					if($credit['transaction_currency']!='SGD') {
						$converted_amount = $this->convertCurrency($total_income,$credit['transaction_currency']);
						$gst_amount = $this->convertCurrency($tax_amount,$credit['transaction_currency']);
						$customer[$credit['credit_no']]['amount'] =  $converted_amount;
					    $customer[$credit['credit_no']]['gst'] =  $gst_amount;
					    $customer[$credit['credit_no']]['famount'] =  $credit['amount'];
					    $customer[$credit['credit_no']]['fgst'] =  $credit['tax_amount'];
					    $customer[$credit['credit_no']]['fcurrency'] =  $credit['transaction_currency'];
					} else {
						$converted_amount = $total_income;
						$gst_amount = $tax_amount;
						$customer[$credit['credit_no']]['amount'] =  $converted_amount;
					    $customer[$credit['credit_no']]['gst'] =  $gst_amount;
					    $customer[$credit['credit_no']]['famount'] =  0;
					    $customer[$credit['credit_no']]['fgst'] =  0;
					    $customer[$credit['credit_no']]['fcurrency'] =  'XXX';
					}


					$customer[$credit['credit_no']]['description'] =  $maximumCre[$credit['cre_id']]['product_description'];
					$customer[$credit['credit_no']]['taxcode'] =  $maximumCre[$credit['cre_id']]['tax_code'];
					$customer[$credit['credit_no']]['currency'] =  $credit['transaction_currency'];
					$customer[$credit['credit_no']]['date'] =  $credit['date'];
					$customer[$credit['credit_no']]['customerName'] =  $credit['customer_name'];
					$customer[$credit['credit_no']]['customerUEN'] =  $credit['company_registration_no'];
					$customer[$credit['credit_no']]['lineNo'] =  $credit['total_count'];

					$customerPurchase += $converted_amount;
					$customerGst += $gst_amount;
					$customerTotal++;

				}
			}

			if(isset($expenseIafVendor) && !empty($expenseIafVendor)) {
				foreach ($expenseIafVendor as $expense) {
					$tax_amount = $expense['tax_amount'];
					$total_income = $expense['amount'];
					if($expense['transaction_currency']!='SGD') {
						$converted_amount = $this->convertCurrency($total_income,$expense['transaction_currency']);
						$gst_amount = $this->convertCurrency($tax_amount,$expense['transaction_currency']);
						$supplier[$expense['expense_no']]['amount'] =  $converted_amount;
					    $supplier[$expense['expense_no']]['gst'] =  $gst_amount;
					    $supplier[$expense['expense_no']]['famount'] =  $expense['amount'];
					    $supplier[$expense['expense_no']]['fgst'] =  $expense['tax_amount'];
					    $supplier[$expense['expense_no']]['fcurrency'] =  $expense['transaction_currency'];
					} else {
						$converted_amount = $total_income;
						$gst_amount = $tax_amount;
						$supplier[$expense['expense_no']]['amount'] =  $converted_amount;
					    $supplier[$expense['expense_no']]['gst'] =  $gst_amount;
					    $supplier[$expense['expense_no']]['famount'] =  0;
					    $supplier[$expense['expense_no']]['fgst'] =  0;
					    $supplier[$expense['expense_no']]['fcurrency'] =  'XXX';
					}


					$supplier[$expense['expense_no']]['description'] =  $maximumExp[$expense['exp_id']]['product_description'];
					$supplier[$expense['expense_no']]['taxcode'] =  $maximumExp[$expense['exp_id']]['tax_code'];
					$supplier[$expense['expense_no']]['currency'] =  $expense['transaction_currency'];
					$supplier[$expense['expense_no']]['date'] =  $expense['date'];
					$supplier[$expense['expense_no']]['supplierName'] =  $expense['vendor_name'];
					$supplier[$expense['expense_no']]['supplierUEN'] =  $expense['company_registration_no'];
					$supplier[$expense['expense_no']]['lineNo'] =  $expense['total_count'];

					$supplierPurchase += $converted_amount;
					$supplierGst += $gst_amount;
					$supplierTotal++;

				}
			}


			if(in_array(4, $reportArray) || in_array(5, $reportArray)) {	

			$generalLedger = array();
			$accountId     = array();

			$incomeAccountIncome  = $this->report->getIafIncomeAccount($from,$to);
			$incomeAccountInvoice = $this->report->getIafInvoiceIncomeAccount($from,$to);
			$incomeAccountCredit  = $this->report->getIafCreditAccount($from,$to);
			$expenseAccount  = $this->report->getIafExpenseAccount($from,$to);

			$incomeAccountIncomePay  = $this->report->getIafIncomePayAccount($from,$to);
			$expenseAccountPay  =  $this->report->getIafExpensePayAccounts($from,$to);
			$incomeAccountInvoicePay  =  $this->report->getIafInvoicePayAccounts($from,$to);

			$incomeAccountEntry = $this->report->getIafAccountingEntriesIncome($from,$to);
			$expenseAccountEntry = $this->report->getIafAccountingEntriesExpense($from,$to);
			$invoiceAccountEntry = $this->report->getIafAccountingEntriesInvoice($from,$to);
			$creditAccountEntry = $this->report->getIafAccountingEntriesCredit($from,$to);

			
			$j=1;
			$accountId['income'][] = 'NULL';
			if(isset($incomeAccountIncome) && !empty($incomeAccountIncome)) {
				foreach ($incomeAccountIncome as $income) {
					$accountId['income'][] = $income['inc_id'];
					$tax_amount = ($income['amount'] * $income['tax_value'] / 100);
					$total_income = $income['amount'];
					if($income['transaction_currency']!='SGD') {
						$converted_amount = $this->convertCurrency($total_income,$income['transaction_currency']);
					} else {
						$converted_amount = $total_income;
					}
					/*if(isset($generalLedger[$income['fkincome_type']])) {
						$generalLedger[$income['fkincome_type']]['credit_amount'] += $converted_amount;
						//$generalLedger[$income['fkincome_type']]['debit_amount'] = 0.00;
					} else {
						$generalLedger[$income['fkincome_type']]['credit_amount'] = 0.00;
						$generalLedger[$income['fkincome_type']]['debit_amount'] = 0.00;
						$generalLedger[$income['fkincome_type']]['credit_amount'] += $converted_amount;
					}*/
					$generalLedger[$j]['transaction_id'] = $income['income_no'];
					$generalLedger[$j]['account_id'] = $income['fkincome_type'];
					$generalLedger[$j]['description'] = $income['transaction_description'];
					$generalLedger[$j]['debit_amount'] = 0.00;
					$generalLedger[$j]['credit_amount'] = $converted_amount;
					$generalLedger[$j]['date'] = $income['date'];
					$generalLedger[$j]['name'] = $income['customer_name'];
					$j++;
				}
			}
			$accountId['invoice'][] = 'NULL';
			if(isset($incomeAccountInvoice) && !empty($incomeAccountInvoice)) {
				foreach ($incomeAccountInvoice as $invoice) {
					$accountId['invoice'][] = $invoice['inv_id'];
					$amount = ($invoice['unit_price'] * $invoice['quantity'] - $invoice['discount_amount']);
					$tax_amount = ($amount * $invoice['tax_value'] / 100);
					$total_income = $amount;
					if($invoice['transaction_currency']!='SGD') {
						$converted_amount = $this->convertCurrency($total_income,$invoice['transaction_currency']);
					} else {
						$converted_amount = $total_income;
					}
					/*if(isset($generalLedger[$invoice['fkincomeaccount_id']])) {
						$generalLedger[$invoice['fkincomeaccount_id']]['credit_amount'] += $converted_amount;
						//$generalLedger[$invoice['fkincomeaccount_id']]['debit_amount'] = 0.00;
					} else {
						$generalLedger[$invoice['fkincomeaccount_id']]['credit_amount'] = 0.00;
						$generalLedger[$invoice['fkincomeaccount_id']]['debit_amount'] = 0.00;
						$generalLedger[$invoice['fkincomeaccount_id']]['credit_amount'] += $converted_amount;
					}*/
					$generalLedger[$j]['account_id'] = $invoice['fkincomeaccount_id'];
					$generalLedger[$j]['transaction_id'] = $invoice['invoice_no'];
					$generalLedger[$j]['description'] = $invoice['description'];
					$generalLedger[$j]['debit_amount'] = 0.00;
					$generalLedger[$j]['credit_amount'] = $converted_amount;
					$generalLedger[$j]['date'] = $invoice['date'];
					$generalLedger[$j]['name'] = $invoice['customer_name'];
					$j++;
				}
			}

			if(isset($incomeAccountCredit) && !empty($incomeAccountCredit)) {
				foreach ($incomeAccountCredit as $credit) {
					$amount = ($credit['unit_price'] * $credit['quantity']);
					$tax_amount = ($amount * $credit['tax_value'] / 100);
					$total_income = $amount;
					if($credit['transaction_currency']!='SGD') {
						$converted_amount = $this->convertCurrency($total_income,$credit['transaction_currency']);
					} else {
						$converted_amount = $total_income;
					}
					//echo '<br/>'.$converted_amount;
					/*if(isset($generalLedger[$credit['fkincomeaccount_id']])) {
						$generalLedger[$credit['fkincomeaccount_id']]['debit_amount'] += $converted_amount;
						//$generalLedger[$credit['fkincomeaccount_id']]['credit_amount'] = 0.00;
					} else {
						$generalLedger[$credit['fkincomeaccount_id']]['credit_amount'] = 0.00;
						$generalLedger[$credit['fkincomeaccount_id']]['debit_amount'] = 0.00;
						$generalLedger[$credit['fkincomeaccount_id']]['debit_amount'] += $converted_amount;
					}*/
					$generalLedger[$j]['account_id'] = $credit['fkincomeaccount_id'];
					$generalLedger[$j]['transaction_id'] = $credit['credit_no'];
					$generalLedger[$j]['description'] = $credit['description'];
					$generalLedger[$j]['credit_amount'] = 0.00;
					$generalLedger[$j]['debit_amount'] = $converted_amount;
					$generalLedger[$j]['date'] = $credit['date'];
					$generalLedger[$j]['name'] = $credit['customer_name'];
					$j++;
				}
			}

			$accountId['expense'][] = 'NULL';
			if(isset($expenseAccount) && !empty($expenseAccount)) {
				foreach ($expenseAccount as $expense) {
					$accountId['expense'][] = $expense['exp_id'];
					$amount = ($expense['unit_price'] * $expense['quantity']);
					$tax_amount = ($amount * $expense['tax_value'] / 100);
					$total_income = $amount + $tax_amount;
					if($expense['transaction_currency']!='SGD') {
						$converted_amount = $this->convertCurrency($total_income,$expense['transaction_currency']);
					} else {
						$converted_amount = $total_income;
					}
					/*if(isset($generalLedger[$expense['fkexpense_type']])) {
						$generalLedger[$expense['fkexpense_type']]['debit_amount'] += $converted_amount;
						//$generalLedger[$expense['fkexpense_type']]['credit_amount'] = 0.00;
					} else {
						$generalLedger[$expense['fkexpense_type']]['debit_amount'] = 0.00;
						$generalLedger[$expense['fkexpense_type']]['credit_amount'] = 0.00;
						$generalLedger[$expense['fkexpense_type']]['debit_amount'] += $converted_amount;
					}*/
					$generalLedger[$j]['account_id'] = $expense['fkexpense_type'];
					$generalLedger[$j]['transaction_id'] = $expense['expense_no'];
					$generalLedger[$j]['description'] = '';
					$generalLedger[$j]['credit_amount'] = 0.00;
					$generalLedger[$j]['debit_amount'] = $converted_amount;
					$generalLedger[$j]['date'] = $expense['date'];
					$generalLedger[$j]['name'] = $expense['vendor_name'];
					$j++;


				}
			}

			$accountId['income_pay'][] = 'NULL';
			$accountId['income_paid'][] = 'NULL';
			if(isset($incomeAccountIncomePay) && !empty($incomeAccountIncomePay)) {
				foreach ($incomeAccountIncomePay as $incPayment) {
						$accountId['income_pay'][] = $incPayment['inc_id'];
						$amount = $incPayment['payment_amount'];
						if($incPayment['transaction_currency']!='SGD') {
							$converted_amount = $this->convertCurrency($amount,$incPayment['transaction_currency']);
						} else {
							$converted_amount = $amount;
						}
						if(isset($accountId['income_paid'][$incPayment['inc_id']])) {
							$accountId['income_paid'][$incPayment['inc_id']] += $converted_amount;
						} else {
							$accountId['income_paid'][$incPayment['inc_id']] = 0.0;
							$accountId['income_paid'][$incPayment['inc_id']] += $converted_amount;
						}
						/*if(isset($generalLedger[$incPayment['fkpayment_account']])) {
							$generalLedger[$incPayment['fkpayment_account']]['debit_amount'] += $converted_amount;
							//$generalLedger[$incPayment['fkpayment_account']]['credit_amount'] += 0.00;
						} else {
							$generalLedger[$incPayment['fkpayment_account']]['debit_amount'] = 0.00;
							$generalLedger[$incPayment['fkpayment_account']]['credit_amount'] = 0.00;
							$generalLedger[$incPayment['fkpayment_account']]['debit_amount'] += $converted_amount;
						}*/
					$generalLedger[$j]['account_id'] = $incPayment['fkpayment_account'];
					$generalLedger[$j]['transaction_id'] = $incPayment['income_no'];
					$generalLedger[$j]['description'] = 'Payment for transaction no '.$incPayment['income_no'];
					$generalLedger[$j]['credit_amount'] = 0.00;
					$generalLedger[$j]['debit_amount'] = $converted_amount;
					$generalLedger[$j]['date'] = $incPayment['pay_date'];
					$generalLedger[$j]['name'] = $incPayment['customer_name'];
					$j++;
				}
			}

			$accountId['expense_pay'][] = 'NULL';
			$accountId['expense_paid'][] = 'NULL';
			if(isset($expenseAccountPay) && !empty($expenseAccountPay)) {
				foreach ($expenseAccountPay as $expPayment) {
						$accountId['expense_pay'][] = $expPayment['exp_id'];
						$amount = $expPayment['payment_amount'];
						if($expPayment['transaction_currency']!='SGD') {
							$converted_amount = $this->convertCurrency($amount,$expPayment['transaction_currency']);
						} else {
							$converted_amount = $amount;
						}
						if(isset($accountId['expense_paid'][$expPayment['exp_id']])) {
							$accountId['expense_paid'][$expPayment['exp_id']] += $converted_amount;
						} else {
							$accountId['expense_paid'][$expPayment['exp_id']] = 0.0;
							$accountId['expense_paid'][$expPayment['exp_id']] += $converted_amount;
						}
						/*if(isset($generalLedger[$expPayment['fkpayment_account']])) {
							$generalLedger[$expPayment['fkpayment_account']]['credit_amount'] += $converted_amount;
							//$generalLedger[$expPayment['fkpayment_account']]['debit_amount'] += 0.00;
						} else {
							$generalLedger[$expPayment['fkpayment_account']]['credit_amount'] = 0.00;
							$generalLedger[$expPayment['fkpayment_account']]['debit_amount'] = 0.00;
							$generalLedger[$expPayment['fkpayment_account']]['credit_amount'] += $converted_amount;
						}*/
					$generalLedger[$j]['account_id'] = $expPayment['fkpayment_account'];
					$generalLedger[$j]['transaction_id'] = $expPayment['expense_no'];
					$generalLedger[$j]['description'] = 'Payment for transaction no '.$expPayment['expense_no'];
					$generalLedger[$j]['debit_amount'] = 0.00;
					$generalLedger[$j]['credit_amount'] = $converted_amount;
					$generalLedger[$j]['date'] = $expPayment['pay_date'];
					$generalLedger[$j]['name'] = $expPayment['vendor_name'];
					$j++;
					}
			}

			$accountId['invoice_pay'][] = 'NULL';
			$accountId['invoice_paid'][] = 'NULL';
			if(isset($incomeAccountInvoicePay) && !empty($incomeAccountInvoicePay)) {
				foreach ($incomeAccountInvoicePay as $invPayment) {
						$accountId['invoice_pay'][] = $invPayment['inv_id'];
						$amount = $invPayment['payment_amount'];
						if($invPayment['transaction_currency']!='SGD') {
							$converted_amount = $this->convertCurrency($amount,$invPayment['transaction_currency']);
						} else {
							$converted_amount = $amount;
						}
						if(isset($accountId['invoice_paid'][$invPayment['inv_id']])) {
							$accountId['invoice_paid'][$invPayment['inv_id']] += $converted_amount;
						} else {
							$accountId['invoice_paid'][$invPayment['inv_id']] = 0.0;
							$accountId['invoice_paid'][$invPayment['inv_id']] += $converted_amount;
						}
						/*if(isset($generalLedger[$invPayment['fkpayment_account']])) {
							$generalLedger[$invPayment['fkpayment_account']]['debit_amount'] += $converted_amount;
							//$generalLedger[$invPayment['fkpayment_account']]['credit_amount'] += 0.00;
						} else {
							$generalLedger[$invPayment['fkpayment_account']]['debit_amount'] = 0.00;
							$generalLedger[$invPayment['fkpayment_account']]['credit_amount'] = 0.00;
							$generalLedger[$invPayment['fkpayment_account']]['debit_amount'] += $converted_amount;
						}*/
					$generalLedger[$j]['account_id'] = $invPayment['fkpayment_account'];
					$generalLedger[$j]['transaction_id'] = $invPayment['invoice_no'];
					$generalLedger[$j]['description'] = 'Payment for transaction no '.$invPayment['invoice_no'];
					$generalLedger[$j]['credit_amount'] = 0.00;
					$generalLedger[$j]['debit_amount'] = $converted_amount;
					$generalLedger[$j]['date'] = $invPayment['pay_date'];
					$generalLedger[$j]['name'] = $invPayment['customer_name'];
					$j++;
					}
			}


			/*$generalLedger['accountReceivables']['debit_amount'] = 0.00;
			$generalLedger['accountReceivables']['credit_amount'] = 0.00;
			$generalLedger['accountPayables']['debit_amount'] = 0.00;
			$generalLedger['accountPayables']['credit_amount'] = 0.00;
			$generalLedger['gstPayables']['debit_amount'] = 0.00;
			$generalLedger['gstPayables']['credit_amount'] = 0.00;
*/

			if(isset($incomeAccountEntry) && !empty($incomeAccountEntry)) {
				foreach ($incomeAccountEntry as $incomeEntry) {
						$amount = $incomeEntry['amount'];
						if($incomeEntry['transaction_currency']!='SGD') {
							$converted_amount = $this->convertCurrency($amount,$incomeEntry['transaction_currency']);
						} else {
							$converted_amount = $amount;
						}
					

					  if(($incomeEntry['account_entry_id']==3) && (isset($accountId['income_paid'][$incomeEntry['inc_id']]))) {
							   $generalLedger[$j]['transaction_id'] = $incomeEntry['income_no'];
							   $generalLedger[$j]['description'] = $incomeEntry['transaction_description'];
								
							  $generalLedger[$j]['date'] = $incomeEntry['inc_date'];
							  $generalLedger[$j]['name'] = $incomeEntry['customer_name'];
					  		//  $generalLedger[$j]['account_name'] = 'Account Receivables';
					  		  $generalLedger[$j]['account_id'] = 'accountReceivables';
					  		  $generalLedger[$j]['debit_amount'] = 0.00;
					  		  $generalLedger[$j]['credit_amount'] = $accountId['income_paid'][$incomeEntry['inc_id']];
					  }
						if($incomeEntry['account_entry_id']==1 && (in_array($incomeEntry['inc_id'], $accountId['income']))) {
							$generalLedger[$j]['transaction_id'] = $incomeEntry['income_no'];
							$generalLedger[$j]['description'] = '';
							
							$generalLedger[$j]['date'] = $incomeEntry['inc_date'];
							$generalLedger[$j]['name'] = $incomeEntry['customer_name'];
							//  $generalLedger[$j]['account_name'] = 'Account Receivables';
					  		$generalLedger[$j]['account_id'] = 'accountReceivables';
					  		$generalLedger[$j]['debit_amount'] = $converted_amount;
					  	    $generalLedger[$j]['credit_amount'] = 0.00;
							
						} else if($incomeEntry['account_entry_id']==3) {
							
						} else if($incomeEntry['account_entry_id']==4 && (in_array($incomeEntry['inc_id'], $accountId['income']))) {
							$generalLedger[$j]['transaction_id'] = $incomeEntry['income_no'];
							$generalLedger[$j]['description'] = $incomeEntry['transaction_description'];
							
							$generalLedger[$j]['date'] = $incomeEntry['inc_date'];
							$generalLedger[$j]['name'] = $incomeEntry['customer_name'];
							//$generalLedger[$j]['account_name'] = 'GST Payables';
					  		$generalLedger[$j]['account_id'] = 'gstPayables';
					  		$generalLedger[$j]['credit_amount'] = $converted_amount;
					  	    $generalLedger[$j]['debit_amount'] = 0.00;
						}	
						$j++;
					}
			}

			if(isset($expenseAccountEntry) && !empty($expenseAccountEntry)) {
				foreach ($expenseAccountEntry as $expenseEntry) {
					$amount = $expenseEntry['amount'];
					if($expenseEntry['transaction_currency']!='SGD') {
						$converted_amount = $this->convertCurrency($amount,$expenseEntry['transaction_currency']);
					} else {
						$converted_amount = $amount;
					}
					   if(($expenseEntry['account_entry_id']==3) && isset($accountId['expense_paid'][$expenseEntry['exp_id']])) {	
					   		   $generalLedger[$j]['transaction_id'] = $expenseEntry['expense_no'];
							   $generalLedger[$j]['description'] = '';
								
							  $generalLedger[$j]['date'] = $expenseEntry['exp_date'];
							  $generalLedger[$j]['name'] = $expenseEntry['vendor_name'];
					  		  //$generalLedger[$j]['account_name'] = 'Account Payables';
					  		$generalLedger[$j]['account_id'] = 'accountPayables';
					  		  $generalLedger[$j]['credit_amount'] = 0.00;
							$generalLedger[$j]['debit_amount'] = $accountId['expense_paid'][$expenseEntry['exp_id']];
						}
						if($expenseEntry['account_entry_id']==2 && (in_array($expenseEntry['exp_id'], $accountId['expense']))) {
								$generalLedger[$j]['transaction_id'] = $expenseEntry['expense_no'];
							   $generalLedger[$j]['description'] = '';
								
							  $generalLedger[$j]['date'] = $expenseEntry['exp_date'];
							  $generalLedger[$j]['name'] = $expenseEntry['vendor_name'];
					  		  //$generalLedger[$j]['account_name'] = 'Account Payables';
					  		$generalLedger[$j]['account_id'] = 'accountPayables';
					  		  $generalLedger[$j]['debit_amount'] = 0.00;
								$generalLedger[$j]['credit_amount'] = $converted_amount;
						} else if($expenseEntry['account_entry_id']==3 && (in_array($expenseEntry['exp_id'], $accountId['expense']))) {
							
						} 	
						$j++;
				}
			}

			if(isset($invoiceAccountEntry) && !empty($invoiceAccountEntry)) {
				foreach ($invoiceAccountEntry as $invoiceEntry) {
					$amount = $invoiceEntry['amount'];
					if($invoiceEntry['transaction_currency']!='SGD') {
						$converted_amount = $this->convertCurrency($amount,$invoiceEntry['transaction_currency']);
					} else {
						$converted_amount = $amount;
					}
						if(($invoiceEntry['account_entry_id']==3) && (isset($accountId['invoice_paid'][$invoiceEntry['inv_id']]))) {
							 $generalLedger[$j]['transaction_id'] = $invoiceEntry['invoice_no'];
							   $generalLedger[$j]['description'] = '';
								
							  $generalLedger[$j]['date'] = $invoiceEntry['inv_date'];
							  $generalLedger[$j]['name'] = $invoiceEntry['customer_name'];
					  		 //  $generalLedger[$j]['account_name'] = 'Account Receivables';
					  		$generalLedger[$j]['account_id'] = 'accountReceivables';
					  		  $generalLedger[$j]['debit_amount'] = 0.00; 
							$generalLedger[$j]['credit_amount'] = $accountId['invoice_paid'][$invoiceEntry['inv_id']];
						}
						if($invoiceEntry['account_entry_id']==1 && (in_array($invoiceEntry['inv_id'], $accountId['invoice']))) {
							$generalLedger[$j]['transaction_id'] = $invoiceEntry['invoice_no'];
							   $generalLedger[$j]['description'] = '';
								
							  $generalLedger[$j]['date'] = $invoiceEntry['inv_date'];
							  $generalLedger[$j]['name'] = $invoiceEntry['customer_name'];
					  		  //  $generalLedger[$j]['account_name'] = 'Account Receivables';
					  		$generalLedger[$j]['account_id'] = 'accountReceivables';
					  		  $generalLedger[$j]['credit_amount'] = 0.00; 
							$generalLedger[$j]['debit_amount'] = $converted_amount;
							
						} else if($invoiceEntry['account_entry_id']==3) {
							
						} else if($invoiceEntry['account_entry_id']==4 && (in_array($invoiceEntry['inv_id'], $accountId['invoice']))) {
							$generalLedger[$j]['transaction_id'] = $invoiceEntry['invoice_no'];
							   $generalLedger[$j]['description'] = '';
								
							  $generalLedger[$j]['date'] = $invoiceEntry['inv_date'];
							  $generalLedger[$j]['name'] = $invoiceEntry['customer_name'];
					  		  //$generalLedger[$j]['account_name'] = 'GST Payables';
					  		$generalLedger[$j]['account_id'] = 'gstPayables';
					  		  $generalLedger[$j]['debit_amount'] = 0.00; 
								$generalLedger[$j]['credit_amount'] = $converted_amount;
						}
						$j++;
				}
			}

			if(isset($creditAccountEntry) && !empty($creditAccountEntry)) {
				foreach ($creditAccountEntry as $creditEntry) {
					$amount = $creditEntry['amount'];
					if($creditEntry['transaction_currency']!='SGD') {
						$converted_amount = $this->convertCurrency($amount,$creditEntry['transaction_currency']);
					} else {
						$converted_amount = $amount;
					}
					if($creditEntry['account_entry_id']==1) {
						$generalLedger[$j]['transaction_id'] = $creditEntry['credit_no'];
							   $generalLedger[$j]['description'] = '';
								
							  $generalLedger[$j]['date'] = $creditEntry['cre_date'];
							  $generalLedger[$j]['name'] = $creditEntry['customer_name'];
					  		   //  $generalLedger[$j]['account_name'] = 'Account Receivables';
					  		$generalLedger[$j]['account_id'] = 'accountReceivables';
					  		  $generalLedger[$j]['debit_amount'] = 0.00; 
						$generalLedger[$j]['credit_amount'] = $converted_amount;
					} else if($creditEntry['account_entry_id']==4) {
						$generalLedger[$j]['transaction_id'] = $creditEntry['credit_no'];
							   $generalLedger[$j]['description'] = '';
								
							  $generalLedger[$j]['date'] = $creditEntry['cre_date'];
							  $generalLedger[$j]['name'] = $creditEntry['customer_name'];
					  		   //$generalLedger[$j]['account_name'] = 'GST Payables';
					  		$generalLedger[$j]['account_id'] = 'gstPayables';
					  		  $generalLedger[$j]['credit_amount'] = 0.00; 
						$generalLedger[$j]['debit_amount'] = $converted_amount;
					}	

					$j++;
				}
			}

			$this->getAccount	=  $this->report->getAllAccounts();
			$asset = 100000;
			$liability = 200000;
			$income = 300000;
			$expense = 400000;
			$equity = 500000;
			$accounts = array();
			foreach ($this->getAccount as $account) {
				if($account['account_type']==1) {
					$accounts[$account['id']]['name'] = $account['account_name'];
					$accounts[$account['id']]['acc_id'] = ++$asset;
				} else if($account['account_type']==2) {
					$accounts[$account['id']]['name'] = $account['account_name'];
					$accounts[$account['id']]['acc_id'] = ++$liability;
				} else if($account['account_type']==3) {
					$accounts[$account['id']]['name'] = $account['account_name'];
					$accounts[$account['id']]['acc_id'] = ++$income;
				} else if($account['account_type']==4) {
					$accounts[$account['id']]['name'] = $account['account_name'];
					$accounts[$account['id']]['acc_id'] = ++$expense;
				} else if($account['account_type']==5) {
					$accounts[$account['id']]['name'] = $account['account_name'];
					$accounts[$account['id']]['acc_id'] = ++$equity;
				}
			}

			$accounts['accountReceivables']['name'] = 'Account Receivables';
		    $accounts['accountReceivables']['acc_id'] = ++$asset;

		    $accounts['accountPayables']['name'] = 'Account Payables';
			$accounts['accountPayables']['acc_id'] = ++$liability;

			$accounts['gstPayables']['name'] = 'GST Payables';
			$accounts['gstPayables']['acc_id'] = ++$liability;


	//		echo '<pre>'; print_r($accounts); echo '</pre>';

/*		$debit_amount = 0;
		$credit_amount = 0;

			foreach ($generalLedger as $gl) {
				$debit_amount += $gl['debit_amount'];
				$credit_amount += $gl['credit_amount'];
			} 
			echo $credit_amount.'<br/>';
			echo $debit_amount;*/

			$this->view->getAccount	=  $this->report->getAllAccounts();
			$this->view->generalAccount	=  $generalLedger; 


		}




     		$xml = new SimpleXMLElement('<company/>');

			if(isset($company) && !empty($company)) {

				$product_version = "Xpand Accounting V-".$company[0]['id'];
				$iras_version = "IAFV1.0.0.";
				$companies = $xml->addChild('CompanyInfo');
				$companies->addChild('CompanyName',$company[0]['company_name']);
				$companies->addChild('CompanyUEN',$company[0]['company_uen']);
				$companies->addChild('GSTNo',$company[0]['company_gst']);
				$companies->addChild('PeriodStart',$company[0]['financial_year_start_date']);
				$companies->addChild('PeriodEnd',$company[0]['financial_year_end_date']);
				$companies->addChild('IAFCreationDate',date('Y-m-d'));
				$companies->addChild('ProductVersion',$product_version);
				$companies->addChild('IAFVersion',$iras_version);


			}

			if(isset($supplier) && !empty($supplier)) {

				$purchase = $xml->addChild('Purchase');

				foreach ($supplier as $key => $supply) {

					$purchaseLines = $purchase->addChild('PurchaseLines');
					$purchaseLines->addChild('SupplierName',$supply['supplierName']);
					$purchaseLines->addChild('SupplierUEN',$supply['supplierUEN']);
					$purchaseLines->addChild('InvoiceDate',$supply['date']);
					$purchaseLines->addChild('InvoiceNo',$key);
					$purchaseLines->addChild('LineNo',$supply['lineNo']);
					$purchaseLines->addChild('ProductDescription',$supply['description']);
					$purchaseLines->addChild('PurchaseValueSGD',$supply['amount']);
					$purchaseLines->addChild('GSTValueSGD',$supply['gst']);
					$purchaseLines->addChild('TaxCode',$supply['taxcode']);
					$purchaseLines->addChild('FCYCode',$supply['fcurrency']);
					$purchaseLines->addChild('PurchaseFCY',$supply['famount']);
					$purchaseLines->addChild('GSTFCY',$supply['fgst']);

				}

			}

			if(isset($customer) && !empty($customer)) {

				$supplies = $xml->addChild('Supply');

				foreach ($customer as $key => $custom) {

					$supplyLines = $supplies->addChild('SupplyLines');
					$supplyLines->addChild('CustomerName',$custom['customerName']);
					$supplyLines->addChild('CustomerUEN',$custom['customerUEN']);
					$supplyLines->addChild('InvoiceDate',$custom['date']);
					$supplyLines->addChild('InvoiceNo',$key);
					$supplyLines->addChild('LineNo',$custom['lineNo']);
					$supplyLines->addChild('ProductDescription',$custom['description']);
					$supplyLines->addChild('PurchaseValueSGD',$custom['amount']);
					$supplyLines->addChild('GSTValueSGD',$custom['gst']);
					$supplyLines->addChild('TaxCode',$custom['taxcode']);
					$supplyLines->addChild('FCYCode',$custom['fcurrency']);
					$supplyLines->addChild('PurchaseFCY',$custom['famount']);
					$supplyLines->addChild('GSTFCY',$custom['fgst']);

				}

			}

			if(isset($generalLedger) && !empty($generalLedger)) {
				$balance = 0.00;
				$gl = $xml->addChild('GLData');

				foreach ($generalLedger as $key => $general) {
					$debit = number_format($general['debit_amount'], 2, '.', '');
					$credit = number_format($general['credit_amount'], 2, '.', '');
					$balance += $debit - $credit;
					$total = number_format($balance, 2, '.', '');
					$glLines = $gl->addChild('GLDataLines');
					$glLines->addChild('TransactionDate',$general['date']);
					$glLines->addChild('AccountID',$accounts[$general['account_id']]['acc_id']);
					$glLines->addChild('AccountName',$accounts[$general['account_id']]['name']);
					$glLines->addChild('TransactionDesciption',$general['description']);
					$glLines->addChild('TransactionID',$general['transaction_id']);
					$glLines->addChild('Name',$general['name']);
					$glLines->addChild('Debit',$debit);
					$glLines->addChild('Credit',$credit);
					$glLines->addChild('Balance',$total);
					
				}

			}

			if(isset($logSession->proxy_cid) && !empty($logSession->proxy_cid)) {
				$cid = $logSession->proxy_cid;
			} else {
				$cid = $logSession->cid;
			}

			if($xml->asXML("public/uploads/$cid/IAFv1.0.0.xml")) {
				$this->view->xml = "public/uploads/$cid/IAFv1.0.0.xml";
				$this->_redirect($this->sitePath.$this->view->xml);
			}

			

			//echo '<pre>'; print_r($customer); echo '</pre>';
			//echo '<pre>'; print_r($incomeAccountCustomer); echo '</pre>';
			//echo '<pre>'; print_r($expenseIafVendor); echo '</pre>';
			//echo '<pre>'; print_r($maxExpense); echo '</pre>';
			//echo '<pre>'; print_r($supplier); echo '</pre>';

			

			/*$debit_amount = 0;
			$credit_amount = 0;

			foreach ($generalLedger as $gl) {
				$debit_amount += $gl['debit_amount'];
				$credit_amount += $gl['credit_amount'];
			} */
		//	echo $debit_amount.'<br/>';
		//	echo $credit_amount;

			
			$this->view->generalAccount	=  $generalLedger; 
			//echo '<pre>'; print_r($this->view->generalAccount); echo '</pre>';
		}
	}


	/*public function setupRoutage() {
			//$route = new Zend_Controller_Router_Route
			$router = $this->frontCtrls->getRouter();
			//$setRoute = new Zend_Controller_Router_Route(':action/*', array('module'=>'default', 'controller'=>'index', 'action'=>'index'));
			//$router->addRoute('index', $setRoute);
			$router->addRoute(
            'default',
            new Zend_Controller_Router_Route(':action/*',
                                            array('module'=>'default','controller'=>'index', 'action'=>'index'))
                     )
			->addRoute('channels',new Zend_Controller_Router_Route('channels/:action/*',
                                            array('module'=>'default','controller'=>'channels', 'action'=>':action'))
                     )
			 ->addRoute('member',new Zend_Controller_Router_Route('user/:action/*',
                                            array('module'=>'member','controller'=>'index', 'action'=>':action'))
                     )
			 ->addRoute('channel',new Zend_Controller_Router_Route('channel/:action/*',
                                            array('module'=>'mychannel','controller'=>'index', 'action'=>':action'))
						)
                         ->addRoute('admin',new Zend_Controller_Router_Route('admin/:action/*',
                                            array('module'=>'admin','controller'=>'index', 'action'=>':action'))
                                                )
                         ->addRoute('panel',new Zend_Controller_Router_Route('admin/panel/:action/*',
                                            array('module'=>'admin','controller'=>'panel', 'action'=>':action'))
						)
			 ->addRoute('routing',new Zend_Controller_Router_Route('routing/:action/*',
                                            array('module'=>'mychannel','controller'=>'test', 'action'=>':action'))
                     );
		  	
        }*/

	function convertCurrency($amount, $from){
		$to   = 'SGD';
	    $url  = "https://www.google.com/finance/converter?a=$amount&from=$from&to=$to";
	    $data = file_get_contents($url);
	    preg_match("/<span class=bld>(.*)<\/span>/",$data, $converted);
	    $converted = preg_replace("/[^0-9.]/", "", $converted[1]);
	    return round($converted, 3);
	}

}

?>