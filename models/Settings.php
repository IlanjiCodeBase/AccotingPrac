<?php
class Settings extends Zend_Db_Table 
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
			/*$this->remoteDb = new Zend_Db_Adapter_Pdo_Mysql(array(
							    'host'     =>  'localhost',
							    'username' =>  'root',
						        'password' =>  '',
								'dbname'   =>  'btrans'
								));*/
			$authAdapter = new Zend_Auth_Adapter_DbTable($this->remoteDb);
		}
		//echo '<pre>'; print_r($this->remoteDb); echo '</pre>'; die();
	}

	/**
	* Purpose : Update Particular Company Details 
	* @param   array $postVal contain form post value
	* @return  last update id when success
	*/
	
	public function updateCompany($postVal,$id) {
		$getData    =   array('company_name'   				 => trim($postVal['company']),
						 	  'company_uen'    				 => trim($postVal['cuen']),
						 	  'company_gst'    				 => trim($postVal['gst']),
						 	  'telephone'    	   			 => trim($postVal['phone']),
						 	  'block_no'    	   			 => trim($postVal['block_no']),
						 	  'street_name'    	   			 => trim($postVal['street_name']),
						 	  'level'    	   				 => trim($postVal['level']),
						 	  'unit_no'    	   				 => trim($postVal['unit_no']),
						 	  'city'    	   				 => trim($postVal['city']),
						 	  'zip_code'    	   			 => trim($postVal['zip_code']),
						 	  'region'    	   				 => trim($postVal['region']),
						 	  'country'    	   				 => trim($postVal['country']),
						 	  'financial_year_start_date'    => trim($postVal['start_date']),
						 	  'financial_year_end_date'    	 => trim($postVal['end_date']),
						 	  'status'    	 				 => 1,
						 	  'currency'			    	 => trim($postVal['currency']),
		             		  'date_modified' 				 => new Zend_Db_Expr('NOW()'));
		if($this->_db->update('company_details',$getData,'id = '.$id.'')) {
			return  true;	
		} else {
			return false;	
		}	
	}


	/**
	* Purpose : Insert fundamental accounts to the particular company database 
	* @param   array $postVal contain form post value
	* @return  last insert id when success
	*/
	
	public function insertAccount($postVal) {
		//echo '<pre>'; print_r($postVal); echo '</pre>'; die();
		$getData    =   array('account_type'    			 => trim($postVal['account_type']),
						 	  'level1'    				     => trim($postVal['level1']),
						 	  'level2'    				     => trim($postVal['level2']),
						 	  'account_name'    	   		 => stripslashes($postVal['account_name']),
						 	  'currency'    	   			 => $postVal['currency'],
						 	  'edit_status'    	   			 => 1,
						 	  'pay_status'    	   			 => 2);
		if($this->remoteDb->insert('account',$getData)) {
			return  $this->remoteDb->lastInsertId();	
		} else {
			return false;	
		}
	}

	/**
	* Purpose : check account name exists or not for particular level group
	* @param   array $postVal contain form post value
	* @return  check account name exists or not
	*/

	public function checkAccountName($postVal,$id='') {
		//echo 'SELECT id FROM account WHERE account_type='.$postVal['account_type'].' AND level1='.$postVal['level1'].' AND level2='.$postVal['level2'].'  AND account_name="'.stripslashes($postVal['account_name']).'"'; die();
		if(isset($id) && !empty($id)) {
			$sql = $this->remoteDb->fetchAll('SELECT id FROM account WHERE id!='.$id.' AND account_name="'.stripslashes($postVal['account_name']).'" AND delete_status=1');
			return $sql;
		} else {
			$sql = $this->remoteDb->fetchAll('SELECT id FROM account WHERE account_name="'.stripslashes($postVal['account_name']).'" AND delete_status=1');
			return $sql;
		}
	}


	/**
	* Purpose : get all active accounts available for a particular company
	* @param   array $postVal contain form post value
	* @return  all account details
	*/

	public function getAccounts($id='') {
		if(isset($id) && !empty($id)) {
			$sql = $this->remoteDb->fetchAll('SELECT * FROM account WHERE id='.$id.' AND delete_status=1');
		} else {
			$sql = $this->remoteDb->fetchAll('SELECT * FROM account WHERE delete_status=1');
		}
		return $sql;
	}


	/**
	* Purpose : check particular account is associated with the product list
	* @param   account id
	* @return  return product name
	*/

	public function checkProduct($accId) {
		$sql = $this->remoteDb->fetchOne('SELECT name FROM products WHERE fkincomeaccount_id='.$accId.'');
		return $sql;
	}

	/**
	* Purpose : Update delete status as 2 to mark the account deleted
	* @param   account id
	* @return  last update id when success
	*/
	
	public function deleteAccount($accId) {
		$checkExpense  =  $this->remoteDb->fetchAll('SELECT fkexpense_type FROM expense_transaction_list WHERE fkexpense_type='.$accId.''); 
	 	$checkIncome   =  $this->remoteDb->fetchAll('SELECT fkincome_type FROM income_transaction WHERE fkincome_type='.$accId.' OR fkpayment_account='.$accId.'');
	 	$checkPayment  =  $this->remoteDb->fetchAll('SELECT fkpayment_account FROM payments WHERE fkpayment_account='.$accId.'');
	 	$inv = count($checkExpense);
	    $inc = count($checkIncome);
	    $pay = count($checkPayment);
		if($inv==0 && $inc==0 && $pay==0) {
			$getData    =   array('delete_status'   => 2,
			             		  'date_modified' 	=> new Zend_Db_Expr('NOW()'));
			if($this->remoteDb->update('account',$getData,'id = '.$accId.'')) {
				return  1;	
			} else {
				return false;	
			}
		} else {
			return 3;
		}	
	}

	/**
	* Purpose : Update accounts to the particular company database
	* @param   account id
	* @return  last update id when success
	*/
	
	public function updateAccount($postVal,$accId) {
		$getData    =   array('account_name'   => stripslashes($postVal['account_name']),
			                  'currency'	   => $postVal['edit_currency'],
							  'pay_status'	   => $postVal['pay_status'],
		             		  'date_modified'  => new Zend_Db_Expr('NOW()'));
		if($this->remoteDb->update('account',$getData,'id = '.$accId.'')) {
			return  true;	
		} else {
			return false;	
		}	
	}


	/**
	* Purpose : Update opening balance for particular coa to the particular company database
	* @param   account id
	* @return  last update id when success
	*/
	
	public function updateOpeningBalanceOld($postVal,$accId) {
		$getData    =   array('debit_opening_balance'   => $postVal['balance_debit'],
			                  'credit_opening_balance'	=> $postVal['balance_credit'],
		             		  'date_modified'  => new Zend_Db_Expr('NOW()'));
		//echo '<pre>'; print_r($accId); echo '</pre>'; die();
		if($this->remoteDb->update('account',$getData,'id = '.$accId.'')) {
			return  true;	
		} else {
			return false;	
		}	
	}

	/**
	* Purpose  get all the product details for the particular company database
	* @param   none
	* @return  all product details
	*/	

	public function getProducts($id='') {
		if(isset($id) && !empty($id)) {
			$where = 't1.id = '.$id.'';
			$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'products'))
					 ->joinLeft(array('t2' => 'account'),'t1.fkincomeaccount_id = t2.id',array('t2.id as aid',
					 		't2.account_type','t2.account_name'))
					 ->where($where);
		    $sql = $this->remoteDb->fetchAll($select);
			return $sql;
		} else {
			$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'products'))
					 ->joinLeft(array('t2' => 'account'),'t1.fkincomeaccount_id = t2.id',array('t2.id as aid',
					 		't2.account_type','t2.account_name'));
		    $sql = $this->remoteDb->fetchAll($select);
			return $sql;
		}	
	}

	/**
	* Purpose  get all the income account details for the particular company database
	* @param   none
	* @return  all income account details
	*/	

	public function getIncomeAccounts() {
		$sql = $this->remoteDb->fetchAll('SELECT * FROM account WHERE account_type=3 AND level1!=0 AND level2!=0 AND delete_status=1 ORDER BY account_name ASC');
		return $sql;
	}


	/**
	* Purpose : Insert products / services to the particular company database 
	* @param   array $postVal contain form post value
	* @return  last insert id when success
	*/
	
	public function insertProduct($postVal,$cid) {
		$getData    =   array('name'   				 => stripslashes($postVal['product_name']),
							  'fkcompany_id'		 => $cid,
						 	  'product_id'    	     => trim($postVal['product_id']),
						 	  'description'    		 => stripslashes($postVal['description']),
						 	  'price'    	   		 => trim($postVal['price']),
						 	  'currency'    	   	 => $postVal['currency'],
						 	  'fkincomeaccount_id'   => $postVal['income_account']);
		//print_r($getData); die();
		if($this->remoteDb->insert('products',$getData)) {
			return  $this->remoteDb->lastInsertId();	
		} else {
			return false;	
		}
	}

	/**
	* Purpose : Update products / services to the particular company database 
	* @param   array $postVal contain form post value and product primary id
	* @return  last update id when success
	*/
	
	public function updateProduct($postVal,$pid) {
		$getData    =   array('name'   				 => stripslashes($postVal['product_name']),
						 	  'product_id'    	     => trim($postVal['product_id']),
						 	  'description'    		 => stripslashes($postVal['description']),
						 	  'price'    	   		 => trim($postVal['price']),
						 	  'currency'    	   	 => $postVal['currency'],
						 	  'fkincomeaccount_id'   => $postVal['income_account'],
		             		  'date_modified'  => new Zend_Db_Expr('NOW()'));
		if($this->remoteDb->update('products',$getData,'id = '.$pid.'')) {
			return  true;	
		} else {
			return false;	
		}
	}

	/**
	* Purpose  delete particular product from the company database
	* @param   product primary id
	* @return  return true on success
	*/	

	 public function deleteProduct($delid) {  
	 	$checkInvoice  =  $this->remoteDb->fetchAll('SELECT product_description FROM invoice_product_list WHERE product_description='.$delid.''); 
		$inv = count($checkInvoice);
		if($inv==0) {
			$sql = $this->remoteDb->delete('products', 'id = '.$delid.'');
				if($sql) {
					return 1;
				} else {
					return false;
				}
		} else {
			return 3;
		}
	}

	/**
	* Purpose  get all the tax code details for the particular company database
	* @param   none
	* @return  all tax code details maintained by particular company
	*/	

	public function getTax() {
		$sql = $this->remoteDb->fetchAll('SELECT * FROM taxcodes');
		return $sql;
	}

	/**
	* Purpose : Insert tax to the particular company database 
	* @param   array $postVal contain form post value
	* @return  last insert id when success
	*/
	
	public function insertTax($postVal,$cid) {
		$getData    =   array('tax_code'   		     => trim($postVal['tax_code']),
						 	  'tax_percentage'    	 => trim($postVal['percentage']),
						 	  'description'    		 => stripslashes($postVal['description']),
						 	  'tax_type'    	   	 => $postVal['tax_type'],
						 	  'tax_status'    	   	 => 1,
						 	  'fkcompany_id'         => $cid);
		if($this->remoteDb->insert('taxcodes',$getData)) {
			return  $this->remoteDb->lastInsertId();	
		} else {
			return false;	
		}
	}

	/**
	* Purpose : Update tax code details to the particular company database 
	* @param   array $postVal contain form post value and tax primary id
	* @return  last update id when success
	*/
	
	public function updateTax($postVal,$tid) {
		$getData    =   array('tax_code'   		     => trim($postVal['tax_code']),
						 	  'tax_percentage'    	 => trim($postVal['percentage']),
						 	  'description'    		 => stripslashes($postVal['description']),
						 	  'tax_type'    	   	 => $postVal['tax_type'],
		             		  'date_modified'  => new Zend_Db_Expr('NOW()'));
		if($this->remoteDb->update('taxcodes',$getData,'id = '.$tid.'')) {
			return  true;	
		} else {
			return false;	
		}
	}

	/**
	* Purpose  get all the tax code details for the particular company database
	* @param   none
	* @return  all tax code details maintained by particular company
	*/	

	public function getAllTax($id='') {
		if(isset($id) && !empty($id)) {
			$sql = $this->remoteDb->fetchAll('SELECT * FROM taxcodes WHERE id='.$id.'');
			return $sql;
		} else  {
			$sql = $this->remoteDb->fetchAll('SELECT * FROM taxcodes');
			return $sql;
		}
	}

	/**
	* Purpose : Update particular tax code as active to the particular company database 
	* @param   tax primary id
	* @return  last update id when success
	*/
	
	public function setTax($tid,$status) {
		$getData    =   array('tax_status'     => $status,
		             		  'date_modified'  => new Zend_Db_Expr('NOW()'));
		if($this->remoteDb->update('taxcodes',$getData,'id = '.$tid.'')) {
			return  true;	
		} else {
			return false;	
		}
	}

	/**
	* Purpose  delete particular tax codes from the company database
	* @param   tax primary id
	* @return  return true on success
	*/	

	 public function deleteTax($delid) {  
	 	$checkExpense  =  $this->remoteDb->fetchAll('SELECT fktax_id FROM expense_transaction_list WHERE fktax_id='.$delid.''); 
	 	$checkIncome   =  $this->remoteDb->fetchAll('SELECT fktax_id FROM income_transaction WHERE fktax_id='.$delid.'');
	 	$checkInvoice  =  $this->remoteDb->fetchAll('SELECT fktax_id FROM invoice_product_list WHERE fktax_id ='.$delid.'');
	 	$inv = count($checkInvoice);
	    $inc = count($checkIncome);
	    $exp = count($checkExpense);
		if($inv==0 && $inc==0 && $exp==0) {
			$sql = $this->remoteDb->delete('taxcodes', 'id = '.$delid.'');
				if($sql) {
					return 1;
				} else {
					return false;
				}
		} else {
			return 3;
		}
	}

	/**
	* Purpose : Update notification settings to the particular company database 
	* @param   array post value
	* @return  last update id when success
	*/
	
	public function updateNotification($postVal) {
		$getData    =   array('notification'     => $postVal['notify'],
							  'email_setting'    => $postVal['email'],
		             		  'date_modified'  => new Zend_Db_Expr('NOW()'));
		if($this->remoteDb->update('notifications',$getData,'id = '.$postVal['notify_id'].'')) {
			return  true;	
		} else {
			return false;	
		}
	}

	/**
	* Purpose  get all the user profile details for the particular company database
	* @param   company primary id
	* @return  all user profile details maintained by particular company
	*/	

	public function getUserLists($id) {
		$sql = $this->_db->fetchAll('SELECT * FROM login_credentials WHERE fkcompany_id='.$id.'');
		return $sql;
	}

	public function getUserList($id) {
		$sql = $this->_db->fetchAll('SELECT * FROM login_credentials WHERE fkcompany_id='.$id.' OR account_type=0');
		return $sql;
	}

	/**
	* Purpose  get manager and super user details for the particular company database
	* @param   company primary id
	* @return  manager and super user details maintained by particular company
	*/	

	public function getApproveUsers($id='') {
		if(isset($id) && !empty($id)) {
			$sql = $this->_db->fetchAll('SELECT * FROM login_credentials WHERE fkcompany_id='.$id.' AND account_type IN (2,3)');
			return $sql;
		} else {
			$sql = $this->_db->fetchAll('SELECT * FROM login_credentials');
			return $sql;
		}
	}

	/**
	* Purpose  get invoice and credit note customization for the particular company database
	* @param   company primary id
	* @return  default invoice and credit note customization by particular company
	*/	

	public function getInvoiceCustomization() {
		$sql = $this->remoteDb->fetchAll('SELECT * FROM invoice_credit_note_customization');
		return $sql;
	}

	/**
	* Purpose  get notification settings for the particular company database
	* @param   none
	* @return  default notification settings by particular company
	*/	

	public function getNotificationSettings() {
		$sql = $this->remoteDb->fetchAll('SELECT * FROM notifications');
		return $sql;
	}

	/**
	* Purpose  get invoice next running number for the particular company database
	* @param   company primary id
	* @return  next running number customization by particular company
	*/	

	public function getInvoiceNextNumber() {
		$sql = $this->remoteDb->fetchOne('SELECT invoice_no FROM invoice ORDER BY id DESC');
		return $sql;
	}

	/**
	* Purpose  get credit note next running number for the particular company database
	* @param   company primary id
	* @return  next running number customization by particular company
	*/	

	public function getCreditNextNumber() {
		$sql = $this->remoteDb->fetchOne('SELECT credit_no FROM credit ORDER BY id DESC');
		return $sql;
	}

	/**
	* Purpose : Update Invoice and credit note customization for the particular company database
	* @param   array $postVal contain form post value
	* @return  last update id when success
	*/
	
	public function updateInvoiceCustomization($postVal,$id) {
		$getData    =   array('template'    				 => trim($postVal['template']),
						 	  'company_logo'    			 => trim($postVal['logo']),
						 	 // 'display_logo'    	   		 => trim($postVal['display_logo']),
						 	  'invoice_prefix'    	   		 => trim(strtoupper($postVal['invoice_prefix'])),
						 	  'credit_prefix'    	   		 => trim(strtoupper($postVal['credit_prefix'])),
						 	  'default_credit_term'    	   	 => trim($postVal['credit_term']),
						 	  'default_tax_code'    	   	 => trim($postVal['tax_code']),
						 	  'default_currency'    	   	 => trim($postVal['currency']),
						 	  'default_product_title'    	 => trim($postVal['product_title']));
	//	print_r($getData); die();
		if($this->remoteDb->update('invoice_credit_note_customization',$getData,'id = '.$postVal['custom_id'].'')) {
			return  true;	
		} else {
			return false;	
		}	
	}


	/**
	* Purpose : Insert audit log to the particular company database 
	* @param   array $postVal contain form post value
	* @return  last insert id when success
	*/
	
	public function insertAuditLog($event,$source,$name_number,$reference) {
		$logSession = new Zend_Session_Namespace('sess_login');
		if(isset($logSession->proxy_cid) && !empty($logSession->proxy_cid)) {
			$cid = $logSession->proxy_cid;
		} else {
			$cid = $logSession->cid;
		}
		$id = $logSession->id;
		$getData    =   array('fkcompany_id' => $cid,
						 	  'fkuser_id'    => $id,
						 	  'event'    	 => $event,
						 	  'source'    	 => $source,
						 	  'name_number'  => $name_number,
						 	  'reference'    => $reference);
		if($this->remoteDb->insert('audit_log',$getData)) {
			return  $this->remoteDb->lastInsertId();	
		} else {
			return false;	
		}
	}


	public function insertAuditLogin($event,$source,$name_number,$reference) {
		if(Zend_Session::namespaceIsset('sess_remote_database')) {
			$remoteSession = new Zend_Session_Namespace('sess_remote_database');
			$this->remoteDb = new Zend_Db_Adapter_Pdo_Mysql(array(
							    'host'     =>  $remoteSession->hostName,
							    'username' =>  $remoteSession->userName,
						        'password' =>  $remoteSession->password,
								'dbname'   =>  $remoteSession->dataBase
								)); 
			/*$this->remoteDb = new Zend_Db_Adapter_Pdo_Mysql(array(
							    'host'     =>  'localhost',
							    'username' =>  'root',
						        'password' =>  '',
								'dbname'   =>  'btrans'
								));*/
			$authAdapter = new Zend_Auth_Adapter_DbTable($this->remoteDb);
		}
		$logSession = new Zend_Session_Namespace('sess_login');
		if(isset($logSession->proxy_cid) && !empty($logSession->proxy_cid)) {
			$cid = $logSession->proxy_cid;
		} else {
			$cid = $logSession->cid;
		}
		$id = $logSession->id;
		$getData    =   array('fkcompany_id' => $cid,
						 	  'fkuser_id'    => $id,
						 	  'event'    	 => $event,
						 	  'source'    	 => $source,
						 	  'name_number'  => $name_number,
						 	  'reference'    => $reference);
		if($this->remoteDb->insert('audit_log',$getData)) {
			return  $this->remoteDb->lastInsertId();	
		} else {
			return false;	
		}
	}

	/**
	* Purpose  get audit log report for the particular company database
	* @param   none
	* @return  all audit log details of particular company
	*/	

	public function getAuditLog() {
		$sql = $this->remoteDb->fetchAll('SELECT * FROM audit_log ORDER BY id ASC');
	    return $sql;
	}

	/**
	* Purpose  get system audit log report for the particular company database
	* @param   none
	* @return  system audit log details of particular company
	*/	

	public function getSystemAuditLog($type) {
		$where ='1 AND source NOT IN (1,2,3,4,5,11)';
		if($type==2) {
			$where .= 'AND event=1';
		} else if($type==3) {
			$where .= 'AND event=2';
		} else if($type==4) {
			$where .= 'AND event=3';
		}
		$sql = $this->remoteDb->fetchAll('SELECT * FROM audit_log WHERE '.$where.' ORDER BY id ASC');
	    return $sql;
	}

	/**
	* Purpose  get transaction audit log report for the particular company database
	* @param   none
	* @return  transaction audit log details of particular company
	*/	

	public function getTransactionAuditLog($type) {
		$where ='1 AND source IN (1,2,3,4,5,11)';
		if($type==2) {
			$where .= 'AND event=1';
		} else if($type==3) {
			$where .= 'AND event=2';
		} else if($type==4) {
			$where .= 'AND event=3';
		}
		$sql = $this->remoteDb->fetchAll('SELECT * FROM audit_log WHERE '.$where.' ORDER BY id ASC');
	    return $sql;
	}

	/**
	* Purpose : check product name already exists for the particular company database
	* @param   product input name
	* @return  true if exists
	*/

	public function checkProductName($productName,$id='') {
		if(isset($id) && !empty($id)) {
			$sql = $this->remoteDb->fetchOne('SELECT id FROM products WHERE name="'.trim($productName).'" AND id!='.$id.'');
			return $sql;
		} else {
			$sql = $this->remoteDb->fetchOne('SELECT id FROM products WHERE name="'.trim($productName).'"');
			return $sql;
		}
	}


	/**
	* Purpose : check product id already exists for the particular company database
	* @param   product input id
	* @return  true if exists
	*/

	public function checkProductId($productId,$id='') {
		if(isset($id) && !empty($id)) {
			$sql = $this->remoteDb->fetchOne('SELECT id FROM products WHERE product_id="'.trim($productId).'" AND id!='.$id.'');
			return $sql;
		} else {
			$sql = $this->remoteDb->fetchOne('SELECT id FROM products WHERE product_id="'.trim($productId).'"');
			return $sql;
		}
	}

	/**
	* Purpose  get all themes available for the particular company database
	* @param   none
	* @return  all all themes of particular company
	*/	

	public function getAllThemes() {
		$sql = $this->remoteDb->fetchAll('SELECT * FROM theme_setting');
	    return $sql;
	}

	public function getAllDeveloperThemes() {
		$sql = $this->_db->fetchAll('SELECT * FROM themes');
	    return $sql;
	}

	/**
	* Purpose : Update theme settings to the particular company database 
	* @param   Previous active id and current selected id
	* @return  last update id when success
	*/
	
	public function updateTheme($aid,$cid) {
		$getPreviousData    =   array('default_theme'  => 2,
		             		  		  'date_modified'  => new Zend_Db_Expr('NOW()'));
		$getData    		=   array('default_theme'  => 1,
		             		  		  'date_modified'  => new Zend_Db_Expr('NOW()'));
		if($this->remoteDb->update('theme_setting',$getPreviousData,'id = '.$aid.'') && $this->remoteDb->update('theme_setting',$getData,'id = '.$cid.'')) {
			return  true;	
		} else {
			return false;	
		}
	}


		/**
	* Purpose : Update theme settings to the particular company database 
	* @param   Previous active id and current selected id
	* @return  last update id when success
	*/
	
	public function updateDeveloperTheme($aid,$cid) {
		$getPreviousData    =   array('default_theme'  => 2,
		             		  		  'date_modified'  => new Zend_Db_Expr('NOW()'));
		$getData    		=   array('default_theme'  => 1,
		             		  		  'date_modified'  => new Zend_Db_Expr('NOW()'));
		if($this->_db->update('themes',$getPreviousData,'id = '.$aid.'') && $this->_db->update('themes',$getData,'id = '.$cid.'')) {
			return  true;	
		} else {
			return false;	
		}
	}

	/**
	* Purpose : Update opening balance for each coa for the particular company database
	* @param   array $postVal contain form post value
	* @return  last update id when success
	*/
	
	public function updateOpeningBalance($postVal) {
		foreach ($postVal['account_debit'] as $key => $value) {
			$debit_amount   = $value;
			$credit_amount  = $postVal['account_credit'][$key];
			$debit_balance  = str_replace(",","",$debit_amount);
			$credit_balance = str_replace(",","",$credit_amount);
			$getData    =   array( 'debit_opening_balance'  => $debit_balance,
								   'credit_opening_balance' => $credit_balance,
		             		       'date_modified' 	=> new Zend_Db_Expr('NOW()'));
			$this->remoteDb->update('account',$getData,'id='.$key.'');
	    }
	    return true;
	}

	/**
	* Purpose : check product name or product id already exists for the particular company database
	* @param   product input name
	* @return  true if exists
	*/

	public function checkProductImport($productName,$productId) {
		//echo 'SELECT id FROM products WHERE name="'.trim($productName).'" OR product_id="'.trim($productId).'"'; die();
		$sql = $this->remoteDb->fetchOne('SELECT id FROM products WHERE name="'.trim(addslashes($productName)).'" OR product_id="'.trim($productId).'"');
		return $sql;
	}


	/**
	* Purpose : Update particular tax code as active to all company database 
	* @param   tax primary id
	* @return  last update id when success
	*/
	
	public function setIrasTax($tid,$status) {
		$getData    =   array('status'     => $status,
		             		  'date_modified'  => new Zend_Db_Expr('NOW()'));
		if($this->_db->update('taxcodes',$getData,'id = '.$tid.'')) {
			return  true;	
		} else {
			return false;	
		}
	}



	/**
	* Purpose : Insert tax to all company database 
	* @param   array $postVal contain form post value
	* @return  last insert id when success
	*/
	
	public function insertIrasTax($postVal) {
		$getData    =   array('name'   		     => trim(strtoupper($postVal['tax_code'])),
						 	  'percentage'    	 => trim($postVal['percentage']),
						 	  'description'    	 => stripslashes($postVal['description']),
						 	  'type'    	   	 => $postVal['tax_type']);
		if($this->_db->insert('taxcodes',$getData)) {
			return  $this->_db->lastInsertId();	
		} else {
			return false;	
		}
	}



}
?>