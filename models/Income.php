<?php
class Income extends Zend_Db_Table 
{
	protected $getVal;
	public function init() {

		$this->settings    = new Settings();
		$this->account     = new Account();
		$this->report      = new Reports();
		//$this->transaction = new Transaction();

		if(Zend_Session::namespaceIsset('sess_remote_database')) {
			$remoteSession = new Zend_Session_Namespace('sess_remote_database');
			$this->remoteDb = new Zend_Db_Adapter_Pdo_Mysql(array(
							    'host'     =>  $remoteSession->hostName,
							    'username' =>  $remoteSession->userName,
						        'password' =>  $remoteSession->password,
								'dbname'   =>  $remoteSession->dataBase
								)); 
			$authAdapter = new Zend_Auth_Adapter_DbTable($this->remoteDb);
		}

	}



	public function index($from) {

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
				$current_month = date('m-d',strtotime($from));
				$current_year  = date('Y',strtotime($from));
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

			$incomeAccount = $this->getIncomeAccountIncomes($start);
			$incomeAccountInvoice = $this->getIncomeAccountInvoice($start);
			$incomeAccountCredit  = $this->getIncomeAccountCredit($start);
			$expenseAccount  = $this->getExpenseAccountExpenses($start);
			$incomeJournalAccount   = $this->getIncomeJournalAccount($start);
			$expenseJournalAccount  = $this->getExpenseJournalAccount($start);
			$incomeAccountPay  = $this->getIncomeAccountIncomesPay($start);
			$invoiceAccountPay = $this->getIncomeAccountInvoicesPay($start);
			$expenseAccountPay = $this->getExpenseAccountExpensesPay($start);
			$this->incomeCoa  = $this->getIncomeAccount();
			$this->expenseCoa = $this->getExpenseAccount();
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
					if($income['payment_status']==1 && $income['final_payment_date'] <= $start) {
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
					if($invoice['payment_status']==1 && $invoice['final_payment_date'] <= $start) {
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
					if($expense['payment_status']==1 && $expense['final_payment_date'] <= $start) {
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

			foreach ($this->incomeCoa as $inc) {
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

			foreach ($this->expenseCoa as $exp) {
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


			$foreignCurrency = array();

			$incomeAccountIncome     = $this->getGeneralIncomeAccountForeign($start);

			$incomeAccountInvoice    = $this->getGeneralInvoiceIncomeAccountForeign($start);

			$expenseAccount  		 = $this->getGeneralExpenseAccountForeign($start);

			$incomeAccountIncomePay  = $this->getGeneralIncomePayAccountForeign($start);

			$incomeAccountInvoicePay = $this->getInvoicePayAccountsForeign($start);

			$expenseAccountPay       = $this->getExpensePayAccountsForeign($start);

			$incomeAccountCredit  	 = $this->getGeneralCreditAccountForeign($start);


			foreach ($incomeAccountIncome as $income) {
				
					    $tax_amount   = ($income['amount'] * $income['tax_value'] / 100);
						$total_income = $income['amount']+$tax_amount;	

						if($income['transaction_currency']!='SGD') {
							$converted_rate       = $income['exchange_rate'];
							$converted_amount     = $total_income*$income['exchange_rate'];
						} 
				if($income['final_payment_date'] <= $start) {
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
					if($invoice['final_payment_date'] <= $start) {
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

					if($expense['final_payment_date'] <= $start) {
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

			return $totals;

	}








	public function retained($start) {

			$logSession = new Zend_Session_Namespace('sess_login');
				if(isset($logSession->proxy_cid) && !empty($logSession->proxy_cid)) {
					$cid = $logSession->proxy_cid;
				} else {
					$cid = $logSession->cid;
				}
				
/*			$getCompany = $this->account->getCompany($cid);
				foreach ($getCompany as $company) {
					$start_year = $company['financial_year_start_date'];
					$end_year   = $company['financial_year_end_date'];
				}
				$current_month = date('m-d',strtotime($from));
				$current_year  = date('Y',strtotime($from));
				$finance_month = date('m-d',strtotime($start_year));
				if($current_month < $finance_month) {
					$cur_date  = $current_year."-".$finance_month;
					$strtotime = strtotime($cur_date);
					$last_year = strtotime("-1 year",$strtotime);
					$current_year = date('Y-m-d',$last_year);
				} else {
					$current_year = $current_year."-".$finance_month;
				}
				$start 		  = $current_year;*/

			$incomeAccount = $this->getIncomeAccountIncomes($start);
			$incomeAccountInvoice = $this->getIncomeAccountInvoice($start);
			$incomeAccountCredit  = $this->getIncomeAccountCredit($start);
			$expenseAccount  = $this->getExpenseAccountExpenses($start);
			$incomeJournalAccount   = $this->getIncomeJournalAccount($start);
			$expenseJournalAccount  = $this->getExpenseJournalAccount($start);
			$incomeAccountPay  = $this->getIncomeAccountIncomesPay($start);
			$invoiceAccountPay = $this->getIncomeAccountInvoicesPay($start);
			$expenseAccountPay = $this->getExpenseAccountExpensesPay($start);
			$this->incomeCoa  = $this->getIncomeAccount();
			$this->expenseCoa = $this->getExpenseAccount();
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
					if($income['payment_status']==1 && $income['final_payment_date'] <= $start) {
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
					if($invoice['payment_status']==1 && $invoice['final_payment_date'] <= $start) {
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
					if($expense['payment_status']==1 && $expense['final_payment_date'] <= $start) {
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

			foreach ($this->incomeCoa as $inc) {
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

			foreach ($this->expenseCoa as $exp) {
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


			$foreignCurrency = array();

			$incomeAccountIncome     = $this->getGeneralIncomeAccountForeign($start);

			$incomeAccountInvoice    = $this->getGeneralInvoiceIncomeAccountForeign($start);

			$expenseAccount  		 = $this->getGeneralExpenseAccountForeign($start);

			$incomeAccountIncomePay  = $this->getGeneralIncomePayAccountForeign($start);

			$incomeAccountInvoicePay = $this->getInvoicePayAccountsForeign($start);

			$expenseAccountPay       = $this->getExpensePayAccountsForeign($start);

			$incomeAccountCredit  	 = $this->getGeneralCreditAccountForeign($start);


			foreach ($incomeAccountIncome as $income) {
				
					    $tax_amount   = ($income['amount'] * $income['tax_value'] / 100);
						$total_income = $income['amount']+$tax_amount;	

						if($income['transaction_currency']!='SGD') {
							$converted_rate       = $income['exchange_rate'];
							$converted_amount     = $total_income*$income['exchange_rate'];
						} 
				if($income['final_payment_date'] <= $start) {
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
					if($invoice['final_payment_date'] <= $start) {
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

					if($expense['final_payment_date'] <= $start) {
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

			return $totals;

	}




	/**
	* Purpose : get income account incomes and their currency types
	* @param   none
	* @return  amount,income type,tax value and currency
	*/

	public function getIncomeAccountIncomes($from) {
		$where = '(t1.transaction_status=1 AND t1.delete_status=1 AND t1.date < "'.$from.'")';
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'income_transaction'),array('t1.id as inc_id','t1.transaction_currency','t1.payment_status','t1.final_payment_date','t1.exchange_rate','t1.date','t1.fkincome_type','t1.amount','t1.tax_value'))
		   			 ->where($where)
		   			 ->group('t1.id');
		$sql = $this->remoteDb->fetchAll($select);		
		return $sql;
	}

	/**
	* Purpose : get income account incomes from invoice and their currency types
	* @param   none
	* @return  amount,income type,tax value,quantity,discount amount and currency
	*/

	public function getIncomeAccountInvoice($from) {
		$where = 't1.invoice_status=1 AND t1.delete_status=1 AND  t1.date <  "'.$from.'"';
		
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'invoice'),array('t1.id as inv_id','t1.transaction_currency','t1.payment_status','t1.final_payment_date','t1.exchange_rate','t1.date'))
					 ->joinLeft(array('t2' => 'invoice_product_list'),'t2.fkinvoice_id = t1.id',array('t2.id as pid','t2.unit_price','t2.quantity','t2.discount_amount','t2.tax_value','t2.product_description'))
		   			 ->joinLeft(array('t3' => 'products'),'t3.id = t2.product_description',array('t3.fkincomeaccount_id'))
		   			 ->where($where);
		$sql = $this->remoteDb->fetchAll($select);
	    return $sql;
	}
	
	/**
	* Purpose : get income account incomes from credit and their currency types
	* @param   none
	* @return  amount,income type,tax value,quantity and currency
	*/

	public function getIncomeAccountCredit($from) {
		$where = 't1.credit_status=1 AND t1.delete_status=1 AND  t1.date <  "'.$from.'"';
		
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'credit'),array('t1.id as credit_id','t1.transaction_currency','t1.exchange_rate','t1.date'))
					 ->joinLeft(array('t2' => 'credit_product_list'),'t2.fkcredit_id = t1.id',array('t2.id as pid','t2.unit_price','t2.quantity','t2.discount_amount','t2.tax_value','t2.product_description'))
		   			 ->joinLeft(array('t3' => 'products'),'t3.id = t2.product_description',array('t3.fkincomeaccount_id'))
		   			 ->joinLeft(array('t4' => 'invoice'),'t4.id = t1.fkinvoice_id',array('t4.invoice_no','t4.payment_status','t4.final_payment_date'))
		   			 ->where($where);
		$sql = $this->remoteDb->fetchAll($select);
	    return $sql;
	}

	/**
	* Purpose : get expense account expenses and their currency types
	* @param   none
	* @return  amount,expense type,tax value,quantity and currency
	*/

	public function getExpenseAccountExpenses($from) {
		$where = 't1.transaction_status=1 AND t1.delete_status=1 AND  t1.date <  "'.$from.'" AND t3.account_type=4';

		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'expense_transaction'),array('t1.id as exp_id','t1.payment_status','t1.final_payment_date','t1.transaction_currency','t1.exchange_rate','t1.date','t1.total_gst'))
					 ->joinLeft(array('t2' => 'expense_transaction_list'),'t2.fkexpense_id = t1.id',array('t2.id as pid','t2.fkexpense_type','t2.unit_price','t2.quantity','t2.tax_value'))
		   			 ->joinLeft(array('t3' => 'account'),'t2.fkexpense_type=t3.id',array('t3.id as aid'))
		   			 ->where($where);
		   	//$sql = $select->__toString();
			//echo "$sql\n"; die();
		    $sql = $this->remoteDb->fetchAll($select);
			return $sql;
	}

	/**
	* Purpose : get payment  discounts for income account incomes and their currency types
	* @param   none
	* @return  amount,income type,tax value and currency
	*/

	public function getIncomeAccountIncomesPay($from) {
		$where = '(t1.transaction_status=1 AND t1.delete_status=1 AND  t2.date <  "'.$from.'" AND t2.payment_status=1)';
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'income_transaction'),array('t1.id as inc_id','t1.income_no','t1.transaction_currency','t1.payment_status as pay_status','t1.final_payment_date','t1.tax_value','t1.fktax_id'))
					 ->joinLeft(array('t2' => 'payments'),'t2.fkiei_id = t1.id',array('t2.date','pay_amount' => 't2.discount_amount','payment_amount' => 't2.payment_amount'))
		   			 ->where($where)
		   			 /*->group('t1.id')*/;
		$sql = $this->remoteDb->fetchAll($select);		
		return $sql;
	}

	/**
	* Purpose : get payment  discounts for invoice account incomes and their currency types
	* @param   none
	* @return  amount,income type,tax value and currency
	*/

	public function getIncomeAccountInvoicesPay($from) {
		$where = '(t1.invoice_status=1 AND t1.delete_status=1 AND  t2.date <  "'.$from.'" AND t2.payment_status=3)';
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'invoice'),array('t1.id as inv_id','t1.invoice_no','t1.transaction_currency','t1.payment_status as pay_status','t1.final_payment_date'))
					 ->joinLeft(array('t2' => 'payments'),'t2.fkiei_id = t1.id',array('t2.date','pay_amount' => 't2.discount_amount','payment_amount' => 't2.payment_amount'))
		   			 ->joinLeft(array('t3' => 'invoice_product_list'),'t1.id=t3.fkinvoice_id',array('t3.tax_value','t3.fktax_id'))
		   			 ->where($where)
		   			 ->group('t2.id');
		$sql = $this->remoteDb->fetchAll($select);		
		return $sql;
	}

	/**
	* Purpose : get payment  discounts for expense account incomes and their currency types
	* @param   none
	* @return  amount,expense type,tax value and currency
	*/

	public function getExpenseAccountExpensesPay($from) {
		$where = '(t1.transaction_status=1 AND t1.delete_status=1 AND  t2.date <  "'.$from.'" AND t2.payment_status=2)';
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'expense_transaction'),array('t1.id as exp_id','t1.transaction_currency','t1.payment_status as pay_status','t1.final_payment_date','t1.total_gst'))
					 ->joinLeft(array('t2' => 'payments'),'t2.fkiei_id = t1.id',array('t2.date','pay_amount' => 't2.discount_amount','payment_amount' => 't2.payment_amount'))
		   			 ->joinLeft(array('t3' => 'expense_transaction_list'),'t1.id=t3.fkexpense_id',array('t3.tax_value','t3.fktax_id'))
		   			 ->where($where)
		   			 ->group('t2.id');
		$sql = $this->remoteDb->fetchAll($select);		
		return $sql;
	}


    public function getIncomeJournalAccount($from) {			
		$where = 't1.journal_status =1 AND t1.delete_status=1 AND  t1.date <  "'.$from.'" AND t3.account_type=3';

		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'journal_entries'),array('t1.id as journal_id','t1.date'))
					 ->joinLeft(array('t2' => 'journal_entries_list'),'t2.fkjournal_id = t1.id',array('t2.id as jid','t2.debit','t2.credit','t2.fkaccount_id'))
		   			 ->joinLeft(array('t3' => 'account'),'t2.fkaccount_id = t3.id',array('t3.account_type'))
		   			 ->where($where);
		    $sql = $this->remoteDb->fetchAll($select);
			return $sql;
	}



	public function getExpenseJournalAccount($from) {			
		$where = 't1.journal_status =1 AND t1.delete_status=1 AND  t1.date <  "'.$from.'" AND t3.account_type=4';

		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'journal_entries'),array('t1.id as journal_id','t1.date'))
					 ->joinLeft(array('t2' => 'journal_entries_list'),'t2.fkjournal_id = t1.id',array('t2.id as jid','t2.debit','t2.credit','t2.fkaccount_id'))
		   			 ->joinLeft(array('t3' => 'account'),'t2.fkaccount_id = t3.id',array('t3.account_type'))
		   			 ->where($where);
		    $sql = $this->remoteDb->fetchAll($select);
			return $sql;
	}


