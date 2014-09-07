<?php
class Business extends Zend_Db_Table 
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
		//echo '<pre>'; print_r($this->remoteDb); echo '</pre>';
	}

	/**
	* Purpose  get all the customer details and their default key contact details
	* @param   none
	* @return  all customer details with their default key contact person details
	*/	

	public function getCustomers($id='') {
		if(isset($id) && !empty($id)) {
			$sql = $this->remoteDb->fetchAll('SELECT * FROM customers WHERE id='.$id.'');
			return $sql;
		} else {
			$where = 't1.delete_status = 1';
			$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'customers'),array('t1.id as cid','t1.customer_id','t1.customer_name','t1.country','t1.office_number'))
					 ->joinLeft(array('t2' => 'customer_contact_person'),'t1.id = t2.fkcustomer_id AND t2.default_key_contact = 1 AND t2.contact_type = 1',array('t2.id as pid',
					 		't2.contact_name','t2.designation'))
					 ->where($where);
		    $sql = $this->remoteDb->fetchAll($select);
			return $sql;	
		}
	}

	/**
	* Purpose  get all the vendor details and their default key contact details
	* @param   none
	* @return  all vendor details with their default key contact person details
	*/	

	public function getVendors($id='') {
		if(isset($id) && !empty($id)) {
			$sql = $this->remoteDb->fetchAll('SELECT * FROM vendors WHERE id='.$id.'');
			return $sql;
		} else {
			$where = 't1.delete_status = 1';
			$select  = $this->remoteDb->select()
					 ->from(array('t1' => 'vendors'),array('t1.id as vid','t1.vendor_id','t1.vendor_name','t1.country','t1.office_number'))
					 ->joinLeft(array('t2' => 'customer_contact_person'),'t1.id = t2.fkcustomer_id AND t2.default_key_contact = 1 AND t2.contact_type = 2',array('t2.id as pid',
					 		't2.contact_name','t2.designation'))
					 ->where($where);
					// echo '<pre>'; print_r($select); echo '</pre>'; die();
		    $sql = $this->remoteDb->fetchAll($select);
			return $sql;	
		}
	}

	/**
	* Purpose  get the shipping address details for the particular customer
	* @param   customer row id
	* @return  shipping address details for the particular customer id
	*/	

	public function getShippingAddress($sid) {
		$sql = $this->remoteDb->fetchAll('SELECT * FROM customer_shipping_address WHERE fkcustomer_id='.$sid.'');
		return $sql;
	}

	/**
	* Purpose  get the key contact details for the particular customer
	* @param   customer row id and contact type
	* @return  key contact details for the particular customer id
	*/	

	public function getKeyContacts($sid,$ctype) {
		$sql = $this->remoteDb->fetchAll('SELECT * FROM customer_contact_person WHERE fkcustomer_id='.$sid.' AND contact_type='.$ctype.'');
		return $sql;
	}

	/**
	* Purpose : Insert customer details 
	* @param   array $postVal contain form post value and company primary row id
	* @return  last insert id when success
	*/
	
	public function insertCustomer($postVal,$cid) {
		$getCustomer_id = $this->getCustomerID();
		if(isset($postVal['gst_status']) && !empty($postVal['gst_status'])) {
			$gst_date   =   date("Y-m-d",strtotime($postVal['gst_status']));
		} else {
			$gst_date = '';
		}
		$getData    =   array('fkcompany_id'   			=> $cid,
						 	  'customer_id'    			=> $getCustomer_id,
						 	  'customer_name'    		=> trim($postVal['customer_name']),
						 	  'address1'    	   	    => trim(addslashes($postVal['address1'])),
						 	  'address2'    	   		=> trim(addslashes($postVal['address2'])),
						 	  'company_registration_no' => trim($postVal['customer_reg_no']),
						 	  'office_number'    	 	=> trim($postVal['office_number']),
						 	  'fax_number'    			=> trim($postVal['fax_number']),
						 	  'city'    	   			=> trim($postVal['city']),
						 	  'state'    	   			=> trim($postVal['state']),
						 	  'country'    	   			=> trim($postVal['country']),
						 	  'website'    				=> trim($postVal['website']),
						 	  'email'    				=> trim($postVal['email']),
						 	  'company_gst_no'    	   	=> trim($postVal['company_gst_no']),
						 	  'coa_link'    	   		=> trim($postVal['coa_link']),
						 	 // 'other_coa_link'    	   	=> trim($postVal['other_coa']),
						 	  'postcode'    	   		=> trim($postVal['postcode']),
						 	  'gst_verified_date'    	=> $gst_date);
		if($this->remoteDb->insert('customers',$getData)) {
			$lastID = $this->remoteDb->lastInsertId();
			if(isset($lastID) && !empty($lastID)) {
				$shipping_counter = $postVal['shipping_counter'];
				$contact_counter  = $postVal['contact_counter'];
				if(isset($shipping_counter) && !empty($shipping_counter) && $shipping_counter!=0) {
					for ($i=1; $i <= $shipping_counter; $i++) { 
						$ship_address1   =   trim(addslashes($postVal['shipping_address_one_'.$i]));
						$ship_address2   =   trim(addslashes($postVal['shipping_address_two_'.$i]));
						$ship_city   	 =   trim($postVal['shipping_city_'.$i]);
						$ship_state   	 =   trim($postVal['shipping_state_'.$i]);
						$ship_country    =   trim($postVal['shipping_country_'.$i]);
						$ship_postcode   =   trim($postVal['shipping_postal_code_'.$i]);
					  if(isset($ship_address1) && !empty($ship_address1) && isset($ship_city) && !empty($ship_city) && isset($ship_state) && !empty($ship_state) && isset($ship_country) && !empty($ship_country)) {
						$getShipData     =   array('fkcustomer_id'    		=> $lastID,
											 	   'shipping_address1'  	=> $ship_address1,
											 	   'shipping_address2'  	=> $ship_address2,
											 	   'shipping_city'    	   	=> $ship_city,
											 	   'shipping_state' 		=> $ship_state,
											 	   'shipping_country'    	=> $ship_country,
											 	   'shipping_postcode'    	=> $ship_postcode);
							$insertShip  =  $this->remoteDb->insert('customer_shipping_address',$getShipData);
					  }
					}
				}

				if(isset($contact_counter) && !empty($contact_counter) && $contact_counter!=0) {
					for ($j=1; $j <= $contact_counter; $j++) { 
						$contact_person  =   trim($postVal['key_contact_person_'.$j]);
						$designation     =   trim($postVal['key_designation_'.$j]);
						$contact_office  =   trim($postVal['key_contact_office_'.$j]);
						$contact_email 	 =   trim($postVal['key_email_'.$j]);
						$contact_mobile  =   trim($postVal['key_contact_mobile_'.$j]);
						$default_person  =   trim($postVal['key_default_person_'.$j]);
					  if(isset($contact_person) && !empty($contact_person) && isset($designation) && !empty($designation) && isset($default_person) && !empty($default_person)) {
						$getContactData     =    array('fkcustomer_id'    		=> $lastID,
												 	   'contact_name'  			=> $contact_person,
												 	   'designation'  			=> $designation,
												 	   'contact_office_number'  => $contact_office,
												 	   'contact_mobile_number'  => $contact_mobile,
												 	   'contact_email'    		=> $contact_email,
												 	   'default_key_contact'    => $default_person,
												 	   'contact_type' => 1);
							$insertContact  =  $this->remoteDb->insert('customer_contact_person',$getContactData);
					  } 
					}
				}
				return $lastID;
			}
		} else {
			return false;
		}
	}


	/**
	* Purpose : Insert vendor details 
	* @param   array $postVal contain form post value and company primary row id
	* @return  last insert id when success
	*/
	
	public function insertVendor($postVal,$cid) {
		$getVendor_id = $this->getVendorID();
		if(isset($postVal['gst_status']) && !empty($postVal['gst_status'])) {
			$gst_date   =   date("Y-m-d",strtotime($postVal['gst_status']));
		} else {
			$gst_date = '';
		}
		$getData    =   array('fkcompany_id'   			=> $cid,
						 	  'vendor_id'    			=> $getVendor_id,
						 	  'vendor_name'	    		=> trim($postVal['vendor_name']),
						 	  'address1'    	   	    => trim(addslashes($postVal['address1'])),
						 	  'address2'    	   		=> trim(addslashes($postVal['address2'])),
						 	  'company_registration_no' => trim($postVal['vendor_reg_no']),
						 	  'office_number'    	 	=> trim($postVal['office_number']),
						 	  'fax_number'    			=> trim($postVal['fax_number']),
						 	  'city'    	   			=> trim($postVal['city']),
						 	  'state'    	   			=> trim($postVal['state']),
						 	  'country'    	   			=> trim($postVal['country']),
						 	  'website'    				=> trim($postVal['website']),
						 	  'email'    				=> trim($postVal['email']),
						 	  'company_gst_no'    	   	=> trim($postVal['company_gst_no']),
						 	  'coa_link'    	   		=> trim($postVal['coa_link']),
						 	//  'other_coa_link'    	   	=> trim($postVal['other_coa']),
						 	  'postcode'    	   		=> trim($postVal['postcode']),
						 	  'gst_verified_date'    	=> $gst_date);
		if($this->remoteDb->insert('vendors',$getData)) {
			$lastID = $this->remoteDb->lastInsertId();
			if(isset($lastID) && !empty($lastID)) {
				$contact_counter  = $postVal['contact_counter'];
				if(isset($contact_counter) && !empty($contact_counter) && $contact_counter!=0) {
					for ($j=1; $j <= $contact_counter; $j++) { 
						$contact_person  =   trim($postVal['key_contact_person_'.$j]);
						$designation     =   trim($postVal['key_designation_'.$j]);
						$contact_office  =   trim($postVal['key_contact_office_'.$j]);
						$contact_email 	 =   trim($postVal['key_email_'.$j]);
						$contact_mobile  =   trim($postVal['key_contact_mobile_'.$j]);
						$default_person  =   trim($postVal['key_default_person_'.$j]);
					  if(isset($contact_person) && !empty($contact_person) && isset($designation) && !empty($designation) && isset($default_person) && !empty($default_person)) {
						$getContactData     =    array('fkcustomer_id'    		=> $lastID,
												 	   'contact_name'  			=> $contact_person,
												 	   'designation'  			=> $designation,
												 	   'contact_office_number'  => $contact_office,
												 	   'contact_mobile_number'  => $contact_mobile,
												 	   'contact_email'    		=> $contact_email,
												 	   'default_key_contact'    => $default_person,
												 	   'contact_type' => 2);
							$insertContact  =  $this->remoteDb->insert('customer_contact_person',$getContactData);
					  } 
					}
				}
				return $lastID;
			}
		} else {
			return false;
		}
	}



	/**
	* Purpose : Update customer details 
	* @param   array $postVal contain form post value and company primary row id
	* @return  last update id when success
	*/
	
	public function updateCustomer($postVal,$cid) {
		if(isset($postVal['gst_status']) && !empty($postVal['gst_status'])) {
			$gst_date   =   date("Y-m-d",strtotime($postVal['gst_status']));
		} else {
			$gst_date = '';
		}
		$getData    =   array('customer_name'    		=> trim($postVal['customer_name']),
						 	  'address1'    	   	    => trim(addslashes($postVal['address1'])),
						 	  'address2'    	   		=> trim(addslashes($postVal['address2'])),
						 	  'company_registration_no' => trim($postVal['customer_reg_no']),
						 	  'office_number'    	 	=> trim($postVal['office_number']),
						 	  'fax_number'    			=> trim($postVal['fax_number']),
						 	  'city'    	   			=> trim($postVal['city']),
						 	  'state'    	   			=> trim($postVal['state']),
						 	  'country'    	   			=> trim($postVal['country']),
						 	  'website'    				=> trim($postVal['website']),
						 	  'email'    				=> trim($postVal['email']),
						 	  'company_gst_no'    	   	=> trim($postVal['company_gst_no']),
						 	  'postcode'    	   		=> trim($postVal['postcode']),
						 	  'coa_link'    	   		=> trim($postVal['coa_link']),
						 	//  'other_coa_link'    	   	=> trim($postVal['other_coa']),
						 	  'gst_verified_date'    	=> $gst_date,
		             		  'date_modified' 		    => new Zend_Db_Expr('NOW()'));
		if($this->remoteDb->update('customers',$getData,'id = '.$cid.'')) {

			    $update_shipping_counter = $postVal['update_shipping_counter'];
				$update_contact_counter  = $postVal['update_contact_counter'];
				if(isset($update_shipping_counter) && !empty($update_shipping_counter) && $update_shipping_counter!=0) {
					for ($i=1; $i <= $update_shipping_counter; $i++) { 
						$ship_address1   =   trim(addslashes($postVal['shipping_address_one_'.$i]));
						$ship_address2   =   trim(addslashes($postVal['shipping_address_two_'.$i]));
						$ship_city   	 =   trim($postVal['shipping_city_'.$i]);
						$ship_state   	 =   trim($postVal['shipping_state_'.$i]);
						$ship_country    =   trim($postVal['shipping_country_'.$i]);
						$ship_postcode   =   trim($postVal['shipping_postal_code_'.$i]);
						$ship_id  		 =   $postVal['ship_id_'.$i];	
					  if(isset($ship_id) && !empty($ship_id) && isset($ship_address1) && !empty($ship_address1) && isset($ship_city) && !empty($ship_city) && isset($ship_state) && !empty($ship_state) && isset($ship_country) && !empty($ship_country)) {
						$getShipData     =   array('shipping_address1'  	=> $ship_address1,
											 	   'shipping_address2'  	=> $ship_address2,
											 	   'shipping_city'    	   	=> $ship_city,
											 	   'shipping_state' 		=> $ship_state,
											 	   'shipping_country'    	=> $ship_country,
											 	   'shipping_postcode'    	=> $ship_postcode,
		             		  					   'date_modified' 		    => new Zend_Db_Expr('NOW()'));
							$updateShip  =  $this->remoteDb->update('customer_shipping_address',$getShipData,'id = '.$ship_id.'');
					  }
					}
				}

				if(isset($update_contact_counter) && !empty($update_contact_counter) && $update_contact_counter!=0) {
					for ($j=1; $j <= $update_contact_counter; $j++) { 
						$contact_person  =   trim($postVal['key_contact_person_'.$j]);
						$designation     =   trim($postVal['key_designation_'.$j]);
						$contact_office  =   trim($postVal['key_contact_office_'.$j]);
						$contact_email 	 =   trim($postVal['key_email_'.$j]);
						$contact_mobile  =   trim($postVal['key_contact_mobile_'.$j]);
						$default_person  =   trim($postVal['key_default_person_'.$j]);
						$contact_id      =   $postVal['contact_id_'.$i];
					  if(isset($contact_id) && !empty($contact_id) && isset($contact_person) && !empty($contact_person) && isset($designation) && !empty($designation) && isset($default_person) && !empty($default_person)) {
						$getContactData     =    array('contact_name'  			=> $contact_person,
												 	   'designation'  			=> $designation,
												 	   'contact_office_number'  => $contact_office,
												 	   'contact_mobile_number'  => $contact_mobile,
												 	   'contact_email'    		=> $contact_email,
												 	   'default_key_contact'    => $default_person,
		             		 						   'date_modified' 		    => new Zend_Db_Expr('NOW()'));
							$updateContact  =  $this->remoteDb->update('customer_contact_person',$getContactData,'id = '.$contact_id.'');
					  } 
					}
				}

				$shipping_counter = $postVal['shipping_counter'];
				$contact_counter  = $postVal['contact_counter'];
				if(isset($shipping_counter) && !empty($shipping_counter) && $shipping_counter!=0) {
					for ($i=++$update_shipping_counter; $i <= $shipping_counter; $i++) { 
						$ship_address1   =   trim(addslashes($postVal['shipping_address_one_'.$i]));
						$ship_address2   =   trim(addslashes($postVal['shipping_address_two_'.$i]));
						$ship_city   	 =   trim($postVal['shipping_city_'.$i]);
						$ship_state   	 =   trim($postVal['shipping_state_'.$i]);
						$ship_country    =   trim($postVal['shipping_country_'.$i]);
						$ship_postcode   =   trim($postVal['shipping_postal_code_'.$i]);
					  if(isset($ship_address1) && !empty($ship_address1) && isset($ship_city) && !empty($ship_city) && isset($ship_state) && !empty($ship_state) && isset($ship_country) && !empty($ship_country)) {
						$getShipData     =   array('fkcustomer_id'    		=> $cid,
											 	   'shipping_address1'  	=> $ship_address1,
											 	   'shipping_address2'  	=> $ship_address2,
											 	   'shipping_city'    	   	=> $ship_city,
											 	   'shipping_state' 		=> $ship_state,
											 	   'shipping_country'    	=> $ship_country,
											 	   'shipping_postcode'    	=> $ship_postcode);
							$insertShip  =  $this->remoteDb->insert('customer_shipping_address',$getShipData);
					  }
					}
				}

				if(isset($contact_counter) && !empty($contact_counter) && $contact_counter!=0) {
					for ($j=++$update_contact_counter; $j <= $contact_counter; $j++) { 
						$contact_person  =   trim($postVal['key_contact_person_'.$j]);
						$designation     =   trim($postVal['key_designation_'.$j]);
						$contact_office  =   trim($postVal['key_contact_office_'.$j]);
						$contact_email 	 =   trim($postVal['key_email_'.$j]);
						$contact_mobile  =   trim($postVal['key_contact_mobile_'.$j]);
						$default_person  =   trim($postVal['key_default_person_'.$j]);
					  if(isset($contact_person) && !empty($contact_person) && isset($designation) && !empty($designation) && isset($default_person) && !empty($default_person)) {
						$getContactData     =    array('fkcustomer_id'    		=> $cid,
												 	   'contact_name'  			=> $contact_person,
												 	   'designation'  			=> $designation,
												 	   'contact_office_number'  => $contact_office,
												 	   'contact_mobile_number'  => $contact_mobile,
												 	   'contact_email'    		=> $contact_email,
												 	   'default_key_contact'    => $default_person,
												 	   'contact_type' => 1);
							$insertContact  =  $this->remoteDb->insert('customer_contact_person',$getContactData);
					  } 
					}
				}
				return true;
		} else {
			return false;
		}
	}



	/**
	* Purpose : Update vendor details 
	* @param   array $postVal contain form post value and company primary row id
	* @return  last update id when success
	*/
	
	public function updateVendor($postVal,$cid) {
		if(isset($postVal['gst_status']) && !empty($postVal['gst_status'])) {
			$gst_date   =   date("Y-m-d",strtotime($postVal['gst_status']));
		} else {
			$gst_date = '';
		}
		$getData    =   array('vendor_name'    			=> trim($postVal['vendor_name']),
						 	  'address1'    	   	    => trim(addslashes($postVal['address1'])),
						 	  'address2'    	   		=> trim(addslashes($postVal['address2'])),
						 	  'company_registration_no' => trim($postVal['vendor_reg_no']),
						 	  'office_number'    	 	=> trim($postVal['office_number']),
						 	  'fax_number'    			=> trim($postVal['fax_number']),
						 	  'city'    	   			=> trim($postVal['city']),
						 	  'state'    	   			=> trim($postVal['state']),
						 	  'country'    	   			=> trim($postVal['country']),
						 	  'website'    				=> trim($postVal['website']),
						 	  'email'    				=> trim($postVal['email']),
						 	  'company_gst_no'    	   	=> trim($postVal['company_gst_no']),
						 	  'postcode'    	   		=> trim($postVal['postcode']),
						 	  'coa_link'    	   		=> trim($postVal['coa_link']),
						 	//  'other_coa_link'    	   	=> trim($postVal['other_coa']),
						 	  'gst_verified_date'    	=> $gst_date,
		             		  'date_modified' 		    => new Zend_Db_Expr('NOW()'));
		if($this->remoteDb->update('vendors',$getData,'id = '.$cid.'')) {

				$update_contact_counter  = $postVal['update_contact_counter'];
				
				if(isset($update_contact_counter) && !empty($update_contact_counter) && $update_contact_counter!=0) {
					for ($j=1; $j <= $update_contact_counter; $j++) { 
						$contact_person  =   trim($postVal['key_contact_person_'.$j]);
						$designation     =   trim($postVal['key_designation_'.$j]);
						$contact_office  =   trim($postVal['key_contact_office_'.$j]);
						$contact_email 	 =   trim($postVal['key_email_'.$j]);
						$contact_mobile  =   trim($postVal['key_contact_mobile_'.$j]);
						$default_person  =   trim($postVal['key_default_person_'.$j]);
						$contact_id      =   $postVal['contact_id_'.$i];
					  if(isset($contact_id) && !empty($contact_id) && isset($contact_person) && !empty($contact_person) && isset($designation) && !empty($designation) && isset($default_person) && !empty($default_person)) {
						$getContactData     =    array('contact_name'  			=> $contact_person,
												 	   'designation'  			=> $designation,
												 	   'contact_office_number'  => $contact_office,
												 	   'contact_mobile_number'  => $contact_mobile,
												 	   'contact_email'    		=> $contact_email,
												 	   'default_key_contact'    => $default_person,
		             		 						   'date_modified' 		    => new Zend_Db_Expr('NOW()'));
							$updateContact  =  $this->remoteDb->update('customer_contact_person',$getContactData,'id = '.$contact_id.'');
					  } 
					}
				}


				$contact_counter  = $postVal['contact_counter'];
				
				if(isset($contact_counter) && !empty($contact_counter) && $contact_counter!=0) {
					for ($j=++$update_contact_counter; $j <= $contact_counter; $j++) { 
						$contact_person  =   trim($postVal['key_contact_person_'.$j]);
						$designation     =   trim($postVal['key_designation_'.$j]);
						$contact_office  =   trim($postVal['key_contact_office_'.$j]);
						$contact_email 	 =   trim($postVal['key_email_'.$j]);
						$contact_mobile  =   trim($postVal['key_contact_mobile_'.$j]);
						$default_person  =   trim($postVal['key_default_person_'.$j]);
					  if(isset($contact_person) && !empty($contact_person) && isset($designation) && !empty($designation) && isset($contact_email) && !empty($contact_email) && isset($contact_mobile) && !empty($contact_mobile) && isset($default_person) && !empty($default_person)) {
						$getContactData     =    array('fkcustomer_id'    		=> $cid,
												 	   'contact_name'  			=> $contact_person,
												 	   'designation'  			=> $designation,
												 	   'contact_office_number'  => $contact_office,
												 	   'contact_mobile_number'  => $contact_mobile,
												 	   'contact_email'    		=> $contact_email,
												 	   'default_key_contact'    => $default_person,
												 	   'contact_type' => 2);
							$insertContact  =  $this->remoteDb->insert('customer_contact_person',$getContactData);
					  } 
					}
				}
				return true;
		} else {
			return false;
		}
	}


   /**
	* Purpose : get next customer ID for the particular company database
	* @param   none
	* @return  customer ID
	*/

	public function getCustomerID() {
		$sql = $this->remoteDb->fetchOne('SELECT customer_id FROM customers ORDER BY id DESC');
		if(isset($sql) && !empty($sql)) {
			$customer_id = ++$sql;
			return $customer_id;
		} else {
			$customer_id = 'CUS-0000000001';
			return $customer_id;
		}
	}



   /**
	* Purpose : get next vendor ID for the particular company database
	* @param   none
	* @return  vendor ID
	*/

	public function getVendorID() {
		$sql = $this->remoteDb->fetchOne('SELECT vendor_id FROM vendors ORDER BY id DESC');
		if(isset($sql) && !empty($sql)) {
			$vendor_id = ++$sql;
			return $vendor_id;
		} else {
			$vendor_id = 'VEN-0000000001';
			return $vendor_id;
		}
	}


	/**
	* Purpose  delete particular customer means update delete status to 2 and check invoice or income if customer id exists there before delete
	* @param   customer primary id
	* @return  return true on success
	*/	

	 public function deleteCustomer($delid) {
	 	$checkInvoice  =  $this->remoteDb->fetchAll('SELECT fkcustomer_id FROM invoice WHERE fkcustomer_id='.$delid.''); 
	 	$checkIncome   =  $this->remoteDb->fetchAll('SELECT fkcustomer_id FROM income_transaction WHERE fkcustomer_id='.$delid.'');
	 	//$checkReceipt  =  $this->remoteDb->fetchAll('SELECT fkbusiness_id FROM receipt_uploads WHERE fkbusiness_id ='.$delid.' AND receipt_type=1');
	 	$inv = count($checkInvoice);
	    $inc = count($checkIncome);
	    $rec = count($checkReceipt);
		if($inv==0 && $inc==0 && $rec==0) {
			$getData    =   array('delete_status'   => 2,
			             		  'date_modified' 	=> new Zend_Db_Expr('NOW()'));
			if($this->remoteDb->update('customers',$getData,'id = '.$delid.'')) {
				return  1;	
			} else {
				return false;	
			}
		} else {
			return 3;
		}
	}	


	/**
	* Purpose  check receipt is associated with income or expense
	* @param   receipt primary id
	* @return  return number of counts
	*/	


	 public function checkReceipt($delid,$type) {
	 	if($type==1) {
		 	$sql  =  $this->remoteDb->fetchAll('SELECT fkreceipt_id FROM income_transaction WHERE fkreceipt_id='.$delid.''); 
		 	$receipt = count($sql);
		 	return $receipt;
		} else if($type==2) {
			$sql  =  $this->remoteDb->fetchAll('SELECT fkreceipt_id FROM expense_transaction WHERE fkreceipt_id='.$delid.''); 
		 	$receipt = count($sql);
		 	return $receipt;
		}
	 }


	/**
	* Purpose  delete particular vendor means update delete status to 2
	* @param   vendor primary id
	* @return  return true on success
	*/	

	 public function deleteVendor($delid) {  
	 	$checkExpense  =  $this->remoteDb->fetchAll('SELECT fkvendor_id FROM expense_transaction WHERE fkvendor_id='.$delid.'');
	 	$exp = count($checkExpense);
		if($exp==0) {
			$getData    =   array('delete_status'   => 2,
			             		  'date_modified' 	=> new Zend_Db_Expr('NOW()'));
			if($this->remoteDb->update('vendors',$getData,'id = '.$delid.'')) {
				return  1;	
			} else {	
				return false;	
			}
		} else {
			return  3;	
		}
	}

	/**
	* Purpose  get particular customer detail
	* @param   customer primary row id
	* @return  particular customer detail
	*/	

	public function getCustomerDetails($id) {
		$sql = $this->remoteDb->fetchAll('SELECT * FROM customers WHERE id='.$id.'');
		return $sql;
	}

	/**
	* Purpose  get particular vendor detail
	* @param   vendor primary row id
	* @return  particular vendor detail
	*/	

	public function getVendorDetails($id) {
		$sql = $this->remoteDb->fetchAll('SELECT * FROM vendors WHERE id='.$id.'');
		return $sql;
	}

	/**
	* Purpose  get receipts of particular customer (or) vendor
	* @param   customer primary row id $id and receipt type 1 (or) 2 $rtype 
	* @return  receipt details of particular customer (or) vendor 
	*/	

	public function getReceipts($id='',$rtype) {
		if(isset($id) && !empty($id)) {
			$sql = $this->remoteDb->fetchAll('SELECT * FROM receipt_uploads WHERE fkbusiness_id='.$id.' AND receipt_type='.$rtype.'');
			return $sql;
		} else {
			$sql = $this->remoteDb->fetchAll('SELECT id,fkbusiness_id,name,receipt FROM receipt_uploads WHERE receipt_type='.$rtype.'');
			return $sql;
		}
	}

	/**
	* Purpose  Insert receipt for the particular cus
	* @param   array $postVal contain form post value and customer primary row id $id and receipt type 1 (or) 2 $rtype 
	* @return  last inserted if success
	*/	

	public function insertReceipt($postVal,$id,$rtype) {
		$getData    =   array('fkbusiness_id' => $id,
						 	  'name'     	  => trim($postVal['receipt_name']),
						 	  'receipt'       => trim($postVal['attach_file']),
						 	  'extension'     => trim($postVal['extension']),
						 	  'receipt_type'  => $rtype);
		if($this->remoteDb->insert('receipt_uploads',$getData)) {
			return  $this->remoteDb->lastInsertId();	
		} else {
			return false;	
		} 
	}

	 /**
	* Purpose  delete particular receipt of the customer 
	* @param   receipt primary id
	* @return  return true on success
	*/	

	 public function deleteReceipt($delid) {  
	 	$sql = $this->remoteDb->delete('receipt_uploads', 'id = '.$delid.'');
		if($sql) {
			return true;
		} else {
			return false;
		}
	}	

	/**
	* Purpose : check customer name already exists for the particular company database
	* @param   customer input name
	* @return  true if exists
	*/

	public function checkCustomer($customerName,$id='') {
		if(isset($id) && !empty($id)) {
			$sql = $this->remoteDb->fetchOne('SELECT id FROM customers WHERE customer_name="'.trim($customerName).'" AND id!='.$id.'');
			return $sql;
		} else {
			$sql = $this->remoteDb->fetchOne('SELECT id FROM customers WHERE customer_name="'.trim($customerName).'"');
			return $sql;
		}
	}


	 /**
	* Purpose : check vendor name already exists for the particular company database
	* @param   vendor input name
	* @return  true if exists
	*/

	public function checkVendor($vendorName,$id='') {
		if(isset($id) && !empty($id)) {
			$sql = $this->remoteDb->fetchOne('SELECT id FROM vendors WHERE vendor_name="'.trim($vendorName).'" AND id!='.$id.'');
			return $sql;
		} else {
			$sql = $this->remoteDb->fetchOne('SELECT id FROM vendors WHERE vendor_name="'.trim($vendorName).'"');
			return $sql;
		}
	}


	/**
	* Purpose  get all customer name
	* @param   none
	* @return  all customer name
	*/	

	public function getCustomerName($id='') {
		if(isset($id) && !empty($id)) {
			$sql = $this->remoteDb->fetchOne('SELECT customer_name FROM customers WHERE id='.$id.'');
			return $sql;
		} else {
			$sql = $this->remoteDb->fetchAll('SELECT id,customer_name FROM customers');
			return $sql;
		}
	}

	/**
	* Purpose  get all vendor name
	* @param   vendor primary row id
	* @return  all vendor name
	*/	

	public function getVendorName($id='') {
		if(isset($id) && !empty($id)) {
			$sql = $this->remoteDb->fetchOne('SELECT vendor_name FROM vendors WHERE id='.$id.'');
			return $sql;
		} else {
			$sql = $this->remoteDb->fetchAll('SELECT id,vendor_name FROM vendors');
			return $sql;
		}
	}

	/**
	* Purpose  get all other receivables details
	* @param   none
	* @return  all other receivables details
	*/	

	public function getOtherReceivables() {
		$sql = $this->remoteDb->fetchAll('SELECT * FROM account WHERE account_type=1 AND level1=1 AND level2=5 AND id!=4');
		return $sql;
	}


	/**
	* Purpose  get all other payables details
	* @param   none
	* @return  all other payables details
	*/	

	public function getOtherPayables() {
		$sql = $this->remoteDb->fetchAll('SELECT * FROM account WHERE account_type=2 AND level1=1 AND level2=8 AND id!=6');
		return $sql;
	}

	/**
	* Purpose  get income transaction count for particular customer
	* @param   customer id
	* @return  count of income transaction
	*/	

	public function getIncomeCount($id) {
		$sql = $this->remoteDb->fetchOne('SELECT count(*) FROM income_transaction WHERE fkcustomer_id='.$id.'');
		return $sql;
	}

	/**
	* Purpose  get invoice transaction count for particular customer
	* @param   customer id
	* @return  count of invoice transaction
	*/	

	public function getInvoiceCount($id) {
		$sql = $this->remoteDb->fetchOne('SELECT count(*) FROM invoice WHERE fkcustomer_id='.$id.'');
		return $sql;
	}

	/**
	* Purpose  get expense transaction count for particular vendor
	* @param   vendor id
	* @return  count of expense transaction
	*/	

	public function getExpenseCount($id) {
		$sql = $this->remoteDb->fetchOne('SELECT count(*) FROM expense_transaction WHERE fkvendor_id='.$id.'');
		return $sql;
	}
	
}