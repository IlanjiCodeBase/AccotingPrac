<?php 
class IndexController extends Zend_Controller_Action {
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
		$this->report      = new Reports();
		$this->accountData = new Account_Data();	
		$this->uploadPath  = Zend_Registry::get('uploadpath');
		//Zend_Session::destroy();
		if(Zend_Session::namespaceIsset('sess_login')) {

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
		if(Zend_Session::namespaceIsset('sess_login')) {
			$this->_redirect('index/dashboard');
		} else {
		if($this->_request->isPost()) {
			$postArray  = 	$this->getRequest()->getPost();
			$result     =   $this->account->userAuth($postArray);
			if($result) {
			//	echo '<pre>'; print_r($result); echo '</pre>'; die();
				$logSession = new Zend_Session_Namespace('sess_login');
				//$logSession->setExpirationSeconds(10); 
				$logSession->id		  = $result[0]['id'];
				$logSession->type	  = $result[0]['account_type'];
				$logSession->name 	  = $result[0]['company_name'];
				$logSession->cid  	  = $result[0]['cid'];
				$logSession->currency = $result[0]['currency'];
				$logSession->status   = $result[0]['status'];
				$logSession->username = $postArray['username'];
				$logSession->server   = $result[0]['server_address'];
				//$this->_redirect('index/dashboard');
				if($result[0]['server_address'] == 'main_default') {
					$this->_redirect('developer');
				} else {
					if($result[0]['server_address'] == 'default') {
						$remoteSession 	= new Zend_Session_Namespace('sess_remote_database');
						$remoteSession->hostName = "localhost";
						$remoteSession->userName = "ummadc";
						$remoteSession->password = "accelerated2020";
						$remoteSession->dataBase = $result[0]['database_name'];
					} else {
						$remoteSession = new Zend_Session_Namespace('sess_remote_database');
						$remoteSession->hostName = $result[0]['server_address'];
						$remoteSession->userName = $result[0]['server_user'];
						$remoteSession->password = $result[0]['server_pass'];
						$remoteSession->dataBase = $result[0]['database_name'];
					}
					if($logSession->type!=0) {
						$auditLog	  = $this->settings->insertAuditLogin(9,12,'Logged In',$logSession->type);
					}					
					if($result[0]['account_type']==0 || $result[0]['account_type'] == 1) {
						$this->_redirect('developer');
					}  else if($result[0]['account_type'] == 2) { 
						$logSession->companySet = 1;
						if($logSession->status==2) {
							$this->_redirect('settings/company');
						} else {
							$this->_redirect('settings');
						}
					} else {
                        $this->_redirect('index/dashboard');
                     }
					//echo '<pre>'; print_r($result); echo '</pre>';
				}
				/* $remoteSession->hostName = "103.14.121.168";
				$remoteSession->userName = "ummgroup";
				$remoteSession->password = "accelerated2020";
				$remoteSession->dataBase = "ummgroup_money_exchange"; */
			} else {
			 	$this->view->error = 'Invalid Login Details';
			}
		}
	  }
	}