		public function getGeneralIncomeAccountForeign($from) {			
		$sql = $this->remoteDb->fetchAll('SELECT t1.id as inc_id,t1.income_no,t1.fkincome_type,t1.transaction_description,t1.credit_term,t1.final_payment_date,t1.credit_term,t1.transaction_currency,t1.exchange_rate,t1.amount,t1.tax_value,t1.date,t2.coa_link,t2.customer_name FROM income_transaction as t1 INNER JOIN customers as t2 ON (t1.fkcustomer_id=t2.id) WHERE t1.transaction_status=1 AND t1.delete_status=1 AND t1.payment_status=1 AND t1.transaction_currency!="SGD" AND t1.final_payment_date < "'.$from.'"');
	    return $sql;
	}


	public function getGeneralInvoiceIncomeAccountForeign($from) {			
		$where = 't1.invoice_status=1 AND t1.delete_status=1 AND t1.transaction_currency!="SGD" AND t1.payment_status=1 AND t1.final_payment_date < "'.$from.'"';
		
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'invoice'),array('t1.id as inv_id','t1.invoice_no','t1.credit_term','t1.final_payment_date','t1.credit_term','t1.transaction_currency','t1.exchange_rate','t1.date'))
					 ->joinLeft(array('t2' => 'invoice_product_list'),'t2.fkinvoice_id = t1.id',array('t2.id as pid',"amount" => "sum(t2.unit_price * t2.quantity - t2.discount_amount)","tax_amount" => "sum((t2.unit_price * t2.quantity - t2.discount_amount) * t2.tax_value / 100)"))
		   			 ->joinLeft(array('t3' => 'customers'),'t3.id = t1.fkcustomer_id',array('t3.coa_link','t3.customer_name'))
		   			 ->joinLeft(array('t4' => 'products'),'t4.id = t2.product_description',array('t4.name','t4.description'))
		   			 ->where($where)
		   			 ->group('t1.id');
		    $sql = $this->remoteDb->fetchAll($select);
			return $sql;
	}


	public function getGeneralCreditAccountForeign($from) {			
		$where = 't1.credit_status=1 AND t1.delete_status=1 AND t1.transaction_currency!="SGD" AND t5.payment_status=1 AND t5.final_payment_date < "'.$from.'"';

		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'credit'),array('t1.id as credit_id','t1.credit_no','t1.transaction_currency','t1.exchange_rate','t1.date','t1.memo'))
					 ->joinLeft(array('t2' => 'credit_product_list'),'t2.fkcredit_id = t1.id',array('t2.id as pid','t2.unit_price','t2.quantity','t2.tax_value','t2.product_description','t2.discount_amount'))
		   			 ->joinLeft(array('t3' => 'products'),'t3.id = t2.product_description',array('t3.fkincomeaccount_id','t3.name','t3.description'))
		   			 ->joinLeft(array('t4' => 'customers'),'t4.id = t1.fkcustomer_id',array('t4.coa_link','t4.customer_name'))
		   			 ->joinLeft(array('t5' => 'invoice'),'t5.id = t1.fkinvoice_id',array('t5.invoice_no'))
		   			 ->where($where)
		   			 ->order('t1.date');
		    $sql = $this->remoteDb->fetchAll($select);
			return $sql;
	}



	public function getGeneralExpenseAccountForeign($from) {
		$where = 't1.transaction_status=1 AND t1.delete_status=1 AND t1.transaction_currency!="SGD" AND t1.payment_status=1 AND t1.final_payment_date < "'.$from.'"';
		
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'expense_transaction'),array('t1.id as exp_id','t1.credit_term','t1.expense_no','t1.final_payment_date','t1.transaction_currency','t1.exchange_rate','t1.credit_term','t1.date','t1.total_gst'))
					 ->joinLeft(array('t2' => 'expense_transaction_list'),'t2.fkexpense_id = t1.id',array('t2.id as pid',"amount" => "sum(t2.unit_price * t2.quantity)","tax_amount" => "sum((t2.unit_price * t2.quantity) * t2.tax_value / 100)",'t2.product_id','t2.product_description'))
		   			 ->joinLeft(array('t3' => 'vendors'),'t3.id = t1.fkvendor_id',array('t3.coa_link','t3.vendor_name'))
		   			 ->where($where)
		   			 ->group('t1.id');
		    $sql = $this->remoteDb->fetchAll($select);
			return $sql;
	}


	public function getGeneralIncomePayAccountForeign($from) {
		$where = 't1.payment_status=1 AND t2.payment_status=1 AND t2.transaction_currency!="SGD" AND t2.delete_status=1 AND t2.transaction_status=1 AND  t1.date <  "'.$from.'"';
		
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'payments'),array('t1.id',"amount" =>"sum(t1.payment_amount)",'t1.date as pay_date','t1.fkiei_id as iei_id'))
					 ->joinLeft(array('t2' => 'income_transaction'),'t2.id = t1.fkiei_id',array('t2.id as inc_id','t2.income_no','t2.transaction_currency','t2.exchange_rate','t2.credit_term'))
		   			 ->where($where)
		   			 ->group('t1.fkiei_id');
		$sql = $this->remoteDb->fetchAll($select);
	    return $sql;
	} 

	public function getInvoicePayAccountsForeign($from) {
		$where = 't1.payment_status=3 AND t2.payment_status=1 AND t2.transaction_currency!="SGD" AND t2.delete_status=1 AND t2.invoice_status=1 AND  t1.date <  "'.$from.'"';
		
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'payments'),array('t1.id',"amount" =>"sum(t1.payment_amount)",'t1.date as pay_date'))
					 ->joinLeft(array('t2' => 'invoice'),'t2.id = t1.fkiei_id',array('t2.id as inv_id','t2.invoice_no','t2.transaction_currency','t2.exchange_rate','t2.credit_term'))
		   			 ->where($where)
		   			 ->group('t1.fkiei_id');
		$sql = $this->remoteDb->fetchAll($select);
	    return $sql;
	}


	public function getExpensePayAccountsForeign($from) {
		$where = 't1.payment_status=2 AND t2.payment_status=1 AND t2.transaction_currency!="SGD" AND t2.delete_status=1 AND t2.transaction_status=1 AND  t1.date <  "'.$from.'"';
		
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'payments'),array('t1.id',"amount" =>"sum(t1.payment_amount)",'t1.date as pay_date'))
					 ->joinLeft(array('t2' => 'expense_transaction'),'t2.id = t1.fkiei_id',array('t2.id as exp_id','t2.expense_no','t2.transaction_currency','t2.exchange_rate','t2.credit_term','t2.total_gst'))
		   			 ->where($where)
		   			 ->group('t1.fkiei_id');
		$sql = $this->remoteDb->fetchAll($select);
	    return $sql;
	}


	public function getIncomeAccount() {
		$sql = $this->remoteDb->fetchAll('SELECT id,account_name,account_type,level1,level2,debit_opening_balance,credit_opening_balance FROM account WHERE account_type=3 AND delete_status=1 AND edit_status=1 ORDER BY account_name ASC');
		return $sql;
	}

	/**
	* Purpose  get expense account details for the particular company database
	* @param   none
	* @return  expense account name and id
	*/	

	public function getExpenseAccount() {
		$sql = $this->remoteDb->fetchAll('SELECT id,account_name,account_type,level1,level2,debit_opening_balance,credit_opening_balance FROM account WHERE account_type=4 AND delete_status=1 AND edit_status=1 ORDER BY account_name ASC');
		return $sql;
	}



	}


?>