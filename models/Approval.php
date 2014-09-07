<?php
class Approval extends Zend_Db_Table 
{
	protected $getVal;
	public function init() {

		$this->settings    = new Settings();
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
		//echo '<pre>'; print_r($this->remoteDb); echo '</pre>';
	}

	/**
	* Purpose : get all pending income transactions for particular super user or manager account
	* @param   login session id or proxy id
	* @return  return all pending income transaction details
	*/
	
	public function pendingIncomeTransactions($id) {
		$sql = $this->remoteDb->fetchAll('SELECT t1.id,t1.income_no,t1.date,t1.fkincome_type,t1.amount,t1.tax_value,t1.fkcustomer_id,t2.account_name,t3.customer_name,t1.exchange_rate,t1.transaction_currency FROM income_transaction as t1
										 LEFT JOIN account as t2 ON (t1.fkincome_type=t2.id) LEFT JOIN customers as t3 ON (t1.fkcustomer_id=t3.id) 
										 WHERE t1.transaction_status=2 AND t1.approval_for='.$id.' AND t1.delete_status=1');
		return $sql;
	}

	/**
	* Purpose : get all pending expense transactions for particular super user or manager account
	* @param   login session id or proxy id
	* @return  return all pending expense transaction details
	*/
	
	public function pendingExpenseTransactions($id) {
			$where = 't1.transaction_status=2 AND t1.approval_for='.$id.' AND t1.delete_status=1';
			$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'expense_transaction'),array('t1.id','t1.expense_no','t1.date','t1.exchange_rate','t1.total_gst','t1.transaction_currency'))
					 ->joinLeft(array('t2' => 'vendors'),'t1.fkvendor_id = t2.id',array('t2.vendor_name'))
					 ->joinLeft(array('t3' => 'expense_transaction_list'),'t3.fkexpense_id = t1.id',array('t3.id as eid',"amount" => "sum(t3.unit_price * t3.quantity)","tax_amount" => "sum((t3.unit_price * t3.quantity) * t3.tax_value / 100)"))
					 ->where($where)
					 ->group('t1.id');

