<?php
class GlRoll extends Zend_Db_Table 
{
	protected $getVal;
	public function init() {

		$this->settings    = new Settings();
		$this->account     = new Account();
		$this->report      = new Reports();

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
				echo $start 		  = $current_year;
				
		
		$incomeAccountIncome  = $this->getGeneralIncomeAccountGl($from);
	    $incomeAccountInvoice = $this->getGeneralInvoiceIncomeAccountGl($from);
	    $incomeAccountCredit  = $this->getGeneralCreditAccountGl($from);
	    $expenseAccount  = $this->getGeneralExpenseAccountGl($from);
	    $journalAccount  = $this->getGeneralJournalAccountGl($from);

		$incomeAccountIncomePay  = $this->getGeneralIncomePayAccountGl($from);
		$expenseAccountPay  =  $this->getExpensePayAccountGl($from);
		$incomeAccountInvoicePay  =  $this->getInvoicePayAccountGl($from);

		$accountLedger = array();

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
						if($income['pay_status']==1 && $income['final_payment_date'] >= $start) {
							$accountLedger[2][$income['income_no']]['account_type']  = 2;
							$accountLedger[2][$income['income_no']]['paid']  = 1;
							$accountLedger[2][$income['income_no']]['type']  		 = "Income";
							$accountLedger[2][$income['income_no']]['debit_amount']   = round($whole_amount,2);
							$accountLedger[2][$income['income_no']]['credit_amount']  = 0.00;
						}
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
					
					if($income['date'] >= $start) {

						$accountLedger[$income['fkincome_type']][$income['income_no']]['account_type']  = $income['fkincome_type'];
						$accountLedger[$income['fkincome_type']][$income['income_no']]['type']  		= "Income";
						$accountLedger[$income['fkincome_type']][$income['income_no']]['credit_amount'] = $converted_amount;
						$accountLedger[$income['fkincome_type']][$income['income_no']]['debit_amount']  = 0.00;

					}

						if($total_tax!=0) {
							$accountLedger[11][$income['income_no']]['account_type']  = 11;
							$accountLedger[11][$income['income_no']]['type']  		  = "Income";
							$accountLedger[11][$income['income_no']]['credit_amount'] = $total_tax;
							$accountLedger[11][$income['income_no']]['debit_amount']  = 0.00;
						}


						if($income['credit_term']!=1) {
							$accountLedger[$income['coa_link']][$income['income_no']]['account_type']   = $income['coa_link'];
							$accountLedger[$income['coa_link']][$income['income_no']]['type']  		    = "Income";
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
						if($invoice['pay_status']==1 && $invoice['final_payment_date'] >= $start && !isset($accountLedger[2][$invoice['invoice_no']])) {
							$accountLedger[2][$invoice['invoice_no']]['account_type']    = 2;
							$accountLedger[2][$invoice['invoice_no']]['paid']    = 1;
							$accountLedger[2][$invoice['invoice_no']]['type'] 		     = "Invoice";
							$accountLedger[2][$invoice['invoice_no']]['debit_amount']    = $whole_amount;
							$accountLedger[2][$invoice['invoice_no']]['credit_amount']    = 0.00;
						} else if($invoice['pay_status']==1 && $invoice['final_payment_date']  >= $start && isset($accountLedger[2][$invoice['invoice_no']])) {
							$accountLedger[2][$invoice['invoice_no']]['debit_amount']    += $whole_amount;
						}
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
						if($invoice['date'] >= $start) {
							$accountLedger[$invoice['fkincomeaccount_id']][$invoice_id]['account_type']   = $invoice['fkincomeaccount_id'];
							$accountLedger[$invoice['fkincomeaccount_id']][$invoice_id]['type'] 		  = "Invoice";
							$accountLedger[$invoice['fkincomeaccount_id']][$invoice_id]['credit_amount']  = $converted_amount;
							$accountLedger[$invoice['fkincomeaccount_id']][$invoice_id]['debit_amount']   = 0.00;
						}

						if($total_tax!=0) {
							if(!isset($accountLedger[11][$invoice['invoice_no']])) {
								$accountLedger[11][$invoice['invoice_no']]['account_type']      = 11;
								$accountLedger[11][$invoice['invoice_no']]['type'] 		  		= "Invoice";
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

						if($invoice['date'] >= $start) {
							$accountLedger[$invoice['fkincomeaccount_id']][$invoice_id]['account_type']   = $invoice['fkincomeaccount_id'];
							$accountLedger[$invoice['fkincomeaccount_id']][$invoice_id]['type'] 		  = "Invoice";
							$accountLedger[$invoice['fkincomeaccount_id']][$invoice_id]['credit_amount']  = $converted_amount;
							$accountLedger[$invoice['fkincomeaccount_id']][$invoice_id]['debit_amount']   = 0.00;
						}

						if($invoice['credit_term']!=1) {
							if(!isset($accountLedger[$invoice['coa_link']][$invoice['invoice_no']])) {
								$accountLedger[$invoice['coa_link']][$invoice['invoice_no']]['account_type']    = $invoice['coa_link'];
								$accountLedger[$invoice['coa_link']][$invoice['invoice_no']]['type']  		    = "Invoice";
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
					if($credit['date'] >= $start) {
						$accountLedger[$credit['fkincomeaccount_id']][$credit_id]['account_type'] 	= $credit['fkincomeaccount_id'];
						$accountLedger[$credit['fkincomeaccount_id']][$credit_id]['type'] 			= "Credit Note";
						$accountLedger[$credit['fkincomeaccount_id']][$credit_id]['credit_amount'] 	= 0.00;
						$accountLedger[$credit['fkincomeaccount_id']][$credit_id]['debit_amount'] 	= $converted_amount;
					}

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
								$accountLedger[11][$credit['credit_no']]['type'] 			= "Credit Note";
								$accountLedger[11][$credit['credit_no']]['credit_amount']   = 0.00;
								$accountLedger[11][$credit['credit_no']]['debit_amount'] 	= $total_tax;
							} else {
								$accountLedger[11][$credit['credit_no']]['credit_amount']    = 0.00;
								$accountLedger[11][$credit['credit_no']]['debit_amount'] 	+= $total_tax;
							}
						}

						if(!isset($accountLedger[$credit['coa_link']][$credit_id])) {
								$accountLedger[$credit['coa_link']][$credit_id]['account_type']     = $credit['coa_link'];
								$accountLedger[$credit['coa_link']][$credit_id]['type']  		    = "Credit Note";
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

						if($expense['pay_status']==1 && $expense['final_payment_date']  >= $start && !isset($accountLedger[2][$expense['expense_no']])) {
							$accountLedger[2][$expense['expense_no']]['account_type']    = 2;
							$accountLedger[2][$expense['expense_no']]['paid']    = 1;
							$accountLedger[2][$expense['expense_no']]['type'] 		     = "Expense";
							$accountLedger[2][$expense['expense_no']]['credit_amount']   = round($whole_amount,2);
							$accountLedger[2][$expense['expense_no']]['debit_amount']    = 0.00;
						} else if($expense['pay_status']==1 && $expense['final_payment_date']  >= $start && isset($accountLedger[2][$expense['expense_no']])) {
							$accountLedger[2][$expense['expense_no']]['credit_amount']   += round($whole_amount,2);
						}
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
					if($expense['date'] >= $start) {
						$accountLedger[$expense['fkexpense_type']][$expense_id]['account_type']  = $expense['fkexpense_type'];
						$accountLedger[$expense['fkexpense_type']][$expense_id]['type'] 		 = "Expense";
						$accountLedger[$expense['fkexpense_type']][$expense_id]['credit_amount'] = 0.00;
						$accountLedger[$expense['fkexpense_type']][$expense_id]['debit_amount']  = $converted_amount;
					}

					if($total_tax!=0) {
						if(!isset($accountLedger[11][$expense['expense_no']])) { 
							$accountLedger[11][$expense['expense_no']]['account_type']   = 11;
							$accountLedger[11][$expense['expense_no']]['type'] 		 	 = "Expense";
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
							$accountLedger[$expense['coa_link']][$expense['expense_no']]['type']  		    = "Expense";
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
						
						if($incPayment['pay_status']==1 && $incPayment['transaction_currency']!='SGD' && $incPayment['pay_date'] >= $start) {
							if(isset($accountLedger[2][$incPayment['income_no']])) {
								$accountLedger[2][$incPayment['income_no']]['debit_amount'] -= $incPayment['payment_amount'];
								$accountLedger[2][$incPayment['income_no']]['paid'] 		  = 2;
							} /*else {
								$accountLedger[2][$incPayment['income_no']]['account_type']  = $incPayment['fkpayment_account'];
								$accountLedger[2][$incPayment['income_no']]['type'] 		  = "Payment";
								$accountLedger[2][$incPayment['income_no']]['paid'] 		  = 2;
								$accountLedger[2][$incPayment['income_no']]['credit_amount'] = 0.00;
								$accountLedger[2][$incPayment['income_no']]['debit_amount']  = $incPayment['payment_amount'];
							}*/
						}

					$payId = $incPayment['id']."_".$incPayment['income_no']."_pay";
					$entryId = $incPayment['id']."_".$incPayment['income_no']."_payentry";
					$accountLedger[$incPayment['fkpayment_account']][$payId]['account_type']  = $incPayment['fkpayment_account'];
					$accountLedger[$incPayment['fkpayment_account']][$payId]['type'] 		  = "Payment";
					$accountLedger[$incPayment['fkpayment_account']][$payId]['credit_amount'] = 0.00;
					$accountLedger[$incPayment['fkpayment_account']][$payId]['debit_amount']  = $incPayment['payment_amount'];

					if($incPayment['discount_amount']!=0) {

						if(isset($incPayment['tax_value']) && $incPayment['tax_value']!=0) {
							$tax_pay = (($incPayment['discount_amount'] * $incPayment['tax_value']) / (100+$incPayment['tax_value']));
							$discount_amount = $incPayment['discount_amount'] - $tax_pay;

							$accountLedger[11][$payId]['account_type']  = 11;
							$accountLedger[11][$payId]['type'] 		   = "Payment";
							$accountLedger[11][$payId]['credit_amount'] = 0.00;
							$accountLedger[11][$payId]['debit_amount']  = $tax_pay;
						} else {
							$discount_amount = $incPayment['discount_amount'];
						}

						if($incPayment['pay_date'] >= $start) {
							$accountLedger[7][$payId]['account_type']  = 7;
							$accountLedger[7][$payId]['type'] 		   = "Payment";
							$accountLedger[7][$payId]['credit_amount'] = 0.00;
							$accountLedger[7][$payId]['debit_amount']  = $discount_amount;
						}

					}

					if($incPayment['credit_term']!=1) {

							$accountLedger[$incPayment['coa_link']][$payId]['account_type']    = $incPayment['coa_link'];
							$accountLedger[$incPayment['coa_link']][$payId]['type']  		   = "Payment";
							/*$accountLedger[$incPayment['coa_link']][$payId]['debit_amount']    = 0.00;
							$accountLedger[$incPayment['coa_link']][$payId]['credit_amount']   = $amount;*/	

							if($incPayment['pay_status']==1 && ($incPayment['final_payment_date'] == $incPayment['pay_date'])) {

								if(isset($accountLedger[$incPayment['coa_link']][$incPayment['income_no']])) {
									$debit_amount   = $accountLedger[$incPayment['coa_link']][$incPayment['income_no']]['debit_amount'];
								} else {
									$debit_amount = 0.00;
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
						
						if($expPayment['pay_status']==1 && $expPayment['transaction_currency']!='SGD' && $expPayment['pay_date'] >= $start) {
							if(isset($accountLedger[2][$expPayment['expense_no']])) {
								$accountLedger[2][$expPayment['expense_no']]['credit_amount'] -= $expPayment['payment_amount'];
								$accountLedger[2][$expPayment['expense_no']]['paid'] 		   = 2;
							} /*else {
								$accountLedger[2][$expPayment['expense_no']]['account_type'] = $expPayment['fkpayment_account'];
								$accountLedger[2][$expPayment['expense_no']]['type'] = "Payment";
								$accountLedger[2][$expPayment['expense_no']]['paid'] 		  = 2;
								$accountLedger[2][$expPayment['expense_no']]['credit_amount'] = $expPayment['payment_amount'];
								$accountLedger[2][$expPayment['expense_no']]['debit_amount'] = 0.00;
							}*/
						}

						/*echo $expPayment['pay_date'];
						echo $expPayment['final_payment_date'];*/

					$payId = $expPayment['id']."_".$expPayment['expense_no']."_pay";
					$entryId = $expPayment['id']."_".$expPayment['expense_no']."_payentry";
					$accountLedger[$expPayment['fkpayment_account']][$payId]['account_type'] = $expPayment['fkpayment_account'];
					$accountLedger[$expPayment['fkpayment_account']][$payId]['type'] = "Payment";
					$accountLedger[$expPayment['fkpayment_account']][$payId]['credit_amount'] = $expPayment['payment_amount'];
					$accountLedger[$expPayment['fkpayment_account']][$payId]['debit_amount'] = 0.00;

					if($expPayment['discount_amount']!=0) {

						if(isset($expPayment['tax_value']) && $expPayment['tax_value']!=0) {
							$tax_pay = (($expPayment['discount_amount'] * $expPayment['tax_value']) / (100+$expPayment['tax_value']));
							$discount_amount = $expPayment['discount_amount'] - $tax_pay;

							$accountLedger[11][$payId]['account_type']  = 11;
							$accountLedger[11][$payId]['type'] 		    = "Payment";
							$accountLedger[11][$payId]['debit_amount']  = 0.00;
							$accountLedger[11][$payId]['credit_amount'] = $tax_pay;
						} else {
							$discount_amount = $expPayment['discount_amount'];
						}

						if($expPayment['pay_date'] >= $start) {

							$accountLedger[8][$payId]['account_type']  = 8;
							$accountLedger[8][$payId]['type'] 		   = "Payment";
							$accountLedger[8][$payId]['debit_amount']  = 0.00;
							$accountLedger[8][$payId]['credit_amount'] = $discount_amount;

						}
								
					}

					if($expPayment['credit_term']!=1) {

							$accountLedger[$expPayment['coa_link']][$payId]['account_type']    = $expPayment['coa_link'];
							$accountLedger[$expPayment['coa_link']][$payId]['type']  		   = "Payment";


							if($expPayment['pay_status']==1 && ($expPayment['final_payment_date'] == $expPayment['pay_date'])) {

								if(isset($accountLedger[$expPayment['coa_link']][$expPayment['expense_no']])) {
									$credit_amount = $accountLedger[$expPayment['coa_link']][$expPayment['expense_no']]['credit_amount'];
								} else {
									$credit_amount = 0.00;
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

							if($invPayment['pay_status']==1 && $invPayment['transaction_currency']!='SGD' && $invPayment['pay_date'] >= $start) {
								//echo $invPayment['payment_amount'];
								if(isset($accountLedger[2][$invPayment['invoice_no']])) {
									$accountLedger[2][$invPayment['invoice_no']]['debit_amount'] -= $invPayment['payment_amount'];
									$accountLedger[2][$invPayment['invoice_no']]['paid'] = 2;
								} /*else {
									$accountLedger[2][$invPayment['invoice_no']]['account_type'] = $invPayment['fkpayment_account'];
									$accountLedger[2][$invPayment['invoice_no']]['type'] = "Payment";
									$accountLedger[2][$invPayment['invoice_no']]['paid'] = 2;
									$accountLedger[2][$invPayment['invoice_no']]['credit_amount'] = 0.00; 
									$accountLedger[2][$invPayment['invoice_no']]['debit_amount'] = $invPayment['payment_amount'];
								}*/
							}
					
							$payId = $invPayment['id']."_".$invPayment['invoice_no']."_pay";
							$entryId = $invPayment['id']."_".$invPayment['invoice_no']."_payentry";
							$accountLedger[$invPayment['fkpayment_account']][$payId]['account_type'] = $invPayment['fkpayment_account'];
							$accountLedger[$invPayment['fkpayment_account']][$payId]['type'] = "Payment";
							$accountLedger[$invPayment['fkpayment_account']][$payId]['credit_amount'] = 0.00; 
							$accountLedger[$invPayment['fkpayment_account']][$payId]['debit_amount'] = $invPayment['payment_amount'];

							if($invPayment['discount_amount']!=0) {

							if(isset($invPayment['tax_value']) && $invPayment['tax_value']!=0) {
								$tax_pay = (($invPayment['discount_amount'] * $invPayment['tax_value']) / (100+$invPayment['tax_value']));
								$discount_amount = $invPayment['discount_amount'] - $tax_pay;

								$accountLedger[11][$payId]['account_type']  = 11;
								$accountLedger[11][$payId]['type'] 		   = "Payment";
								$accountLedger[11][$payId]['credit_amount'] = 0.00;
								$accountLedger[11][$payId]['debit_amount']  = $tax_pay;
							} else {
								$discount_amount = $invPayment['discount_amount'];
							}

								if($invPayment['pay_date'] >= $start) {

									$accountLedger[7][$payId]['account_type']  = 7;
									$accountLedger[7][$payId]['type'] 		   = "Payment";
									$accountLedger[7][$payId]['credit_amount'] = 0.00;
									$accountLedger[7][$payId]['debit_amount']  = $discount_amount;

								}
								
							}

						if($invPayment['credit_term']!=1) {

							$accountLedger[$invPayment['coa_link']][$payId]['account_type']    = $invPayment['coa_link'];
							$accountLedger[$invPayment['coa_link']][$payId]['type']  		   = "Payment";
							/*$accountLedger[$invPayment['coa_link']][$payId]['debit_amount']    = 0.00;
							$accountLedger[$invPayment['coa_link']][$payId]['credit_amount']   = $amount;	*/

							if($invPayment['pay_status']==1 && ($invPayment['final_payment_date'] == $invPayment['pay_date'])) {

								if(isset($accountLedger[$invPayment['coa_link']][$invPayment['invoice_no']])) {
									$debit_amount   = $accountLedger[$invPayment['coa_link']][$invPayment['invoice_no']]['debit_amount'];
								} else {
									$debit_amount = 0.00;
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
					
					if($journal['account_type']==1 || $journal['account_type']==2 || $journal['account_type']==3) {

						$journId = $journal['jid']."_".$journal['journal_no'];
						$accountLedger[$journal['fkaccount_id']][$journId]['account_type'] = $journal['fkaccount_id'];
						$accountLedger[$journal['fkaccount_id']][$journId]['type'] 		   = "Journal Entry";
						$accountLedger[$journal['fkaccount_id']][$journId]['credit_amount']= $journal['credit']; 
						$accountLedger[$journal['fkaccount_id']][$journId]['debit_amount'] = $journal['debit'];

					} else if(($journal['account_type']==4 || $journal['account_type']==5) && $journal['date'] >= $start) {


						$journId = $journal['jid']."_".$journal['journal_no'];
						$accountLedger[$journal['fkaccount_id']][$journId]['account_type'] = $journal['fkaccount_id'];
						$accountLedger[$journal['fkaccount_id']][$journId]['type'] 		   = "Journal Entry";
						$accountLedger[$journal['fkaccount_id']][$journId]['credit_amount']= $journal['credit']; 
						$accountLedger[$journal['fkaccount_id']][$journId]['debit_amount'] = $journal['debit'];

					}
				}
			}


			//echo '<pre>'; print_r($accountLedger); echo '</pre>';

			$generalAccount	=  $this->report->getAllAccounts();

			$oldGl = array();

			$debit_amount = 0.00;
            $credit_amount = 0.00;
            foreach ($generalAccount as $general) {
            	$heading = 0;
                $i = 0;
                $runningBalance = 0.00;
                if($general['debit_opening_balance']>0 || $general['credit_opening_balance']>0) {

                	if($general['debit_opening_balance']!=0 && $general['debit_opening_balance']>0) {
                        $runningBalance = $general['debit_opening_balance'];
                    } else if($general['credit_opening_balance']!=0 && $general['credit_opening_balance']>0) {
                        $runningBalance = -($general['credit_opening_balance']);
                    }

                }

                foreach ($accountLedger as $keys => $ledger) {
                	if($general['id']==$keys) {

                		foreach ($ledger as $keyss => $data) {

                			$debit_amount  = abs($data['debit_amount']);
                        	$credit_amount = abs($data['credit_amount']);

                        	if($general['id']==2) { 
                        		if($data['paid']==2) {
	                        		$db = 0.00;
			                        $cr = 0.00;
			                        if($data['type']=='Income' || $data['type']=='Invoice') {
			                          if($data['debit_amount'] < 0) {
			                            $db = abs($data['credit_amount']);
			                            $cr = abs($data['debit_amount']);
			                          } else {
			                            $db = abs($data['debit_amount']);
			                            $cr = abs($data['credit_amount']);
			                          }
			                        } else if($data['type']=='Expense') {
			                          if($data['credit_amount'] < 0) {
			                            $db = abs($data['credit_amount']);
			                            $cr = abs($data['debit_amount']);
			                          } else {
			                            $db = abs($data['debit_amount']);
			                            $cr = abs($data['credit_amount']);
			                          }
			                        }

					              if($db!=0 && $db>0) {
		                            $runningBalance += $db;
		                          } else if($cr!=0 && $cr>0) {
		                            $runningBalance -= $cr;
		                          }
		                         }

                        	} else {

	                        	if($debit_amount!=0 && $debit_amount>0) {
		                            $runningBalance += round($debit_amount,2);
		                          } else if($credit_amount!=0 && $credit_amount>0) {
		                            $runningBalance -= round($credit_amount,2);
		                          }

		                    }

	                          $runningBalance = round($runningBalance,2);

	                          /*if($general['id']==3) {
	                          	echo $debit_amount.', ';
	                          	echo $credit_amount.', ';
	                          	echo $runningBalance.'<br/>';
	                          }*/

                		}

                	}

                }


                $oldGl[$general['id']] = $runningBalance;


            }


           return $oldGl;

	}



	public function getGeneralIncomeAccountGl($from) {			
		$sql = $this->remoteDb->fetchAll('SELECT t1.id as inc_id,t1.income_no,t1.receipt_no,t1.fkincome_type,t1.transaction_description,t1.credit_term,t1.transaction_currency,t1.exchange_rate,t1.amount,t1.tax_value,t1.transaction_description,t1.date,t1.final_payment_date,t1.payment_status as pay_status,t2.coa_link,t2.customer_name FROM income_transaction as t1 INNER JOIN customers as t2 ON (t1.fkcustomer_id=t2.id) WHERE t1.transaction_status=1 AND t1.delete_status=1 AND t1.date < "'.$from.'" ORDER BY t1.date');
	    return $sql;
	}

	public function getGeneralInvoiceIncomeAccountGl($from) {			
		$where = 't1.invoice_status=1 AND t1.delete_status=1 AND t1.date < "'.$from.'"';
		
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'invoice'),array('t1.id as inv_id','t1.invoice_no','t1.transaction_currency','t1.exchange_rate','t1.final_payment_date','t1.payment_status as pay_status','t1.date','t1.credit_term','t1.memo'))
					 ->joinLeft(array('t2' => 'invoice_product_list'),'t2.fkinvoice_id = t1.id',array('t2.id as pid','t2.unit_price','t2.quantity','t2.discount_amount','t2.tax_value','t2.product_description'))
		   			 ->joinLeft(array('t3' => 'products'),'t3.id = t2.product_description',array('t3.fkincomeaccount_id','t3.name','t3.description'))
		   			 ->joinLeft(array('t4' => 'customers'),'t4.id = t1.fkcustomer_id',array('t4.coa_link','t4.customer_name'))
		   			 ->where($where)
		   			 ->order('t1.date');
		    $sql = $this->remoteDb->fetchAll($select);
			return $sql;
	}

	public function getGeneralCreditAccountGl($from) {			
		$where = 't1.credit_status=1 AND t1.delete_status=1 AND t1.date < "'.$from.'"';

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

	public function getGeneralExpenseAccountGl($from) {
		$where = 't1.transaction_status=1 AND t1.delete_status=1 AND t1.date < "'.$from.'"';

		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'expense_transaction'),array('t1.id as exp_id','t1.expense_no','t1.receipt_no','t1.final_payment_date','t1.payment_status as pay_status','t1.transaction_currency','t1.exchange_rate','t1.date','t1.credit_term','t1.total_gst'))
					 ->joinLeft(array('t2' => 'expense_transaction_list'),'t2.fkexpense_id = t1.id',array('t2.id as pid','t2.fkexpense_type','t2.unit_price','t2.quantity','t2.tax_value','t2.product_description','t2.product_id'))
		   			 ->joinLeft(array('t3' => 'vendors'),'t3.id = t1.fkvendor_id',array('t3.coa_link','t3.vendor_name'))
		   			 ->where($where)
		   			 ->order('t1.date');
		    $sql = $this->remoteDb->fetchAll($select);
			return $sql;
	}

	public function getGeneralJournalAccountGl($from) {			
		$where = 't1.journal_status =1 AND t1.delete_status=1 AND t1.date < "'.$from.'"';

		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'journal_entries'),array('t1.id as journal_id','t1.journal_no','t1.date'))
					 ->joinLeft(array('t2' => 'journal_entries_list'),'t2.fkjournal_id = t1.id',array('t2.id as jid','t2.debit','t2.credit','t2.fkaccount_id','t2.journal_description'))
		   			 ->joinLeft(array('t3' => 'account'),'t2.fkaccount_id=t3.id',array('t3.account_type'))
		   			 ->where($where)
		   			 ->order('t1.date');
		    $sql = $this->remoteDb->fetchAll($select);
			return $sql;
	}


	/**
	* Purpose : get payments made for payment account in income and their currency types
	* @param   none
	* @return  amount, currency and fkiei_id
	*/

	public function getGeneralIncomePayAccountGl($from) {
		$where = 't1.payment_status=1 AND t2.delete_status=1 AND t2.transaction_status=1 AND t1.date < "'.$from.'"';

		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'payments'),array('t1.id','t1.fkpayment_account','t1.payment_description','t1.discount_amount','t1.payment_amount','t1.date as pay_date','t1.fkiei_id as iei_id'))
					 ->joinLeft(array('t2' => 'income_transaction'),'t2.id = t1.fkiei_id',array('t2.id as inc_id','t2.final_payment_date','t2.payment_status as pay_status','t2.income_no','t2.transaction_currency','t2.exchange_rate','t2.credit_term','t2.tax_value'))
		   			 ->joinLeft(array('t3' => 'customers'),'t3.id = t2.fkcustomer_id',array('t3.coa_link','t3.customer_name'))
		   			 ->where($where)
		   			 ->group('t1.id');
		$sql = $this->remoteDb->fetchAll($select);
	    return $sql;
	} 


	public function getExpensePayAccountGl($from) {
		$where = 't1.payment_status=2 AND t2.delete_status=1 AND t2.transaction_status=1 AND t1.date < "'.$from.'"';

		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'payments'),array('t1.id','t1.fkpayment_account','t1.payment_description','t1.discount_amount','t1.payment_amount','t1.date as pay_date'))
					 ->joinLeft(array('t2' => 'expense_transaction'),'t2.id = t1.fkiei_id',array('t2.id as exp_id','t2.final_payment_date','t2.payment_status as pay_status','t2.expense_no','t2.transaction_currency','t2.exchange_rate','t2.credit_term','t2.total_gst'))
		   			 ->joinLeft(array('t3' => 'vendors'),'t3.id = t2.fkvendor_id',array('t3.coa_link','t3.vendor_name'))
		   			 ->joinLeft(array('t4' => 'expense_transaction_list'),'t2.id = t4.fkexpense_id',array('t4.tax_value'))
		   			 ->where($where)
		   			 ->group('t1.id');
		$sql = $this->remoteDb->fetchAll($select);
	    return $sql;
	}

	public function getInvoicePayAccountGl($from) {
		$where = 't1.payment_status=3 AND t2.delete_status=1 AND t2.invoice_status=1 AND t1.date < "'.$from.'"';

		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'payments'),array('t1.id','t1.fkpayment_account','t1.payment_description','t1.discount_amount','t1.payment_amount','t1.date as pay_date'))
					 ->joinLeft(array('t2' => 'invoice'),'t2.id = t1.fkiei_id',array('t2.id as inv_id','t2.final_payment_date','t2.payment_status as pay_status','t2.invoice_no','t2.transaction_currency','t2.exchange_rate','t2.credit_term'))
		   			 ->joinLeft(array('t3' => 'customers'),'t3.id = t2.fkcustomer_id',array('t3.coa_link','t3.customer_name'))
		   			 ->joinLeft(array('t4' => 'invoice_product_list'),'t2.id = t4.fkinvoice_id',array('t4.tax_value'))
		   			 ->where($where)
		   			 ->group('t1.id');
		$sql = $this->remoteDb->fetchAll($select);
	    return $sql;
	}


}