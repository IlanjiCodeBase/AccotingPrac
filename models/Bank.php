<?php
class Bank extends Zend_Db_Table 
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


	public function index($to,$aid) {

			$logSession = new Zend_Session_Namespace('sess_login');
				if(isset($logSession->proxy_cid) && !empty($logSession->proxy_cid)) {
					$cid = $logSession->proxy_cid;
				} else {
					$cid = $logSession->cid;
				}

			$incomeAccountIncomePay  = $this->getGeneralIncomePayAccountGl($to,$aid);
			$expenseAccountPay  =  $this->getExpensePayAccountGl($to,$aid);
			$incomeAccountInvoicePay  =  $this->getInvoicePayAccountGl($to,$aid);
			$journalAccount  = $this->getGeneralJournalAccountGl($to,$aid);
			$coa  = $this->getCoa($aid);

			$debit_amount = 0.00;
			$credit_amount = 0.00;

			if(isset($incomeAccountIncomePay) && !empty($incomeAccountIncomePay)) {
				foreach ($incomeAccountIncomePay as $incPayment) {

					$debit_amount += $incPayment['payment_amount'];
					
					}
				}




			if(isset($expenseAccountPay) && !empty($expenseAccountPay)) {
				foreach ($expenseAccountPay as $expPayment) {
						
						$credit_amount += $expPayment['payment_amount'];

					}
			}


			if(isset($incomeAccountInvoicePay) && !empty($incomeAccountInvoicePay)) {
				foreach ($incomeAccountInvoicePay as $invPayment) {
						
						$debit_amount += $invPayment['payment_amount'];

					}
			}



			if(isset($journalAccount) && !empty($journalAccount)) {
				foreach ($journalAccount as $journal) {
						
						$debit_amount  += $journal['debit'];
						$credit_amount += $journal['credit'];
					
				}
			}


			if(isset($coa) && !empty($coa)) {
				foreach ($coa as $acc) {
						
						$debit_amount  += $acc['debit_opening_balance'];
						$credit_amount += $acc['credit_opening_balance'];
					
				}
			}


			$amount = $debit_amount - $credit_amount;
			echo $amount;
			return $amount;

	}





	public function getGeneralJournalAccountGl($to,$aid) {			
		$where = 't1.journal_status =1 AND t1.delete_status=1 AND t1.date <= "'.$to.'" AND t2.fkaccount_id='.$aid.'';

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

	public function getGeneralIncomePayAccountGl($to,$aid) {
		$where = 't1.payment_status=1 AND t2.delete_status=1 AND t2.transaction_status=1 AND t1.date <= "'.$to.'" AND t1.fkpayment_account='.$aid.'';

		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'payments'),array('t1.id','t1.fkpayment_account','t1.payment_description','t1.discount_amount','t1.payment_amount','t1.date as pay_date','t1.fkiei_id as iei_id'))
					 ->joinLeft(array('t2' => 'income_transaction'),'t2.id = t1.fkiei_id',array('t2.id as inc_id','t2.final_payment_date','t2.payment_status as pay_status','t2.income_no','t2.transaction_currency','t2.exchange_rate','t2.credit_term','t2.tax_value'))
		   			 ->joinLeft(array('t3' => 'customers'),'t3.id = t2.fkcustomer_id',array('t3.coa_link','t3.customer_name'))
		   			 ->where($where)
		   			 ->group('t1.id');
		$sql = $this->remoteDb->fetchAll($select);
	    return $sql;
	} 


	public function getExpensePayAccountGl($to,$aid) {
		$where = 't1.payment_status=2 AND t2.delete_status=1 AND t2.transaction_status=1 AND t1.date <= "'.$to.'" AND t1.fkpayment_account='.$aid.'';

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

	public function getInvoicePayAccountGl($to,$aid) {
		$where = 't1.payment_status=3 AND t2.delete_status=1 AND t2.invoice_status=1 AND t1.date <= "'.$to.'" AND t1.fkpayment_account='.$aid.'';

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


	public function getCoa($aid) {
		$sql = $this->remoteDb->fetchAll('SELECT id,account_name,account_type,level1,level2,debit_opening_balance,credit_opening_balance FROM account WHERE account_type=1 AND id='.$aid.' AND delete_status=1 AND edit_status=1 ORDER BY account_name ASC');
		return $sql;
	}






}