		    $sql = $this->remoteDb->fetchAll($select);
			return $sql;
	}

	/**
	* Purpose : get all pending invoice transactions for particular super user or manager account
	* @param   login session id or proxy id
	* @return  return all pending invoice transaction details
	*/
	
	public function pendingInvoiceTransactions($id) {
			$where = 't1.invoice_status=2 AND t1.approval_for='.$id.' AND t1.delete_status=1';
			$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'invoice'),array('t1.id','t1.invoice_no','t1.date','t1.exchange_rate','t1.transaction_currency'))
					 ->joinLeft(array('t2' => 'customers'),'t1.fkcustomer_id = t2.id',array('t2.customer_name'))
					 ->joinLeft(array('t3' => 'invoice_product_list'),'t3.fkinvoice_id = t1.id',array('t3.id as pid',"amount" => "sum(t3.unit_price * t3.quantity - t3.discount_amount)","tax_amount" => "sum((t3.unit_price * t3.quantity - t3.discount_amount) * t3.tax_value / 100)"))
					 ->where($where)
					 ->group('t1.id');
		    $sql = $this->remoteDb->fetchAll($select);
			return $sql;
	}

	/**
	* Purpose : get pending credit note transactions for particular super user or manager account
	* @param   login session id or proxy id
	* @return  return all pending credit note transaction details
	*/
	
	public function pendingCreditTransactions($id) {
			$where = 't1.credit_status=2 AND t1.approval_for='.$id.' AND t1.delete_status=1';
			$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'credit'),array('t1.id','t1.credit_no','t1.date','t1.exchange_rate','t1.transaction_currency'))
					 ->joinLeft(array('t2' => 'customers'),'t1.fkcustomer_id = t2.id',array('t2.id as cid',
					 			't2.customer_id','t2.customer_name'))
					 ->joinLeft(array('t3' => 'credit_product_list'),'t3.fkcredit_id = t1.id',array('t3.id as pid',"amount" => "sum(t3.unit_price * t3.quantity)","tax_amount" => "sum((t3.unit_price * t3.quantity) * t3.tax_value / 100)"))
					 ->where($where)
					 ->group('t1.id');
		    $sql = $this->remoteDb->fetchAll($select);
			return $sql;
	}

	/**
	* Purpose : get all pending journal transactions for particular super user or manager account
	* @param   login session id or proxy id
	* @return  return all pending journal transaction details
	*/
	
	public function pendingJournalTransactions($id) {
			$where = 't1.journal_status=2 AND t1.approval_for='.$id.' AND t1.delete_status=1';
			$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'journal_entries'),array('t1.id','t1.journal_no','t1.description','t1.date'))
					 ->joinLeft(array('t3' => 'journal_entries_list'),'t3.fkjournal_id = t1.id',array("total_debit" => "sum(t3.debit)","total_credit" => "sum(t3.credit)"))
					 ->where($where)
					 ->group('t3.fkjournal_id');
		    $sql = $this->remoteDb->fetchAll($select);
			return $sql;
	}

	/**
	* Purpose  get maximum expense transaction for each individual expense expense
	* @param   none
	* @return  all maximum expense transaction details
	*/	

	public function getMaxExpenseTransaction($id) {
		$where = 't3.transaction_status=2 AND t3.approval_for='.$id.' AND t3.delete_status=1';
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'expense_transaction_list'),array('t1.fkexpense_id','t1.fkexpense_type',"maxi"=>"MAX(t1.unit_price * t1.quantity)"))
					 ->joinLeft(array('t2' => 'account'),'t1.fkexpense_type = t2.id',array('t2.account_name'))
					 ->joinLeft(array('t3' => 'expense_transaction'),'t1.fkexpense_id = t3.id',array('t3.expense_no'))
					 ->where($where)
					 ->group('t1.fkexpense_id')
					 ->order('maxi DESC');
		$sql = $this->remoteDb->fetchAll($select);
	    return $sql;
	}

	/**
	* Purpose  get maximum invoice product for each individual invoice
	* @param   none
	* @return  all maximum invoice transaction details
	*/	

	public function getMaxInvoiceTransaction($id) {
		$where = 't4.invoice_status=2 AND t4.approval_for='.$id.' AND t4.delete_status=1';
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'invoice_product_list'),array('t1.fkinvoice_id','t1.product_description',"maxi"=>"MAX(t1.unit_price * t1.quantity - t1.discount_amount)"))
					 ->joinLeft(array('t2' => 'products'),'t1.product_description = t2.id',array('t2.id as pid','t2.fkincomeaccount_id'))
					 ->joinLeft(array('t3' => 'account'),'t2.fkincomeaccount_id = t3.id',array('t3.account_name'))
					 ->joinLeft(array('t4' => 'invoice'),'t1.fkinvoice_id = t4.id',array('t4.invoice_no'))
					 ->where($where)
					 ->group('t1.fkinvoice_id')
					 ->order('maxi DESC');
		$sql = $this->remoteDb->fetchAll($select);
	    return $sql;
	}

	/**
	* Purpose  get maximum credit product for each individual credit
	* @param   none
	* @return  all maximum credit transaction details
	*/

	public function getMaxCreditTransaction($id) {
		$where = 't4.credit_status=2 AND t4.approval_for='.$id.' AND t4.delete_status=1';
		$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'credit_product_list'),array('t1.fkcredit_id','t1.product_description',"maxi"=>"MAX(t1.unit_price * t1.quantity)"))
					 ->joinLeft(array('t2' => 'products'),'t1.product_description = t2.id',array('t2.id as pid','t2.fkincomeaccount_id'))
					 ->joinLeft(array('t3' => 'account'),'t2.fkincomeaccount_id = t3.id',array('t3.account_name'))
					 ->joinLeft(array('t4' => 'credit'),'t1.fkcredit_id = t4.id',array('t4.credit_no'))
					 ->where($where)
					 ->group('t1.fkcredit_id')
					 ->order('maxi DESC');
		$sql = $this->remoteDb->fetchAll($select);
	    return $sql;
	}

	/**
	* Purpose  get  announcements details that are unseen by the particular user
	* @param   user id
	* @return  announcements details that are unseen by particular user
	*/	

	public function getNotificationMessage($cid,$id) {
		$sql = $this->_db->fetchAll('SELECT * FROM announcements WHERE (fkcompany_id='.$cid.' OR fkcompany_id=0)');
		return $sql;	
	}

		/**
	* Purpose  get all announcements details or particular announcements details
	* @param   none
	* @return  all announcements details (or) particular announcements details
	*/	

	public function getNotificationAnnouncements($id='') {
		if(isset($id) && !empty($id)) {
			$sql = $this->_db->fetchAll('SELECT t1.*  FROM announcements as t1 WHERE t1.id='.$id.'');
		} else {
			$sql = $this->_db->fetchAll('SELECT t1.*,t2.company_name FROM announcements as t1 LEFT JOIN company_details as t2 ON (t1.fkcompany_id=t2.id) WHERE t2.delete_status=1');
		}
		return $sql;	
	}

	/**
	* Purpose : update seen users list in announcements
	* @param   primary id and the status
	* @return  true when success
	*/
	
	public function markMessageSeen($id,$users) {
		$getData    =   array('seen_users' => $users,
		             		  'date_modified' => new Zend_Db_Expr('NOW()'));
		if($this->_db->update('announcements',$getData,'id = '.$id.'')) {
			return  true;	
		} else {
			return false;	
		}
	}

	/**
	* Purpose : search all income transactions for search query
	* @param   search string
	* @return  return all matched transactions
	*/
	
	public function searchIncomeTransactions($query) {
		$sql = $this->remoteDb->fetchAll('SELECT t1.id,t1.income_no,t1.receipt_no,t1.date,t1.transaction_description,t1.fkcustomer_id,t1.fktax_id,t2.customer_name,t3.tax_code FROM income_transaction as t1
										 LEFT JOIN customers as t2 ON (t1.fkcustomer_id=t2.id) LEFT JOIN taxcodes as t3 ON(t1.fktax_id=t3.id)
										 WHERE ((t1.income_no LIKE "%'.$query.'%" OR t1.receipt_no LIKE "%'.$query.'%" OR t1.transaction_description LIKE "%'.$query.'%" OR t2.customer_name LIKE "%'.$query.'%" OR t3.tax_code LIKE "%'.$query.'%") AND (t1.delete_status=1))');
		return $sql;
	}

	/**
	* Purpose : search all expense transactions for search query
	* @param   search string
	* @return  return all matched transactions
	*/
	
	public function searchExpenseTransactions($query) {
			$where = '((t1.expense_no LIKE "%'.$query.'%" OR t1.receipt_no LIKE "%'.$query.'%" OR t3.product_description LIKE "%'.$query.'%" OR t2.vendor_name LIKE "%'.$query.'%" OR t4.tax_code LIKE "%'.$query.'%") AND (t1.delete_status=1))';
			$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'expense_transaction'),array('t1.id','t1.expense_no','t1.date'))
					 ->joinLeft(array('t2' => 'vendors'),'t1.fkvendor_id = t2.id',array('t2.vendor_name'))
					 ->joinLeft(array('t3' => 'expense_transaction_list'),'t3.fkexpense_id = t1.id',array('t3.id as eid','t3.product_description'))
					 ->joinLeft(array('t4' => 'taxcodes'),'t3.fktax_id = t4.id',array('t4.tax_code'))
					 ->where($where)
					 ->group('t1.id');

		    $sql = $this->remoteDb->fetchAll($select);
			return $sql;
	}

	/**
	* Purpose : search all invoice transactions for search query
	* @param   search string
	* @return  return all matched transactions
	*/

	public function searchInvoiceTransactions($query) {
			$where = '((t1.invoice_no LIKE "%'.$query.'%" OR t3.product_id LIKE "%'.$query.'%" OR t5.name LIKE "%'.$query.'%" OR t2.customer_name LIKE "%'.$query.'%" OR t4.tax_code LIKE "%'.$query.'%") AND (t1.delete_status=1))';
			$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'invoice'),array('t1.id','t1.invoice_no','t1.date'))
					 ->joinLeft(array('t2' => 'customers'),'t1.fkcustomer_id = t2.id',array('t2.customer_name'))
					 ->joinLeft(array('t3' => 'invoice_product_list'),'t3.fkinvoice_id = t1.id',array('t3.id as pid','t3.product_id'))
					 ->joinLeft(array('t4' => 'taxcodes'),'t3.fktax_id = t4.id',array('t4.tax_code'))
					 ->joinLeft(array('t5' => 'products'),'t3.product_description = t5.id',array('t5.name'))
					 ->where($where)
					 ->group('t1.id');
		    $sql = $this->remoteDb->fetchAll($select);
			return $sql;
	}


	/**
	* Purpose : search all credit transactions for search query
	* @param   search string
	* @return  return all matched transactions
	*/

	public function searchCreditTransactions($query) {
			$where = '((t1.credit_no LIKE "%'.$query.'%" OR t3.product_id LIKE "%'.$query.'%" OR t2.customer_name LIKE "%'.$query.'%" OR t4.tax_code LIKE "%'.$query.'%") AND (t1.delete_status=1))';
			$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'credit'),array('t1.id','t1.credit_no','t1.date'))
					 ->joinLeft(array('t2' => 'customers'),'t1.fkcustomer_id = t2.id',array('t2.customer_name'))
					 ->joinLeft(array('t3' => 'credit_product_list'),'t3.fkcredit_id = t1.id',array('t3.id as pid','t3.product_id'))
					 ->joinLeft(array('t4' => 'taxcodes'),'t3.fktax_id = t4.id',array('t4.tax_code'))
					 ->where($where)
					 ->group('t1.id');
		    $sql = $this->remoteDb->fetchAll($select);
			return $sql;
	}


	/**
	* Purpose : search all journal transactions for search query
	* @param   search string
	* @return  return all matched transactions
	*/

	public function searchJournalTransactions($query) {
			$where = '((t1.journal_no LIKE "%'.$query.'%" OR t1.description LIKE "%'.$query.'%" OR t2.journal_description LIKE "%'.$query.'%") AND (t1.delete_status=1))';
			$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'journal_entries'),array('t1.id','t1.journal_no','t1.description','t1.date'))
					 ->joinLeft(array('t2' => 'journal_entries_list'),'t2.fkjournal_id = t1.id',array('t2.journal_description'))
					 ->where($where)
					 ->group('t1.id');
		    $sql = $this->remoteDb->fetchAll($select);
			return $sql;
	}

	/**
	* Purpose : search all customers for search query
	* @param   search string
	* @return  return all matched customers
	*/
	
	public function searchCustomers($query) {
		$sql = $this->remoteDb->fetchAll('SELECT id,customer_id,customer_name,date_created FROM customers 
										  WHERE customer_name LIKE "%'.$query.'%" AND delete_status=1');
		return $sql;
	}


	/**
	* Purpose : search all vendors for search query
	* @param   search string
	* @return  return all matched vendors
	*/
	
	public function searchVendors($query) {
		$sql = $this->remoteDb->fetchAll('SELECT id,vendor_id,vendor_name,date_created FROM vendors 
										  WHERE vendor_name LIKE "%'.$query.'%" AND delete_status=1');
		return $sql;
	}

	/**
	* Purpose : search all products for search query
	* @param   search string
	* @return  return all matched products
	*/
	
	public function searchProducts($query) {
		$sql = $this->remoteDb->fetchAll('SELECT id,product_id,name,date_created FROM products 
										  WHERE name LIKE "%'.$query.'%" OR  product_id LIKE "%'.$query.'%"');
		return $sql;
	}


}
?>