	public function dashboardAction() {
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


			if($logSession->status==2) {
				$this->_redirect('settings/company');
			}

			if($logSession->type==2 || $logSession->type==3 || $logSession->proxy_type==2 || $logSession->proxy_type==3) {
				$pendingIncome  = $this->transaction->pendingIncomeTransactions($id);
				$pendingExpense = $this->transaction->pendingExpenseTransactions($id);
				$pendingInvoice = $this->transaction->pendingInvoiceTransactions($id);
				$pendingCredit  = $this->transaction->pendingCreditTransactions($id);
				$pendingjournal = $this->transaction->pendingJournalTransactions($id);
				$this->view->totalCount = $pendingIncome+$pendingExpense+$pendingInvoice+$pendingCredit+$pendingjournal;
			}

			$this->notifications = $this->approval->getNotificationMessage($cid,$id);
			if(isset($this->notifications) && !empty($this->notifications)) {
				foreach ($this->notifications as $notification) {
					$users 			= explode(",", $notification['users']);
					$seen_users 	= explode(",", $notification['seen_users']);
					if((in_array($id,$users) && !in_array($id, $seen_users)) || ($notification['users']=='all' && !in_array($id, $seen_users))) {
						$notify[$notification['id']]['subject'] = $notification['subject'];
						$notify[$notification['id']]['message'] = $notification['message'];
						$notify[$notification['id']]['date']    = $notification['date_created'];
					}
				}
			}


			$getCompany = $this->account->getCompany($cid);
			$stat = 0;
				foreach ($getCompany as $company) {
					$start_year = $company['financial_year_start_date'];
					$end_year   = $company['financial_year_end_date'];
				}
				$current_month = date('m-d');
				$finance_month = date('m-d',strtotime($start_year));
				if($current_month < $finance_month) {
					$cur_date  = date('Y-m-d',strtotime($start_year));
					$strtotime = strtotime($cur_date);
					$last_year = strtotime("-1 year",$strtotime);
					$current_year = date('Y-m-d',$last_year);
					$stat=1;
				} else {
					$current_year = date('Y-m-d',strtotime($start_year));
				}
			$from = $current_year;
			if($start_year=='01-Jan') {
				$last_year = date('Y-m-d',strtotime($end_year));
			} else {
				if($stat==0) {
					$cur_date  = date('Y-m-d',strtotime($end_year));
					$strtotime = strtotime($cur_date);
					$last_year = strtotime("+1 year",$strtotime);
					$last_year = date('Y-m-d',$last_year);
				} else {
					$last_year  = date('Y-m-d',strtotime($end_year));
				}
			}
			$to   = $last_year;


			$date1 = date('Y-m',strtotime($from));
			$date2 = date('Y-m',strtotime($to));

			if($date1 < $date2)
			{
			   $past = $date1;
			   $future = $date2;
			}
			else
			{
			   $past = $date2;
			   $future = $date1;
			}

			$months = array();
			for($i = $past; $past<=$future; $i++)
			{
			   $timestamp = strtotime($past.'-1');
			   $months[date('M-y',$timestamp)][1]['debit']  = 0.00;
			   $months[date('M-y',$timestamp)][1]['credit'] = 0.00;
			   $months[date('M-y',$timestamp)][2]['debit']  = 0.00;
			   $months[date('M-y',$timestamp)][2]['credit'] = 0.00;
			   $past = date('Y-m',strtotime('+1 month',$timestamp));  
			}


			
			/*$from = '2014-06-01';
			$to = '2014-06-30';*/
			

			$incomeAccount = $this->report->getIncomeAccountIncomes($from,$to);
			$incomeAccountInvoice = $this->report->getIncomeAccountInvoice($from,$to);
			$incomeAccountCredit  = $this->report->getIncomeAccountCredit($from,$to);
			$expenseAccount  = $this->report->getExpenseAccountExpenses($from,$to);
			$incomeJournalAccount   = $this->report->getIncomeJournalAccount($from,$to);
			$expenseJournalAccount  = $this->report->getExpenseJournalAccount($from,$to);
			$incomeAccountPay  = $this->report->getIncomeAccountIncomesPay($from,$to);
			$invoiceAccountPay = $this->report->getIncomeAccountInvoicesPay($from,$to);
			$expenseAccountPay = $this->report->getExpenseAccountExpensesPay($from,$to);
			$this->view->incomeCoa  = $this->transaction->getIncomeAccount();
			$this->view->expenseCoa = $this->transaction->getExpenseAccount();
			$incomes   = array();
			$invoices  = array();
			$invoicess = array();
			$expenses  = array();

			//echo '<pre>'; print_r($expenseAccountPay); echo '</pre>';



			foreach ($incomeAccount as $income) {
				$date = date('M-y',strtotime($income['date']));
				$tax_amount   = ($income['amount'] * $income['tax_value'] / 100);
				$whole_income = $tax_amount+$income['amount'];
				if($income['transaction_currency']!='SGD') {
					$converted_amount = $income['amount']*$income['exchange_rate'];
					$whole_amount = $whole_income*$income['exchange_rate'];
					if($income['payment_status']==1 && $income['final_payment_date'] <= $to) {
						//$incomeStatement[2]['debit']   += round($whole_amount,2);
						$incomes[$income['inc_id']] = $income['inc_id'];
						//$months[$date][2]['debit']     += round($whole_amount,2);
					}
					//echo $whole_amount.'<br/>';
				} else {
					$converted_amount = $income['amount'];
				}

				$months[$date][1]['credit']     += $converted_amount;

				/*if(array_key_exists($income['fkincome_type'], $incomeStatement)) {
					$incomeStatement[$income['fkincome_type']]['credit'] += $converted_amount;
				} else {
					$incomeStatement[$income['fkincome_type']]['credit']  = 0.00;
					$incomeStatement[$income['fkincome_type']]['debit']   = 0.00;
					$incomeStatement[$income['fkincome_type']]['type']    = 1;
					$incomeStatement[$income['fkincome_type']]['credit'] += $converted_amount;
				}*/
			}

			


			foreach ($incomeAccountInvoice as $invoice) {
				$date = date('M-y',strtotime($invoice['date']));
				$discount_amount   = $invoice['discount_amount'];
				$total_income      = $invoice['unit_price']*$invoice['quantity'];
				$whole_income      = $invoice['unit_price']*$invoice['quantity'] - $invoice['discount_amount'];
				$tax_amount   	   = ($whole_income * $invoice['tax_value'] / 100);
				if($invoice['transaction_currency']!='SGD') {
					$converted_amount = $whole_income*$invoice['exchange_rate'];
					$whole_amount     = ($whole_income+$tax_amount)*$invoice['exchange_rate'];
					if($invoice['payment_status']==1 && $invoice['final_payment_date'] <= $to) {
						//$incomeStatement[2]['debit']   += $whole_amount;
						$invoicess[$invoice['inv_id']] = $invoice['inv_id'];
						//$months[$date][2]['debit']     += $whole_amount;
					}
					
					/*if($discount_amount!=0) {
						$discount_amount  = $discount_amount*$invoice['exchange_rate'];
					} else {
						$discount_amount  = $discount_amount;
					}*/
				} else {
					$converted_amount = $whole_income;
					$discount_amount  = $discount_amount;
				}
				$months[$date][1]['credit']     += $converted_amount;
				/*if(array_key_exists($invoice['fkincomeaccount_id'], $incomeStatement)) {
					$incomeStatement[$invoice['fkincomeaccount_id']]['credit'] += $converted_amount;
				} else {
					$incomeStatement[$invoice['fkincomeaccount_id']]['credit']  = 0.00;
					$incomeStatement[$invoice['fkincomeaccount_id']]['debit']   = 0.00;
					$incomeStatement[$invoice['fkincomeaccount_id']]['type']    = 1;
					$incomeStatement[$invoice['fkincomeaccount_id']]['credit'] += $converted_amount;
				}*/

				/*if(array_key_exists(7, $incomeStatement)) {
					$incomeStatement[7]['debit'] += $discount_amount;
				} else {
					$incomeStatement[7]['credit']  = 0.00;
					$incomeStatement[7]['debit']   = 0.00;
					$incomeStatement[7]['debit']  += $discount_amount;
				}*/
			}

			foreach ($incomeAccountCredit as $credit) {
				$date = date('M-y',strtotime($credit['date']));
				$discount_amount   = $credit['discount_amount'];
				$total_income      = $credit['unit_price']*$credit['quantity'];
				$whole_income      = $credit['unit_price']*$credit['quantity'] - $credit['discount_amount'];
				$tax_amount   	   = ($whole_income * $credit['tax_value'] / 100);
				if($credit['transaction_currency']!='SGD') {
					$converted_amount = $whole_income*$credit['exchange_rate'];
					$whole_amount     = ($whole_income+$tax_amount)*$credit['exchange_rate'];
					if(isset($invoices[$credit['invoice_no']])) {
						$invoices[$credit['invoice_no']]['amount'] += $whole_amount;
					} else {
						$invoices[$credit['invoice_no']]['amount'] = $whole_amount;
					}
					/*if($discount_amount!=0) {
						$discount_amount  = $discount_amount*$credit['exchange_rate'];
					} else {
						$discount_amount  = $discount_amount;
					}*/
				} else {
					$converted_amount = $whole_income;
					$discount_amount  = $discount_amount;
				}
				$months[$date][1]['debit']     += $converted_amount;
				/*if(array_key_exists($credit['fkincomeaccount_id'], $incomeStatement)) {
					$incomeStatement[$credit['fkincomeaccount_id']]['debit'] += $converted_amount;
				} else {
					$incomeStatement[$credit['fkincomeaccount_id']]['debit']  = 0.00;
					$incomeStatement[$credit['fkincomeaccount_id']]['credit'] = 0.00;
					$incomeStatement[$credit['fkincomeaccount_id']]['type']   = 1;
					$incomeStatement[$credit['fkincomeaccount_id']]['debit'] += $converted_amount;
				}*/

				/*if(array_key_exists(7, $incomeStatement)) {
					$incomeStatement[7]['credit'] += $discount_amount;
				} else {
					$incomeStatement[7]['credit']  = 0.00;
					$incomeStatement[7]['debit']   = 0.00;
					$incomeStatement[7]['credit'] += $discount_amount;
				}*/
			}

			foreach ($expenseAccount as $expense) {
				$date = date('M-y',strtotime($expense['date']));
				$total_expense  = $expense['unit_price']*$expense['quantity'];
				/*if($expense['total_gst']!=0.00) {
					$tax_amount   = $expense['total_gst'];
				} else {*/
					$tax_amount   = ($total_expense * $expense['tax_value'] / 100);	
				//}
				
				$whole_expense = $total_expense+$tax_amount;
				if($expense['transaction_currency']!='SGD') {
					$converted_amount = $total_expense*$expense['exchange_rate'];
					if($expense['total_gst']!=0.00) {
						$whole_amount	  = ($total_expense*$expense['exchange_rate'])+$expense['total_gst'];
					} else {
						$whole_amount	  = ($total_expense+$tax_amount)*$expense['exchange_rate'];
					}
					if($expense['payment_status']==1 && $expense['final_payment_date'] <= $to) {
						//$incomeStatement[2]['credit']   += round($whole_amount,2);
						//$months[$date][2]['credit']     += round($whole_amount,2);
						$expenses[$expense['exp_id']] = $expense['exp_id'];
						/*echo $expense['exp_id'].'<br/>';
						echo $converted_amount.'<br/>';*/
					}
				} else {
					$converted_amount = $total_expense;
				}
				$months[$date][2]['debit']     += $converted_amount;
				/*if(array_key_exists($expense['fkexpense_type'], $incomeStatement)) {
					$incomeStatement[$expense['fkexpense_type']]['debit'] += $converted_amount;
				} else {
					$incomeStatement[$expense['fkexpense_type']]['debit']  = 0.00;
					$incomeStatement[$expense['fkexpense_type']]['credit'] = 0.00;
					$incomeStatement[$expense['fkexpense_type']]['type']   = 2;
					$incomeStatement[$expense['fkexpense_type']]['debit'] += $converted_amount;
				}*/
			}

			foreach ($incomeJournalAccount as $incomeJournal) {
				$date = date('M-y',strtotime($incomeJournal['date']));
				$months[$date][1]['debit']     += $incomeJournal['debit'];
				$months[$date][1]['credit']    += $incomeJournal['credit'];
				/*if(array_key_exists($incomeJournal['fkaccount_id'], $incomeStatement)) {
					$incomeStatement[$incomeJournal['fkaccount_id']]['debit']  += $incomeJournal['debit'];
					$incomeStatement[$incomeJournal['fkaccount_id']]['credit'] += $incomeJournal['credit'];
				} else {
					$incomeStatement[$incomeJournal['fkaccount_id']]['debit']   = 0.00;
					$incomeStatement[$incomeJournal['fkaccount_id']]['credit']  = 0.00;
					$incomeStatement[$incomeJournal['fkaccount_id']]['type']    = 1;
					$incomeStatement[$incomeJournal['fkaccount_id']]['debit']  += $incomeJournal['debit'];
					$incomeStatement[$incomeJournal['fkaccount_id']]['credit'] += $incomeJournal['credit'];
				}*/
			}

			foreach ($expenseJournalAccount as $expenseJournal) {
				$date = date('M-y',strtotime($expenseJournal['date']));
				$months[$date][2]['debit']     += $expenseJournal['debit'];
				$months[$date][2]['credit']    += $expenseJournal['credit'];
				/*if(array_key_exists($expenseJournal['fkaccount_id'], $incomeStatement)) {
					$incomeStatement[$expenseJournal['fkaccount_id']]['debit']  += $expenseJournal['debit'];
					$incomeStatement[$expenseJournal['fkaccount_id']]['credit'] += $expenseJournal['credit'];
				} else {
					$incomeStatement[$expenseJournal['fkaccount_id']]['debit']   = 0.00;
					$incomeStatement[$expenseJournal['fkaccount_id']]['credit']  = 0.00;
					$incomeStatement[$expenseJournal['fkaccount_id']]['type']    = 2;
					$incomeStatement[$expenseJournal['fkaccount_id']]['debit']  += $expenseJournal['debit'];
					$incomeStatement[$expenseJournal['fkaccount_id']]['credit'] += $expenseJournal['credit'];
				}*/
			}

			foreach ($incomeAccountPay as $incomePay) {
				$date = date('M-y',strtotime($incomePay['date']));
				if($incomePay['pay_status']==1 && $incomePay['transaction_currency']!='SGD') {
					//$incomeStatement[2]['debit']   -= $incomePay['payment_amount'];
					if(array_key_exists($incomePay['inc_id'], $incomes)) {
						//$months[$date][2]['debit']     -= $incomePay['payment_amount'];
					}
				}
				if($incomePay['pay_amount']!=0) {
					if($incomePay['tax_value']!=0) {
						$tax_pay = ($incomePay['pay_amount'] * $incomePay['tax_value'] / 100);
						$discount_amount = $incomePay['pay_amount'] - $tax_pay;
					} else {
						$discount_amount = $incomePay['pay_amount'];
					}
					$months[$date][1]['debit']     += $discount_amount;

					/*if(array_key_exists(7, $incomeStatement)) {
						$incomeStatement[7]['debit']  += $discount_amount;
					} else {
						$incomeStatement[7]['credit']  = 0.00;
						$incomeStatement[7]['debit']   = 0.00;
						$incomeStatement[7]['debit']  += $discount_amount;
					}*/
				}
			}

			foreach ($invoiceAccountPay as $invoicePay) {
				$date = date('M-y',strtotime($invoicePay['date']));
				if($invoicePay['pay_status']==1 && $invoicePay['transaction_currency']!='SGD') {
					if(array_key_exists($invoicePay['inv_id'], $invoicess)) {
						if(isset($invoices[$invoicePay['invoice_no']])) {
							//$incomeStatement[2]['debit']   -= round($invoices[$invoicePay['invoice_no']]['amount'],2);
							//$months[$date][2]['debit']     -= round($invoices[$invoicePay['invoice_no']]['amount'],2);
						} 
						//$incomeStatement[2]['debit']   -= $invoicePay['payment_amount'];
						//$months[$date][2]['debit']     -= $invoicePay['payment_amount'];
					}
					//echo $incomeStatement[2]['debit']."_".$incomeStatement[2]['credit'].'<br/>';
				}

				if($invoicePay['pay_amount']!=0) {
					if($invoicePay['tax_value']!=0) {
						$tax_pay = (($invoicePay['pay_amount'] * $invoicePay['tax_value']) / (100+$invoicePay['tax_value']));
						$discount_amount = $invoicePay['pay_amount'] - $tax_pay;
					} else {
						$discount_amount = $invoicePay['pay_amount'];
					}
					$months[$date][1]['debit']     += $discount_amount;
					/*if(array_key_exists(7, $incomeStatement)) {
						$incomeStatement[7]['debit']  += $discount_amount;
					} else {
						$incomeStatement[7]['credit']  = 0.00;
						$incomeStatement[7]['debit']   = 0.00;
						$incomeStatement[7]['debit']  += $discount_amount;
					}*/
				}
			}

			foreach ($expenseAccountPay as $expensePay) {
				$date = date('M-y',strtotime($expensePay['date']));
				if($expensePay['pay_status']==1 && $expensePay['transaction_currency']!='SGD') {
					if(array_key_exists($expensePay['exp_id'], $expenses)) {
					     //$incomeStatement[2]['credit']   -= $expensePay['payment_amount'];
					    // $months[$date][2]['credit']     -= $expensePay['payment_amount'];
					}
				//	echo $incomeStatement[2]['debit']."_".$incomeStatement[2]['credit'];
				}

				if($expensePay['pay_amount']!=0) {
					if($expensePay['tax_value']!=0) {
						$tax_pay = ($expensePay['pay_amount'] * $expensePay['tax_value'] / (100+$expensePay['tax_value']));
						$discount_amount = $expensePay['pay_amount'] - $tax_pay;
					} else {
						$discount_amount = $expensePay['pay_amount'];
					}
					$months[$date][2]['credit']     += $discount_amount;
					/*if(array_key_exists(8, $incomeStatement)) {
						$incomeStatement[8]['credit'] += $discount_amount;
					} else {
						$incomeStatement[8]['credit']  = 0.00;
						$incomeStatement[8]['debit']   = 0.00;
						$incomeStatement[8]['credit']  += $discount_amount;
					}*/
				}
			}



			$foreignCurrency = array();

			$incomeAccountIncome     = $this->report->getGeneralIncomeAccountForeign($from,$to);

			$incomeAccountInvoice    = $this->report->getGeneralInvoiceIncomeAccountForeign($from,$to);

			$expenseAccount  		 = $this->report->getGeneralExpenseAccountForeign($from,$to);

			$incomeAccountIncomePay  = $this->report->getGeneralIncomePayAccountForeign($from,$to);

			$incomeAccountInvoicePay = $this->report->getInvoicePayAccountsForeign($from,$to);

			$expenseAccountPay       = $this->report->getExpensePayAccountsForeign($from,$to);

			$incomeAccountCredit  	 = $this->report->getGeneralCreditAccountForeign($from,$to);


			foreach ($incomeAccountIncome as $income) {
				
					    $tax_amount   = ($income['amount'] * $income['tax_value'] / 100);
						$total_income = $income['amount']+$tax_amount;	

						if($income['transaction_currency']!='SGD') {
							$converted_rate       = $income['exchange_rate'];
							$converted_amount     = $total_income*$income['exchange_rate'];
						} 
				if($income['final_payment_date'] <= $to) {
				    $foreignCurrency[$income['income_no']]['no'] 			 = $income['income_no'];	
					$foreignCurrency[$income['income_no']]['date'] 			 = $income['final_payment_date'];
					$foreignCurrency[$income['income_no']]['type'] 			 = "1";
					$foreignCurrency[$income['income_no']]['currency']  	 = $income['transaction_currency'];
					$foreignCurrency[$income['income_no']]['amount']    	 = $total_income;
					$foreignCurrency[$income['income_no']]['rate']      	 = $converted_rate;
					$foreignCurrency[$income['income_no']]['convert_amount'] = round($converted_amount,2);
					$foreignCurrency[$income['income_no']]['name'] 			 = $income['customer_name'];
					$foreignCurrency[$income['income_no']]['paid']       	 = 0.00;
				}

			}

			foreach ($incomeAccountIncomePay as $incomePay) {
				$foreignCurrency[$incomePay['income_no']]['paid']    += $incomePay['amount'];
			}


			foreach ($incomeAccountInvoice as $invoice) {
				
					    $tax_amount   = $invoice['tax_amount'] ;
						$total_income = $invoice['amount']+$tax_amount;	

						if($invoice['transaction_currency']!='SGD') {
							$converted_rate 	= $invoice['exchange_rate'];
							$converted_amount 	= $total_income*$invoice['exchange_rate'];
						}
					if($invoice['final_payment_date'] <= $to) {
						$foreignCurrency[$invoice['invoice_no']]['no'] 			     = $invoice['invoice_no'];
						$foreignCurrency[$invoice['invoice_no']]['date'] 			 = $invoice['final_payment_date'];
						$foreignCurrency[$invoice['invoice_no']]['type'] 			 = "1";
						$foreignCurrency[$invoice['invoice_no']]['currency']  		 = $invoice['transaction_currency'];
						$foreignCurrency[$invoice['invoice_no']]['amount']    		 = $total_income;
						$foreignCurrency[$invoice['invoice_no']]['rate']      		 = $converted_rate;
						$foreignCurrency[$invoice['invoice_no']]['convert_amount'] 	 = round($converted_amount,2);
						$foreignCurrency[$invoice['invoice_no']]['name'] 			 = $invoice['customer_name'];
						$foreignCurrency[$invoice['invoice_no']]['paid']       	 	 = 0.00;
					}

			}



			if(isset($incomeAccountCredit) && !empty($incomeAccountCredit)) {
				foreach ($incomeAccountCredit as $credit) {
					$amount = ($credit['unit_price'] * $credit['quantity'] - $credit['discount_amount']);
					$tax_amount = ($amount * $credit['tax_value'] / 100);
					$total_income = $amount+$tax_amount;
					if($credit['transaction_currency']!='SGD') {
						$converted_amount = $amount*$credit['exchange_rate'];
						$whole_amount 	  = $total_income*$credit['exchange_rate'];
						
					} else {
						$converted_amount = $amount;
						$whole_amount 	  = $total_income;
					}

					if(isset($foreignCurrency[$credit['invoice_no']])) {
						$credits = $foreignCurrency[$credit['invoice_no']]['convert_amount'] - round($whole_amount,2);
						$foreignCurrency[$credit['invoice_no']]['convert_amount'] = $credits;
					}
				}
			}


			foreach ($incomeAccountInvoicePay as $invoicePay) {
				$foreignCurrency[$invoicePay['invoice_no']]['paid']    += $invoicePay['amount'];
			}


			foreach ($expenseAccount as $expense) {
				
					/*if($expense['total_gst']!=0.00) {
						$tax_amount    = $expense['total_gst'];
					} else {*/
						$tax_amount    = $expense['tax_amount'];
					//}
					
					$total_expense = $expense['amount']+$tax_amount;	

					if($expense['transaction_currency']!='SGD') {
						$converted_rate     = $expense['exchange_rate'];
						if($expense['total_gst']!=0.00) {
							$converted_amount   = ($expense['amount']*$expense['exchange_rate'])+$expense['total_gst'];
						} else {
							$converted_amount   = $total_expense*$expense['exchange_rate'];
						}
						
					} 

					if($expense['final_payment_date'] <= $to) {
						$foreignCurrency[$expense['expense_no']]['no'] 			     = $expense['expense_no'];
						$foreignCurrency[$expense['expense_no']]['date'] 			 = $expense['final_payment_date'];
						$foreignCurrency[$expense['expense_no']]['type'] 			 = "2";
						$foreignCurrency[$expense['expense_no']]['currency']  		 = $expense['transaction_currency'];
						$foreignCurrency[$expense['expense_no']]['amount']    		 = $total_expense;
						$foreignCurrency[$expense['expense_no']]['rate']      		 = $converted_rate;
						$foreignCurrency[$expense['expense_no']]['convert_amount'] 	 = round($converted_amount,2);
						$foreignCurrency[$expense['expense_no']]['name'] 			 = $expense['vendor_name'];
						$foreignCurrency[$expense['expense_no']]['paid']       	 	 = 0.00;
					}
					
				}

				foreach ($expenseAccountPay as $expensePay) {
					$foreignCurrency[$expensePay['expense_no']]['paid']    += $expensePay['amount'];
				}



			//echo '<pre>'; print_r($months); echo '</pre>';
			$finance = array();

			foreach ($months as $key => $value) {
				$income  = $value[1]['credit']-$value[1]['debit'];
				$expense = $value[2]['debit']-$value[2]['credit'];
				$finance[$key]['1'] = round($income,2);
				$finance[$key]['2'] = round($expense,2);
				/*if($value['type']==1) {
					$amount = $value['credit'] - $value['debit'];
					$finance[$key] = $amount;
				} else if($value['type']==2) {
					$amount = $value['debit'] - $value['credit'];
					$finance[$key] = $amount;
				}*/
			}


			$total = 0.00;
              foreach ($foreignCurrency as $key => $exchange) {
              	$date = date('M-y',strtotime($exchange['date']));
                $sub_total = 0.00;
                $amounts   = 0.00;
                if($exchange['type']==1) {
                  $amount = $exchange['convert_amount'] - $exchange['paid'];
                  if($amount>0) {
                    $sub_total = "(".number_format(abs($amount),2,'.',',').")";
                    $amounts   = -$amount;
                  } else {
                    $sub_total = number_format(abs($amount),2,'.',',');
                    $amounts   = -($amount);
                  }
                } else if($exchange['type']==2) { 
                  $amount = $exchange['convert_amount'] - $exchange['paid'];
                  if($amount<0) {
                    $sub_total = "(".number_format(abs($amount),2,'.',',').")";
                    $amounts   = $amount;
                  } else {
                    $sub_total = number_format(abs($amount),2,'.',',');
                    $amounts   = +$amount;
                  }
                }
                $total += $amounts;
                $calcs = (-1)*($amounts);
                $finance[$date]['2'] += $calcs; 
               }

			//echo '<pre>'; print_r($finance); echo '</pre>';

			$this->view->finance = $finance;

			/*foreach ($this->view->incomeCoa as $inc) {
				if($inc['debit_opening_balance']!=0 || $inc['credit_opening_balance']!=0) {
					if(array_key_exists($inc['id'], $incomeStatement)) {
						$incomeStatement[$inc['id']]['debit']  += $inc['debit_opening_balance'];
						$incomeStatement[$inc['id']]['credit'] += $inc['credit_opening_balance'];
					} else {
						$incomeStatement[$inc['id']]['debit']   = 0.00;
						$incomeStatement[$inc['id']]['credit']  = 0.00;
						$incomeStatement[$inc['id']]['type']    = 1;
						$incomeStatement[$inc['id']]['debit']  += $inc['debit_opening_balance'];
						$incomeStatement[$inc['id']]['credit'] += $inc['credit_opening_balance'];
					}
				}
			}

			foreach ($this->view->expenseCoa as $exp) {
				if($exp['debit_opening_balance']!=0 || $exp['credit_opening_balance']!=0) {
					if(array_key_exists($exp['id'], $incomeStatement)) {
						$incomeStatement[$exp['id']]['debit']  += $exp['debit_opening_balance'];
						$incomeStatement[$exp['id']]['credit'] += $exp['credit_opening_balance'];
					} else {
						$incomeStatement[$exp['id']]['debit']   = 0.00;
						$incomeStatement[$exp['id']]['credit']  = 0.00;
						$incomeStatement[$exp['id']]['type']    = 2;
						$incomeStatement[$exp['id']]['debit']  += $exp['debit_opening_balance'];
						$incomeStatement[$exp['id']]['credit'] += $exp['credit_opening_balance'];
					}
				}
			}*/

			
			//echo date("M",strtotime(($i > 0) ? "+$i months" : "$i months"))."\n";
			

			$this->view->notifyMessages = $notify;
			
		}
	}

	public function registrationAction() {
		if(!Zend_Session::namespaceIsset('sess_login')) {
			$this->_redirect('index');
		} else {
			$logSession = new Zend_Session_Namespace('sess_login');
			if($logSession->type!=0) {
				$this->_redirect('index');
			}
			$getAccountArray              =  $this->accountData->getData(array('country'));
			$this->view->countries        =  $getAccountArray['country'];
			if(Zend_Session::namespaceIsset('insert_account_success')) {
				$sessSuccess = new Zend_Session_Namespace('insert_account_success');
				$this->view->success = 'Account Created successfully';
				//$this->view->success = 'Account Created successfully. Kindly <a href="'.$this->view->sitePath."developer/configure-database/company/".base64_encode($sessSuccess->companyId).'">click here</a> to assign database and load accounts for the company.';
				Zend_Session::namespaceUnset('insert_account_success');
			}
			if(Zend_Session::namespaceIsset('insert_account_success_nodb')) {
				$sessSuccess = new Zend_Session_Namespace('insert_account_success_nodb');
				$this->view->success = 'Account Created successfully but problem in creating database and configuring it. Kindly configure database manually';
				Zend_Session::namespaceUnset('insert_account_success_nodb');
			}
			if($this->_request->isPost()) {
				$postArray  = 	$this->getRequest()->getPost(); 
				$postArray['account_type'] = 2;
				$this->view->username 	= $postArray['username'];
				$this->view->company 	= $postArray['company'];
				$this->view->cuen 		= $postArray['cuen'];
				$this->view->gst 		= $postArray['gst'];
				$this->view->phone 		= $postArray['phone'];
				$this->view->block_no 	= $postArray['block_no'];
				$this->view->street_name= $postArray['street_name'];
				$this->view->level   	= $postArray['level'];
				$this->view->unit_no    = $postArray['unit_no'];
				$this->view->city   	= $postArray['city'];
				$this->view->zip_code   = $postArray['zip_code'];
				$this->view->region   	= $postArray['region'];
				$this->view->country    = $postArray['country'];
				$this->view->start_date	= $postArray['start_date'];
				$this->view->end_date   = $postArray['end_date'];
				$start_date	 = date('d-m-Y',strtotime($postArray['start_date']));
				$end_date	 = date('d-m-Y',strtotime($postArray['end_date']));
				$start = strtotime($start_date);
                $end   = strtotime($end_date);
                $days_between = ceil(abs($end - $start) / 86400);  
                if($days_between=='364' || $days_between=='1') {
					$checkUsername			= $this->account->checkLogin($postArray['username']);
						if(!$checkUsername) {
						$result     			= $this->account->insertCompany($postArray);
						if($result) {
							$insertLogin = $this->account->insertLogin($postArray,$result);
							 if($insertLogin) {
							 	//mkdir("../".$this->receiptPath.$result);
							 	//mkdir("../".$this->uploadPath."journal/".$result);
							 	mkdir("../".$this->uploadPath.$result);
							 	mkdir("../".$this->uploadPath.$result."/receipts");
							 	mkdir("../".$this->uploadPath.$result."/journal");
							 	mkdir("../".$this->uploadPath.$result."/imports");
							 	mkdir("../".$this->uploadPath.$result."/sql");
							 	$file = "..".$this->uploadPath."/accounts.json";
								$newfile = "..".$this->uploadPath.$result."/accounts.json";
								copy($file, $newfile);
							 	//mkdir("../".$result."/accounts");
							 	$database_name = "ummadc_account_".$result;
							 	$sql_filename = 'accounting.sql';
								$sql_contents = file_get_contents("../".$this->uploadPath.$sql_filename);
								$sql_contents = explode("@@", $sql_contents);
								if(!empty($sql_contents) && !empty($database_name)) {
									$database  = $this->account->createDatabase($database_name,$sql_contents,$result);
									//$createCoa = $this->account->CreateDefaultCoa($result); 
									if($database) {
										$sessSuccess = new Zend_Session_Namespace('insert_account_success');
										$sessSuccess->status = 1;
										$sessSuccess->companyId = $result;
										$this->_redirect('index/registration');
									} else{
										$sessSuccess = new Zend_Session_Namespace('insert_account_success_nodb');
										$sessSuccess->status = 1;
										$sessSuccess->companyId = $result;
										$this->_redirect('index/registration');
									}
								} else {
									$sessSuccess = new Zend_Session_Namespace('insert_account_success_nodb');
									$sessSuccess->status = 1;
									$sessSuccess->companyId = $result;
									$this->_redirect('index/registration');
								}
							}  else {
								$this->view->error = 'Company created succesfully. Login details cannot be created. Kindly try adding in user settings';
							}
						} else {
								$this->view->error = 'Account cannot be created. Kindly try again later';
						}
					  } else {
					  		$this->view->error = 'Email ID already exists. Kindly try some other email address';
					  }
				} else {
					$this->view->error = 'Financial start and end date should be exactly one year';
				}
			}

		}
	}

	public function updateProfileAction() {
		if(!Zend_Session::namespaceIsset('sess_login')) {
			$this->_redirect('index');
		} else {
			$logSession = new Zend_Session_Namespace('sess_login');
			if(isset($logSession->proxy_id) && !empty($logSession->proxy_id)) {
				$id = $logSession->proxy_id;
			} else {
				$id = $logSession->id;
			}
			if(Zend_Session::namespaceIsset('update_success_user')) {
				$this->view->success = 'Details Updated Successfully';
				Zend_Session::namespaceUnset('update_success_user');
			}
			$getAccountArray       	   =  $this->accountData->getData(array('account_types'));
			$this->view->account_types =  $getAccountArray['account_types'];
			$this->view->result        =  $this->account->getLoginDetails($id);
			//print_r($this->view->login);
			if($this->_request->isPost()) {
				$postArray  				= $this->getRequest()->getPost();
				$checkUsername			= $this->account->checkLogin($postArray['username'],$id);
				if(!$checkUsername) {
					$result					= $this->account->updateLogin($postArray,$id);
					if($result) {
						$sessSuccess = new Zend_Session_Namespace('update_success_user');
						$sessSuccess->status = 1;
						$this->_redirect('index/update-profile');
					} else {
						$this->view->error = 'Details cannot be updated. Kindly try again later';
					} 
				} else {
					$this->view->error = 'Email ID already exists. Kindly try some other email address';
				}
			}
		}
	}

	public function incomeStatementAction() {
	  $this->_helper->getHelper('layout')->disableLayout();
	  $this->_helper->viewRenderer->setNoRender(true);
	  if($this->_request->isXmlHttpRequest()) {
		if ($this->_request->isPost()) {
		  $ajaxVal = $this->getRequest()->getPost();
			if($ajaxVal['action']=='incomes') {
				
			//$from = date('Y-01-01');
			$logSession = new Zend_Session_Namespace('sess_login');
				if(isset($logSession->proxy_cid) && !empty($logSession->proxy_cid)) {
					$cid = $logSession->proxy_cid;
				} else {
					$cid = $logSession->cid;
				}
			$getCompany = $this->account->getCompany($cid);
				foreach ($getCompany as $company) {
					$start_year = $company['financial_year_start_date'];
					$end_year   = $company['financial_year_end_date'];
				}
				$current_month = date('m-d');
				$finance_month = date('m-d',strtotime($start_year));
				if($current_month < $finance_month) {
					$cur_date  = date('Y-m-d',strtotime($start_year));
					$strtotime = strtotime($cur_date);
					$last_year = strtotime("-1 year",$strtotime);
					$current_year = date('Y-m-d',$last_year);
				} else {
					$current_year = date('Y-m-d',strtotime($start_year));
				}
			$from = $current_year;
			$to   = date('Y-m-d');

			$incomeAccount = $this->report->getIncomeAccountIncomes($from,$to);
			$incomeAccountInvoice = $this->report->getIncomeAccountInvoice($from,$to);
			$incomeAccountCredit  = $this->report->getIncomeAccountCredit($from,$to);
			$expenseAccount  = $this->report->getExpenseAccountExpenses($from,$to);
			$incomeJournalAccount   = $this->report->getIncomeJournalAccount($from,$to);
			$expenseJournalAccount  = $this->report->getExpenseJournalAccount($from,$to);
			$incomeAccountPay  = $this->report->getIncomeAccountIncomesPay($from,$to);
			$invoiceAccountPay = $this->report->getIncomeAccountInvoicesPay($from,$to);
			$expenseAccountPay = $this->report->getExpenseAccountExpensesPay($from,$to);
			$this->view->incomeCoa  = $this->transaction->getIncomeAccount();
			$this->view->expenseCoa = $this->transaction->getExpenseAccount();
			$incomes   = array();
			$invoices  = array();
			$invoicess = array();
			$expenses  = array();

			//echo '<pre>'; print_r($expenseAccountPay); echo '</pre>';


			$incomeStatement[7]['credit']  = 0.00;
			$incomeStatement[7]['debit']   = 0.00;
			$incomeStatement[7]['type']    = 1;

			$incomeStatement[8]['credit']  = 0.00;
			$incomeStatement[8]['debit']   = 0.00;
			$incomeStatement[8]['type']    = 2;

			$incomeStatement[2]['credit']  = 0.00;
			$incomeStatement[2]['debit']   = 0.00;
			$incomeStatement[2]['type']    = 2;

			foreach ($incomeAccount as $income) {
				$tax_amount   = ($income['amount'] * $income['tax_value'] / 100);
				$whole_income = $tax_amount+$income['amount'];
				if($income['transaction_currency']!='SGD') {
					$converted_amount = $income['amount']*$income['exchange_rate'];
					$whole_amount = $whole_income*$income['exchange_rate'];
					if($income['payment_status']==1 && $income['final_payment_date'] <= $to) {
						$incomes[$income['inc_id']] = $income['inc_id'];
						$incomeStatement[2]['debit']   += round($whole_amount,2);
					}
					//echo $whole_amount.'<br/>';
				} else {
					$converted_amount = $income['amount'];
				}

				if(array_key_exists($income['fkincome_type'], $incomeStatement)) {
					$incomeStatement[$income['fkincome_type']]['credit'] += $converted_amount;
				} else {
					$incomeStatement[$income['fkincome_type']]['credit']  = 0.00;
					$incomeStatement[$income['fkincome_type']]['debit']   = 0.00;
					$incomeStatement[$income['fkincome_type']]['type']    = 1;
					$incomeStatement[$income['fkincome_type']]['credit'] += $converted_amount;
				}
			}

			foreach ($incomeAccountInvoice as $invoice) {
				$discount_amount   = $invoice['discount_amount'];
				$total_income      = $invoice['unit_price']*$invoice['quantity'];
				$whole_income      = $invoice['unit_price']*$invoice['quantity'] - $invoice['discount_amount'];
				$tax_amount   	   = ($whole_income * $invoice['tax_value'] / 100);
				if($invoice['transaction_currency']!='SGD') {
					$converted_amount = $whole_income*$invoice['exchange_rate'];
					$whole_amount     = ($whole_income+$tax_amount)*$invoice['exchange_rate'];
					if($invoice['payment_status']==1 && $invoice['final_payment_date'] <= $to) {
						$invoicess[$invoice['inv_id']] = $invoice['inv_id'];
						$incomeStatement[2]['debit']   += $whole_amount;
					}
					
					/*if($discount_amount!=0) {
						$discount_amount  = $discount_amount*$invoice['exchange_rate'];
					} else {
						$discount_amount  = $discount_amount;
					}*/
				} else {
					$converted_amount = $whole_income;
					$discount_amount  = $discount_amount;
				}
				if(array_key_exists($invoice['fkincomeaccount_id'], $incomeStatement)) {
					$incomeStatement[$invoice['fkincomeaccount_id']]['credit'] += $converted_amount;
				} else {
					$incomeStatement[$invoice['fkincomeaccount_id']]['credit']  = 0.00;
					$incomeStatement[$invoice['fkincomeaccount_id']]['debit']   = 0.00;
					$incomeStatement[$invoice['fkincomeaccount_id']]['type']    = 1;
					$incomeStatement[$invoice['fkincomeaccount_id']]['credit'] += $converted_amount;
				}

				/*if(array_key_exists(7, $incomeStatement)) {
					$incomeStatement[7]['debit'] += $discount_amount;
				} else {
					$incomeStatement[7]['credit']  = 0.00;
					$incomeStatement[7]['debit']   = 0.00;
					$incomeStatement[7]['debit']  += $discount_amount;
				}*/
			}

			foreach ($incomeAccountCredit as $credit) {
				$discount_amount   = $credit['discount_amount'];
				$total_income      = $credit['unit_price']*$credit['quantity'];
				$whole_income      = $credit['unit_price']*$credit['quantity'] - $credit['discount_amount'];
				$tax_amount   	   = ($whole_income * $credit['tax_value'] / 100);
				if($credit['transaction_currency']!='SGD') {
					$converted_amount = $whole_income*$credit['exchange_rate'];
					$whole_amount     = ($whole_income+$tax_amount)*$credit['exchange_rate'];
					if(isset($invoices[$credit['invoice_no']])) {
						$invoices[$credit['invoice_no']]['amount'] += $whole_amount;
					} else {
						$invoices[$credit['invoice_no']]['amount'] = $whole_amount;
					}
					/*if($discount_amount!=0) {
						$discount_amount  = $discount_amount*$credit['exchange_rate'];
					} else {
						$discount_amount  = $discount_amount;
					}*/
				} else {
					$converted_amount = $whole_income;
					$discount_amount  = $discount_amount;
				}
				if(array_key_exists($credit['fkincomeaccount_id'], $incomeStatement)) {
					$incomeStatement[$credit['fkincomeaccount_id']]['debit'] += $converted_amount;
				} else {
					$incomeStatement[$credit['fkincomeaccount_id']]['debit']  = 0.00;
					$incomeStatement[$credit['fkincomeaccount_id']]['credit'] = 0.00;
					$incomeStatement[$credit['fkincomeaccount_id']]['type']   = 1;
					$incomeStatement[$credit['fkincomeaccount_id']]['debit'] += $converted_amount;
				}

				/*if(array_key_exists(7, $incomeStatement)) {
					$incomeStatement[7]['credit'] += $discount_amount;
				} else {
					$incomeStatement[7]['credit']  = 0.00;
					$incomeStatement[7]['debit']   = 0.00;
					$incomeStatement[7]['credit'] += $discount_amount;
				}*/
			}

			foreach ($expenseAccount as $expense) {
				$total_expense  = $expense['unit_price']*$expense['quantity'];
				/*if($expense['total_gst']!=0.00) {
					$tax_amount   = $expense['total_gst'];
				} else {*/
					$tax_amount   = ($total_expense * $expense['tax_value'] / 100);	
				//}
				
				$whole_expense = $total_expense+$tax_amount;
				if($expense['transaction_currency']!='SGD') {
					$converted_amount = $total_expense*$expense['exchange_rate'];
					if($expense['total_gst']!=0.00) {
						$whole_amount	  = ($total_expense*$expense['exchange_rate'])+$expense['total_gst'];
					} else {
						$whole_amount	  = ($total_expense+$tax_amount)*$expense['exchange_rate'];
					}
					if($expense['payment_status']==1 && $expense['final_payment_date'] <= $to) {
						$incomeStatement[2]['credit']   += round($whole_amount,2);
						$expenses[$expense['exp_id']] = $expense['exp_id'];
						/*echo $expense['exp_id'].'<br/>';
						echo $converted_amount.'<br/>';*/
					}
				} else {
					$converted_amount = $total_expense;
				}
				if(array_key_exists($expense['fkexpense_type'], $incomeStatement)) {
					$incomeStatement[$expense['fkexpense_type']]['debit'] += $converted_amount;
				} else {
					$incomeStatement[$expense['fkexpense_type']]['debit']  = 0.00;
					$incomeStatement[$expense['fkexpense_type']]['credit'] = 0.00;
					$incomeStatement[$expense['fkexpense_type']]['type']   = 2;
					$incomeStatement[$expense['fkexpense_type']]['debit'] += $converted_amount;
				}
			}

			foreach ($incomeJournalAccount as $incomeJournal) {
				if(array_key_exists($incomeJournal['fkaccount_id'], $incomeStatement)) {
					$incomeStatement[$incomeJournal['fkaccount_id']]['debit']  += $incomeJournal['debit'];
					$incomeStatement[$incomeJournal['fkaccount_id']]['credit'] += $incomeJournal['credit'];
				} else {
					$incomeStatement[$incomeJournal['fkaccount_id']]['debit']   = 0.00;
					$incomeStatement[$incomeJournal['fkaccount_id']]['credit']  = 0.00;
					$incomeStatement[$incomeJournal['fkaccount_id']]['type']    = 1;
					$incomeStatement[$incomeJournal['fkaccount_id']]['debit']  += $incomeJournal['debit'];
					$incomeStatement[$incomeJournal['fkaccount_id']]['credit'] += $incomeJournal['credit'];
				}
			}

			foreach ($expenseJournalAccount as $expenseJournal) {
				if(array_key_exists($expenseJournal['fkaccount_id'], $incomeStatement)) {
					$incomeStatement[$expenseJournal['fkaccount_id']]['debit']  += $expenseJournal['debit'];
					$incomeStatement[$expenseJournal['fkaccount_id']]['credit'] += $expenseJournal['credit'];
				} else {
					$incomeStatement[$expenseJournal['fkaccount_id']]['debit']   = 0.00;
					$incomeStatement[$expenseJournal['fkaccount_id']]['credit']  = 0.00;
					$incomeStatement[$expenseJournal['fkaccount_id']]['type']    = 2;
					$incomeStatement[$expenseJournal['fkaccount_id']]['debit']  += $expenseJournal['debit'];
					$incomeStatement[$expenseJournal['fkaccount_id']]['credit'] += $expenseJournal['credit'];
				}
			}

			foreach ($incomeAccountPay as $incomePay) {
				if($incomePay['pay_status']==1 && $incomePay['transaction_currency']!='SGD') {
					if(array_key_exists($incomePay['inc_id'], $incomes)) {
						$incomeStatement[2]['debit']   -= $incomePay['payment_amount'];
					}
				}
				if($incomePay['pay_amount']!=0) {
					if($incomePay['tax_value']!=0) {
						$tax_pay = ($incomePay['pay_amount'] * $incomePay['tax_value'] / 100);
						$discount_amount = $incomePay['pay_amount'] - $tax_pay;
					} else {
						$discount_amount = $incomePay['pay_amount'];
					}
					if(array_key_exists(7, $incomeStatement)) {
						$incomeStatement[7]['debit']  += $discount_amount;
					} else {
						$incomeStatement[7]['credit']  = 0.00;
						$incomeStatement[7]['debit']   = 0.00;
						$incomeStatement[7]['debit']  += $discount_amount;
					}
				}
			}

			foreach ($invoiceAccountPay as $invoicePay) {
				if($invoicePay['pay_status']==1 && $invoicePay['transaction_currency']!='SGD') {
					if(array_key_exists($invoicePay['inv_id'], $invoicess)) {
						if(isset($invoices[$invoicePay['invoice_no']])) {
							$incomeStatement[2]['debit']   -= round($invoices[$invoicePay['invoice_no']]['amount'],2);
						} 
						$incomeStatement[2]['debit']   -= $invoicePay['payment_amount'];
					}
					//echo $incomeStatement[2]['debit']."_".$incomeStatement[2]['credit'].'<br/>';
				}

				if($invoicePay['pay_amount']!=0) {
					if($invoicePay['tax_value']!=0) {
						$tax_pay = (($invoicePay['pay_amount'] * $invoicePay['tax_value']) / (100+$invoicePay['tax_value']));
						$discount_amount = $invoicePay['pay_amount'] - $tax_pay;
					} else {
						$discount_amount = $invoicePay['pay_amount'];
					}
					if(array_key_exists(7, $incomeStatement)) {
						$incomeStatement[7]['debit']  += $discount_amount;
					} else {
						$incomeStatement[7]['credit']  = 0.00;
						$incomeStatement[7]['debit']   = 0.00;
						$incomeStatement[7]['debit']  += $discount_amount;
					}
				}
			}

			foreach ($expenseAccountPay as $expensePay) {
				if($expensePay['pay_status']==1 && $expensePay['transaction_currency']!='SGD') {
					if(array_key_exists($expensePay['exp_id'], $expenses)) {
					     $incomeStatement[2]['credit']   -= $expensePay['payment_amount'];
					}
				//	echo $incomeStatement[2]['debit']."_".$incomeStatement[2]['credit'];
				}

				if($expensePay['pay_amount']!=0) {
					if($expensePay['tax_value']!=0) {
						$tax_pay = ($expensePay['pay_amount'] * $expensePay['tax_value'] / (100+$expensePay['tax_value']));
						$discount_amount = $expensePay['pay_amount'] - $tax_pay;
					} else {
						$discount_amount = $expensePay['pay_amount'];
					}
					if(array_key_exists(8, $incomeStatement)) {
						$incomeStatement[8]['credit'] += $discount_amount;
					} else {
						$incomeStatement[8]['credit']  = 0.00;
						$incomeStatement[8]['debit']   = 0.00;
						$incomeStatement[8]['credit']  += $discount_amount;
					}
				}
			}

			foreach ($this->view->incomeCoa as $inc) {
				if($inc['debit_opening_balance']!=0 || $inc['credit_opening_balance']!=0) {
					if(array_key_exists($inc['id'], $incomeStatement)) {
						$incomeStatement[$inc['id']]['debit']  += $inc['debit_opening_balance'];
						$incomeStatement[$inc['id']]['credit'] += $inc['credit_opening_balance'];
					} else {
						$incomeStatement[$inc['id']]['debit']   = 0.00;
						$incomeStatement[$inc['id']]['credit']  = 0.00;
						$incomeStatement[$inc['id']]['type']    = 1;
						$incomeStatement[$inc['id']]['debit']  += $inc['debit_opening_balance'];
						$incomeStatement[$inc['id']]['credit'] += $inc['credit_opening_balance'];
					}
				}
			}

			foreach ($this->view->expenseCoa as $exp) {
				if($exp['account_type']==4) {
					if($exp['debit_opening_balance']!=0 || $exp['credit_opening_balance']!=0) {
						if(array_key_exists($exp['id'], $incomeStatement)) {
							$incomeStatement[$exp['id']]['debit']  += $exp['debit_opening_balance'];
							$incomeStatement[$exp['id']]['credit'] += $exp['credit_opening_balance'];
						} else {
							$incomeStatement[$exp['id']]['debit']   = 0.00;
							$incomeStatement[$exp['id']]['credit']  = 0.00;
							$incomeStatement[$exp['id']]['type']    = 2;
							$incomeStatement[$exp['id']]['debit']  += $exp['debit_opening_balance'];
							$incomeStatement[$exp['id']]['credit'] += $exp['credit_opening_balance'];
						}
					}
				}
			}


			$foreignCurrency = array();

			$incomeAccountIncome     = $this->report->getGeneralIncomeAccountForeign($from,$to);

			$incomeAccountInvoice    = $this->report->getGeneralInvoiceIncomeAccountForeign($from,$to);

			$expenseAccount  		 = $this->report->getGeneralExpenseAccountForeign($from,$to);

			$incomeAccountIncomePay  = $this->report->getGeneralIncomePayAccountForeign($from,$to);

			$incomeAccountInvoicePay = $this->report->getInvoicePayAccountsForeign($from,$to);

			$expenseAccountPay       = $this->report->getExpensePayAccountsForeign($from,$to);

			$incomeAccountCredit  	 = $this->report->getGeneralCreditAccountForeign($from,$to);


			foreach ($incomeAccountIncome as $income) {
				
					    $tax_amount   = ($income['amount'] * $income['tax_value'] / 100);
						$total_income = $income['amount']+$tax_amount;	

						if($income['transaction_currency']!='SGD') {
							$converted_rate       = $income['exchange_rate'];
							$converted_amount     = $total_income*$income['exchange_rate'];
						} 
				if($income['final_payment_date'] <= $to) {
				    $foreignCurrency[$income['income_no']]['no'] 			 = $income['income_no'];	
					$foreignCurrency[$income['income_no']]['date'] 			 = $income['final_payment_date'];
					$foreignCurrency[$income['income_no']]['type'] 			 = "1";
					$foreignCurrency[$income['income_no']]['currency']  	 = $income['transaction_currency'];
					$foreignCurrency[$income['income_no']]['amount']    	 = $total_income;
					$foreignCurrency[$income['income_no']]['rate']      	 = $converted_rate;
					$foreignCurrency[$income['income_no']]['convert_amount'] = round($converted_amount,2);
					$foreignCurrency[$income['income_no']]['name'] 			 = $income['customer_name'];
					$foreignCurrency[$income['income_no']]['paid']       	 = 0.00;
				}

			}

			foreach ($incomeAccountIncomePay as $incomePay) {
				$foreignCurrency[$incomePay['income_no']]['paid']    += $incomePay['amount'];
			}


			foreach ($incomeAccountInvoice as $invoice) {
				
					    $tax_amount   = $invoice['tax_amount'] ;
						$total_income = $invoice['amount']+$tax_amount;	

						if($invoice['transaction_currency']!='SGD') {
							$converted_rate 	= $invoice['exchange_rate'];
							$converted_amount 	= $total_income*$invoice['exchange_rate'];
						}
					if($invoice['final_payment_date'] <= $to) {
						$foreignCurrency[$invoice['invoice_no']]['no'] 			     = $invoice['invoice_no'];
						$foreignCurrency[$invoice['invoice_no']]['date'] 			 = $invoice['final_payment_date'];
						$foreignCurrency[$invoice['invoice_no']]['type'] 			 = "1";
						$foreignCurrency[$invoice['invoice_no']]['currency']  		 = $invoice['transaction_currency'];
						$foreignCurrency[$invoice['invoice_no']]['amount']    		 = $total_income;
						$foreignCurrency[$invoice['invoice_no']]['rate']      		 = $converted_rate;
						$foreignCurrency[$invoice['invoice_no']]['convert_amount'] 	 = round($converted_amount,2);
						$foreignCurrency[$invoice['invoice_no']]['name'] 			 = $invoice['customer_name'];
						$foreignCurrency[$invoice['invoice_no']]['paid']       	 	 = 0.00;
					}

			}



			if(isset($incomeAccountCredit) && !empty($incomeAccountCredit)) {
				foreach ($incomeAccountCredit as $credit) {
					$amount = ($credit['unit_price'] * $credit['quantity'] - $credit['discount_amount']);
					$tax_amount = ($amount * $credit['tax_value'] / 100);
					$total_income = $amount+$tax_amount;
					if($credit['transaction_currency']!='SGD') {
						$converted_amount = $amount*$credit['exchange_rate'];
						$whole_amount 	  = $total_income*$credit['exchange_rate'];
						
					} else {
						$converted_amount = $amount;
						$whole_amount 	  = $total_income;
					}

					if(isset($foreignCurrency[$credit['invoice_no']])) {
						$credits = $foreignCurrency[$credit['invoice_no']]['convert_amount'] - round($whole_amount,2);
						$foreignCurrency[$credit['invoice_no']]['convert_amount'] = $credits;
					}
				}
			}


			foreach ($incomeAccountInvoicePay as $invoicePay) {
				$foreignCurrency[$invoicePay['invoice_no']]['paid']    += $invoicePay['amount'];
			}


			foreach ($expenseAccount as $expense) {
				
					/*if($expense['total_gst']!=0.00) {
						$tax_amount    = $expense['total_gst'];
					} else {*/
						$tax_amount    = $expense['tax_amount'];
					//}
					
					$total_expense = $expense['amount']+$tax_amount;	

					if($expense['transaction_currency']!='SGD') {
						$converted_rate     = $expense['exchange_rate'];
						if($expense['total_gst']!=0.00) {
							$converted_amount   = ($expense['amount']*$expense['exchange_rate'])+$expense['total_gst'];
						} else {
							$converted_amount   = $total_expense*$expense['exchange_rate'];
						}
						
					} 

					if($expense['final_payment_date'] <= $to) {
						$foreignCurrency[$expense['expense_no']]['no'] 			     = $expense['expense_no'];
						$foreignCurrency[$expense['expense_no']]['date'] 			 = $expense['final_payment_date'];
						$foreignCurrency[$expense['expense_no']]['type'] 			 = "2";
						$foreignCurrency[$expense['expense_no']]['currency']  		 = $expense['transaction_currency'];
						$foreignCurrency[$expense['expense_no']]['amount']    		 = $total_expense;
						$foreignCurrency[$expense['expense_no']]['rate']      		 = $converted_rate;
						$foreignCurrency[$expense['expense_no']]['convert_amount'] 	 = round($converted_amount,2);
						$foreignCurrency[$expense['expense_no']]['name'] 			 = $expense['vendor_name'];
						$foreignCurrency[$expense['expense_no']]['paid']       	 	 = 0.00;
					}
					
				}

				foreach ($expenseAccountPay as $expensePay) {
					$foreignCurrency[$expensePay['expense_no']]['paid']    += $expensePay['amount'];
				}


			  $total = 0.00;
              foreach ($foreignCurrency as $key => $exchange) {
                $sub_total = 0.00;
                $amounts   = 0.00;
                if($exchange['type']==1) {
                  $amount = $exchange['convert_amount'] - $exchange['paid'];
                  if($amount>0) {
                    $sub_total = "(".number_format(abs($amount),2,'.',',').")";
                    $amounts   = -$amount;
                  } else {
                    $sub_total = number_format(abs($amount),2,'.',',');
                    $amounts   = -($amount);
                  }
                } else if($exchange['type']==2) { 
                  $amount = $exchange['convert_amount'] - $exchange['paid'];
                  if($amount<0) {
                    $sub_total = "(".number_format(abs($amount),2,'.',',').")";
                    $amounts   = $amount;
                  } else {
                    $sub_total = number_format(abs($amount),2,'.',',');
                    $amounts   = +$amount;
                  }
                }
                $total += $amounts;
               }

               $foreignCurrency = (-1)*($total);

			//echo '<pre>'; print_r($incomeStatement); echo '</pre>';

			$total_income  = 0.00;
			$total_expense = 0.00;
			$totals         = 0.00;

			foreach ($incomeStatement as $key=> $inc) {
				if($key!=2) {
				if($inc['type']==1) {
					if($key==7) {
						$amount = ($inc['credit']-$inc['debit']);
						$total_income += $amount;
					} else {
						$amount = ($inc['credit']-$inc['debit']);
						$total_income += $amount;
					}
				} else if($inc['type']==2) {
					if($key==8) {
						$amount = ($inc['debit']-$inc['credit']);
						$total_expense += $amount;
					} else {
						$amount = ($inc['debit']-$inc['credit']);
						$total_expense += $amount;
					}
				}
				}
				//echo $key."_".$amount.'<br/>'; 
			}

			$total_expense += $foreignCurrency; 

			$totals = $total_income-$total_expense;
			if($total_income<0) {
				echo '<tr><td>Income</td><td style="text-align:right">('.number_format(abs($total_income),2,'.',',').')</td></tr>';
			} else {
				echo '<tr><td>Income</td><td style="text-align:right">'.number_format($total_income,2,'.',',').'</td></tr>';
			}

			if($total_expense<0) {
				echo '<tr><td>Expense</td><td style="text-align:right">('.number_format(abs($total_expense),2,'.',',').')</td></tr>';
			} else {
				echo '<tr><td>Expense</td><td style="text-align:right">'.number_format($total_expense,2,'.',',').'</td></tr>';
			}

			if($totals<0) {
				echo '<tr><td>Net Income</td><td style="text-align:right">('.number_format(abs($totals),2,'.',',').')</td></tr>';
			} else {
				echo '<tr><td>Net Income</td><td style="text-align:right">'.number_format($totals,2,'.',',').'</td></tr>';
			}
			//$this->view->incomeStatement = $incomeStatement;
			//echo '<pre>'; print_r($incomeStatement); echo '</pre>';
			} 
		} 
	  } 
  	}

  	public function receivablesAction() {
	  $this->_helper->getHelper('layout')->disableLayout();
	  $this->_helper->viewRenderer->setNoRender(true);
	  if($this->_request->isXmlHttpRequest()) {
		if ($this->_request->isPost()) {
		  $ajaxVal = $this->getRequest()->getPost();
			if($ajaxVal['action']=='receivable') {

				$to = date('Y-m-d');

				$getAccountArray            =  $this->accountData->getData(array('creditTermArray'));
				$this->view->creditTerm     =  $getAccountArray['creditTermArray'];
				//$this->view->customers      =  $this->business->getCustomerName();
				$incomeAccountReceivable 	=  $this->report->getIncomeAccountReceivables($to);
				$incomeAccountCash 			=  $this->report->getIncomeAccountCash($to);
				$incomeAccountInvoiceReceivable = $this->report->getIncomeAccountInvoiceReceivables($to);
				$incomeAccountInvoiceCash = $this->report->getIncomeAccountInvoiceCash($to);
				$incomeAccountCreditReceivable = $this->report->getIncomeAccountCreditReceivables($to);
				$incomeReceivable = array();
				
			foreach ($incomeAccountReceivable as $incomeReceive) {
					if($incomeReceive['transaction_currency']!='SGD') {
						$converted_pending_amount = $incomeReceive['amount']*$incomeReceive['exchange_rate'];
					} else {
						$converted_pending_amount = $incomeReceive['amount'];
					}
					/*$inc_date = $incomeReceive['inc_date'];
					if($incomeReceive['credit_term']!=1) {
						$days     = $this->view->creditTerm[$incomeReceive['credit_term']];
						$due_date = date('Y-m-d', strtotime("$inc_date +$days day")); 
					} else {
						$due_date = $inc_date;
					}*/
					$due_date = $incomeReceive['inc_date'];
					$incomeReceivable[$incomeReceive['fkcustomer_id']][$incomeReceive['income_no']] = array('due_date' => $due_date,'amount' => $converted_pending_amount,'currency' => $incomeReceive['transaction_currency'],'paid' => '0.00','pending' => $converted_pending_amount);
			}

			foreach ($incomeAccountCash as $incomeCash) {
				if(array_key_exists($incomeCash['fkcustomer_id'], $incomeReceivable) && array_key_exists($incomeCash['income_no'], $incomeReceivable[$incomeCash['fkcustomer_id']])) {
					$incomeReceivable[$incomeCash['fkcustomer_id']][$incomeCash['income_no']]['paid'] += $incomeCash['pay_amount'];
					$totalAmount = $incomeReceivable[$incomeCash['fkcustomer_id']][$incomeCash['income_no']]['amount'] - $incomeReceivable[$incomeCash['fkcustomer_id']][$incomeCash['income_no']]['paid'];
					/*if($incomeReceivable[$incomeCash['fkcustomer_id']][$incomeCash['income_no']]['currency']!='SGD') {
						$converted_amount = $this->convertCurrency($totalAmount,$incomeReceivable[$incomeCash['fkcustomer_id']]['income_no']['currency']);
					} else {
						$converted_amount = $totalAmount;
					}*/
					$incomeReceivable[$incomeCash['fkcustomer_id']][$incomeCash['income_no']]['pending']  = $totalAmount;
				}
			}

			foreach ($incomeAccountInvoiceReceivable as $incomeInvoiceReceive) {
				if($incomeInvoiceReceive['transaction_currency']!='SGD') {
					$converted_pending_amount = $incomeInvoiceReceive['amount']*$incomeInvoiceReceive['exchange_rate'];
				} else {
					$converted_pending_amount = $incomeInvoiceReceive['amount'];
				}
				$incomeReceivable[$incomeInvoiceReceive['fkcustomer_id']][$incomeInvoiceReceive['invoice_no']] = array('due_date' => $incomeInvoiceReceive['inv_date'],'amount' => $converted_pending_amount,'currency' => $incomeInvoiceReceive['transaction_currency'],'paid' => '0.00','pending' => $converted_pending_amount);
			}

			foreach ($incomeAccountInvoiceCash as $incomeInvoiceCash) {
				if(array_key_exists($incomeInvoiceCash['fkcustomer_id'], $incomeReceivable) && array_key_exists($incomeInvoiceCash['invoice_no'], $incomeReceivable[$incomeInvoiceCash['fkcustomer_id']])) {
					$incomeReceivable[$incomeInvoiceCash['fkcustomer_id']][$incomeInvoiceCash['invoice_no']]['paid'] += $incomeInvoiceCash['pay_amount'];
					$totalAmount = $incomeReceivable[$incomeInvoiceCash['fkcustomer_id']][$incomeInvoiceCash['invoice_no']]['amount'] - $incomeReceivable[$incomeInvoiceCash['fkcustomer_id']][$incomeInvoiceCash['invoice_no']]['paid'];
					/*if($incomeReceivable[$incomeInvoiceCash['fkcustomer_id']][$incomeInvoiceCash['invoice_no']]['currency']!='SGD') {
						$converted_amount = $this->convertCurrency($totalAmount,$incomeReceivable[$incomeInvoiceCash['fkcustomer_id']][$incomeInvoiceCash['invoice_no']]['currency']);
					} else {
						$converted_amount = $totalAmount;
					}*/
					$incomeReceivable[$incomeInvoiceCash['fkcustomer_id']][$incomeInvoiceCash['invoice_no']]['pending']  = $totalAmount;
				}
			}

			foreach ($incomeAccountCreditReceivable as $incomeCreditCash) {
				if(array_key_exists($incomeCreditCash['fkcustomer_id'], $incomeReceivable) && array_key_exists($incomeCreditCash['invoice_no'], $incomeReceivable[$incomeCreditCash['fkcustomer_id']])) {
					if($incomeCreditCash['transaction_currency']!='SGD') {
						$incomeReceivable[$incomeCreditCash['fkcustomer_id']][$incomeCreditCash['invoice_no']]['paid'] += ($incomeCreditCash['amount']*$incomeCreditCash['exchange_rate']);
					} else {
						$incomeReceivable[$incomeCreditCash['fkcustomer_id']][$incomeCreditCash['invoice_no']]['paid'] += $incomeCreditCash['amount'];
					}
					$totalAmount = round($incomeReceivable[$incomeCreditCash['fkcustomer_id']][$incomeCreditCash['invoice_no']]['amount'],2) - round($incomeReceivable[$incomeCreditCash['fkcustomer_id']][$incomeCreditCash['invoice_no']]['paid'],2);
					/*if($incomeReceivable[$incomeInvoiceCash['fkcustomer_id']][$incomeInvoiceCash['invoice_no']]['currency']!='SGD') {
						$converted_amount = $this->convertCurrency($totalAmount,$incomeReceivable[$incomeInvoiceCash['fkcustomer_id']][$incomeInvoiceCash['invoice_no']]['currency']);
					} else {
						$converted_amount = $totalAmount;
					}*/
					$incomeReceivable[$incomeCreditCash['fkcustomer_id']][$incomeCreditCash['invoice_no']]['pending']  = $totalAmount;
				}
			}


				$start    = date('Y-m-d',strtotime($to));
              	$start_ts = strtotime($start);


                 $first_receievable = 0.00;
                 $second_receievable = 0.00;
                 $third_receievable = 0.00;
                 $fourth_receievable = 0.00;
                 $fifth_receievable = 0.00;
                 $sixth_receievable = 0.00;
                 $total_receivable = 0.00;
                 $total_due = 0.00;

            if(isset($incomeReceivable) && !empty($incomeReceivable)) {
                foreach ($incomeReceivable as $keys => $receivables) {
                      $first  = '0.00';
                      $second = '0.00';
                      $third  = '0.00';
                      $fourth = '0.00';
                      $fifth  = '0.00';
                      $sixth  = '0.00';
                      $due    = '0.00';
                    
                  foreach($receivables as $key => $receivable) {
                      $receivable_amount =  $receivable['pending'];
                      if($receivable_amount!=0) {
                            $end = $receivable['due_date'];
                            $end_ts = strtotime($end);
                            $diff = $end_ts - $start_ts;
                            $days = round($diff / 86400);
                            if($days>0) {
                              $first += $receivable_amount;
                              $first_receievable += $receivable_amount;
                            } else {
                              $day = abs($days);
                              if($day<=30) {
                                $second += $receivable_amount;
                                $second_receievable += $receivable_amount;
                              } else if($day>30 && $day<=60) {
                                $third += $receivable_amount;
                                $third_receievable += $receivable_amount;
                              } else if($day>60 && $day<=90) {
                                $fourth += $receivable_amount;
                                $fourth_receievable += $receivable_amount;
                              } else if($day>90 && $day<=120) {
                                $fifth += $receivable_amount;
                                $fifth_receievable += $receivable_amount;
                              } else if($day>120) {
                                $sixth += $receivable_amount;
                                $sixth_receievable += $receivable_amount;
                              }
                            }
                            $total_receivable += $receivable_amount;
                      }
                  }
                   $due               = $second+$third+$fourth+$fifth+$sixth;
                   $total_due        += $due;
                   if($due!=0) {
                

                  }
                }
            }

           echo '<tr><td><strong>Amount Due</strong></td>
                  <td style="text-align:right;">'.number_format($total_due,2,'.',',').'</td>
            	</tr>';
            echo '<tr> 
            	  <td><strong>1 - 30</strong></td>
                  <td style="text-align:right;">'.number_format($second_receievable,2,'.',',').'</td>
           		 </tr>';
            echo '<tr> 
            	  <td><strong>30 - 60</strong></td>
                  <td style="text-align:right;">'.number_format($third_receievable,2,'.',',').'</td>
            	 </tr>';
            echo '<tr> 
            	  <td><strong>60 - 90</strong></td>
                  <td style="text-align:right;">'.number_format($fourth_receievable,2,'.',',').'</td>
                  </tr>';
            echo '<tr> 
            	  <td><strong>90 - 120</strong></td>
                  <td style="text-align:right;">'.number_format($fifth_receievable,2,'.',',').'</td>
            	 </tr>';
            echo '<tr> 
            	  <td><strong>> 120</strong></td>
                  <td style="text-align:right;">'.number_format($sixth_receievable,2,'.',',').'</td>
            	  </tr>';     
           
			      
			} 
		} 
	  } 
  	}


  	public function payablesAction() {
	  $this->_helper->getHelper('layout')->disableLayout();
	  $this->_helper->viewRenderer->setNoRender(true);
	  if($this->_request->isXmlHttpRequest()) {
		if ($this->_request->isPost()) {
		  $ajaxVal = $this->getRequest()->getPost();
			if($ajaxVal['action']=='payable') {
			      $to = date('Y-m-d');

			        $getAccountArray           =  $this->accountData->getData(array('creditTermArray'));
					$this->view->creditTerm    =  $getAccountArray['creditTermArray'];
					$expenseAccountPayable 	   = $this->report->getExpenseAccountPayables($to);
					$expenseAccountCash        = $this->report->getExpenseAccountCash($to);

					$expensePayable = array();
		     		
			foreach ($expenseAccountPayable as $expensePay) {
					if($expensePay['transaction_currency']!='SGD') {
						$converted_pending_amount = $expensePay['amount']*$expensePay['exchange_rate'];
					} else {
						$converted_pending_amount = $expensePay['amount'];
					}
					$expensePayable[$expensePay['fkvendor_id']][$expensePay['expense_no']] = array('due_date' => $expensePay['exp_date'],'amount' => $converted_pending_amount,'currency' => $expensePay['transaction_currency'],'paid' => '0.00','pending' => $converted_pending_amount);
			}

			foreach ($expenseAccountCash as $expenseCash) {
				if(array_key_exists($expenseCash['fkvendor_id'], $expensePayable) && array_key_exists($expenseCash['expense_no'], $expensePayable[$expenseCash['fkvendor_id']])) {
					$expensePayable[$expenseCash['fkvendor_id']][$expenseCash['expense_no']]['paid'] += $expenseCash['pay_amount'];
					$totalAmount = $expensePayable[$expenseCash['fkvendor_id']][$expenseCash['expense_no']]['amount'] - $expensePayable[$expenseCash['fkvendor_id']][$expenseCash['expense_no']]['paid'];
					/*if($expensePayable[$expenseCash['fkvendor_id']][$expenseCash['expense_no']]['currency']!='SGD') {
						$converted_amount = $this->convertCurrency($totalAmount,$expensePayable[$expenseCash['fkvendor_id']][$expenseCash['expense_no']]['currency']);
					} else {
						$converted_amount = $totalAmount;
					}*/
					$expensePayable[$expenseCash['fkvendor_id']][$expenseCash['expense_no']]['pending']  = $totalAmount;
				} 
			}



			  $start = date('Y-m-d',strtotime($to));
              $start_ts = strtotime($start);


                 $first_payable = 0.00;
                 $second_payable = 0.00;
                 $third_payable = 0.00;
                 $fourth_payable = 0.00;
                 $fifth_payable = 0.00;
                 $sixth_payable = 0.00;
                 $total_payable = 0.00;
                 $total_due = 0.00;

            if(isset($expensePayable) && !empty($expensePayable)) {
                foreach ($expensePayable as $keys => $payables) {
                      $first = '0.00';
                      $second = '0.00';
                      $third = '0.00';
                      $fourth = '0.00';
                      $fifth = '0.00';
                      $sixth = '0.00';
                      $due   = '0.00';
                      $vendor_name = '';
                 
                  foreach($payables as $key => $payable) {
                      $payable_amount =  $payable['pending'];
                      if($payable_amount!=0) {
                      $end = $payable['due_date'];
                      $end_ts = strtotime($end);
                      $diff = $end_ts - $start_ts;
                      $days = round($diff / 86400);
                      if($days>0) {
                        $first = $payable_amount;
                        $first_payable += $payable_amount;
                      } else {
                        $day = abs($days);
                        if($day<=30) {
                          $second = $payable_amount;
                          $second_payable += $payable_amount;
                        } else if($day>30 && $day<=60) {
                          $third = $payable_amount;
                          $third_payable += $payable_amount;
                        } else if($day>60 && $day<=90) {
                          $fourth = $payable_amount;
                          $fourth_payable += $payable_amount;
                        } else if($day>90 && $day<=120) {
                          $fifth = $payable_amount;
                          $fifth_payable += $payable_amount;
                        } else if($day>120) {
                          $sixth = $payable_amount;
                          $sixth_payable += $payable_amount;
                        }
                      }
                      $total_payable += $payable_amount;
                  }
                }
                   $due               = $second+$third+$fourth+$fifth+$sixth;
                   $total_due        += $due;
                    if($due!=0) {

                

                  }
                }
            }

            echo '<tr><td><strong>Amount Due</strong></td>
                  <td style="text-align:right;">'.number_format($total_due,2,'.',',').'</td>
            	</tr>';
            echo '<tr> 
            	  <td><strong>1 - 30</strong></td>
                  <td style="text-align:right;">'.number_format($second_payable,2,'.',',').'</td>
           		 </tr>';
            echo '<tr> 
            	  <td><strong>30 - 60</strong></td>
                  <td style="text-align:right;">'.number_format($third_payable,2,'.',',').'</td>
            	 </tr>';
            echo '<tr> 
            	  <td><strong>60 - 90</strong></td>
                  <td style="text-align:right;">'.number_format($fourth_payable,2,'.',',').'</td>
                  </tr>';
            echo '<tr> 
            	  <td><strong>90 - 120</strong></td>
                  <td style="text-align:right;">'.number_format($fifth_payable,2,'.',',').'</td>
            	 </tr>';
            echo '<tr> 
            	  <td><strong>> 120</strong></td>
                  <td style="text-align:right;">'.number_format($sixth_payable,2,'.',',').'</td>
            	  </tr>';  

			} 
		} 
	  } 
  	}


	public function expensePieAction() {
	  $this->_helper->getHelper('layout')->disableLayout();
	  $this->_helper->viewRenderer->setNoRender(true);
	 /* $from = date('Y-01-01');
	  $to = date('Y-m-d');*/

	  $logSession = new Zend_Session_Namespace('sess_login');
				if(isset($logSession->proxy_cid) && !empty($logSession->proxy_cid)) {
					$cid = $logSession->proxy_cid;
					$this->json    =  "..".$this->uploadPath.$logSession->proxy_cid."/accounts.json";
				} else {
					$cid = $logSession->cid;
					$this->json    =  "..".$this->uploadPath.$logSession->cid."/accounts.json";
				}

				$incomeStatement = array();

				$phpNative = Zend_Json::decode(file_get_contents($this->json));

				foreach ($phpNative as  $key => $value) {
					if($key=='Expense') {
						$i=1;
			      		foreach ($value as $keys => $values) {
			      			$j=1;
			      			foreach ($values as $key1 => $value1) {
			      				$incomeStatement[$i][$j]['name']   = $key1;
			      				$incomeStatement[$i][$j]['credit'] = 0.00;
			      				$incomeStatement[$i][$j]['debit']  = 0.00;
			      				$j++;
			      			}
			      		$i++;
			      		}
			      	 }
			    }

		      	 //print_r($expense);

			$getCompany = $this->account->getCompany($cid);
				foreach ($getCompany as $company) {
					$start_year = $company['financial_year_start_date'];
					$end_year   = $company['financial_year_end_date'];
				}
				$current_month = date('m-d');
				$finance_month = date('m-d',strtotime($start_year));
				if($current_month < $finance_month) {
					$cur_date  = date('Y-m-d',strtotime($start_year));
					$strtotime = strtotime($cur_date);
					$last_year = strtotime("-1 year",$strtotime);
					$current_year = date('Y-m-d',$last_year);
				} else {
					$current_year = date('Y-m-d',strtotime($start_year));
				}
				$from 		  = $current_year;
			$to = date('Y-m-d');

	  

	  $expenseAccount  		  = $this->report->getExpenseAccountExpensesPie($from,$to);
	  $expenseJournalAccount  = $this->report->getExpenseJournalAccountPie($from,$to);
	  $expenseAccountPay 	  = $this->report->getExpenseAccountExpensesPayPie($from,$to);
	  $this->expenseCoa 	  = $this->transaction->getExpensePieAccount();
/*
	  		$incomeStatement[8]['credit']  = 0.00;
			$incomeStatement[8]['debit']   = 0.00;
			$incomeStatement[8]['type']    = 2;

			$incomeStatement[2]['credit']  = 0.00;
			$incomeStatement[2]['debit']   = 0.00;
			$incomeStatement[2]['type']    = 2;*/

	  		foreach ($expenseAccount as $expense) {
				$total_expense  = $expense['unit_price']*$expense['quantity'];
				if($expense['total_gst']!=0.00) {
					$tax_amount   = $expense['total_gst'];
				} else {
					$tax_amount   = ($total_expense * $expense['tax_value'] / 100);	
				}
				$whole_expense = $total_expense+$tax_amount;
				if($expense['transaction_currency']!='SGD') {
					$converted_amount = $total_expense*$expense['exchange_rate'];
					$whole_amount	  = $whole_expense*$expense['exchange_rate'];
					if($expense['payment_status']==1 && $expense['final_payment_date'] <= $to) {
						$incomeStatement[1][1]['credit']   += $whole_amount;
						/*echo $expense['exp_id'].'<br/>';
						echo $converted_amount.'<br/>';*/
					}
				} else {
					$converted_amount = $total_expense;
				}
				//if(array_key_exists($expense['fkexpense_type'], $incomeStatement)) {
					$incomeStatement[$expense['level1']][$expense['level2']]['debit'] += $converted_amount;
				/*} else {
					$incomeStatement[$expense['fkexpense_type']]['debit']  = 0.00;
					$incomeStatement[$expense['fkexpense_type']]['credit'] = 0.00;
					$incomeStatement[$expense['fkexpense_type']]['type']   = 2;
					$incomeStatement[$expense['fkexpense_type']]['debit'] += $converted_amount;
				}*/
			}


			foreach ($expenseJournalAccount as $expenseJournal) {
				//if(array_key_exists($expenseJournal['fkaccount_id'], $incomeStatement)) {
					$incomeStatement[$expenseJournal['level1']][$expenseJournal['level2']]['debit']  += $expenseJournal['debit'];
					$incomeStatement[$expenseJournal['level1']][$expenseJournal['level2']]['credit'] += $expenseJournal['credit'];
				/*} else {
					$incomeStatement[$expenseJournal['fkaccount_id']]['debit']   = 0.00;
					$incomeStatement[$expenseJournal['fkaccount_id']]['credit']  = 0.00;
					$incomeStatement[$expenseJournal['fkaccount_id']]['type']    = 2;
					$incomeStatement[$expenseJournal['fkaccount_id']]['debit']  += $expenseJournal['debit'];
					$incomeStatement[$expenseJournal['fkaccount_id']]['credit'] += $expenseJournal['credit'];
				}*/
			}


			foreach ($expenseAccountPay as $expensePay) {
				if($expensePay['pay_status']==1 && $expensePay['transaction_currency']!='SGD') {
					$incomeStatement[1][1]['credit']   -= $expensePay['payment_amount'];
				//	echo $incomeStatement[2]['debit']."_".$incomeStatement[2]['credit'];
				}
				if($expensePay['pay_amount']!=0) {
					if($expensePay['tax_value']!=0) {
						$tax_pay = ($expensePay['pay_amount'] * $expensePay['tax_value'] / 100);
						$discount_amount = $expensePay['pay_amount'] - $tax_pay;
					} else {
						$discount_amount = $expensePay['pay_amount'];
					}
					//if(array_key_exists(8, $incomeStatement)) {
						$incomeStatement[1][1]['credit'] += $discount_amount;
					/*} else {
						$incomeStatement[8]['credit']  = 0.00;
						$incomeStatement[8]['debit']   = 0.00;
						$incomeStatement[8]['credit']  += $discount_amount;
					}*/
				}
			}

			//print_r($incomeStatement);


	 $json = '{
  "cols": [
        {"id":"coa","label":"Coa","type":"string"},
        {"id":"amount","label":"Amount","type":"number"},
      ],
  "rows": [';

  	foreach ($incomeStatement as $key => $inc) {
  	   foreach ($inc as $keys => $values) {
  		$account_name = $values['name'];
  		/*foreach ($this->expenseCoa as $expenseCoa) {
  			if($expenseCoa['id']==$key) {
  				$account_name = $expenseCoa['account_name'];
  			}
  		}*/
  		if($account_name!='') {
	  		$amount = ($values['debit']-$values['credit']);
			/*if($key==8) {
				$amount = ($inc['debit']-$inc['credit']);
				$account_name = "Discounts Received";
			} else {
				$amount = ($inc['debit']-$inc['credit']);
			}	*/	
			if($amount<0) {
				$amount = -$amount;
			}
			$amount = number_format($amount,2,'.','');
		  	$json .= '{"c":[{"v":"'.$account_name.'","f":null},{"v":'.$amount.',"f":null}]},';
	  	}
	   }
	  }

       /*$json .= '{"c":[{"v":"Mushrooms","f":null},{"v":3,"f":null}]},
        {"c":[{"v":"Onions","f":null},{"v":1,"f":null}]},
        {"c":[{"v":"Olives","f":null},{"v":1,"f":null}]},
        {"c":[{"v":"Zucchini","f":null},{"v":1,"f":null}]},
        {"c":[{"v":"Pepperoni","f":null},{"v":2,"f":null}]}';*/
      $json .= ']
}';
echo $json;
  	}

	public function convertCurrencyAction() {
	  $this->_helper->getHelper('layout')->disableLayout();
	  $this->_helper->viewRenderer->setNoRender(true);
	  if($this->_request->isXmlHttpRequest()) {
		if ($this->_request->isPost()) {
		  $ajaxVal = $this->getRequest()->getPost();
			if($ajaxVal['action']=='converter') {
			      $amount = $ajaxVal['amount'];
			      $from   = $ajaxVal['from'];
			      $to     = 'SGD';
			      $url  = "https://www.google.com/finance/converter?a=$amount&from=$from&to=$to";
			      $data = file_get_contents($url);
			      preg_match("/<span class=bld>(.*)<\/span>/",$data, $converted);
			      $converted = preg_replace("/[^0-9.]/", "", $converted[1]);
			      echo round($converted, 5);
			} 
		} 
	  } 
  	}

  	function convertCurrency($amount, $from){
		$to   = 'SGD';
	    $url  = "https://www.google.com/finance/converter?a=$amount&from=$from&to=$to";
	    $data = file_get_contents($url);
	    preg_match("/<span class=bld>(.*)<\/span>/",$data, $converted);
	    $converted = preg_replace("/[^0-9.]/", "", $converted[1]);
	    return round($converted, 3);
	}

	public function logoutAction() {
		$this->_helper->getHelper('layout')->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		$logSession = new Zend_Session_Namespace('sess_login');
		if($logSession->type!=0) {
			$auditLog	  = $this->settings->insertAuditLog(9,13,'Logged Out',$logSession->type);
		}
		if(Zend_Session::destroy()) {
			$this->_redirect('index');
		} else {
			$this->_redirect('index');
		}
	}
	
}

?>