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
		$this->settings    = new Settings();
		$this->accountData = new Account_Data();
		if(Zend_Session::namespaceIsset('sess_login')) {
			$logSession = new Zend_Session_Namespace('sess_login');
			if($logSession->type==0 && !isset($logSession->companySet)) {
				$this->_redirect('developer');
			}
			if($logSession->type==4 || $logSession->type==5) {
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

			if(isset($incomeAccount) && !empty($incomeAccount)) {
				foreach ($incomeAccount as $income) {
					$tax_amount = ($income['amount'] * $income['tax_value'] / 100);
					$total_income = $income['amount'] - $tax_amount;
					//echo $total_income."<br/>";
					if($income['transaction_currency']!='SGD') {
						$converted_amount = $this->convertCurrency($total_income,$income['transaction_currency']);
						//echo $converted_amount;
					} else {
						$converted_amount = $total_income;
					}
					if(isset($incomeType[$income['fkincome_type']])) {
						$incomeType[$income['fkincome_type']] += $converted_amount;
					} else {
						$incomeType[$income['fkincome_type']] = 0.00;
						$incomeType[$income['fkincome_type']] += $converted_amount;
					}
				}
			}

			if(isset($incomeAccountInvoice) && !empty($incomeAccountInvoice)) {
				foreach ($incomeAccountInvoice as $invoice) {
					$amount = ($invoice['unit_price'] * $invoice['quantity'] - $invoice['discount_amount']);
					$tax_amount = ($amount * $invoice['tax_value'] / 100);
					$total_income = $amount - $tax_amount;
					if($invoice['transaction_currency']!='SGD') {
						$converted_amount = $this->convertCurrency($total_income,$invoice['transaction_currency']);
						//echo $converted_amount;
					} else {
						$converted_amount = $total_income;
					}
					if(isset($incomeType[$invoice['fkincomeaccount_id']])) {
						$incomeType[$invoice['fkincomeaccount_id']] += $converted_amount;
					} else {
						$incomeType[$invoice['fkincomeaccount_id']] = 0.00;
						$incomeType[$invoice['fkincomeaccount_id']] += $converted_amount;
					}
				}
			}

			if(isset($incomeAccountCredit) && !empty($incomeAccountCredit)) {
				foreach ($incomeAccountCredit as $credit) {
					$amount = ($credit['unit_price'] * $credit['quantity']);
					$tax_amount = ($amount * $credit['tax_value'] / 100);
					$total_income = $amount - $tax_amount;
					if($credit['transaction_currency']!='SGD') {
						$converted_amount = $this->convertCurrency($total_income,$credit['transaction_currency']);
						//echo $converted_amount;
					} else {
						$converted_amount = $total_income;
					}
					if(isset($incomeType[$credit['fkincomeaccount_id']])) {
						$incomeType[$credit['fkincomeaccount_id']] += $converted_amount;
					} else {
						$incomeType[$credit['fkincomeaccount_id']] = 0.00;
						$incomeType[$credit['fkincomeaccount_id']] += $converted_amount;
					}
				}
			}

			if(isset($expenseAccount) && !empty($expenseAccount)) {
				foreach ($expenseAccount as $expense) {
					$amount = ($expense['unit_price'] * $expense['quantity']);
					$tax_amount = ($amount * $expense['tax_value'] / 100);
					$total_income = $amount - $tax_amount;
					if($expense['transaction_currency']!='SGD') {
						$converted_amount = $this->convertCurrency($total_income,$expense['transaction_currency']);
						//echo $converted_amount;
					} else {
						$converted_amount = $total_income;
					}
					if(isset($incomeType[$expense['fkexpense_type']])) {
						$expenseType[$expense['fkexpense_type']] += $converted_amount;
					} else {
						$expenseType[$expense['fkexpense_type']] = 0.00;
						$expenseType[$expense['fkexpense_type']] += $converted_amount;
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
				if($incomeReceive['credit_term']!=1) {
					$inc_date = $incomeReceive['inc_date'];
					$days     = $this->view->creditTerm[$incomeReceive['credit_term']];
					$due_date = date('Y-m-d', strtotime("$inc_date +$days day")); 
					$incomeReceivable[$incomeReceive['income_no']] = array('due_date' => $due_date,'amount' => $incomeReceive['amount'],'currency' => $incomeReceive['transaction_currency'],'paid' => '0.00');
				}
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
				if($incomeInvoiceReceive['credit_term']!=1) {
				    $incomeReceivable[$incomeInvoiceReceive['invoice_no']] = array('due_date' => $incomeInvoiceReceive['due_date'],'amount' => $incomeInvoiceReceive['amount'],'currency' => $incomeInvoiceReceive['transaction_currency'],'paid' => '0.00');
				}
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
				if($expensePay['credit_term']!=1) {
					$expensePayable[$expensePay['expense_no']] = array('due_date' => $expensePay['due_date'],'amount' => $expensePay['amount'],'currency' => $expensePay['transaction_currency'],'paid' => '0.00');
				}
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
			
			//echo '<pre>'; print_r($expenseAccountPayable); echo '</pre>';
			//echo '<pre>'; print_r($expenseAccountCash); echo '</pre>';
			//echo '<pre>'; print_r($expensePayable); echo '</pre>';
		}
	}


	public function balanceSheetAction() {
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
				$cid = $logSession->cid;
		      	$this->json    =  "..".$this->uploadPath.$logSession->cid."/accounts.json";
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

	public function generalLedgerAction() {
		if(!Zend_Session::namespaceIsset('sess_login')) {
		   $this->_redirect('index');
		} else {
			$generalLedger = array();
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

			if(isset($incomeAccountIncome) && !empty($incomeAccountIncome)) {
				foreach ($incomeAccountIncome as $income) {
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

			if(isset($incomeAccountInvoice) && !empty($incomeAccountInvoice)) {
				foreach ($incomeAccountInvoice as $invoice) {
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

			if(isset($expenseAccount) && !empty($expenseAccount)) {
				foreach ($expenseAccount as $expense) {
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

			if(isset($incomeAccountIncomePay) && !empty($incomeAccountIncomePay)) {
				foreach ($incomeAccountIncomePay as $incPayment) {
						$amount = $incPayment['payment_amount'];
						if($incPayment['transaction_currency']!='SGD') {
							$converted_amount = $this->convertCurrency($amount,$incPayment['transaction_currency']);
						} else {
							$converted_amount = $amount;
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

			if(isset($expenseAccountPay) && !empty($expenseAccountPay)) {
				foreach ($expenseAccountPay as $expPayment) {
						$amount = $expPayment['payment_amount'];
						if($expPayment['transaction_currency']!='SGD') {
							$converted_amount = $this->convertCurrency($amount,$expPayment['transaction_currency']);
						} else {
							$converted_amount = $amount;
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

			if(isset($incomeAccountInvoicePay) && !empty($incomeAccountInvoicePay)) {
				foreach ($incomeAccountInvoicePay as $invPayment) {
						$amount = $invPayment['payment_amount'];
						if($invPayment['transaction_currency']!='SGD') {
							$converted_amount = $this->convertCurrency($amount,$invPayment['transaction_currency']);
						} else {
							$converted_amount = $amount;
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
			$generalLedger['cash']['debit_amount'] = 0.00;
			$generalLedger['cash']['credit_amount'] = 0.00;
			$generalLedger['gstPayables']['debit_amount'] = 0.00;
			$generalLedger['gstPayables']['credit_amount'] = 0.00;
			$generalLedger['sales']['debit_amount'] = 0.00;
			$generalLedger['sales']['credit_amount'] = 0.00;

			if(isset($incomeAccountEntry) && !empty($incomeAccountEntry)) {
				foreach ($incomeAccountEntry as $incomeEntry) {
					$amount = $incomeEntry['amount'];
					if($incomeEntry['transaction_currency']!='SGD') {
						$converted_amount = $this->convertCurrency($amount,$incomeEntry['transaction_currency']);
					} else {
						$converted_amount = $amount;
					}
					if($incomeEntry['account_entry_id']==1) {
						$generalLedger['accountReceivables']['debit_amount'] += $converted_amount;
						
					} else if($incomeEntry['account_entry_id']==3) {
							$generalLedger['accountReceivables']['credit_amount'] += $converted_amount;
						
					} else if($incomeEntry['account_entry_id']==4) {
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
					if($expenseEntry['account_entry_id']==2) {
							$generalLedger['accountPayables']['credit_amount'] += $converted_amount;
					} else if($expenseEntry['account_entry_id']==3) {
							$generalLedger['accountPayables']['debit_amount'] += $converted_amount;
						
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
					if($invoiceEntry['account_entry_id']==1) {
						$generalLedger['accountReceivables']['debit_amount'] += $converted_amount;
						
					} else if($invoiceEntry['account_entry_id']==3) {
							$generalLedger['accountReceivables']['credit_amount'] += $converted_amount;
						
					} else if($invoiceEntry['account_entry_id']==4) {
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
					//echo '<br/>'.$converted_amount;
					if($creditEntry['account_entry_id']==1) {
						$generalLedger['accountReceivables']['credit_amount'] += $converted_amount;
					} else if($creditEntry['account_entry_id']==4) {
						$generalLedger['gstPayables']['debit_amount'] += $converted_amount;
					}	
				}
			}


			$debit_amount = 0;
			$credit_amount = 0;

			foreach ($generalLedger as $gl) {
				$debit_amount += $gl['debit_amount'];
				$credit_amount += $gl['credit_amount'];
			}

			echo $debit_amount.'<br/>';
			echo $credit_amount;

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
			echo '<pre>'; print_r($incomeAccountCredit); echo '</pre>';*/
			echo '<pre>'; print_r($incomeAccountIncome); echo '</pre>';
			echo '<pre>'; print_r($incomeAccountIncomePay); echo '</pre>';
			echo '<pre>'; print_r($incomeAccountEntry); echo '</pre>';
			echo '<pre>'; print_r($generalLedger); echo '</pre>';
			
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