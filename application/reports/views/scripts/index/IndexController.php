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
		$this->glroll      = new GlRoll();
		$this->income      = new Income();
		$this->bank        = new Bank();
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

		}
	}

	public function incomeStatementAction() {
		if(!Zend_Session::namespaceIsset('sess_login')) {
			 $this->_redirect('index');
		} else {
			$incomeStatement = array();
			
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
				$from 		  = $current_year;

				$to = date('Y-m-d');
			if($this->_request->isPost()) {
				$postArray  = $this->getRequest()->getPost();
				$from = date('Y-m-d',strtotime($postArray['from_date']));
				$to = date('Y-m-d',strtotime($postArray['to_date']));
			}
			$this->view->from = date('d-m-Y',strtotime($from));
			$this->view->to = date('d-m-Y',strtotime($to));
			//echo $this->convertCurrency(1, "USD");

			$logSession = new Zend_Session_Namespace('sess_login');
				if(isset($logSession->proxy_cid) && !empty($logSession->proxy_cid)) {
					$cid = $logSession->proxy_cid;
				} else {
					$cid = $logSession->cid;
				}
		      	$this->json    =  "..".$this->uploadPath.$cid."/accounts.json";
		      	$inc  = array();
		      	$exp  = array();
		      	$phpNative = Zend_Json::decode(file_get_contents($this->json));
		      	foreach ($phpNative as  $key => $value) {
		      	 if($key=='Income') {
		      		foreach ($value as $keys => $values) {
		      				foreach ($values as $key1 => $value1) {
		      					foreach ($value1 as $key2 => $value2) {
		      						$inc[$keys][$key1][$key2] = $value2;
		      					}
		      				}
		      		}
		      	 }  else  if($key=='Expense') {
		      		foreach ($value as $keys => $values) {
		      				foreach ($values as $key1 => $value1) {
		      					foreach ($value1 as $key2 => $value2) {
		      						$exp[$keys][$key1][$key2] = $value2;
		      					}
		      				}
		      		}
		      	 }
		      	}

		      	$this->view->income  = $inc;
		      	$this->view->expense = $exp;

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

			/*echo '<pre>'; print_r($invoiceAccountPay); echo '</pre>';
			echo '<pre>'; print_r($expenseAccountPay); echo '</pre>';*/
			//echo '<pre>'; print_r($expenseAccount); echo '</pre>';
			//echo '<pre>'; print_r($expenseAccountPay); echo '</pre>';

			$incomeStatement[7]['credit']  = 0.00;
			$incomeStatement[7]['debit']   = 0.00;

			$incomeStatement[8]['credit']  = 0.00;
			$incomeStatement[8]['debit']   = 0.00;

			$incomeStatement[2]['credit']  = 0.00;
			$incomeStatement[2]['debit']   = 0.00;
			$incomes   = array();
			$invoices  = array();
			$invoicess = array();
			$expenses  = array();

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
						$expenses[$expense['exp_id']] = $expense['exp_id'];
						$incomeStatement[2]['credit']   += round($whole_amount,2);
						/*echo $whole_amount;
						echo '<br/>';
						echo $expense['exp_id'].'<br/>';*/
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
					$incomeStatement[$expense['fkexpense_type']]['debit'] += $converted_amount;
				}
			}

			//print_r($incomeStatement[2]);

			foreach ($incomeJournalAccount as $incomeJournal) {
				if(array_key_exists($incomeJournal['fkaccount_id'], $incomeStatement)) {
					$incomeStatement[$incomeJournal['fkaccount_id']]['debit']  += $incomeJournal['debit'];
					$incomeStatement[$incomeJournal['fkaccount_id']]['credit'] += $incomeJournal['credit'];
				} else {
					$incomeStatement[$incomeJournal['fkaccount_id']]['debit']   = 0.00;
					$incomeStatement[$incomeJournal['fkaccount_id']]['credit']  = 0.00;
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

			//print_r($incomeStatement[2]);

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

			//print_r($incomeStatement[2]);

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
						$foreignCurrency[$invoice['invoice_no']]['convert_amount'] = $credits;
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

               $this->view->foreignCurrency = (-1)*($total);

			//print_r($incomeStatement[2]);

			foreach ($this->view->incomeCoa as $inc) {
				if($inc['debit_opening_balance']!=0 || $inc['credit_opening_balance']!=0) {
					if(array_key_exists($inc['id'], $incomeStatement)) {
						$incomeStatement[$inc['id']]['debit']  += $inc['debit_opening_balance'];
						$incomeStatement[$inc['id']]['credit'] += $inc['credit_opening_balance'];
					} else {
						$incomeStatement[$inc['id']]['debit']   = 0.00;
						$incomeStatement[$inc['id']]['credit']  = 0.00;
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
						$incomeStatement[$exp['id']]['debit']  += $exp['debit_opening_balance'];
						$incomeStatement[$exp['id']]['credit'] += $exp['credit_opening_balance'];
					}
				}
			}




			//echo '<pre>'; print_r($incomeStatement); echo '</pre>';

			$this->view->incomeStatement = $incomeStatement;
			//echo '<pre>'; print_r($this->view->incomeStatement); echo '</pre>';
			/*echo '<pre>'; print_r($expenseAccountPay); echo '</pre>';
			
			echo '<pre>'; print_r($invoices); echo '</pre>';*/
/*			$incomeAccount = $this->report->getIncomeAccountIncomes($from,$to);
			$incomeAccountInvoice = $this->report->getIncomeAccountInvoice($from,$to);
			$incomeAccountCredit  = $this->report->getIncomeAccountCredit($from,$to);
			$expenseAccount  = $this->report->getExpenseAccountExpenses($from,$to);
			$incomeCoa  = $this->transaction->getIncomeAccount();
			$expenseCoa = $this->transaction->getExpenseAccount();
			$incomeJournalAccount   = $this->report->getIncomeJournalAccount($from,$to);
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


			foreach ($incomeType as $key => $income) {
				foreach ($incomeCoa as $inc) {
                    if($key==$inc['id']) {
                        if($inc['account_id']<=82) {
                        	$revenue[$key]['account_name']  = $inc['account_name'];
                        	$revenue[$key]['account_id']    = $inc['account_id'];
                        	$revenue[$key]['debit_amount']  = $income['debit_amount']; 
                        	$revenue[$key]['credit_amount'] = $income['credit_amount'];
                        } else if($inc['account_id']>82) {
                            $indirectIncome[$key]['account_name']  = $inc['account_name'];
                            $indirectIncome[$key]['account_id']    = $inc['account_id'];
                        	$indirectIncome[$key]['debit_amount']  = $income['debit_amount']; 
                        	$indirectIncome[$key]['credit_amount'] = $income['credit_amount'];
                        }
                    }
                } 
			}

			foreach ($expenseType as $key => $expense) {
				foreach ($expenseCoa as $exp) {
                    if($key==$exp['id']) {
                        if($exp['account_id']<=30) {
                        	$costOfGoods[$key]['account_name']  = $exp['account_name'];
                        	$costOfGoods[$key]['account_id']    = $exp['account_id'];
                        	$costOfGoods[$key]['debit_amount']  = $expense['debit_amount']; 
                        	$costOfGoods[$key]['credit_amount'] = $expense['credit_amount'];
                        } else if($exp['account_id']>30) {
                            $indirectExpense[$key]['account_name']  = $exp['account_name'];
                            $indirectExpense[$key]['account_id']    = $exp['account_id'];
                        	$indirectExpense[$key]['debit_amount']  = $expense['debit_amount']; 
                        	$indirectExpense[$key]['credit_amount'] = $expense['credit_amount'];
                        }
                    }
                } 
			}

			$this->view->revenue  		 = $revenue;
			$this->view->indirectIncome  = $indirectIncome;
			$this->view->costOfGoods  	 = $costOfGoods;
			$this->view->indirectExpense = $indirectExpense;*/
			//echo '<pre>'; print_r($incomeAccount); echo '</pre>';
			//echo '<pre>'; print_r($incomeAccountInvoice); echo '</pre>';
			//echo '<pre>'; print_r($incomeAccountCredit); echo '</pre>';
			//echo '<pre>'; print_r($expenseAccount); echo '</pre>';
			//echo '<pre>'; print_r($this->view->incomeCoa); echo '</pre>';
			//echo '<pre>'; print_r($this->view->expenseCoa); echo '</pre>';
			//echo '<pre>'; print_r($incomeType); echo '</pre>';
			//echo '<pre>'; print_r($expenseType); echo '</pre>';
			//echo '<pre>'; print_r($incomeJournalAccount); echo '</pre>';
/*			echo '<pre>'; print_r($revenue); echo '</pre>';
			echo '<pre>'; print_r($indirectIncome); echo '</pre>';
			echo '<pre>'; print_r($costOfGoods); echo '</pre>';
			echo '<pre>'; print_r($indirectExpense); echo '</pre>';*/
		}
	}


	public function salesTaxAction() {
		if(!Zend_Session::namespaceIsset('sess_login')) {
			 $this->_redirect('index');
		} else {
			$taxReceivable = array();
			$taxPayable    = array();
			
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
				$from 		  = $current_year;
			$to = date('Y-m-d');
			if($this->_request->isPost()) {
				$postArray  = $this->getRequest()->getPost();
				$from = date('Y-m-d',strtotime($postArray['from_date']));
				$to = date('Y-m-d',strtotime($postArray['to_date']));
			}
			$this->view->from = date('d-m-Y',strtotime($from));
			$this->view->to = date('d-m-Y',strtotime($to));
			//echo $this->convertCurrency(1, "USD");

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
			$this->view->taxes 	    =  $this->settings->getTax();
			$incomeAccount = $this->report->getIncomeAccountIncomeTax($from,$to);
			$incomeAccountInvoice = $this->report->getIncomeAccountInvoiceTax($from,$to);
			$incomeAccountCredit  = $this->report->getIncomeAccountCreditTax($from,$to);
			$expenseAccount  	  = $this->report->getExpenseAccountExpenseTax($from,$to);

			$incomeAccountPay  = $this->report->getIncomeAccountIncomesPay($from,$to);
			$invoiceAccountPay = $this->report->getIncomeAccountInvoicesPay($from,$to);
			$expenseAccountPay = $this->report->getExpenseAccountExpensesPay($from,$to);

//			echo '<pre>'; print_r($expenseAccount); echo '</pre>';

			foreach ($incomeAccount as $income) {
				$tax_amount = ($income['amount'] * $income['tax_value'] / 100);
				if($income['transaction_currency']!='SGD') {
					$base_amount      = $income['amount']*$income['exchange_rate'];
					$converted_amount = $tax_amount*$income['exchange_rate'];
				} else {
					$base_amount	  = $income['amount'];
					$converted_amount = $tax_amount;
				}

				if(array_key_exists($income['fktax_id'], $taxPayable)) {
					$taxPayable[$income['fktax_id']]['amount'] 	   += $base_amount;
					$taxPayable[$income['fktax_id']]['tax_amount'] += round($converted_amount,2);
				} else {
					$taxPayable[$income['fktax_id']]['amount']  	= 0.00;
					$taxPayable[$income['fktax_id']]['tax_amount']  = 0.00;
					$taxPayable[$income['fktax_id']]['amount'] 	   += $base_amount;
					$taxPayable[$income['fktax_id']]['tax_amount'] += round($converted_amount,2);
				}
			}
			foreach ($incomeAccountInvoice as $invoice) {

				$amount = $invoice['amount'];
				$tax_amount = $invoice['tax_amount'];
				if($invoice['transaction_currency']!='SGD') {
					$base_amount	  = $amount*$invoice['exchange_rate'];
					$converted_amount = $tax_amount*$invoice['exchange_rate'];
				} else {
					$base_amount      = $amount;
					$converted_amount = $tax_amount;
				}

				if(array_key_exists($invoice['fktax_id'], $taxPayable)) {
					$taxPayable[$invoice['fktax_id']]['amount'] 	+= $base_amount;
					$taxPayable[$invoice['fktax_id']]['tax_amount'] += round($converted_amount,2);
				} else {
					$taxPayable[$invoice['fktax_id']]['amount']  	 = 0.00;
					$taxPayable[$invoice['fktax_id']]['tax_amount']  = 0.00;
					$taxPayable[$invoice['fktax_id']]['amount'] 	+= $base_amount;
					$taxPayable[$invoice['fktax_id']]['tax_amount'] += round($converted_amount,2);
				}
			}


			foreach ($incomeAccountCredit as $credit) {

				$amount = $credit['amount'];
				$tax_amount = $credit['tax_amount'];
				if($credit['transaction_currency']!='SGD') {
					$base_amount	  = $amount*$credit['exchange_rate'];
					$converted_amount = $tax_amount*$credit['exchange_rate'];
				} else {
					$base_amount      = $amount;
					$converted_amount = $tax_amount;
				}

				if(array_key_exists($credit['fktax_id'], $taxPayable)) {
					$taxPayable[$credit['fktax_id']]['amount'] 	   -= $base_amount;
					$taxPayable[$credit['fktax_id']]['tax_amount'] -= round($converted_amount,2);
				} else {
					$taxPayable[$credit['fktax_id']]['amount']  	= 0.00;
					$taxPayable[$credit['fktax_id']]['tax_amount']  = 0.00;
					$taxPayable[$credit['fktax_id']]['amount'] 	   -= $base_amount;
					$taxPayable[$credit['fktax_id']]['tax_amount'] -= round($converted_amount,2);
				}
			}

			foreach ($expenseAccount as $expense) {
				$amount = $expense['amount'];
				$tax_amount = $expense['tax_amount'];
				if($expense['transaction_currency']!='SGD') {
					$base_amount	  = $amount*$expense['exchange_rate'];
					if($expense['total_gst']!=0.00) {
						$converted_amount = $expense['total_gst'];
					} else {
						$converted_amount = $tax_amount*$expense['exchange_rate'];
					}
				} else {
					$base_amount	  = $amount;
					$converted_amount = $tax_amount;
				}

				if(array_key_exists($expense['fktax_id'], $taxReceivable)) {
					$taxReceivable[$expense['fktax_id']]['amount'] 	+= $base_amount;
					$taxReceivable[$expense['fktax_id']]['tax_amount'] += round($converted_amount,2);
				} else {
					$taxReceivable[$expense['fktax_id']]['amount']  	 = 0.00;
					$taxReceivable[$expense['fktax_id']]['tax_amount']  = 0.00;
					$taxReceivable[$expense['fktax_id']]['amount'] 	+= $base_amount;
					$taxReceivable[$expense['fktax_id']]['tax_amount'] += round($converted_amount,2);
				}
			}

			foreach ($incomeAccountPay as $incomePay) {
				if($incomePay['pay_amount']!=0) {
					if($incomePay['tax_value']!=0) {
						$tax_pay = (($incomePay['pay_amount'] * $incomePay['tax_value']) / (100+$incomePay['tax_value']));
						$discount_amount = $incomePay['pay_amount'] - $tax_pay;
						if(array_key_exists($incomePay['fktax_id'], $taxPayable)) {
							$taxPayable[$incomePay['fktax_id']]['amount'] -= $discount_amount;
							$taxPayable[$incomePay['fktax_id']]['tax_amount'] -= round($tax_pay,2);
						} else {
							$taxPayable[$incomePay['fktax_id']]['amount'] 	   = 0.00;
							$taxPayable[$incomePay['fktax_id']]['tax_amount']  = 0.00;
							$taxPayable[$incomePay['fktax_id']]['amount']     -= $discount_amount;
							$taxPayable[$incomePay['fktax_id']]['tax_amount'] -= round($tax_pay,2);
						}
					}
				} 
			}

			foreach ($invoiceAccountPay as $invoicePay) {
				if($invoicePay['pay_amount']!=0) {
					if($invoicePay['tax_value']!=0) {
						$tax_pay = (($invoicePay['pay_amount'] * $invoicePay['tax_value']) / (100+$invoicePay['tax_value']));
						$discount_amount = $invoicePay['pay_amount'] - $tax_pay;
						if(array_key_exists($invoicePay['fktax_id'], $taxPayable)) {
							$taxPayable[$invoicePay['fktax_id']]['amount'] -= $discount_amount;
							$taxPayable[$invoicePay['fktax_id']]['tax_amount'] -= round($tax_pay,2);
						} else {
							$taxPayable[$invoicePay['fktax_id']]['amount'] 	   = 0.00;
							$taxPayable[$invoicePay['fktax_id']]['tax_amount']  = 0.00;
							$taxPayable[$invoicePay['fktax_id']]['amount']     -= $discount_amount;
							$taxPayable[$invoicePay['fktax_id']]['tax_amount'] -= round($tax_pay,2);
						}
					}
				} 
			}

			foreach ($expenseAccountPay as $expensePay) {
				if($expensePay['pay_amount']!=0) {
					if($expensePay['tax_value']!=0) {
						$tax_pay = (($expensePay['pay_amount'] * $expensePay['tax_value']) / (100+$expensePay['tax_value']));
						$discount_amount = $expensePay['pay_amount'] - $tax_pay;
						if(array_key_exists($expensePay['fktax_id'], $taxReceivable)) {
							$taxReceivable[$expensePay['fktax_id']]['amount'] -= $discount_amount;
							$taxReceivable[$expensePay['fktax_id']]['tax_amount'] -= round($tax_pay,2);
						} else {
							$taxReceivable[$expensePay['fktax_id']]['amount'] 	   = 0.00;
							$taxReceivable[$expensePay['fktax_id']]['tax_amount']  = 0.00;
							$taxReceivable[$expensePay['fktax_id']]['amount']     -= $discount_amount;
							$taxReceivable[$expensePay['fktax_id']]['tax_amount'] -= round($tax_pay,2);
						}
					}
				} 
			}

			//echo '<pre>'; print_r($taxPayable); echo '</pre>';
			//echo '<pre>'; print_r($taxReceivable); echo '</pre>';
			//echo round($taxPayable[1]['tax_amount'],2);

			$this->view->taxReceivable = $taxReceivable;
			$this->view->taxPayable    = $taxPayable;

/*			$incomeAccount = $this->report->getIncomeAccountIncomes($from,$to);
			$incomeAccountInvoice = $this->report->getIncomeAccountInvoice($from,$to);
			$incomeAccountCredit  = $this->report->getIncomeAccountCredit($from,$to);
			$expenseAccount  = $this->report->getExpenseAccountExpenses($from,$to);*/


		}
	}



	public function salesTaxDetailAction() {
		if(!Zend_Session::namespaceIsset('sess_login')) {
			 $this->_redirect('index');
		} else {
			
			
			$logSession = new Zend_Session_Namespace('sess_login');
				if(isset($logSession->proxy_cid) && !empty($logSession->proxy_cid)) {
					$cid = $logSession->proxy_cid;
				} else {
					$cid = $logSession->cid;
				}

			

			$logSession = new Zend_Session_Namespace('sess_login');
				if(isset($logSession->proxy_cid) && !empty($logSession->proxy_cid)) {
					$cid = $logSession->proxy_cid;
				} else {
					$cid = $logSession->cid;
				}

		$sales  =  $this->_getParam('sales');
		$tid     = base64_decode($this->_getParam('tax'));
		$from    = $this->_getParam('fdate');
		$to      = $this->_getParam('tdate');

		if(isset($tid) && isset($from) && isset($to) && isset($sales) && !empty($tid) && !empty($from) && !empty($to) && !empty($sales) && ($sales==1 || $sales==2)) {


			$from = date('Y-m-d',strtotime($from));
			$to   = date('Y-m-d',strtotime($to));

			$this->view->from  = $from;
			$this->view->to    = $to;
			$this->view->sales = $sales;
			$this->view->tid   = $tid;

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
			$this->supply       = $supply;
			$this->purchase 	= $purchase;
			$this->taxes 		= $this->settings->getTax();
			
			if($sales==1) {

				foreach ($this->taxes as $taxes) {
                    if($taxes['id']==$tid) {
                      foreach ($this->supply as $keys => $supply) {
                        if($taxes['tax_code']==$keys) {
                           $code = $supply['name']." - ".$taxes['tax_percentage'];
                        }
                      }
                    }
                }

                $tax[$tid] = array();

				$incomeAccount = $this->report->getIncomeAccountIncomePartTax($from,$to,$tid);
				$incomeAccountInvoice = $this->report->getIncomeAccountInvoicePartTax($from,$to,$tid);
				$incomeAccountCredit  = $this->report->getIncomeAccountCreditPartTax($from,$to,$tid);
				

				$incomeAccountPay  = $this->report->getIncomeAccountIncomesPartPay($from,$to,$tid);
				$invoiceAccountPay = $this->report->getIncomeAccountInvoicesPartPay($from,$to,$tid);

			foreach ($incomeAccount as $income) {
				$tax_amount = ($income['amount'] * $income['tax_value'] / 100);
				if($income['transaction_currency']!='SGD') {
					$base_amount      = $income['amount']*$income['exchange_rate'];
					$converted_amount = $tax_amount*$income['exchange_rate'];
				} else {
					$base_amount	  = $income['amount'];
					$converted_amount = $tax_amount;
				}

				if(array_key_exists($income['income_no'], $tax[$income['fktax_id']])) {
					$tax[$income['fktax_id']][$income['income_no']]['amount'] 	+= $base_amount;
					$tax[$income['fktax_id']][$income['income_no']]['tax_amount'] += round($converted_amount,2);
				} else {
					$tax[$income['fktax_id']][$income['income_no']]['date']  	 = $income['date'];
					$tax[$income['fktax_id']][$income['income_no']]['amount']  	 = 0.00;
					$tax[$income['fktax_id']][$income['income_no']]['tax_amount']  = 0.00;
					$tax[$income['fktax_id']][$income['income_no']]['amount'] 	+= $base_amount;
					$tax[$income['fktax_id']][$income['income_no']]['tax_amount'] += round($converted_amount,2);
				}
			}

			foreach ($incomeAccountInvoice as $invoice) {

				$amount = $invoice['amount'];
				$tax_amount = $invoice['tax_amount'];
				if($invoice['transaction_currency']!='SGD') {
					$base_amount	  = $amount*$invoice['exchange_rate'];
					$converted_amount = $tax_amount*$invoice['exchange_rate'];
				} else {
					$base_amount      = $amount;
					$converted_amount = $tax_amount;
				}

				if(array_key_exists($invoice['invoice_no'], $tax[$invoice['fktax_id']])) {
					$tax[$invoice['fktax_id']][$invoice['invoice_no']]['amount'] 	+= $base_amount;
					$tax[$invoice['fktax_id']][$invoice['invoice_no']]['tax_amount'] += round($converted_amount,2);
				} else {
					$tax[$invoice['fktax_id']][$invoice['invoice_no']]['date']  	 = $invoice['date'];
					$tax[$invoice['fktax_id']][$invoice['invoice_no']]['amount']  	 = 0.00;
					$tax[$invoice['fktax_id']][$invoice['invoice_no']]['tax_amount']  = 0.00;
					$tax[$invoice['fktax_id']][$invoice['invoice_no']]['amount'] 	+= $base_amount;
					$tax[$invoice['fktax_id']][$invoice['invoice_no']]['tax_amount'] += round($converted_amount,2);
				}
			}


			foreach ($incomeAccountCredit as $credit) {

				$amount = $credit['amount'];
				$tax_amount = $credit['tax_amount'];
				if($credit['transaction_currency']!='SGD') {
					$base_amount	  = $amount*$credit['exchange_rate'];
					$converted_amount = $tax_amount*$credit['exchange_rate'];
				} else {
					$base_amount      = $amount;
					$converted_amount = $tax_amount;
				}

				if(array_key_exists($credit['credit_no'], $tax[$credit['fktax_id']])) {
					$tax[$credit['fktax_id']][$credit['credit_no']]['amount'] 	   -= $base_amount;
					$tax[$credit['fktax_id']][$credit['credit_no']]['tax_amount'] -= round($converted_amount,2);
				} else {
					$tax[$credit['fktax_id']][$credit['credit_no']]['date']  	= $credit['date'];
					$tax[$credit['fktax_id']][$credit['credit_no']]['amount']  	= 0.00;
					$tax[$credit['fktax_id']][$credit['credit_no']]['tax_amount']  = 0.00;
					$tax[$credit['fktax_id']][$credit['credit_no']]['amount'] 	   -= $base_amount;
					$tax[$credit['fktax_id']][$credit['credit_no']]['tax_amount'] -= round($converted_amount,2);
				}
			}


			foreach ($incomeAccountPay as $incomePay) {
				if($incomePay['pay_amount']!=0) {
					if($incomePay['tax_value']!=0) {
						$tax_pay = (($incomePay['pay_amount'] * $incomePay['tax_value']) / (100+$incomePay['tax_value']));
						$discount_amount = $incomePay['pay_amount'] - $tax_pay;
						$pay = 'PMT'.$incomePay['pid'];
						if(array_key_exists($pay, $tax[$incomePay['fktax_id']])) {
							$taxPayable[$incomePay['fktax_id']][$pay]['amount'] -= $discount_amount;
							$taxPayable[$incomePay['fktax_id']][$pay]['tax_amount'] -= round($tax_pay,2);
						} else {
							$tax[$incomePay['fktax_id']][$pay]['date'] 	   = $incomePay['date'];
							$tax[$incomePay['fktax_id']][$pay]['amount'] 	   = 0.00;
							$tax[$incomePay['fktax_id']][$pay]['tax_amount']  = 0.00;
							$tax[$incomePay['fktax_id']][$pay]['amount']     -= $discount_amount;
							$tax[$incomePay['fktax_id']][$pay]['tax_amount'] -= round($tax_pay,2);
						}
					}
				} 
			}

			foreach ($invoiceAccountPay as $invoicePay) {
				if($invoicePay['pay_amount']!=0) {
					if($invoicePay['tax_value']!=0) {
						$tax_pay = (($invoicePay['pay_amount'] * $invoicePay['tax_value']) / (100+$invoicePay['tax_value']));
						$discount_amount = $invoicePay['pay_amount'] - $tax_pay;
						$pay = 'PMT'.$incomePay['pid'];
						if(array_key_exists($pay, $tax[$invoicePay['fktax_id']])) {
							$tax[$invoicePay['fktax_id']][$pay]['amount'] -= $discount_amount;
							$tax[$invoicePay['fktax_id']][$pay]['tax_amount'] -= round($tax_pay,2);
						} else {
							$tax[$invoicePay['fktax_id']][$pay]['date'] 	   = $invoicePay['date'];
							$tax[$invoicePay['fktax_id']][$pay]['amount'] 	   = 0.00;
							$tax[$invoicePay['fktax_id']][$pay]['tax_amount']  = 0.00;
							$tax[$invoicePay['fktax_id']][$pay]['amount']     -= $discount_amount;
							$tax[$invoicePay['fktax_id']][$pay]['tax_amount'] -= round($tax_pay,2);
						}
					}
				} 
			}

			} else if($sales==2) {

				foreach ($this->taxes as $taxes) {
                    if($taxes['id']==$tid) {
                      foreach ($this->purchase as $keys => $purchase) {
                        if($taxes['tax_code']==$keys) {
                          $code = $purchase['name']." - ".$taxes['tax_percentage'];
                        }
                      }
                    }
                }

                $tax[$tid] = array();

				$expenseAccount    = $this->report->getExpenseAccountExpensePartTax($from,$to,$tid);
				$expenseAccountPay = $this->report->getExpenseAccountExpensesPartPay($from,$to,$tid);

		foreach ($expenseAccount as $expense) {
				$amount = $expense['amount'];
				$tax_amount = $expense['tax_amount'];
				if($expense['transaction_currency']!='SGD') {
					$base_amount	  = $amount*$expense['exchange_rate'];
					if($expense['total_gst']!=0.00) {
						$converted_amount = $expense['total_gst'];
					} else {
						$converted_amount = $tax_amount*$expense['exchange_rate'];
					}
				} else {
					$base_amount	  = $amount;
					$converted_amount = $tax_amount;
				}

				if(array_key_exists($expense['expense_no'], $tax[$expense['fktax_id']])) {
					$tax[$expense['fktax_id']][$expense['expense_no']]['amount'] 	+= $base_amount;
					$tax[$expense['fktax_id']][$expense['expense_no']]['tax_amount'] += round($converted_amount,2);
				} else {
					$tax[$expense['fktax_id']][$expense['expense_no']]['date']  	 = $expense['date'];
					$tax[$expense['fktax_id']][$expense['expense_no']]['amount']  	 = 0.00;
					$tax[$expense['fktax_id']][$expense['expense_no']]['tax_amount']  = 0.00;
					$tax[$expense['fktax_id']][$expense['expense_no']]['amount'] 	+= $base_amount;
					$tax[$expense['fktax_id']][$expense['expense_no']]['tax_amount'] += round($converted_amount,2);
				}
			}



			foreach ($expenseAccountPay as $expensePay) {
				if($expensePay['pay_amount']!=0) {
					if($expensePay['tax_value']!=0) {
						$tax_pay = (($expensePay['pay_amount'] * $expensePay['tax_value']) / (100+$expensePay['tax_value']));
						$discount_amount = $expensePay['pay_amount'] - $tax_pay;
						$pay = 'PMT'.$incomePay['pid'];
						if(array_key_exists($pay, $tax[$expensePay['fktax_id']])) {
							$tax[$expensePay['fktax_id']][$pay]['amount'] -= $discount_amount;
							$tax[$expensePay['fktax_id']][$pay]['tax_amount'] -= round($tax_pay,2);
						} else {
							$tax[$expensePay['fktax_id']][$pay]['date'] 	   = $expensePay['date'];
							$tax[$expensePay['fktax_id']][$pay]['amount'] 	   = 0.00;
							$tax[$expensePay['fktax_id']][$pay]['tax_amount']  = 0.00;
							$tax[$expensePay['fktax_id']][$pay]['amount']     -= $discount_amount;
							$tax[$expensePay['fktax_id']][$pay]['tax_amount'] -= round($tax_pay,2);
						}
					}
				} 
			}

			}

//			echo '<pre>'; print_r($expenseAccount); echo '</pre>';

			

			//echo round($taxPayable[1]['tax_amount'],2);
			$this->view->code   = $code;
			$this->view->tax    = $tax;
		} else {
			$this->_redirect('sales-tax');
		}

/*			$incomeAccount = $this->report->getIncomeAccountIncomes($from,$to);
			$incomeAccountInvoice = $this->report->getIncomeAccountInvoice($from,$to);
			$incomeAccountCredit  = $this->report->getIncomeAccountCredit($from,$to);
			$expenseAccount  = $this->report->getExpenseAccountExpenses($from,$to);*/


		}
	}

	public function incomeByCustomerAction() {
		if(!Zend_Session::namespaceIsset('sess_login')) {
			 $this->_redirect('index');
		} else {
			$customers = array();
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
				$from 		  = $current_year;
			$to = date('Y-m-d');
			if($this->_request->isPost()) {
				$postArray  = $this->getRequest()->getPost();
				$from = date('Y-m-d',strtotime($postArray['from_date']));
				$to = date('Y-m-d',strtotime($postArray['to_date']));
			}
			$this->view->from = date('d-m-Y',strtotime($from));
			$this->view->to   = date('d-m-Y',strtotime($to));

			$incomeAccountCustomer 		  = $this->report->getIncomeAccountIncomesCustomer($from,$to);
			$incomeAccountInvoiceCustomer = $this->report->getIncomeAccountInvoiceCustomer($from,$to);
			$incomeAccountCreditCustomer  = $this->report->getIncomeAccountCreditCustomer($from,$to);
			$this->view->customerList  	  = $this->business->getCustomers();

			if(isset($incomeAccountCustomer) && !empty($incomeAccountCustomer)) {
				foreach ($incomeAccountCustomer as $income) {
					$tax_amount = ($income['amount'] * $income['tax_value'] / 100);
					$total_income = $income['amount'];
					//echo $total_income."<br/>";
					if($income['transaction_currency']!='SGD') {
						$converted_amount = $total_income*$income['exchange_rate'];
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
					$amount = ($invoice['unit_price'] * $invoice['quantity']);
					$tax_amount = ($amount * $invoice['tax_value'] / 100);
					$total_income = $amount;
					if($invoice['transaction_currency']!='SGD') {
						$converted_amount = $total_income*$invoice['exchange_rate'];
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
					$total_income = $amount;
					if($credit['transaction_currency']!='SGD') {
						$converted_amount = $total_income*$credit['exchange_rate'];
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


	public function incomecustomerCoaAction() {
		if(!Zend_Session::namespaceIsset('sess_login')) {
			 $this->_redirect('index');
		} else {
			
			$logSession = new Zend_Session_Namespace('sess_login');
		    if(isset($logSession->proxy_cid) && !empty($logSession->proxy_cid)) {
		        $id = $logSession->proxy_cid;
			    $this->json    =  "..".$this->uploadPath.$logSession->proxy_cid."/accounts.json";
		    } else {
			    $id = $logSession->cid;
			    $this->json    =  "..".$this->uploadPath.$logSession->cid."/accounts.json";
			}


			$cid     = base64_decode($this->_getParam('customer'));
			$from    = $this->_getParam('from');
			$to      = $this->_getParam('to');
			if(isset($cid) && isset($from) && isset($to) && !empty($cid) && !empty($from) && !empty($to)) {

			$this->view->from    = $this->_getParam('from');
			$this->view->to      = $this->_getParam('to');

			$from = date('Y-m-d',strtotime($this->_getParam('from')));
			$to   = date('Y-m-d',strtotime($this->_getParam('to')));

			$incomeAccountCustomer 		  = $this->report->getIncomeAccountIncomesCustomerCoa($from,$to,$cid);
			$incomeAccountInvoiceCustomer = $this->report->getIncomeAccountInvoiceCustomerCoa($from,$to,$cid);
			$incomeAccountCreditCustomer  = $this->report->getIncomeAccountCreditCustomerCoa($from,$to,$cid);
			$this->view->customer  	      = $this->business->getCustomerName($cid);

			$coa 	  = array();
			$incomes  = array();
			$phpNative = Zend_Json::decode(file_get_contents($this->json));
			foreach ($phpNative as  $key => $value) {
				if($key=='Income') {
		      		foreach ($value as $keys => $values) {
		      				foreach ($values as $key1 => $value1) {
		      					foreach ($value1 as $key2 => $value2) {
		      						$incomes[$keys][$key1][$key2] = $value2;
		      					}
		      				}
		      		}
		      	 } 
			}

			if(isset($incomeAccountCustomer) && !empty($incomeAccountCustomer)) {
				foreach ($incomeAccountCustomer as $income) {
					$tax_amount = ($income['amount'] * $income['tax_value'] / 100);
					$total_income = $income['amount'];
					//echo $total_income."<br/>";
					if($income['transaction_currency']!='SGD') {
						$converted_amount = $total_income*$income['exchange_rate'];
						//echo $converted_amount;
					} else {
						$converted_amount = $total_income;
					}
					if(isset($coa[$income['aid']])) {
						$coa[$income['aid']]['amount'] += $converted_amount;
					} else {
						$coa[$income['aid']]['type']    = $income['account_type'];
						$coa[$income['aid']]['level1']  = $income['level1'];
						$coa[$income['aid']]['level2']  = $income['level2'];
						$coa[$income['aid']]['name']    = $income['account_name'];
						$coa[$income['aid']]['amount']  = 0.00;
						$coa[$income['aid']]['amount'] += $converted_amount;
					}
				}
			}

			if(isset($incomeAccountInvoiceCustomer) && !empty($incomeAccountInvoiceCustomer)) {
				foreach ($incomeAccountInvoiceCustomer as $invoice) {
					$amount = ($invoice['unit_price'] * $invoice['quantity']);
					$tax_amount = ($amount * $invoice['tax_value'] / 100);
					$total_income = $amount;
					if($invoice['transaction_currency']!='SGD') {
						$converted_amount = $total_income*$invoice['exchange_rate'];
						//echo $converted_amount;
					} else {
						$converted_amount = $total_income;
					}
					if(isset($coa[$invoice['aid']])) {
						$coa[$invoice['aid']]['amount'] += $converted_amount;
					} else {
						$coa[$invoice['aid']]['type']    = $invoice['account_type'];
						$coa[$invoice['aid']]['level1']  = $invoice['level1'];
						$coa[$invoice['aid']]['level2']  = $invoice['level2'];
						$coa[$invoice['aid']]['name']    = $invoice['account_name'];
						$coa[$invoice['aid']]['amount']  = 0.00;
						$coa[$invoice['aid']]['amount'] += $converted_amount;
					}
				}
			}

			if(isset($incomeAccountCreditCustomer) && !empty($incomeAccountCreditCustomer)) {
				foreach ($incomeAccountCreditCustomer as $credit) {
					$amount = ($credit['unit_price'] * $credit['quantity']);
					$tax_amount = ($amount * $credit['tax_value'] / 100);
					$total_income = $amount;
					if($credit['transaction_currency']!='SGD') {
						$converted_amount = $total_income*$credit['exchange_rate'];
						//echo $converted_amount;
					} else {
						$converted_amount = $total_income;
					}
					if(isset($coa[$credit['aid']])) {
						$coa[$credit['aid']]['amount'] += $converted_amount;
					} else {
						$coa[$credit['aid']]['type']    = $credit['account_type'];
						$coa[$credit['aid']]['level1']  = $credit['level1'];
						$coa[$credit['aid']]['level2']  = $credit['level2'];
						$coa[$credit['aid']]['name']    = $credit['account_name'];
						$coa[$credit['aid']]['amount']  = 0.00;
						$coa[$credit['aid']]['amount'] += $converted_amount;
					}
				}
			}
			$this->view->income    = $incomes;
			$this->view->coa 	   = $coa;
			//echo '<pre>'; print_r($incomeAccountCustomer); echo '</pre>';
			//echo '<pre>'; print_r($incomeAccountInvoiceCustomer); echo '</pre>';
			//echo '<pre>'; print_r($incomeAccountCreditCustomer); echo '</pre>';
			//echo '<pre>'; print_r($this->view->income); echo '</pre>';
			} else {
				$this->_redirect('reports/index/income-by-customer');
			}
		}
	}

	public function expenseByVendorAction() {
		if(!Zend_Session::namespaceIsset('sess_login')) {
			 $this->_redirect('index');
		} else {
			$vendors = array();
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
				$from 		  = $current_year;
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
					$total_income = $amount;
					if($expense['transaction_currency']!='SGD') {
						$converted_amount = $total_income*$expense['exchange_rate'];
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


	public function expensevendorCoaAction() {
		if(!Zend_Session::namespaceIsset('sess_login')) {
			 $this->_redirect('index');
		} else {
			
			$logSession = new Zend_Session_Namespace('sess_login');
		    if(isset($logSession->proxy_cid) && !empty($logSession->proxy_cid)) {
		        $id = $logSession->proxy_cid;
			    $this->json    =  "..".$this->uploadPath.$logSession->proxy_cid."/accounts.json";
		    } else {
			    $id = $logSession->cid;
			    $this->json    =  "..".$this->uploadPath.$logSession->cid."/accounts.json";
			}


			$vid     = base64_decode($this->_getParam('vendor'));
			$from    = $this->_getParam('from');
			$to      = $this->_getParam('to');
			if(isset($vid) && isset($from) && isset($to) && !empty($vid) && !empty($from) && !empty($to)) {

			$this->view->from    = $this->_getParam('from');
			$this->view->to      = $this->_getParam('to');

			$from = date('Y-m-d',strtotime($this->_getParam('from')));
			$to   = date('Y-m-d',strtotime($this->_getParam('to')));

			$expenseAccountVendor  = $this->report->getExpenseAccountExpensesVendorCoa($from,$to,$vid);
			$this->view->vendor    = $this->business->getVendorName($vid);

			$coa 	   = array();
			$assets    = array();
			$expenses  = array();
			$phpNative = Zend_Json::decode(file_get_contents($this->json));
			foreach ($phpNative as  $key => $value) {
				if($key=='Assets') {
		      		foreach ($value as $keys => $values) {
		      				foreach ($values as $key1 => $value1) {
		      					foreach ($value1 as $key2 => $value2) {
		      						$assets[$keys][$key1][$key2] = $value2;
		      					}
		      				}
		      		}
		      	 } 
				if($key=='Expense') {
		      		foreach ($value as $keys => $values) {
		      				foreach ($values as $key1 => $value1) {
		      					foreach ($value1 as $key2 => $value2) {
		      						$expenses[$keys][$key1][$key2] = $value2;
		      					}
		      				}
		      		}
		      	 } 
			}

			if(isset($expenseAccountVendor) && !empty($expenseAccountVendor)) {
				foreach ($expenseAccountVendor as $expense) {
					$amount = ($expense['unit_price'] * $expense['quantity']);
					$tax_amount = ($amount * $expense['tax_value'] / 100);
					$total_income = $amount;
					if($expense['transaction_currency']!='SGD') {
						$converted_amount = $total_income*$expense['exchange_rate'];
						//echo $converted_amount;
					} else {
						$converted_amount = $total_income;
					}
					if(isset($coa[$expense['aid']])) {
						$coa[$expense['aid']]['amount'] += $converted_amount;
					} else {
						$coa[$expense['aid']]['type']     = $expense['account_type'];
						$coa[$expense['aid']]['level1']   = $expense['level1'];
						$coa[$expense['aid']]['level2']   = $expense['level2'];
						$coa[$expense['aid']]['name']     = $expense['account_name'];
						$coa[$expense['aid']]['amount']   = 0.00;
						$coa[$expense['aid']]['amount']  += $converted_amount;
					}
				}
			}

			$this->view->assets   = $assets;
			$this->view->expense   = $expenses;
			$this->view->coa 	   = $coa;
			//echo '<pre>'; print_r($incomeAccountCustomer); echo '</pre>';
			//echo '<pre>'; print_r($incomeAccountInvoiceCustomer); echo '</pre>';
			//echo '<pre>'; print_r($incomeAccountCreditCustomer); echo '</pre>';
			//echo '<pre>'; print_r($this->view->coa); echo '</pre>';
			} else {
				$this->_redirect('reports/index/expense-by-vendor');
			}
		}
	}

	public function accountReceivablesAction() {
		if(!Zend_Session::namespaceIsset('sess_login')) {
			 $this->_redirect('index');
		} else {
			$incomeReceivable = array();
			//$from = date('Y-m-d');
			$to = date('Y-m-d');
			if($this->_request->isPost()) {
				$postArray  = $this->getRequest()->getPost();
				//$from = date('Y-m-d',strtotime($postArray['from_date']));
				$to = date('Y-m-d',strtotime($postArray['to_date']));
			}
			//$this->view->from = date('d-m-Y',strtotime($from));
			$this->view->to = date('d-m-Y',strtotime($to));
			$getAccountArray            =  $this->accountData->getData(array('creditTermArray'));
			$this->view->creditTerm     =  $getAccountArray['creditTermArray'];
			$this->view->customers      =  $this->business->getCustomerName();
			$incomeAccountReceivable 	=  $this->report->getIncomeAccountReceivables($to);
			$incomeAccountCash 			=  $this->report->getIncomeAccountCash($to);
			$incomeAccountInvoiceReceivable = $this->report->getIncomeAccountInvoiceReceivables($to);
			$incomeAccountInvoiceCash = $this->report->getIncomeAccountInvoiceCash($to);
			$incomeAccountCreditReceivable = $this->report->getIncomeAccountCreditReceivables($to);

			//echo '<pre>'; print_r($incomeAccountCreditReceivable); echo '</pre>';

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
					$totalAmount = $incomeReceivable[$incomeCreditCash['fkcustomer_id']][$incomeCreditCash['invoice_no']]['amount'] - $incomeReceivable[$incomeCreditCash['fkcustomer_id']][$incomeCreditCash['invoice_no']]['paid'];
					/*if($incomeReceivable[$incomeInvoiceCash['fkcustomer_id']][$incomeInvoiceCash['invoice_no']]['currency']!='SGD') {
						$converted_amount = $this->convertCurrency($totalAmount,$incomeReceivable[$incomeInvoiceCash['fkcustomer_id']][$incomeInvoiceCash['invoice_no']]['currency']);
					} else {
						$converted_amount = $totalAmount;
					}*/
					$incomeReceivable[$incomeCreditCash['fkcustomer_id']][$incomeCreditCash['invoice_no']]['pending']  = $totalAmount;
				}
			}

			$this->view->accountReceivables = $incomeReceivable;
			
			//echo '<pre>'; print_r($incomeAccountInvoiceReceivable); echo '</pre>';
			//echo '<pre>'; print_r($incomeAccountCash); echo '</pre>';
			//echo '<pre>'; print_r($incomeAccountInvoiceReceivable); echo '</pre>';
			//echo '<pre>'; print_r($incomeAccountInvoiceCash); echo '</pre>';
			//echo '<pre>'; print_r($incomeReceivable); echo '</pre>';
		}
	}

	public function outstandingInvoicesAction() {
		if(!Zend_Session::namespaceIsset('sess_login')) {
			 $this->_redirect('index');
		} else {
			$logSession = new Zend_Session_Namespace('sess_login');
			if(isset($logSession->proxy_cid) && !empty($logSession->proxy_cid)) {
			$cid = $logSession->proxy_cid;
			} else {
				$cid = $logSession->cid;
			}
			$cid     = base64_decode($this->_getParam('customer'));
			$date    = $this->_getParam('date');
			if(isset($cid) && isset($date) && !empty($cid) && !empty($date)) {
				$this->view->date       	=  $this->_getParam('date');
				$to       					=  date('Y-m-d',strtotime($this->view->date));
				$getAccountArray            =  $this->accountData->getData(array('creditTermArray'));
				$this->view->creditTerm     =  $getAccountArray['creditTermArray'];
				$this->view->customer       =  $this->business->getCustomerName($cid);
				$incomeAccountReceivable 	=  $this->report->getIncomeAccountReceivablesOutstanding($to,$cid);
				$incomeAccountCash 			=  $this->report->getIncomeAccountCashOutstanding($to,$cid);
				$incomeAccountInvoiceReceivable = $this->report->getIncomeAccountInvoiceReceivablesOutstanding($to,$cid);
				$incomeAccountInvoiceCash = $this->report->getIncomeAccountInvoiceCashOutstanding($to,$cid);
				$incomeAccountCreditReceivable = $this->report->getIncomeAccountCreditReceivablesOutstanding($to,$cid);

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
						$incomeReceivable[$incomeReceive['fkcustomer_id']][$incomeReceive['income_no']] = array('no' => $incomeReceive['income_no'],'due_date' => $due_date,'amount' => $converted_pending_amount,'currency' => $incomeReceive['transaction_currency'],'paid' => '0.00','pending' => $converted_pending_amount);
				}

				foreach ($incomeAccountCash as $incomeCash) {
					if(array_key_exists($incomeCash['fkcustomer_id'], $incomeReceivable) && array_key_exists($incomeCash['income_no'], $incomeReceivable[$incomeCash['fkcustomer_id']])) {
						$incomeReceivable[$incomeCash['fkcustomer_id']][$incomeCash['income_no']]['paid'] += $incomeCash['pay_amount'];
						$totalAmount = $incomeReceivable[$incomeCash['fkcustomer_id']][$incomeCash['income_no']]['amount'] - $incomeReceivable[$incomeCash['fkcustomer_id']][$incomeCash['income_no']]['paid'];
						/*if($incomeReceivable[$incomeCash['fkcustomer_id']][$incomeCash['income_no']]['currency']!='SGD') {
							$converted_amount = $this->convertCurrency($totalAmount,$incomeReceivable[$incomeCash[$incomeCash['fkcustomer_id']]['income_no']]['currency']);
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
					$incomeReceivable[$incomeInvoiceReceive['fkcustomer_id']][$incomeInvoiceReceive['invoice_no']] = array('no' => $incomeInvoiceReceive['invoice_no'],'due_date' => $incomeInvoiceReceive['inv_date'],'amount' => $converted_pending_amount,'currency' => $incomeInvoiceReceive['transaction_currency'],'paid' => '0.00','pending' => $converted_pending_amount);
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
					$totalAmount = $incomeReceivable[$incomeCreditCash['fkcustomer_id']][$incomeCreditCash['invoice_no']]['amount'] - $incomeReceivable[$incomeCreditCash['fkcustomer_id']][$incomeCreditCash['invoice_no']]['paid'];
					/*if($incomeReceivable[$incomeInvoiceCash['fkcustomer_id']][$incomeInvoiceCash['invoice_no']]['currency']!='SGD') {
						$converted_amount = $this->convertCurrency($totalAmount,$incomeReceivable[$incomeInvoiceCash['fkcustomer_id']][$incomeInvoiceCash['invoice_no']]['currency']);
					} else {
						$converted_amount = $totalAmount;
					}*/
					$incomeReceivable[$incomeCreditCash['fkcustomer_id']][$incomeCreditCash['invoice_no']]['pending']  = $totalAmount;
				}
			}

				foreach ($incomeReceivable as $key => $receivable) {
					usort($incomeReceivable[$key], $this->make_comparer('due_date'));
				}

				$this->view->accountReceivables = $incomeReceivable;
				//echo '<pre>'; print_r($incomeAccountReceivable); echo '</pre>';
				//echo '<pre>'; print_r($incomeAccountCash); echo '</pre>';
				//echo '<pre>'; print_r($incomeAccountInvoiceReceivable); echo '</pre>';
				//echo '<pre>'; print_r($incomeAccountInvoiceCash); echo '</pre>';
				//echo '<pre>'; print_r($incomeReceivable); echo '</pre>';
			} else {
				$this->_redirect('reports/index/account-receiveables');
			}
		}
	}

	public function accountPayablesAction() {
		if(!Zend_Session::namespaceIsset('sess_login')) {
			 $this->_redirect('index');
		} else {
			$expensePayable = array();
			//$from = date('Y-m-d');
			$to = date('Y-m-d');
			if($this->_request->isPost()) {
				$postArray  = $this->getRequest()->getPost();
				//$from = date('Y-m-d',strtotime($postArray['from_date']));
				$to = date('Y-m-d',strtotime($postArray['to_date']));
			}
			//$this->view->from = date('d-m-Y',strtotime($from));
			$this->view->to = date('d-m-Y',strtotime($to));
			$getAccountArray            =  $this->accountData->getData(array('creditTermArray'));
			$this->view->creditTerm     =  $getAccountArray['creditTermArray'];
			$this->view->vendors        =  $this->business->getVendorName();
			$expenseAccountPayable = $this->report->getExpenseAccountPayables($to);
			$expenseAccountCash    = $this->report->getExpenseAccountCash($to);
     		
			foreach ($expenseAccountPayable as $expensePay) {
					if($expensePay['transaction_currency']!='SGD') {
						if($expensePay['total_gst']!=0.00) {
							$converted_pending_amount = ($expensePay['amount']*$expensePay['exchange_rate'])+$expensePay['total_gst'];
						} else {
							$converted_pending_amount = $expensePay['amount']*$expensePay['exchange_rate'];
						}
						
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


			$this->view->accountPayables = $expensePayable;
			
			/*echo '<pre>'; print_r($expenseAccountPayable); echo '</pre>';
			echo '<pre>'; print_r($expenseAccountCash); echo '</pre>';
			echo '<pre>'; print_r($expensePayable); echo '</pre>';*/
		}
	}

	public function outstandingBillsAction() {
		if(!Zend_Session::namespaceIsset('sess_login')) {
			 $this->_redirect('index');
		} else {
			$logSession = new Zend_Session_Namespace('sess_login');
			if(isset($logSession->proxy_cid) && !empty($logSession->proxy_cid)) {
			$cid = $logSession->proxy_cid;
			} else {
				$cid = $logSession->cid;
			}
			$vid     = base64_decode($this->_getParam('vendor'));
			$date    = $this->_getParam('date');
			if(isset($vid) && isset($date) && !empty($vid) && !empty($date)) {
				$this->view->date       	=  $this->_getParam('date');
				$to       					=  date('Y-m-d',strtotime($this->view->date));
				$getAccountArray            =  $this->accountData->getData(array('creditTermArray'));
				$this->view->creditTerm     =  $getAccountArray['creditTermArray'];
				$this->view->vendor         =  $this->business->getVendorName($vid);
				$expenseAccountPayable = $this->report->getExpenseAccountPayablesOutstanding($to,$vid);
			    $expenseAccountCash    = $this->report->getExpenseAccountCashOutstanding($to,$vid);
     		
			foreach ($expenseAccountPayable as $expensePay) {
					if($expensePay['transaction_currency']!='SGD') {
						if($expensePay['total_gst']!=0.00) {
							$converted_pending_amount = ($expensePay['amount']*$expensePay['exchange_rate'])+$expensePay['total_gst'];
						} else {
							$converted_pending_amount = $expensePay['amount']*$expensePay['exchange_rate'];
						}
					} else {
						$converted_pending_amount = $expensePay['amount'];
					}
					$expensePayable[$expensePay['fkvendor_id']][$expensePay['expense_no']] = array('no' => $expensePay['expense_no'],'due_date' => $expensePay['exp_date'],'amount' => $converted_pending_amount,'currency' => $expensePay['transaction_currency'],'paid' => '0.00','pending' => $converted_pending_amount);
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

			foreach ($expensePayable as $key => $payable) {
				usort($expensePayable[$key], $this->make_comparer('due_date'));
			}

			$this->view->accountPayables = $expensePayable;
				/*echo '<pre>'; print_r($expenseAccountPayable); echo '</pre>';
				echo '<pre>'; print_r($expenseAccountCash); echo '</pre>';
				echo '<pre>'; print_r($expensePayable); echo '</pre>';*/
			} else {
				$this->_redirect('reports/index/account-receiveables');
			}
		}
	}

	public function cashflowCopyAction() {
		if(!Zend_Session::namespaceIsset('sess_login')) {
			 $this->_redirect('index');
		} else {
			$cashInflow = array();
			$cashOutflow = array();
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
				$from 		  = $current_year;
			$to = date('Y-m-d');
			if($this->_request->isPost()) {
				$postArray  = $this->getRequest()->getPost();
				$from = date('Y-m-d',strtotime($postArray['from_date']));
				$to = date('Y-m-d',strtotime($postArray['to_date']));
			}
			$this->view->from = date('d-m-Y',strtotime($from));
			$this->view->to = date('d-m-Y',strtotime($to));

			$incomeCash 				=  $this->report->getCashFlowIncome($from,$to);
			$invoiceCash 				=  $this->report->getCashFlowInvoice($from,$to);
			$expenseCash 				=  $this->report->getCashFlowExpense($from,$to);
			
			foreach ($incomeCash as $income) {
				if(array_key_exists($income['acc_id'], $cashInflow)) {
					$cashInflow[$income['acc_id']]['amount'] += $income['payment_amount'];
				} else {
					$cashInflow[$income['acc_id']]['name']   = $income['account_name'];
					$cashInflow[$income['acc_id']]['amount'] = $income['payment_amount'];
				}
			}

			foreach ($invoiceCash as $invoice) {
				if(array_key_exists($invoice['acc_id'], $cashInflow)) {
					$cashInflow[$invoice['acc_id']]['amount'] += $invoice['payment_amount'];
				} else {
					$cashInflow[$invoice['acc_id']]['name']   = $invoice['account_name'];
					$cashInflow[$invoice['acc_id']]['amount'] = $invoice['payment_amount'];
				}
			}

			foreach ($expenseCash as $expense) {
				if(array_key_exists($expense['acc_id'], $cashOutflow)) {
					$cashOutflow[$expense['acc_id']]['amount'] += $expense['payment_amount'];
				} else {
					$cashOutflow[$expense['acc_id']]['name']   = $expense['account_name'];
					$cashOutflow[$expense['acc_id']]['amount'] = $expense['payment_amount'];
				}
			}

			$this->view->cashInflow  = $cashInflow;
			$this->view->cashOutflow = $cashOutflow;

			//echo '<pre>'; print_r($cashInflow); echo '</pre>';
		}
	}

	public function cashflowAction() {
		if(!Zend_Session::namespaceIsset('sess_login')) {
			 $this->_redirect('index');
		} else {
			$cashInflow = array();
			$cashOutflow = array();
			$revenue     = array();
			$costOfGoods = array();
			$indirectIncome  = array();
			$indirectExpense = array();
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
				$from 		  = $current_year;
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

			$journal = array();
			$account = array();

			$incomeCash 				=  $this->report->getCashFlowIncome($from,$to);
			$incomeCashReceipt   		=  $this->report->getCashFlowIncomeReceipt($from,$to);
			$invoiceCash 				=  $this->report->getCashFlowInvoice($from,$to);
			$invoiceCashReceipt   		=  $this->report->getCashFlowInvoiceReceipt($from,$to);
			$expenseCash 				=  $this->report->getCashFlowExpense($from,$to);
			$expenseCashReceipt   		=  $this->report->getCashFlowExpenseReceipt($from,$to);
			$journalCash 				=  $this->report->getCashFlowJournal($from,$to);
			$journalFlow 				=  $this->report->getFlowJournal($from,$to);

			//echo '<pre>'; print_r($incomeCash); echo '</pre>';
			//echo '<pre>'; print_r($expenseCash); echo '</pre>';

			$account[11]['debit']   = 0.00;
			$account[11]['credit']  = 0.00;

			foreach ($incomeCash as $income) {
				if(isset($account[$income['coa_link']])) {
					$account[$income['coa_link']]['debit']  += $income['pay_amount'];
				} else {
					$account[$income['coa_link']]['debit']   = 0.00;
					$account[$income['coa_link']]['credit']  = 0.00;
					$account[$income['coa_link']]['debit']  += $income['pay_amount'];
				}
				/*if($income['discount_amount']!=0) {
					$tax_pay = (($income['discount_amount'] * $income['tax_value']) / (100+$income['tax_value']));
					$account[11]['debit']   += $tax_pay;
				}*/
			}

			foreach ($incomeCashReceipt as $inc) {
				$tax    = ($inc['amount'] * $inc['tax_value'] / 100);
				if($inc['transaction_currency']!='SGD') {
					$total_amount = $inc['amount']*$inc['exchange_rate'];
					$tax_amount   = $tax*$inc['exchange_rate'];
				} else {
					$total_amount = $inc['amount'];
					$tax_amount   = $tax;
				}
				$account[11]['debit']   += $tax_amount;
				if(isset($account[$inc['fkincome_type']])) {
					$account[$inc['fkincome_type']]['debit']  += $total_amount;
				} else {
					$account[$inc['fkincome_type']]['debit']   = 0.00;
					$account[$inc['fkincome_type']]['credit']  = 0.00;
					$account[$inc['fkincome_type']]['debit']  += $total_amount;
				}
			}


			foreach ($invoiceCash as $invoice) {
				if(isset($account[$invoice['coa_link']])) {
					$account[$invoice['coa_link']]['debit']  += $invoice['pay_amount'];
				} else {
					$account[$invoice['coa_link']]['debit']   = 0.00;
					$account[$invoice['coa_link']]['credit']  = 0.00;
					$account[$invoice['coa_link']]['debit']  += $invoice['pay_amount'];
				}
				/*if($invoice['discount_amount']!=0) {
					$tax_pay = (($invoice['discount_amount'] * $invoice['tax_value']) / (100+$invoice['tax_value']));
					$account[11]['debit']   += $tax_pay;
				}*/
			}

			foreach ($invoiceCashReceipt as $inv) {
				$amount = ($inv['unit_price']*$inv['quantity']) - $inv['discount_amount'];
				$tax    = ($amount * $inv['tax_value'] / 100);
				if($inv['transaction_currency']!='SGD') {
					$total_amount = $amount*$inv['exchange_rate'];
					$tax_amount   = $tax*$inv['exchange_rate'];
				} else {
					$total_amount = $amount;
					$tax_amount   = $tax;
				}
				$account[11]['debit']   += $tax_amount;
				if(isset($account[$inv['fkincomeaccount_id']])) {
					$account[$inv['fkincomeaccount_id']]['debit']  += $total_amount;
				} else {
					$account[$inv['fkincomeaccount_id']]['debit']   = 0.00;
					$account[$inv['fkincomeaccount_id']]['credit']  = 0.00;
					$account[$inv['fkincomeaccount_id']]['debit']  += $total_amount;
				}
			}

			foreach ($expenseCash as $expense) {
				if(isset($account[$expense['coa_link']])) {
					$account[$expense['coa_link']]['credit']  += $expense['pay_amount'];
				} else {
					$account[$expense['coa_link']]['debit']    = 0.00;
					$account[$expense['coa_link']]['credit']   = 0.00;
					$account[$expense['coa_link']]['credit']  += $expense['pay_amount'];
				}
				/*if($expense['discount_amount']!=0) {
					$tax_pay = (($expense['discount_amount'] * $expense['tax_value']) / (100+$expense['tax_value']));
					$account[11]['credit']   += $tax_pay;
				}*/
			}

			foreach ($expenseCashReceipt as $exp) {
				$amount = ($exp['unit_price']*$exp['quantity']);
				$tax    = ($amount * $exp['tax_value'] / 100);
				if($exp['transaction_currency']!='SGD') {
					$total_amount = $amount*$exp['exchange_rate'];
					$tax_amount   = $tax*$exp['exchange_rate'];
				} else {
					$total_amount = $amount;
					$tax_amount   = $tax;
				}
				$account[11]['credit']   += $tax_amount;
				if(isset($account[$exp['fkexpense_type']])) {
					$account[$exp['fkexpense_type']]['credit']  += $total_amount;
				} else {
					$account[$exp['fkexpense_type']]['debit']    = 0.00;
					$account[$exp['fkexpense_type']]['credit']   = 0.00;
					$account[$exp['fkexpense_type']]['credit']  += $total_amount;
				}
			}

			/*foreach ($incomeCash as $income) {
				if(isset($account[$income['coa_link']])) {
					$account[$income['coa_link']]['debit']  += $income['pay_amount'];
				} else {
					$account[$income['coa_link']]['debit']   = 0.00;
					$account[$income['coa_link']]['credit']  = 0.00;
					$account[$income['coa_link']]['debit']  += $income['pay_amount'];
				}
			}*/
			
			foreach ($journalCash as $journ) {
				$journal[$journ['jid']]['debit']  = $journ['debit'];
				$journal[$journ['jid']]['credit'] = $journ['credit'];
			}

			foreach ($journalFlow as $flow) {
				if(($flow['account_type']==1 && $flow['level1']==1 && $flow['level2']==1)) {
					
				} else {
					if(isset($journal[$flow['jid']])) {
						if(isset($account[$flow['fkaccount_id']])) {
							$account[$flow['fkaccount_id']]['debit']  += $flow['credit'];
							$account[$flow['fkaccount_id']]['credit'] += $flow['debit'];
						} else {
							$account[$flow['fkaccount_id']]['debit']  = 0.00;
							$account[$flow['fkaccount_id']]['credit'] = 0.00;
							$account[$flow['fkaccount_id']]['debit']  += $flow['credit'];
							$account[$flow['fkaccount_id']]['credit'] += $flow['debit'];
						}
					}
				}
			} 




			$incomeAccountIncome     = $this->report->getGeneralIncomeAccountForeign($from,$to);

			$incomeAccountInvoice    = $this->report->getGeneralInvoiceIncomeAccountForeign($from,$to);

			$expenseAccount  		 = $this->report->getGeneralExpenseAccountForeign($from,$to);

			$incomeAccountIncomePay  = $this->report->getGeneralIncomePayAccountForeign($from,$to);

			$incomeAccountInvoicePay = $this->report->getInvoicePayAccountsForeign($from,$to);

			$expenseAccountPay       = $this->report->getExpensePayAccountsForeign($from,$to);

			$incomeAccountCredit  	 = $this->report->getGeneralCreditAccountGl($from,$to);

			//echo '<pre>'; print_r($incomeAccountCredit); echo '</pre>';

			foreach ($incomeAccountIncome as $income) {
				if($income['credit_term']==1) {
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

			}

			foreach ($incomeAccountIncomePay as $incomePay) {
				if($incomePay['credit_term']==1) {
					$foreignCurrency[$incomePay['income_no']]['paid']    += $incomePay['amount'];
				}
			}


			foreach ($incomeAccountInvoice as $invoice) {
				if($invoice['credit_term']==1) {
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
						$foreignCurrency[$invoice['invoice_no']]['convert_amount'] = $credits;
					}
				}
			}


			foreach ($incomeAccountInvoicePay as $invoicePay) {
				if($invoicePay['credit_term']==1) {
					$foreignCurrency[$invoicePay['invoice_no']]['paid']    += $invoicePay['amount'];
				}
			}


			foreach ($expenseAccount as $expense) {
				if($expense['credit_term']==1) {
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
					
			}

				foreach ($expenseAccountPay as $expensePay) {
					if($expensePay['credit_term']==1) {
						$foreignCurrency[$expensePay['expense_no']]['paid']    += $expensePay['amount'];
					}
				}

				$account[2]['debit']    = 0.00;
				$account[2]['credit']   = 0.00;

				//echo '<pre>'; print_r($foreignCurrency); echo '</pre>';

				foreach ($foreignCurrency as $key => $exchange) {
					if($exchange['type']==1) {
                  		$amount = $exchange['convert_amount'] - $exchange['paid'];
                  		if($amount>0) {
                  			$account[2]['credit'] += $amount; 
                  		} else {
                  			$account[2]['debit']  += $amount;
                  		}
                  	} else if($exchange['type']==2) {  
                  		$amount = $exchange['convert_amount'] - $exchange['paid'];
                  		if($amount<0) {
                  			$account[2]['credit'] += $amount; 
                  		} else {
                  			$account[2]['debit']  += $amount;
                  		}
                  	}
				}







				$this->view->getAccount	=  $this->report->getAllAccounts();
				$this->view->cashFlow   =  $account; 
			//echo '<pre>'; print_r($this->view->cashFlow); echo '</pre>';
			/*$incomeCash 				=  $this->report->getCashFlowIncome($from,$to);
			$invoiceCash 				=  $this->report->getCashFlowInvoice($from,$to);
			$expenseCash 				=  $this->report->getCashFlowExpense($from,$to);
			$maxInvoice  				=  $this->report->getMaxInvoiceTransaction();
			$maxExpense  				=  $this->report->getMaxExpenseTransaction();
			$incomeCoa  				=  $this->transaction->getIncomeAccount();
			$expenseCoa 				=  $this->transaction->getExpenseAccount();


			
			foreach ($incomeCash as $income) {
				if(array_key_exists($income['fkincome_type'], $cashInflow)) {
					$cashInflow[$income['fkincome_type']]['amount'] += $income['payment_amount'];
				} else {
					$cashInflow[$income['fkincome_type']]['amount'] = $income['payment_amount'];
				}
			}

			foreach ($invoiceCash as $invoice) {
				foreach ($maxInvoice as $maxInv) {
					if($maxInv['fkinvoice_id']==$invoice['inv_id']) {
						$incomeId = $maxInv['fkincomeaccount_id'];
					}
				}
				if(isset($incomeId) && !empty($incomeId) && array_key_exists($incomeId, $cashInflow)) {
					$cashInflow[$incomeId]['amount'] += $invoice['payment_amount'];
				} else if(isset($incomeId) && !empty($incomeId)) {
					$cashInflow[$incomeId]['amount'] = $invoice['payment_amount'];
				}
			}

			foreach ($expenseCash as $expense) {
				foreach ($maxExpense as $maxExp) {
					if($maxExp['fkexpense_id']==$expense['exp_id']) {
						$expenseId = $maxExp['fkexpense_type'];
					}
				}
				if(isset($expenseId) && !empty($expenseId) && array_key_exists($expenseId, $cashOutflow)) {
					$cashOutflow[$expenseId]['amount'] += $expense['payment_amount'];
				} else if(isset($expenseId) && !empty($expenseId)) {
					$cashOutflow[$expenseId]['amount'] = $expense['payment_amount'];
				}
			}


			foreach ($cashInflow as $key => $inflow) {
				foreach ($incomeCoa as $inc) {
                    if($key==$inc['id']) {
                        if($inc['account_id']<=82) {
                        	$revenue[$key]['account_name']  = $inc['account_name'];
                        	$revenue[$key]['account_id']    = $inc['account_id'];
                        	$revenue[$key]['amount']  		= $inflow['amount']; 
                        } else if($inc['account_id']>82) {
                            $indirectIncome[$key]['account_name']  = $inc['account_name'];
                            $indirectIncome[$key]['account_id']    = $inc['account_id'];
                        	$indirectIncome[$key]['amount']  	   = $inflow['amount']; 
                        }
                    }
                } 
			}

			foreach ($cashOutflow as $key => $outflow) {
				foreach ($expenseCoa as $exp) {
                    if($key==$exp['id']) {
                        if($exp['account_id']<=30) {
                        	$costOfGoods[$key]['account_name']  = $exp['account_name'];
                        	$costOfGoods[$key]['account_id']    = $exp['account_id'];
                        	$costOfGoods[$key]['amount']  		= $outflow['amount']; 
                        } else if($exp['account_id']>30) {
                            $indirectExpense[$key]['account_name']  = $exp['account_name'];
                            $indirectExpense[$key]['account_id']    = $exp['account_id'];
                        	$indirectExpense[$key]['amount']  		= $outflow['amount']; 
                        }
                    }
                } 
			}

			$this->view->revenue  		 = $revenue;
			$this->view->indirectIncome  = $indirectIncome;
			$this->view->costOfGoods  	 = $costOfGoods;
			$this->view->indirectExpense = $indirectExpense;*/

			/*$this->view->cashInflow  = $cashInflow;
			$this->view->cashOutflow = $cashOutflow;

			echo '<pre>'; print_r($invoiceCash); echo '</pre>';
			echo '<pre>'; print_r($cashOutflow); echo '</pre>'; */
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

		      	$balanceSheet   = array();
				$accountId      = array();


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
				$from 		  = $current_year;
				//$from = date('Y-01-01');
				$to = date('Y-m-d');
				if($this->_request->isPost()) {
					$postArray  = $this->getRequest()->getPost();
					//$from = date('Y-m-d',strtotime($postArray['from_date']));
					$to = date('Y-m-d',strtotime($postArray['to_date']));
				}
				//$this->view->from = date('d-m-Y',strtotime($from));
				$this->view->to = date('d-m-Y',strtotime($to));


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

				//$this->view->getAccount	=  $this->settings->getAccounts();
				$incomes  = array();
				$invoices = array();
				$expenses = array();
				$incomesPay  = array();
				$expensesPay = array();
				$invoicesPay = array();
				$credits = array();

				$incomeAccountIncome     = $this->report->getGeneralIncomeAccount($from,$to);
				$incomeAccountIncomePay  = $this->report->getGeneralIncomePayAccount($from,$to);
				$incomeAccountInvoice    = $this->report->getGeneralInvoiceIncomeAccount($from,$to);
				$incomeAccountInvoicePay = $this->report->getInvoicePayAccounts($from,$to);
				$incomeAccountCredit     = $this->report->getGeneralCreditAccount($from,$to);
				$expenseAccount  		 = $this->report->getGeneralExpenseAccount($from,$to);
				$expenseAccountPay       = $this->report->getExpensePayAccounts($from,$to);
				$journalAccount  		 = $this->report->getGeneralJournalAccount($from,$to);
				$assetAccount  	    	 = $this->report->getGeneralAssetsExpenseAccount($from,$to);

				//echo '<pre>'; print_r($assetAccount); echo '</pre>';


				foreach ($incomeAccountIncome as $income) {
				
					    $tax_amount   = ($income['amount'] * $income['tax_value'] / 100);
						$total_income = $income['amount']+$tax_amount;	

						if($income['transaction_currency']!='SGD') {
							$converted_amount = $total_income*$income['exchange_rate'];
							if($tax_amount!=0) {
								$converted_tax    = $tax_amount*$income['exchange_rate'];
							} else {
								$converted_tax    = $tax_amount;
							}
						} else {
							$converted_amount = $total_income;
							$converted_tax    = $tax_amount;
						}
						$incomes[$income['income_no']]['amount'] = $converted_amount;
						$incomes[$income['income_no']]['tax_value'] = $income['tax_value'];
				if($income['credit_term']!=1) {
					if(array_key_exists($income['coa_link'], $balanceSheet)) {
						$balanceSheet[$income['coa_link']]['debit_amount'] += round($converted_amount,2);
					} else {
						$balanceSheet[$income['coa_link']]['debit_amount']  = 0.00;
						$balanceSheet[$income['coa_link']]['credit_amount'] = 0.00;
						$balanceSheet[$income['coa_link']]['debit_amount'] += round($converted_amount,2);
					}
				}

			    if(array_key_exists(11, $balanceSheet)) {
						$balanceSheet[11]['credit_amount'] += round($converted_tax,2);
					} else {
						$balanceSheet[11]['debit_amount']   = 0.00;
						$balanceSheet[11]['credit_amount']  = 0.00;
						$balanceSheet[11]['credit_amount'] += round($converted_tax,2);
					}
				}

				foreach ($incomeAccountIncomePay as $incomePay) {
					if(isset($incomes[$incomePay['income_no']]['tax_value']) && $incomes[$incomePay['income_no']]['tax_value']!=0) {
						if($incomePay['discount_amount']!=0) {
							$tax_pay = (($incomePay['discount_amount'] * $incomes[$incomePay['income_no']]['tax_value']) / (100+$incomes[$incomePay['income_no']]['tax_value']));
							if(array_key_exists(11, $balanceSheet)) {
								$balanceSheet[11]['debit_amount'] += round($tax_pay,2);
							} else {
								$balanceSheet[11]['debit_amount']   = 0.00;
								$balanceSheet[11]['credit_amount']  = 0.00;
								$balanceSheet[11]['debit_amount']  += round($tax_pay,2);
							}
						}
					}
					if($incomePay['credit_term']==1) {
						if(array_key_exists($incomePay['fkpayment_account'], $balanceSheet)) {
							$balanceSheet[$incomePay['fkpayment_account']]['debit_amount'] += $incomePay['payment_amount'];
						} else {
							$balanceSheet[$incomePay['fkpayment_account']]['debit_amount']   = 0.00;
							$balanceSheet[$incomePay['fkpayment_account']]['credit_amount']  = 0.00;
							$balanceSheet[$incomePay['fkpayment_account']]['debit_amount']  += $incomePay['payment_amount'];
						}
					} else {
						if(array_key_exists($incomePay['fkpayment_account'], $balanceSheet)) {
							$balanceSheet[$incomePay['fkpayment_account']]['debit_amount'] += $incomePay['payment_amount'];
						} else {
							$balanceSheet[$incomePay['fkpayment_account']]['debit_amount']   = 0.00;
							$balanceSheet[$incomePay['fkpayment_account']]['credit_amount']  = 0.00;
							$balanceSheet[$incomePay['fkpayment_account']]['debit_amount']  += $incomePay['payment_amount'];
						}
						if($incomePay['pay_status']==1 && ($incomePay['final_payment_date'] == $incomePay['pay_date'])) {
					    	$debit_amount = 0.00;
					    	if(isset($incomes[$incomePay['income_no']])) {
					    		$debit_amount = $incomes[$incomePay['income_no']]['amount'];
					    	}
					    	$credit_amount = 0.00;
					    	if(isset($incomesPay[$incomePay['income_no']])) {
					    		$credit_amount  = $incomesPay[$incomePay['income_no']]['amount'];
					    	}

					    	if($debit_amount==0 && $credit_amount==0) {

					    		if(array_key_exists($incomePay['coa_link'], $balanceSheet)) {
									$balanceSheet[$incomePay['coa_link']]['credit_amount'] += $incomePay['payment_amount'];
								} else {
									$balanceSheet[$incomePay['coa_link']]['debit_amount']   = 0.00;
									$balanceSheet[$incomePay['coa_link']]['credit_amount']  = 0.00;
									$balanceSheet[$incomePay['coa_link']]['credit_amount'] += $incomePay['payment_amount'];
								}

					    	} else {

						    	$total_amt = $debit_amount - $credit_amount;

								if(array_key_exists($incomePay['coa_link'], $balanceSheet)) {
									$balanceSheet[$incomePay['coa_link']]['credit_amount']  += $total_amt;
								} else {
									$balanceSheet[$incomePay['coa_link']]['debit_amount']   = 0.00;
									$balanceSheet[$incomePay['coa_link']]['credit_amount']  = 0.00;
									$balanceSheet[$incomePay['coa_link']]['credit_amount']  += $total_amt;
								}
							}
						} else {
						if(array_key_exists($incomePay['coa_link'], $balanceSheet)) {
							$balanceSheet[$incomePay['coa_link']]['credit_amount'] += $incomePay['payment_amount'];
						} else {
							$balanceSheet[$incomePay['coa_link']]['debit_amount']   = 0.00;
							$balanceSheet[$incomePay['coa_link']]['credit_amount']  = 0.00;
							$balanceSheet[$incomePay['coa_link']]['credit_amount'] += $incomePay['payment_amount'];
						}
						}

					}

					if(isset($incomesPay[$incomePay['income_no']])) {
						$incomesPay[$incomePay['income_no']]['amount'] +=  $incomePay['payment_amount'];
					} else {
						$incomesPay[$incomePay['income_no']]['amount']  =  $incomePay['payment_amount'];
					}


				}


				foreach ($incomeAccountInvoice as $invoice) {
				
					    $tax_amount   = $invoice['tax_amount'] ;
						$total_income = $invoice['amount']+$tax_amount;	

						if($invoice['transaction_currency']!='SGD') {
							$converted_amount = $total_income*$invoice['exchange_rate'];
							if($tax_amount!=0) {
								$converted_tax    = $tax_amount*$invoice['exchange_rate'];
							} else {
								$converted_tax    = $tax_amount;
							}
						} else {
							$converted_amount = $total_income;
							$converted_tax    = $tax_amount;
						}
						$invoices[$invoice['invoice_no']]['amount'] = $converted_amount;
						$invoices[$invoice['invoice_no']]['tax_value'] = $invoice['tax_value'];
				if($invoice['credit_term']!=1) {
					if(array_key_exists($invoice['coa_link'], $balanceSheet)) {
						$balanceSheet[$invoice['coa_link']]['debit_amount'] += round($converted_amount,2);
					} else {
						$balanceSheet[$invoice['coa_link']]['debit_amount']  = 0.00;
						$balanceSheet[$invoice['coa_link']]['credit_amount'] = 0.00;
						$balanceSheet[$invoice['coa_link']]['debit_amount'] += round($converted_amount,2);
					}
				}

			        if(array_key_exists(11, $balanceSheet)) {
						$balanceSheet[11]['credit_amount'] += round($converted_tax,2);
					} else {
						$balanceSheet[11]['debit_amount']   = 0.00;
						$balanceSheet[11]['credit_amount']  = 0.00;
						$balanceSheet[11]['credit_amount'] += round($converted_tax,2);
					}
				}

				foreach ($incomeAccountCredit as $credit) {
				
					    $tax_amount   = $credit['tax_amount'];
						$total_income = $credit['amount']+$tax_amount;	

						if($credit['transaction_currency']!='SGD') {
							$converted_amount = $total_income*$credit['exchange_rate'];
							if($tax_amount!=0) {
								$converted_tax    = $tax_amount*$credit['exchange_rate'];
							} else {
								$converted_tax    = $tax_amount;
							}
						} else {
							$converted_amount = $total_income;
							$converted_tax    = $tax_amount;
						}
						if(isset($credits[$credit['invoice_no']])) {
							$credits[$credit['invoice_no']]['amount'] += $converted_amount;
						} else {
							$credits[$credit['invoice_no']]['amount'] = $converted_amount;
						}
					if(array_key_exists($credit['coa_link'], $balanceSheet)) {
						$balanceSheet[$credit['coa_link']]['credit_amount'] += round($converted_amount,2);
					} else {
						$balanceSheet[$credit['coa_link']]['debit_amount']   = 0.00;
						$balanceSheet[$credit['coa_link']]['credit_amount']  = 0.00;
						$balanceSheet[$credit['coa_link']]['credit_amount'] += round($converted_amount,2);
					}

			        if(array_key_exists(11, $balanceSheet)) {
						$balanceSheet[11]['debit_amount']  += round($converted_tax,2);
					} else {
						$balanceSheet[11]['debit_amount']   = 0.00;
						$balanceSheet[11]['credit_amount']  = 0.00;
						$balanceSheet[11]['debit_amount']  += round($converted_tax,2);
					}
				}

				foreach ($incomeAccountInvoicePay as $invoicePay) {
					if(isset($invoices[$invoicePay['invoice_no']]['tax_value']) && $invoices[$invoicePay['invoice_no']]['tax_value']!=0) {
						if($invoicePay['discount_amount']!=0) {
							$tax_pay = (($invoicePay['discount_amount'] * $invoices[$invoicePay['invoice_no']]['tax_value']) / (100+$invoices[$invoicePay['invoice_no']]['tax_value']));
							if(array_key_exists(11, $balanceSheet)) {
								$balanceSheet[11]['debit_amount'] += round($tax_pay,2);
							} else {
								$balanceSheet[11]['debit_amount']   = 0.00;
								$balanceSheet[11]['credit_amount']  = 0.00;
								$balanceSheet[11]['debit_amount']  += round($tax_pay,2);
							}
						}
					}
					if($invoicePay['credit_term']==1) {
						if(array_key_exists($invoicePay['fkpayment_account'], $balanceSheet)) {
							$balanceSheet[$invoicePay['fkpayment_account']]['debit_amount'] += $invoicePay['payment_amount'];
						} else {
							$balanceSheet[$invoicePay['fkpayment_account']]['debit_amount']   = 0.00;
							$balanceSheet[$invoicePay['fkpayment_account']]['credit_amount']  = 0.00;
							$balanceSheet[$invoicePay['fkpayment_account']]['debit_amount']  += $invoicePay['payment_amount'];
						}
					} else {
						if(array_key_exists($invoicePay['fkpayment_account'], $balanceSheet)) {
							$balanceSheet[$invoicePay['fkpayment_account']]['debit_amount'] += $invoicePay['payment_amount'];
						} else {
							$balanceSheet[$invoicePay['fkpayment_account']]['debit_amount']   = 0.00;
							$balanceSheet[$invoicePay['fkpayment_account']]['credit_amount']  = 0.00;
							$balanceSheet[$invoicePay['fkpayment_account']]['debit_amount']  += $invoicePay['payment_amount'];
						}
						if($invoicePay['pay_status']==1 && ($invoicePay['final_payment_date'] == $invoicePay['pay_date'])) {
					    	$debit_amount = 0.00;
					    	if(isset($invoices[$invoicePay['invoice_no']])) {
					    		$debit_amount = $invoices[$invoicePay['invoice_no']]['amount'];
					    	}
					    	$credit_amount = 0.00;
					    	if(isset($credits[$invoicePay['invoice_no']])) {
					    		$credit_amount += $credits[$invoicePay['invoice_no']]['amount'];
					    	}
					    	if(isset($invoicesPay[$invoicePay['invoice_no']])) {
					    		$credit_amount  += $invoicesPay[$invoicePay['invoice_no']]['amount'];
					    	}

					    	if($debit_amount==0 && $credit_amount==0) {

					    		if(array_key_exists($invoicePay['coa_link'], $balanceSheet)) {
									$balanceSheet[$invoicePay['coa_link']]['credit_amount'] += $invoicePay['payment_amount'];
								} else {
									$balanceSheet[$invoicePay['coa_link']]['debit_amount']   = 0.00;
									$balanceSheet[$invoicePay['coa_link']]['credit_amount']  = 0.00;
									$balanceSheet[$invoicePay['coa_link']]['credit_amount'] += $invoicePay['payment_amount'];
								}

					    	} else {

						    	$total_amt = $debit_amount - $credit_amount;

								if(array_key_exists($invoicePay['coa_link'], $balanceSheet)) {
									$balanceSheet[$invoicePay['coa_link']]['credit_amount']  += $total_amt;
								} else {
									$balanceSheet[$invoicePay['coa_link']]['debit_amount']   = 0.00;
									$balanceSheet[$invoicePay['coa_link']]['credit_amount']  = 0.00;
									$balanceSheet[$invoicePay['coa_link']]['credit_amount']  += $total_amt;
								}
							}
						} else {
						if(array_key_exists($invoicePay['coa_link'], $balanceSheet)) {
							$balanceSheet[$invoicePay['coa_link']]['credit_amount'] += $invoicePay['payment_amount'];
						} else {
							$balanceSheet[$invoicePay['coa_link']]['debit_amount']   = 0.00;
							$balanceSheet[$invoicePay['coa_link']]['credit_amount']  = 0.00;
							$balanceSheet[$invoicePay['coa_link']]['credit_amount'] += $invoicePay['payment_amount'];
						}
						}

					}

					if(isset($invoicesPay[$invoicePay['invoice_no']])) {
						$invoicesPay[$invoicePay['invoice_no']]['amount'] +=  $invoicePay['payment_amount'];
					} else {
						$invoicesPay[$invoicePay['invoice_no']]['amount']  =  $invoicePay['payment_amount'];
					}
				}



				foreach ($assetAccount as $asset) {
				
						$total_asset = $asset['amount'];	
						

						if($asset['transaction_currency']!='SGD') {
							$converted_amount = $total_asset*$asset['exchange_rate'];
						} else {
							$converted_amount = $total_asset;
						}

				  if(array_key_exists($asset['fkexpense_type'], $balanceSheet)) {
						$balanceSheet[$asset['fkexpense_type']]['debit_amount']  += $converted_amount;
					} else {
						$balanceSheet[$asset['fkexpense_type']]['debit_amount']   = 0.00;
						$balanceSheet[$asset['fkexpense_type']]['credit_amount']  = 0.00;
						$balanceSheet[$asset['fkexpense_type']]['debit_amount']  += $converted_amount;
					}


				}



				foreach ($expenseAccount as $expense) {
				
						
						$total_expense = $expense['amount'];	
						$tax_amount    = $expense['tax_amount'];
						

						if($expense['transaction_currency']!='SGD') {
							if($expense['total_gst']!=0.00) {
								$converted_amount = ($total_expense*$expense['exchange_rate'])+$expense['total_gst'];
							} else {
						    	$converted_amount = ($total_expense+$tax_amount)*$expense['exchange_rate'];
						    }
							if($tax_amount!=0) {
								if($expense['total_gst']!=0.00) {
									$converted_tax    = $expense['total_gst'];
								} else {
									$converted_tax    = $tax_amount*$expense['exchange_rate'];
								}
							} else {
								$converted_tax    = $tax_amount;
							}
						} else {
							$converted_amount = $total_expense+$tax_amount;
							$converted_tax    = $tax_amount;
						}
						$expenses[$expense['expense_no']]['amount'] = $converted_amount;
						$expenses[$expense['expense_no']]['tax_value'] = $expense['tax_value'];
				if($expense['credit_term']!=1) {
					if(array_key_exists($expense['coa_link'], $balanceSheet)) {
						$balanceSheet[$expense['coa_link']]['credit_amount'] += round($converted_amount,2);
					} else {
						$balanceSheet[$expense['coa_link']]['debit_amount']   = 0.00;
						$balanceSheet[$expense['coa_link']]['credit_amount']  = 0.00;
						$balanceSheet[$expense['coa_link']]['credit_amount'] += round($converted_amount,2);
					}
				}

			        if(array_key_exists(11, $balanceSheet)) {
						$balanceSheet[11]['debit_amount']  += round($converted_tax,2);
					} else {
						$balanceSheet[11]['debit_amount']   = 0.00;
						$balanceSheet[11]['credit_amount']  = 0.00;
						$balanceSheet[11]['debit_amount']  += round($converted_tax,2);
					}
				}

				foreach ($expenseAccountPay as $expensePay) {

					if(isset($expenses[$expensePay['expense_no']]['tax_value']) && $expenses[$expensePay['expense_no']]['tax_value']!=0) {
						if($expensePay['discount_amount']!=0) {
							$tax_pay = (($expensePay['discount_amount'] * $expenses[$expensePay['expense_no']]['tax_value']) / (100+$expenses[$expensePay['expense_no']]['tax_value']));
							if(array_key_exists(11, $balanceSheet)) {
								$balanceSheet[11]['credit_amount'] += round($tax_pay,2);
							} else {
								$balanceSheet[11]['debit_amount']   = 0.00;
								$balanceSheet[11]['credit_amount']  = 0.00;
								$balanceSheet[11]['credit_amount']  += round($tax_pay,2);
							}
						}
					}
					
					if($expensePay['credit_term']==1) {
						if(array_key_exists($expensePay['fkpayment_account'], $balanceSheet)) {
							$balanceSheet[$expensePay['fkpayment_account']]['credit_amount']  += $expensePay['payment_amount'];
						} else {
							$balanceSheet[$expensePay['fkpayment_account']]['debit_amount']    = 0.00;
							$balanceSheet[$expensePay['fkpayment_account']]['credit_amount']   = 0.00;
							$balanceSheet[$expensePay['fkpayment_account']]['credit_amount']  += $expensePay['payment_amount'];
						}
					} else {
						if(array_key_exists($expensePay['fkpayment_account'], $balanceSheet)) {
							$balanceSheet[$expensePay['fkpayment_account']]['credit_amount']  += $expensePay['payment_amount'];
						} else {
							$balanceSheet[$expensePay['fkpayment_account']]['debit_amount']    = 0.00;
							$balanceSheet[$expensePay['fkpayment_account']]['credit_amount']   = 0.00;
							$balanceSheet[$expensePay['fkpayment_account']]['credit_amount']  += $expensePay['payment_amount'];
						}
					    if($expensePay['pay_status']==1 && ($expensePay['final_payment_date'] == $expensePay['pay_date'])) {
					    	$credit_amount = 0.00;
					    	if(isset($expenses[$expensePay['expense_no']])) {
					    		$credit_amount = $expenses[$expensePay['expense_no']]['amount'];
					    	}
					    	$debit_amount = 0.00;
					    	if(isset($expensesPay[$expensePay['expense_no']])) {
					    		$debit_amount  = $expensesPay[$expensePay['expense_no']]['amount'];
					    	}

					    	if($debit_amount==0 && $credit_amount==0) {

					    		if(array_key_exists($expensePay['coa_link'], $balanceSheet)) {
									$balanceSheet[$expensePay['coa_link']]['debit_amount']  += $expensePay['payment_amount'];
								} else {
									$balanceSheet[$expensePay['coa_link']]['debit_amount']   = 0.00;
									$balanceSheet[$expensePay['coa_link']]['credit_amount']  = 0.00;
									$balanceSheet[$expensePay['coa_link']]['debit_amount']  += $expensePay['payment_amount'];
								}

					    	} else {

						    	$total_amt = $credit_amount - $debit_amount;

								if(array_key_exists($expensePay['coa_link'], $balanceSheet)) {
									$balanceSheet[$expensePay['coa_link']]['debit_amount']  += $total_amt;
								} else {
									$balanceSheet[$expensePay['coa_link']]['debit_amount']   = 0.00;
									$balanceSheet[$expensePay['coa_link']]['credit_amount']  = 0.00;
									$balanceSheet[$expensePay['coa_link']]['debit_amount']  += $total_amt;
								}
							}
						} else {
							if(array_key_exists($expensePay['coa_link'], $balanceSheet)) {
								$balanceSheet[$expensePay['coa_link']]['debit_amount']  += $expensePay['payment_amount'];
							} else {
								$balanceSheet[$expensePay['coa_link']]['debit_amount']   = 0.00;
								$balanceSheet[$expensePay['coa_link']]['credit_amount']  = 0.00;
								$balanceSheet[$expensePay['coa_link']]['debit_amount']  += $expensePay['payment_amount'];
							}

						}

					}

					if(isset($expensesPay[$expensePay['expense_no']])) {
						$expensesPay[$expensePay['expense_no']]['amount'] +=  $expensePay['payment_amount'];
					} else {
						$expensesPay[$expensePay['expense_no']]['amount']  =  $expensePay['payment_amount'];
					}
					/*echo $balanceSheet[$expensePay['coa_link']]['debit_amount'].'<br/>';
					echo $balanceSheet[$expensePay['coa_link']]['credit_amount'].'<br/>';*/
				}

				foreach ($journalAccount as $journal) {

					if(array_key_exists($journal['fkaccount_id'], $balanceSheet)) {
						$balanceSheet[$journal['fkaccount_id']]['debit_amount']  += $journal['debit'];
						$balanceSheet[$journal['fkaccount_id']]['credit_amount'] += $journal['credit'];
					} else {
						$balanceSheet[$journal['fkaccount_id']]['debit_amount']   = 0.00;
						$balanceSheet[$journal['fkaccount_id']]['credit_amount']  = 0.00;
						$balanceSheet[$journal['fkaccount_id']]['debit_amount']  += $journal['debit'];
						$balanceSheet[$journal['fkaccount_id']]['credit_amount'] += $journal['credit'];
					}

				}


			$getCompany = $this->account->getCompany($cid);
				foreach ($getCompany as $company) {
					$start_year = $company['financial_year_start_date'];
					$end_year   = $company['financial_year_end_date'];
				}
				$current_month = date('m-d',strtotime($to));
				$current_year  = date('Y',strtotime($to));
				$finance_month = date('m-d',strtotime($start_year));
				if($current_month < $finance_month) {
					$cur_date  = $current_year."-".$finance_month;
					$strtotime = strtotime($cur_date);
					$last_year = strtotime("-1 year",$strtotime);
					$current_year = date('Y-m-d',$last_year);
				} else {
					$current_year = $current_year."-".$finance_month;
				}
				$start 		  = $current_year;


			$incomeAccount = $this->report->getIncomeAccountIncomes($start,$to);
			$incomeAccountInvoice = $this->report->getIncomeAccountInvoice($start,$to);
			$incomeAccountCredit  = $this->report->getIncomeAccountCredit($start,$to);
			$expenseAccount  = $this->report->getExpenseAccountExpenses($start,$to);
			$incomeJournalAccount   = $this->report->getIncomeJournalAccount($start,$to);
			$expenseJournalAccount  = $this->report->getExpenseJournalAccount($start,$to);
			$incomeAccountPay  = $this->report->getIncomeAccountIncomesPay($start,$to);
			$invoiceAccountPay = $this->report->getIncomeAccountInvoicesPay($start,$to);
			$expenseAccountPay = $this->report->getExpenseAccountExpensesPay($start,$to);
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

			$incomeAccountIncome     = $this->report->getGeneralIncomeAccountForeign($start,$to);

			$incomeAccountInvoice    = $this->report->getGeneralInvoiceIncomeAccountForeign($start,$to);

			$expenseAccount  		 = $this->report->getGeneralExpenseAccountForeign($start,$to);

			$incomeAccountIncomePay  = $this->report->getGeneralIncomePayAccountForeign($start,$to);

			$incomeAccountInvoicePay = $this->report->getInvoicePayAccountsForeign($start,$to);

			$expenseAccountPay       = $this->report->getExpensePayAccountsForeign($start,$to);

			$incomeAccountCredit  	 = $this->report->getGeneralCreditAccountForeign($start,$to);


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
						$foreignCurrency[$invoice['invoice_no']]['convert_amount'] = $credits;
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

			$this->view->currentYear = $totals;

			$retained   =  $this->income->retained($start);

			$this->view->retained = $retained;

			//echo $from;

/*				echo '<pre>'; print_r($incomeAccountCredit); echo '</pre>';

				echo '<pre>'; print_r($incomes); echo '</pre>';
				echo '<pre>'; print_r($incomesPay); echo '</pre>';

				echo '<pre>'; print_r($invoices); echo '</pre>';
				echo '<pre>'; print_r($invoicesPay); echo '</pre>';

				echo '<pre>'; print_r($credits); echo '</pre>';

				echo '<pre>'; print_r($balanceSheet); echo '</pre>'; die();*/
/*			
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
			$creditAccountEntry = $this->report->getAccountingEntriesCredit($from,$to);*/

			
			$this->view->previousYear = 0.00;

			$this->view->getAccount	    =  $this->report->getAllAccounts();
			foreach ($this->view->getAccount as $acc) {
				if($acc['debit_opening_balance']!=0 || $acc['credit_opening_balance']!=0) {
					if(array_key_exists($acc['id'], $balanceSheet)) {
						$balanceSheet[$acc['id']]['debit_amount']  += $acc['debit_opening_balance'];
						$balanceSheet[$acc['id']]['credit_amount'] += $acc['credit_opening_balance'];
					} else {
						$balanceSheet[$acc['id']]['debit_amount']   = 0.00;
						$balanceSheet[$acc['id']]['credit_amount']  = 0.00;
						$balanceSheet[$acc['id']]['debit_amount']  += $acc['debit_opening_balance'];
						$balanceSheet[$acc['id']]['credit_amount'] += $acc['credit_opening_balance'];
					}
				}
			}
			$this->view->paymentAccount	=  $balanceSheet;



			  }
	}

	public function generalLedgerAction() {
		if(!Zend_Session::namespaceIsset('sess_login')) {
		   $this->_redirect('index');
		} else {
			$generalLedger  = array();
			$accountId      = array();
			$accountLedger  = array();
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
				$from 		  = $current_year;
				$to = date('Y-m-d');
			if($this->_request->isPost()) {
				$postArray  = $this->getRequest()->getPost();
				$from = date('Y-m-d',strtotime($postArray['from_date']));
				$to = date('Y-m-d',strtotime($postArray['to_date']));
			}
			$this->view->from = date('d-m-Y',strtotime($from));
			$this->view->to = date('d-m-Y',strtotime($to));

			$incomeAccountIncome  = $this->report->getGeneralIncomeAccountGl($from,$to);
			$incomeAccountInvoice = $this->report->getGeneralInvoiceIncomeAccountGl($from,$to);
			$incomeAccountCredit  = $this->report->getGeneralCreditAccountGl($from,$to);
			$expenseAccount  = $this->report->getGeneralExpenseAccountGl($from,$to);
			$journalAccount  = $this->report->getGeneralJournalAccountGl($from,$to);

			$incomeAccountIncomePay  = $this->report->getGeneralIncomePayAccountGl($from,$to);
			$expenseAccountPay  =  $this->report->getExpensePayAccountGl($from,$to);
			$incomeAccountInvoicePay  =  $this->report->getInvoicePayAccountGl($from,$to);



			$accountId['income'][] = 'NULL';
			if(isset($incomeAccountIncome) && !empty($incomeAccountIncome)) {
				foreach ($incomeAccountIncome as $income) {
					$accountId['income'][] = $income['inc_id'];
					$tax_amount = ($income['amount'] * $income['tax_value'] / 100);
					$total_income = $income['amount']+$tax_amount;	
					if($income['transaction_currency']!='SGD') {
						$converted_amount = $income['amount']*$income['exchange_rate'];
						$whole_amount	  = $total_income*$income['exchange_rate'];
						if($tax_amount!=0) {
							$total_tax = $tax_amount*$income['exchange_rate'];
						} else {
							$total_tax = 0;
						}
						/*if($income['pay_status']==1 && $income['final_payment_date'] <= $to) {
							$accountLedger[2][$income['income_no']]['account_type']  = 2;
							$accountLedger[2][$income['income_no']]['no']  		     = $income['income_no'];
							$accountLedger[2][$income['income_no']]['type']  		 = "Income";
							$accountLedger[2][$income['income_no']]['name'] 		 = $income['customer_name'];
							$accountLedger[2][$income['income_no']]['date'] 		 = $income['final_payment_date'];
							$accountLedger[2][$income['income_no']]['transaction']   = $income['transaction_description'];
							$accountLedger[2][$income['income_no']]['transaction2']   = $income['transaction_description'];
							$accountLedger[2][$income['income_no']]['debit_amount']   = round($whole_amount,2);
							$accountLedger[2][$income['income_no']]['credit_amount']  = 0.00;
						}*/
					} else {
						$converted_amount = $income['amount'];
						$whole_amount	  = $total_income;
						if($tax_amount!=0) {
							$total_tax = $tax_amount;
						} else {
							$total_tax = 0;
						}
					}

					$incomes[$income['income_no']]['tax_value'] = $income['tax_value'];
					

						$accountLedger[$income['fkincome_type']][$income['income_no']]['account_type']  = $income['fkincome_type'];
						$accountLedger[$income['fkincome_type']][$income['income_no']]['no']  		    = $income['income_no'];
						$accountLedger[$income['fkincome_type']][$income['income_no']]['type']  		= "Income";
						$accountLedger[$income['fkincome_type']][$income['income_no']]['name'] 		    = $income['customer_name'];
						$accountLedger[$income['fkincome_type']][$income['income_no']]['date'] 		    = $income['date'];
						$accountLedger[$income['fkincome_type']][$income['income_no']]['transaction']   = $income['transaction_description'];
						$accountLedger[$income['fkincome_type']][$income['income_no']]['transaction2']   = $income['transaction_description'];
						$accountLedger[$income['fkincome_type']][$income['income_no']]['credit_amount'] = $converted_amount;
						$accountLedger[$income['fkincome_type']][$income['income_no']]['debit_amount']  = 0.00;

						if($total_tax!=0) {
							$accountLedger[11][$income['income_no']]['account_type']  = 11;
							$accountLedger[11][$income['income_no']]['no']  		  = $income['income_no'];
							$accountLedger[11][$income['income_no']]['type']  		  = "Income";
							$accountLedger[11][$income['income_no']]['name'] 		  = $income['customer_name'];
							$accountLedger[11][$income['income_no']]['date'] 		  = $income['date'];
							$accountLedger[11][$income['income_no']]['transaction']   = $income['transaction_description'];
							$accountLedger[11][$income['income_no']]['transaction2']   = $income['transaction_description'];
							$accountLedger[11][$income['income_no']]['credit_amount'] = $total_tax;
							$accountLedger[11][$income['income_no']]['debit_amount']  = 0.00;
						}


						if($income['credit_term']!=1) {
							$accountLedger[$income['coa_link']][$income['income_no']]['account_type']   = $income['coa_link'];
							$accountLedger[$income['coa_link']][$income['income_no']]['no']   		    = $income['income_no'];
							$accountLedger[$income['coa_link']][$income['income_no']]['type']  		    = "Income";
							$accountLedger[$income['coa_link']][$income['income_no']]['name'] 		    = $income['customer_name'];
							$accountLedger[$income['coa_link']][$income['income_no']]['date'] 		    = $income['date'];
							$accountLedger[$income['coa_link']][$income['income_no']]['transaction']    = $income['transaction_description'];
							$accountLedger[$income['coa_link']][$income['income_no']]['transaction2']    = $income['transaction_description'];
							$accountLedger[$income['coa_link']][$income['income_no']]['debit_amount']   = $whole_amount;
							$accountLedger[$income['coa_link']][$income['income_no']]['credit_amount']  = 0.00;	
						}

				}
			}

			

			$accountId['invoice'][] = 'NULL';
			if(isset($incomeAccountInvoice) && !empty($incomeAccountInvoice)) {
				foreach ($incomeAccountInvoice as $invoice) {
					$accountId['invoice'][] = $invoice['inv_id'];
					$amount = ($invoice['unit_price'] * $invoice['quantity'] - $invoice['discount_amount']);
					$tax_amount = ($amount * $invoice['tax_value'] / 100);
					$total_income = $amount+$tax_amount;
					if($invoice['transaction_currency']!='SGD') {
						$converted_amount = $amount*$invoice['exchange_rate'];
						$whole_amount	  = $total_income*$invoice['exchange_rate'];
						if($tax_amount!=0) {
							$total_tax = $tax_amount*$invoice['exchange_rate'];
						} else {
							$total_tax = 0;
						}
						if($invoice['discount_amount']!=0) {
							$discount_amount = $invoice['discount_amount']*$invoice['exchange_rate'];
						} else {
							$discount_amount = 0;
						}
						/*if($invoice['pay_status']==1 && $invoice['final_payment_date'] <= $to && !isset($accountLedger[2][$invoice['invoice_no']])) {
							$accountLedger[2][$invoice['invoice_no']]['account_type']    = 2;
							$accountLedger[2][$invoice['invoice_no']]['no'] 			 = $invoice['invoice_no'];
							$accountLedger[2][$invoice['invoice_no']]['type'] 		     = "Invoice";
							$accountLedger[2][$invoice['invoice_no']]['name'] 	  	     = $invoice['customer_name'];
							$accountLedger[2][$invoice['invoice_no']]['date'] 		     = $invoice['final_payment_date'];
							$accountLedger[2][$invoice['invoice_no']]['transaction'] 	 = $invoice['name'];
							$accountLedger[2][$invoice['invoice_no']]['transaction2'] 	 = $invoice['description'];
							$accountLedger[2][$invoice['invoice_no']]['debit_amount']    = $whole_amount;
							$accountLedger[2][$invoice['invoice_no']]['credit_amount']    = 0.00;
						} else if($invoice['pay_status']==1 && $invoice['final_payment_date'] <= $to && isset($accountLedger[2][$invoice['invoice_no']])) {
							$accountLedger[2][$invoice['invoice_no']]['debit_amount']    += $whole_amount;
						}*/
					} else {
						$converted_amount = $amount;
						$whole_amount	  = $total_income;
						if($tax_amount!=0) {
							$total_tax = $tax_amount;
						} else {
							$total_tax = 0;
						}
						/*if($invoice['discount_amount']!=0) {
							$discount_amount = $invoice['discount_amount'];
						} else {
							$discount_amount = 0;
						}*/
					}
					if(!isset($invoices[$invoice['invoice_no']]['tax_value'])) {
						$invoices[$invoice['invoice_no']]['tax_value'] = $invoice['tax_value'];
					}

						$invoice_id = $invoice['invoice_no']."_".$invoice['pid'];
						$accountLedger[$invoice['fkincomeaccount_id']][$invoice_id]['account_type']   = $invoice['fkincomeaccount_id'];
						$accountLedger[$invoice['fkincomeaccount_id']][$invoice_id]['no'] 			  = $invoice['invoice_no'];
						$accountLedger[$invoice['fkincomeaccount_id']][$invoice_id]['type'] 		  = "Invoice";
						$accountLedger[$invoice['fkincomeaccount_id']][$invoice_id]['name'] 	  	  = $invoice['customer_name'];
						$accountLedger[$invoice['fkincomeaccount_id']][$invoice_id]['date'] 		  = $invoice['date'];
						$accountLedger[$invoice['fkincomeaccount_id']][$invoice_id]['transaction'] 	  = $invoice['name'];
						$accountLedger[$invoice['fkincomeaccount_id']][$invoice_id]['transaction2']   = $invoice['description'];
						$accountLedger[$invoice['fkincomeaccount_id']][$invoice_id]['credit_amount']  = $converted_amount;
						$accountLedger[$invoice['fkincomeaccount_id']][$invoice_id]['debit_amount']   = 0.00;

						if($total_tax!=0) {
							if(!isset($accountLedger[11][$invoice['invoice_no']])) {
								$accountLedger[11][$invoice['invoice_no']]['account_type']      = 11;
								$accountLedger[11][$invoice['invoice_no']]['no'] 			    = $invoice['invoice_no'];
								$accountLedger[11][$invoice['invoice_no']]['type'] 		  		= "Invoice";
								$accountLedger[11][$invoice['invoice_no']]['name'] 	  	  		= $invoice['customer_name'];
								$accountLedger[11][$invoice['invoice_no']]['date'] 		  		= $invoice['date'];
								$accountLedger[11][$invoice['invoice_no']]['transaction'] 	  	= $invoice['name'];
								$accountLedger[11][$invoice['invoice_no']]['transaction2'] 	  	= $invoice['description'];
								$accountLedger[11][$invoice['invoice_no']]['credit_amount']  	= $total_tax;
								$accountLedger[11][$invoice['invoice_no']]['debit_amount']   	= 0.00;
							} else {
								$accountLedger[11][$invoice['invoice_no']]['credit_amount']  	+= $total_tax;
								$accountLedger[11][$invoice['invoice_no']]['debit_amount']   	 = 0.00;
							}
						}

						/*if($discount_amount!=0) {
							if(!isset($accountLedger[7][$invoice['invoice_no']])) {
								$accountLedger[7][$invoice['invoice_no']]['account_type']       = 7;
								$accountLedger[7][$invoice['invoice_no']]['no'] 			    = $invoice['invoice_no'];
								$accountLedger[7][$invoice['invoice_no']]['type'] 		  		= "Invoice";
								$accountLedger[7][$invoice['invoice_no']]['name'] 	  	  		= $invoice['customer_name'];
								$accountLedger[7][$invoice['invoice_no']]['date'] 		  		= $invoice['date'];
								$accountLedger[7][$invoice['invoice_no']]['transaction'] 	  	= $invoice['name'];
								$accountLedger[7][$invoice['invoice_no']]['debit_amount']  	    = $discount_amount;
								$accountLedger[7][$invoice['invoice_no']]['credit_amount']   	= 0.00;
							} else {
								$accountLedger[7][$invoice['invoice_no']]['debit_amount']  	    += $discount_amount;
								$accountLedger[7][$invoice['invoice_no']]['credit_amount']   	 = 0.00;
							}
						}*/

						$accountLedger[$invoice['fkincomeaccount_id']][$invoice_id]['account_type']   = $invoice['fkincomeaccount_id'];
						$accountLedger[$invoice['fkincomeaccount_id']][$invoice_id]['no'] 			  = $invoice['invoice_no'];
						$accountLedger[$invoice['fkincomeaccount_id']][$invoice_id]['type'] 		  = "Invoice";
						$accountLedger[$invoice['fkincomeaccount_id']][$invoice_id]['name'] 	  	  = $invoice['customer_name'];
						$accountLedger[$invoice['fkincomeaccount_id']][$invoice_id]['date'] 		  = $invoice['date'];
						$accountLedger[$invoice['fkincomeaccount_id']][$invoice_id]['transaction'] 	  = $invoice['name'];
						$accountLedger[$invoice['fkincomeaccount_id']][$invoice_id]['transaction2']   = $invoice['description'];
						$accountLedger[$invoice['fkincomeaccount_id']][$invoice_id]['credit_amount']  = $converted_amount;
						$accountLedger[$invoice['fkincomeaccount_id']][$invoice_id]['debit_amount']   = 0.00;

						if($invoice['credit_term']!=1) {
							if(!isset($accountLedger[$invoice['coa_link']][$invoice['invoice_no']])) {
								$accountLedger[$invoice['coa_link']][$invoice['invoice_no']]['account_type']    = $invoice['coa_link'];
								$accountLedger[$invoice['coa_link']][$invoice['invoice_no']]['no']   		    = $invoice['invoice_no'];
								$accountLedger[$invoice['coa_link']][$invoice['invoice_no']]['type']  		    = "Invoice";
								$accountLedger[$invoice['coa_link']][$invoice['invoice_no']]['name'] 		    = $invoice['customer_name'];
								$accountLedger[$invoice['coa_link']][$invoice['invoice_no']]['date'] 		    = $invoice['date'];
								$accountLedger[$invoice['coa_link']][$invoice['invoice_no']]['transaction']     = $invoice['name'];
								$accountLedger[$invoice['coa_link']][$invoice['invoice_no']]['transaction2']    = $invoice['description'];
								$accountLedger[$invoice['coa_link']][$invoice['invoice_no']]['debit_amount']    = $whole_amount;
								$accountLedger[$invoice['coa_link']][$invoice['invoice_no']]['credit_amount']   = 0.00;	
							} else {
								$accountLedger[$invoice['coa_link']][$invoice['invoice_no']]['debit_amount']    += $whole_amount;
								$accountLedger[$invoice['coa_link']][$invoice['invoice_no']]['credit_amount']    = 0.00;	
							}
						}
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
						if($tax_amount!=0) {
							$total_tax = $tax_amount*$credit['exchange_rate'];
						} else {
							$total_tax = 0;
						}
						if($credit['discount_amount']!=0) {
							$discount_amount = $credit['discount_amount']*$credit['exchange_rate'];
						} else {
							$discount_amount = 0;
						}
					} else {
						$converted_amount = $amount;
						$whole_amount 	  = $total_income;
						if($tax_amount!=0) {
							$total_tax = $tax_amount;
						} else {
							$total_tax = 0;
						}
						/*if($credit['discount_amount']!=0) {
							$discount_amount = $credit['discount_amount'];
						} else {
							$discount_amount = 0;
						}*/
					}

					if(isset($accountLedger[2][$credit['invoice_no']])) {
						$credits = $accountLedger[2][$invoice['invoice_no']]['debit_amount'] - $whole_amount;
						$accountLedger[2][$invoice['invoice_no']]['debit_amount'] = round($credits,2); 
					}
					

						//$credit_id = $credit['credit_no']."_".$credit['invoice_no']."_".$credit['pid'];
					$credit_id = $credit['credit_no']."_".$credit['invoice_no']."_".$credit['pid'];
						$accountLedger[$credit['fkincomeaccount_id']][$credit_id]['account_type'] 	= $credit['fkincomeaccount_id'];
						$accountLedger[$credit['fkincomeaccount_id']][$credit_id]['no'] 			= $credit['credit_no'];
						$accountLedger[$credit['fkincomeaccount_id']][$credit_id]['type'] 			= "Credit Note";
						$accountLedger[$credit['fkincomeaccount_id']][$credit_id]['date']			= $credit['date'];
						$accountLedger[$credit['fkincomeaccount_id']][$credit_id]['name'] 		    = $credit['customer_name'];
						$accountLedger[$credit['fkincomeaccount_id']][$credit_id]['transaction'] 	= $credit['name'];
						$accountLedger[$credit['fkincomeaccount_id']][$credit_id]['transaction2'] 	= $credit['description'];
						$accountLedger[$credit['fkincomeaccount_id']][$credit_id]['credit_amount'] 	= 0.00;
						$accountLedger[$credit['fkincomeaccount_id']][$credit_id]['debit_amount'] 	= $converted_amount;

						/*if($discount_amount!=0) {
							if(!isset($accountLedger[7][$credit['credit_no']])) { 
								$accountLedger[7][$credit['credit_no']]['account_type'] 	= 7;
								$accountLedger[7][$credit['credit_no']]['no'] 				= $credit['credit_no'];
								$accountLedger[7][$credit['credit_no']]['type'] 			= "Credit Note";
								$accountLedger[7][$credit['credit_no']]['date']			    = $credit['date'];
								$accountLedger[7][$credit['credit_no']]['name'] 		    = $credit['customer_name'];
								$accountLedger[7][$credit['credit_no']]['transaction']   	= $credit['name'];
								$accountLedger[7][$credit['credit_no']]['debit_amount']     = 0.00;
								$accountLedger[7][$credit['credit_no']]['credit_amount'] 	= $discount_amount;
							} else {
								$accountLedger[7][$credit['credit_no']]['debit_amount']      = 0.00;
								$accountLedger[7][$credit['credit_no']]['credit_amount'] 	+= $discount_amount;
							}
						}*/

						if($total_tax!=0) {
							if(!isset($accountLedger[11][$credit['credit_no']])) { 
								$accountLedger[11][$credit['credit_no']]['account_type'] 	= 11;
								$accountLedger[11][$credit['credit_no']]['no'] 				= $credit['credit_no'];
								$accountLedger[11][$credit['credit_no']]['type'] 			= "Credit Note";
								$accountLedger[11][$credit['credit_no']]['date']			= $credit['date'];
								$accountLedger[11][$credit['credit_no']]['name'] 		    = $credit['customer_name'];
								$accountLedger[11][$credit['credit_no']]['transaction'] 	= $credit['name'];
								$accountLedger[11][$credit['credit_no']]['transaction2'] 	= $credit['description'];
								$accountLedger[11][$credit['credit_no']]['credit_amount']   = 0.00;
								$accountLedger[11][$credit['credit_no']]['debit_amount'] 	= $total_tax;
							} else {
								$accountLedger[11][$credit['credit_no']]['credit_amount']    = 0.00;
								$accountLedger[11][$credit['credit_no']]['debit_amount'] 	+= $total_tax;
							}
						}

						if(!isset($accountLedger[$credit['coa_link']][$credit_id])) {
								$accountLedger[$credit['coa_link']][$credit_id]['account_type']     = $credit['coa_link'];
								$accountLedger[$credit['coa_link']][$credit_id]['no']   		      = $credit['credit_no'];
								$accountLedger[$credit['coa_link']][$credit_id]['type']  		      = "Credit Note";
								$accountLedger[$credit['coa_link']][$credit_id]['name'] 		      = $credit['customer_name'];
								$accountLedger[$credit['coa_link']][$credit_id]['date'] 		      = $credit['date'];
								$accountLedger[$credit['coa_link']][$credit_id]['transaction']      = $credit['name'];
								$accountLedger[$credit['coa_link']][$credit_id]['transaction2']     = $credit['description'];
								$accountLedger[$credit['coa_link']][$credit_id]['credit_amount']    = $whole_amount;
								$accountLedger[$credit['coa_link']][$credit_id]['debit_amount']     = 0.00;	
						} else {
								$accountLedger[$credit['coa_link']][$credit_id]['credit_amount']    += $whole_amount;
								$accountLedger[$credit['coa_link']][$credit_id]['debit_amount']      = 0.00;	
						}
				}
			}

			

            

			$accountId['expense'][] = 'NULL';
			if(isset($expenseAccount) && !empty($expenseAccount)) {
				foreach ($expenseAccount as $expense) {
					$accountId['expense'][] = $expense['exp_id'];
					$amount = ($expense['unit_price'] * $expense['quantity']);
					if($expense['total_gst']!=0.00) {
						$tax_amount = $expense['total_gst'];
					} else {
						$tax_amount = ($amount * $expense['tax_value'] / 100);
					}
					$total_income = $amount + $tax_amount;
					if($expense['transaction_currency']!='SGD') {
						$converted_amount = $amount*$expense['exchange_rate'];
						if($expense['total_gst']!=0.00) {
							$whole_amount 	  = ($amount*$expense['exchange_rate'])+$expense['total_gst'];
						} else {
							$whole_amount 	  = $total_income*$expense['exchange_rate'];
						}
						if($tax_amount!=0) {
							if($expense['total_gst']!=0.00) {
								$total_tax = $expense['total_gst'];
							} else {
								$total_tax = $tax_amount*$expense['exchange_rate'];
							}
						} else {
							$total_tax = 0;
						}

						/*if($expense['pay_status']==1 && $expense['final_payment_date'] <= $to && !isset($accountLedger[2][$expense['expense_no']])) {
							$accountLedger[2][$expense['expense_no']]['account_type']    = 2;
							$accountLedger[2][$expense['expense_no']]['no'] 			 = $expense['expense_no'];
							$accountLedger[2][$expense['expense_no']]['type'] 		     = "Expense";
							$accountLedger[2][$expense['expense_no']]['name'] 	  	     = $expense['vendor_name'];
							$accountLedger[2][$expense['expense_no']]['date'] 		     = $expense['final_payment_date'];
							$accountLedger[2][$expense['expense_no']]['transaction'] 	 = $expense['product_id'];
							$accountLedger[2][$expense['expense_no']]['transaction2'] 	 = $expense['product_description'];
							$accountLedger[2][$expense['expense_no']]['credit_amount']   = round($whole_amount,2);
							$accountLedger[2][$expense['expense_no']]['debit_amount']    = 0.00;
						} else if($expense['pay_status']==1 && $expense['final_payment_date'] <= $to && isset($accountLedger[2][$expense['expense_no']])) {
							$accountLedger[2][$expense['expense_no']]['credit_amount']   += round($whole_amount,2);
						}*/
					} else {
						$converted_amount = $amount;
						$whole_amount     = $total_income;
						if($tax_amount!=0) {
							$total_tax = $tax_amount;
						} else {
							$total_tax = 0;
						}
					}

					if(!isset($expenses[$expense['expense_no']]['tax_value'])) {
						$expenses[$expense['expense_no']]['tax_value'] = $expense['tax_value'];
					}

					$expense_id = $expense['expense_no']."_".$expense['pid'];
					$accountLedger[$expense['fkexpense_type']][$expense_id]['account_type']  = $expense['fkexpense_type'];
					$accountLedger[$expense['fkexpense_type']][$expense_id]['no'] 			 = $expense['expense_no'];
					$accountLedger[$expense['fkexpense_type']][$expense_id]['type'] 		 = "Expense";
					$accountLedger[$expense['fkexpense_type']][$expense_id]['date'] 		 = $expense['date'];
					$accountLedger[$expense['fkexpense_type']][$expense_id]['name'] 		 = $expense['vendor_name'];
					$accountLedger[$expense['fkexpense_type']][$expense_id]['transaction']   = $expense['product_id'];
					$accountLedger[$expense['fkexpense_type']][$expense_id]['transaction2']  = $expense['product_description'];
					$accountLedger[$expense['fkexpense_type']][$expense_id]['credit_amount'] = 0.00;
					$accountLedger[$expense['fkexpense_type']][$expense_id]['debit_amount']  = $converted_amount;

					if($total_tax!=0) {
						if(!isset($accountLedger[11][$expense['expense_no']])) { 
							$accountLedger[11][$expense['expense_no']]['account_type']   = 11;
							$accountLedger[11][$expense['expense_no']]['no'] 			 = $expense['expense_no'];
							$accountLedger[11][$expense['expense_no']]['type'] 		 	 = "Expense";
							$accountLedger[11][$expense['expense_no']]['date'] 		 	 = $expense['date'];
							$accountLedger[11][$expense['expense_no']]['name'] 		     = $expense['vendor_name'];
							$accountLedger[11][$expense['expense_no']]['transaction']    = $expense['product_id'];
							$accountLedger[11][$expense['expense_no']]['transaction2']   = $expense['product_description'];
							$accountLedger[11][$expense['expense_no']]['credit_amount']  = 0.00;
							$accountLedger[11][$expense['expense_no']]['debit_amount']   = $total_tax;
						} else {
							$accountLedger[11][$expense['expense_no']]['credit_amount']   = 0.00;
							$accountLedger[11][$expense['expense_no']]['debit_amount']   += $total_tax;
						}
					}

					if($expense['credit_term']!=1) {
						if(!isset($accountLedger[$expense['coa_link']][$expense['expense_no']])) {
							$accountLedger[$expense['coa_link']][$expense['expense_no']]['account_type']    = $expense['coa_link'];
							$accountLedger[$expense['coa_link']][$expense['expense_no']]['no']   		    = $expense['expense_no'];
							$accountLedger[$expense['coa_link']][$expense['expense_no']]['type']  		    = "Expense";
							$accountLedger[$expense['coa_link']][$expense['expense_no']]['name'] 		    = $expense['vendor_name'];
							$accountLedger[$expense['coa_link']][$expense['expense_no']]['date'] 		    = $expense['date'];
							$accountLedger[$expense['coa_link']][$expense['expense_no']]['transaction']     = $expense['product_id'];
							$accountLedger[$expense['coa_link']][$expense['expense_no']]['transaction2']     = $expense['product_description'];
							$accountLedger[$expense['coa_link']][$expense['expense_no']]['debit_amount']    = 0.00;
							$accountLedger[$expense['coa_link']][$expense['expense_no']]['credit_amount']   = $whole_amount;	
						} else {
							$accountLedger[$expense['coa_link']][$expense['expense_no']]['debit_amount']     += 0.00;
							$accountLedger[$expense['coa_link']][$expense['expense_no']]['credit_amount']    += $whole_amount;	
						}
					}
				}
			}




			$accountId['income_pay'][] = 'NULL';
			$accountId['income_paid'][] = 'NULL';
			if(isset($incomeAccountIncomePay) && !empty($incomeAccountIncomePay)) {
				foreach ($incomeAccountIncomePay as $incPayment) {
						$accountId['income_pay'][] = $incPayment['inc_id'];
						$amount = $incPayment['payment_amount']+$incPayment['discount_amount'];
						
						/*if($incPayment['pay_status']==1 && $incPayment['transaction_currency']!='SGD') {
							if(isset($accountLedger[2][$incPayment['income_no']])) {
								$accountLedger[2][$incPayment['income_no']]['debit_amount'] -= $incPayment['payment_amount'];
							} else {
								$accountLedger[2][$incPayment['income_no']]['account_type']  = $incPayment['fkpayment_account'];
								$accountLedger[2][$incPayment['income_no']]['no'] 			  = "PMT".$incPayment['id'];
								$accountLedger[2][$incPayment['income_no']]['type'] 		  = "Payment";
								$accountLedger[2][$incPayment['income_no']]['date'] 		  = $incPayment['pay_date'];
								$accountLedger[2][$incPayment['income_no']]['name'] 		  = $incPayment['customer_name'];
								$accountLedger[2][$incPayment['income_no']]['transaction']   = "Payment for Income No ".$incPayment['income_no'];
								$accountLedger[2][$incPayment['income_no']]['transaction2']  = $incPayment['payment_description'];
								$accountLedger[2][$incPayment['income_no']]['credit_amount'] = 0.00;
								$accountLedger[2][$incPayment['income_no']]['debit_amount']  = $incPayment['payment_amount'];
							}
						}*/

					$payId = $incPayment['id']."_".$incPayment['income_no']."_pay";
					$entryId = $incPayment['id']."_".$incPayment['income_no']."_payentry";
					$accountLedger[$incPayment['fkpayment_account']][$payId]['account_type']  = $incPayment['fkpayment_account'];
					$accountLedger[$incPayment['fkpayment_account']][$payId]['no'] 			  = "PMT".$incPayment['id'];
					$accountLedger[$incPayment['fkpayment_account']][$payId]['type'] 		  = "Payment";
					$accountLedger[$incPayment['fkpayment_account']][$payId]['date'] 		  = $incPayment['pay_date'];
					$accountLedger[$incPayment['fkpayment_account']][$payId]['name'] 		  = $incPayment['customer_name'];
					$accountLedger[$incPayment['fkpayment_account']][$payId]['transaction']   = "Payment for Income No ".$incPayment['income_no'];
					$accountLedger[$incPayment['fkpayment_account']][$payId]['transaction2']   = $incPayment['payment_description'];
					$accountLedger[$incPayment['fkpayment_account']][$payId]['credit_amount'] = 0.00;
					$accountLedger[$incPayment['fkpayment_account']][$payId]['debit_amount']  = $incPayment['payment_amount'];

					if($incPayment['discount_amount']!=0) {

						if(isset($incPayment['tax_value']) && $incPayment['tax_value']!=0) {
							$tax_pay = (($incPayment['discount_amount'] * $incPayment['tax_value']) / (100+$incPayment['tax_value']));
							$discount_amount = $incPayment['discount_amount'] - $tax_pay;

							$accountLedger[11][$payId]['account_type']  = 11;
							$accountLedger[11][$payId]['no'] 		   = "PMT".$incPayment['id'];
							$accountLedger[11][$payId]['type'] 		   = "Payment";
							$accountLedger[11][$payId]['date'] 		   = $incPayment['pay_date'];
							$accountLedger[11][$payId]['name'] 		   = $incPayment['customer_name'];
							$accountLedger[11][$payId]['transaction']   = "Payment for Income No ".$incPayment['income_no'];
							$accountLedger[11][$payId]['transaction2']   = $incPayment['payment_description'];
							$accountLedger[11][$payId]['credit_amount'] = 0.00;
							$accountLedger[11][$payId]['debit_amount']  = $tax_pay;
						} else {
							$discount_amount = $incPayment['discount_amount'];
						}

						$accountLedger[7][$payId]['account_type']  = 7;
						$accountLedger[7][$payId]['no'] 		   = "PMT".$incPayment['id'];
						$accountLedger[7][$payId]['type'] 		   = "Payment";
						$accountLedger[7][$payId]['date'] 		   = $incPayment['pay_date'];
						$accountLedger[7][$payId]['name'] 		   = $incPayment['customer_name'];
						$accountLedger[7][$payId]['transaction']   = "Payment for Income No ".$incPayment['income_no'];
						$accountLedger[7][$payId]['transaction2']   = $incPayment['payment_description'];
						$accountLedger[7][$payId]['credit_amount'] = 0.00;
						$accountLedger[7][$payId]['debit_amount']  = $discount_amount;

					}

					if($incPayment['credit_term']!=1) {

							$accountLedger[$incPayment['coa_link']][$payId]['account_type']    = $incPayment['coa_link'];
							$accountLedger[$incPayment['coa_link']][$payId]['no']   		   = "PMT".$incPayment['id'];
							$accountLedger[$incPayment['coa_link']][$payId]['type']  		   = "Payment";
							$accountLedger[$incPayment['coa_link']][$payId]['name'] 		   = $incPayment['customer_name'];
							$accountLedger[$incPayment['coa_link']][$payId]['date'] 		   = $incPayment['pay_date'];
							$accountLedger[$incPayment['coa_link']][$payId]['transaction']     = "Payment for Income No ".$incPayment['income_no'];
							$accountLedger[$incPayment['coa_link']][$payId]['transaction2']    = $incPayment['payment_description'];
							/*$accountLedger[$incPayment['coa_link']][$payId]['debit_amount']    = 0.00;
							$accountLedger[$incPayment['coa_link']][$payId]['credit_amount']   = $amount;*/	

							if($incPayment['pay_status']==1 && ($incPayment['final_payment_date'] == $incPayment['pay_date'])) {

								if(isset($accountLedger[$incPayment['coa_link']][$incPayment['income_no']])) {
									$debit_amount   = $accountLedger[$incPayment['coa_link']][$incPayment['income_no']]['debit_amount'];
								} else {
									$receivable = $this->report->getIncomeReceivables($incPayment['inc_id']);
									if(isset($receivable) && !empty($receivable)) {
										foreach ($receivable as $receive) {
											if($incPayment['transaction_currency']!='SGD') {
												$amt = $receive['amount']*$incPayment['exchange_rate'];
											} else {
												$amt = $receive['amount'];
											}
											$debit_amount = round($amt,2);
										}
									} else {
										$debit_amount = 0.00;
									}
								}
								$credit_amount  = 0.00;

								foreach ($accountLedger as $key => $value) {
									foreach ($value as $key1 => $value1) {
										$split = explode("_", $key1);
										if(isset($split[1]) && !empty($split[1]) && $split[1]==$incPayment['income_no']) {
											if(isset($value1['credit_amount'])) {
										    	$credit_amount += $value1['credit_amount'];
											}
										}
									}
								}

								if($debit_amount==0 && $credit_amount==0) {

									$accountLedger[$incPayment['coa_link']][$payId]['credit_amount']   = $amount;
									$accountLedger[$incPayment['coa_link']][$payId]['debit_amount']    = 0.00;

								} else {

									$total_amt = $debit_amount - $credit_amount;

									$accountLedger[$incPayment['coa_link']][$payId]['credit_amount']  = $total_amt;
									$accountLedger[$incPayment['coa_link']][$payId]['debit_amount']   = 0.00;

								}

							} else {

								$accountLedger[$incPayment['coa_link']][$payId]['credit_amount']   = $amount;
								$accountLedger[$incPayment['coa_link']][$payId]['debit_amount']    = 0.00;

							}
					}
				}
			}



			$accountId['expense_pay'][] = 'NULL';
			$accountId['expense_paid'][] = 'NULL';
			if(isset($expenseAccountPay) && !empty($expenseAccountPay)) {
				foreach ($expenseAccountPay as $expPayment) {
						$accountId['expense_pay'][] = $expPayment['exp_id'];
						$amount = $expPayment['payment_amount']+$expPayment['discount_amount'];
						
						/*if($expPayment['pay_status']==1 && $expPayment['transaction_currency']!='SGD') {
							if(isset($accountLedger[2][$expPayment['expense_no']])) {
								$accountLedger[2][$expPayment['expense_no']]['credit_amount'] -= $expPayment['payment_amount'];
							} else {
								$accountLedger[2][$expPayment['expense_no']]['account_type'] = $expPayment['fkpayment_account'];
								$accountLedger[2][$expPayment['expense_no']]['no'] = "PMT".$expPayment['id'];
								$accountLedger[2][$expPayment['expense_no']]['type'] = "Payment";
								$accountLedger[2][$expPayment['expense_no']]['date'] = $expPayment['pay_date'];
								$accountLedger[2][$expPayment['expense_no']]['name'] = $expPayment['vendor_name'];
								$accountLedger[2][$expPayment['expense_no']]['transaction'] = "Payment for Expense No ".$expPayment['expense_no'];
								$accountLedger[2][$expPayment['expense_no']]['transaction2'] = $expPayment['payment_description'];
								$accountLedger[2][$expPayment['expense_no']]['credit_amount'] = $expPayment['payment_amount'];
								$accountLedger[2][$expPayment['expense_no']]['debit_amount'] = 0.00;
							}
						}*/

						/*echo $expPayment['pay_date'];
						echo $expPayment['final_payment_date'];*/

					$payId = $expPayment['id']."_".$expPayment['expense_no']."_pay";
					$entryId = $expPayment['id']."_".$expPayment['expense_no']."_payentry";
					$accountLedger[$expPayment['fkpayment_account']][$payId]['account_type'] = $expPayment['fkpayment_account'];
					$accountLedger[$expPayment['fkpayment_account']][$payId]['no'] = "PMT".$expPayment['id'];
					$accountLedger[$expPayment['fkpayment_account']][$payId]['type'] = "Payment";
					$accountLedger[$expPayment['fkpayment_account']][$payId]['date'] = $expPayment['pay_date'];
					$accountLedger[$expPayment['fkpayment_account']][$payId]['name'] = $expPayment['vendor_name'];
					$accountLedger[$expPayment['fkpayment_account']][$payId]['transaction'] = "Payment for Expense No ".$expPayment['expense_no'];
					$accountLedger[$expPayment['fkpayment_account']][$payId]['transaction2'] = $expPayment['payment_description'];
					$accountLedger[$expPayment['fkpayment_account']][$payId]['credit_amount'] = $expPayment['payment_amount'];
					$accountLedger[$expPayment['fkpayment_account']][$payId]['debit_amount'] = 0.00;

					if($expPayment['discount_amount']!=0) {

						if(isset($expPayment['tax_value']) && $expPayment['tax_value']!=0) {
							$tax_pay = (($expPayment['discount_amount'] * $expPayment['tax_value']) / (100+$expPayment['tax_value']));
							$discount_amount = $expPayment['discount_amount'] - $tax_pay;

							$accountLedger[11][$payId]['account_type']  = 11;
							$accountLedger[11][$payId]['no'] 		   = "PMT".$expPayment['id'];
							$accountLedger[11][$payId]['type'] 		   = "Payment";
							$accountLedger[11][$payId]['date'] 		   = $expPayment['pay_date'];
							$accountLedger[11][$payId]['name'] 		   = $expPayment['vendor_name'];
							$accountLedger[11][$payId]['transaction']   = "Payment for Expense No ".$expPayment['expense_no'];
							$accountLedger[11][$payId]['transaction2']  = $expPayment['payment_description'];
							$accountLedger[11][$payId]['debit_amount']  = 0.00;
							$accountLedger[11][$payId]['credit_amount']  = $tax_pay;
						} else {
							$discount_amount = $expPayment['discount_amount'];
						}

						$accountLedger[8][$payId]['account_type']  = 8;
						$accountLedger[8][$payId]['no'] 		   = "PMT".$expPayment['id'];
						$accountLedger[8][$payId]['type'] 		   = "Payment";
						$accountLedger[8][$payId]['date'] 		   = $expPayment['pay_date'];
						$accountLedger[8][$payId]['name'] 		   = $expPayment['vendor_name'];
						$accountLedger[8][$payId]['transaction']   = "Payment for Expense No ".$expPayment['expense_no'];
						$accountLedger[8][$payId]['transaction2']  = $expPayment['payment_description'];
						$accountLedger[8][$payId]['debit_amount']  = 0.00;
						$accountLedger[8][$payId]['credit_amount'] = $discount_amount;
								
					}

					if($expPayment['credit_term']!=1) {

							$accountLedger[$expPayment['coa_link']][$payId]['account_type']    = $expPayment['coa_link'];
							$accountLedger[$expPayment['coa_link']][$payId]['no']   		   = "PMT".$expPayment['id'];
							$accountLedger[$expPayment['coa_link']][$payId]['type']  		   = "Payment";
							$accountLedger[$expPayment['coa_link']][$payId]['name'] 		   = $expPayment['vendor_name'];
							$accountLedger[$expPayment['coa_link']][$payId]['date'] 		   = $expPayment['pay_date'];
							$accountLedger[$expPayment['coa_link']][$payId]['transaction']     = "Payment for Expense No ".$expPayment['expense_no'];
							$accountLedger[$expPayment['coa_link']][$payId]['transaction2']     = $expPayment['payment_description'];


							if($expPayment['pay_status']==1 && ($expPayment['final_payment_date'] == $expPayment['pay_date'])) {

								if(isset($accountLedger[$expPayment['coa_link']][$expPayment['expense_no']])) {
									$credit_amount = $accountLedger[$expPayment['coa_link']][$expPayment['expense_no']]['credit_amount'];
								} else {
									$payables = $this->report->getExpensePayables($expPayment['exp_id']);
									if(isset($payables) && !empty($payables)) {
										foreach ($payables as $payable) {
											if($expPayment['transaction_currency']!='SGD') {
												if($expPayment['total_gst']!=0.00) {
													$amt = ($payable['amount']*$expPayment['exchange_rate'])+$expPayment['total_gst'];
												} else {
													$amt = $payable['amount']*$expPayment['exchange_rate'];
												}
											} else {
												$amt = $payable['amount'];
											}
											$credit_amount = round($amt,2);
										}
									} else {
										$credit_amount = 0.00;
									}
								}
								$debit_amount  = 0.00;

								foreach ($accountLedger as $key => $value) {
									foreach ($value as $key1 => $value1) {
										$split = explode("_", $key1);
										if(isset($split[1]) && !empty($split[1]) && $split[1]==$expPayment['expense_no']) {
											if(isset($value1['debit_amount'])) {
												$debit_amount += $value1['debit_amount'];
											}
										}
									}
								}

								if($debit_amount==0 && $credit_amount==0) {
									$accountLedger[$expPayment['coa_link']][$payId]['debit_amount']    = $amount;
									$accountLedger[$expPayment['coa_link']][$payId]['credit_amount']   = 0.00;

								} else {

									$total_amt = $credit_amount - $debit_amount;

									$accountLedger[$expPayment['coa_link']][$payId]['debit_amount']    = $total_amt;
									$accountLedger[$expPayment['coa_link']][$payId]['credit_amount']   = 0.00;
								}

							} else {

								$accountLedger[$expPayment['coa_link']][$payId]['debit_amount']    = $amount;
								$accountLedger[$expPayment['coa_link']][$payId]['credit_amount']   = 0.00;

							}
								
						
					}


					}
			}


			$accountId['invoice_pay'][] = 'NULL';
			$accountId['invoice_paid'][] = 'NULL';
			if(isset($incomeAccountInvoicePay) && !empty($incomeAccountInvoicePay)) {
				foreach ($incomeAccountInvoicePay as $invPayment) {
						$accountId['invoice_pay'][] = $invPayment['inv_id'];
						$amount = $invPayment['payment_amount']+$invPayment['discount_amount'];

							/*if($invPayment['pay_status']==1 && $invPayment['transaction_currency']!='SGD') {
								if(isset($accountLedger[2][$invPayment['invoice_no']])) {
									$accountLedger[2][$invPayment['invoice_no']]['debit_amount'] -= $invPayment['payment_amount'];
								} else {
									$accountLedger[2][$invPayment['invoice_no']]['account_type'] = $invPayment['fkpayment_account'];
									$accountLedger[2][$invPayment['invoice_no']]['no'] = "PMT".$invPayment['id'];
									$accountLedger[2][$invPayment['invoice_no']]['type'] = "Payment";
									$accountLedger[2][$invPayment['invoice_no']]['date'] = $invPayment['pay_date'];
									$accountLedger[2][$invPayment['invoice_no']]['name'] = $invPayment['customer_name'];
									$accountLedger[2][$invPayment['invoice_no']]['transaction'] = "Payment for Invoice No ".$invPayment['invoice_no'];
									$accountLedger[2][$invPayment['invoice_no']]['transaction2'] = $invPayment['payment_description'];
									$accountLedger[2][$invPayment['invoice_no']]['credit_amount'] = 0.00; 
									$accountLedger[2][$invPayment['invoice_no']]['debit_amount'] = $invPayment['payment_amount'];
								}
							}*/
					
							$payId = $invPayment['id']."_".$invPayment['invoice_no']."_pay";
							$entryId = $invPayment['id']."_".$invPayment['invoice_no']."_payentry";
							$accountLedger[$invPayment['fkpayment_account']][$payId]['account_type'] = $invPayment['fkpayment_account'];
							$accountLedger[$invPayment['fkpayment_account']][$payId]['no'] = "PMT".$invPayment['id'];
							$accountLedger[$invPayment['fkpayment_account']][$payId]['type'] = "Payment";
							$accountLedger[$invPayment['fkpayment_account']][$payId]['date'] = $invPayment['pay_date'];
							$accountLedger[$invPayment['fkpayment_account']][$payId]['name'] = $invPayment['customer_name'];
							$accountLedger[$invPayment['fkpayment_account']][$payId]['transaction'] = "Payment for Invoice No ".$invPayment['invoice_no'];
							$accountLedger[$invPayment['fkpayment_account']][$payId]['transaction2'] = $invPayment['payment_description'];
							$accountLedger[$invPayment['fkpayment_account']][$payId]['credit_amount'] = 0.00; 
							$accountLedger[$invPayment['fkpayment_account']][$payId]['debit_amount'] = $invPayment['payment_amount'];

							if($invPayment['discount_amount']!=0) {

							if(isset($invPayment['tax_value']) && $invPayment['tax_value']!=0) {
								$tax_pay = (($invPayment['discount_amount'] * $invPayment['tax_value']) / (100+$invPayment['tax_value']));
								$discount_amount = $invPayment['discount_amount'] - $tax_pay;

								$accountLedger[11][$payId]['account_type']  = 11;
								$accountLedger[11][$payId]['no'] 		   = "PMT".$invPayment['id'];
								$accountLedger[11][$payId]['type'] 		   = "Payment";
								$accountLedger[11][$payId]['date'] 		   = $invPayment['pay_date'];
								$accountLedger[11][$payId]['name'] 		   = $invPayment['customer_name'];
								$accountLedger[11][$payId]['transaction']   = "Payment for Invoice No ".$invPayment['invoice_no'];
								$accountLedger[11][$payId]['transaction2']  = $invPayment['payment_description'];
								$accountLedger[11][$payId]['credit_amount'] = 0.00;
								$accountLedger[11][$payId]['debit_amount']  = $tax_pay;
							} else {
								$discount_amount = $invPayment['discount_amount'];
							}

								$accountLedger[7][$payId]['account_type']  = 7;
								$accountLedger[7][$payId]['no'] 		   = "PMT".$invPayment['id'];
								$accountLedger[7][$payId]['type'] 		   = "Payment";
								$accountLedger[7][$payId]['date'] 		   = $invPayment['pay_date'];
								$accountLedger[7][$payId]['name'] 		   = $invPayment['customer_name'];
								$accountLedger[7][$payId]['transaction']   = "Payment for Invoice No ".$invPayment['invoice_no'];
								$accountLedger[7][$payId]['transaction2']  = $invPayment['payment_description'];
								$accountLedger[7][$payId]['credit_amount'] = 0.00;
								$accountLedger[7][$payId]['debit_amount']  = $discount_amount;
								
							}

						if($invPayment['credit_term']!=1) {

							$accountLedger[$invPayment['coa_link']][$payId]['account_type']    = $invPayment['coa_link'];
							$accountLedger[$invPayment['coa_link']][$payId]['no']   		   = "PMT".$invPayment['id'];
							$accountLedger[$invPayment['coa_link']][$payId]['type']  		   = "Payment";
							$accountLedger[$invPayment['coa_link']][$payId]['name'] 		   = $invPayment['customer_name'];
							$accountLedger[$invPayment['coa_link']][$payId]['date'] 		   = $invPayment['pay_date'];
							$accountLedger[$invPayment['coa_link']][$payId]['transaction']     = "Payment for Invoice No ".$invPayment['invoice_no'];
							$accountLedger[$invPayment['coa_link']][$payId]['transaction2']     = $invPayment['payment_description'];
							/*$accountLedger[$invPayment['coa_link']][$payId]['debit_amount']    = 0.00;
							$accountLedger[$invPayment['coa_link']][$payId]['credit_amount']   = $amount;	*/

							if($invPayment['pay_status']==1 && ($invPayment['final_payment_date'] == $invPayment['pay_date'])) {

								if(isset($accountLedger[$invPayment['coa_link']][$invPayment['invoice_no']])) {
									$debit_amount   = $accountLedger[$invPayment['coa_link']][$invPayment['invoice_no']]['debit_amount'];
								} else {
									$receivable = $this->report->getInvoiceReceivables($invPayment['inv_id']);
									if(isset($receivable) && !empty($receivable)) {
										foreach ($receivable as $receive) {
											if($invPayment['transaction_currency']!='SGD') {
												$amt = $receive['amount']*$invPayment['exchange_rate'];
											} else {
												$amt = $receive['amount'];
											}
											$debit_amount = $amt;
										}
									} else {
										$debit_amount = 0.00;
									}
								}
								$credit_amount  = 0.00;
								$amt = 0.00;

								/*$creditreceivable = $this->report->getCreditReceivables($invPayment['inv_id']);
									if(isset($creditreceivable) && !empty($creditreceivable)) {
										foreach ($creditreceivable as $creceive) {
											if($invPayment['transaction_currency']!='SGD') {
												$amt = $creceive['amount']*$invPayment['exchange_rate'];
											} else {
												$amt = $creceive['amount'];
											}
											$credit_amount += $amt;
										}
									}*/

									

								foreach ($accountLedger as $key => $value) {
									foreach ($value as $key1 => $value1) {
										$split = explode("_", $key1);
										if(isset($split[1]) && !empty($split[1]) && $split[1]==$invPayment['invoice_no']) {
											if(isset($value1['credit_amount'])) {
												//echo $value1['credit_amount']."_".$invPayment['invoice_no']."<br/>";
												$credit_amount += $value1['credit_amount'];
											}
										}
									}
								}


								if($debit_amount==0 && $credit_amount==0) {

									$accountLedger[$invPayment['coa_link']][$payId]['credit_amount']   = $amount;
									$accountLedger[$invPayment['coa_link']][$payId]['debit_amount']    = 0.00;

								} else {

									$total_amt = $debit_amount - $credit_amount;

									$accountLedger[$invPayment['coa_link']][$payId]['credit_amount']  = $total_amt;
									$accountLedger[$invPayment['coa_link']][$payId]['debit_amount']   = 0.00;
								}

							} else {

								$accountLedger[$invPayment['coa_link']][$payId]['credit_amount']   = $amount;
								$accountLedger[$invPayment['coa_link']][$payId]['debit_amount']    = 0.00;

							}
						
						}

					}
			}



			if(isset($journalAccount) && !empty($journalAccount)) {
				foreach ($journalAccount as $journal) {
					

					$journId = $journal['jid']."_".$journal['journal_no'];
					$accountLedger[$journal['fkaccount_id']][$journId]['account_type'] = $journal['fkaccount_id'];
					$accountLedger[$journal['fkaccount_id']][$journId]['no'] 		   = $journal['journal_no'];
					$accountLedger[$journal['fkaccount_id']][$journId]['type'] 		   = "Journal Entry";
					$accountLedger[$journal['fkaccount_id']][$journId]['name']         = "-";
					$accountLedger[$journal['fkaccount_id']][$journId]['transaction']  = "Journal No ".$journal['journal_no'];
					$accountLedger[$journal['fkaccount_id']][$journId]['transaction2'] = $journal['journal_description'];
					$accountLedger[$journal['fkaccount_id']][$journId]['credit_amount']= $journal['credit']; 
					$accountLedger[$journal['fkaccount_id']][$journId]['debit_amount'] = $journal['debit'];
					$accountLedger[$journal['fkaccount_id']][$journId]['date']         = $journal['date'];
				}
			}




			$incomeAccountIncome     = $this->report->getGeneralIncomeAccountForeign($from,$to);

			$incomeAccountInvoice    = $this->report->getGeneralInvoiceIncomeAccountForeign($from,$to);

			$expenseAccount  		 = $this->report->getGeneralExpenseAccountForeign($from,$to);

			$incomeAccountIncomePay  = $this->report->getGeneralIncomePayAccountForeign($from,$to);

			$incomeAccountInvoicePay = $this->report->getInvoicePayAccountsForeign($from,$to);

			$expenseAccountPay       = $this->report->getExpensePayAccountsForeign($from,$to);

			$incomeAccountCredit  	 = $this->report->getGeneralCreditAccountForeign($from,$to);

			//echo '<pre>'; print_r($incomeAccountCredit); echo '</pre>';

			foreach ($incomeAccountIncome as $income) {
				
					    $tax_amount   = ($income['amount'] * $income['tax_value'] / 100);
						$total_income = $income['amount']+$tax_amount;	

						if($income['transaction_currency']!='SGD') {
							$converted_rate       = $income['exchange_rate'];
							$converted_amount     = $total_income*$income['exchange_rate'];
						} 
				if($income['final_payment_date'] <= $to) {
					$accountLedger[2][$income['income_no']]['account_type'] 			 = 2;
				    $accountLedger[2][$income['income_no']]['no'] 			 = $income['income_no'];	
					$accountLedger[2][$income['income_no']]['date'] 			 = $income['final_payment_date'];
					$accountLedger[2][$income['income_no']]['type'] 			 = "Income";
					$accountLedger[2][$income['income_no']]['name']  	 = $income['customer_name'];
					$accountLedger[2][$income['income_no']]['amount']    	 = $total_income;
					$accountLedger[2][$income['income_no']]['transaction']      	 = $income['transaction_description'];
					$accountLedger[2][$income['income_no']]['transaction2']      	 = $income['transaction_description'];
					$accountLedger[2][$income['income_no']]['debit_amount'] = round($converted_amount,2);
					$accountLedger[2][$income['income_no']]['credit_amount']       	 = 0.00;
				}

			}

			foreach ($incomeAccountIncomePay as $incomePay) {
				$accountLedger[2][$incomePay['income_no']]['debit_amount']    -= $incomePay['amount'];
			}


			foreach ($incomeAccountInvoice as $invoice) {
				
					    $tax_amount   = $invoice['tax_amount'] ;
						$total_income = $invoice['amount']+$tax_amount;	

						if($invoice['transaction_currency']!='SGD') {
							$converted_rate 	= $invoice['exchange_rate'];
							$converted_amount 	= $total_income*$invoice['exchange_rate'];
						}
					if($invoice['final_payment_date'] <= $to) {
						$accountLedger[2][$invoice['invoice_no']]['account_type'] 			     = 2;
						$accountLedger[2][$invoice['invoice_no']]['no'] 			     = $invoice['invoice_no'];
						$accountLedger[2][$invoice['invoice_no']]['date'] 			 = $invoice['final_payment_date'];
						$accountLedger[2][$invoice['invoice_no']]['type'] 			 = "Invoice";
						$accountLedger[2][$invoice['invoice_no']]['name']  		 = $invoice['customer_name'];
						$accountLedger[2][$invoice['invoice_no']]['amount']    		 = $total_income;
						$accountLedger[2][$invoice['invoice_no']]['transaction']      		 = $invoice['name'];
						$accountLedger[2][$invoice['invoice_no']]['transaction2']      		 = $invoice['description'];
						$accountLedger[2][$invoice['invoice_no']]['debit_amount'] 	 = round($converted_amount,2);
						$accountLedger[2][$invoice['invoice_no']]['credit_amount']       	 	 = 0.00;
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

					if(isset($accountLedger[2][$credit['invoice_no']])) {
						$credits = $accountLedger[2][$credit['invoice_no']]['debit_amount'] - round($whole_amount,2);
						$accountLedger[2][$invoice['invoice_no']]['debit_amount'] = $credits;
					}
				}
			}


			foreach ($incomeAccountInvoicePay as $invoicePay) {
				$accountLedger[2][$invoicePay['invoice_no']]['debit_amount']    -= $invoicePay['amount'];
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
						$accountLedger[2][$expense['expense_no']]['account_type'] 			     = 2;
						$accountLedger[2][$expense['expense_no']]['no'] 			     = $expense['expense_no'];
						$accountLedger[2][$expense['expense_no']]['date'] 			 = $expense['final_payment_date'];
						$accountLedger[2][$expense['expense_no']]['type'] 			 = "Expense";
						$accountLedger[2][$expense['expense_no']]['name']  		 = $expense['vendor_name'];
						$accountLedger[2][$expense['expense_no']]['amount']    		 = $total_expense;
						$accountLedger[2][$expense['expense_no']]['transaction']      		 = $expense['product_id'];
						$accountLedger[2][$expense['expense_no']]['transaction2']      		 = $expense['product_description'];
						$accountLedger[2][$expense['expense_no']]['credit_amount'] 	 = round($converted_amount,2);
						$accountLedger[2][$expense['expense_no']]['debit_amount']       	 	 = 0.00;
					}
					
				}

				foreach ($expenseAccountPay as $expensePay) {
					$accountLedger[2][$expensePay['expense_no']]['credit_amount']    -= $expensePay['amount'];
				}
			
			$GlRollOver =  $this->glroll->index($from);


			$retained   =  $this->income->index($from);

			if(isset($GlRollOver[9])) {
				$GlRollOver[9] += round($retained,2);
			} else {
				$GlRollOver[9]  = round($retained,2);
			}

			

			//echo $retained;

			
			
			//echo '<pre>'; print_r($GlRollOver); echo '</pre>';

			$this->view->generalAccount	=  $this->report->getAllAccounts();

/*			foreach ($this->view->generalAccount as $value) {
				if($value['account_type']!=4 && $value['account_type']!=5) {
					if($value['debit_opening_balance']>0) {
						if(array_key_exists($value['id'], $GlRollOver)) {
							$GlRollOver[$value['id']] += $value['debit_opening_balance'];
						} else {
							$GlRollOver[$value['id']]  = $value['debit_opening_balance'];
						}
					} else if($value['credit_opening_balance']>0) {
						if(array_key_exists($value['id'], $GlRollOver)) {
							$GlRollOver[$value['id']] -= $value['credit_opening_balance'];
						} else {
							$GlRollOver[$value['id']]  = $value['credit_opening_balance'];
						}
					}
				}
			}*/


			$this->view->rollOver = $GlRollOver;
			/*if(isset($this->view->getAccount) && !empty($this->view->getAccount)) {
				$this->view->generalAccount	=  $generalLedger; 
			} else {
				$this->view->generalAccount	=  array(); 
			}*/

			//echo '<pre>'; print_r($accountLedger[2]); echo '</pre>';

			foreach ($accountLedger as $key => $ledger) {
				usort($accountLedger[$key], $this->make_comparer('date'));
			}

			$this->view->accountLedger	=  $accountLedger; 
			//echo '<pre>'; print_r($this->view->accountLedger); echo '</pre>';
			//echo '<pre>'; print_r($this->view->generalAccount); echo '</pre>';

			
		}
    }



    public function accountTransactionsAction() {
		if(!Zend_Session::namespaceIsset('sess_login')) {
		   $this->_redirect('index');
		} else {
			$accountLedger  = array();
			$accountId      = array();
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
				$from 		  = $current_year;
			$to = date('Y-m-d');
			if($this->_request->isPost()) {
				$postArray  = $this->getRequest()->getPost();
				$from = date('Y-m-d',strtotime($postArray['from_date']));
				$to = date('Y-m-d',strtotime($postArray['to_date']));
				$this->view->currentAccount = $postArray['account'];

				if($this->view->currentAccount==2 || $this->view->currentAccount==7 || $this->view->currentAccount==8 || $this->view->currentAccount==11) {
								
					$incomeAccountIncome  = $this->report->getGeneralIncomeAccountGl($from,$to);
					$incomeAccountInvoice = $this->report->getGeneralInvoiceIncomeAccountGl($from,$to);
					$incomeAccountCredit  = $this->report->getGeneralCreditAccountGl($from,$to);
					$expenseAccount  = $this->report->getGeneralExpenseAccountGl($from,$to);
					$journalAccount  = $this->report->getGeneralJournalAccountGl($from,$to);

					$incomeAccountIncomePay  = $this->report->getGeneralIncomePayAccountGl($from,$to);
					$expenseAccountPay  =  $this->report->getExpensePayAccountGl($from,$to);
					$incomeAccountInvoicePay  =  $this->report->getInvoicePayAccountGl($from,$to);

				} else {

					$incomeAccountIncome  = $this->report->getGeneralIncomeAccountTransaction($from,$to,$postArray['account']);
					$incomeAccountInvoice = $this->report->getGeneralInvoiceIncomeAccountTransaction($from,$to,$postArray['account']);
					$incomeAccountCredit  = $this->report->getGeneralCreditAccountTransaction($from,$to,$postArray['account']);
					$expenseAccount  = $this->report->getGeneralExpenseAccountTransaction($from,$to,$postArray['account']);
					$journalAccount  = $this->report->getGeneralJournalAccountTransaction($from,$to,$postArray['account']);

					$incomeAccountIncomePay  = $this->report->getGeneralIncomePayAccountTransaction($from,$to,$postArray['account']);
					$expenseAccountPay  =  $this->report->getExpensePayAccountTransaction($from,$to,$postArray['account']);
					$incomeAccountInvoicePay  =  $this->report->getInvoicePayAccountTransaction($from,$to,$postArray['account']);

				}

				//echo '<pre>'; print_r($incomeAccountInvoicePay); echo '</pre>';


			$accountId['income'][] = 'NULL';
			if(isset($incomeAccountIncome) && !empty($incomeAccountIncome)) {
				foreach ($incomeAccountIncome as $income) {
					$accountId['income'][] = $income['inc_id'];
					$tax_amount = ($income['amount'] * $income['tax_value'] / 100);
					$total_income = $income['amount']+$tax_amount;	
					if($income['transaction_currency']!='SGD') {
						$converted_amount = $income['amount']*$income['exchange_rate'];
						$whole_amount	  = $total_income*$income['exchange_rate'];
						if($tax_amount!=0) {
							$total_tax = $tax_amount*$income['exchange_rate'];
						} else {
							$total_tax = 0;
						}
						/*if($income['pay_status']==1 && $income['final_payment_date'] <= $to) {
							$accountLedger[2][$income['income_no']]['account_type']  = 2;
							$accountLedger[2][$income['income_no']]['no']  		     = $income['income_no'];
							$accountLedger[2][$income['income_no']]['type']  		 = "Income";
							$accountLedger[2][$income['income_no']]['name'] 		 = $income['customer_name'];
							$accountLedger[2][$income['income_no']]['date'] 		 = $income['final_payment_date'];
							$accountLedger[2][$income['income_no']]['transaction']   = $income['transaction_description'];
							$accountLedger[2][$income['income_no']]['transaction2']   = $income['transaction_description'];
							$accountLedger[2][$income['income_no']]['debit_amount']   = round($whole_amount,2);
							$accountLedger[2][$income['income_no']]['credit_amount']  = 0.00;
						}*/
					} else {
						$converted_amount = $income['amount'];
						$whole_amount	  = $total_income;
						if($tax_amount!=0) {
							$total_tax = $tax_amount;
						} else {
							$total_tax = 0;
						}
					}

					$incomes[$income['income_no']]['tax_value'] = $income['tax_value'];
					

						$accountLedger[$income['fkincome_type']][$income['income_no']]['account_type']  = $income['fkincome_type'];
						$accountLedger[$income['fkincome_type']][$income['income_no']]['no']  		    = $income['income_no'];
						$accountLedger[$income['fkincome_type']][$income['income_no']]['type']  		= "Income";
						$accountLedger[$income['fkincome_type']][$income['income_no']]['name'] 		    = $income['customer_name'];
						$accountLedger[$income['fkincome_type']][$income['income_no']]['date'] 		    = $income['date'];
						$accountLedger[$income['fkincome_type']][$income['income_no']]['transaction']   = $income['transaction_description'];
						$accountLedger[$income['fkincome_type']][$income['income_no']]['transaction2']   = $income['transaction_description'];
						$accountLedger[$income['fkincome_type']][$income['income_no']]['credit_amount'] = $converted_amount;
						$accountLedger[$income['fkincome_type']][$income['income_no']]['debit_amount']  = 0.00;

						if($total_tax!=0) {
							$accountLedger[11][$income['income_no']]['account_type']  = 11;
							$accountLedger[11][$income['income_no']]['no']  		  = $income['income_no'];
							$accountLedger[11][$income['income_no']]['type']  		  = "Income";
							$accountLedger[11][$income['income_no']]['name'] 		  = $income['customer_name'];
							$accountLedger[11][$income['income_no']]['date'] 		  = $income['date'];
							$accountLedger[11][$income['income_no']]['transaction']   = $income['transaction_description'];
							$accountLedger[11][$income['income_no']]['transaction2']   = $income['transaction_description'];
							$accountLedger[11][$income['income_no']]['credit_amount'] = $total_tax;
							$accountLedger[11][$income['income_no']]['debit_amount']  = 0.00;
						}


						if($income['credit_term']!=1) {
							$accountLedger[$income['coa_link']][$income['income_no']]['account_type']   = $income['coa_link'];
							$accountLedger[$income['coa_link']][$income['income_no']]['no']   		    = $income['income_no'];
							$accountLedger[$income['coa_link']][$income['income_no']]['type']  		    = "Income";
							$accountLedger[$income['coa_link']][$income['income_no']]['name'] 		    = $income['customer_name'];
							$accountLedger[$income['coa_link']][$income['income_no']]['date'] 		    = $income['date'];
							$accountLedger[$income['coa_link']][$income['income_no']]['transaction']    = $income['transaction_description'];
							$accountLedger[$income['coa_link']][$income['income_no']]['transaction2']    = $income['transaction_description'];
							$accountLedger[$income['coa_link']][$income['income_no']]['debit_amount']   = $whole_amount;
							$accountLedger[$income['coa_link']][$income['income_no']]['credit_amount']  = 0.00;	
						}

				}
			}

			

			$accountId['invoice'][] = 'NULL';
			if(isset($incomeAccountInvoice) && !empty($incomeAccountInvoice)) {
				foreach ($incomeAccountInvoice as $invoice) {
					$accountId['invoice'][] = $invoice['inv_id'];
					$amount = ($invoice['unit_price'] * $invoice['quantity'] - $invoice['discount_amount']);
					$tax_amount = ($amount * $invoice['tax_value'] / 100);
					$total_income = $amount+$tax_amount;
					if($invoice['transaction_currency']!='SGD') {
						$converted_amount = $amount*$invoice['exchange_rate'];
						$whole_amount	  = $total_income*$invoice['exchange_rate'];
						if($tax_amount!=0) {
							$total_tax = $tax_amount*$invoice['exchange_rate'];
						} else {
							$total_tax = 0;
						}
						if($invoice['discount_amount']!=0) {
							$discount_amount = $invoice['discount_amount']*$invoice['exchange_rate'];
						} else {
							$discount_amount = 0;
						}
						/*if($invoice['pay_status']==1 && $invoice['final_payment_date'] <= $to && !isset($accountLedger[2][$invoice['invoice_no']])) {
							$accountLedger[2][$invoice['invoice_no']]['account_type']    = 2;
							$accountLedger[2][$invoice['invoice_no']]['no'] 			 = $invoice['invoice_no'];
							$accountLedger[2][$invoice['invoice_no']]['type'] 		     = "Invoice";
							$accountLedger[2][$invoice['invoice_no']]['name'] 	  	     = $invoice['customer_name'];
							$accountLedger[2][$invoice['invoice_no']]['date'] 		     = $invoice['final_payment_date'];
							$accountLedger[2][$invoice['invoice_no']]['transaction'] 	 = $invoice['name'];
							$accountLedger[2][$invoice['invoice_no']]['transaction2'] 	 = $invoice['description'];
							$accountLedger[2][$invoice['invoice_no']]['debit_amount']    = $whole_amount;
							$accountLedger[2][$invoice['invoice_no']]['credit_amount']    = 0.00;
						} else if($invoice['pay_status']==1 && $invoice['final_payment_date'] <= $to && isset($accountLedger[2][$invoice['invoice_no']])) {
							$accountLedger[2][$invoice['invoice_no']]['debit_amount']    += $whole_amount;
						}*/
					} else {
						$converted_amount = $amount;
						$whole_amount	  = $total_income;
						if($tax_amount!=0) {
							$total_tax = $tax_amount;
						} else {
							$total_tax = 0;
						}
						/*if($invoice['discount_amount']!=0) {
							$discount_amount = $invoice['discount_amount'];
						} else {
							$discount_amount = 0;
						}*/
					}
					if(!isset($invoices[$invoice['invoice_no']]['tax_value'])) {
						$invoices[$invoice['invoice_no']]['tax_value'] = $invoice['tax_value'];
					}

						$invoice_id = $invoice['invoice_no']."_".$invoice['pid'];
						$accountLedger[$invoice['fkincomeaccount_id']][$invoice_id]['account_type']   = $invoice['fkincomeaccount_id'];
						$accountLedger[$invoice['fkincomeaccount_id']][$invoice_id]['no'] 			  = $invoice['invoice_no'];
						$accountLedger[$invoice['fkincomeaccount_id']][$invoice_id]['type'] 		  = "Invoice";
						$accountLedger[$invoice['fkincomeaccount_id']][$invoice_id]['name'] 	  	  = $invoice['customer_name'];
						$accountLedger[$invoice['fkincomeaccount_id']][$invoice_id]['date'] 		  = $invoice['date'];
						$accountLedger[$invoice['fkincomeaccount_id']][$invoice_id]['transaction'] 	  = $invoice['name'];
						$accountLedger[$invoice['fkincomeaccount_id']][$invoice_id]['transaction2']   = $invoice['description'];
						$accountLedger[$invoice['fkincomeaccount_id']][$invoice_id]['credit_amount']  = $converted_amount;
						$accountLedger[$invoice['fkincomeaccount_id']][$invoice_id]['debit_amount']   = 0.00;

						if($total_tax!=0) {
							if(!isset($accountLedger[11][$invoice['invoice_no']])) {
								$accountLedger[11][$invoice['invoice_no']]['account_type']      = 11;
								$accountLedger[11][$invoice['invoice_no']]['no'] 			    = $invoice['invoice_no'];
								$accountLedger[11][$invoice['invoice_no']]['type'] 		  		= "Invoice";
								$accountLedger[11][$invoice['invoice_no']]['name'] 	  	  		= $invoice['customer_name'];
								$accountLedger[11][$invoice['invoice_no']]['date'] 		  		= $invoice['date'];
								$accountLedger[11][$invoice['invoice_no']]['transaction'] 	  	= $invoice['name'];
								$accountLedger[11][$invoice['invoice_no']]['transaction2'] 	  	= $invoice['description'];
								$accountLedger[11][$invoice['invoice_no']]['credit_amount']  	= $total_tax;
								$accountLedger[11][$invoice['invoice_no']]['debit_amount']   	= 0.00;
							} else {
								$accountLedger[11][$invoice['invoice_no']]['credit_amount']  	+= $total_tax;
								$accountLedger[11][$invoice['invoice_no']]['debit_amount']   	 = 0.00;
							}
						}

						/*if($discount_amount!=0) {
							if(!isset($accountLedger[7][$invoice['invoice_no']])) {
								$accountLedger[7][$invoice['invoice_no']]['account_type']       = 7;
								$accountLedger[7][$invoice['invoice_no']]['no'] 			    = $invoice['invoice_no'];
								$accountLedger[7][$invoice['invoice_no']]['type'] 		  		= "Invoice";
								$accountLedger[7][$invoice['invoice_no']]['name'] 	  	  		= $invoice['customer_name'];
								$accountLedger[7][$invoice['invoice_no']]['date'] 		  		= $invoice['date'];
								$accountLedger[7][$invoice['invoice_no']]['transaction'] 	  	= $invoice['name'];
								$accountLedger[7][$invoice['invoice_no']]['debit_amount']  	    = $discount_amount;
								$accountLedger[7][$invoice['invoice_no']]['credit_amount']   	= 0.00;
							} else {
								$accountLedger[7][$invoice['invoice_no']]['debit_amount']  	    += $discount_amount;
								$accountLedger[7][$invoice['invoice_no']]['credit_amount']   	 = 0.00;
							}
						}*/

						$accountLedger[$invoice['fkincomeaccount_id']][$invoice_id]['account_type']   = $invoice['fkincomeaccount_id'];
						$accountLedger[$invoice['fkincomeaccount_id']][$invoice_id]['no'] 			  = $invoice['invoice_no'];
						$accountLedger[$invoice['fkincomeaccount_id']][$invoice_id]['type'] 		  = "Invoice";
						$accountLedger[$invoice['fkincomeaccount_id']][$invoice_id]['name'] 	  	  = $invoice['customer_name'];
						$accountLedger[$invoice['fkincomeaccount_id']][$invoice_id]['date'] 		  = $invoice['date'];
						$accountLedger[$invoice['fkincomeaccount_id']][$invoice_id]['transaction'] 	  = $invoice['name'];
						$accountLedger[$invoice['fkincomeaccount_id']][$invoice_id]['transaction2']   = $invoice['description'];
						$accountLedger[$invoice['fkincomeaccount_id']][$invoice_id]['credit_amount']  = $converted_amount;
						$accountLedger[$invoice['fkincomeaccount_id']][$invoice_id]['debit_amount']   = 0.00;

						if($invoice['credit_term']!=1) {
							if(!isset($accountLedger[$invoice['coa_link']][$invoice['invoice_no']])) {
								$accountLedger[$invoice['coa_link']][$invoice['invoice_no']]['account_type']    = $invoice['coa_link'];
								$accountLedger[$invoice['coa_link']][$invoice['invoice_no']]['no']   		    = $invoice['invoice_no'];
								$accountLedger[$invoice['coa_link']][$invoice['invoice_no']]['type']  		    = "Invoice";
								$accountLedger[$invoice['coa_link']][$invoice['invoice_no']]['name'] 		    = $invoice['customer_name'];
								$accountLedger[$invoice['coa_link']][$invoice['invoice_no']]['date'] 		    = $invoice['date'];
								$accountLedger[$invoice['coa_link']][$invoice['invoice_no']]['transaction']     = $invoice['name'];
								$accountLedger[$invoice['coa_link']][$invoice['invoice_no']]['transaction2']    = $invoice['description'];
								$accountLedger[$invoice['coa_link']][$invoice['invoice_no']]['debit_amount']    = $whole_amount;
								$accountLedger[$invoice['coa_link']][$invoice['invoice_no']]['credit_amount']   = 0.00;	
							} else {
								$accountLedger[$invoice['coa_link']][$invoice['invoice_no']]['debit_amount']    += $whole_amount;
								$accountLedger[$invoice['coa_link']][$invoice['invoice_no']]['credit_amount']    = 0.00;	
							}
						}
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
						if($tax_amount!=0) {
							$total_tax = $tax_amount*$credit['exchange_rate'];
						} else {
							$total_tax = 0;
						}
						if($credit['discount_amount']!=0) {
							$discount_amount = $credit['discount_amount']*$credit['exchange_rate'];
						} else {
							$discount_amount = 0;
						}
					} else {
						$converted_amount = $amount;
						$whole_amount 	  = $total_income;
						if($tax_amount!=0) {
							$total_tax = $tax_amount;
						} else {
							$total_tax = 0;
						}
						/*if($credit['discount_amount']!=0) {
							$discount_amount = $credit['discount_amount'];
						} else {
							$discount_amount = 0;
						}*/
					}

					if(isset($accountLedger[2][$credit['invoice_no']])) {
						$credits = $accountLedger[2][$invoice['invoice_no']]['debit_amount'] - $whole_amount;
						$accountLedger[2][$invoice['invoice_no']]['debit_amount'] = round($credits,2); 
					}
					

						//$credit_id = $credit['credit_no']."_".$credit['invoice_no']."_".$credit['pid'];
					$credit_id = $credit['credit_no']."_".$credit['invoice_no']."_".$credit['pid'];
						$accountLedger[$credit['fkincomeaccount_id']][$credit_id]['account_type'] 	= $credit['fkincomeaccount_id'];
						$accountLedger[$credit['fkincomeaccount_id']][$credit_id]['no'] 			= $credit['credit_no'];
						$accountLedger[$credit['fkincomeaccount_id']][$credit_id]['type'] 			= "Credit Note";
						$accountLedger[$credit['fkincomeaccount_id']][$credit_id]['date']			= $credit['date'];
						$accountLedger[$credit['fkincomeaccount_id']][$credit_id]['name'] 		    = $credit['customer_name'];
						$accountLedger[$credit['fkincomeaccount_id']][$credit_id]['transaction'] 	= $credit['name'];
						$accountLedger[$credit['fkincomeaccount_id']][$credit_id]['transaction2'] 	= $credit['description'];
						$accountLedger[$credit['fkincomeaccount_id']][$credit_id]['credit_amount'] 	= 0.00;
						$accountLedger[$credit['fkincomeaccount_id']][$credit_id]['debit_amount'] 	= $converted_amount;

						/*if($discount_amount!=0) {
							if(!isset($accountLedger[7][$credit['credit_no']])) { 
								$accountLedger[7][$credit['credit_no']]['account_type'] 	= 7;
								$accountLedger[7][$credit['credit_no']]['no'] 				= $credit['credit_no'];
								$accountLedger[7][$credit['credit_no']]['type'] 			= "Credit Note";
								$accountLedger[7][$credit['credit_no']]['date']			    = $credit['date'];
								$accountLedger[7][$credit['credit_no']]['name'] 		    = $credit['customer_name'];
								$accountLedger[7][$credit['credit_no']]['transaction']   	= $credit['name'];
								$accountLedger[7][$credit['credit_no']]['debit_amount']     = 0.00;
								$accountLedger[7][$credit['credit_no']]['credit_amount'] 	= $discount_amount;
							} else {
								$accountLedger[7][$credit['credit_no']]['debit_amount']      = 0.00;
								$accountLedger[7][$credit['credit_no']]['credit_amount'] 	+= $discount_amount;
							}
						}*/

						if($total_tax!=0) {
							if(!isset($accountLedger[11][$credit['credit_no']])) { 
								$accountLedger[11][$credit['credit_no']]['account_type'] 	= 11;
								$accountLedger[11][$credit['credit_no']]['no'] 				= $credit['credit_no'];
								$accountLedger[11][$credit['credit_no']]['type'] 			= "Credit Note";
								$accountLedger[11][$credit['credit_no']]['date']			= $credit['date'];
								$accountLedger[11][$credit['credit_no']]['name'] 		    = $credit['customer_name'];
								$accountLedger[11][$credit['credit_no']]['transaction'] 	= $credit['name'];
								$accountLedger[11][$credit['credit_no']]['transaction2'] 	= $credit['description'];
								$accountLedger[11][$credit['credit_no']]['credit_amount']   = 0.00;
								$accountLedger[11][$credit['credit_no']]['debit_amount'] 	= $total_tax;
							} else {
								$accountLedger[11][$credit['credit_no']]['credit_amount']    = 0.00;
								$accountLedger[11][$credit['credit_no']]['debit_amount'] 	+= $total_tax;
							}
						}

						if(!isset($accountLedger[$credit['coa_link']][$credit_id])) {
								$accountLedger[$credit['coa_link']][$credit_id]['account_type']     = $credit['coa_link'];
								$accountLedger[$credit['coa_link']][$credit_id]['no']   		      = $credit['credit_no'];
								$accountLedger[$credit['coa_link']][$credit_id]['type']  		      = "Credit Note";
								$accountLedger[$credit['coa_link']][$credit_id]['name'] 		      = $credit['customer_name'];
								$accountLedger[$credit['coa_link']][$credit_id]['date'] 		      = $credit['date'];
								$accountLedger[$credit['coa_link']][$credit_id]['transaction']      = $credit['name'];
								$accountLedger[$credit['coa_link']][$credit_id]['transaction2']     = $credit['description'];
								$accountLedger[$credit['coa_link']][$credit_id]['credit_amount']    = $whole_amount;
								$accountLedger[$credit['coa_link']][$credit_id]['debit_amount']     = 0.00;	
						} else {
								$accountLedger[$credit['coa_link']][$credit_id]['credit_amount']    += $whole_amount;
								$accountLedger[$credit['coa_link']][$credit_id]['debit_amount']      = 0.00;	
						}
				}
			}

			

            

			$accountId['expense'][] = 'NULL';
			if(isset($expenseAccount) && !empty($expenseAccount)) {
				foreach ($expenseAccount as $expense) {
					$accountId['expense'][] = $expense['exp_id'];
					$amount = ($expense['unit_price'] * $expense['quantity']);
					if($expense['total_gst']!=0.00) {
						$tax_amount = $expense['total_gst'];
					} else {
						$tax_amount = ($amount * $expense['tax_value'] / 100);
					}
					
					$total_income = $amount + $tax_amount;
					if($expense['transaction_currency']!='SGD') {
						$converted_amount = $amount*$expense['exchange_rate'];
						if($expense['total_gst']!=0.00) {
							$whole_amount 	  = ($amount*$expense['exchange_rate'])+$expense['total_gst'];
						} else {
							$whole_amount 	  = $total_income*$expense['exchange_rate'];
						}
						if($tax_amount!=0) {
							if($expense['total_gst']!=0.00) {
								$total_tax = $expense['total_gst'];
							} else {
								$total_tax = $tax_amount*$expense['exchange_rate'];
							}
						} else {
							$total_tax = 0;
						}

						/*if($expense['pay_status']==1 && $expense['final_payment_date'] <= $to && !isset($accountLedger[2][$expense['expense_no']])) {
							$accountLedger[2][$expense['expense_no']]['account_type']    = 2;
							$accountLedger[2][$expense['expense_no']]['no'] 			 = $expense['expense_no'];
							$accountLedger[2][$expense['expense_no']]['type'] 		     = "Expense";
							$accountLedger[2][$expense['expense_no']]['name'] 	  	     = $expense['vendor_name'];
							$accountLedger[2][$expense['expense_no']]['date'] 		     = $expense['final_payment_date'];
							$accountLedger[2][$expense['expense_no']]['transaction'] 	 = $expense['product_id'];
							$accountLedger[2][$expense['expense_no']]['transaction2'] 	 = $expense['product_description'];
							$accountLedger[2][$expense['expense_no']]['credit_amount']   = round($whole_amount,2);
							$accountLedger[2][$expense['expense_no']]['debit_amount']    = 0.00;
						} else if($expense['pay_status']==1 && $expense['final_payment_date'] <= $to && isset($accountLedger[2][$expense['expense_no']])) {
							$accountLedger[2][$expense['expense_no']]['credit_amount']   += round($whole_amount,2);
						}*/
					} else {
						$converted_amount = $amount;
						$whole_amount     = $total_income;
						if($tax_amount!=0) {
							$total_tax = $tax_amount;
						} else {
							$total_tax = 0;
						}
					}

					if(!isset($expenses[$expense['expense_no']]['tax_value'])) {
						$expenses[$expense['expense_no']]['tax_value'] = $expense['tax_value'];
					}

					$expense_id = $expense['expense_no']."_".$expense['pid'];
					$accountLedger[$expense['fkexpense_type']][$expense_id]['account_type']  = $expense['fkexpense_type'];
					$accountLedger[$expense['fkexpense_type']][$expense_id]['no'] 			 = $expense['expense_no'];
					$accountLedger[$expense['fkexpense_type']][$expense_id]['type'] 		 = "Expense";
					$accountLedger[$expense['fkexpense_type']][$expense_id]['date'] 		 = $expense['date'];
					$accountLedger[$expense['fkexpense_type']][$expense_id]['name'] 		 = $expense['vendor_name'];
					$accountLedger[$expense['fkexpense_type']][$expense_id]['transaction']   = $expense['product_id'];
					$accountLedger[$expense['fkexpense_type']][$expense_id]['transaction2']  = $expense['product_description'];
					$accountLedger[$expense['fkexpense_type']][$expense_id]['credit_amount'] = 0.00;
					$accountLedger[$expense['fkexpense_type']][$expense_id]['debit_amount']  = $converted_amount;

					if($total_tax!=0) {
						if(!isset($accountLedger[11][$expense['expense_no']])) { 
							$accountLedger[11][$expense['expense_no']]['account_type']   = 11;
							$accountLedger[11][$expense['expense_no']]['no'] 			 = $expense['expense_no'];
							$accountLedger[11][$expense['expense_no']]['type'] 		 	 = "Expense";
							$accountLedger[11][$expense['expense_no']]['date'] 		 	 = $expense['date'];
							$accountLedger[11][$expense['expense_no']]['name'] 		     = $expense['vendor_name'];
							$accountLedger[11][$expense['expense_no']]['transaction']    = $expense['product_id'];
							$accountLedger[11][$expense['expense_no']]['transaction2']   = $expense['product_description'];
							$accountLedger[11][$expense['expense_no']]['credit_amount']  = 0.00;
							$accountLedger[11][$expense['expense_no']]['debit_amount']   = $total_tax;
						} else {
							$accountLedger[11][$expense['expense_no']]['credit_amount']   = 0.00;
							$accountLedger[11][$expense['expense_no']]['debit_amount']   += $total_tax;
						}
					}

					if($expense['credit_term']!=1) {
						if(!isset($accountLedger[$expense['coa_link']][$expense['expense_no']])) {
							$accountLedger[$expense['coa_link']][$expense['expense_no']]['account_type']    = $expense['coa_link'];
							$accountLedger[$expense['coa_link']][$expense['expense_no']]['no']   		    = $expense['expense_no'];
							$accountLedger[$expense['coa_link']][$expense['expense_no']]['type']  		    = "Expense";
							$accountLedger[$expense['coa_link']][$expense['expense_no']]['name'] 		    = $expense['vendor_name'];
							$accountLedger[$expense['coa_link']][$expense['expense_no']]['date'] 		    = $expense['date'];
							$accountLedger[$expense['coa_link']][$expense['expense_no']]['transaction']     = $expense['product_id'];
							$accountLedger[$expense['coa_link']][$expense['expense_no']]['transaction2']     = $expense['product_description'];
							$accountLedger[$expense['coa_link']][$expense['expense_no']]['debit_amount']    = 0.00;
							$accountLedger[$expense['coa_link']][$expense['expense_no']]['credit_amount']   = $whole_amount;	
						} else {
							$accountLedger[$expense['coa_link']][$expense['expense_no']]['debit_amount']     += 0.00;
							$accountLedger[$expense['coa_link']][$expense['expense_no']]['credit_amount']    += $whole_amount;	
						}
					}
				}
			}




			$accountId['income_pay'][] = 'NULL';
			$accountId['income_paid'][] = 'NULL';
			if(isset($incomeAccountIncomePay) && !empty($incomeAccountIncomePay)) {
				foreach ($incomeAccountIncomePay as $incPayment) {
						$accountId['income_pay'][] = $incPayment['inc_id'];
						$amount = $incPayment['payment_amount']+$incPayment['discount_amount'];
						
						/*if($incPayment['pay_status']==1 && $incPayment['transaction_currency']!='SGD') {
							if(isset($accountLedger[2][$incPayment['income_no']])) {
								$accountLedger[2][$incPayment['income_no']]['debit_amount'] -= $incPayment['payment_amount'];
							} else {
								$accountLedger[2][$incPayment['income_no']]['account_type']  = $incPayment['fkpayment_account'];
								$accountLedger[2][$incPayment['income_no']]['no'] 			  = "PMT".$incPayment['id'];
								$accountLedger[2][$incPayment['income_no']]['type'] 		  = "Payment";
								$accountLedger[2][$incPayment['income_no']]['date'] 		  = $incPayment['pay_date'];
								$accountLedger[2][$incPayment['income_no']]['name'] 		  = $incPayment['customer_name'];
								$accountLedger[2][$incPayment['income_no']]['transaction']   = "Payment for Income No ".$incPayment['income_no'];
								$accountLedger[2][$incPayment['income_no']]['transaction2']  = $incPayment['payment_description'];
								$accountLedger[2][$incPayment['income_no']]['credit_amount'] = 0.00;
								$accountLedger[2][$incPayment['income_no']]['debit_amount']  = $incPayment['payment_amount'];
							}
						}*/

					$payId = $incPayment['id']."_".$incPayment['income_no']."_pay";
					$entryId = $incPayment['id']."_".$incPayment['income_no']."_payentry";
					$accountLedger[$incPayment['fkpayment_account']][$payId]['account_type']  = $incPayment['fkpayment_account'];
					$accountLedger[$incPayment['fkpayment_account']][$payId]['no'] 			  = "PMT".$incPayment['id'];
					$accountLedger[$incPayment['fkpayment_account']][$payId]['type'] 		  = "Payment";
					$accountLedger[$incPayment['fkpayment_account']][$payId]['date'] 		  = $incPayment['pay_date'];
					$accountLedger[$incPayment['fkpayment_account']][$payId]['name'] 		  = $incPayment['customer_name'];
					$accountLedger[$incPayment['fkpayment_account']][$payId]['transaction']   = "Payment for Income No ".$incPayment['income_no'];
					$accountLedger[$incPayment['fkpayment_account']][$payId]['transaction2']   = $incPayment['payment_description'];
					$accountLedger[$incPayment['fkpayment_account']][$payId]['credit_amount'] = 0.00;
					$accountLedger[$incPayment['fkpayment_account']][$payId]['debit_amount']  = $incPayment['payment_amount'];

					if($incPayment['discount_amount']!=0) {

						if(isset($incPayment['tax_value']) && $incPayment['tax_value']!=0) {
							$tax_pay = (($incPayment['discount_amount'] * $incPayment['tax_value']) / (100+$incPayment['tax_value']));
							$discount_amount = $incPayment['discount_amount'] - $tax_pay;

							$accountLedger[11][$payId]['account_type']  = 11;
							$accountLedger[11][$payId]['no'] 		   = "PMT".$incPayment['id'];
							$accountLedger[11][$payId]['type'] 		   = "Payment";
							$accountLedger[11][$payId]['date'] 		   = $incPayment['pay_date'];
							$accountLedger[11][$payId]['name'] 		   = $incPayment['customer_name'];
							$accountLedger[11][$payId]['transaction']   = "Payment for Income No ".$incPayment['income_no'];
							$accountLedger[11][$payId]['transaction2']   = $incPayment['payment_description'];
							$accountLedger[11][$payId]['credit_amount'] = 0.00;
							$accountLedger[11][$payId]['debit_amount']  = $tax_pay;
						} else {
							$discount_amount = $incPayment['discount_amount'];
						}

						$accountLedger[7][$payId]['account_type']  = 7;
						$accountLedger[7][$payId]['no'] 		   = "PMT".$incPayment['id'];
						$accountLedger[7][$payId]['type'] 		   = "Payment";
						$accountLedger[7][$payId]['date'] 		   = $incPayment['pay_date'];
						$accountLedger[7][$payId]['name'] 		   = $incPayment['customer_name'];
						$accountLedger[7][$payId]['transaction']   = "Payment for Income No ".$incPayment['income_no'];
						$accountLedger[7][$payId]['transaction2']   = $incPayment['payment_description'];
						$accountLedger[7][$payId]['credit_amount'] = 0.00;
						$accountLedger[7][$payId]['debit_amount']  = $discount_amount;

					}

					if($incPayment['credit_term']!=1) {

							$accountLedger[$incPayment['coa_link']][$payId]['account_type']    = $incPayment['coa_link'];
							$accountLedger[$incPayment['coa_link']][$payId]['no']   		   = "PMT".$incPayment['id'];
							$accountLedger[$incPayment['coa_link']][$payId]['type']  		   = "Payment";
							$accountLedger[$incPayment['coa_link']][$payId]['name'] 		   = $incPayment['customer_name'];
							$accountLedger[$incPayment['coa_link']][$payId]['date'] 		   = $incPayment['pay_date'];
							$accountLedger[$incPayment['coa_link']][$payId]['transaction']     = "Payment for Income No ".$incPayment['income_no'];
							$accountLedger[$incPayment['coa_link']][$payId]['transaction2']    = $incPayment['payment_description'];
							/*$accountLedger[$incPayment['coa_link']][$payId]['debit_amount']    = 0.00;
							$accountLedger[$incPayment['coa_link']][$payId]['credit_amount']   = $amount;*/	

							if($incPayment['pay_status']==1 && ($incPayment['final_payment_date'] == $incPayment['pay_date'])) {

								if(isset($accountLedger[$incPayment['coa_link']][$incPayment['income_no']])) {
									$debit_amount   = $accountLedger[$incPayment['coa_link']][$incPayment['income_no']]['debit_amount'];
								} else {
									$receivable = $this->report->getIncomeReceivables($incPayment['inc_id']);
									if(isset($receivable) && !empty($receivable)) {
										foreach ($receivable as $receive) {
											if($incPayment['transaction_currency']!='SGD') {
												$amt = $receive['amount']*$incPayment['exchange_rate'];
											} else {
												$amt = $receive['amount'];
											}
											$debit_amount = round($amt,2);
										}
									} else {
										$debit_amount = 0.00;
									}
								}
								$credit_amount  = 0.00;

								foreach ($accountLedger as $key => $value) {
									foreach ($value as $key1 => $value1) {
										$split = explode("_", $key1);
										if(isset($split[1]) && !empty($split[1]) && $split[1]==$incPayment['income_no']) {
											if(isset($value1['credit_amount'])) {
										    	$credit_amount += $value1['credit_amount'];
											}
										}
									}
								}

								if($debit_amount==0 && $credit_amount==0) {

									$accountLedger[$incPayment['coa_link']][$payId]['credit_amount']   = $amount;
									$accountLedger[$incPayment['coa_link']][$payId]['debit_amount']    = 0.00;

								} else {

									$total_amt = $debit_amount - $credit_amount;

									$accountLedger[$incPayment['coa_link']][$payId]['credit_amount']  = $total_amt;
									$accountLedger[$incPayment['coa_link']][$payId]['debit_amount']   = 0.00;

								}

							} else {

								$accountLedger[$incPayment['coa_link']][$payId]['credit_amount']   = $amount;
								$accountLedger[$incPayment['coa_link']][$payId]['debit_amount']    = 0.00;

							}
					}
				}
			}



			$accountId['expense_pay'][] = 'NULL';
			$accountId['expense_paid'][] = 'NULL';
			if(isset($expenseAccountPay) && !empty($expenseAccountPay)) {
				foreach ($expenseAccountPay as $expPayment) {
						$accountId['expense_pay'][] = $expPayment['exp_id'];
						$amount = $expPayment['payment_amount']+$expPayment['discount_amount'];
						
						/*if($expPayment['pay_status']==1 && $expPayment['transaction_currency']!='SGD') {
							if(isset($accountLedger[2][$expPayment['expense_no']])) {
								$accountLedger[2][$expPayment['expense_no']]['credit_amount'] -= $expPayment['payment_amount'];
							} else {
								$accountLedger[2][$expPayment['expense_no']]['account_type'] = $expPayment['fkpayment_account'];
								$accountLedger[2][$expPayment['expense_no']]['no'] = "PMT".$expPayment['id'];
								$accountLedger[2][$expPayment['expense_no']]['type'] = "Payment";
								$accountLedger[2][$expPayment['expense_no']]['date'] = $expPayment['pay_date'];
								$accountLedger[2][$expPayment['expense_no']]['name'] = $expPayment['vendor_name'];
								$accountLedger[2][$expPayment['expense_no']]['transaction'] = "Payment for Expense No ".$expPayment['expense_no'];
								$accountLedger[2][$expPayment['expense_no']]['transaction2'] = $expPayment['payment_description'];
								$accountLedger[2][$expPayment['expense_no']]['credit_amount'] = $expPayment['payment_amount'];
								$accountLedger[2][$expPayment['expense_no']]['debit_amount'] = 0.00;
							}
						}*/

						/*echo $expPayment['pay_date'];
						echo $expPayment['final_payment_date'];*/

					$payId = $expPayment['id']."_".$expPayment['expense_no']."_pay";
					$entryId = $expPayment['id']."_".$expPayment['expense_no']."_payentry";
					$accountLedger[$expPayment['fkpayment_account']][$payId]['account_type'] = $expPayment['fkpayment_account'];
					$accountLedger[$expPayment['fkpayment_account']][$payId]['no'] = "PMT".$expPayment['id'];
					$accountLedger[$expPayment['fkpayment_account']][$payId]['type'] = "Payment";
					$accountLedger[$expPayment['fkpayment_account']][$payId]['date'] = $expPayment['pay_date'];
					$accountLedger[$expPayment['fkpayment_account']][$payId]['name'] = $expPayment['vendor_name'];
					$accountLedger[$expPayment['fkpayment_account']][$payId]['transaction'] = "Payment for Expense No ".$expPayment['expense_no'];
					$accountLedger[$expPayment['fkpayment_account']][$payId]['transaction2'] = $expPayment['payment_description'];
					$accountLedger[$expPayment['fkpayment_account']][$payId]['credit_amount'] = $expPayment['payment_amount'];
					$accountLedger[$expPayment['fkpayment_account']][$payId]['debit_amount'] = 0.00;

					if($expPayment['discount_amount']!=0) {

						if(isset($expPayment['tax_value']) && $expPayment['tax_value']!=0) {
							$tax_pay = (($expPayment['discount_amount'] * $expPayment['tax_value']) / (100+$expPayment['tax_value']));
							$discount_amount = $expPayment['discount_amount'] - $tax_pay;

							$accountLedger[11][$payId]['account_type']  = 11;
							$accountLedger[11][$payId]['no'] 		   = "PMT".$expPayment['id'];
							$accountLedger[11][$payId]['type'] 		   = "Payment";
							$accountLedger[11][$payId]['date'] 		   = $expPayment['pay_date'];
							$accountLedger[11][$payId]['name'] 		   = $expPayment['vendor_name'];
							$accountLedger[11][$payId]['transaction']   = "Payment for Expense No ".$expPayment['expense_no'];
							$accountLedger[11][$payId]['transaction2']  = $expPayment['payment_description'];
							$accountLedger[11][$payId]['debit_amount']  = 0.00;
							$accountLedger[11][$payId]['credit_amount']  = $tax_pay;
						} else {
							$discount_amount = $expPayment['discount_amount'];
						}

						$accountLedger[8][$payId]['account_type']  = 8;
						$accountLedger[8][$payId]['no'] 		   = "PMT".$expPayment['id'];
						$accountLedger[8][$payId]['type'] 		   = "Payment";
						$accountLedger[8][$payId]['date'] 		   = $expPayment['pay_date'];
						$accountLedger[8][$payId]['name'] 		   = $expPayment['vendor_name'];
						$accountLedger[8][$payId]['transaction']   = "Payment for Expense No ".$expPayment['expense_no'];
						$accountLedger[8][$payId]['transaction2']  = $expPayment['payment_description'];
						$accountLedger[8][$payId]['debit_amount']  = 0.00;
						$accountLedger[8][$payId]['credit_amount'] = $discount_amount;
								
					}

					if($expPayment['credit_term']!=1) {

							$accountLedger[$expPayment['coa_link']][$payId]['account_type']    = $expPayment['coa_link'];
							$accountLedger[$expPayment['coa_link']][$payId]['no']   		   = "PMT".$expPayment['id'];
							$accountLedger[$expPayment['coa_link']][$payId]['type']  		   = "Payment";
							$accountLedger[$expPayment['coa_link']][$payId]['name'] 		   = $expPayment['vendor_name'];
							$accountLedger[$expPayment['coa_link']][$payId]['date'] 		   = $expPayment['pay_date'];
							$accountLedger[$expPayment['coa_link']][$payId]['transaction']     = "Payment for Expense No ".$expPayment['expense_no'];
							$accountLedger[$expPayment['coa_link']][$payId]['transaction2']     = $expPayment['payment_description'];


							if($expPayment['pay_status']==1 && ($expPayment['final_payment_date'] == $expPayment['pay_date'])) {

								if(isset($accountLedger[$expPayment['coa_link']][$expPayment['expense_no']])) {
									$credit_amount = $accountLedger[$expPayment['coa_link']][$expPayment['expense_no']]['credit_amount'];
								} else {
									$payables = $this->report->getExpensePayables($expPayment['exp_id']);
									if(isset($payables) && !empty($payables)) {
										foreach ($payables as $payable) {
											if($expPayment['transaction_currency']!='SGD') {
												if($expPayment['total_gst']!=0.00) {
													$amt = ($payable['amount']*$expPayment['exchange_rate'])+$expPayment['total_gst'];
												} else {
													$amt = $payable['amount']*$expPayment['exchange_rate'];
												}
											} else {
												$amt = $payable['amount'];
											}
											$credit_amount = round($amt,2);
										}
									} else {
										$credit_amount = 0.00;
									}
								}
								$debit_amount  = 0.00;

								foreach ($accountLedger as $key => $value) {
									foreach ($value as $key1 => $value1) {
										$split = explode("_", $key1);
										if(isset($split[1]) && !empty($split[1]) && $split[1]==$expPayment['expense_no']) {
											if(isset($value1['debit_amount'])) {
												$debit_amount += $value1['debit_amount'];
											}
										}
									}
								}

								if($debit_amount==0 && $credit_amount==0) {
									$accountLedger[$expPayment['coa_link']][$payId]['debit_amount']    = $amount;
									$accountLedger[$expPayment['coa_link']][$payId]['credit_amount']   = 0.00;

								} else {

									$total_amt = $credit_amount - $debit_amount;

									$accountLedger[$expPayment['coa_link']][$payId]['debit_amount']    = $total_amt;
									$accountLedger[$expPayment['coa_link']][$payId]['credit_amount']   = 0.00;
								}

							} else {

								$accountLedger[$expPayment['coa_link']][$payId]['debit_amount']    = $amount;
								$accountLedger[$expPayment['coa_link']][$payId]['credit_amount']   = 0.00;

							}
								
						
					}


					}
			}


			$accountId['invoice_pay'][] = 'NULL';
			$accountId['invoice_paid'][] = 'NULL';
			if(isset($incomeAccountInvoicePay) && !empty($incomeAccountInvoicePay)) {
				foreach ($incomeAccountInvoicePay as $invPayment) {
						$accountId['invoice_pay'][] = $invPayment['inv_id'];
						$amount = $invPayment['payment_amount']+$invPayment['discount_amount'];

							/*if($invPayment['pay_status']==1 && $invPayment['transaction_currency']!='SGD') {
								//echo $invPayment['payment_amount'];
								if(isset($accountLedger[2][$invPayment['invoice_no']])) {
									$accountLedger[2][$invPayment['invoice_no']]['debit_amount'] -= $invPayment['payment_amount'];
								} else {
									$accountLedger[2][$invPayment['invoice_no']]['account_type'] = $invPayment['fkpayment_account'];
									$accountLedger[2][$invPayment['invoice_no']]['no'] = "PMT".$invPayment['id'];
									$accountLedger[2][$invPayment['invoice_no']]['type'] = "Payment";
									$accountLedger[2][$invPayment['invoice_no']]['date'] = $invPayment['pay_date'];
									$accountLedger[2][$invPayment['invoice_no']]['name'] = $invPayment['customer_name'];
									$accountLedger[2][$invPayment['invoice_no']]['transaction'] = "Payment for Invoice No ".$invPayment['invoice_no'];
									$accountLedger[2][$invPayment['invoice_no']]['transaction2'] = $invPayment['payment_description'];
									$accountLedger[2][$invPayment['invoice_no']]['credit_amount'] = 0.00; 
									$accountLedger[2][$invPayment['invoice_no']]['debit_amount'] = $invPayment['payment_amount'];
								}
							}*/
					
							$payId = $invPayment['id']."_".$invPayment['invoice_no']."_pay";
							$entryId = $invPayment['id']."_".$invPayment['invoice_no']."_payentry";
							$accountLedger[$invPayment['fkpayment_account']][$payId]['account_type'] = $invPayment['fkpayment_account'];
							$accountLedger[$invPayment['fkpayment_account']][$payId]['no'] = "PMT".$invPayment['id'];
							$accountLedger[$invPayment['fkpayment_account']][$payId]['type'] = "Payment";
							$accountLedger[$invPayment['fkpayment_account']][$payId]['date'] = $invPayment['pay_date'];
							$accountLedger[$invPayment['fkpayment_account']][$payId]['name'] = $invPayment['customer_name'];
							$accountLedger[$invPayment['fkpayment_account']][$payId]['transaction'] = "Payment for Invoice No ".$invPayment['invoice_no'];
							$accountLedger[$invPayment['fkpayment_account']][$payId]['transaction2'] = $invPayment['payment_description'];
							$accountLedger[$invPayment['fkpayment_account']][$payId]['credit_amount'] = 0.00; 
							$accountLedger[$invPayment['fkpayment_account']][$payId]['debit_amount'] = $invPayment['payment_amount'];

							if($invPayment['discount_amount']!=0) {

							if(isset($invPayment['tax_value']) && $invPayment['tax_value']!=0) {
								$tax_pay = (($invPayment['discount_amount'] * $invPayment['tax_value']) / (100+$invPayment['tax_value']));
								$discount_amount = $invPayment['discount_amount'] - $tax_pay;

								$accountLedger[11][$payId]['account_type']  = 11;
								$accountLedger[11][$payId]['no'] 		   = "PMT".$invPayment['id'];
								$accountLedger[11][$payId]['type'] 		   = "Payment";
								$accountLedger[11][$payId]['date'] 		   = $invPayment['pay_date'];
								$accountLedger[11][$payId]['name'] 		   = $invPayment['customer_name'];
								$accountLedger[11][$payId]['transaction']   = "Payment for Invoice No ".$invPayment['invoice_no'];
								$accountLedger[11][$payId]['transaction2']  = $invPayment['payment_description'];
								$accountLedger[11][$payId]['credit_amount'] = 0.00;
								$accountLedger[11][$payId]['debit_amount']  = $tax_pay;
							} else {
								$discount_amount = $invPayment['discount_amount'];
							}

								$accountLedger[7][$payId]['account_type']  = 7;
								$accountLedger[7][$payId]['no'] 		   = "PMT".$invPayment['id'];
								$accountLedger[7][$payId]['type'] 		   = "Payment";
								$accountLedger[7][$payId]['date'] 		   = $invPayment['pay_date'];
								$accountLedger[7][$payId]['name'] 		   = $invPayment['customer_name'];
								$accountLedger[7][$payId]['transaction']   = "Payment for Invoice No ".$invPayment['invoice_no'];
								$accountLedger[7][$payId]['transaction2']  = $invPayment['payment_description'];
								$accountLedger[7][$payId]['credit_amount'] = 0.00;
								$accountLedger[7][$payId]['debit_amount']  = $discount_amount;
								
							}

						if($invPayment['credit_term']!=1) {

							$accountLedger[$invPayment['coa_link']][$payId]['account_type']    = $invPayment['coa_link'];
							$accountLedger[$invPayment['coa_link']][$payId]['no']   		   = "PMT".$invPayment['id'];
							$accountLedger[$invPayment['coa_link']][$payId]['type']  		   = "Payment";
							$accountLedger[$invPayment['coa_link']][$payId]['name'] 		   = $invPayment['customer_name'];
							$accountLedger[$invPayment['coa_link']][$payId]['date'] 		   = $invPayment['pay_date'];
							$accountLedger[$invPayment['coa_link']][$payId]['transaction']     = "Payment for Invoice No ".$invPayment['invoice_no'];
							$accountLedger[$invPayment['coa_link']][$payId]['transaction2']     = $invPayment['payment_description'];
							/*$accountLedger[$invPayment['coa_link']][$payId]['debit_amount']    = 0.00;
							$accountLedger[$invPayment['coa_link']][$payId]['credit_amount']   = $amount;	*/

							if($invPayment['pay_status']==1 && ($invPayment['final_payment_date'] == $invPayment['pay_date'])) {

								if(isset($accountLedger[$invPayment['coa_link']][$invPayment['invoice_no']])) {
									$debit_amount   = $accountLedger[$invPayment['coa_link']][$invPayment['invoice_no']]['debit_amount'];
								} else {
									$receivable = $this->report->getInvoiceReceivables($invPayment['inv_id']);
									if(isset($receivable) && !empty($receivable)) {
										foreach ($receivable as $receive) {
											if($invPayment['transaction_currency']!='SGD') {
												$amt = $receive['amount']*$invPayment['exchange_rate'];
											} else {
												$amt = $receive['amount'];
											}
											$debit_amount = $amt;
										}
									} else {
										$debit_amount = 0.00;
									}
								}
								$credit_amount  = 0.00;

								foreach ($accountLedger as $key => $value) {
									foreach ($value as $key1 => $value1) {
										$split = explode("_", $key1);
										if(isset($split[1]) && !empty($split[1]) && $split[1]==$invPayment['invoice_no']) {
											if(isset($value1['credit_amount'])) {
												$credit_amount += $value1['credit_amount'];
											}
										}
									}
								}

								if($debit_amount==0 && $credit_amount==0) {

									$accountLedger[$invPayment['coa_link']][$payId]['credit_amount']   = $amount;
									$accountLedger[$invPayment['coa_link']][$payId]['debit_amount']    = 0.00;

								} else {

									$total_amt = $debit_amount - $credit_amount;

									$accountLedger[$invPayment['coa_link']][$payId]['credit_amount']  = $total_amt;
									$accountLedger[$invPayment['coa_link']][$payId]['debit_amount']   = 0.00;
								}

							} else {

								$accountLedger[$invPayment['coa_link']][$payId]['credit_amount']   = $amount;
								$accountLedger[$invPayment['coa_link']][$payId]['debit_amount']    = 0.00;

							}
						
						}

					}
			}



			if(isset($journalAccount) && !empty($journalAccount)) {
				foreach ($journalAccount as $journal) {
					

					$journId = $journal['jid']."_".$journal['journal_no'];
					$accountLedger[$journal['fkaccount_id']][$journId]['account_type'] = $journal['fkaccount_id'];
					$accountLedger[$journal['fkaccount_id']][$journId]['no'] 		   = $journal['journal_no'];
					$accountLedger[$journal['fkaccount_id']][$journId]['type'] 		   = "Journal Entry";
					$accountLedger[$journal['fkaccount_id']][$journId]['name']         = "-";
					$accountLedger[$journal['fkaccount_id']][$journId]['transaction']  = "Journal No ".$journal['journal_no'];
					$accountLedger[$journal['fkaccount_id']][$journId]['transaction2'] = $journal['journal_description'];
					$accountLedger[$journal['fkaccount_id']][$journId]['credit_amount']= $journal['credit']; 
					$accountLedger[$journal['fkaccount_id']][$journId]['debit_amount'] = $journal['debit'];
					$accountLedger[$journal['fkaccount_id']][$journId]['date']         = $journal['date'];
				}
			}
			


			$incomeAccountIncome     = $this->report->getGeneralIncomeAccountForeign($from,$to);

			$incomeAccountInvoice    = $this->report->getGeneralInvoiceIncomeAccountForeign($from,$to);

			$expenseAccount  		 = $this->report->getGeneralExpenseAccountForeign($from,$to);

			$incomeAccountIncomePay  = $this->report->getGeneralIncomePayAccountForeign($from,$to);

			$incomeAccountInvoicePay = $this->report->getInvoicePayAccountsForeign($from,$to);

			$expenseAccountPay       = $this->report->getExpensePayAccountsForeign($from,$to);

			$incomeAccountCredit  	 = $this->report->getGeneralCreditAccountForeign($from,$to);

			//echo '<pre>'; print_r($incomeAccountCredit); echo '</pre>';

			foreach ($incomeAccountIncome as $income) {
				
					    $tax_amount   = ($income['amount'] * $income['tax_value'] / 100);
						$total_income = $income['amount']+$tax_amount;	

						if($income['transaction_currency']!='SGD') {
							$converted_rate       = $income['exchange_rate'];
							$converted_amount     = $total_income*$income['exchange_rate'];
						} 
				if($income['final_payment_date'] <= $to) {
					$accountLedger[2][$income['income_no']]['account_type'] 			 = 2;
				    $accountLedger[2][$income['income_no']]['no'] 			 = $income['income_no'];	
					$accountLedger[2][$income['income_no']]['date'] 			 = $income['final_payment_date'];
					$accountLedger[2][$income['income_no']]['type'] 			 = "Income";
					$accountLedger[2][$income['income_no']]['name']  	 = $income['customer_name'];
					$accountLedger[2][$income['income_no']]['amount']    	 = $total_income;
					$accountLedger[2][$income['income_no']]['transaction']      	 = $income['transaction_description'];
					$accountLedger[2][$income['income_no']]['transaction2']      	 = $income['transaction_description'];
					$accountLedger[2][$income['income_no']]['debit_amount'] = round($converted_amount,2);
					$accountLedger[2][$income['income_no']]['credit_amount']       	 = 0.00;
				}

			}

			foreach ($incomeAccountIncomePay as $incomePay) {
				$accountLedger[2][$incomePay['income_no']]['debit_amount']    -= $incomePay['amount'];
			}


			foreach ($incomeAccountInvoice as $invoice) {
				
					    $tax_amount   = $invoice['tax_amount'] ;
						$total_income = $invoice['amount']+$tax_amount;	

						if($invoice['transaction_currency']!='SGD') {
							$converted_rate 	= $invoice['exchange_rate'];
							$converted_amount 	= $total_income*$invoice['exchange_rate'];
						}
					if($invoice['final_payment_date'] <= $to) {
						$accountLedger[2][$invoice['invoice_no']]['account_type'] 			     = 2;
						$accountLedger[2][$invoice['invoice_no']]['no'] 			     = $invoice['invoice_no'];
						$accountLedger[2][$invoice['invoice_no']]['date'] 			 = $invoice['final_payment_date'];
						$accountLedger[2][$invoice['invoice_no']]['type'] 			 = "Invoice";
						$accountLedger[2][$invoice['invoice_no']]['name']  		 = $invoice['customer_name'];
						$accountLedger[2][$invoice['invoice_no']]['amount']    		 = $total_income;
						$accountLedger[2][$invoice['invoice_no']]['transaction']      		 = $invoice['name'];
						$accountLedger[2][$invoice['invoice_no']]['transaction2']      		 = $invoice['description'];
						$accountLedger[2][$invoice['invoice_no']]['debit_amount'] 	 = round($converted_amount,2);
						$accountLedger[2][$invoice['invoice_no']]['credit_amount']       	 	 = 0.00;
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

					if(isset($accountLedger[2][$credit['invoice_no']])) {
						$credits = $accountLedger[2][$credit['invoice_no']]['debit_amount'] - round($whole_amount,2);
						$accountLedger[2][$invoice['invoice_no']]['debit_amount'] = $credits;
					}
				}
			}


			foreach ($incomeAccountInvoicePay as $invoicePay) {
				$accountLedger[2][$invoicePay['invoice_no']]['debit_amount']    -= $invoicePay['amount'];
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
						$accountLedger[2][$expense['expense_no']]['account_type'] 			     = 2;
						$accountLedger[2][$expense['expense_no']]['no'] 			     = $expense['expense_no'];
						$accountLedger[2][$expense['expense_no']]['date'] 			 = $expense['final_payment_date'];
						$accountLedger[2][$expense['expense_no']]['type'] 			 = "Expense";
						$accountLedger[2][$expense['expense_no']]['name']  		 = $expense['vendor_name'];
						$accountLedger[2][$expense['expense_no']]['amount']    		 = $total_expense;
						$accountLedger[2][$expense['expense_no']]['transaction']      		 = $expense['product_id'];
						$accountLedger[2][$expense['expense_no']]['transaction2']      		 = $expense['product_description'];
						$accountLedger[2][$expense['expense_no']]['credit_amount'] 	 = round($converted_amount,2);
						$accountLedger[2][$expense['expense_no']]['debit_amount']       	 	 = 0.00;
					}
					
				}

				foreach ($expenseAccountPay as $expensePay) {
					$accountLedger[2][$expensePay['expense_no']]['credit_amount']    -= $expensePay['amount'];
				}
			
			$GlRollOver =  $this->glroll->index($from);


			$retained   =  $this->income->index($from);

			if(isset($GlRollOver[9])) {
				$GlRollOver[9] += round($retained,2);
			} else {
				$GlRollOver[9]  = round($retained,2);
			}


			$this->view->rollOver = $GlRollOver;

			
			foreach ($accountLedger as $key => $ledger) {
				usort($accountLedger[$key], $this->make_comparer('date'));
			}

			$this->view->accountLedger	=  $accountLedger; 

			}
			$this->view->from = date('d-m-Y',strtotime($from));
			$this->view->to = date('d-m-Y',strtotime($to));

			



			$this->view->generalAccount	=  $this->report->getAllAccountsTransaction();
			/*if(isset($this->view->getAccount) && !empty($this->view->getAccount)) {
				$this->view->generalTransaction	=  $generalLedger; 
			} else {
				$this->view->generalTransaction	=  array(); 
			}*/
			
			//echo '<pre>'; print_r($this->view->accountLedger); echo '</pre>';
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
				$from 		  = $current_year;
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
		    $generalLedger  = array();
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
			$getAccountArray  =  $this->accountData->getData(array('purchaseTaxCodes','supplyTaxCodes'));
			$supply 			    = array();
			$purchase 				= array();
			$this->irasSupply 	    = $this->transaction->getIrasTax(2);
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
			$this->supply     = $supply;
			$this->purchase   = $purchase;
			$this->taxes 	  = $this->settings->getTax();		

			if(in_array(4, $reportArray) || in_array(5, $reportArray)) {	

/*			$incomeAccountIncome  = $this->report->getGeneralIncomeAccount($from,$to);
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
			$this->generalAccount	=  $generalLedger; */

		}

		if(in_array(1, $reportArray) || in_array(5, $reportArray)) {	

			$company  =  $this->account->getCompany($id);

		}
		if(in_array(3, $reportArray) || in_array(5, $reportArray)) {	
			//$customers  =  $this->report->getCustomers();
				$incomeIafCustomer  = $this->report->getIafIncomeCustomer($from,$to);
				$invoiceIafCustomer = $this->report->getIafInvoiceCustomer($from,$to);
				$creditIafCustomer  = $this->report->getIafCreditCustomer($from,$to);
				$maxInvoice  		= $this->report->getMaxInvoiceTransaction();
				$maxCredit  		= $this->report->getMaxCreditTransaction();
		}
		if(in_array(2, $reportArray) || in_array(5, $reportArray)) {	
			//$vendors  =  $this->report->getVendors();
			$expenseIafVendor = $this->report->getIafExpenseVendor($from,$to);
		    $maxExpense  	  = $this->report->getMaxExpenseTransaction();
		}


		if(isset($maxInvoice) && !empty($maxInvoice)) {
				foreach ($maxInvoice as $maxInv) {
					if(!array_key_exists($maxInv['fkinvoice_id'], $maximumInv)) {
						$maximumInv[$maxInv['fkinvoice_id']]['product_description'] = $maxInv['product_description'];
						$maximumInv[$maxInv['fkinvoice_id']]['tax_code'] = $maxInv['fktax_id'];
					}
				}
			}

			if(isset($maxCredit) && !empty($maxCredit)) {
				foreach ($maxCredit as $maxCre) {
					if(!array_key_exists($maxCre['fkcredit_id'], $maximumCre)) {
						$maximumCre[$maxCre['fkcredit_id']]['product_description'] = $maxCre['product_description'];
						$maximumCre[$maxCre['fkcredit_id']]['tax_code'] = $maxCre['fktax_id'];
					}
				}
			}


			if(isset($maxExpense) && !empty($maxExpense)) {
				foreach ($maxExpense as $maxExp) {
					if(!array_key_exists($maxExp['fkexpense_id'], $maximumExp)) {
						$maximumExp[$maxExp['fkexpense_id']]['product_description'] = $maxExp['product_description'];
						$maximumExp[$maxExp['fkexpense_id']]['tax_code'] = $maxExp['fktax_id'];
					}
				}
			}

			if(isset($incomeIafCustomer) && !empty($incomeIafCustomer)) {
				foreach ($incomeIafCustomer as $income) {
					$tax_amount = ($income['amount'] * $income['tax_value'] / 100);
					$total_income = $income['amount'];
					if($income['transaction_currency']!='SGD') {
						$converted_amount = $total_income*$income['exchange_rate'];
						$gst_amount = $tax_amount*$income['exchange_rate'];
						$customer[$income['income_no']]['amount'] =  $converted_amount;
					    $customer[$income['income_no']]['gst'] =  $gst_amount;
					    $customer[$income['income_no']]['famount'] =  $income['amount'];
					    $customer[$income['income_no']]['fgst'] =  $tax_amount;
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

					if(isset($income['fktax_id']) && !empty($income['fktax_id'])) {
						foreach ($this->taxes as $tax) {
							if($tax['id']==$income['fktax_id']) {
								foreach ($this->supply as $key => $supply) {
	                                if($tax['tax_code']==$key) {
	                                    $code = $supply['name'];
	                                }
	                            }
							}
						}
					} else {
						$code = 'NA';
					}

					$customer[$income['income_no']]['no'] =  $income['income_no'];
					$customer[$income['income_no']]['invoice_no'] =  $income['receipt_no'];
					$customer[$income['income_no']]['currency'] =  $income['transaction_currency'];
					$customer[$income['income_no']]['description'] =  $income['transaction_description'];
					$customer[$income['income_no']]['date'] =  $income['date'];
					$customer[$income['income_no']]['taxcode'] =  $code;
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
						$converted_amount = $total_income*$invoice['exchange_rate'];
						$gst_amount = $tax_amount*$invoice['exchange_rate'];
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

					if(isset($maximumInv[$invoice['inv_id']]['tax_code']) && !empty($maximumInv[$invoice['inv_id']]['tax_code'])) {
						foreach ($this->taxes as $tax) {
							if($tax['id']==$maximumInv[$invoice['inv_id']]['tax_code']) {
								foreach ($this->supply as $key => $supply) {
	                                if($tax['tax_code']==$key) {
	                                    $code = $supply['name'];
	                                }
	                            }
							}
						}
					} else {
						$code = 'NA';
					}

					$customer[$invoice['invoice_no']]['no'] =  $invoice['invoice_no'];
					$customer[$invoice['invoice_no']]['invoice_no'] =  $invoice['invoice_no'];
					$customer[$invoice['invoice_no']]['description'] =  $maximumInv[$invoice['inv_id']]['product_description'];
					$customer[$invoice['invoice_no']]['taxcode'] =  $code;
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
						$converted_amount = $total_income*$credit['exchange_rate'];
						$gst_amount = $tax_amount*$credit['exchange_rate'];
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

					if(isset($maximumCre[$credit['cre_id']]['tax_code']) && !empty($maximumCre[$credit['cre_id']]['tax_code'])) {
						foreach ($this->taxes as $tax) {
							if($tax['id']==$maximumCre[$credit['cre_id']]['tax_code']) {
								foreach ($this->supply as $key => $supply) {
	                                if($tax['tax_code']==$key) {
	                                    $code = $supply['name'];
	                                }
	                            }
							}
						}
					} else {
						$code = 'NA';
					}

					$customer[$credit['credit_no']]['no'] =  $credit['credit_no'];
					$customer[$credit['credit_no']]['invoice_no'] =  $credit['credit_no'];
					$customer[$credit['credit_no']]['description'] =  $maximumCre[$credit['cre_id']]['product_description'];
					$customer[$credit['credit_no']]['taxcode'] =  $code;
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
					/*if($expense['total_gst']!=0.00) {
						$tax_amount = $expense['total_gst'];
					} else {*/
						$tax_amount = $expense['tax_amount'];
					//}
					
					$total_income = $expense['amount'];
					if($expense['transaction_currency']!='SGD') {
						$converted_amount = $total_income*$expense['exchange_rate'];
						if($expense['total_gst']!=0.00) {
							$gst_amount = $expense['total_gst'];
						} else {
							$gst_amount = $tax_amount*$expense['exchange_rate'];
						}
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

					if(isset($maximumExp[$expense['exp_id']]['tax_code']) && !empty($maximumExp[$expense['exp_id']]['tax_code'])) {
						foreach ($this->taxes as $tax) {
							if($tax['id']==$maximumExp[$expense['exp_id']]['tax_code']) {
								foreach ($this->purchase as $key => $purchase) {
	                                if($tax['tax_code']==$key) {
	                                    $code = $purchase['name'];
	                                }
	                            }
							}
						}
					} else {
						$code = 'NA';
					}

					$supplier[$expense['expense_no']]['no'] =  $expense['expense_no'];
					$supplier[$expense['expense_no']]['invoice_no'] =  $expense['receipt_no'];
					$supplier[$expense['expense_no']]['permit_no']  =  $expense['permit_no'];
					$supplier[$expense['expense_no']]['description'] =  $maximumExp[$expense['exp_id']]['product_description'];
					$supplier[$expense['expense_no']]['taxcode'] =  $code;
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

			usort($customer, $this->make_comparer('date'));
			                   

			if(isset($customer) && !empty($customer)) {

				 $objWorkSheet = $objPHPExcel->createSheet($j);

			     $objWorkSheet->setCellValue('A2', 'Supply Listings');

			     $objWorkSheet->setCellValue('A4', 'Customer Name');
			     $objWorkSheet->setCellValue('B4', 'Customer UEN');
			     $objWorkSheet->setCellValue('C4', 'Invoice Date');
			     $objWorkSheet->setCellValue('D4', 'Invoice No');
			     $objWorkSheet->setCellValue('E4', 'Line No');
			     $objWorkSheet->setCellValue('F4', 'Product Description');
			     $objWorkSheet->setCellValue('G4', 'SupplyValueSGD');
			     $objWorkSheet->setCellValue('H4', 'GSTValueSGD');
			     $objWorkSheet->setCellValue('I4', 'GrossTotal');
			     $objWorkSheet->setCellValue('J4', 'TaxCode');
			     $objWorkSheet->setCellValue('K4', 'FCYCode');
			     $objWorkSheet->setCellValue('L4', 'SupplyFCY');
			     $objWorkSheet->setCellValue('M4', 'GSTFCY');

			     $i =5;
				foreach ($customer as $key => $custom) {

					 $objWorkSheet->setCellValue('A'.$i, $custom['customerName']);
				     $objWorkSheet->setCellValue('B'.$i, $custom['customerUEN']);
				     $objWorkSheet->setCellValue('C'.$i, $custom['date']);
				     $objWorkSheet->setCellValue('D'.$i, $custom['no']);
				     $objWorkSheet->setCellValue('E'.$i, $custom['lineNo']);
				     $objWorkSheet->setCellValue('F'.$i, $custom['description']);
				     $objWorkSheet->setCellValue('G'.$i, $custom['amount']);
				     $objWorkSheet->setCellValue('H'.$i, $custom['gst']);
				     $objWorkSheet->setCellValue('I'.$i, ($custom['amount']+$custom['gst']));
				     $objWorkSheet->setCellValue('J'.$i, $custom['taxcode']);
				     $objWorkSheet->setCellValue('K'.$i, $custom['fcurrency']);
				     $objWorkSheet->setCellValue('L'.$i, $custom['famount']);
				     $objWorkSheet->setCellValue('M'.$i, $custom['fgst']);

					$i++;

				}
				 $objWorkSheet->setTitle('Supply Listings');
			     $j++;
			}

			usort($supplier, $this->make_comparer('date'));

			if(isset($supplier) && !empty($supplier)) {

				 $objWorkSheet = $objPHPExcel->createSheet($j);

			     $objWorkSheet->setCellValue('A2', 'Purchase Listings');

			     $objWorkSheet->setCellValue('A4', 'Supplier Name');
			     $objWorkSheet->setCellValue('B4', 'Supplier UEN');
			     $objWorkSheet->setCellValue('C4', 'Invoice Date');
			     $objWorkSheet->setCellValue('D4', 'Invoice No');
			     $objWorkSheet->setCellValue('E4', 'Line No');
			     $objWorkSheet->setCellValue('F4', 'Product Description');
			     $objWorkSheet->setCellValue('G4', 'SupplyValueSGD');
			     $objWorkSheet->setCellValue('H4', 'GSTValueSGD');
			     $objWorkSheet->setCellValue('I4', 'GrossTotal');
			     $objWorkSheet->setCellValue('J4', 'TaxCode');
			     $objWorkSheet->setCellValue('K4', 'FCYCode');
			     $objWorkSheet->setCellValue('L4', 'SupplyFCY');
			     $objWorkSheet->setCellValue('M4', 'GSTFCY');

			     $i =5;
				foreach ($supplier as $key => $supply) {

					 $objWorkSheet->setCellValue('A'.$i, $supply['supplierName']);
				     $objWorkSheet->setCellValue('B'.$i, $supply['supplierUEN']);
				     $objWorkSheet->setCellValue('C'.$i, $supply['date']);
				     $objWorkSheet->setCellValue('D'.$i, $supply['no']);
				     $objWorkSheet->setCellValue('E'.$i, $supply['lineNo']);
				     $objWorkSheet->setCellValue('F'.$i, $supply['description']);
				     $objWorkSheet->setCellValue('G'.$i, $supply['amount']);
				     $objWorkSheet->setCellValue('H'.$i, $supply['gst']);
				     $objWorkSheet->setCellValue('I'.$i, ($supply['amount']+$supply['gst']));
				     $objWorkSheet->setCellValue('J'.$i, $supply['taxcode']);
				     $objWorkSheet->setCellValue('K'.$i, $supply['fcurrency']);
				     $objWorkSheet->setCellValue('L'.$i, $supply['famount']);
				     $objWorkSheet->setCellValue('M'.$i, $supply['fgst']);

					$i++;

				}
				 $objWorkSheet->setTitle('Purchase Listings');
			     $j++;
			}

/*				if(isset($vendors) && !empty($vendors)) {

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
			 }*/

/*			 if(isset($this->generalAccount) && !empty($this->generalAccount)) {
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
*/
                   

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
			/*echo $from;
			echo $to; 
			echo $report;*/


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

			$getAccountArray  =  $this->accountData->getData(array('purchaseTaxCodes','supplyTaxCodes'));
			//$this->purchase   =  $getAccountArray['purchaseTaxCodes'];
			//$this->supply     =  $getAccountArray['supplyTaxCodes'];
			$supply 			    = array();
			$purchase 				= array();
			$this->irasSupply 	    = $this->transaction->getIrasTax(2);
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
			$this->supply     = $supply;
			$this->purchase   = $purchase;
			$this->taxes 	  = $this->settings->getTax();			

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
						$maximumInv[$maxInv['fkinvoice_id']]['tax_code'] = $maxInv['fktax_id'];
					}
				}
			}

			if(isset($maxCredit) && !empty($maxCredit)) {
				foreach ($maxCredit as $maxCre) {
					if(!array_key_exists($maxCre['fkcredit_id'], $maximumCre)) {
						$maximumCre[$maxCre['fkcredit_id']]['product_description'] = $maxCre['product_description'];
						$maximumCre[$maxCre['fkcredit_id']]['tax_code'] = $maxCre['fktax_id'];
					}
				}
			}


			if(isset($maxExpense) && !empty($maxExpense)) {
				foreach ($maxExpense as $maxExp) {
					if(!array_key_exists($maxExp['fkexpense_id'], $maximumExp)) {
						$maximumExp[$maxExp['fkexpense_id']]['product_description'] = $maxExp['product_description'];
						$maximumExp[$maxExp['fkexpense_id']]['tax_code'] = $maxExp['fktax_id'];
					}
				}
			}

			if(isset($incomeIafCustomer) && !empty($incomeIafCustomer)) {
				foreach ($incomeIafCustomer as $income) {
					$tax_amount = ($income['amount'] * $income['tax_value'] / 100);
					$total_income = $income['amount'];
					if($income['transaction_currency']!='SGD') {
						$converted_amount = $total_income*$income['exchange_rate'];
						$gst_amount = $tax_amount*$income['exchange_rate'];
						$customer[$income['income_no']]['amount'] =  $converted_amount;
					    $customer[$income['income_no']]['gst'] =  $gst_amount;
					    $customer[$income['income_no']]['famount'] =  $income['amount'];
					    $customer[$income['income_no']]['fgst'] =  $tax_amount;
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

					if(isset($income['fktax_id']) && !empty($income['fktax_id'])) {
						foreach ($this->taxes as $tax) {
							if($tax['id']==$income['fktax_id']) {
								foreach ($this->supply as $key => $supply) {
	                                if($tax['tax_code']==$key) {
	                                    $code = $supply['name'];
	                                }
	                            }
							}
						}
					} else {
						$code = 'NA';
					}

					$customer[$income['income_no']]['no'] =  $income['income_no'];
					$customer[$income['income_no']]['invoice_no'] =  $income['receipt_no'];
					$customer[$income['income_no']]['currency'] =  $income['transaction_currency'];
					$customer[$income['income_no']]['description'] =  $income['transaction_description'];
					$customer[$income['income_no']]['date'] =  $income['date'];
					$customer[$income['income_no']]['taxcode'] =  $code;
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
						$converted_amount = $total_income*$invoice['exchange_rate'];
						$gst_amount = $tax_amount*$invoice['exchange_rate'];
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

					if(isset($maximumInv[$invoice['inv_id']]['tax_code']) && !empty($maximumInv[$invoice['inv_id']]['tax_code'])) {
						foreach ($this->taxes as $tax) {
							if($tax['id']==$maximumInv[$invoice['inv_id']]['tax_code']) {
								foreach ($this->supply as $key => $supply) {
	                                if($tax['tax_code']==$key) {
	                                    $code = $supply['name'];
	                                }
	                            }
							}
						}
					} else {
						$code = 'NA';
					}

					$customer[$invoice['invoice_no']]['no'] =  $invoice['invoice_no'];
					$customer[$invoice['invoice_no']]['invoice_no'] =  $invoice['invoice_no'];
					$customer[$invoice['invoice_no']]['description'] =  $maximumInv[$invoice['inv_id']]['product_description'];
					$customer[$invoice['invoice_no']]['taxcode'] =  $code;
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
						$converted_amount = $total_income*$credit['exchange_rate'];
						$gst_amount = $tax_amount*$credit['exchange_rate'];
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

					if(isset($maximumCre[$credit['cre_id']]['tax_code']) && !empty($maximumCre[$credit['cre_id']]['tax_code'])) {
						foreach ($this->taxes as $tax) {
							if($tax['id']==$maximumCre[$credit['cre_id']]['tax_code']) {
								foreach ($this->supply as $key => $supply) {
	                                if($tax['tax_code']==$key) {
	                                    $code = $supply['name'];
	                                }
	                            }
							}
						}
					} else {
						$code = 'NA';
					}

					$customer[$credit['credit_no']]['no'] =  $credit['credit_no'];
					$customer[$credit['credit_no']]['invoice_no'] =  $credit['credit_no'];
					$customer[$credit['credit_no']]['description'] =  $maximumCre[$credit['cre_id']]['product_description'];
					$customer[$credit['credit_no']]['taxcode'] =  $code;
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
					/*if($expense['total_gst']!=0.00) {
						$tax_amount = $expense['total_gst'];
					} else {*/
						$tax_amount = $expense['tax_amount'];
					//}
					
					$total_income = $expense['amount'];
					if($expense['transaction_currency']!='SGD') {
						$converted_amount = $total_income*$expense['exchange_rate'];
						if($expense['total_gst']!=0.00) {
							$gst_amount = $expense['total_gst'];
						} else {
							$gst_amount = $tax_amount*$expense['exchange_rate'];
						}
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

					if(isset($maximumExp[$expense['exp_id']]['tax_code']) && !empty($maximumExp[$expense['exp_id']]['tax_code'])) {
						foreach ($this->taxes as $tax) {
							if($tax['id']==$maximumExp[$expense['exp_id']]['tax_code']) {
								foreach ($this->purchase as $key => $purchase) {
	                                if($tax['tax_code']==$key) {
	                                    $code = $purchase['name'];
	                                }
	                            }
							}
						}
					} else {
						$code = 'NA';
					}

					$supplier[$expense['expense_no']]['no'] =  $expense['expense_no'];
					$supplier[$expense['expense_no']]['invoice_no'] =  $expense['receipt_no'];
					$supplier[$expense['expense_no']]['permit_no']  =  $expense['permit_no'];
					$supplier[$expense['expense_no']]['description'] =  $maximumExp[$expense['exp_id']]['product_description'];
					$supplier[$expense['expense_no']]['taxcode'] =  $code;
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

			$generalLedger  = array();
			$accountId      = array();
			$accountLedger  = array();


			$incomeAccountIncome  = $this->report->getGeneralIncomeAccountGl($from,$to);
			$incomeAccountInvoice = $this->report->getGeneralInvoiceIncomeAccountGl($from,$to);
			$incomeAccountCredit  = $this->report->getGeneralCreditAccountGl($from,$to);
			$expenseAccount  = $this->report->getGeneralExpenseAccountGl($from,$to);
			$journalAccount  = $this->report->getGeneralJournalAccountGl($from,$to);

			$incomeAccountIncomePay  = $this->report->getGeneralIncomePayAccountGl($from,$to);
			$expenseAccountPay  =  $this->report->getExpensePayAccountGl($from,$to);
			$incomeAccountInvoicePay  =  $this->report->getInvoicePayAccountGl($from,$to);


			$accountId['income'][] = 'NULL';
			if(isset($incomeAccountIncome) && !empty($incomeAccountIncome)) {
				foreach ($incomeAccountIncome as $income) {
					$accountId['income'][] = $income['inc_id'];
					$tax_amount = ($income['amount'] * $income['tax_value'] / 100);
					$total_income = $income['amount']+$tax_amount;	
					if($income['transaction_currency']!='SGD') {
						$converted_amount = $income['amount']*$income['exchange_rate'];
						$whole_amount	  = $total_income*$income['exchange_rate'];
						if($tax_amount!=0) {
							$total_tax = $tax_amount*$income['exchange_rate'];
						} else {
							$total_tax = 0;
						}
						/*if($income['pay_status']==1 && $income['final_payment_date'] <= $to) {
							$accountLedger[2][$income['income_no']]['account_type']  = 2;
							$accountLedger[2][$income['income_no']]['no']  		     = $income['income_no'];
							$accountLedger[2][$income['income_no']]['source']  		 = $income['receipt_no'];
							$accountLedger[2][$income['income_no']]['type']  		 = "Income";
							$accountLedger[2][$income['income_no']]['name'] 		 = $income['customer_name'];
							$accountLedger[2][$income['income_no']]['date'] 		 = $income['final_payment_date'];
							$accountLedger[2][$income['income_no']]['transaction']   = "";
							$accountLedger[2][$income['income_no']]['debit_amount']   = round($whole_amount,2);
							$accountLedger[2][$income['income_no']]['credit_amount']  = 0.00;
						}*/
					} else {
						$converted_amount = $income['amount'];
						$whole_amount	  = $total_income;
						if($tax_amount!=0) {
							$total_tax = $tax_amount;
						} else {
							$total_tax = 0;
						}
					}

					$incomes[$income['income_no']]['tax_value'] = $income['tax_value'];
					

						$accountLedger[$income['fkincome_type']][$income['income_no']]['account_type']  = $income['fkincome_type'];
						$accountLedger[$income['fkincome_type']][$income['income_no']]['no']  		    = $income['income_no'];
						$accountLedger[$income['fkincome_type']][$income['income_no']]['type']  		= "Income";
						$accountLedger[$income['fkincome_type']][$income['income_no']]['source']  		= $income['receipt_no'];
						$accountLedger[$income['fkincome_type']][$income['income_no']]['name'] 		    = $income['customer_name'];
						$accountLedger[$income['fkincome_type']][$income['income_no']]['date'] 		    = $income['date'];
						$accountLedger[$income['fkincome_type']][$income['income_no']]['transaction']   = $income['transaction_description'];
						$accountLedger[$income['fkincome_type']][$income['income_no']]['credit_amount'] = $converted_amount;
						$accountLedger[$income['fkincome_type']][$income['income_no']]['debit_amount']  = 0.00;

						if($total_tax!=0) {
							$accountLedger[11][$income['income_no']]['account_type']  = 11;
							$accountLedger[11][$income['income_no']]['no']  		  = $income['income_no'];
							$accountLedger[11][$income['income_no']]['type']  		  = "Income";
							$accountLedger[11][$income['income_no']]['source']  	  = $income['receipt_no'];
							$accountLedger[11][$income['income_no']]['name'] 		  = $income['customer_name'];
							$accountLedger[11][$income['income_no']]['date'] 		  = $income['date'];
							$accountLedger[11][$income['income_no']]['transaction']   = $income['transaction_description'];
							$accountLedger[11][$income['income_no']]['credit_amount'] = $total_tax;
							$accountLedger[11][$income['income_no']]['debit_amount']  = 0.00;
						}


						if($income['credit_term']!=1) {
							$accountLedger[$income['coa_link']][$income['income_no']]['account_type']   = $income['coa_link'];
							$accountLedger[$income['coa_link']][$income['income_no']]['no']   		    = $income['income_no'];
							$accountLedger[$income['coa_link']][$income['income_no']]['source']   		= $income['receipt_no'];
							$accountLedger[$income['coa_link']][$income['income_no']]['type']  		    = "Income";
							$accountLedger[$income['coa_link']][$income['income_no']]['name'] 		    = $income['customer_name'];
							$accountLedger[$income['coa_link']][$income['income_no']]['date'] 		    = $income['date'];
							$accountLedger[$income['coa_link']][$income['income_no']]['transaction']    = $income['transaction_description'];
							$accountLedger[$income['coa_link']][$income['income_no']]['debit_amount']   = $whole_amount;
							$accountLedger[$income['coa_link']][$income['income_no']]['credit_amount']  = 0.00;	
						}

				}
			}

			

			$accountId['invoice'][] = 'NULL';
			if(isset($incomeAccountInvoice) && !empty($incomeAccountInvoice)) {
				foreach ($incomeAccountInvoice as $invoice) {
					$accountId['invoice'][] = $invoice['inv_id'];
					$amount = ($invoice['unit_price'] * $invoice['quantity'] - $invoice['discount_amount']);
					$tax_amount = ($amount * $invoice['tax_value'] / 100);
					$total_income = $amount+$tax_amount;
					if($invoice['transaction_currency']!='SGD') {
						$converted_amount = $amount*$invoice['exchange_rate'];
						$whole_amount	  = $total_income*$invoice['exchange_rate'];
						if($tax_amount!=0) {
							$total_tax = $tax_amount*$invoice['exchange_rate'];
						} else {
							$total_tax = 0;
						}
						if($invoice['discount_amount']!=0) {
							$discount_amount = $invoice['discount_amount']*$invoice['exchange_rate'];
						} else {
							$discount_amount = 0;
						}
						/*if($invoice['pay_status']==1 && $invoice['final_payment_date'] <= $to && !isset($accountLedger[2][$invoice['invoice_no']])) {
							$accountLedger[2][$invoice['invoice_no']]['account_type']    = 2;
							$accountLedger[2][$invoice['invoice_no']]['no'] 			 = $invoice['invoice_no'];
							$accountLedger[2][$invoice['invoice_no']]['source'] 		 = $invoice['invoice_no'];
							$accountLedger[2][$invoice['invoice_no']]['type'] 		     = "Invoice";
							$accountLedger[2][$invoice['invoice_no']]['name'] 	  	     = $invoice['customer_name'];
							$accountLedger[2][$invoice['invoice_no']]['date'] 		     = $invoice['final_payment_date'];
							$accountLedger[2][$invoice['invoice_no']]['transaction'] 	 = "";
							$accountLedger[2][$invoice['invoice_no']]['debit_amount']    = $whole_amount;
							$accountLedger[2][$invoice['invoice_no']]['credit_amount']    = 0.00;
						} else if($invoice['pay_status']==1 && $invoice['final_payment_date'] <= $to && isset($accountLedger[2][$invoice['invoice_no']])) {
							$accountLedger[2][$invoice['invoice_no']]['debit_amount']    += $whole_amount;
						}*/
					} else {
						$converted_amount = $amount;
						$whole_amount	  = $total_income;
						if($tax_amount!=0) {
							$total_tax = $tax_amount;
						} else {
							$total_tax = 0;
						}
						/*if($invoice['discount_amount']!=0) {
							$discount_amount = $invoice['discount_amount'];
						} else {
							$discount_amount = 0;
						}*/
					}

					if(!isset($invoices[$invoice['invoice_no']]['tax_value'])) {
						$invoices[$invoice['invoice_no']]['tax_value'] = $invoice['tax_value'];
					}

						$invoice_id = $invoice['invoice_no']."_".$invoice['pid'];
						$accountLedger[$invoice['fkincomeaccount_id']][$invoice_id]['account_type']   = $invoice['fkincomeaccount_id'];
						$accountLedger[$invoice['fkincomeaccount_id']][$invoice_id]['no'] 			  = $invoice['invoice_no'];
						$accountLedger[$invoice['fkincomeaccount_id']][$invoice_id]['source']		  = $invoice['invoice_no'];
						$accountLedger[$invoice['fkincomeaccount_id']][$invoice_id]['type'] 		  = "Invoice";
						$accountLedger[$invoice['fkincomeaccount_id']][$invoice_id]['name'] 	  	  = $invoice['customer_name'];
						$accountLedger[$invoice['fkincomeaccount_id']][$invoice_id]['date'] 		  = $invoice['date'];
						$accountLedger[$invoice['fkincomeaccount_id']][$invoice_id]['transaction'] 	  = $invoice['name'];
						$accountLedger[$invoice['fkincomeaccount_id']][$invoice_id]['credit_amount']  = $converted_amount;
						$accountLedger[$invoice['fkincomeaccount_id']][$invoice_id]['debit_amount']   = 0.00;

						if($total_tax!=0) {
							if(!isset($accountLedger[11][$invoice['invoice_no']])) {
								$accountLedger[11][$invoice['invoice_no']]['account_type']      = 11;
								$accountLedger[11][$invoice['invoice_no']]['no'] 			    = $invoice['invoice_no'];
								$accountLedger[11][$invoice['invoice_no']]['source'] 			= $invoice['invoice_no'];
								$accountLedger[11][$invoice['invoice_no']]['type'] 		  		= "Invoice";
								$accountLedger[11][$invoice['invoice_no']]['name'] 	  	  		= $invoice['customer_name'];
								$accountLedger[11][$invoice['invoice_no']]['date'] 		  		= $invoice['date'];
								$accountLedger[11][$invoice['invoice_no']]['transaction'] 	  	= $invoice['name'];
								$accountLedger[11][$invoice['invoice_no']]['credit_amount']  	= $total_tax;
								$accountLedger[11][$invoice['invoice_no']]['debit_amount']   	= 0.00;
							} else {
								$accountLedger[11][$invoice['invoice_no']]['credit_amount']  	+= $total_tax;
								$accountLedger[11][$invoice['invoice_no']]['debit_amount']   	 = 0.00;
							}
						}

						/*if($discount_amount!=0) {
							if(!isset($accountLedger[7][$invoice['invoice_no']])) {
								$accountLedger[7][$invoice['invoice_no']]['account_type']       = 7;
								$accountLedger[7][$invoice['invoice_no']]['no'] 			    = $invoice['invoice_no'];
								$accountLedger[7][$invoice['invoice_no']]['type'] 		  		= "Invoice";
								$accountLedger[7][$invoice['invoice_no']]['name'] 	  	  		= $invoice['customer_name'];
								$accountLedger[7][$invoice['invoice_no']]['date'] 		  		= $invoice['date'];
								$accountLedger[7][$invoice['invoice_no']]['transaction'] 	  	= $invoice['name'];
								$accountLedger[7][$invoice['invoice_no']]['debit_amount']  	    = $discount_amount;
								$accountLedger[7][$invoice['invoice_no']]['credit_amount']   	= 0.00;
							} else {
								$accountLedger[7][$invoice['invoice_no']]['debit_amount']  	    += $discount_amount;
								$accountLedger[7][$invoice['invoice_no']]['credit_amount']   	 = 0.00;
							}
						}*/

						$accountLedger[$invoice['fkincomeaccount_id']][$invoice_id]['account_type']   = $invoice['fkincomeaccount_id'];
						$accountLedger[$invoice['fkincomeaccount_id']][$invoice_id]['no'] 			  = $invoice['invoice_no'];
						$accountLedger[$invoice['fkincomeaccount_id']][$invoice_id]['source'] 		  = $invoice['invoice_no'];
						$accountLedger[$invoice['fkincomeaccount_id']][$invoice_id]['type'] 		  = "Invoice";
						$accountLedger[$invoice['fkincomeaccount_id']][$invoice_id]['name'] 	  	  = $invoice['customer_name'];
						$accountLedger[$invoice['fkincomeaccount_id']][$invoice_id]['date'] 		  = $invoice['date'];
						$accountLedger[$invoice['fkincomeaccount_id']][$invoice_id]['transaction'] 	  = $invoice['name'];
						$accountLedger[$invoice['fkincomeaccount_id']][$invoice_id]['credit_amount']  = $converted_amount;
						$accountLedger[$invoice['fkincomeaccount_id']][$invoice_id]['debit_amount']   = 0.00;

						if($invoice['credit_term']!=1) {
							if(!isset($accountLedger[$invoice['coa_link']][$invoice['invoice_no']])) {
								$accountLedger[$invoice['coa_link']][$invoice['invoice_no']]['account_type']    = $invoice['coa_link'];
								$accountLedger[$invoice['coa_link']][$invoice['invoice_no']]['no']   		    = $invoice['invoice_no'];
								$accountLedger[$invoice['coa_link']][$invoice['invoice_no']]['source']   		= $invoice['invoice_no'];
								$accountLedger[$invoice['coa_link']][$invoice['invoice_no']]['type']  		    = "Invoice";
								$accountLedger[$invoice['coa_link']][$invoice['invoice_no']]['name'] 		    = $invoice['customer_name'];
								$accountLedger[$invoice['coa_link']][$invoice['invoice_no']]['date'] 		    = $invoice['date'];
								$accountLedger[$invoice['coa_link']][$invoice['invoice_no']]['transaction']     = $invoice['name'];
								$accountLedger[$invoice['coa_link']][$invoice['invoice_no']]['debit_amount']    = $whole_amount;
								$accountLedger[$invoice['coa_link']][$invoice['invoice_no']]['credit_amount']   = 0.00;	
							} else {
								$accountLedger[$invoice['coa_link']][$invoice['invoice_no']]['debit_amount']    += $whole_amount;
								$accountLedger[$invoice['coa_link']][$invoice['invoice_no']]['credit_amount']    = 0.00;	
							}
						}
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
						if($tax_amount!=0) {
							$total_tax = $tax_amount*$credit['exchange_rate'];
						} else {
							$total_tax = 0;
						}
						if($credit['discount_amount']!=0) {
							$discount_amount = $credit['discount_amount']*$credit['exchange_rate'];
						} else {
							$discount_amount = 0;
						}
					} else {
						$converted_amount = $amount;
						$whole_amount 	  = $total_income;
						if($tax_amount!=0) {
							$total_tax = $tax_amount;
						} else {
							$total_tax = 0;
						}
						/*if($credit['discount_amount']!=0) {
							$discount_amount = $credit['discount_amount'];
						} else {
							$discount_amount = 0;
						}*/
					}

					if(isset($accountLedger[2][$credit['invoice_no']])) {
						$credits = $accountLedger[2][$invoice['invoice_no']]['debit_amount'] - $whole_amount;
						$accountLedger[2][$invoice['invoice_no']]['debit_amount'] = round($credits,2); 
					}
					

						//$credit_id = $credit['credit_no']."_".$credit['invoice_no']."_".$credit['pid'];
					$credit_id = $credit['credit_no']."_".$credit['invoice_no']."_".$credit['pid'];
						$accountLedger[$credit['fkincomeaccount_id']][$credit_id]['account_type'] 	= $credit['fkincomeaccount_id'];
						$accountLedger[$credit['fkincomeaccount_id']][$credit_id]['no'] 			= $credit['credit_no'];
						$accountLedger[$credit['fkincomeaccount_id']][$credit_id]['source'] 	    = $credit['credit_no'];
						$accountLedger[$credit['fkincomeaccount_id']][$credit_id]['type'] 			= "Credit Note";
						$accountLedger[$credit['fkincomeaccount_id']][$credit_id]['date']			= $credit['date'];
						$accountLedger[$credit['fkincomeaccount_id']][$credit_id]['name'] 		    = $credit['customer_name'];
						$accountLedger[$credit['fkincomeaccount_id']][$credit_id]['transaction'] 	= $credit['name'];
						$accountLedger[$credit['fkincomeaccount_id']][$credit_id]['credit_amount'] 	= 0.00;
						$accountLedger[$credit['fkincomeaccount_id']][$credit_id]['debit_amount'] 	= $converted_amount;

						/*if($discount_amount!=0) {
							if(!isset($accountLedger[7][$credit['credit_no']])) { 
								$accountLedger[7][$credit['credit_no']]['account_type'] 	= 7;
								$accountLedger[7][$credit['credit_no']]['no'] 				= $credit['credit_no'];
								$accountLedger[7][$credit['credit_no']]['type'] 			= "Credit Note";
								$accountLedger[7][$credit['credit_no']]['date']			    = $credit['date'];
								$accountLedger[7][$credit['credit_no']]['name'] 		    = $credit['customer_name'];
								$accountLedger[7][$credit['credit_no']]['transaction']   	= $credit['name'];
								$accountLedger[7][$credit['credit_no']]['debit_amount']     = 0.00;
								$accountLedger[7][$credit['credit_no']]['credit_amount'] 	= $discount_amount;
							} else {
								$accountLedger[7][$credit['credit_no']]['debit_amount']      = 0.00;
								$accountLedger[7][$credit['credit_no']]['credit_amount'] 	+= $discount_amount;
							}
						}*/

						if($total_tax!=0) {
							if(!isset($accountLedger[11][$credit['credit_no']])) { 
								$accountLedger[11][$credit['credit_no']]['account_type'] 	= 11;
								$accountLedger[11][$credit['credit_no']]['no'] 				= $credit['credit_no'];
								$accountLedger[11][$credit['credit_no']]['source'] 			= $credit['credit_no'];
								$accountLedger[11][$credit['credit_no']]['type'] 			= "Credit Note";
								$accountLedger[11][$credit['credit_no']]['date']			= $credit['date'];
								$accountLedger[11][$credit['credit_no']]['name'] 		    = $credit['customer_name'];
								$accountLedger[11][$credit['credit_no']]['transaction'] 	= $credit['name'];
								$accountLedger[11][$credit['credit_no']]['credit_amount']   = 0.00;
								$accountLedger[11][$credit['credit_no']]['debit_amount'] 	= $total_tax;
							} else {
								$accountLedger[11][$credit['credit_no']]['credit_amount']    = 0.00;
								$accountLedger[11][$credit['credit_no']]['debit_amount'] 	+= $total_tax;
							}
						}

						if(!isset($accountLedger[$credit['coa_link']][$credit_id])) {
								$accountLedger[$credit['coa_link']][$credit_id]['account_type']       = $credit['coa_link'];
								$accountLedger[$credit['coa_link']][$credit_id]['no']   		      = $credit['credit_no'];
								$accountLedger[$credit['coa_link']][$credit_id]['source']   		  = $credit['credit_no'];
								$accountLedger[$credit['coa_link']][$credit_id]['type']  		      = "Credit Note";
								$accountLedger[$credit['coa_link']][$credit_id]['name'] 		      = $credit['customer_name'];
								$accountLedger[$credit['coa_link']][$credit_id]['date'] 		      = $credit['date'];
								$accountLedger[$credit['coa_link']][$credit_id]['transaction']      = $credit['name'];
								$accountLedger[$credit['coa_link']][$credit_id]['credit_amount']    = $whole_amount;
								$accountLedger[$credit['coa_link']][$credit_id]['debit_amount']     = 0.00;	
						} else {
								$accountLedger[$credit['coa_link']][$credit_id]['credit_amount']    += $whole_amount;
								$accountLedger[$credit['coa_link']][$credit_id]['debit_amount']      = 0.00;	
						}
				}
			}

			

            

			$accountId['expense'][] = 'NULL';
			if(isset($expenseAccount) && !empty($expenseAccount)) {
				foreach ($expenseAccount as $expense) {
					$accountId['expense'][] = $expense['exp_id'];
					$amount = ($expense['unit_price'] * $expense['quantity']);
					if($expense['total_gst']!=0.00) {
						$tax_amount = $expense['total_gst'];
					} else {
						$tax_amount = ($amount * $expense['tax_value'] / 100);
					}
					
					$total_income = $amount + $tax_amount;
					if($expense['transaction_currency']!='SGD') {
						$converted_amount = $amount*$expense['exchange_rate'];
						if($expense['total_gst']!=0.00) {
							$whole_amount 	  = ($amount*$expense['exchange_rate'])+$expense['total_gst'];
						} else {
							$whole_amount 	  = $total_income*$expense['exchange_rate'];
						}
						if($tax_amount!=0) {
							if($expense['total_gst']!=0.00) {
								$total_tax = $expense['total_gst'];
							} else {
								$total_tax = $tax_amount*$expense['exchange_rate'];
							}
						} else {
							$total_tax = 0;
						}

						/*if($expense['pay_status']==1 && $expense['final_payment_date'] <= $to && !isset($accountLedger[2][$expense['expense_no']])) {
							$accountLedger[2][$expense['expense_no']]['account_type']    = 2;
							$accountLedger[2][$expense['expense_no']]['no'] 			 = $expense['expense_no'];
							$accountLedger[2][$expense['expense_no']]['source'] 	     = $expense['receipt_no'];
							$accountLedger[2][$expense['expense_no']]['type'] 		     = "Expense";
							$accountLedger[2][$expense['expense_no']]['name'] 	  	     = $expense['vendor_name'];
							$accountLedger[2][$expense['expense_no']]['date'] 		     = $expense['final_payment_date'];
							$accountLedger[2][$expense['expense_no']]['transaction'] 	 = "";
							$accountLedger[2][$expense['expense_no']]['credit_amount']   = round($whole_amount,2);
							$accountLedger[2][$expense['expense_no']]['debit_amount']    = 0.00;
						} else if($expense['pay_status']==1 && $expense['final_payment_date'] <= $to && isset($accountLedger[2][$expense['expense_no']])) {
							$accountLedger[2][$expense['expense_no']]['credit_amount']   += round($whole_amount,2);
						}*/
					} else {
						$converted_amount = $amount;
						$whole_amount     = $total_income;
						if($tax_amount!=0) {
							$total_tax = $tax_amount;
						} else {
							$total_tax = 0;
						}
					}

					if(!isset($expenses[$expense['expense_no']]['tax_value'])) {
						$expenses[$expense['expense_no']]['tax_value'] = $expense['tax_value'];
					}

					$expense_id = $expense['expense_no']."_".$expense['pid'];
					$accountLedger[$expense['fkexpense_type']][$expense_id]['account_type']  = $expense['fkexpense_type'];
					$accountLedger[$expense['fkexpense_type']][$expense_id]['no'] 			 = $expense['expense_no'];
					$accountLedger[$expense['fkexpense_type']][$expense_id]['source'] 	     = $expense['receipt_no'];
					$accountLedger[$expense['fkexpense_type']][$expense_id]['type'] 		 = "Expense";
					$accountLedger[$expense['fkexpense_type']][$expense_id]['date'] 		 = $expense['date'];
					$accountLedger[$expense['fkexpense_type']][$expense_id]['name'] 		 = $expense['vendor_name'];
					$accountLedger[$expense['fkexpense_type']][$expense_id]['transaction']   = $expense['product_description'];
					$accountLedger[$expense['fkexpense_type']][$expense_id]['credit_amount'] = 0.00;
					$accountLedger[$expense['fkexpense_type']][$expense_id]['debit_amount']  = $converted_amount;

					if($total_tax!=0) {
						if(!isset($accountLedger[11][$expense['expense_no']])) { 
							$accountLedger[11][$expense['expense_no']]['account_type']   = 11;
							$accountLedger[11][$expense['expense_no']]['no'] 			 = $expense['expense_no'];
							$accountLedger[11][$expense['expense_no']]['source'] 		 = $expense['receipt_no'];
							$accountLedger[11][$expense['expense_no']]['type'] 		 	 = "Expense";
							$accountLedger[11][$expense['expense_no']]['date'] 		 	 = $expense['date'];
							$accountLedger[11][$expense['expense_no']]['name'] 		     = $expense['vendor_name'];
							$accountLedger[11][$expense['expense_no']]['transaction']    = $expense['product_description'];
							$accountLedger[11][$expense['expense_no']]['credit_amount']  = 0.00;
							$accountLedger[11][$expense['expense_no']]['debit_amount']   = $total_tax;
						} else {
							$accountLedger[11][$expense['expense_no']]['credit_amount']   = 0.00;
							$accountLedger[11][$expense['expense_no']]['debit_amount']   += $total_tax;
						}
					}

					if($expense['credit_term']!=1) {
						if(!isset($accountLedger[$expense['coa_link']][$expense['expense_no']])) {
							$accountLedger[$expense['coa_link']][$expense['expense_no']]['account_type']    = $expense['coa_link'];
							$accountLedger[$expense['coa_link']][$expense['expense_no']]['no']   		    = $expense['expense_no'];
							$accountLedger[$expense['coa_link']][$expense['expense_no']]['source']   		= $expense['receipt_no'];
							$accountLedger[$expense['coa_link']][$expense['expense_no']]['type']  		    = "Expense";
							$accountLedger[$expense['coa_link']][$expense['expense_no']]['name'] 		    = $expense['vendor_name'];
							$accountLedger[$expense['coa_link']][$expense['expense_no']]['date'] 		    = $expense['date'];
							$accountLedger[$expense['coa_link']][$expense['expense_no']]['transaction']     = $expense['product_description'];
							$accountLedger[$expense['coa_link']][$expense['expense_no']]['debit_amount']    = 0.00;
							$accountLedger[$expense['coa_link']][$expense['expense_no']]['credit_amount']   = $whole_amount;	
						} else {
							$accountLedger[$expense['coa_link']][$expense['expense_no']]['debit_amount']     += 0.00;
							$accountLedger[$expense['coa_link']][$expense['expense_no']]['credit_amount']    += $whole_amount;	
						}
					}
				}
			}




			$accountId['income_pay'][] = 'NULL';
			$accountId['income_paid'][] = 'NULL';
			if(isset($incomeAccountIncomePay) && !empty($incomeAccountIncomePay)) {
				foreach ($incomeAccountIncomePay as $incPayment) {
						$accountId['income_pay'][] = $incPayment['inc_id'];
						$amount = $incPayment['payment_amount']+$incPayment['discount_amount'];
						
						/*if($incPayment['pay_status']==1 && $incPayment['transaction_currency']!='SGD') {
							if(isset($accountLedger[2][$incPayment['income_no']])) {
								$accountLedger[2][$incPayment['income_no']]['debit_amount'] -= $incPayment['payment_amount'];
							} else {
								$accountLedger[2][$incPayment['income_no']]['account_type']  = $incPayment['fkpayment_account'];
								$accountLedger[2][$incPayment['income_no']]['source']  = $incPayment['income_no'];
								$accountLedger[2][$incPayment['income_no']]['no'] 			  = "PMT".$incPayment['id'];
								$accountLedger[2][$incPayment['income_no']]['type'] 		  = "Income";
								$accountLedger[2][$incPayment['income_no']]['date'] 		  = $incPayment['pay_date'];
								$accountLedger[2][$incPayment['income_no']]['name'] 		  = $incPayment['customer_name'];
								$accountLedger[2][$incPayment['income_no']]['transaction']   = "Payment for Income No ".$incPayment['income_no'];
								$accountLedger[2][$incPayment['income_no']]['credit_amount'] = 0.00;
								$accountLedger[2][$incPayment['income_no']]['debit_amount']  = $incPayment['payment_amount'];
							}
						}*/

					$payId = $incPayment['id']."_".$incPayment['income_no']."_pay";
					$entryId = $incPayment['id']."_".$incPayment['income_no']."_payentry";
					$accountLedger[$incPayment['fkpayment_account']][$payId]['account_type']  = $incPayment['fkpayment_account'];
					$accountLedger[$incPayment['fkpayment_account']][$payId]['source']  = $incPayment['income_no'];
					$accountLedger[$incPayment['fkpayment_account']][$payId]['no'] 			  = "PMT".$incPayment['id'];
					$accountLedger[$incPayment['fkpayment_account']][$payId]['type'] 		  = "Income";
					$accountLedger[$incPayment['fkpayment_account']][$payId]['date'] 		  = $incPayment['pay_date'];
					$accountLedger[$incPayment['fkpayment_account']][$payId]['name'] 		  = $incPayment['customer_name'];
					$accountLedger[$incPayment['fkpayment_account']][$payId]['transaction']   = "Payment for Income No ".$incPayment['income_no'];
					$accountLedger[$incPayment['fkpayment_account']][$payId]['credit_amount'] = 0.00;
					$accountLedger[$incPayment['fkpayment_account']][$payId]['debit_amount']  = $incPayment['payment_amount'];

					if($incPayment['discount_amount']!=0) {

						if(isset($incomes[$incPayment['income_no']]['tax_value']) && $incomes[$incPayment['income_no']]['tax_value']!=0) {
							$tax_pay = (($incPayment['discount_amount'] * $incomes[$incPayment['income_no']]['tax_value']) / (100+$incomes[$incPayment['income_no']]['tax_value']));
							$discount_amount = $incPayment['discount_amount'] - $tax_pay;

							$accountLedger[11][$payId]['account_type']  = 11;
							$accountLedger[11][$payId]['source'] 		= $incPayment['income_no'];
							$accountLedger[11][$payId]['no'] 		   = "PMT".$incPayment['id'];
							$accountLedger[11][$payId]['type'] 		   = "Income";
							$accountLedger[11][$payId]['date'] 		   = $incPayment['pay_date'];
							$accountLedger[11][$payId]['name'] 		   = $incPayment['customer_name'];
							$accountLedger[11][$payId]['transaction']   = "Payment for Income No ".$incPayment['income_no'];
							$accountLedger[11][$payId]['credit_amount'] = 0.00;
							$accountLedger[11][$payId]['debit_amount']  = $tax_pay;
						} else {
							$discount_amount = $incPayment['discount_amount'];
						}

						$accountLedger[7][$payId]['account_type']  = 7;
						$accountLedger[7][$payId]['source'] 	   = $incPayment['income_no'];
						$accountLedger[7][$payId]['no'] 		   = "PMT".$incPayment['id'];
						$accountLedger[7][$payId]['type'] 		   = "Income";
						$accountLedger[7][$payId]['date'] 		   = $incPayment['pay_date'];
						$accountLedger[7][$payId]['name'] 		   = $incPayment['customer_name'];
						$accountLedger[7][$payId]['transaction']   = "Payment for Income No ".$incPayment['income_no'];
						$accountLedger[7][$payId]['credit_amount'] = 0.00;
						$accountLedger[7][$payId]['debit_amount']  = $discount_amount;

					}

					if($incPayment['credit_term']!=1) {

							$accountLedger[$incPayment['coa_link']][$payId]['account_type']    = $incPayment['coa_link'];
							$accountLedger[$incPayment['coa_link']][$payId]['source']    	   = $incPayment['income_no'];
							$accountLedger[$incPayment['coa_link']][$payId]['no']   		   = "PMT".$incPayment['id'];
							$accountLedger[$incPayment['coa_link']][$payId]['type']  		   = "Income";
							$accountLedger[$incPayment['coa_link']][$payId]['name'] 		   = $incPayment['customer_name'];
							$accountLedger[$incPayment['coa_link']][$payId]['date'] 		   = $incPayment['pay_date'];
							$accountLedger[$incPayment['coa_link']][$payId]['transaction']     = "Payment for Income No ".$incPayment['income_no'];
							/*$accountLedger[$incPayment['coa_link']][$payId]['debit_amount']    = 0.00;
							$accountLedger[$incPayment['coa_link']][$payId]['credit_amount']   = $amount;*/	

							if($incPayment['pay_status']==1 && ($incPayment['final_payment_date'] == $incPayment['pay_date'])) {

								if(isset($accountLedger[$incPayment['coa_link']][$incPayment['income_no']])) {
									$debit_amount   = $accountLedger[$incPayment['coa_link']][$incPayment['income_no']]['debit_amount'];
								} else {
									$receivable = $this->report->getIncomeReceivables($incPayment['inc_id']);
									if(isset($receivable) && !empty($receivable)) {
										foreach ($receivable as $receive) {
											if($incPayment['transaction_currency']!='SGD') {
												$amt = $receive['amount']*$incPayment['exchange_rate'];
											} else {
												$amt = $receive['amount'];
											}
											$debit_amount = round($amt,2);
										}
									} else {
										$debit_amount = 0.00;
									}
								}
								$credit_amount  = 0.00;

								foreach ($accountLedger as $key => $value) {
									foreach ($value as $key1 => $value1) {
										$split = explode("_", $key1);
										if(isset($split[1]) && !empty($split[1]) && $split[1]==$incPayment['income_no']) {
											if(isset($value1['credit_amount'])) {
										    	$credit_amount += $value1['credit_amount'];
											}
										}
									}
								}

								if($debit_amount==0 && $credit_amount==0) {

									$accountLedger[$incPayment['coa_link']][$payId]['credit_amount']   = $amount;
									$accountLedger[$incPayment['coa_link']][$payId]['debit_amount']    = 0.00;

								} else {

									$total_amt = $debit_amount - $credit_amount;

									$accountLedger[$incPayment['coa_link']][$payId]['credit_amount']  = $total_amt;
									$accountLedger[$incPayment['coa_link']][$payId]['debit_amount']   = 0.00;

								}

							} else {

								$accountLedger[$incPayment['coa_link']][$payId]['credit_amount']   = $amount;
								$accountLedger[$incPayment['coa_link']][$payId]['debit_amount']    = 0.00;

							}
					}
				}
			}



			$accountId['expense_pay'][] = 'NULL';
			$accountId['expense_paid'][] = 'NULL';
			if(isset($expenseAccountPay) && !empty($expenseAccountPay)) {
				foreach ($expenseAccountPay as $expPayment) {
						$accountId['expense_pay'][] = $expPayment['exp_id'];
						$amount = $expPayment['payment_amount']+$expPayment['discount_amount'];
						
						/*if($expPayment['pay_status']==1 && $expPayment['transaction_currency']!='SGD') {
							if(isset($accountLedger[2][$expPayment['expense_no']])) {
								$accountLedger[2][$expPayment['expense_no']]['credit_amount'] -= $expPayment['payment_amount'];
							} else {
								$accountLedger[2][$expPayment['expense_no']]['account_type'] = $expPayment['fkpayment_account'];
								$accountLedger[2][$expPayment['expense_no']]['source'] = $expPayment['expense_no'];
								$accountLedger[2][$expPayment['expense_no']]['no'] = "PMT".$expPayment['id'];
								$accountLedger[2][$expPayment['expense_no']]['type'] = "Expense";
								$accountLedger[2][$expPayment['expense_no']]['date'] = $expPayment['pay_date'];
								$accountLedger[2][$expPayment['expense_no']]['name'] = $expPayment['vendor_name'];
								$accountLedger[2][$expPayment['expense_no']]['transaction'] = "Payment for Expense No ".$expPayment['expense_no'];
								$accountLedger[2][$expPayment['expense_no']]['credit_amount'] = $expPayment['payment_amount'];
								$accountLedger[2][$expPayment['expense_no']]['debit_amount'] = 0.00;
							}
						}*/

						/*echo $expPayment['pay_date'];
						echo $expPayment['final_payment_date'];*/

					$payId = $expPayment['id']."_".$expPayment['expense_no']."_pay";
					$entryId = $expPayment['id']."_".$expPayment['expense_no']."_payentry";
					$accountLedger[$expPayment['fkpayment_account']][$payId]['account_type'] = $expPayment['fkpayment_account'];
					$accountLedger[$expPayment['fkpayment_account']][$payId]['source'] = $expPayment['expense_no'];
					$accountLedger[$expPayment['fkpayment_account']][$payId]['no'] = "PMT".$expPayment['id'];
					$accountLedger[$expPayment['fkpayment_account']][$payId]['type'] = "Expense";
					$accountLedger[$expPayment['fkpayment_account']][$payId]['date'] = $expPayment['pay_date'];
					$accountLedger[$expPayment['fkpayment_account']][$payId]['name'] = $expPayment['vendor_name'];
					$accountLedger[$expPayment['fkpayment_account']][$payId]['transaction'] = "Payment for Expense No ".$expPayment['expense_no'];
					$accountLedger[$expPayment['fkpayment_account']][$payId]['credit_amount'] = $expPayment['payment_amount'];
					$accountLedger[$expPayment['fkpayment_account']][$payId]['debit_amount'] = 0.00;

					if($expPayment['discount_amount']!=0) {

						if(isset($expenses[$expPayment['expense_no']]['tax_value']) && $expenses[$expPayment['expense_no']]['tax_value']!=0) {
							$tax_pay = (($expPayment['discount_amount'] * $expenses[$expPayment['expense_no']]['tax_value']) / (100+$expenses[$expPayment['expense_no']]['tax_value']));
							$discount_amount = $expPayment['discount_amount'] - $tax_pay;

							$accountLedger[11][$payId]['account_type']  = 11;
							$accountLedger[11][$payId]['source']  		= $expPayment['expense_no'];
							$accountLedger[11][$payId]['no'] 		   = "PMT".$expPayment['id'];
							$accountLedger[11][$payId]['type'] 		   = "Expense";
							$accountLedger[11][$payId]['date'] 		   = $expPayment['pay_date'];
							$accountLedger[11][$payId]['name'] 		   = $expPayment['vendor_name'];
							$accountLedger[11][$payId]['transaction']   = "Payment for Expense No ".$expPayment['expense_no'];
							$accountLedger[11][$payId]['debit_amount']  = 0.00;
							$accountLedger[11][$payId]['credit_amount']  = $tax_pay;
						} else {
							$discount_amount = $expPayment['discount_amount'];
						}

						$accountLedger[8][$payId]['account_type']  = 8;
						$accountLedger[8][$payId]['source'] 	   = $expPayment['expense_no'];
						$accountLedger[8][$payId]['no'] 		   = "PMT".$expPayment['id'];
						$accountLedger[8][$payId]['type'] 		   = "Expense";
						$accountLedger[8][$payId]['date'] 		   = $expPayment['pay_date'];
						$accountLedger[8][$payId]['name'] 		   = $expPayment['vendor_name'];
						$accountLedger[8][$payId]['transaction']   = "Payment for Expense No ".$expPayment['expense_no'];
						$accountLedger[8][$payId]['debit_amount']  = 0.00;
						$accountLedger[8][$payId]['credit_amount'] = $discount_amount;
								
					}

					if($expPayment['credit_term']!=1) {

							$accountLedger[$expPayment['coa_link']][$payId]['account_type']    = $expPayment['coa_link'];
							$accountLedger[$expPayment['coa_link']][$payId]['source']   	   = $expPayment['expense_no'];
							$accountLedger[$expPayment['coa_link']][$payId]['no']   		   = "PMT".$expPayment['id'];
							$accountLedger[$expPayment['coa_link']][$payId]['type']  		   = "Expense";
							$accountLedger[$expPayment['coa_link']][$payId]['name'] 		   = $expPayment['vendor_name'];
							$accountLedger[$expPayment['coa_link']][$payId]['date'] 		   = $expPayment['pay_date'];
							$accountLedger[$expPayment['coa_link']][$payId]['transaction']     = "Payment for Expense No ".$expPayment['expense_no'];
							
							if($expPayment['pay_status']==1 && ($expPayment['final_payment_date'] == $expPayment['pay_date'])) {

								if(isset($accountLedger[$expPayment['coa_link']][$expPayment['expense_no']])) {
									$credit_amount = $accountLedger[$expPayment['coa_link']][$expPayment['expense_no']]['credit_amount'];
								} else {
									$payables = $this->report->getExpensePayables($expPayment['exp_id']);
									if(isset($payables) && !empty($payables)) {
										foreach ($payables as $payable) {
											if($expPayment['transaction_currency']!='SGD') {
												if($expPayment['total_gst']!=0.00) {
													$amt = ($payable['amount']*$expPayment['exchange_rate'])+$expPayment['total_gst'];
												} else {
													$amt = $payable['amount']*$expPayment['exchange_rate'];
												}
											} else {
												$amt = $payable['amount'];
											}
											$credit_amount = round($amt,2);
										}
									} else {
										$credit_amount = 0.00;
									}
								}
								$debit_amount  = 0.00;

								foreach ($accountLedger as $key => $value) {
									foreach ($value as $key1 => $value1) {
										$split = explode("_", $key1);
										if(isset($split[1]) && !empty($split[1]) && $split[1]==$expPayment['expense_no']) {
											if(isset($value1['debit_amount'])) {
												$debit_amount += $value1['debit_amount'];
											}
										}
									}
								}

								if($debit_amount==0 && $credit_amount==0) {
									$accountLedger[$expPayment['coa_link']][$payId]['debit_amount']    = $amount;
									$accountLedger[$expPayment['coa_link']][$payId]['credit_amount']   = 0.00;

								} else {

									$total_amt = $credit_amount - $debit_amount;

									$accountLedger[$expPayment['coa_link']][$payId]['debit_amount']    = $total_amt;
									$accountLedger[$expPayment['coa_link']][$payId]['credit_amount']   = 0.00;
								}

							} else {

								$accountLedger[$expPayment['coa_link']][$payId]['debit_amount']    = $amount;
								$accountLedger[$expPayment['coa_link']][$payId]['credit_amount']   = 0.00;

							}
								
						
					}


					}
			}


			$accountId['invoice_pay'][] = 'NULL';
			$accountId['invoice_paid'][] = 'NULL';
			if(isset($incomeAccountInvoicePay) && !empty($incomeAccountInvoicePay)) {
				foreach ($incomeAccountInvoicePay as $invPayment) {
						$accountId['invoice_pay'][] = $invPayment['inv_id'];
						$amount = $invPayment['payment_amount']+$invPayment['discount_amount'];

							/*if($invPayment['pay_status']==1 && $invPayment['transaction_currency']!='SGD') {
								//echo $invPayment['payment_amount'];
								if(isset($accountLedger[2][$invPayment['invoice_no']])) {
									$accountLedger[2][$invPayment['invoice_no']]['debit_amount'] -= $invPayment['payment_amount'];
								} else {
									$accountLedger[2][$invPayment['invoice_no']]['account_type'] = $invPayment['fkpayment_account'];
									$accountLedger[2][$invPayment['invoice_no']]['source'] = $invPayment['invoice_no'];
									$accountLedger[2][$invPayment['invoice_no']]['no'] = "PMT".$invPayment['id'];
									$accountLedger[2][$invPayment['invoice_no']]['type'] = "Invoice";
									$accountLedger[2][$invPayment['invoice_no']]['date'] = $invPayment['pay_date'];
									$accountLedger[2][$invPayment['invoice_no']]['name'] = $invPayment['customer_name'];
									$accountLedger[2][$invPayment['invoice_no']]['transaction'] = "Payment for Invoice No ".$invPayment['invoice_no'];
									$accountLedger[2][$invPayment['invoice_no']]['credit_amount'] = 0.00; 
									$accountLedger[2][$invPayment['invoice_no']]['debit_amount'] = $invPayment['payment_amount'];
								}
							}*/
					
							$payId = $invPayment['id']."_".$invPayment['invoice_no']."_pay";
							$entryId = $invPayment['id']."_".$invPayment['invoice_no']."_payentry";
							$accountLedger[$invPayment['fkpayment_account']][$payId]['account_type'] = $invPayment['fkpayment_account'];
							$accountLedger[$invPayment['fkpayment_account']][$payId]['source'] = $invPayment['invoice_no'];
							$accountLedger[$invPayment['fkpayment_account']][$payId]['no'] = "PMT".$invPayment['id'];
							$accountLedger[$invPayment['fkpayment_account']][$payId]['type'] = "Invoice";
							$accountLedger[$invPayment['fkpayment_account']][$payId]['date'] = $invPayment['pay_date'];
							$accountLedger[$invPayment['fkpayment_account']][$payId]['name'] = $invPayment['customer_name'];
							$accountLedger[$invPayment['fkpayment_account']][$payId]['transaction'] = "Payment for Invoice No ".$invPayment['invoice_no'];
							$accountLedger[$invPayment['fkpayment_account']][$payId]['credit_amount'] = 0.00; 
							$accountLedger[$invPayment['fkpayment_account']][$payId]['debit_amount'] = $invPayment['payment_amount'];

							if($invPayment['discount_amount']!=0) {

							if(isset($invoices[$invPayment['invoice_no']]['tax_value']) && $invoices[$invPayment['invoice_no']]['tax_value']!=0) {
								$tax_pay = (($invPayment['discount_amount'] * $invoices[$invPayment['invoice_no']]['tax_value']) / (100+$invoices[$invPayment['invoice_no']]['tax_value']));
								$discount_amount = $invPayment['discount_amount'] - $tax_pay;

								$accountLedger[11][$payId]['account_type']  = 11;
								$accountLedger[11][$payId]['source'] 		= $invPayment['invoice_no'];
								$accountLedger[11][$payId]['no'] 		   = "PMT".$invPayment['id'];
								$accountLedger[11][$payId]['type'] 		   = "Invoice";
								$accountLedger[11][$payId]['date'] 		   = $invPayment['pay_date'];
								$accountLedger[11][$payId]['name'] 		   = $invPayment['customer_name'];
								$accountLedger[11][$payId]['transaction']   = "Payment for Invoice No ".$invPayment['invoice_no'];
								$accountLedger[11][$payId]['credit_amount'] = 0.00;
								$accountLedger[11][$payId]['debit_amount']  = $tax_pay;
							} else {
								$discount_amount = $invPayment['discount_amount'];
							}

								$accountLedger[7][$payId]['account_type']  = 7;
								$accountLedger[7][$payId]['source'] 	   = $invPayment['invoice_no'];
								$accountLedger[7][$payId]['no'] 		   = "PMT".$invPayment['id'];
								$accountLedger[7][$payId]['type'] 		   = "Invoice";
								$accountLedger[7][$payId]['date'] 		   = $invPayment['pay_date'];
								$accountLedger[7][$payId]['name'] 		   = $invPayment['customer_name'];
								$accountLedger[7][$payId]['transaction']   = "Payment for Invoice No ".$invPayment['invoice_no'];
								$accountLedger[7][$payId]['credit_amount'] = 0.00;
								$accountLedger[7][$payId]['debit_amount']  = $discount_amount;
								
							}

						if($invPayment['credit_term']!=1) {

							$accountLedger[$invPayment['coa_link']][$payId]['account_type']    = $invPayment['coa_link'];
							$accountLedger[$invPayment['coa_link']][$payId]['source']    	   = $invPayment['invoice_no'];
							$accountLedger[$invPayment['coa_link']][$payId]['no']   		   = "PMT".$invPayment['id'];
							$accountLedger[$invPayment['coa_link']][$payId]['type']  		   = "Invoice";
							$accountLedger[$invPayment['coa_link']][$payId]['name'] 		   = $invPayment['customer_name'];
							$accountLedger[$invPayment['coa_link']][$payId]['date'] 		   = $invPayment['pay_date'];
							$accountLedger[$invPayment['coa_link']][$payId]['transaction']     = "Payment for Invoice No ".$invPayment['invoice_no'];
							/*$accountLedger[$invPayment['coa_link']][$payId]['debit_amount']    = 0.00;
							$accountLedger[$invPayment['coa_link']][$payId]['credit_amount']   = $amount;	*/

							if($invPayment['pay_status']==1 && ($invPayment['final_payment_date'] == $invPayment['pay_date'])) {

								if(isset($accountLedger[$invPayment['coa_link']][$invPayment['invoice_no']])) {
									$debit_amount   = $accountLedger[$invPayment['coa_link']][$invPayment['invoice_no']]['debit_amount'];
								} else {
									$receivable = $this->report->getInvoiceReceivables($invPayment['inv_id']);
									if(isset($receivable) && !empty($receivable)) {
										foreach ($receivable as $receive) {
											if($invPayment['transaction_currency']!='SGD') {
												$amt = $receive['amount']*$invPayment['exchange_rate'];
											} else {
												$amt = $receive['amount'];
											}
											$debit_amount = $amt;
										}
									} else {
										$debit_amount = 0.00;
									}
								}
								$credit_amount  = 0.00;

								foreach ($accountLedger as $key => $value) {
									foreach ($value as $key1 => $value1) {
										$split = explode("_", $key1);
										if(isset($split[1]) && !empty($split[1]) && $split[1]==$invPayment['invoice_no']) {
											if(isset($value1['credit_amount'])) {
												$credit_amount += $value1['credit_amount'];
											}
										}
									}
								}

								if($debit_amount==0 && $credit_amount==0) {

									$accountLedger[$invPayment['coa_link']][$payId]['credit_amount']   = $amount;
									$accountLedger[$invPayment['coa_link']][$payId]['debit_amount']    = 0.00;

								} else {

									$total_amt = $debit_amount - $credit_amount;

									$accountLedger[$invPayment['coa_link']][$payId]['credit_amount']  = $total_amt;
									$accountLedger[$invPayment['coa_link']][$payId]['debit_amount']   = 0.00;
								}

							} else {

								$accountLedger[$invPayment['coa_link']][$payId]['credit_amount']   = $amount;
								$accountLedger[$invPayment['coa_link']][$payId]['debit_amount']    = 0.00;

							}
						
						}

					}
			}



			if(isset($journalAccount) && !empty($journalAccount)) {
				foreach ($journalAccount as $journal) {
					

					$journId = $journal['jid']."_".$journal['journal_no'];
					$accountLedger[$journal['fkaccount_id']][$journId]['account_type'] = $journal['fkaccount_id'];
					$accountLedger[$journal['fkaccount_id']][$journId]['no'] 		   = $journal['journal_no'];
					$accountLedger[$journal['fkaccount_id']][$journId]['source'] 	   = $journal['journal_no'];
					$accountLedger[$journal['fkaccount_id']][$journId]['type'] 		   = "Journal Entry";
					$accountLedger[$journal['fkaccount_id']][$journId]['name']         = "-";
					$accountLedger[$journal['fkaccount_id']][$journId]['transaction']  = "Journal No ".$journal['journal_no'];
					$accountLedger[$journal['fkaccount_id']][$journId]['credit_amount']= $journal['credit']; 
					$accountLedger[$journal['fkaccount_id']][$journId]['debit_amount'] = $journal['debit'];
					$accountLedger[$journal['fkaccount_id']][$journId]['date']         = $journal['date'];
				}
			}




			$incomeAccountIncome     = $this->report->getGeneralIncomeAccountForeign($from,$to);

			$incomeAccountInvoice    = $this->report->getGeneralInvoiceIncomeAccountForeign($from,$to);

			$expenseAccount  		 = $this->report->getGeneralExpenseAccountForeign($from,$to);

			$incomeAccountIncomePay  = $this->report->getGeneralIncomePayAccountForeign($from,$to);

			$incomeAccountInvoicePay = $this->report->getInvoicePayAccountsForeign($from,$to);

			$expenseAccountPay       = $this->report->getExpensePayAccountsForeign($from,$to);

			$incomeAccountCredit  	 = $this->report->getGeneralCreditAccountForeign($from,$to);

			//echo '<pre>'; print_r($incomeAccountCredit); echo '</pre>';

			foreach ($incomeAccountIncome as $income) {
				
					    $tax_amount   = ($income['amount'] * $income['tax_value'] / 100);
						$total_income = $income['amount']+$tax_amount;	

						if($income['transaction_currency']!='SGD') {
							$converted_rate       = $income['exchange_rate'];
							$converted_amount     = $total_income*$income['exchange_rate'];
						} 
				if($income['final_payment_date'] <= $to) {
					$accountLedger[2][$income['income_no']]['account_type'] 			 = 2;
				    $accountLedger[2][$income['income_no']]['no'] 			 = $income['income_no'];	
					$accountLedger[2][$income['income_no']]['date'] 			 = $income['final_payment_date'];
					$accountLedger[2][$income['income_no']]['type'] 			 = "Income";
					$accountLedger[2][$income['income_no']]['name']  	 = $income['customer_name'];
					$accountLedger[2][$income['income_no']]['amount']    	 = $total_income;
					$accountLedger[2][$income['income_no']]['transaction']      	 = $income['transaction_description'];
					$accountLedger[2][$income['income_no']]['source']      	 = $income['receipt_no'];
					$accountLedger[2][$income['income_no']]['debit_amount'] = round($converted_amount,2);
					$accountLedger[2][$income['income_no']]['credit_amount']       	 = 0.00;
				}

			}

			foreach ($incomeAccountIncomePay as $incomePay) {
				$accountLedger[2][$incomePay['income_no']]['debit_amount']    -= $incomePay['amount'];
			}


			foreach ($incomeAccountInvoice as $invoice) {
				
					    $tax_amount   = $invoice['tax_amount'] ;
						$total_income = $invoice['amount']+$tax_amount;	

						if($invoice['transaction_currency']!='SGD') {
							$converted_rate 	= $invoice['exchange_rate'];
							$converted_amount 	= $total_income*$invoice['exchange_rate'];
						}
					if($invoice['final_payment_date'] <= $to) {
						$accountLedger[2][$invoice['invoice_no']]['account_type'] 			     = 2;
						$accountLedger[2][$invoice['invoice_no']]['no'] 			     = $invoice['invoice_no'];
						$accountLedger[2][$invoice['invoice_no']]['date'] 			 = $invoice['final_payment_date'];
						$accountLedger[2][$invoice['invoice_no']]['type'] 			 = "Invoice";
						$accountLedger[2][$invoice['invoice_no']]['name']  		 = $invoice['customer_name'];
						$accountLedger[2][$invoice['invoice_no']]['amount']    		 = $total_income;
						$accountLedger[2][$invoice['invoice_no']]['transaction']      		 = $invoice['name'];
						$accountLedger[2][$invoice['invoice_no']]['source']      		 = $invoice['invoice_no'];
						$accountLedger[2][$invoice['invoice_no']]['debit_amount'] 	 = round($converted_amount,2);
						$accountLedger[2][$invoice['invoice_no']]['credit_amount']       	 	 = 0.00;
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

					if(isset($accountLedger[2][$credit['invoice_no']])) {
						$credits = $accountLedger[2][$credit['invoice_no']]['debit_amount'] - round($whole_amount,2);
						$accountLedger[2][$invoice['invoice_no']]['debit_amount'] = $credits;
					}
				}
			}


			foreach ($incomeAccountInvoicePay as $invoicePay) {
				$accountLedger[2][$invoicePay['invoice_no']]['debit_amount']    -= $invoicePay['amount'];
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
						$accountLedger[2][$expense['expense_no']]['account_type'] 			     = 2;
						$accountLedger[2][$expense['expense_no']]['no'] 			     = $expense['expense_no'];
						$accountLedger[2][$expense['expense_no']]['date'] 			 = $expense['final_payment_date'];
						$accountLedger[2][$expense['expense_no']]['type'] 			 = "Expense";
						$accountLedger[2][$expense['expense_no']]['name']  		 = $expense['vendor_name'];
						$accountLedger[2][$expense['expense_no']]['amount']    		 = $total_expense;
						$accountLedger[2][$expense['expense_no']]['transaction']      		 = $expense['product_id'];
						$accountLedger[2][$expense['expense_no']]['source']      		 = $expense['expense_no'];
						$accountLedger[2][$expense['expense_no']]['credit_amount'] 	 = round($converted_amount,2);
						$accountLedger[2][$expense['expense_no']]['debit_amount']       	 	 = 0.00;
					}
					
				}

				foreach ($expenseAccountPay as $expensePay) {
					$accountLedger[2][$expensePay['expense_no']]['credit_amount']    -= $expensePay['amount'];
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



			$GlRollOver =  $this->glroll->index($from);


			$retained   =  $this->income->index($from);

			if(isset($GlRollOver[9])) {
				$GlRollOver[9] += round($retained,2);
			} else {
				$GlRollOver[9]  = round($retained,2);
			}


	//		echo '<pre>'; print_r($accounts); echo '</pre>';

/*		$debit_amount = 0;
		$credit_amount = 0;

			foreach ($generalLedger as $gl) {
				$debit_amount += $gl['debit_amount'];
				$credit_amount += $gl['credit_amount'];
			} 
			echo $credit_amount.'<br/>';
			echo $debit_amount;*/

			$this->generalAccount	=  $this->report->getAllAccounts();
			foreach ($accountLedger as $key => $ledger) {
				usort($accountLedger[$key], $this->make_comparer('date'));
			}
			$this->view->rollOver = $GlRollOver;
			$this->accountLedger	=  $accountLedger; 


		}




     		$xml = new SimpleXMLElement('<company/>');

			if(isset($company) && !empty($company)) {


				$product_version = "Accurate Accounting Software";
				$iras_version = "IAFv1.0.0";
				$companies = $xml->addChild('CompanyInfo');
				$companies->addChild('CompanyName',$company[0]['company_name']);
				$companies->addChild('CompanyUEN',$company[0]['company_uen']);
				$companies->addChild('GSTNo',$company[0]['company_gst']);
				$companies->addChild('PeriodStart',$from);
				$companies->addChild('PeriodEnd',$to);
				$companies->addChild('IAFCreationDate',date('Y-m-d'));
				$companies->addChild('ProductVersion',$product_version);
				$companies->addChild('IAFVersion',$iras_version);


			}

			usort($supplier, $this->make_comparer('date'));

			if(isset($supplier) && !empty($supplier)) {

				$totalGst = 0.00;
				$totalSgd = 0.00;
				$totalCount = 0;

				$purchase = $xml->addChild('Purchase');
				

				foreach ($supplier as $key => $supply) {

					$purchaseLines = $purchase->addChild('PurchaseLines');
					$purchaseLines->addChild('SupplierName',$supply['supplierName']);
					$purchaseLines->addChild('SupplierUEN',$supply['supplierUEN']);
					$purchaseLines->addChild('InvoiceDate',$supply['date']);
					$purchaseLines->addChild('InvoiceNo',$supply['invoice_no']);
					$purchaseLines->addChild('PermitNo',$supply['permit_no']);
					$purchaseLines->addChild('LineNo',$supply['lineNo']);
					$purchaseLines->addChild('ProductDescription',$supply['description']);
					$purchaseLines->addChild('PurchaseValueSGD',number_format($supply['amount'],2,'.',''));
					$purchaseLines->addChild('GSTValueSGD',number_format($supply['gst'],2,'.',''));
					$purchaseLines->addChild('TaxCode',$supply['taxcode']);
					$purchaseLines->addChild('FCYCode',$supply['fcurrency']);
					$purchaseLines->addChild('PurchaseFCY',number_format($supply['famount'],2,'.',''));
					$purchaseLines->addChild('GSTFCY',number_format($supply['fgst'],2,'.',''));

					$totalGst += $supply['gst'];
					$totalSgd += $supply['amount'];
					$totalCount++;

				}

				$purchase->addAttribute('PurchaseTotalSGD', number_format($totalSgd,2,'.',''));
				$purchase->addAttribute('GSTTotalSGD',number_format($totalGst,2,'.',''));
				$purchase->addAttribute('TransactionCountTotal',$totalCount);

			}

			usort($customer, $this->make_comparer('date'));

			if(isset($customer) && !empty($customer)) {

				$totalGst = 0.00;
				$totalSgd = 0.00;
				$totalCount = 0;

				$supplies = $xml->addChild('Supply');

				foreach ($customer as $key => $custom) {

					$supplyLines = $supplies->addChild('SupplyLines');
					$supplyLines->addChild('CustomerName',$custom['customerName']);
					$supplyLines->addChild('CustomerUEN',$custom['customerUEN']);
					$supplyLines->addChild('InvoiceDate',$custom['date']);
					$supplyLines->addChild('InvoiceNo',$custom['invoice_no']);
					$supplyLines->addChild('LineNo',$custom['lineNo']);
					$supplyLines->addChild('ProductDescription',$custom['description']);
					$supplyLines->addChild('PurchaseValueSGD',number_format($custom['amount'],2,'.',''));
					$supplyLines->addChild('GSTValueSGD',number_format($custom['gst'],2,'.',''));
					$supplyLines->addChild('TaxCode',$custom['taxcode']);
					$supplyLines->addChild('FCYCode',$custom['fcurrency']);
					$supplyLines->addChild('PurchaseFCY',number_format($custom['famount'],2,'.',''));
					$supplyLines->addChild('GSTFCY',number_format($custom['fgst'],2,'.',''));

					$totalGst += $custom['gst'];
					$totalSgd += $custom['amount'];
					$totalCount++;

				}

				$supplies->addAttribute('SupplyTotalSGD', number_format($totalSgd,2,'.',''));
				$supplies->addAttribute('GSTTotalSGD',number_format($totalGst,2,'.',''));
				$supplies->addAttribute('TransactionCountTotal',$totalCount);

			}

			/*if(isset($generalLedger) && !empty($generalLedger)) {
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

			}*/

			if(isset($this->generalAccount) && !empty($this->generalAccount)) {
				  $debit_amount  = 0.00;
                  $credit_amount = 0.00;
                  $totalCount    = 0;
                  $gl = $xml->addChild('GLData');
                  
                  foreach ($this->generalAccount as $general) {
                  	$heading = 0;
                  	$runningBalance = 0.00;

                  	/*if($general['debit_opening_balance']>0) {
                				$debit = $general['debit_opening_balance'];
                			} else {
                				$debit = 0;
                			}
                			if($general['credit_opening_balance']>0) {
                				$credit = $general['credit_opening_balance'];
                			} else {
                				$credit = 0;
                			}*/
                foreach ($this->view->rollOver as $key => $roll) {
                    if($key==$general['id']) {
                      if($roll!=0) {
                        $heading++;
                        $db = 0.00;
                        $cr = 0.00;
                        if($roll>0) {
                          $db = abs($roll);
                        } else if($roll<0) {
                          $cr = abs($roll);
                        }
                	//if($debit!=0 || $credit!=0) {
                			/*$debit_amount  += $general['debit_opening_balance'];
                			$credit_amount += $general['credit_opening_balance'];*/
                			$runningBalance = $db-$cr;
                			$glLines = $gl->addChild('GLDataLines');
							$glLines->addChild('TransactionDate',date('d-m-Y',strtotime($from)));
							$glLines->addChild('AccountID',$accounts[$general['id']]['acc_id']);
							$glLines->addChild('AccountName',$accounts[$general['id']]['name']);
							$glLines->addChild('TransactionDesciption',"Opening Balance");
							//$glLines->addChild('TransactionID',"");
							//$glLines->addChild('Name',"");
							$glLines->addChild('Debit',$debit);
							$glLines->addChild('Credit',$credit);
							$glLines->addChild('Balance',$runningBalance);
							$totalCount++;
						//}
						}
					}

				}

                   foreach ($this->accountLedger as $keys => $ledger) {
                		if($general['id']==$keys) {

                			if($heading==0) {

                				$glLines = $gl->addChild('GLDataLines');
								$glLines->addChild('TransactionDate',date('d-m-Y',strtotime($from)));
								$glLines->addChild('AccountID',$accounts[$general['id']]['acc_id']);
								$glLines->addChild('AccountName',$accounts[$general['id']]['name']);
								$glLines->addChild('TransactionDesciption',"Opening Balance");
								//$glLines->addChild('TransactionID',"");
								//$glLines->addChild('Name',"");
								$glLines->addChild('Debit','0.00');
								$glLines->addChild('Credit','0.00');
								$glLines->addChild('Balance','0.00');
								$totalCount++;
								$heading++;

                			}
                			
                			foreach ($ledger as $keyss => $data) {
                				if($data['debit_amount']!=0 || $data['credit_amount']!=0) {
	                				if($data['debit_amount']!=0 && $data['debit_amount']>0) {
			                           $runningBalance += $data['debit_amount'];
			                        } else if($data['credit_amount']!=0 && $data['credit_amount']>0) {
			                           $runningBalance -= $data['credit_amount'];
			                        }
			                        $debit_amount  += $data['debit_amount'];
	                				$credit_amount += $data['credit_amount'];
	                				$glLines = $gl->addChild('GLDataLines');
									$glLines->addChild('TransactionDate',date('d-m-Y',strtotime($data['date'])));
									$glLines->addChild('AccountID',$accounts[$general['id']]['acc_id']);
									$glLines->addChild('AccountName',$accounts[$general['id']]['name']);
									$glLines->addChild('TransactionDesciption',ucfirst($data['transaction']));
									$glLines->addChild('TransactionID',$data['no']);
									$glLines->addChild('SourceDocumentID',$data['source']);
									$glLines->addChild('SourceType',$data['type']);
									$glLines->addChild('Name',ucfirst($data['name']));
									$glLines->addChild('Debit',$data['debit_amount']);
									$glLines->addChild('Credit',$data['credit_amount']);
									$glLines->addChild('Balance',$runningBalance);
									$totalCount++;
								}
                			}
                		}
                	}
                    


                   }

                    $gl->addAttribute('TotalDebit', number_format($debit_amount,2,'.',''));
					$gl->addAttribute('TotalCredit',number_format($credit_amount,2,'.',''));
					$gl->addAttribute('TransactionCountTotal',$totalCount);
					$gl->addAttribute('GLTCurrency',"SGD");

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

	public function foreignCurrencyAction() {
		if(!Zend_Session::namespaceIsset('sess_login')) {
		   $this->_redirect('index');
		} else {
			$foreignCurrency  = array();
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
				$from 		  = $current_year;
			$to = date('Y-m-d');
			if($this->_request->isPost()) {
				$postArray  = $this->getRequest()->getPost();
				$from = date('Y-m-d',strtotime($postArray['from_date']));
				$to = date('Y-m-d',strtotime($postArray['to_date']));
			}
			$this->view->from = date('d-m-Y',strtotime($from));
			$this->view->to = date('d-m-Y',strtotime($to));

			$foreignCurrency = array();

			$incomeAccountIncome     = $this->report->getGeneralIncomeAccountForeign($from,$to);

			$incomeAccountInvoice    = $this->report->getGeneralInvoiceIncomeAccountForeign($from,$to);

			$expenseAccount  		 = $this->report->getGeneralExpenseAccountForeign($from,$to);

			$incomeAccountIncomePay  = $this->report->getGeneralIncomePayAccountForeign($from,$to);

			$incomeAccountInvoicePay = $this->report->getInvoicePayAccountsForeign($from,$to);

			$expenseAccountPay       = $this->report->getExpensePayAccountsForeign($from,$to);

			$incomeAccountCredit  	 = $this->report->getGeneralCreditAccountForeign($from,$to);

			//echo '<pre>'; print_r($incomeAccountCredit); echo '</pre>';

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
						$foreignCurrency[$invoice['invoice_no']]['convert_amount'] = $credits;
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


				usort($foreignCurrency, $this->make_comparer('date'));



				//echo '<pre>'; print_r($foreignCurrency); echo '</pre>';

				$this->view->foreignExchange = $foreignCurrency;
			

		}
	}

	public function bankReconcileAction() {
		if(!Zend_Session::namespaceIsset('sess_login')) {
		   $this->_redirect('index');
		} else {
			$accountLedger  = array();
			$accountId      = array();
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
				$from 		  = $current_year;
			$to = date('Y-m-d');

			$account     = $this->_getParam('account');

			if(isset($account) && !empty($account)) {
				$this->view->currentAccount = $this->_getParam('account');
				$gfrom     = $this->_getParam('from_date');
				$gto       = $this->_getParam('to_date');
				if(isset($gfrom) && !empty($gfrom)) {
					$from = date('Y-m-d',strtotime($this->_getParam('from_date')));
				}
				if(isset($gto) && !empty($gto)) {
					$to = date('Y-m-d',strtotime($this->_getParam('to_date')));
				}


				$incomeAccountIncomePay  = $this->report->getGeneralIncomePayBank($from,$to,$account);
				$expenseAccountPay  =  $this->report->getExpensePayBank($from,$to,$account);
				$incomeAccountInvoicePay  =  $this->report->getInvoicePayBank($from,$to,$account);
				$journalBank  =  $this->report->getJournalBank($from,$to,$account);


				$accountId['income_pay'][] = 'NULL';
				$accountId['income_paid'][] = 'NULL';
				if(isset($incomeAccountIncomePay) && !empty($incomeAccountIncomePay)) {
					foreach ($incomeAccountIncomePay as $incPayment) {
							$accountId['income_pay'][] = $incPayment['inc_id'];
							$amount = $incPayment['payment_amount']+$incPayment['discount_amount'];
							
							if($incPayment['pay_status']==1 && $incPayment['transaction_currency']!='SGD') {
								if(isset($accountLedger[2][$incPayment['income_no']])) {
									$accountLedger[2][$incPayment['income_no']]['debit_amount'] -= $incPayment['payment_amount'];
								}
							}

						$payId = $incPayment['id']."_".$incPayment['income_no']."_pay";
						$entryId = $incPayment['id']."_".$incPayment['income_no']."_payentry";
						$accountLedger[$incPayment['fkpayment_account']][$payId]['account_type']  = $incPayment['fkpayment_account'];
						$accountLedger[$incPayment['fkpayment_account']][$payId]['pid'] = $incPayment['id']."_payment";
						$accountLedger[$incPayment['fkpayment_account']][$payId]['no'] 			  = "PMT".$incPayment['id'];
						$accountLedger[$incPayment['fkpayment_account']][$payId]['type'] 		  = "payment";
						$accountLedger[$incPayment['fkpayment_account']][$payId]['date'] 		  = $incPayment['pay_date'];
						$accountLedger[$incPayment['fkpayment_account']][$payId]['bank_date']     = $incPayment['bank_date'];
						$accountLedger[$incPayment['fkpayment_account']][$payId]['name'] 		  = $incPayment['customer_name'];
						$accountLedger[$incPayment['fkpayment_account']][$payId]['transaction']   = "Payment for Income No ".$incPayment['income_no'];
						$accountLedger[$incPayment['fkpayment_account']][$payId]['credit_amount'] = 0.00;
						$accountLedger[$incPayment['fkpayment_account']][$payId]['debit_amount']  = $incPayment['payment_amount'];

						
					}
				}



				$accountId['expense_pay'][] = 'NULL';
				$accountId['expense_paid'][] = 'NULL';
				if(isset($expenseAccountPay) && !empty($expenseAccountPay)) {
					foreach ($expenseAccountPay as $expPayment) {
							$accountId['expense_pay'][] = $expPayment['exp_id'];
							$amount = $expPayment['payment_amount']+$expPayment['discount_amount'];
							
							if($expPayment['pay_status']==1 && $expPayment['transaction_currency']!='SGD') {
								if(isset($accountLedger[2][$expPayment['expense_no']])) {
									$accountLedger[2][$expPayment['expense_no']]['credit_amount'] -= $expPayment['payment_amount'];
								}
							}

						$payId = $expPayment['id']."_".$expPayment['expense_no']."_pay";
						$entryId = $expPayment['id']."_".$expPayment['expense_no']."_payentry";
						$accountLedger[$expPayment['fkpayment_account']][$payId]['account_type'] = $expPayment['fkpayment_account'];
						$accountLedger[$expPayment['fkpayment_account']][$payId]['pid'] = $expPayment['id']."_payment";
						$accountLedger[$expPayment['fkpayment_account']][$payId]['no'] = "PMT".$expPayment['id'];
						$accountLedger[$expPayment['fkpayment_account']][$payId]['type'] = "payment";
						$accountLedger[$expPayment['fkpayment_account']][$payId]['date'] = $expPayment['pay_date'];
						$accountLedger[$expPayment['fkpayment_account']][$payId]['bank_date']     = $expPayment['bank_date'];
						$accountLedger[$expPayment['fkpayment_account']][$payId]['name'] = $expPayment['vendor_name'];
						$accountLedger[$expPayment['fkpayment_account']][$payId]['transaction'] = "Payment for Expense No ".$expPayment['expense_no'];
						$accountLedger[$expPayment['fkpayment_account']][$payId]['credit_amount'] = $expPayment['payment_amount'];
						$accountLedger[$expPayment['fkpayment_account']][$payId]['debit_amount'] = 0.00;

						


						}
				}


				$accountId['invoice_pay'][] = 'NULL';
				$accountId['invoice_paid'][] = 'NULL';
				if(isset($incomeAccountInvoicePay) && !empty($incomeAccountInvoicePay)) {
					foreach ($incomeAccountInvoicePay as $invPayment) {
							$accountId['invoice_pay'][] = $invPayment['inv_id'];
							$amount = $invPayment['payment_amount']+$invPayment['discount_amount'];

								if($invPayment['pay_status']==1 && $invPayment['transaction_currency']!='SGD') {
									//echo $invPayment['payment_amount'];
									if(isset($accountLedger[2][$invPayment['invoice_no']])) {
										$accountLedger[2][$invPayment['invoice_no']]['debit_amount'] -= $invPayment['payment_amount'];
									}
								}
						
								$payId = $invPayment['id']."_".$invPayment['invoice_no']."_pay";
								$entryId = $invPayment['id']."_".$invPayment['invoice_no']."_payentry";
								$accountLedger[$invPayment['fkpayment_account']][$payId]['account_type'] = $invPayment['fkpayment_account'];
								$accountLedger[$invPayment['fkpayment_account']][$payId]['pid'] = $invPayment['id']."_payment";
								$accountLedger[$invPayment['fkpayment_account']][$payId]['no'] = "PMT".$invPayment['id'];
								$accountLedger[$invPayment['fkpayment_account']][$payId]['type'] = "payment";
								$accountLedger[$invPayment['fkpayment_account']][$payId]['date'] = $invPayment['pay_date'];
								$accountLedger[$invPayment['fkpayment_account']][$payId]['bank_date']     = $invPayment['bank_date'];
								$accountLedger[$invPayment['fkpayment_account']][$payId]['name'] = $invPayment['customer_name'];
								$accountLedger[$invPayment['fkpayment_account']][$payId]['transaction'] = "Payment for Invoice No ".$invPayment['invoice_no'];
								$accountLedger[$invPayment['fkpayment_account']][$payId]['credit_amount'] = 0.00; 
								$accountLedger[$invPayment['fkpayment_account']][$payId]['debit_amount'] = $invPayment['payment_amount'];

								

						}
				}

				if(isset($journalBank) && !empty($journalBank)) {
					foreach ($journalBank as $journal) {
								$payId = $journal['jid']."_".$journal['journal_no']."_pay";
								$entryId = $journal['jid']."_".$journal['journal_no']."_payentry";
								$accountLedger[$journal['fkaccount_id']][$payId]['account_type'] = $journal['fkaccount_id'];
								$accountLedger[$journal['fkaccount_id']][$payId]['pid'] = $journal['jid']."_journal";
								$accountLedger[$journal['fkaccount_id']][$payId]['no'] = $journal['journal_no'];
								$accountLedger[$journal['fkaccount_id']][$payId]['type'] = "journal";
								$accountLedger[$journal['fkaccount_id']][$payId]['date'] = $journal['date'];
								$accountLedger[$journal['fkaccount_id']][$payId]['bank_date']     = $journal['bank_date'];
								$accountLedger[$journal['fkaccount_id']][$payId]['name'] = "-";
								$accountLedger[$journal['fkaccount_id']][$payId]['transaction'] = $journal['journal_description'];
								$accountLedger[$journal['fkaccount_id']][$payId]['credit_amount'] = $journal['credit']; 
								$accountLedger[$journal['fkaccount_id']][$payId]['debit_amount'] = $journal['debit'];
					}
				}

				$bankRollover =  $this->bank->index($to,$account);

				$this->view->compBalance = $bankRollover;

				foreach ($accountLedger as $key => $ledger) {
					usort($accountLedger[$key], $this->make_comparer('date'));
				}

				$this->view->accountLedger	=  $accountLedger;

			}

			if(Zend_Session::namespaceIsset('update_success_bank_reconcile')) {
					$this->view->success = 'Bank Date Updated Successfully';
					Zend_Session::namespaceUnset('update_success_bank_reconcile');
				}

			if($this->_request->isPost()) {
				$postArray  = $this->getRequest()->getPost();
				//echo '<pre>'; print_r($postArray); echo '</pre>';
				$this->updateBank = $this->report->updateBankReconcile($postArray);
					if($this->updateBank) {
						$sessSuccess = new Zend_Session_Namespace('update_success_bank_reconcile');
						$sessSuccess->status = 1;
					    $this->_redirect('reports/index/bank-reconcile/?account='.$account.'&from_date='.$gfrom.'&to_date='.$gto);
					}
				
				 
			}

			$this->view->from = date('d-m-Y',strtotime($from));
			$this->view->to = date('d-m-Y',strtotime($to));

			



			$this->view->generalAccount	=  $this->report->getAllAccountsTransaction();
		}
	}

	function make_comparer() {
    // Normalize criteria up front so that the comparer finds everything tidy
    $criteria = func_get_args();
    foreach ($criteria as $index => $criterion) {
        $criteria[$index] = is_array($criterion)
            ? array_pad($criterion, 3, null)
            : array($criterion, SORT_ASC, null);
    }
 
    return function($first, $second) use ($criteria) {
        foreach ($criteria as $criterion) {
            // How will we compare this round?
            list($column, $sortOrder, $projection) = $criterion;
            $sortOrder = $sortOrder === SORT_DESC ? -1 : 1;
 
            // If a projection was defined project the values now
            if ($projection) {
                $lhs = call_user_func($projection, $first[$column]);
                $rhs = call_user_func($projection, $second[$column]);
            }
            else {
                $lhs = $first[$column];
                $rhs = $second[$column];
            }
 
            // Do the actual comparison; do not return if equal
            if ($lhs < $rhs) {
                return -1 * $sortOrder;
            }
            else if ($lhs > $rhs) {
                return 1 * $sortOrder;
            }
        }
 
        return 0; // tiebreakers exhausted, so $first == $second
    };
}


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