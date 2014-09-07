<?php
class Reports extends Zend_Db_Table 
{
	protected $getVal;

	public function init() {

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

	/**
	* Purpose : get income account incomes tax and their currency types
	* @param   none
	* @return  amount,income type,tax value and currency
	*/

	public function getIncomeAccountIncomeTax($from,$to) {
		$where = '(t1.transaction_status=1 AND t1.delete_status=1 AND t1.date between "'.$from.'" AND "'.$to.'" AND t1.fktax_id!=0)';
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'income_transaction'),array('t1.id as inc_id','t1.income_no','t1.transaction_currency','t1.exchange_rate','t1.date','t1.fkincome_type','t1.amount','t1.fktax_id','t1.tax_value'))
		   			 ->where($where)
		   			 ->group('t1.id');
		$sql = $this->remoteDb->fetchAll($select);		
		return $sql;
	}

	/**
	* Purpose : get invoice account tax incomes from invoice and their currency types
	* @param   none
	* @return  amount,income type,tax value,quantity,discount amount and currency
	*/

	public function getIncomeAccountInvoiceTax($from,$to) {
		$where = 't1.invoice_status=1 AND t1.delete_status=1 AND t1.date between "'.$from.'" AND "'.$to.'" AND t2.fktax_id!=0';
		
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'invoice'),array('t1.id as inv_id','t1.invoice_no','t1.transaction_currency','t1.exchange_rate','t1.date'))
					 ->joinLeft(array('t2' => 'invoice_product_list'),'t2.fkinvoice_id = t1.id',array('t2.id as pid','t2.tax_value','t2.fktax_id',"amount" => "sum(t2.unit_price * t2.quantity - t2.discount_amount)","tax_amount" => "sum((t2.unit_price * t2.quantity - t2.discount_amount) * t2.tax_value / 100)"))
		   			 ->where($where)
		   			 ->group('t1.id');
		$sql = $this->remoteDb->fetchAll($select);
	    return $sql;
	}

	/**
	* Purpose : get credit account tax incomes from credit and their currency types
	* @param   none
	* @return  amount,income type,tax value,quantity and currency
	*/

	public function getIncomeAccountCreditTax($from,$to) {
		$where = 't1.credit_status=1 AND t1.delete_status=1 AND t1.date between "'.$from.'" AND "'.$to.'" AND t2.fktax_id!=0';
		
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'credit'),array('t1.id as credit_id','t1.credit_no','t1.transaction_currency','t1.exchange_rate','t1.date'))
					 ->joinLeft(array('t2' => 'credit_product_list'),'t2.fkcredit_id = t1.id',array('t2.id as pid','t2.tax_value','t2.product_description','t2.fktax_id',"amount" => "sum(t2.unit_price * t2.quantity - t2.discount_amount)","tax_amount" => "sum((t2.unit_price * t2.quantity - t2.discount_amount) * t2.tax_value / 100)"))
		   			 ->where($where)
		   			 ->group('t1.id');
		$sql = $this->remoteDb->fetchAll($select);
	    return $sql;
	}

	/**
	* Purpose : get expense account tax expenses and their currency types
	* @param   none
	* @return  amount,expense type,tax value,quantity and currency
	*/

	public function getExpenseAccountExpenseTax($from,$to) {
		$where = 't1.transaction_status=1 AND t1.delete_status=1 AND t1.date between "'.$from.'" AND "'.$to.'" AND t2.fktax_id!=0';

		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'expense_transaction'),array('t1.id as exp_id','t1.expense_no','t1.transaction_currency','t1.exchange_rate','t1.total_gst','t1.date'))
					 ->joinLeft(array('t2' => 'expense_transaction_list'),'t2.fkexpense_id = t1.id',array('t2.id as pid','t2.fkexpense_type','t2.tax_value','t2.fktax_id',"amount" => "sum(t2.unit_price * t2.quantity)","tax_amount" => "sum((t2.unit_price * t2.quantity) * t2.tax_value / 100)"))
		   			 ->where($where)
		   			 ->group('t1.id');
		    $sql = $this->remoteDb->fetchAll($select);
			return $sql;
	}
	


	/**
	* Purpose : get income account incomes and their currency types
	* @param   none
	* @return  amount,income type,tax value and currency
	*/

	public function getIncomeAccountIncomes($from,$to) {
		$where = '(t1.transaction_status=1 AND t1.delete_status=1 AND t1.date between "'.$from.'" AND "'.$to.'")';
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

	public function getIncomeAccountInvoice($from,$to) {
		$where = 't1.invoice_status=1 AND t1.delete_status=1 AND t1.date between "'.$from.'" AND "'.$to.'"';
		
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

	public function getIncomeAccountCredit($from,$to) {
		$where = 't1.credit_status=1 AND t1.delete_status=1 AND t1.date between "'.$from.'" AND "'.$to.'"';
		
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

	public function getExpenseAccountExpenses($from,$to) {
		$where = 't1.transaction_status=1 AND t1.delete_status=1 AND t1.date between "'.$from.'" AND "'.$to.'" AND t3.account_type=4';

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

	public function getIncomeAccountIncomesPay($from,$to) {
		$where = '(t1.transaction_status=1 AND t1.delete_status=1 AND t2.date between "'.$from.'" AND "'.$to.'" AND t2.payment_status=1)';
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'income_transaction'),array('t1.id as inc_id','t1.income_no','t1.transaction_currency','t1.payment_status as pay_status','t1.final_payment_date','t1.tax_value','t1.fktax_id'))
					 ->joinLeft(array('t2' => 'payments'),'t2.fkiei_id = t1.id',array('t2.id as pid','t2.date','pay_amount' => 't2.discount_amount','payment_amount' => 't2.payment_amount'))
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

	public function getIncomeAccountInvoicesPay($from,$to) {
		$where = '(t1.invoice_status=1 AND t1.delete_status=1 AND t2.date between "'.$from.'" AND "'.$to.'" AND t2.payment_status=3)';
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'invoice'),array('t1.id as inv_id','t1.invoice_no','t1.transaction_currency','t1.payment_status as pay_status','t1.final_payment_date'))
					 ->joinLeft(array('t2' => 'payments'),'t2.fkiei_id = t1.id',array('t2.id as pid','t2.date','pay_amount' => 't2.discount_amount','payment_amount' => 't2.payment_amount'))
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

	public function getExpenseAccountExpensesPay($from,$to) {
		$where = '(t1.transaction_status=1 AND t1.delete_status=1 AND t2.date between "'.$from.'" AND "'.$to.'" AND t2.payment_status=2)';
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'expense_transaction'),array('t1.id as exp_id','t1.transaction_currency','t1.payment_status as pay_status','t1.final_payment_date','t1.total_gst'))
					 ->joinLeft(array('t2' => 'payments'),'t2.fkiei_id = t1.id',array('t2.id as pid','t2.date','pay_amount' => 't2.discount_amount','payment_amount' => 't2.payment_amount'))
		   			 ->joinLeft(array('t3' => 'expense_transaction_list'),'t1.id=t3.fkexpense_id',array('t3.tax_value','t3.fktax_id'))
		   			 ->where($where)
		   			 ->group('t2.id');
		$sql = $this->remoteDb->fetchAll($select);		
		return $sql;
	}


	/**
	* Purpose : get income account customer wise incomes and their currency types
	* @param   none
	* @return  amount,income type,customer id,tax value and currency
	*/

	public function getIncomeAccountIncomesCustomer($from='',$to='') {
		if(isset($from) && !empty($from) && isset($to) && !empty($to)) {
		    $sql = $this->remoteDb->fetchAll('SELECT fkincome_type,transaction_currency,exchange_rate,amount,tax_value,fkcustomer_id FROM income_transaction WHERE transaction_status=1 AND delete_status=1 AND date between "'.$from.'" AND "'.$to.'"');
		    //echo 'SELECT fkincome_type,transaction_currency,amount,tax_value FROM income_transaction WHERE transaction_status=1 AND date between '.$from.' AND '.$to.'';
			return $sql;
		} else {
	    	$sql = $this->remoteDb->fetchAll('SELECT fkincome_type,transaction_currency,exchange_rate,amount,tax_value,fkcustomer_id FROM income_transaction WHERE transaction_status=1 AND delete_status=1');
			return $sql;
		}
	}

	/**
	* Purpose : get income account customer wise incomes from invoice and their currency types
	* @param   none
	* @return  amount,income type,customer id,tax value,quantity,discount amount and currency
	*/

	public function getIncomeAccountInvoiceCustomer($from='',$to='') {
		if(isset($from) && !empty($from) && isset($to) && !empty($to)) {
			$where = 't1.invoice_status=1 AND t1.delete_status=1 AND t1.date between "'.$from.'" AND "'.$to.'"';
		}
		else {
			$where = 't1.invoice_status=1 AND t1.delete_status=1';
		}
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'invoice'),array('t1.id as inv_id','t1.transaction_currency','t1.exchange_rate','t1.date','t1.fkcustomer_id'))
					 ->joinLeft(array('t2' => 'invoice_product_list'),'t2.fkinvoice_id = t1.id',array('t2.id as pid','t2.unit_price','t2.quantity','t2.discount_amount','t2.tax_value','t2.product_description'))
		   			 ->joinLeft(array('t3' => 'products'),'t3.id = t2.product_description',array('t3.fkincomeaccount_id'))
		   			 ->where($where);
		    $sql = $this->remoteDb->fetchAll($select);
			return $sql;
	}
	
	/**
	* Purpose : get income account customer wise incomes from credit and their currency types
	* @param   none
	* @return  amount,income type,customer id,tax value,quantity and currency
	*/

	public function getIncomeAccountCreditCustomer($from='',$to='') {
		if(isset($from) && !empty($from) && isset($to) && !empty($to)) {
			$where = 't1.credit_status=1 AND t1.delete_status=1 AND t1.date between "'.$from.'" AND "'.$to.'"';
		}
		else {
			$where = 't1.credit_status=1 AND t1.delete_status=1';
		}
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'credit'),array('t1.id as credit_id','t1.transaction_currency','t1.exchange_rate','t1.date','t1.fkcustomer_id'))
					 ->joinLeft(array('t2' => 'credit_product_list'),'t2.fkcredit_id = t1.id',array('t2.id as pid','t2.unit_price','t2.quantity','t2.tax_value','t2.product_description'))
		   			 ->joinLeft(array('t3' => 'products'),'t3.id = t2.product_description',array('t3.fkincomeaccount_id'))
		   			 ->where($where);
		    $sql = $this->remoteDb->fetchAll($select);
			return $sql;
	}



	/**
	* Purpose : get income account customer wise incomes and their currency types
	* @param   none
	* @return  amount,income type,customer id,tax value and currency
	*/

	public function getIncomeAccountIncomesCustomerCoa($from,$to,$cid) {
		$sql = $this->remoteDb->fetchAll('SELECT t1.fkincome_type,t1.transaction_currency,t1.exchange_rate,t1.amount,t1.tax_value,t1.fkcustomer_id,t2.id as aid,t2.account_type,t2.level1,t2.level2,t2.account_name FROM income_transaction as t1 INNER JOIN account as t2 ON (t1.fkincome_type=t2.id) WHERE t1.transaction_status=1 AND t1.delete_status=1 AND t1.date between "'.$from.'" AND "'.$to.'" AND t1.fkcustomer_id='.$cid.'');
		return $sql;
	}

	/**
	* Purpose : get income account customer wise incomes from invoice and their currency types
	* @param   none
	* @return  amount,income type,customer id,tax value,quantity,discount amount and currency
	*/

	public function getIncomeAccountInvoiceCustomerCoa($from,$to,$cid) {
		$where = 't1.invoice_status=1 AND t1.delete_status=1 AND t1.date between "'.$from.'" AND "'.$to.'" AND t1.fkcustomer_id='.$cid.'';
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'invoice'),array('t1.id as inv_id','t1.transaction_currency','t1.exchange_rate','t1.date','t1.fkcustomer_id'))
					 ->joinLeft(array('t2' => 'invoice_product_list'),'t2.fkinvoice_id = t1.id',array('t2.id as pid','t2.unit_price','t2.quantity','t2.discount_amount','t2.tax_value','t2.product_description'))
		   			 ->joinLeft(array('t3' => 'products'),'t3.id = t2.product_description',array('t3.fkincomeaccount_id'))
		   			 ->joinLeft(array('t4' => 'account'),'t4.id = t3.fkincomeaccount_id',array('t4.id as aid','t4.account_type','t4.level1','t4.level2','t4.account_name'))
		   			 ->where($where);
		    $sql = $this->remoteDb->fetchAll($select);
			return $sql;
	}
	
	/**
	* Purpose : get income account customer wise incomes from credit and their currency types
	* @param   none
	* @return  amount,income type,customer id,tax value,quantity and currency
	*/

	public function getIncomeAccountCreditCustomerCoa($from,$to,$cid) {
		$where = 't1.credit_status=1 AND t1.delete_status=1 AND t1.date between "'.$from.'" AND "'.$to.'" AND t1.fkcustomer_id='.$cid.'';
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'credit'),array('t1.id as credit_id','t1.transaction_currency','t1.exchange_rate','t1.date','t1.fkcustomer_id'))
					 ->joinLeft(array('t2' => 'credit_product_list'),'t2.fkcredit_id = t1.id',array('t2.id as pid','t2.unit_price','t2.quantity','t2.tax_value','t2.product_description'))
		   			 ->joinLeft(array('t3' => 'products'),'t3.id = t2.product_description',array('t3.fkincomeaccount_id'))
		   			 ->joinLeft(array('t4' => 'account'),'t4.id = t3.fkincomeaccount_id',array('t4.id as aid','t4.account_type','t4.level1','t4.level2','t4.account_name'))
		   			 ->where($where);
		    $sql = $this->remoteDb->fetchAll($select);
			return $sql;
	}

	/**
	* Purpose : get expense account vendor expenses and their currency types
	* @param   none
	* @return  amount,expense type,vendor id,tax value,quantity and currency
	*/

	public function getExpenseAccountExpensesVendor($from='',$to='') {
		if(isset($from) && !empty($from) && isset($to) && !empty($to)) {
			$where = 't1.transaction_status=1 AND t1.delete_status=1 AND t1.date between "'.$from.'" AND "'.$to.'" AND ((t3.account_type=1 AND t3.level1=2) OR t3.account_type=4)';
		}
		else {
			$where = 't1.transaction_status=1 AND t1.delete_status=1 AND ((t3.account_type=1 AND t3.level1=2) OR t3.account_type=4)';
		}
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'expense_transaction'),array('t1.id as exp_id','t1.transaction_currency','t1.exchange_rate','t1.date','t1.fkvendor_id','t1.total_gst'))
					 ->joinLeft(array('t2' => 'expense_transaction_list'),'t2.fkexpense_id = t1.id',array('t2.id as pid','t2.fkexpense_type','t2.unit_price','t2.quantity','t2.tax_value'))
		   			 ->joinLeft(array('t3' => 'account'),'t2.fkexpense_type=t3.id',array('t3.id as aid'))
		   			 ->where($where);
		   	//$sql = $select->__toString();
			//echo "$sql\n"; die();
		    $sql = $this->remoteDb->fetchAll($select);
			return $sql;
	}


	/**
	* Purpose : get expense account vendor expenses and their currency types
	* @param   none
	* @return  amount,expense type,vendor id,tax value,quantity and currency
	*/

	public function getExpenseAccountExpensesVendorCoa($from,$to,$vid) {
		if(isset($from) && !empty($from) && isset($to) && !empty($to)) {
			$where = 't1.transaction_status=1 AND t1.delete_status=1 AND t1.date between "'.$from.'" AND "'.$to.'" AND t1.fkvendor_id='.$vid.' AND ((t4.account_type=1 AND t4.level1=2) OR t4.account_type=4)';
		}
		else {
			$where = 't1.transaction_status=1 AND t1.delete_status=1 AND ((t4.account_type=1 AND t4.level1=2) OR t4.account_type=4)';
		}
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'expense_transaction'),array('t1.id as exp_id','t1.transaction_currency','t1.exchange_rate','t1.date','t1.fkvendor_id','t1.total_gst'))
					 ->joinLeft(array('t2' => 'expense_transaction_list'),'t2.fkexpense_id = t1.id',array('t2.id as pid','t2.fkexpense_type','t2.unit_price','t2.quantity','t2.tax_value'))
		   			 ->joinLeft(array('t4' => 'account'),'t4.id = t2.fkexpense_type',array('t4.id as aid','t4.account_type','t4.level1','t4.level2','t4.account_name'))
		   			 ->where($where);
		   	//$sql = $select->__toString();
			//echo "$sql\n"; die();
		    $sql = $this->remoteDb->fetchAll($select);
			return $sql;
	}


	/**
	* Purpose : get income account receivables and their currency types
	* @param   none
	* @return  amount,income type,tax value,date and currency
	*/

	public function getIncomeAccountReceivables($to) {
		$where = 't2.transaction_status=1 AND t2.delete_status=1 AND t1.entry_type=1 AND t1.expiry_status=1 AND t1.account_entry_id=1 AND t2.date <= "'.$to.'" AND ((t2.payment_status=1 AND t2.final_payment_date > "'.$to.'") OR (t2.payment_status!=1))';
		
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'accounting_entries'))
					 ->joinLeft(array('t2' => 'income_transaction'),'t2.id = t1.fkiei_id',array('t2.id as inc_id','t2.income_no','t2.fkcustomer_id','t2.credit_term','t2.transaction_description','t2.transaction_currency','t2.exchange_rate','t2.date as inc_date'))
		   			 ->where($where);
		$sql = $this->remoteDb->fetchAll($select);
	    return $sql;
	}


	/**
	* Purpose : get income account cash and their currency types
	* @param   none
	* @return  amount,income type,tax value,date and currency
	*/

	public function getIncomeAccountCash($to) {
		$where = 't1.payment_status=1 AND t2.transaction_status=1 AND t2.delete_status=1 AND t1.date <= "'.$to.'" AND ((t2.payment_status=1 AND t2.final_payment_date > "'.$to.'") OR (t2.payment_status!=1))';
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'payments'),array('t1.id as pid','pay_amount' => 'SUM(t1.payment_amount)'))
					 ->joinLeft(array('t2' => 'income_transaction'),'t2.id = t1.fkiei_id',array('t2.id as inc_id','t2.income_no','t2.fkcustomer_id'))
		   			 ->group('t1.fkiei_id')
		   			 ->where($where);
		$sql = $this->remoteDb->fetchAll($select);
	    return $sql;
	}

	/**
	* Purpose : get income account invoice receivables and their currency types
	* @param   none
	* @return  amount,income type,tax value,date and currency
	*/

	public function getIncomeAccountInvoiceReceivables($to) {
		$where = 't2.invoice_status=1 AND t2.delete_status=1 AND t1.entry_type=3 AND t1.expiry_status=1 AND t1.account_entry_id=1 AND t2.date <= "'.$to.'" AND ((t2.payment_status=1 AND t2.final_payment_date > "'.$to.'") OR (t2.payment_status!=1))';
		
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'accounting_entries'))
					 ->joinLeft(array('t2' => 'invoice'),'t2.id = t1.fkiei_id',array('t2.id as inv_id','t2.fkcustomer_id','t2.invoice_no','t2.credit_term','t2.due_date','t2.transaction_currency','t2.exchange_rate','t2.date as inv_date'))
		   			 ->where($where);
		$sql = $this->remoteDb->fetchAll($select);
	    return $sql;
	}


	/**
	* Purpose : get income account invoice cash and their currency types
	* @param   none
	* @return  amount,income type,tax value,date and currency
	*/

	public function getIncomeAccountInvoiceCash($to) {
		$where = 't1.payment_status=3 AND t2.invoice_status=1 AND t2.delete_status=1 AND t1.date <= "'.$to.'" AND ((t2.payment_status=1 AND t2.final_payment_date > "'.$to.'") OR (t2.payment_status!=1))';
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'payments'),array('t1.id as pid','pay_amount' => 'SUM(t1.payment_amount)'))
					 ->joinLeft(array('t2' => 'invoice'),'t2.id = t1.fkiei_id',array('t2.id as inv_id','t2.invoice_no','t2.fkcustomer_id'))
		   			 ->group('t1.fkiei_id')
		   			 ->where($where);
		$sql = $this->remoteDb->fetchAll($select);
	    return $sql;
	}

		/**
	* Purpose : get income account credit receivables and their currency types
	* @param   none
	* @return  amount,income type,tax value,date and currency
	*/

	public function getIncomeAccountCreditReceivables($to) {
		$where = 't2.credit_status=1 AND t2.delete_status=1 AND t1.entry_type=4 AND t1.expiry_status=1 AND t1.account_entry_id=1 AND t2.date <= "'.$to.'"';
		
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'accounting_entries'))
					 ->joinLeft(array('t2' => 'credit'),'t2.id = t1.fkiei_id',array('t2.id as cre_id','t2.fkcustomer_id','t2.credit_no','t2.transaction_currency','t2.exchange_rate','t2.date as cre_date'))
		   			 ->joinLeft(array('t3' => 'invoice'),'t3.id = t2.fkinvoice_id',array('t3.id as inv_id','t3.invoice_no'))
		   			 ->where($where);
		$sql = $this->remoteDb->fetchAll($select);
	    return $sql;
	}




	/**
	* Purpose : get income account receivables and their currency types
	* @param   none
	* @return  amount,income type,tax value,date and currency
	*/

	public function getIncomeAccountReceivablesOutstanding($to,$cid) {
		$where = 't2.transaction_status=1 AND t2.delete_status=1 AND t1.entry_type=1 AND t1.expiry_status=1 AND t1.account_entry_id=1 AND t2.date <= "'.$to.'" AND t2.fkcustomer_id='.$cid.' AND ((t2.payment_status=1 AND t2.final_payment_date > "'.$to.'") OR (t2.payment_status!=1))';
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'accounting_entries'))
					 ->joinLeft(array('t2' => 'income_transaction'),'t2.id = t1.fkiei_id',array('t2.id as inc_id','t2.income_no','t2.fkcustomer_id','t2.credit_term','t2.transaction_description','t2.transaction_currency','t2.exchange_rate','t2.date as inc_date'))
		   			 ->where($where);
		$sql = $this->remoteDb->fetchAll($select);
	    return $sql;
	}


	/**
	* Purpose : get income account cash and their currency types
	* @param   none
	* @return  amount,income type,tax value,date and currency
	*/

	public function getIncomeAccountCashOutstanding($to,$cid) {
		$where = 't1.payment_status=1 AND t2.transaction_status=1 AND t2.delete_status=1 AND t1.date <= "'.$to.'" AND t2.fkcustomer_id='.$cid.' AND ((t2.payment_status=1 AND t2.final_payment_date > "'.$to.'") OR (t2.payment_status!=1))';
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'payments'),array('t1.id as pid','pay_amount' => 'SUM(t1.payment_amount)'))
					 ->joinLeft(array('t2' => 'income_transaction'),'t2.id = t1.fkiei_id',array('t2.id as inc_id','t2.income_no','t2.fkcustomer_id'))
		   			 ->group('t1.fkiei_id')
		   			 ->where($where);
		$sql = $this->remoteDb->fetchAll($select);
	    return $sql;
	}

	/**
	* Purpose : get income account invoice receivables and their currency types
	* @param   none
	* @return  amount,income type,tax value,date and currency
	*/

	public function getIncomeAccountInvoiceReceivablesOutstanding($to,$cid) {
		$where = 't2.invoice_status=1 AND t2.delete_status=1 AND t1.entry_type=3 AND t1.expiry_status=1 AND t1.account_entry_id=1 AND t2.date <= "'.$to.'" AND t2.fkcustomer_id='.$cid.' AND ((t2.payment_status=1 AND t2.final_payment_date > "'.$to.'") OR (t2.payment_status!=1))';
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'accounting_entries'))
					 ->joinLeft(array('t2' => 'invoice'),'t2.id = t1.fkiei_id',array('t2.id as inv_id','t2.fkcustomer_id','t2.invoice_no','t2.credit_term','t2.due_date','t2.transaction_currency','t2.exchange_rate','t2.date as inv_date'))
		   			 ->where($where);
		$sql = $this->remoteDb->fetchAll($select);
	    return $sql;
	}


	/**
	* Purpose : get income account invoice cash and their currency types
	* @param   none
	* @return  amount,income type,tax value,date and currency
	*/

	public function getIncomeAccountInvoiceCashOutstanding($to,$cid) {
		$where = 't1.payment_status=3 AND t2.invoice_status=1 AND t2.delete_status=1 AND t1.date <= "'.$to.'" AND t2.fkcustomer_id='.$cid.' AND ((t2.payment_status=1 AND t2.final_payment_date > "'.$to.'") OR (t2.payment_status!=1))';
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'payments'),array('t1.id as pid','pay_amount' => 'SUM(t1.payment_amount)'))
					 ->joinLeft(array('t2' => 'invoice'),'t2.id = t1.fkiei_id',array('t2.id as inv_id','t2.invoice_no','t2.fkcustomer_id'))
		   			 ->group('t1.fkiei_id')
		   			 ->where($where);
		$sql = $this->remoteDb->fetchAll($select);
	    return $sql;
	}

			/**
	* Purpose : get income account credit receivables and their currency types
	* @param   none
	* @return  amount,income type,tax value,date and currency
	*/

	public function getIncomeAccountCreditReceivablesOutstanding($to,$cid) {
		$where = 't2.credit_status=1 AND t2.delete_status=1 AND t1.entry_type=4 AND t1.expiry_status=1 AND t1.account_entry_id=1 AND t2.date <= "'.$to.'" AND t2.fkcustomer_id='.$cid.'';
		
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'accounting_entries'))
					 ->joinLeft(array('t2' => 'credit'),'t2.id = t1.fkiei_id',array('t2.id as cre_id','t2.fkcustomer_id','t2.credit_no','t2.transaction_currency','t2.exchange_rate','t2.date as cre_date'))
		   			 ->joinLeft(array('t3' => 'invoice'),'t3.id = t2.fkinvoice_id',array('t3.id as inv_id','t3.invoice_no'))
		   			 ->where($where);
		$sql = $this->remoteDb->fetchAll($select);
	    return $sql;
	}

	/**
	* Purpose : get expense account receivables and their currency types
	* @param   none
	* @return  amount,expense type,tax value,date and currency
	*/

	public function getExpenseAccountPayables($to) {
		$where = 't2.transaction_status=1 AND t2.delete_status=1 AND t1.entry_type=2 AND t1.expiry_status=1 AND t1.account_entry_id=2 AND t2.date <= "'.$to.'" AND ((t2.payment_status=1 AND t2.final_payment_date > "'.$to.'") OR (t2.payment_status!=1))';
		
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'accounting_entries'))
					 ->joinLeft(array('t2' => 'expense_transaction'),'t2.id = t1.fkiei_id',array('t2.id as exp_id','t2.expense_no','t2.credit_term','t2.due_date','t2.transaction_currency','t2.exchange_rate','t2.date as exp_date','t2.fkvendor_id','t2.total_gst'))
		   			 ->where($where);
		$sql = $this->remoteDb->fetchAll($select);
	    return $sql;
	}


	/**
	* Purpose : get expense account cash and their currency types
	* @param   none
	* @return  amount,expense type,tax value,date and currency
	*/

	public function getExpenseAccountCash($to) {
		$where = 't1.payment_status=2 AND t2.transaction_status=1 AND t2.delete_status=1 AND t1.date <= "'.$to.'" AND ((t2.payment_status=1 AND t2.final_payment_date > "'.$to.'") OR (t2.payment_status!=1))';
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'payments'),array('t1.id as pid','pay_amount' => 'SUM(t1.payment_amount)'))
					 ->joinLeft(array('t2' => 'expense_transaction'),'t2.id = t1.fkiei_id',array('t2.id as exp_id','t2.expense_no','t2.fkvendor_id','t2.total_gst'))
		   			 ->group('t1.fkiei_id')
		   			 ->where($where);
		$sql = $this->remoteDb->fetchAll($select);
	    return $sql;
	}



	/**
	* Purpose : get expense account receivables and their currency types
	* @param   none
	* @return  amount,expense type,tax value,date and currency
	*/

	public function getExpenseAccountPayablesOutstanding($to,$vid) {
		$where = 't2.transaction_status=1 AND t2.delete_status=1 AND t1.entry_type=2 AND t1.expiry_status=1 AND t1.account_entry_id=2 AND t2.date <= "'.$to.'" AND t2.fkvendor_id='.$vid.' AND ((t2.payment_status=1 AND t2.final_payment_date > "'.$to.'") OR (t2.payment_status!=1))';
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'accounting_entries'))
					 ->joinLeft(array('t2' => 'expense_transaction'),'t2.id = t1.fkiei_id',array('t2.id as exp_id','t2.expense_no','t2.credit_term','t2.due_date','t2.transaction_currency','t2.exchange_rate','t2.date as exp_date','t2.fkvendor_id','t2.total_gst'))
		   			 ->where($where);
		$sql = $this->remoteDb->fetchAll($select);
	    return $sql;
	}


	/**
	* Purpose : get expense account cash and their currency types
	* @param   none
	* @return  amount,expense type,tax value,date and currency
	*/

	public function getExpenseAccountCashOutstanding($to,$vid) {
		$where = 't1.payment_status=2 AND t2.transaction_status=1 AND t2.delete_status=1 AND t1.date <= "'.$to.'" AND t2.fkvendor_id='.$vid.' AND ((t2.payment_status=1 AND t2.final_payment_date > "'.$to.'") OR (t2.payment_status!=1))';
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'payments'),array('t1.id as pid','pay_amount' => 'SUM(t1.payment_amount)'))
					 ->joinLeft(array('t2' => 'expense_transaction'),'t2.id = t1.fkiei_id',array('t2.id as exp_id','t2.expense_no','t2.fkvendor_id','t2.total_gst'))
		   			 ->group('t1.fkiei_id')
		   			 ->where($where);
		$sql = $this->remoteDb->fetchAll($select);
	    return $sql;
	}


	/**
	* Purpose : get payments made for payment account in income and their currency types
	* @param   none
	* @return  amount, currency and fkiei_id
	*/

	public function getIncomePaymentAccounts($from='',$to='') {
		if(isset($from) && !empty($from) && isset($to) && !empty($to)) {
			$where = 't1.payment_status=1 AND t2.delete_status=1 AND t2.transaction_status=1 AND t1.date between "'.$from.'" AND "'.$to.'"';
		}
		else {
			$where = 't1.payment_status=1 AND t2.delete_status=1 AND t2.transaction_status=1';
		}
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'payments'),array('t1.fkpayment_account','t1.payment_amount','t1.date as pay_date'))
					 ->joinLeft(array('t2' => 'income_transaction'),'t2.id = t1.fkiei_id',array('t2.id as inc_id','t2.income_no','t2.transaction_currency','t2.exchange_rate'))
		   			 ->where($where);
		$sql = $this->remoteDb->fetchAll($select);
	    return $sql;
	}


	/**
	* Purpose : get payments made for payment account in expense and their currency types
	* @param   none
	* @return  amount, currency and fkiei_id
	*/

	public function getExpensePaymentAccounts($from='',$to='') {
		if(isset($from) && !empty($from) && isset($to) && !empty($to)) {
			$where = 't1.payment_status=2 AND t2.delete_status=1 AND t2.transaction_status=1 AND t1.date between "'.$from.'" AND "'.$to.'"';
		}
		else {
			$where = 't1.payment_status=2 AND t2.delete_status=1 AND t2.transaction_status=1';
		}
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'payments'),array('t1.fkpayment_account','t1.payment_amount','t1.date as pay_date'))
					 ->joinLeft(array('t2' => 'expense_transaction'),'t2.id = t1.fkiei_id',array('t2.id as exp_id','t2.expense_no','t2.transaction_currency','t2.exchange_rate','t2.total_gst'))
		   			 ->where($where);
		$sql = $this->remoteDb->fetchAll($select);
	    return $sql;
	}

	/**
	* Purpose : get payments made for payment account in invoice and their currency types
	* @param   none
	* @return  amount, currency and fkiei_id
	*/

	public function getInvoicePaymentAccounts($from='',$to='') {
		if(isset($from) && !empty($from) && isset($to) && !empty($to)) {
			$where = 't1.payment_status=3 AND t2.delete_status=1 AND t2.invoice_status=1 AND t1.date between "'.$from.'" AND "'.$to.'"';
		}
		else {
			$where = 't1.payment_status=3 AND t2.delete_status=1 AND t2.invoice_status=1';
		}
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'payments'),array('t1.fkpayment_account','t1.payment_amount','t1.date as pay_date'))
					 ->joinLeft(array('t2' => 'invoice'),'t2.id = t1.fkiei_id',array('t2.id as inv_id','t2.invoice_no','t2.transaction_currency','t2.exchange_rate'))
		   			 ->where($where);
		$sql = $this->remoteDb->fetchAll($select);
	    return $sql;
	}


	public function getGeneralIncomeAccount($from,$to) {			
		    $sql = $this->remoteDb->fetchAll('SELECT t1.id as inc_id,t1.income_no,t1.fkincome_type,t1.credit_term,t1.transaction_currency,t1.exchange_rate,t1.amount,t1.tax_value,t1.date,t2.coa_link FROM income_transaction as t1 INNER JOIN customers as t2 ON (t1.fkcustomer_id=t2.id) WHERE t1.transaction_status=1 AND t1.delete_status=1 AND t1.date between "'.$from.'" AND "'.$to.'"');
			return $sql;
	}

	public function getGeneralInvoiceIncomeAccount($from,$to) {			
		$where = 't1.invoice_status=1 AND t1.delete_status=1 AND t1.date between "'.$from.'" AND "'.$to.'"';
		
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'invoice'),array('t1.id as inv_id','t1.invoice_no','t1.credit_term','t1.transaction_currency','t1.exchange_rate','t1.date'))
					 ->joinLeft(array('t2' => 'invoice_product_list'),'t2.fkinvoice_id = t1.id',array('t2.id as pid','t2.tax_value',"amount" => "sum(t2.unit_price * t2.quantity - t2.discount_amount)","tax_amount" => "sum((t2.unit_price * t2.quantity - t2.discount_amount) * t2.tax_value / 100)"))
		   			 ->joinLeft(array('t3' => 'customers'),'t3.id = t1.fkcustomer_id',array('t3.coa_link'))
		   			 ->where($where)
		   			 ->group('t1.id');
		    $sql = $this->remoteDb->fetchAll($select);
			return $sql;
	}

	public function getGeneralCreditAccount($from,$to) {			
		$where = 't1.credit_status=1 AND t1.delete_status=1 AND t1.date between "'.$from.'" AND "'.$to.'"';
		
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'credit'),array('t1.id as credit_id','t1.credit_no','t1.transaction_currency','t1.exchange_rate','t1.date'))
					 ->joinLeft(array('t2' => 'credit_product_list'),'t2.fkcredit_id = t1.id',array('t2.id as pid',"amount" => "sum(t2.unit_price * t2.quantity - t2.discount_amount)","tax_amount" => "sum((t2.unit_price * t2.quantity - t2.discount_amount) * t2.tax_value / 100)"))
		   			 ->joinLeft(array('t3' => 'customers'),'t3.id = t1.fkcustomer_id',array('t3.coa_link'))
		   			 ->joinLeft(array('t4' => 'invoice'),'t4.id = t1.fkinvoice_id',array('t4.invoice_no'))
		   			 ->where($where)
		   			 ->group('t1.id');
		    $sql = $this->remoteDb->fetchAll($select);
			return $sql;
	}

	public function getGeneralExpenseAccount($from='',$to='') {
		$where = 't1.transaction_status=1 AND t1.delete_status=1 AND t1.date between "'.$from.'" AND "'.$to.'"';
		
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'expense_transaction'),array('t1.id as exp_id','t1.expense_no','t1.exchange_rate','t1.transaction_currency','t1.credit_term','t1.date','t1.total_gst'))
					 ->joinLeft(array('t2' => 'expense_transaction_list'),'t2.fkexpense_id = t1.id',array('t2.id as pid','t2.tax_value',"amount" => "sum(t2.unit_price * t2.quantity)","tax_amount" => "sum((t2.unit_price * t2.quantity) * t2.tax_value / 100)"))
		   			 ->joinLeft(array('t3' => 'vendors'),'t3.id = t1.fkvendor_id',array('t3.coa_link'))
		   			 ->where($where)
		   			 ->group('t1.id');
		    $sql = $this->remoteDb->fetchAll($select);
			return $sql;
	}



	public function getGeneralAssetsExpenseAccount($from='',$to='') {
		$where = 't1.transaction_status=1 AND t3.account_type=1 AND t3.level1=2 AND t1.delete_status=1 AND t1.date between "'.$from.'" AND "'.$to.'"';
		
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'expense_transaction'),array('t1.id as exp_id','t1.expense_no','t1.exchange_rate','t1.transaction_currency','t1.credit_term','t1.date','t1.total_gst'))
					 ->joinLeft(array('t2' => 'expense_transaction_list'),'t2.fkexpense_id = t1.id',array('t2.id as pid','t2.fkexpense_type','t2.tax_value',"amount" => "sum(t2.unit_price * t2.quantity)"))
		   			 ->joinLeft(array('t3' => 'account'),'t3.id = t2.fkexpense_type',array('t3.account_name'))
		   			 ->where($where)
		   			 ->group('t2.id');
		    $sql = $this->remoteDb->fetchAll($select);
			return $sql;
	}

	public function getGeneralJournalAccount($from,$to) {			
		$where = 't1.journal_status =1 AND t1.delete_status=1 AND t1.date between "'.$from.'" AND "'.$to.'"';

		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'journal_entries'),array('t1.id as journal_id','t1.journal_no','t1.date'))
					 ->joinLeft(array('t2' => 'journal_entries_list'),'t2.fkjournal_id = t1.id',array('t2.id as jid','t2.debit','t2.credit','t2.fkaccount_id'))
		   			 ->where($where);
		    $sql = $this->remoteDb->fetchAll($select);
			return $sql;
	}


	/**
	* Purpose : get payments made for payment account in income and their currency types
	* @param   none
	* @return  amount, currency and fkiei_id
	*/

	public function getGeneralIncomePayAccount($from,$to) {
		$where = 't1.payment_status=1 AND t2.delete_status=1 AND t2.transaction_status=1 AND t1.date between "'.$from.'" AND "'.$to.'"';
		
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'payments'),array('t1.id','t1.fkpayment_account','t1.payment_amount','t1.discount_amount','t1.date as pay_date','t1.fkiei_id as iei_id'))
					 ->joinLeft(array('t2' => 'income_transaction'),'t2.id = t1.fkiei_id',array('t2.id as inc_id','t2.income_no','t2.transaction_currency','t2.exchange_rate','t2.credit_term','t2.payment_status as pay_status','t2.final_payment_date'))
					 ->joinLeft(array('t3' => 'customers'),'t3.id = t2.fkcustomer_id',array('t3.coa_link'))
		   			 ->where($where);
		$sql = $this->remoteDb->fetchAll($select);
	    return $sql;
	} 


	public function getExpensePayAccounts($from,$to) {
		$where = 't1.payment_status=2 AND t2.delete_status=1 AND t2.transaction_status=1 AND t1.date between "'.$from.'" AND "'.$to.'"';
		
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'payments'),array('t1.id','t1.fkpayment_account','t1.payment_amount','t1.discount_amount','t1.date as pay_date'))
					 ->joinLeft(array('t2' => 'expense_transaction'),'t2.id = t1.fkiei_id',array('t2.id as exp_id','t2.expense_no','t2.transaction_currency','t2.exchange_rate','t2.credit_term','t2.payment_status as pay_status','t2.final_payment_date','t2.total_gst'))
		   			 ->joinLeft(array('t3' => 'vendors'),'t3.id = t2.fkvendor_id',array('t3.coa_link'))
		   			 ->where($where);
		$sql = $this->remoteDb->fetchAll($select);
	    return $sql;
	}

	public function getInvoicePayAccounts($from,$to) {
		$where = 't1.payment_status=3 AND t2.delete_status=1 AND t2.invoice_status=1 AND t1.date between "'.$from.'" AND "'.$to.'"';
		
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'payments'),array('t1.id','t1.fkpayment_account','t1.payment_amount','t1.discount_amount','t1.date as pay_date'))
					 ->joinLeft(array('t2' => 'invoice'),'t2.id = t1.fkiei_id',array('t2.id as inv_id','t2.invoice_no','t2.transaction_currency','t2.exchange_rate','t2.credit_term','t2.payment_status as pay_status','t2.final_payment_date'))
		             ->joinLeft(array('t3' => 'customers'),'t3.id = t2.fkcustomer_id',array('t3.coa_link'))
		   			 ->where($where);
		$sql = $this->remoteDb->fetchAll($select);
	    return $sql;
	}

	public function getGeneralIncomeAccountForeign($from,$to) {			
		$sql = $this->remoteDb->fetchAll('SELECT t1.id as inc_id,t1.income_no,t1.fkincome_type,t1.receipt_no,t1.transaction_description,t1.credit_term,t1.final_payment_date,t1.credit_term,t1.transaction_currency,t1.exchange_rate,t1.amount,t1.tax_value,t1.date,t2.coa_link,t2.customer_name FROM income_transaction as t1 INNER JOIN customers as t2 ON (t1.fkcustomer_id=t2.id) WHERE t1.transaction_status=1 AND t1.delete_status=1 AND t1.payment_status=1 AND t1.transaction_currency!="SGD" AND t1.final_payment_date between "'.$from.'" AND "'.$to.'"');
	    return $sql;
	}


	public function getGeneralInvoiceIncomeAccountForeign($from,$to) {			
		$where = 't1.invoice_status=1 AND t1.delete_status=1 AND t1.transaction_currency!="SGD" AND t1.payment_status=1 AND t1.final_payment_date between "'.$from.'" AND "'.$to.'"';
		
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


	public function getGeneralCreditAccountForeign($from,$to) {			
		$where = 't1.credit_status=1 AND t1.delete_status=1 AND t1.transaction_currency!="SGD" AND t5.payment_status=1 AND t5.final_payment_date between "'.$from.'" AND "'.$to.'"';

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



	public function getGeneralExpenseAccountForeign($from,$to) {
		$where = 't1.transaction_status=1 AND t1.delete_status=1 AND t1.transaction_currency!="SGD" AND t1.payment_status=1 AND t1.final_payment_date between "'.$from.'" AND "'.$to.'"';
		
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'expense_transaction'),array('t1.id as exp_id','t1.credit_term','t1.expense_no','t1.final_payment_date','t1.receipt_no','t1.transaction_currency','t1.exchange_rate','t1.credit_term','t1.date','t1.total_gst'))
					 ->joinLeft(array('t2' => 'expense_transaction_list'),'t2.fkexpense_id = t1.id',array('t2.id as pid',"amount" => "sum(t2.unit_price * t2.quantity)","tax_amount" => "sum((t2.unit_price * t2.quantity) * t2.tax_value / 100)",'t2.product_id','t2.product_description'))
		   			 ->joinLeft(array('t3' => 'vendors'),'t3.id = t1.fkvendor_id',array('t3.coa_link','t3.vendor_name'))
		   			 ->where($where)
		   			 ->group('t1.id');
		    $sql = $this->remoteDb->fetchAll($select);
			return $sql;
	}


	public function getGeneralIncomePayAccountForeign($from,$to) {
		$where = 't1.payment_status=1 AND t2.payment_status=1 AND t2.transaction_currency!="SGD" AND t2.delete_status=1 AND t2.transaction_status=1 AND t1.date between "'.$from.'" AND "'.$to.'"';
		
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'payments'),array('t1.id',"amount" =>"sum(t1.payment_amount)",'t1.date as pay_date','t1.fkiei_id as iei_id'))
					 ->joinLeft(array('t2' => 'income_transaction'),'t2.id = t1.fkiei_id',array('t2.id as inc_id','t2.income_no','t2.transaction_currency','t2.exchange_rate','t2.credit_term'))
		   			 ->where($where)
		   			 ->group('t1.fkiei_id');
		$sql = $this->remoteDb->fetchAll($select);
	    return $sql;
	} 

	public function getInvoicePayAccountsForeign($from,$to) {
		$where = 't1.payment_status=3 AND t2.payment_status=1 AND t2.transaction_currency!="SGD" AND t2.delete_status=1 AND t2.invoice_status=1 AND t1.date between "'.$from.'" AND "'.$to.'"';
		
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'payments'),array('t1.id',"amount" =>"sum(t1.payment_amount)",'t1.date as pay_date'))
					 ->joinLeft(array('t2' => 'invoice'),'t2.id = t1.fkiei_id',array('t2.id as inv_id','t2.invoice_no','t2.transaction_currency','t2.exchange_rate','t2.credit_term'))
		   			 ->where($where)
		   			 ->group('t1.fkiei_id');
		$sql = $this->remoteDb->fetchAll($select);
	    return $sql;
	}


	public function getExpensePayAccountsForeign($from,$to) {
		$where = 't1.payment_status=2 AND t2.payment_status=1 AND t2.transaction_currency!="SGD" AND t2.delete_status=1 AND t2.transaction_status=1 AND t1.date between "'.$from.'" AND "'.$to.'"';
		
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'payments'),array('t1.id',"amount" =>"sum(t1.payment_amount)",'t1.date as pay_date'))
					 ->joinLeft(array('t2' => 'expense_transaction'),'t2.id = t1.fkiei_id',array('t2.id as exp_id','t2.expense_no','t2.transaction_currency','t2.exchange_rate','t2.credit_term','t2.total_gst'))
		   			 ->where($where)
		   			 ->group('t1.fkiei_id');
		$sql = $this->remoteDb->fetchAll($select);
	    return $sql;
	}


	public function getAccountingEntriesIncome($from='',$to='') {
		if(isset($from) && !empty($from) && isset($to) && !empty($to)) {
			//$where = 't2.transaction_status=1 AND t1.entry_type=1 AND t1.expiry_status=1 AND t2.date between "'.$from.'" AND "'.$to.'"';
			$where = 't2.transaction_status=1 AND t2.delete_status=1 AND t1.entry_type=1 AND t1.expiry_status=1';
		}
		else {
			$where = 't2.transaction_status=1 AND t2.delete_status=1 AND t1.entry_type=1 AND t1.expiry_status=1';
		}
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'accounting_entries'))
					 ->joinLeft(array('t2' => 'income_transaction'),'t2.id = t1.fkiei_id',array('t2.id as inc_id','t2.income_no','t2.transaction_currency','t2.exchange_rate','t2.date as inc_date'))
		   			 ->where($where);
		$sql = $this->remoteDb->fetchAll($select);
	    return $sql;
	}

	public function getAccountingEntriesExpense($from='',$to='') {
		if(isset($from) && !empty($from) && isset($to) && !empty($to)) {
			$where = 't2.transaction_status=1 AND t2.delete_status=1 AND t1.entry_type=2 AND t1.expiry_status=1';
		}
		else {
			$where = 't2.transaction_status=1 AND t2.delete_status=1 AND t1.entry_type=2 AND t1.expiry_status=1';
		}
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'accounting_entries'))
					 ->joinLeft(array('t2' => 'expense_transaction'),'t2.id = t1.fkiei_id',array('t2.id as exp_id','t2.expense_no','t2.credit_term','t2.due_date','t2.transaction_currency','t2.exchange_rate','t2.date as exp_date','t2.total_gst'))
		   			 ->where($where);
		$sql = $this->remoteDb->fetchAll($select);
	    return $sql;
	}

	public function getAccountingEntriesInvoice($from='',$to='') {
		if(isset($from) && !empty($from) && isset($to) && !empty($to)) {
			$where = 't2.invoice_status=1 AND t2.delete_status=1 AND t1.entry_type=3 AND t1.expiry_status=1';
		}
		else {
			$where = 't2.invoice_status=1 AND t2.delete_status=1 AND t1.entry_type=3 AND t1.expiry_status=1';
		}
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'accounting_entries'))
					 ->joinLeft(array('t2' => 'invoice'),'t2.id = t1.fkiei_id',array('t2.id as inv_id','t2.invoice_no','t2.transaction_currency','t2.exchange_rate','t2.date as inv_date'))
		   			 ->where($where);
		$sql = $this->remoteDb->fetchAll($select);
	    return $sql;
	}


	public function getAccountingEntriesCredit($from='',$to='') {
		if(isset($from) && !empty($from) && isset($to) && !empty($to)) {
			$where = 't2.credit_status=1 AND t2.delete_status=1 AND t1.entry_type=4 AND t1.expiry_status=1 AND t2.date between "'.$from.'" AND "'.$to.'"';
		}
		else {
			$where = 't2.credit_status=1 AND t2.delete_status=1 AND t1.entry_type=4 AND t1.expiry_status=1';
		}
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'accounting_entries'))
					 ->joinLeft(array('t2' => 'credit'),'t2.id = t1.fkiei_id',array('t2.id as cre_id','t2.credit_no','t2.transaction_currency','t2.exchange_rate','t2.date as cre_date'))
		   			 ->where($where);
		$sql = $this->remoteDb->fetchAll($select);
	    return $sql;
	}

	public function getAllAccounts() {
		$sql = $this->remoteDb->fetchAll('SELECT * FROM account WHERE delete_status=1 ORDER BY account_type ASC, account_name ASC');
		return $sql;
	}

	public function getAllAccountsTransaction() {
		$sql = $this->remoteDb->fetchAll('SELECT * FROM account WHERE delete_status=1 AND id!=10 ORDER BY account_type ASC, account_name ASC');
		return $sql;
	}


	public function getIncomeJournalAccount($from,$to) {			
		$where = 't1.journal_status =1 AND t1.delete_status=1 AND t1.date between "'.$from.'" AND "'.$to.'" AND t3.account_type=3';

		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'journal_entries'),array('t1.id as journal_id','t1.date'))
					 ->joinLeft(array('t2' => 'journal_entries_list'),'t2.fkjournal_id = t1.id',array('t2.id as jid','t2.debit','t2.credit','t2.fkaccount_id'))
		   			 ->joinLeft(array('t3' => 'account'),'t2.fkaccount_id = t3.id',array('t3.account_type'))
		   			 ->where($where);
		    $sql = $this->remoteDb->fetchAll($select);
			return $sql;
	}



	public function getExpenseJournalAccount($from,$to) {			
		$where = 't1.journal_status =1 AND t1.delete_status=1 AND t1.date between "'.$from.'" AND "'.$to.'" AND t3.account_type=4';

		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'journal_entries'),array('t1.id as journal_id','t1.date'))
					 ->joinLeft(array('t2' => 'journal_entries_list'),'t2.fkjournal_id = t1.id',array('t2.id as jid','t2.debit','t2.credit','t2.fkaccount_id'))
		   			 ->joinLeft(array('t3' => 'account'),'t2.fkaccount_id = t3.id',array('t3.account_type'))
		   			 ->where($where);
		    $sql = $this->remoteDb->fetchAll($select);
			return $sql;
	}

	public function getCustomers() {
		$sql = $this->remoteDb->fetchAll('SELECT * FROM customers WHERE delete_status=1');
		return $sql;
	}

	public function getVendors() {
		$sql = $this->remoteDb->fetchAll('SELECT * FROM vendors WHERE delete_status=1');
		return $sql;
	}


	public function getIafIncomeCustomer($from='',$to='') {
		if(isset($from) && !empty($from) && isset($to) && !empty($to)) {
			$where = 't1.transaction_status=1 AND t1.delete_status=1 AND t1.date between "'.$from.'" AND "'.$to.'" AND t1.fktax_id!=0';
		}
		else {
			$where = 't1.transaction_status=1 AND t1.delete_status=1';
		}
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'income_transaction'),array('t1.id as inc_id','t1.income_no','t1.receipt_no','t1.transaction_currency','t1.exchange_rate','t1.transaction_description','t1.date','t1.fkcustomer_id','t1.amount','t1.tax_value','t1.fktax_id'))
					 ->joinLeft(array('t2' => 'customers'),'t1.fkcustomer_id = t2.id',array('t2.id as cid','t2.customer_id','t2.customer_name','t2.company_registration_no','t2.company_gst_no'))
		   			 ->joinLeft(array('t3' => 'taxcodes'),'t1.fktax_id = t3.id',array('t3.id as tid','t3.tax_code'))
		   			 ->where($where);
		$sql = $this->remoteDb->fetchAll($select);
		return $sql;
	}

	public function getIafInvoiceCustomer($from='',$to='') {
			if(isset($from) && !empty($from) && isset($to) && !empty($to)) {
			$where = 't1.invoice_status=1 AND t1.delete_status=1 AND t1.date between "'.$from.'" AND "'.$to.'" AND t3.fktax_id!=0';
			}
			else {
				$where = 't1.invoice_status=1 AND t1.delete_status=1';
			}
			$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'invoice'),array('t1.id as inv_id','t1.invoice_no','t1.transaction_currency','t1.exchange_rate','t1.date','t1.fkcustomer_id'))
					 ->joinLeft(array('t2' => 'customers'),'t1.fkcustomer_id = t2.id',array('t2.id as cid',
					 		't2.customer_id','t2.customer_name','t2.company_registration_no','t2.company_gst_no'))
					 ->joinLeft(array('t3' => 'invoice_product_list'),'t3.fkinvoice_id = t1.id',array('t3.id as pid','count(*) as total_count',"amount" => "sum(t3.unit_price * t3.quantity - t3.discount_amount)","tax_amount" => "sum((t3.unit_price * t3.quantity - t3.discount_amount) * t3.tax_value / 100)"))
					 ->group('t1.id')
					 ->where($where);

		    $sql = $this->remoteDb->fetchAll($select);
			return $sql;
	}


	public function getIafCreditCustomer($from='',$to='') {
			if(isset($from) && !empty($from) && isset($to) && !empty($to)) {
			$where = 't1.credit_status=1 AND t1.delete_status=1 AND t1.date between "'.$from.'" AND "'.$to.'" AND t3.fktax_id!=0';
			}
			else {
				$where = 't1.credit_status=1 AND t1.delete_status=1';
			}
			$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'credit'),array('t1.id as cre_id','t1.credit_no','t1.transaction_currency','t1.exchange_rate','t1.date','t1.fkcustomer_id'))
					 ->joinLeft(array('t2' => 'customers'),'t1.fkcustomer_id = t2.id',array('t2.id as cid',
					 		't2.customer_id','t2.customer_name','t2.company_registration_no','t2.company_gst_no'))
					 ->joinLeft(array('t3' => 'credit_product_list'),'t3.fkcredit_id = t1.id',array('t3.id as pid','count(*) as total_count',"amount" => "sum(t3.unit_price * t3.quantity - t3.discount_amount)","tax_amount" => "sum((t3.unit_price * t3.quantity - t3.discount_amount) * t3.tax_value / 100)"))
					 ->group('t1.id')
					 ->where($where);

		    $sql = $this->remoteDb->fetchAll($select);
			return $sql;
	}

	public function getMaxInvoiceTransaction() {
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'invoice_product_list'),array('t1.fkinvoice_id','t1.product_description','t1.fktax_id',"maxi"=>"MAX(t1.unit_price * t1.quantity - t1.discount_amount)"))
					 ->joinLeft(array('t2' => 'products'),'t1.product_description = t2.id',array('t2.id as pid','t2.description','fkincomeaccount_id','t2.name as product_name'))
					 ->joinLeft(array('t3' => 'taxcodes'),'t1.fktax_id = t3.id',array('t3.id as tid','t3.tax_code'))
					 ->group('t1.fkinvoice_id')
					 ->order('maxi DESC');
		$sql = $this->remoteDb->fetchAll($select);
	    return $sql;
	}


	public function getMaxCreditTransaction() {
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'credit_product_list'),array('t1.fkcredit_id','t1.product_description','t1.fktax_id',"maxi"=>"MAX(t1.unit_price * t1.quantity)"))
					 ->joinLeft(array('t2' => 'products'),'t1.product_description = t2.id',array('t2.id as pid','t2.description','t2.name as product_name'))
					 ->joinLeft(array('t3' => 'taxcodes'),'t1.fktax_id = t3.id',array('t3.id as tid','t3.tax_code'))
					 ->group('t1.fkcredit_id')
					 ->order('maxi DESC');
		$sql = $this->remoteDb->fetchAll($select);
	    return $sql;
	}

	public function getIafExpenseVendor($from='',$to='') {
			if(isset($from) && !empty($from) && isset($to) && !empty($to)) {
			$where = 't1.transaction_status=1 AND t1.delete_status=1 AND t1.date between "'.$from.'" AND "'.$to.'" AND t3.fktax_id!=0';
			}
			else {
				$where = 't1.transaction_status=1 AND t1.delete_status=1';
			}
			$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'expense_transaction'),array('t1.id as exp_id','t1.expense_no','t1.receipt_no','t1.transaction_currency','t1.exchange_rate','t1.date','t1.fkvendor_id','t1.total_gst','t1.permit_no'))
					 ->joinLeft(array('t2' => 'vendors'),'t1.fkvendor_id = t2.id',array('t2.id as vid',
					 		't2.vendor_id','t2.vendor_name','t2.company_registration_no','t2.company_gst_no'))
					 ->joinLeft(array('t3' => 'expense_transaction_list'),'t3.fkexpense_id = t1.id',array('t3.id as eid','count(*) as total_count',"amount" => "sum(t3.unit_price * t3.quantity)","tax_amount" => "sum((t3.unit_price * t3.quantity) * t3.tax_value / 100)"))
					 ->group('t1.id')
					 ->where($where);

		    $sql = $this->remoteDb->fetchAll($select);
			return $sql;
	}

	public function getMaxExpenseTransaction() {
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'expense_transaction_list'),array('t1.fkexpense_id','t1.fkexpense_type','t1.fktax_id','t1.product_description',"maxi"=>"MAX(t1.unit_price * t1.quantity)"))
					 ->joinLeft(array('t3' => 'taxcodes'),'t1.fktax_id = t3.id',array('t3.id as tid','t3.tax_code'))
					 ->group('t1.fkexpense_id')
					 ->order('maxi DESC');
		$sql = $this->remoteDb->fetchAll($select);
	    return $sql;
	}

	public function getIafIncomeAccount($from='',$to='') {			
		if(isset($from) && !empty($from) && isset($to) && !empty($to)) {
		    $sql = $this->remoteDb->fetchAll('SELECT t1.id as inc_id,t1.fkincome_type,t1.income_no,t1.transaction_currency,t1.exchange_rate,t1.date,t1.transaction_description,t1.amount,t1.tax_value,t2.customer_name FROM income_transaction as t1 LEFT JOIN customers as t2 ON (t1.fkcustomer_id=t2.id) WHERE t1.transaction_status=1 AND t1.delete_status=1 AND t1.date between "'.$from.'" AND "'.$to.'"');
			return $sql;
		} else {
	    	$sql = $this->remoteDb->fetchAll('SELECT t1.id as inc_id,t1.fkincome_type,t1.income_no,t1.transaction_currency,t1.exchange_rate,t1.date,t1.amount,t1.transaction_description,t1.tax_value,t2.customer_name FROM income_transaction as t1 LEFT JOIN customers as t2 ON (t1.fkcustomer_id=t2.id) WHERE t1.transaction_status=1 AND t1.delete_status=1');
			return $sql;
		}
	}

	public function getIafInvoiceIncomeAccount($from='',$to='') {			
		if(isset($from) && !empty($from) && isset($to) && !empty($to)) {
			$where = 't1.invoice_status=1 AND t1.delete_status=1 AND t1.date between "'.$from.'" AND "'.$to.'"';
		}
		else {
			$where = 't1.invoice_status=1 AND t1.delete_status=1';
		}
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'invoice'),array('t1.id as inv_id','t1.invoice_no','t1.transaction_currency','t1.exchange_rate','t1.date','t1.fkcustomer_id'))
					 ->joinLeft(array('t2' => 'invoice_product_list'),'t2.fkinvoice_id = t1.id',array('t2.id as pid','t2.unit_price','t2.quantity','t2.discount_amount','t2.tax_value','t2.product_description'))
		   			 ->joinLeft(array('t3' => 'products'),'t3.id = t2.product_description',array('t3.fkincomeaccount_id','t3.description'))
		   			 ->joinLeft(array('t4' => 'customers'),'t1.fkcustomer_id=t4.id',array('t4.customer_name'))
		   			 ->where($where);
		    $sql = $this->remoteDb->fetchAll($select);
			return $sql;
	}

	public function getIafCreditAccount($from='',$to='') {			
		if(isset($from) && !empty($from) && isset($to) && !empty($to)) {
			$where = 't1.credit_status=1 AND t1.delete_status=1 AND t1.date between "'.$from.'" AND "'.$to.'"';
		}
		else {
			$where = 't1.credit_status=1 AND t1.delete_status=1';
		}
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'credit'),array('t1.id as credit_id','t1.credit_no','t1.transaction_currency','t1.exchange_rate','t1.date','t1.fkcustomer_id'))
					 ->joinLeft(array('t2' => 'credit_product_list'),'t2.fkcredit_id = t1.id',array('t2.id as pid','t2.unit_price','t2.quantity','t2.tax_value','t2.product_description'))
		   			 ->joinLeft(array('t3' => 'products'),'t3.id = t2.product_description',array('t3.fkincomeaccount_id','t3.description'))
		   			 ->joinLeft(array('t4' => 'customers'),'t1.fkcustomer_id=t4.id',array('t4.customer_name'))
		   			 ->where($where);
		    $sql = $this->remoteDb->fetchAll($select);
			return $sql;
	}

	public function getIafExpenseAccount($from='',$to='') {
		if(isset($from) && !empty($from) && isset($to) && !empty($to)) {
			$where = 't1.transaction_status=1 AND t1.delete_status=1 AND t1.date between "'.$from.'" AND "'.$to.'"';
		}
		else {
			$where = 't1.transaction_status=1 AND t1.delete_status=1';
		}
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'expense_transaction'),array('t1.id as exp_id','t1.expense_no','t1.transaction_currency','t1.exchange_rate','t1.date','t1.fkvendor_id','t1.total_gst'))
					 ->joinLeft(array('t2' => 'expense_transaction_list'),'t2.fkexpense_id = t1.id',array('t2.id as pid','t2.fkexpense_type','t2.unit_price','t2.quantity','t2.tax_value'))
		   			 ->joinLeft(array('t3' => 'vendors'),'t1.fkvendor_id=t3.id',array('t3.vendor_name'))
		   			 ->where($where);
		    $sql = $this->remoteDb->fetchAll($select);
			return $sql;
	}

	public function getIafIncomePayAccount($from='',$to='') {
		if(isset($from) && !empty($from) && isset($to) && !empty($to)) {
			$where = 't1.payment_status=1 AND t2.delete_status=1 AND t2.transaction_status=1 AND t1.date between "'.$from.'" AND "'.$to.'"';
		}
		else {
			$where = 't1.payment_status=1 AND t2.delete_status=1 AND t2.transaction_status=1';
		}
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'payments'),array('t1.fkpayment_account','t1.payment_amount','t1.date as pay_date','t1.fkiei_id as iei_id'))
					 ->joinLeft(array('t2' => 'income_transaction'),'t2.id = t1.fkiei_id',array('t2.id as inc_id','t2.income_no','t2.transaction_currency','t2.exchange_rate','t2.transaction_description','t2.fkcustomer_id'))
		   			 ->joinLeft(array('t3' => 'customers'),'t2.fkcustomer_id=t3.id',array('t3.customer_name'))
		   			 ->where($where);
		$sql = $this->remoteDb->fetchAll($select);
	    return $sql;
	} 


	public function getIafExpensePayAccounts($from='',$to='') {
		if(isset($from) && !empty($from) && isset($to) && !empty($to)) {
			$where = 't1.payment_status=2 AND t2.delete_status=1 AND t2.transaction_status=1 AND t1.date between "'.$from.'" AND "'.$to.'"';
		}
		else {
			$where = 't1.payment_status=2 AND t2.delete_status=1 AND t2.transaction_status=1';
		}
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'payments'),array('t1.fkpayment_account','t1.payment_amount','t1.date as pay_date'))
					 ->joinLeft(array('t2' => 'expense_transaction'),'t2.id = t1.fkiei_id',array('t2.id as exp_id','t2.expense_no','t2.transaction_currency','t2.exchange_rate','t2.fkvendor_id','t2.total_gst'))
		   			 ->joinLeft(array('t3' => 'vendors'),'t2.fkvendor_id=t3.id',array('t3.vendor_name'))
		   			 ->where($where);
		$sql = $this->remoteDb->fetchAll($select);
	    return $sql;
	}

	public function getIafInvoicePayAccounts($from='',$to='') {
		if(isset($from) && !empty($from) && isset($to) && !empty($to)) {
			$where = 't1.payment_status=3 AND t2.delete_status=1 AND t2.invoice_status=1 AND t1.date between "'.$from.'" AND "'.$to.'"';
		}
		else {
			$where = 't1.payment_status=3 AND t2.delete_status=1 AND t2.invoice_status=1';
		}
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'payments'),array('t1.fkpayment_account','t1.payment_amount','t1.date as pay_date'))
					 ->joinLeft(array('t2' => 'invoice'),'t2.id = t1.fkiei_id',array('t2.id as inv_id','t2.fkcustomer_id','t2.invoice_no','t2.transaction_currency','t2.exchange_rate'))
		   			 ->joinLeft(array('t3' => 'customers'),'t2.fkcustomer_id=t3.id',array('t3.customer_name'))
		   			 ->where($where);
		$sql = $this->remoteDb->fetchAll($select);
	    return $sql;
	}

	public function getIafAccountingEntriesIncome($from='',$to='') {
		if(isset($from) && !empty($from) && isset($to) && !empty($to)) {
			//$where = 't2.transaction_status=1 AND t1.entry_type=1 AND t1.expiry_status=1 AND t2.date between "'.$from.'" AND "'.$to.'"';
			$where = 't2.transaction_status=1 AND t2.delete_status=1 AND t1.entry_type=1 AND t1.expiry_status=1';
		}
		else {
			$where = 't2.transaction_status=1 AND t2.delete_status=1 AND t1.entry_type=1 AND t1.expiry_status=1';
		}
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'accounting_entries'))
					 ->joinLeft(array('t2' => 'income_transaction'),'t2.id = t1.fkiei_id',array('t2.id as inc_id','t2.income_no','t2.transaction_currency','t2.exchange_rate','t2.date as inc_date','t2.transaction_description','t2.fkcustomer_id'))
		   			 ->joinLeft(array('t3' => 'customers'),'t2.fkcustomer_id=t3.id',array('t3.customer_name'))
		   			 ->where($where);
		$sql = $this->remoteDb->fetchAll($select);
	    return $sql;
	}

		public function getIafAccountingEntriesExpense($from='',$to='') {
		if(isset($from) && !empty($from) && isset($to) && !empty($to)) {
			$where = 't2.transaction_status=1 AND t2.delete_status=1 AND t1.entry_type=2 AND t1.expiry_status=1';
		}
		else {
			$where = 't2.transaction_status=1 AND t2.delete_status=1 AND t1.entry_type=2 AND t1.expiry_status=1';
		}
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'accounting_entries'))
					 ->joinLeft(array('t2' => 'expense_transaction'),'t2.id = t1.fkiei_id',array('t2.id as exp_id','t2.fkvendor_id','t2.expense_no','t2.credit_term','t2.due_date','t2.transaction_currency','t2.exchange_rate','t2.date as exp_date','t2.total_gst'))
		   			 ->joinLeft(array('t3' => 'vendors'),'t2.fkvendor_id=t3.id',array('t3.vendor_name'))
		   			 ->where($where);
		$sql = $this->remoteDb->fetchAll($select);
	    return $sql;
	}

	public function getIafAccountingEntriesInvoice($from='',$to='') {
		if(isset($from) && !empty($from) && isset($to) && !empty($to)) {
			$where = 't2.invoice_status=1 AND t2.delete_status=1 AND t1.entry_type=3 AND t1.expiry_status=1';
		}
		else {
			$where = 't2.invoice_status=1 AND t2.delete_status=1 AND t1.entry_type=3 AND t1.expiry_status=1';
		}
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'accounting_entries'))
					 ->joinLeft(array('t2' => 'invoice'),'t2.id = t1.fkiei_id',array('t2.id as inv_id','t2.fkcustomer_id','t2.invoice_no','t2.transaction_currency','t2.exchange_rate','t2.date as inv_date'))
		   			 ->joinLeft(array('t3' => 'customers'),'t2.fkcustomer_id=t3.id',array('t3.customer_name'))
		   			 ->where($where);
		$sql = $this->remoteDb->fetchAll($select);
	   return $sql;
	}


	public function getIafAccountingEntriesCredit($from='',$to='') {
		if(isset($from) && !empty($from) && isset($to) && !empty($to)) {
			$where = 't2.credit_status=1 AND t2.delete_status=1 AND t1.entry_type=4 AND t1.expiry_status=1 AND t2.date between "'.$from.'" AND "'.$to.'"';
		}
		else {
			$where = 't2.credit_status=1 AND t2.delete_status=1 AND t1.entry_type=4 AND t1.expiry_status=1';
		}
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'accounting_entries'))
					 ->joinLeft(array('t2' => 'credit'),'t2.id = t1.fkiei_id',array('t2.id as cre_id','t2.fkcustomer_id','t2.credit_no','t2.transaction_currency','t2.exchange_rate','t2.date as cre_date'))
		   			 ->joinLeft(array('t3' => 'customers'),'t2.fkcustomer_id=t3.id',array('t3.customer_name'))
		   			 ->where($where);
		$sql = $this->remoteDb->fetchAll($select);
	    return $sql;
	}


	public function getCashFlowIncome($from='',$to='') {
		$where = 't1.payment_status=1 AND t3.delete_status=1 AND t3.credit_term!=1 AND t3.transaction_status=1 AND t1.date between "'.$from.'" AND "'.$to.'"';
		
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'payments'),array('t1.id as pid','t1.discount_amount',"pay_amount" => "t1.payment_amount"))
		   			 ->joinLeft(array('t3' => 'income_transaction'),'t1.fkiei_id=t3.id',array('t3.id as inc_id','t3.income_no','t3.tax_value'))
		   			 ->joinLeft(array('t4' => 'customers'),'t3.fkcustomer_id=t4.id',array('t4.customer_name','t4.coa_link'))
		   			 ->where($where)
		   			 ->group('t1.fkiei_id');
		$sql = $this->remoteDb->fetchAll($select);
	    return $sql;
	}

	public function getCashFlowIncomeReceipt($from='',$to='') {
		$where = 't3.delete_status=1 AND t3.credit_term=1 AND t3.transaction_status=1 AND t3.date between "'.$from.'" AND "'.$to.'"';
		
		$select  = $this->remoteDb->select()
		   			 ->from(array('t3' => 'income_transaction'),array('t3.id as inc_id','t3.income_no','t3.fkincome_type','t3.amount','t3.tax_value','t3.transaction_currency','t3.exchange_rate'))
		   			 ->where($where);
		$sql = $this->remoteDb->fetchAll($select);
	    return $sql;
	}

	public function getCashFlowInvoice($from='',$to='') {
		$where = 't1.payment_status=3 AND t3.delete_status=1 AND t3.credit_term!=1 AND t3.invoice_status=1 AND t1.date between "'.$from.'" AND "'.$to.'"';
		
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'payments'),array('t1.id as pid','t1.discount_amount',"pay_amount" => "t1.payment_amount"))
		   			 ->joinLeft(array('t3' => 'invoice'),'t1.fkiei_id=t3.id',array('t3.id as inv_id','t3.invoice_no'))
		   			 ->joinLeft(array('t4' => 'customers'),'t3.fkcustomer_id=t4.id',array('t4.customer_name','t4.coa_link'))
		   			 ->joinLeft(array('t5' => 'invoice_product_list'),'t5.fkinvoice_id=t3.id',array('t5.tax_value'))
		   			 ->where($where)
		   			 ->group('t1.fkiei_id');
		$sql = $this->remoteDb->fetchAll($select);
	    return $sql;
	}


	public function getCashFlowInvoiceReceipt($from,$to) {
		$where = 't1.invoice_status=1 AND t1.credit_term=1 AND t1.delete_status=1 AND t1.date between "'.$from.'" AND "'.$to.'"';
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'invoice'),array('t1.id as inv_id','t1.transaction_currency','t1.exchange_rate','t1.date','t1.fkcustomer_id'))
					 ->joinLeft(array('t2' => 'invoice_product_list'),'t2.fkinvoice_id = t1.id',array('t2.id as pid','t2.unit_price','t2.quantity','t2.discount_amount','t2.tax_value','t2.product_description'))
		   			 ->joinLeft(array('t3' => 'products'),'t3.id = t2.product_description',array('t3.fkincomeaccount_id'))
		   			 ->where($where);
		    $sql = $this->remoteDb->fetchAll($select);
			return $sql;
	}

	public function getCashFlowExpense($from='',$to='') {
		$where = 't1.payment_status=2 AND t3.delete_status=1 AND t3.credit_term!=1 AND t3.transaction_status=1 AND t1.date between "'.$from.'" AND "'.$to.'"';
		
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'payments'),array('t1.id as pid','t1.discount_amount',"pay_amount" => "t1.payment_amount"))
		   			 ->joinLeft(array('t3' => 'expense_transaction'),'t1.fkiei_id=t3.id',array('t3.id as exp_id','t3.expense_no','t3.total_gst'))
		   			 ->joinLeft(array('t4' => 'vendors'),'t3.fkvendor_id=t4.id',array('t4.vendor_name','t4.coa_link'))
		   			 ->joinLeft(array('t5' => 'expense_transaction_list'),'t5.fkexpense_id=t3.id',array('t5.tax_value'))
		   			 ->where($where)
		   			 ->group('t1.fkiei_id');
		$sql = $this->remoteDb->fetchAll($select);
	    return $sql;
	}

	public function getCashFlowExpenseReceipt($from='',$to='') {
		$where = 't1.transaction_status=1 AND t1.credit_term=1 AND t1.delete_status=1 AND t1.date between "'.$from.'" AND "'.$to.'"';
		
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'expense_transaction'),array('t1.id as exp_id','t1.transaction_currency','t1.exchange_rate','t1.date','t1.fkvendor_id','t1.total_gst'))
					 ->joinLeft(array('t2' => 'expense_transaction_list'),'t2.fkexpense_id = t1.id',array('t2.id as pid','t2.fkexpense_type','t2.unit_price','t2.quantity','t2.tax_value'))
		   			 ->where($where);
		    $sql = $this->remoteDb->fetchAll($select);
			return $sql;
	}

	public function getCashFlowJournal($from='',$to='') {
		$where = 't1.delete_status=1 AND t1.journal_status=1 AND t1.date between "'.$from.'" AND "'.$to.'" AND t3.account_type=1 AND t3.level1=1 AND t3.level2=1';
		
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'journal_entries'),array('t1.id as jid'))
		   			 ->joinLeft(array('t2' => 'journal_entries_list'),'t2.fkjournal_id=t1.id',array('t2.fkaccount_id','t2.debit','t2.credit'))
		   			 ->joinLeft(array('t3' => 'account'),'t2.fkaccount_id=t3.id',array('t3.account_name'))
		   			 ->where($where);
		$sql = $this->remoteDb->fetchAll($select);
	    return $sql;
	}

	public function getFlowJournal($from='',$to='') {
		$where = 't1.delete_status=1 AND t1.journal_status=1 AND t1.date between "'.$from.'" AND "'.$to.'"';
		
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'journal_entries'),array('t1.id as jid'))
		   			 ->joinLeft(array('t2' => 'journal_entries_list'),'t2.fkjournal_id=t1.id',array('t2.fkaccount_id','t2.debit','t2.credit'))
		   			 ->joinLeft(array('t3' => 'account'),'t2.fkaccount_id=t3.id',array('t3.account_name','t3.account_type','t3.level1','t3.level2'))
		   			 ->where($where);
		$sql = $this->remoteDb->fetchAll($select);
	    return $sql;
	}


	public function getGeneralIncomeAccountGl($from,$to) {			
		$sql = $this->remoteDb->fetchAll('SELECT t1.id as inc_id,t1.income_no,t1.receipt_no,t1.fkincome_type,t1.transaction_description,t1.credit_term,t1.transaction_currency,t1.exchange_rate,t1.amount,t1.tax_value,t1.transaction_description,t1.date,t1.final_payment_date,t1.payment_status as pay_status,t2.coa_link,t2.customer_name FROM income_transaction as t1 INNER JOIN customers as t2 ON (t1.fkcustomer_id=t2.id) WHERE t1.transaction_status=1 AND t1.delete_status=1 AND t1.date between "'.$from.'" AND "'.$to.'" ORDER BY t1.date');
	    return $sql;
	}

	public function getGeneralInvoiceIncomeAccountGl($from,$to) {			
		$where = 't1.invoice_status=1 AND t1.delete_status=1 AND t1.date between "'.$from.'" AND "'.$to.'"';
		
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

	public function getGeneralCreditAccountGl($from,$to) {			
		$where = 't1.credit_status=1 AND t1.delete_status=1 AND t1.date between "'.$from.'" AND "'.$to.'"';

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

	public function getGeneralExpenseAccountGl($from,$to) {
		$where = 't1.transaction_status=1 AND t1.delete_status=1 AND t1.date between "'.$from.'" AND "'.$to.'"';

		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'expense_transaction'),array('t1.id as exp_id','t1.expense_no','t1.receipt_no','t1.final_payment_date','t1.payment_status as pay_status','t1.transaction_currency','t1.exchange_rate','t1.date','t1.credit_term','t1.total_gst'))
					 ->joinLeft(array('t2' => 'expense_transaction_list'),'t2.fkexpense_id = t1.id',array('t2.id as pid','t2.fkexpense_type','t2.unit_price','t2.quantity','t2.tax_value','t2.product_description','t2.product_id'))
		   			 ->joinLeft(array('t3' => 'vendors'),'t3.id = t1.fkvendor_id',array('t3.coa_link','t3.vendor_name'))
		   			 ->where($where)
		   			 ->order('t1.date');
		    $sql = $this->remoteDb->fetchAll($select);
			return $sql;
	}

	public function getGeneralJournalAccountGl($from,$to) {			
		$where = 't1.journal_status =1 AND t1.delete_status=1 AND t1.date between "'.$from.'" AND "'.$to.'"';

		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'journal_entries'),array('t1.id as journal_id','t1.journal_no','t1.date'))
					 ->joinLeft(array('t2' => 'journal_entries_list'),'t2.fkjournal_id = t1.id',array('t2.id as jid','t2.debit','t2.credit','t2.fkaccount_id','t2.journal_description'))
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

	public function getGeneralIncomePayAccountGl($from,$to) {
		$where = 't1.payment_status=1 AND t2.delete_status=1 AND t2.transaction_status=1 AND t1.date between "'.$from.'" AND "'.$to.'"';

		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'payments'),array('t1.id','t1.fkpayment_account','t1.payment_description','t1.discount_amount','t1.payment_amount','t1.date as pay_date','t1.fkiei_id as iei_id'))
					 ->joinLeft(array('t2' => 'income_transaction'),'t2.id = t1.fkiei_id',array('t2.id as inc_id','t2.final_payment_date','t2.payment_status as pay_status','t2.income_no','t2.transaction_currency','t2.exchange_rate','t2.credit_term','t2.tax_value'))
		   			 ->joinLeft(array('t3' => 'customers'),'t3.id = t2.fkcustomer_id',array('t3.coa_link','t3.customer_name'))
		   			 ->where($where)
		   			 ->group('t1.id');
		$sql = $this->remoteDb->fetchAll($select);
	    return $sql;
	} 


	public function getExpensePayAccountGl($from,$to) {
		$where = 't1.payment_status=2 AND t2.delete_status=1 AND t2.transaction_status=1 AND t1.date between "'.$from.'" AND "'.$to.'"';

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

	public function getInvoicePayAccountGl($from,$to) {
		$where = 't1.payment_status=3 AND t2.delete_status=1 AND t2.invoice_status=1 AND t1.date between "'.$from.'" AND "'.$to.'"';

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






	public function getGeneralIncomeAccountTransaction($from,$to,$aid) {			
		$sql = $this->remoteDb->fetchAll('SELECT t1.id as inc_id,t1.income_no,t1.receipt_no,t1.fkincome_type,t1.transaction_description,t1.credit_term,t1.transaction_currency,t1.exchange_rate,t1.amount,t1.tax_value,t1.transaction_description,t1.final_payment_date,t1.payment_status as pay_status,t1.date,t2.coa_link,t2.customer_name FROM income_transaction as t1 INNER JOIN customers as t2 ON (t1.fkcustomer_id=t2.id) WHERE t1.transaction_status=1 AND t1.delete_status=1 AND t1.date between "'.$from.'" AND "'.$to.'" AND (t1.fkincome_type='.$aid.' OR t2.coa_link='.$aid.') ORDER BY t1.date');
	    return $sql;
	}

	public function getGeneralInvoiceIncomeAccountTransaction($from,$to,$aid) {			
		$where = 't1.invoice_status=1 AND t1.delete_status=1 AND t1.date between "'.$from.'" AND "'.$to.'" AND (t3.fkincomeaccount_id='.$aid.' OR t4.coa_link='.$aid.')';
		
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'invoice'),array('t1.id as inv_id','t1.invoice_no','t1.final_payment_date','t1.payment_status as pay_status','t1.transaction_currency','t1.exchange_rate','t1.date','t1.credit_term'))
					 ->joinLeft(array('t2' => 'invoice_product_list'),'t2.fkinvoice_id = t1.id',array('t2.id as pid','t2.unit_price','t2.quantity','t2.discount_amount','t2.tax_value','t2.product_description'))
		   			 ->joinLeft(array('t3' => 'products'),'t3.id = t2.product_description',array('t3.fkincomeaccount_id','t3.name','t3.description'))
		   			 ->joinLeft(array('t4' => 'customers'),'t4.id = t1.fkcustomer_id',array('t4.coa_link','t4.customer_name'))
		   			 ->where($where)
		   			 ->order('t1.date');
		    $sql = $this->remoteDb->fetchAll($select);
			return $sql;
	}

	public function getGeneralCreditAccountTransaction($from,$to,$aid) {			
		$where = 't1.credit_status=1 AND t1.delete_status=1 AND t1.date between "'.$from.'" AND "'.$to.'" AND (t3.fkincomeaccount_id='.$aid.' OR t4.coa_link='.$aid.')';

		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'credit'),array('t1.id as credit_id','t1.credit_no','t1.transaction_currency','t1.exchange_rate','t1.date'))
					 ->joinLeft(array('t2' => 'credit_product_list'),'t2.fkcredit_id = t1.id',array('t2.id as pid','t2.unit_price','t2.quantity','t2.tax_value','t2.product_description','t2.discount_amount'))
		   			 ->joinLeft(array('t3' => 'products'),'t3.id = t2.product_description',array('t3.fkincomeaccount_id','t3.name','t3.description'))
		   			 ->joinLeft(array('t4' => 'customers'),'t4.id = t1.fkcustomer_id',array('t4.coa_link','t4.customer_name'))
		   			 ->joinLeft(array('t5' => 'invoice'),'t5.id = t1.fkinvoice_id',array('t5.invoice_no'))
		   			 ->where($where)
		   			 ->order('t1.date');
		    $sql = $this->remoteDb->fetchAll($select);
			return $sql;
	}  

	public function getGeneralExpenseAccountTransaction($from,$to,$aid) {
		$where = 't1.transaction_status=1 AND t1.delete_status=1 AND t1.date between "'.$from.'" AND "'.$to.'" AND (t2.fkexpense_type='.$aid.' OR t3.coa_link='.$aid.')';

		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'expense_transaction'),array('t1.id as exp_id','t1.expense_no','t1.receipt_no','t1.final_payment_date','t1.payment_status as pay_status','t1.transaction_currency','t1.exchange_rate','t1.date','t1.credit_term','t1.total_gst'))
					 ->joinLeft(array('t2' => 'expense_transaction_list'),'t2.fkexpense_id = t1.id',array('t2.id as pid','t2.fkexpense_type','t2.unit_price','t2.quantity','t2.tax_value','t2.product_description','t2.product_id'))
		   			 ->joinLeft(array('t3' => 'vendors'),'t3.id = t1.fkvendor_id',array('t3.coa_link','t3.vendor_name'))
		   			 ->where($where)
		   			 ->order('t1.date');
		    $sql = $this->remoteDb->fetchAll($select);
			return $sql;
	}

	public function getGeneralJournalAccountTransaction($from,$to,$aid) {			
		$where = 't1.journal_status =1 AND t1.delete_status=1 AND t1.date between "'.$from.'" AND "'.$to.'" AND t2.fkaccount_id='.$aid.'';

		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'journal_entries'),array('t1.id as journal_id','t1.journal_no','t1.date'))
					 ->joinLeft(array('t2' => 'journal_entries_list'),'t2.fkjournal_id = t1.id',array('t2.id as jid','t2.debit','t2.credit','t2.fkaccount_id','t2.journal_description'))
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

	public function getGeneralIncomePayAccountTransaction($from,$to,$aid) {
		$where = 't1.payment_status=1 AND t2.delete_status=1 AND t2.transaction_status=1 AND t1.date between "'.$from.'" AND "'.$to.'" AND (t1.fkpayment_account='.$aid.' OR t3.coa_link='.$aid.')';

		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'payments'),array('t1.id','t1.fkpayment_account','t1.payment_description','t1.discount_amount','t1.payment_amount','t1.date as pay_date','t1.fkiei_id as iei_id'))
					 ->joinLeft(array('t2' => 'income_transaction'),'t2.id = t1.fkiei_id',array('t2.id as inc_id','t2.final_payment_date','t2.payment_status as pay_status','t2.income_no','t2.transaction_currency','t2.exchange_rate','t2.credit_term','t2.tax_value'))
		   			 ->joinLeft(array('t3' => 'customers'),'t3.id = t2.fkcustomer_id',array('t3.coa_link','t3.customer_name'))
		   			 ->where($where)
		   			 ->group('t1.id');
		$sql = $this->remoteDb->fetchAll($select);
	    return $sql;
	} 


	public function getExpensePayAccountTransaction($from,$to,$aid) {
		$where = 't1.payment_status=2 AND t2.delete_status=1 AND t2.transaction_status=1 AND t1.date between "'.$from.'" AND "'.$to.'" AND (t1.fkpayment_account='.$aid.' OR t3.coa_link='.$aid.')';

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

	public function getInvoicePayAccountTransaction($from,$to,$aid) {
		$where = 't1.payment_status=3 AND t2.delete_status=1 AND t2.invoice_status=1 AND t1.date between "'.$from.'" AND "'.$to.'" AND (t1.fkpayment_account='.$aid.' OR t3.coa_link='.$aid.')';

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




	/**
	* Purpose : get payments made for payment account in income and their currency types
	* @param   none
	* @return  amount, currency and fkiei_id
	*/

	public function getGeneralIncomePayBank($from,$to,$aid) {
		$where = 't1.payment_status=1 AND t2.delete_status=1 AND t2.transaction_status=1 AND ((t1.date between "'.$from.'" AND "'.$to.'") OR ((t1.date<"'.$from.'") AND (t1.bank_date>="'.$from.'" OR t1.bank_date="0000-00-00"))) AND (t1.fkpayment_account='.$aid.')';

		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'payments'),array('t1.id','t1.fkpayment_account','t1.payment_amount','t1.discount_amount','t1.date as pay_date','t1.bank_date','t1.fkiei_id as iei_id'))
					 ->joinLeft(array('t2' => 'income_transaction'),'t2.id = t1.fkiei_id',array('t2.id as inc_id','t2.final_payment_date','t2.payment_status as pay_status','t2.income_no','t2.transaction_currency','t2.exchange_rate','t2.credit_term'))
		   			 ->joinLeft(array('t3' => 'customers'),'t3.id = t2.fkcustomer_id',array('t3.coa_link','t3.customer_name'))
		   			 ->where($where)
		   			 ->order('t1.date');
		$sql = $this->remoteDb->fetchAll($select);
	    return $sql;
	} 


	public function getExpensePayBank($from,$to,$aid) {
		$where = 't1.payment_status=2 AND t2.delete_status=1 AND t2.transaction_status=1 AND ((t1.date between "'.$from.'" AND "'.$to.'") OR ((t1.date<"'.$from.'") AND (t1.bank_date>="'.$from.'" OR t1.bank_date="0000-00-00"))) AND (t1.fkpayment_account='.$aid.')';

		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'payments'),array('t1.id','t1.fkpayment_account','t1.payment_amount','t1.discount_amount','t1.date as pay_date','t1.bank_date'))
					 ->joinLeft(array('t2' => 'expense_transaction'),'t2.id = t1.fkiei_id',array('t2.id as exp_id','t2.final_payment_date','t2.payment_status as pay_status','t2.expense_no','t2.transaction_currency','t2.exchange_rate','t2.credit_term','t2.total_gst'))
		   			 ->joinLeft(array('t3' => 'vendors'),'t3.id = t2.fkvendor_id',array('t3.coa_link','t3.vendor_name'))
		   			 ->where($where)
		   			 ->order('t1.date');
		$sql = $this->remoteDb->fetchAll($select);
	    return $sql;
	}

	public function getInvoicePayBank($from,$to,$aid) {
		$where = 't1.payment_status=3 AND t2.delete_status=1 AND t2.invoice_status=1 AND ((t1.date between "'.$from.'" AND "'.$to.'") OR ((t1.date<"'.$from.'") AND (t1.bank_date>="'.$from.'" OR t1.bank_date="0000-00-00"))) AND (t1.fkpayment_account='.$aid.')';

		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'payments'),array('t1.id','t1.fkpayment_account','t1.payment_amount','t1.discount_amount','t1.date as pay_date','t1.bank_date'))
					 ->joinLeft(array('t2' => 'invoice'),'t2.id = t1.fkiei_id',array('t2.id as inv_id','t2.final_payment_date','t2.payment_status as pay_status','t2.invoice_no','t2.transaction_currency','t2.exchange_rate','t2.credit_term'))
		   			 ->joinLeft(array('t3' => 'customers'),'t3.id = t2.fkcustomer_id',array('t3.coa_link','t3.customer_name'))
		   			 ->where($where)
		   			 ->order('t1.date');
		$sql = $this->remoteDb->fetchAll($select);
	    return $sql;
	}

	public function getJournalBank($from,$to,$aid) {
		$where = 't1.journal_status =1 AND t1.delete_status=1 AND ((t1.date between "'.$from.'" AND "'.$to.'") OR ((t1.date<"'.$from.'") AND (t2.bank_date>="'.$from.'" OR t2.bank_date="0000-00-00"))) AND t2.fkaccount_id='.$aid.'';

		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'journal_entries'),array('t1.id','t1.journal_no','t1.date'))
					 ->joinLeft(array('t2' => 'journal_entries_list'),'t2.fkjournal_id = t1.id',array('t2.id as jid','t2.debit','t2.credit','t2.fkaccount_id','t2.journal_description','t2.bank_date'))
		   			 ->where($where)
		   			 ->order('t1.date');
		$sql = $this->remoteDb->fetchAll($select);
	    return $sql;
	}

    /**
	* Purpose : Update bank for each payment for the particular company database
	* @param   array $postVal contain form post value
	* @return  last update id when success
	*/
	
	public function updateBankReconcile($postVal) {
		//print_r($postVal); die();
		foreach ($postVal['bank_date'] as $key => $value) {
			//if(!empty($value)) {
				$splitter 	 = explode("_", $key);
				if(empty($value)) {
					$bank_date = '';
				} else {
					$bank_date   = date('Y-m-d',strtotime($value));
				}
				if($splitter[1]=='payment') {
					$getData     =   array( 'bank_date'  => $bank_date,
				             		       'date_modified' 	=> new Zend_Db_Expr('NOW()'));
					$this->remoteDb->update('payments',$getData,'id='.$splitter[0].'');
				} else if($splitter[1]=='journal') {
					$getData     =   array( 'bank_date'  => $bank_date,
				             		       'date_modified' 	=> new Zend_Db_Expr('NOW()'));
					$this->remoteDb->update('journal_entries_list',$getData,'id='.$splitter[0].'');
				}
			//}
	    }
	    return true;
	}

	public function getExpenseAccountExpensesPie($from,$to) {
		$where = 't1.transaction_status=1 AND t1.delete_status=1 AND t1.date between "'.$from.'" AND "'.$to.'" AND t3.account_type=4';

		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'expense_transaction'),array('t1.id as exp_id','t1.payment_status','t1.final_payment_date','t1.transaction_currency','t1.exchange_rate','t1.date','t1.total_gst'))
					 ->joinLeft(array('t2' => 'expense_transaction_list'),'t2.fkexpense_id = t1.id',array('t2.id as pid','t2.fkexpense_type','t2.unit_price','t2.quantity','t2.tax_value'))
		   			 ->joinLeft(array('t3' => 'account'),'t2.fkexpense_type = t3.id',array('t3.account_type','t3.level1','t3.level2'))
		   			 ->where($where);
		   	//$sql = $select->__toString();
			//echo "$sql\n"; die();
		    $sql = $this->remoteDb->fetchAll($select);
			return $sql;
	}

	public function getExpenseJournalAccountPie($from,$to) {			
		$where = 't1.journal_status =1 AND t1.delete_status=1 AND t1.date between "'.$from.'" AND "'.$to.'" AND t3.account_type=4';

		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'journal_entries'),array('t1.id as journal_id','t1.date'))
					 ->joinLeft(array('t2' => 'journal_entries_list'),'t2.fkjournal_id = t1.id',array('t2.id as jid','t2.debit','t2.credit','t2.fkaccount_id'))
		   			 ->joinLeft(array('t3' => 'account'),'t2.fkaccount_id = t3.id',array('t3.account_type','t3.level1','t3.level2'))
		   			 ->where($where);
		    $sql = $this->remoteDb->fetchAll($select);
			return $sql;
	}

	public function getExpenseAccountExpensesPayPie($from,$to) {
		$where = '(t1.transaction_status=1 AND t1.delete_status=1 AND t2.date between "'.$from.'" AND "'.$to.'" AND t2.payment_status=2)';
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'expense_transaction'),array('t1.id as exp_id','t1.transaction_currency','t1.payment_status as pay_status','t1.final_payment_date','t1.total_gst'))
					 ->joinLeft(array('t2' => 'payments'),'t2.fkiei_id = t1.id',array('pay_amount' => 't2.discount_amount','payment_amount' => 'payment_amount'))
		   			 ->joinLeft(array('t3' => 'expense_transaction_list'),'t1.id=t3.fkexpense_id',array('t3.tax_value','t3.fktax_id'))
		   			 ->where($where)
		   			 ->group('t2.id');
		$sql = $this->remoteDb->fetchAll($select);		
		return $sql;
	}



	public function getIncomeReceivables($id) {
		$where = 't1.fkiei_id = '.$id.' AND t2.transaction_status=1 AND t2.delete_status=1 AND t1.entry_type=1 AND t1.expiry_status=1 AND t1.entry_status=1 AND t1.account_entry_id=1';
		
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'accounting_entries'))
					 ->joinLeft(array('t2' => 'income_transaction'),'t2.id = t1.fkiei_id',array('t2.id as inc_id'))
		   			 ->where($where);
		$sql = $this->remoteDb->fetchAll($select);
	    return $sql;
	}


	public function getInvoiceReceivables($id) {
		$where = 't1.fkiei_id = '.$id.' AND t2.invoice_status=1 AND t2.delete_status=1 AND t1.entry_type=3 AND t1.expiry_status=1 AND t1.entry_status=1 AND t1.account_entry_id=1';
		
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'accounting_entries'))
					 ->joinLeft(array('t2' => 'invoice'),'t2.id = t1.fkiei_id',array('t2.id as inv_id'))
		   			 ->where($where);
		$sql = $this->remoteDb->fetchAll($select);
	    return $sql;
	}



	public function getExpensePayables($id) {
		$where = 't1.fkiei_id = '.$id.' AND t2.transaction_status=1 AND t2.delete_status=1 AND t1.entry_type=2 AND t1.expiry_status=1 AND t1.account_entry_id=2 AND t1.entry_status=2';
		
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'accounting_entries'))
					 ->joinLeft(array('t2' => 'expense_transaction'),'t2.id = t1.fkiei_id',array('t2.id as exp_id'))
		   			 ->where($where);
		$sql = $this->remoteDb->fetchAll($select);
	    return $sql;
	}



	public function getCreditReceivables($id) {
		$where = 't3.id='.$id.' AND t2.credit_status=1 AND t2.delete_status=1 AND t1.entry_type=4 AND t1.expiry_status=1 AND t1.account_entry_id=1 AND t1.entry_status=2';
		
		$select  = $this->remoteDb->select()
					 ->from(array('t3' => 'invoice'),array('t3.id as inv_id'))
		   			 ->joinLeft(array('t2' => 'credit'),'t3.id = t2.fkinvoice_id',array('t2.id as cre_id')) 
		   			 ->joinLeft(array('t1' => 'accounting_entries'),'t2.id=t1.fkiei_id',array('t1.*'))
		   			 ->where($where);
		$sql = $this->remoteDb->fetchAll($select);
	    return $sql;
	}




		/**
	* Purpose : get income account incomes tax and their currency types
	* @param   none
	* @return  amount,income type,tax value and currency
	*/

	public function getIncomeAccountIncomePartTax($from,$to,$tax) {
		$where = '(t1.transaction_status=1 AND t1.delete_status=1 AND t1.date between "'.$from.'" AND "'.$to.'" AND t1.fktax_id!=0 AND t1.fktax_id='.$tax.')';
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'income_transaction'),array('t1.id as inc_id','t1.income_no','t1.transaction_currency','t1.exchange_rate','t1.date','t1.fkincome_type','t1.amount','t1.fktax_id','t1.tax_value'))
		   			 ->where($where)
		   			 ->group('t1.id');
		$sql = $this->remoteDb->fetchAll($select);		
		return $sql;
	}

	/**
	* Purpose : get invoice account tax incomes from invoice and their currency types
	* @param   none
	* @return  amount,income type,tax value,quantity,discount amount and currency
	*/

	public function getIncomeAccountInvoicePartTax($from,$to,$tax) {
		$where = 't1.invoice_status=1 AND t1.delete_status=1 AND t1.date between "'.$from.'" AND "'.$to.'" AND t2.fktax_id!=0 AND t2.fktax_id='.$tax.'';
		
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'invoice'),array('t1.id as inv_id','t1.invoice_no','t1.transaction_currency','t1.exchange_rate','t1.date'))
					 ->joinLeft(array('t2' => 'invoice_product_list'),'t2.fkinvoice_id = t1.id',array('t2.id as pid','t2.tax_value','t2.fktax_id',"amount" => "sum(t2.unit_price * t2.quantity - t2.discount_amount)","tax_amount" => "sum((t2.unit_price * t2.quantity - t2.discount_amount) * t2.tax_value / 100)"))
		   			 ->where($where)
		   			 ->group('t1.id');
		$sql = $this->remoteDb->fetchAll($select);
	    return $sql;
	}

	/**
	* Purpose : get credit account tax incomes from credit and their currency types
	* @param   none
	* @return  amount,income type,tax value,quantity and currency
	*/

	public function getIncomeAccountCreditPartTax($from,$to,$tax) {
		$where = 't1.credit_status=1 AND t1.delete_status=1 AND t1.date between "'.$from.'" AND "'.$to.'" AND t2.fktax_id!=0 AND t2.fktax_id='.$tax.'';
		
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'credit'),array('t1.id as credit_id','t1.credit_no','t1.transaction_currency','t1.exchange_rate','t1.date'))
					 ->joinLeft(array('t2' => 'credit_product_list'),'t2.fkcredit_id = t1.id',array('t2.id as pid','t2.tax_value','t2.product_description','t2.fktax_id',"amount" => "sum(t2.unit_price * t2.quantity - t2.discount_amount)","tax_amount" => "sum((t2.unit_price * t2.quantity - t2.discount_amount) * t2.tax_value / 100)"))
		   			 ->where($where)
		   			 ->group('t1.id');
		$sql = $this->remoteDb->fetchAll($select);
	    return $sql;
	}

	/**
	* Purpose : get expense account tax expenses and their currency types
	* @param   none
	* @return  amount,expense type,tax value,quantity and currency
	*/

	public function getExpenseAccountExpensePartTax($from,$to,$tax) {
		$where = 't1.transaction_status=1 AND t1.delete_status=1 AND t1.date between "'.$from.'" AND "'.$to.'" AND t2.fktax_id!=0 AND t2.fktax_id='.$tax.'';

		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'expense_transaction'),array('t1.id as exp_id','t1.expense_no','t1.transaction_currency','t1.exchange_rate','t1.total_gst','t1.date'))
					 ->joinLeft(array('t2' => 'expense_transaction_list'),'t2.fkexpense_id = t1.id',array('t2.id as pid','t2.fkexpense_type','t2.tax_value','t2.fktax_id',"amount" => "sum(t2.unit_price * t2.quantity)","tax_amount" => "sum((t2.unit_price * t2.quantity) * t2.tax_value / 100)"))
		   			 ->where($where)
		   			 ->group('t1.id');
		    $sql = $this->remoteDb->fetchAll($select);
			return $sql;
	}



		/**
	* Purpose : get payment  discounts for income account incomes and their currency types
	* @param   none
	* @return  amount,income type,tax value and currency
	*/

	public function getIncomeAccountIncomesPartPay($from,$to,$tax) {
		$where = '(t1.transaction_status=1 AND t1.delete_status=1 AND t2.date between "'.$from.'" AND "'.$to.'" AND t2.payment_status=1 AND t1.fktax_id='.$tax.')';
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'income_transaction'),array('t1.id as inc_id','t1.income_no','t1.transaction_currency','t1.payment_status as pay_status','t1.final_payment_date','t1.tax_value','t1.fktax_id'))
					 ->joinLeft(array('t2' => 'payments'),'t2.fkiei_id = t1.id',array('t2.id as pid','t2.date','pay_amount' => 't2.discount_amount','payment_amount' => 't2.payment_amount'))
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

	public function getIncomeAccountInvoicesPartPay($from,$to,$tax) {
		$where = '(t1.invoice_status=1 AND t1.delete_status=1 AND t2.date between "'.$from.'" AND "'.$to.'" AND t2.payment_status=3 AND t3.fktax_id='.$tax.')';
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'invoice'),array('t1.id as inv_id','t1.invoice_no','t1.transaction_currency','t1.payment_status as pay_status','t1.final_payment_date'))
					 ->joinLeft(array('t2' => 'payments'),'t2.fkiei_id = t1.id',array('t2.id as pid','t2.date','pay_amount' => 't2.discount_amount','payment_amount' => 't2.payment_amount'))
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

	public function getExpenseAccountExpensesPartPay($from,$to,$tax) {
		$where = '(t1.transaction_status=1 AND t1.delete_status=1 AND t2.date between "'.$from.'" AND "'.$to.'" AND t2.payment_status=2 AND t3.fktax_id='.$tax.')';
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'expense_transaction'),array('t1.id as exp_id','t1.transaction_currency','t1.payment_status as pay_status','t1.final_payment_date','t1.total_gst'))
					 ->joinLeft(array('t2' => 'payments'),'t2.fkiei_id = t1.id',array('t2.id as pid','t2.date','pay_amount' => 't2.discount_amount','payment_amount' => 't2.payment_amount'))
		   			 ->joinLeft(array('t3' => 'expense_transaction_list'),'t1.id=t3.fkexpense_id',array('t3.tax_value','t3.fktax_id'))
		   			 ->where($where)
		   			 ->group('t2.id');
		$sql = $this->remoteDb->fetchAll($select);		
		return $sql;
	}




}

?>