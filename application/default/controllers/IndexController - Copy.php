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
						$remoteSession->userName = "root";
						$remoteSession->password = "";
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
							 	$database_name = "ummtech1_accounting_".$result;
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
				
			$from = date('Y-01-01');
			$to = date('Y-m-d');

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

			//echo '<pre>'; print_r($expenseAccountPay); echo '</pre>';
			$incomeStatement[7]['credit']  = 0.00;
			$incomeStatement[7]['debit']   = 0.00;
			$incomeStatement[7]['type']    = 1;

			$incomeStatement[8]['credit']  = 0.00;
			$incomeStatement[8]['debit']   = 0.00;
			$incomeStatement[8]['type']    = 2;

			foreach ($incomeAccount as $income) {
				if($income['transaction_currency']!='SGD') {
					$converted_amount = $income['amount']*$income['exchange_rate'];
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
				if($invoice['transaction_currency']!='SGD') {
					$converted_amount = $total_income*$invoice['exchange_rate'];
					if($discount_amount!=0) {
						$discount_amount  = $discount_amount*$invoice['exchange_rate'];
					} else {
						$discount_amount  = $discount_amount;
					}
				} else {
					$converted_amount = $total_income;
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

				if(array_key_exists(7, $incomeStatement)) {
					$incomeStatement[7]['debit'] += $discount_amount;
				} else {
					$incomeStatement[7]['credit']  = 0.00;
					$incomeStatement[7]['debit']   = 0.00;
					$incomeStatement[7]['debit']  += $discount_amount;
				}
			}

			foreach ($incomeAccountCredit as $credit) {
				$discount_amount   = $credit['discount_amount'];
				$total_income      = $credit['unit_price']*$credit['quantity'];
				if($credit['transaction_currency']!='SGD') {
					$converted_amount = $total_income*$credit['exchange_rate'];
					if($discount_amount!=0) {
						$discount_amount  = $discount_amount*$credit['exchange_rate'];
					} else {
						$discount_amount  = $discount_amount;
					}
				} else {
					$converted_amount = $total_income;
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

				if(array_key_exists(7, $incomeStatement)) {
					$incomeStatement[7]['credit'] += $discount_amount;
				} else {
					$incomeStatement[7]['credit']  = 0.00;
					$incomeStatement[7]['debit']   = 0.00;
					$incomeStatement[7]['credit'] += $discount_amount;
				}
			}

			foreach ($expenseAccount as $expense) {
				$total_expense  = $expense['unit_price']*$expense['quantity'];
				if($expense['transaction_currency']!='SGD') {
					$converted_amount = $total_expense*$expense['exchange_rate'];
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
				if($incomePay['pay_amount']!=0) {
					if(array_key_exists(7, $incomeStatement)) {
						$incomeStatement[7]['debit']  += $incomePay['pay_amount'];
					} else {
						$incomeStatement[7]['credit']  = 0.00;
						$incomeStatement[7]['debit']   = 0.00;
						$incomeStatement[7]['debit']  += $incomePay['pay_amount'];
					}
				}
			}

			foreach ($invoiceAccountPay as $invoicePay) {
				if($invoicePay['pay_amount']!=0) {
					if(array_key_exists(7, $incomeStatement)) {
						$incomeStatement[7]['debit']  += $invoicePay['pay_amount'];
					} else {
						$incomeStatement[7]['credit']  = 0.00;
						$incomeStatement[7]['debit']   = 0.00;
						$incomeStatement[7]['debit']  += $invoicePay['pay_amount'];
					}
				}
			}

			foreach ($expenseAccountPay as $expensePay) {
				if($expensePay['pay_amount']!=0) {
					if(array_key_exists(8, $incomeStatement)) {
						$incomeStatement[8]['credit'] += $expensePay['pay_amount'];
					} else {
						$incomeStatement[8]['credit']  = 0.00;
						$incomeStatement[8]['debit']   = 0.00;
						$incomeStatement[8]['credit']  += $expensePay['pay_amount'];
					}
				}
			}

			$total_income  = 0.00;
			$total_expense = 0.00;
			$total         = 0.00;

			foreach ($incomeStatement as $key=> $inc) {
				if($inc['type']==1) {
					if($key==7) {
						$amount = -($inc['credit']-$inc['debit']);
						$total_income += $amount;
					} else {
						$amount = ($inc['credit']-$inc['debit']);
						$total_income += $amount;
					}
				} else if($inc['type']==2) {
					if($key==8) {
						$amount = -($inc['debit']-$inc['credit']);
						$total_expense += $amount;
					} else {
						$amount = ($inc['debit']-$inc['credit']);
						$total_expense += $amount;
					}
				} 
			}

			$total = $total_income-$total_expense;

			echo '<tr><td>Income</td><td style="text-align:right">'.number_format($total_income,2,'.',',').'</td></tr>';
			echo '<tr><td>Expense</td><td style="text-align:right">'.number_format($total_expense,2,'.',',').'</td></tr>';
			if($total<0) {
				echo '<tr><td>Net Income</td><td style="text-align:right">('.number_format(abs($total),2,'.',',').')</td></tr>';
			} else {
				echo '<tr><td>Net Income</td><td style="text-align:right">'.number_format($total,2,'.',',').'</td></tr>';
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

				foreach ($incomeAccountReceivable as $incomeReceive) {
						if($incomeReceive['transaction_currency']!='SGD') {
							$converted_pending_amount = $incomeReceive['amount']*$incomeReceive['exchange_rate'];
						} else {
							$converted_pending_amount = $incomeReceive['amount'];
						}
						$inc_date = $incomeReceive['inc_date'];
						if($incomeReceive['credit_term']!=1) {
							$days     = $this->view->creditTerm[$incomeReceive['credit_term']];
							$due_date = date('Y-m-d', strtotime("$inc_date +$days day")); 
						} else {
							$due_date = $inc_date;
						}
						$incomeReceivable[$incomeReceive['fkcustomer_id']][$incomeReceive['income_no']] = array('due_date' => $due_date,'amount' => $converted_pending_amount,'currency' => $incomeReceive['transaction_currency'],'paid' => '0.00','pending' => $converted_pending_amount);
				}

				foreach ($incomeAccountCash as $incomeCash) {
					if(array_key_exists($incomeCash['fkcustomer_id'], $incomeReceivable)) {
						$incomeReceivable[$incomeCash['fkcustomer_id']][$incomeCash['income_no']]['paid'] += $incomeCash['pay_amount'];
						$totalAmount = $incomeReceivable[$incomeCash['fkcustomer_id']][$incomeCash['income_no']]['amount'] - $incomeReceivable[$incomeCash['fkcustomer_id']][$incomeCash['income_no']]['paid'];
						
						$incomeReceivable[$incomeCash['fkcustomer_id']][$incomeCash['income_no']]['pending']  = $totalAmount;
					}
				}

				foreach ($incomeAccountInvoiceReceivable as $incomeInvoiceReceive) {
					if($incomeInvoiceReceive['transaction_currency']!='SGD') {
						$converted_pending_amount = $incomeInvoiceReceive['amount']*$incomeInvoiceReceive['exchange_rate'];
					} else {
						$converted_pending_amount = $incomeInvoiceReceive['amount'];
					}
					$incomeReceivable[$incomeInvoiceReceive['fkcustomer_id']][$incomeInvoiceReceive['invoice_no']] = array('due_date' => $incomeInvoiceReceive['due_date'],'amount' => $converted_pending_amount,'currency' => $incomeInvoiceReceive['transaction_currency'],'paid' => '0.00','pending' => $converted_pending_amount);
				}

				foreach ($incomeAccountInvoiceCash as $incomeInvoiceCash) {
					if(array_key_exists($incomeInvoiceCash['fkcustomer_id'], $incomeReceivable)) {
						$incomeReceivable[$incomeInvoiceCash['fkcustomer_id']][$incomeInvoiceCash['invoice_no']]['paid'] += $incomeInvoiceCash['pay_amount'];
						$totalAmount = $incomeReceivable[$incomeInvoiceCash['fkcustomer_id']][$incomeInvoiceCash['invoice_no']]['amount'] - $incomeReceivable[$incomeInvoiceCash['fkcustomer_id']][$incomeInvoiceCash['invoice_no']]['paid'];
						
						$incomeReceivable[$incomeInvoiceCash['fkcustomer_id']][$incomeInvoiceCash['invoice_no']]['pending']  = $totalAmount;
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
                            if($days>=0) {
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
		     		
					foreach ($expenseAccountPayable as $expensePay) {
							if($expensePay['transaction_currency']!='SGD') {
								$converted_pending_amount = $expensePay['amount']*$expensePay['exchange_rate'];
							} else {
								$converted_pending_amount = $expensePay['amount'];
							}
							$expensePayable[$expensePay['fkvendor_id']][$expensePay['expense_no']] = array('due_date' => $expensePay['due_date'],'amount' => $converted_pending_amount,'currency' => $expensePay['transaction_currency'],'paid' => '0.00','pending' => $converted_pending_amount);
					}

					foreach ($expenseAccountCash as $expenseCash) {
						if(array_key_exists($expenseCash['fkvendor_id'], $expensePayable)) {
							$expensePayable[$expenseCash['fkvendor_id']][$expenseCash['expense_no']]['paid'] += $expenseCash['pay_amount'];
							$totalAmount = $expensePayable[$expenseCash['fkvendor_id']][$expenseCash['expense_no']]['amount'] - $expensePayable[$expenseCash['fkvendor_id']][$expenseCash['expense_no']]['paid'];
							
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
                      if($days>=0) {
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
	  $from = date('Y-01-01');
	  $to = date('Y-m-d');

	  $incomeStatement = array();

	  $expenseAccount  = $this->report->getExpenseAccountExpenses($from,$to);
	  $expenseJournalAccount  = $this->report->getExpenseJournalAccount($from,$to);
	  $expenseAccountPay = $this->report->getExpenseAccountExpensesPay($from,$to);
	  $this->expenseCoa = $this->transaction->getExpenseAccount();

	  		$incomeStatement[8]['credit']  = 0.00;
			$incomeStatement[8]['debit']   = 0.00;
			$incomeStatement[8]['type']    = 2;

	  		foreach ($expenseAccount as $expense) {
				$total_expense  = $expense['unit_price']*$expense['quantity'];
				if($expense['transaction_currency']!='SGD') {
					$converted_amount = $total_expense*$expense['exchange_rate'];
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

			foreach ($expenseAccountPay as $expensePay) {
				if($expensePay['pay_amount']!=0) {
					if(array_key_exists(8, $incomeStatement)) {
						$incomeStatement[8]['credit'] += $expensePay['pay_amount'];
					} else {
						$incomeStatement[8]['credit']  = 0.00;
						$incomeStatement[8]['debit']   = 0.00;
						$incomeStatement[8]['credit']  += $expensePay['pay_amount'];
					}
				}
			}

	 $json = '{
  "cols": [
        {"id":"","label":"Topping","pattern":"","type":"string"},
        {"id":"","label":"Slices","pattern":"","type":"number"}
      ],
  "rows": [';

  	foreach ($incomeStatement as $key => $inc) {
  		foreach ($this->expenseCoa as $expenseCoa) {
  			if($expenseCoa['id']==$key) {
  				$account_name = $expenseCoa['account_name'];
  			}
  		}
		if($key==8) {
			$amount = number_format(-($inc['debit']-$inc['credit']),2,'.',',');
			$account_name = "Discounts Received";
		} else {
			$amount = number_format(($inc['debit']-$inc['credit']),2,'.',',');
		}		
	  		$json .= '{"c":[{"v":"'.$account_name.'","f":null},{"v":'.$amount.',"f":null}]},';
	  }

       /*$json .= '{"c":[{"v":"Mushrooms","f":null},{"v":3,"f":null}]},
        {"c":[{"v":"Onions","f":null},{"v":1,"f":null}]},
        {"c":[{"v":"Olives","f":null},{"v":1,"f":null}]},
        {"c":[{"v":"Zucchini","f":null},{"v":1,"f":null}]},
        {"c":[{"v":"Pepperoni","f":null},{"v":2,"f":null}]}';*/
      $json .= ']
}';
echo $json;
	/**/  
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