<?php 
class ImportController extends Zend_Controller_Action {
	/**
     * @var result
    */
	protected $result;
	
	/**
    * @var $postArray
    */
	protected $postArray;
	
	public function init() {
		  $front      = Zend_Controller_Front::getInstance(); 
  		 //getting current module and action names
		$action     = $front->getRequest()->getActionName();
		$module     = $front->getRequest()->getModuleName();
		$controller = $front->getRequest()->getControllerName();
		$this->root 	   = Zend_Registry::get('path');
		$this->uploadPath  = Zend_Registry::get('uploadpath');
		$this->account 	   = new Account();
		$this->settings    = new Settings();
		$this->transaction = new Transaction();
		$this->business    = new Business();
		$this->approval    = new Approval();
		$this->accountData = new Account_Data();
		if(Zend_Session::namespaceIsset('sess_login')) {
			$logSession = new Zend_Session_Namespace('sess_login');
			if($logSession->type==0 && !isset($logSession->proxy_type)) {
				$this->_redirect('developer');
			} else if($logSession->type==0 && isset($logSession->proxy_type) && ($logSession->proxy_type==3 || $logSession->proxy_type==4 || $logSession->proxy_type==5)) {
				$this->_redirect('developer');
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

	public function customersAction() {
	      if(!Zend_Session::namespaceIsset('sess_login')) {
	            $this->_redirect('index');
	      } else {
	      	$logSession = new Zend_Session_Namespace('sess_login');
	      	$error = array();
	      	if(isset($logSession->proxy_cid) && !empty($logSession->proxy_cid)) {
		        $cid = $logSession->proxy_cid;
			    $this->json    =  "..".$this->uploadPath.$logSession->proxy_cid."/accounts.json";
		    } else {
				$cid = $logSession->cid;
			    $this->json    =  "..".$this->uploadPath.$logSession->cid."/accounts.json";
			}
			if(Zend_Session::namespaceIsset('import_customer')) {
				$sessSuccess = new Zend_Session_Namespace('import_customer');
				$this->view->success = $sessSuccess->status.' Customers imported successfully';
				Zend_Session::namespaceUnset('import_customer');
			}
			if(Zend_Session::namespaceIsset('import_customer_error')) {
				$sessError = new Zend_Session_Namespace('import_customer_error');
				$this->view->error = $sessError->status. ' rows cannot be inserted due to mismatch or duplicate or invalid entry';
				Zend_Session::namespaceUnset('import_customer_error');
			}
			    $account = array();
				$this->view->viewpath    =  "../".$this->uploadPath;
			    $this->view->filepath    =  $this->uploadPath.$cid."/imports/";
			    $getAccountArray         =  $this->accountData->getData(array('country'));
			    $countries   =  $getAccountArray['country'];
			    $getAccount	=  $this->settings->getAccounts();
				foreach ($getAccount as $key => $accounts) {
					$account[$accounts['id']] = array("type" => $accounts['account_type'],"name" => $accounts['account_name'],"level1" => $accounts['level1'],"level2" => $accounts['level2']);
				}
		      	if($this->_request->isPost()) {
						$postArray  =   $this->getRequest()->getPost();
						$total_count = 0;
						$total_error = 0;
						$adapter       = new Zend_File_Transfer_Adapter_Http();
						$fileInfo 	   = $adapter->getFileInfo('file'); 
						if(isset($fileInfo['file']['name']) && ($fileInfo['file']['name'] != '')) {
						$adapter->addValidator('Count', false, array('min' =>1, 'max' => 2))
						        ->addValidator('Size',false,array('max'=>2024000),'file')
								->addValidator('Extension',false,'xls,xlsx','file');
						$adapter->setDestination("..".$this->view->filepath,'file');
						$fileInfo 	         	  =   $adapter->getFileInfo('file');
						$fileArray		  		  =   explode('.',$fileInfo['file']['name']);
						$postArray['extension']   =   $fileArray['1'];
						$renameFile 		  	  =  "ExcelImportCustomer_".rand(10,10000).".".$fileArray['1'];
						$postArray['import']      =   $renameFile;
						$adapter->addFilter('Rename',"..".$this->view->filepath.$renameFile);
							if ($adapter->isValid('file') && $adapter->receive('file')) {
								$postArray['import'] =   $renameFile;
							} else {
								$postArray['import'] =   '';
							}
					} else {
						$postArray['import'] =   '';
					}
				      	$inputFileName = "../".$this->view->filepath.$postArray['import'];

						$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);

						$this->sheetData = $objPHPExcel->getSheet(0)->toArray(null,true,true,true);
						foreach ($this->sheetData as $key => $data) {
							if($key!=1) {
								$post['customer_name']  = trim($data['A']);
								$post['customer_reg_no']   = $data['B'];
								$post['company_gst_no']   = $data['C'];
								$post['gst_status']  = $data['D'];
								$post['email'] = $data['E'];
								$post['office_number'] = str_replace(" ","",$data['F']);
								$post['fax_number']   = $data['G'];
								$post['website']   = $data['H'];
								$post['address1'] = trim($data['I']);
								$post['address2'] = $data['J'];
								$post['city']  = $data['K'];
								$post['state'] = $data['L'];
								$post['postcode']   = $data['M'];
								$post['count'] = $data['N'];
								$post['coa'] = strtolower(str_replace(" ", "", $data['O']));
								if(isset($post['customer_name']) && !empty($post['customer_name'])) {
									 $checkCustomer = $this->business->checkCustomer($post['customer_name']); 
									 if($checkCustomer) {
									 	$error_status = 'Customer Already Exists';
									 	$error[$key]['name']   = $post['customer_name'];
									 	$error[$key]['status'] = $error_status;
									 	$total_error++;
									 } else {
									 	//echo strlen($post['address1']);
									 	if(!empty($post['customer_reg_no']) && !empty($post['coa']) && !empty($post['office_number']) && is_numeric($post['office_number']) && !empty($post['address1']) && (strlen($post['address1'])>=10) && !empty($post['city']) && !empty($post['postcode'])) {
										 	if(in_array($post['count'], $countries)) {
										 		$post['country'] = array_search($post['count'], $countries);
										 		$exists = 0;
												foreach ($account as $key => $acc) {
													$accname = strtolower(str_replace(" ", "", $acc['name']));
													if($key==3 && $acc['type']==1 && $acc['level1']==1 && $acc['level2']==4 && $accname==$post['coa']) {
														$post['coa_link'] = $key;
														$exists++;
													} else if($acc['level1']==1 && $acc['type']==1 && $acc['level2']==5 && $accname==$post['coa']) {
														$post['coa_link'] = $key;
														$exists++;
													}
												}
												if($exists!=0) {												
											 		$insertCustomer  = $this->business->insertCustomer($post,$cid);
											 		if($insertCustomer) {
											 			$auditLog	= $this->settings->insertAuditLog(1,6,$post['customer_name'],$insertCustomer);
											 			$total_count++;
											 		} else {
											 			$error_status = 'Customer Already Exists';
													 	$error[$key]['name']   = $post['customer_name'];
													 	$error[$key]['status'] = $error_status;
													 	$total_error++;
											 		}
											 	} else {
											 		$error_status = 'Account Name Not Exists';
													$error[$key]['name']   = $post['customer_name'];
													$error[$key]['status'] = $error_status;
													$total_error++;
											 	}
										 	} else {
										 		$error_status = 'Country Name Not Matched With Our Database';
											 	$error[$key]['name']   = $post['customer_name'];
											 	$error[$key]['status'] = $error_status;
											 	$total_error++;
										 	}
										 } else {
										 	//print_r($post);
										 	$error_status = 'Empty';
											$error[$key]['name']   = $post['customer_name'];
											$error[$key]['status'] = $error_status;
											$total_error++;
										 }
									 }
								} else {
									$error_status = 'Customer Name Empty';
									$error[$key]['name']   = $post['customer_name'];
									$error[$key]['status'] = $error_status;
									$total_error++;
								}
							}
						}

						if($total_count!=0) {
							//$auditLog	= $this->settings->insertAuditLog(10,6,$postArray['import'],$total_count);
							$sessSuccess = new Zend_Session_Namespace('import_customer');
				    		$sessSuccess->status = $total_count;
				    		if(sizeof($error)>0) {
				    			$sessError = new Zend_Session_Namespace('import_customer_error');
				    			$sessError->error  = $error;
				    		    $sessError->status = $total_error;
				    		}
				    		$this->_redirect('import/customers/');	
						} else if($total_count==0) {
							if(sizeof($error)>0) {
				    			$sessError = new Zend_Session_Namespace('import_customer_error');
				    			$sessError->error  = $error;
				    		    $sessError->status = $total_error;
				    		}
				    		$this->_redirect('import/customers/');	
						}
				}
	      }
	     // echo '<pre>'; print_r($this->sheetData); echo '</pre>';
    }

    public function vendorsAction() {
      if(!Zend_Session::namespaceIsset('sess_login')) {
	            $this->_redirect('index');
	      } else {
	      	$logSession = new Zend_Session_Namespace('sess_login');
	      	$error = array();
	      	if(isset($logSession->proxy_cid) && !empty($logSession->proxy_cid)) {
		        $cid = $logSession->proxy_cid;
			    $this->json    =  "..".$this->uploadPath.$logSession->proxy_cid."/accounts.json";
		    } else {
				$cid = $logSession->cid;
			    $this->json    =  "..".$this->uploadPath.$logSession->cid."/accounts.json";
			}
			if(Zend_Session::namespaceIsset('import_vendor')) {
				$sessSuccess = new Zend_Session_Namespace('import_vendor');
				$this->view->success = $sessSuccess->status.' Vendors imported successfully';
				Zend_Session::namespaceUnset('import_vendor');
			}
			if(Zend_Session::namespaceIsset('import_vendor_error')) {
				$sessError = new Zend_Session_Namespace('import_vendor_error');
				$this->view->error = $sessError->status. ' rows cannot be inserted due to mismatch or duplicate or invalid entry';
				Zend_Session::namespaceUnset('import_vendor_error');
			}
				$account = array();
				$this->view->viewpath    =  "../".$this->uploadPath;
			    $this->view->filepath    =  $this->uploadPath.$cid."/imports/";
			    $getAccountArray         =  $this->accountData->getData(array('country'));
			    $countries   =  $getAccountArray['country'];
			    $getAccount	=  $this->settings->getAccounts();
				foreach ($getAccount as $key => $accounts) {
					$account[$accounts['id']] = array("type" => $accounts['account_type'],"name" => $accounts['account_name'],"level1" => $accounts['level1'],"level2" => $accounts['level2']);
				}
		      	if($this->_request->isPost()) {
						$postArray  =   $this->getRequest()->getPost();
						$total_count = 0;
						$total_error = 0;
						$adapter       = new Zend_File_Transfer_Adapter_Http();
						$fileInfo 	   = $adapter->getFileInfo('file'); 
						if(isset($fileInfo['file']['name']) && ($fileInfo['file']['name'] != '')) {
						$adapter->addValidator('Count', false, array('min' =>1, 'max' => 2))
						        ->addValidator('Size',false,array('max'=>2024000),'file')
								->addValidator('Extension',false,'xls,xlsx','file');
						$adapter->setDestination("..".$this->view->filepath,'file');
						$fileInfo 	         	  =   $adapter->getFileInfo('file');
						$fileArray		  		  =   explode('.',$fileInfo['file']['name']);
						$postArray['extension']   =   $fileArray['1'];
						$renameFile 		  	  =  "ExcelImportVendor_".rand(10,10000).".".$fileArray['1'];
						$postArray['import']      =   $renameFile;
						$adapter->addFilter('Rename',"..".$this->view->filepath.$renameFile);
							if ($adapter->isValid('file') && $adapter->receive('file')) {
								$postArray['import'] =   $renameFile;
							} else {
								$postArray['import'] =   '';
							}
					} else {
						$postArray['import'] =   '';
					}
				      	$inputFileName = "../".$this->view->filepath.$postArray['import'];

						$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);

						$this->sheetData = $objPHPExcel->getSheet(0)->toArray(null,true,true,true);
						foreach ($this->sheetData as $key => $data) {
							if($key!=1) {
								$post['vendor_name']  = trim($data['A']);
								$post['vendor_reg_no']   = $data['B'];
								$post['company_gst_no']   = $data['C'];
								$post['gst_status']  = $data['D'];
								$post['email'] = $data['E'];
								$post['office_number'] = str_replace(" ","",$data['F']);
								$post['fax_number']   = $data['G'];
								$post['website']   = $data['H'];
								$post['address1'] = $data['I'];
								$post['address2'] = $data['J'];
								$post['city']  = $data['K'];
								$post['state'] = $data['L'];
								$post['postcode']   = $data['M'];
								$post['count'] = $data['N'];
								$post['coa'] = strtolower(str_replace(" ", "", $data['O']));
								if(isset($post['vendor_name']) && !empty($post['vendor_name'])) {
									 $checkVendor = $this->business->checkVendor($post['vendor_name']); 
									 if($checkVendor) {
									 	$error_status = 'Vendor Already Exists';
									 	$error[$key]['name']   = $post['vendor_name'];
									 	$error[$key]['status'] = $error_status;
									 	$total_error++;
									 } else {
									 	if(!empty($post['vendor_reg_no']) && !empty($post['coa']) && !empty($post['office_number']) && is_numeric($post['office_number']) && !empty($post['address1']) && (strlen($post['address1'])>=10) && !empty($post['city']) && !empty($post['postcode'])) {
											 	if(in_array($post['count'], $countries)) {
											 		$post['country'] = array_search($post['count'], $countries);
											 		$exists = 0;
													foreach ($account as $key => $acc) {
														$accname = strtolower(str_replace(" ", "", $acc['name']));
														if($key==5 && $acc['type']==2 && $acc['level1']==1 && $acc['level2']==3 && $accname==$post['coa']) {
															$post['coa_link'] = $key;
															$exists++;
														} else if($acc['level1']==1 && $acc['type']==2 && $acc['level2']==8 && $accname==$post['coa']) {
															$post['coa_link'] = $key;
															$exists++;
														}
													}
													if($exists!=0) {	
												 		$insertVendor  = $this->business->insertVendor($post,$cid);
												 		if($insertVendor) {
												 			$auditLog	= $this->settings->insertAuditLog(1,7,$post['vendor_name'],$insertVendor);
												 			$total_count++;
												 		} else {
												 			$error_status = 'Vendor Already Exists';
														 	$error[$key]['name']   = $post['vendor_name'];
														 	$error[$key]['status'] = $error_status;
														 	$total_error++;
												 		}
												 	} else {
												 		$error_status = 'Account Name Not Exists';
														$error[$key]['name']   = $post['vendor_name'];
														$error[$key]['status'] = $error_status;
														$total_error++;
												 	}
											 	} else {
											 		$error_status = 'Country Name Not Matched With Our Database';
												 	$error[$key]['name']   = $post['vendor_name'];
												 	$error[$key]['status'] = $error_status;
												 	$total_error++;
											 	}
										}
										else {
										 	$error_status = 'Empty';
											$error[$key]['name']   = $post['vendor_name'];
											$error[$key]['status'] = $error_status;
											$total_error++;
										 }
									 } 

								} else {
									$error_status = 'Vendor Name Empty';
									$error[$key]['name']   = $post['vendor_name'];
									$error[$key]['status'] = $error_status;
									$total_error++;
								}
							}
						}

						if($total_count!=0) {
							//$auditLog	= $this->settings->insertAuditLog(10,7,$postArray['import'],$total_count);
							$sessSuccess = new Zend_Session_Namespace('import_vendor');
				    		$sessSuccess->status = $total_count;
				    		if(sizeof($error)>0) {
				    			$sessError = new Zend_Session_Namespace('import_vendor_error');
				    			$sessError->error  = $error;
				    		    $sessError->status = $total_error;
				    		}
				    		$this->_redirect('import/vendors/');	
						} else if($total_count==0) {
							if(sizeof($error)>0) {
				    			$sessError = new Zend_Session_Namespace('import_vendor_error');
				    			$sessError->error  = $error;
				    		    $sessError->status = $total_error;
				    		}
				    		$this->_redirect('import/vendors/');	
						}
				}
	      }
    }


    public function coaAction() {
	      if(!Zend_Session::namespaceIsset('sess_login')) {
	            $this->_redirect('index');
	      } else {
	      	$logSession = new Zend_Session_Namespace('sess_login');
	      	$this->view->uploaded = '';
	      	if(isset($logSession->proxy_cid) && !empty($logSession->proxy_cid)) {
		      		$cid = $logSession->proxy_cid;
			      	$this->json    =  "..".$this->uploadPath.$logSession->proxy_cid."/accounts.json";
		      	} else {
					$cid = $logSession->cid;
			      	$this->json    =  "..".$this->uploadPath.$logSession->cid."/accounts.json";
			    }
			    if(Zend_Session::namespaceIsset('import_coa')) {
				$sessSuccess = new Zend_Session_Namespace('import_coa');
				$this->view->success = $sessSuccess->status.' Accounts imported successfully';
				Zend_Session::namespaceUnset('import_coa');
				}
				/*$sessError = new Zend_Session_Namespace('import_coa_error');
				var_dump($sessError);*/
				if(Zend_Session::namespaceIsset('import_coa_error')) {
					$sessError = new Zend_Session_Namespace('import_coa_error');
					$this->view->error = $sessError->error. ' rows cannot be inserted due to mismatch or duplicate or invalid entry';
					Zend_Session::namespaceUnset('import_coa_error');
				}
				$this->view->viewpath    =  "../".$this->uploadPath;
			    $this->view->filepath    =  $this->uploadPath.$cid."/imports/";
			    $account   = array();
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
		      						$keys = str_replace("  ", "", $keys);
		      						$key1 = str_replace("  ", "", $key1);
		      						$keys = str_replace(" ", "", $keys);
		      						$key1 = str_replace(" ", "", $key1);
		      						$asset[strtolower($keys)][strtolower($key1)][$key2] = strtolower($value2);
		      					}
		      				}
		      		}
		      	 }  else  if($key=='Liabilities') {
		      		foreach ($value as $keys => $values) {
		      				foreach ($values as $key1 => $value1) {
		      					foreach ($value1 as $key2 => $value2) {
		      						$keys = str_replace("  ", "", $keys);
		      						$key1 = str_replace("  ", "", $key1);
		      						$keys = str_replace(" ", "", $keys);
		      						$key1 = str_replace(" ", "", $key1);
		      						$liability[strtolower($keys)][strtolower($key1)][$key2] = strtolower($value2);
		      					}
		      				}
		      		}
		      	 }  else  if($key=='Income') {
		      		foreach ($value as $keys => $values) {
		      				foreach ($values as $key1 => $value1) {
		      					foreach ($value1 as $key2 => $value2) {
		      						$keys = str_replace("  ", "", $keys);
		      						$key1 = str_replace("  ", "", $key1);
		      						$keys = str_replace(" ", "", $keys);
		      						$key1 = str_replace(" ", "", $key1);
		      						$income[strtolower($keys)][strtolower($key1)][$key2] = strtolower($value2);
		      					}
		      				}
		      		}
		      	 }  else  if($key=='Expense') {
		      		foreach ($value as $keys => $values) {
		      				foreach ($values as $key1 => $value1) {
		      					foreach ($value1 as $key2 => $value2) {
		      						$keys = str_replace("  ", "", $keys);
		      						$key1 = str_replace("  ", "", $key1);
		      						$keys = str_replace(" ", "", $keys);
		      						$key1 = str_replace(" ", "", $key1);
		      						$expense[strtolower($keys)][strtolower($key1)][$key2] = strtolower($value2);
		      					}
		      				}
		      		}
		      	 }  else  if($key=='Equity') {
		      		foreach ($value as $keys => $values) {
		      				foreach ($values as $key1 => $value1) {
		      					foreach ($value1 as $key2 => $value2) {
		      						$keys = str_replace("  ", "", $keys);
		      						$key1 = str_replace("  ", "", $key1);
		      						$keys = str_replace(" ", "", $keys);
		      						$key1 = str_replace(" ", "", $key1);
		      						$equity[strtolower($keys)][strtolower($key1)][$key2] = strtolower($value2);
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

		      	/*echo '<pre>'; print_r($asset); echo '</pre>';
		      	echo '<pre>'; print_r($liability); echo '</pre>';
		      	echo '<pre>'; print_r($income); echo '</pre>';
		      	echo '<pre>'; print_r($expense); echo '</pre>';
		      	echo '<pre>'; print_r($equity['paidsharecapital']); echo '</pre>';*/
		      	/*$ld = 'paidsharecapital';
		      	if(array_key_exists($ld, $equity)) {
		      		echo "ok";
		      	} else {
		      		echo "not ok";
		      	}*/

		      	$getAccount	=  $this->settings->getAccounts();
		      	$getAccountArray  =  $this->accountData->getData(array('currencies'));
				$currencies =  $getAccountArray['currencies'];
				foreach ($getAccount as $key => $accounts) {
					$account[] = array("name" => $accounts['account_name'],"level1" => $accounts['level1'],"level2" => $accounts['level2']);
				}

		      	if($this->_request->isPost()) {
					$postArray  =   $this->getRequest()->getPost();
					$total_count = 0;
					$total_error = 0;
					$adapter       = new Zend_File_Transfer_Adapter_Http();
					$fileInfo 	   = $adapter->getFileInfo('file'); 
					if(isset($fileInfo['file']['name']) && ($fileInfo['file']['name'] != '')) {
						$adapter->addValidator('Count', false, array('min' =>1, 'max' => 2))
						        ->addValidator('Size',false,array('max'=>2024000),'file')
								->addValidator('Extension',false,'xls,xlsx','file');
						$adapter->setDestination("..".$this->view->filepath,'file');
						$fileInfo 	         	  =   $adapter->getFileInfo('file');
						$fileArray		  		  =   explode('.',$fileInfo['file']['name']);
						$postArray['extension']   =   $fileArray['1'];
						$renameFile 		  	  =  "ExcelImportCOA_".rand(10,10000).".".$fileArray['1'];
						$postArray['import']      =   $renameFile;
						$adapter->addFilter('Rename',"..".$this->view->filepath.$renameFile);
							if ($adapter->isValid('file') && $adapter->receive('file')) {
								$postArray['import'] =   $renameFile;
							} else {
								$postArray['import'] =   '';
							}
					} else {
						$postArray['import'] =   '';
					}
			      	$inputFileName = "../".$this->view->filepath.$postArray['import'];
			      //	echo $fileInfo['file']['name']; die();

					$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);

					$this->sheetData = $objPHPExcel->getSheet(0)->toArray(null,true,true,true);
					$this->view->uploaded = 1;
					foreach ($this->sheetData as $key => $data) {
						if($key!=1) {
							$accName = trim($data['A']);
							$level1 = strtolower(str_replace(" ", "",$data['B']));
							$level2 = strtolower(str_replace(" ", "",$data['C']));
							$level3 = strtolower(str_replace(" ", "",$data['D']));
							//$debit  = $data['E'];
							//$credit = $data['F'];
							$currency = strtoupper($data['E']);
						if($accName!='' && $level1!='' && $level2!='' && $level3!='') {
							if($level1=='assets') {
								if(array_key_exists($level2, $asset)) {
									$lev = 1;
									foreach ($asset as $key1 => $value1) {
										if($key1==$level2) {
											$l1 = $lev;
										}
										$lev++;
									}
									if(array_key_exists($level3, $asset[$level2])) {
										$lev = 1;
										foreach ($asset[$level2] as $key2 => $value2) {
											if($key2==$level3) {
												$l2 = $lev;
											}
											$lev++;
										}
										if(array_key_exists($currency, $currencies)) {
											//if(in_array($accName, $asset[$level2][$level3])) {
												$exists = 0;

												foreach ($account as $acc) {
													if($acc['level1']==$l1 && $acc['level2']==$l2 && $acc['name']==$accName) {
														$exists++;
													}												
												}
												if($exists==0) {
													$key = array_search($accName, $asset[$level2][$level3]);
													$post['company_id'] = $cid;
													$post['account_type'] = 1;
													$post['account_id'] = $key;
													$post['account_name'] = $data['A'];
													$post['level1'] = $l1;
													$post['level2'] = $l2;
													$post['currency'] = $currency;
													$post['edit_status'] = 1;
													$post['pay_status'] = 2;
													$checkAccount	= $this->settings->checkAccountName($post);
													if(!$checkAccount) {
														$insertAccount  = $this->settings->insertAccount($post);
												 		if($insertAccount) {
												 			$auditLog	= $this->settings->insertAuditLog(1,8,$post['account_name'],$insertAccount);
												 			$total_count++;
												 		} else {
												 			$error_status = 'Account Name Already Exists';
														 	$error[$key]['name']   = $data['A'];
														 	$error[$key]['status'] = $error_status;
														 	$total_error++;
												 		}
											 		} else {
											 			$error_status = 'Account Name Already Exists';
														$error[$key]['name']   = $data['A'];
														$error[$key]['status'] = $error_status;
														$total_error++;
											 		}
												} else {
													 $error_status = 'Account Name Already Exists';
													$error[$key]['name']   = $data['A'];
													$error[$key]['status'] = $error_status;
													$total_error++;
												}
											/*} else {
												$error_status = 'Invalid Account Name';
												$error[$key]['name']   = $data['A'];
												$error[$key]['status'] = $error_status;
											    $total_error++;
											}*/
										} else {
											 $error_status = 'Currency Not Matched';
											$error[$key]['name']   = $data['A'];
											$error[$key]['status'] = $error_status;
											$total_error++;
										}
									} else {
										 $error_status = 'Level 3 Not Matched';
										$error[$key]['name']   = $data['A'];
										$error[$key]['status'] = $error_status;
										$total_error++;
									}
								} else {
									 $error_status = 'Level 2 Not Matched';
									$error[$key]['name']   = $data['A'];
									$error[$key]['status'] = $error_status;
									$total_error++;
								}
							} else if($level1=='liability' || $level1=='liabilities' || $level1=='liability/creditcard' || $level1=='liabilities/creditcard') {
								if(array_key_exists($level2, $liability)) {
									$lev = 1;
									foreach ($liability as $key1 => $value1) {
										if($key1==$level2) {
											$l1 = $lev;
										}
										$lev++;
									}
									if(array_key_exists($level3, $liability[$level2])) {
										$lev = 1;
										foreach ($liability[$level2] as $key2 => $value2) {
											if($key2==$level3) {
												$l2 = $lev;
											}
											$lev++;
										}
										if(array_key_exists($currency, $currencies)) {
												$exists = 0;
												foreach ($account as $acc) {
													if($acc['level1']==$l1 && $acc['level2']==$l2 && $acc['name']==$accName) {
														$exists++;
													}												
												}
												if($exists==0) {
													$key = array_search($accName, $liability[$level2][$level3]);
													$post['company_id'] = $cid;
													$post['account_type'] = 2;
													$post['account_id'] = $key;
													$post['account_name'] = $data['A'];
													$post['level1'] = $l1;
													$post['level2'] = $l2;
													$post['currency'] = $currency;
													$post['edit_status'] = 1;
													$post['pay_status'] = 2;
													$checkAccount	= $this->settings->checkAccountName($post);
													if(!$checkAccount) {
														$insertAccount  = $this->settings->insertAccount($post);
												 		if($insertAccount) {
												 			$auditLog	= $this->settings->insertAuditLog(1,8,$post['account_name'],$insertAccount);
												 			$total_count++;
												 		} else {
												 			 $error_status = 'Account Name Already Exists';
														 	$error[$key]['name']   = $data['A'];
														 	$error[$key]['status'] = $error_status;
														 	$total_error++;
												 		}
												 	} else {
											 			 $error_status = 'Account Name Already Exists';
														$error[$key]['name']   = $data['A'];
														$error[$key]['status'] = $error_status;
														$total_error++;
											 		}
												} else {
													 $error_status = 'Account Name Already Exists';
													$error[$key]['name']   = $data['A'];
													$error[$key]['status'] = $error_status;
													$total_error++;
												}
											
										} else {
											 $error_status = 'Currency Not Matched';
											$error[$key]['name']   = $data['A'];
											$error[$key]['status'] = $error_status;
											$total_error++;
										}
									} else {
										 $error_status = 'Level 3 Not Matched';
										$error[$key]['name']   = $data['A'];
										$error[$key]['status'] = $error_status;
										$total_error++;
									}
								} else {
									 $error_status = 'Level 2 Not Matched';
									$error[$key]['name']   = $data['A'];
									$error[$key]['status'] = $error_status;
									$total_error++;
								}
							} else if($level1=='income') {
								if(array_key_exists($level2, $income)) {
									$lev = 1;
									foreach ($income as $key1 => $value1) {
										if($key1==$level2) {
											$l1 = $lev;
										}
										$lev++;
									}
									if(array_key_exists($level3, $income[$level2])) {
										$lev = 1;
										foreach ($income[$level2] as $key2 => $value2) {
											if($key2==$level3) {
												$l2 = $lev;
											}
											$lev++;
										}
										if(array_key_exists($currency, $currencies)) {
												$exists = 0;
												foreach ($account as $acc) {
													if($acc['level1']==$l1 && $acc['level2']==$l2 && $acc['name']==$accName) {
														$exists++;
													}												
												}
												if($exists==0) {
													$key = array_search($accName, $income[$level2][$level3]);
													$post['company_id'] = $cid;
													$post['account_type'] = 3;
													$post['account_id'] = $key;
													$post['account_name'] = $data['A'];
													$post['level1'] = $l1;
													$post['level2'] = $l2;
													$post['currency'] = $currency;
													$post['edit_status'] = 1;
													$post['pay_status'] = 2;
													$checkAccount	= $this->settings->checkAccountName($post);
													if(!$checkAccount) {
														$insertAccount  = $this->settings->insertAccount($post);
												 		if($insertAccount) {
												 			$auditLog	= $this->settings->insertAuditLog(1,8,$post['account_name'],$insertAccount);
												 			$total_count++;
												 		} else {
												 			 $error_status = 'Account Name Already Exists';
														 	$error[$key]['name']   = $data['A'];
														 	$error[$key]['status'] = $error_status;
														 	$total_error++;
												 		}
												 	} else {
												 		 $error_status = 'Account Name Already Exists';
														$error[$key]['name']   = $data['A'];
														$error[$key]['status'] = $error_status;
														$total_error++;
												 	}
												} else {
													 $error_status = 'Account Name Already Exists';
													$error[$key]['name']   = $data['A'];
													$error[$key]['status'] = $error_status;
													$total_error++;
												}
											
										} else {
											 $error_status = 'Currency Not Matched';
											$error[$key]['name']   = $data['A'];
											$error[$key]['status'] = $error_status;
											$total_error++;
										}
									} else {
										 $error_status = 'Level 3 Not Matched';
										$error[$key]['name']   = $data['A'];
										$error[$key]['status'] = $error_status;
										$total_error++;
									}
								} else {
									 $error_status = 'Level 2 Not Matched';
									$error[$key]['name']   = $data['A'];
									$error[$key]['status'] = $error_status;
									$total_error++;
								}
							} else if($level1=='expense') {
								if(array_key_exists($level2, $expense)) {
									$lev = 1;
									foreach ($expense as $key1 => $value1) {
										if($key1==$level2) {
											$l1 = $lev;
										}
										$lev++;
									}
									if(array_key_exists($level3, $expense[$level2])) {
										$lev = 1;
										foreach ($expense[$level2] as $key2 => $value2) {
											if($key2==$level3) {
												$l2 = $lev;
											}
											$lev++;
										}
										if(array_key_exists($currency, $currencies)) {
												$exists = 0;
												foreach ($account as $acc) {
													if($acc['level1']==$l1 && $acc['level2']==$l2 && $acc['name']==$accName) {
														$exists++;
													}												
												}
												if($exists==0) {
													$key = array_search($accName, $expense[$level2][$level3]);
													$post['company_id'] = $cid;
													$post['account_type'] = 4;
													$post['account_id'] = $key;
													$post['account_name'] = $data['A'];
													$post['level1'] = $l1;
													$post['level2'] = $l2;
													$post['currency'] = $currency;
													$post['edit_status'] = 1;
													$post['pay_status'] = 2;
													$checkAccount	= $this->settings->checkAccountName($post);
													if(!$checkAccount) {

														$insertAccount  = $this->settings->insertAccount($post);
												 		if($insertAccount) {
												 			$auditLog	= $this->settings->insertAuditLog(1,8,$post['account_name'],$insertAccount);
												 			$total_count++;
												 		} else {
												 			 $error_status = 'Account Name Already Exists';
														 	$error[$key]['name']   = $data['A'];
														 	$error[$key]['status'] = $error_status;
														 	$total_error++;
												 		}

												 	} else {
											 			 $error_status = 'Account Name Already Exists';
														$error[$key]['name']   = $data['A'];
														$error[$key]['status'] = $error_status;
														$total_error++;
											 		}
												} else {
													 $error_status = 'Account Name Already Exists';
													$error[$key]['name']   = $data['A'];
													$error[$key]['status'] = $error_status;
													$total_error++;
												}
											
										} else {
											 $error_status = 'Currency Not Matched';
											$error[$key]['name']   = $data['A'];
											$error[$key]['status'] = $error_status;
											$total_error++;
										}
									} else {
										 $error_status = 'Level 3 Not Matched';
										$error[$key]['name']   = $data['A'];
										$error[$key]['status'] = $error_status;
										$total_error++;
									}
								} else {
									 $error_status = 'Level 2 Not Matched';
									$error[$key]['name']   = $data['A'];
									$error[$key]['status'] = $error_status;
									$total_error++;
								}
							} else if($level1=='equity') {
								if(array_key_exists($level2, $equity)) {
									$lev = 1;
									foreach ($equity as $key1 => $value1) {
										if($key1==$level2) {
											$l1 = $lev;
										}
										$lev++;
									}
									if(array_key_exists($level3, $equity[$level2])) {
										$lev = 1;
										foreach ($equity[$level2] as $key2 => $value2) {
											if($key2==$level3) {
												$l2 = $lev;
											}
											$lev++;
										}
										if(array_key_exists($currency, $currencies)) {
											
												$exists = 0;
												foreach ($account as $acc) {
													if($acc['level1']==$l1 && $acc['level2']==$l2 && $acc['name']==$accName) {
														$exists++;
													}												
												}
												if($exists==0) {
													$key = array_search($accName, $equity[$level2][$level3]);
													$post['company_id'] = $cid;
													$post['account_type'] = 5;
													$post['account_id'] = $key;
													$post['account_name'] = $data['A'];
													$post['level1'] = $l1;
													$post['level2'] = $l2;
													$post['currency'] = $currency;
													$post['edit_status'] = 1;
													$post['pay_status'] = 2;
													$checkAccount	= $this->settings->checkAccountName($post);
													if(!$checkAccount) {

														$insertAccount  = $this->settings->insertAccount($post);
												 		if($insertAccount) {
												 			$auditLog	= $this->settings->insertAuditLog(1,8,$post['account_name'],$insertAccount);
												 			$total_count++;
												 		} else {
												 			 $error_status = 'Account Name Already Exists';
														 	$error[$key]['name']   = $data['A'];
														 	$error[$key]['status'] = $error_status;
														 	$total_error++;
												 		}

												 	} else {
											 			 $error_status = 'Account Name Already Exists';
														$error[$key]['name']   = $data['A'];
														$error[$key]['status'] = $error_status;
														$total_error++;
											 		}
												
												} else {
													 $error_status = 'Account Name Already Exists';
													$error[$key]['name']   = $data['A'];
													$error[$key]['status'] = $error_status;
													$total_error++;
												}
											
										} else {
											 $error_status = 'Currency Not Matched';
											$error[$key]['name']   = $data['A'];
											$error[$key]['status'] = $error_status;
											$total_error++;
										}
									
								} else {
									 $error_status = 'Level 3 Not Matched';
									$error[$key]['name']   = $data['A'];
									$error[$key]['status'] = $error_status;
									$total_error++;
								}
							} else {
								 $error_status = 'Level 2 Not Matched';
								$error[$key]['name']   = $data['A'];
								$error[$key]['status'] = $error_status;
								$total_error++;
							}
						 } else {
									 $error_status = 'Level 1 Not Matched';
									$error[$key]['name']   = $data['A'];
									$error[$key]['status'] = $error_status;
									$total_error++;
								}
						}
					}

					}

						//echo $total_error;
						if($total_count!=0) {
							//$auditLog	= $this->settings->insertAuditLog(10,8,$postArray['import'],$total_count);
							$sessSuccess = new Zend_Session_Namespace('import_coa');
				    		$sessSuccess->status = $total_count;
				    		if(!empty($total_error)) {
				    			$sessError = new Zend_Session_Namespace('import_coa_error');
				    			$sessError->error  = $total_error;
				    		    $sessError->status = $total_error;
				    		}
				    		$this->_redirect('import/coa/');	
						} else if($total_count==0) {
							if(!empty($total_error)) {
				    			$sessError = new Zend_Session_Namespace('import_coa_error');
				    			$sessError->error  = $total_error;
				    		    $sessError->status = $total_error;
				    		}
				    		$this->_redirect('import/coa/');	
						}
					//echo '<pre>'; print_r($this->view->sheetData); echo '</pre>';
				

				/*echo '<pre>'; print_r($this->view->asset); echo '</pre>';
				echo '<pre>'; print_r($account); echo '</pre>';
				echo '<pre>'; print_r($this->view->liability); echo '</pre>';
				echo '<pre>'; print_r($this->view->income); echo '</pre>';
				echo '<pre>'; print_r($this->view->expense); echo '</pre>';
				echo '<pre>'; print_r($this->view->equity); echo '</pre>';*/


	      }
	      }
    }

    public function productsAction() {
    	  if(!Zend_Session::namespaceIsset('sess_login')) {
	            $this->_redirect('index');
	      } else {
	      	$logSession = new Zend_Session_Namespace('sess_login');
	      	$error = array();
	      	$incomeAccount = array();
	      	if(isset($logSession->proxy_cid) && !empty($logSession->proxy_cid)) {
		        $cid = $logSession->proxy_cid;
			    $this->json    =  "..".$this->uploadPath.$logSession->proxy_cid."/accounts.json";
		    } else {
				$cid = $logSession->cid;
			    $this->json    =  "..".$this->uploadPath.$logSession->cid."/accounts.json";
			}
			if(Zend_Session::namespaceIsset('import_products')) {
				$sessSuccess = new Zend_Session_Namespace('import_products');
				$this->view->success = $sessSuccess->status.' Products imported successfully';
				Zend_Session::namespaceUnset('import_products');
			}
			if(Zend_Session::namespaceIsset('import_products_error')) {
				$sessError = new Zend_Session_Namespace('import_products_error');
				$this->view->error = $sessError->status. ' rows cannot be inserted due to mismatch or duplicate or invalid entry';
				Zend_Session::namespaceUnset('import_products_error');
			}
				$this->view->viewpath    =  "../".$this->uploadPath;
			    $this->view->filepath    =  $this->uploadPath.$cid."/imports/";
			    $getAccountArray         =  $this->accountData->getData(array('currencies'));
			    $incomeAccounts           =  $this->settings->getIncomeAccounts();
			    foreach ($incomeAccounts as $key => $incomes) {
			    	$incomeAccount[$incomes['id']] = strtolower(str_replace(" ", "", $incomes['account_name']));
			    }
			    $currencies   =  $getAccountArray['currencies'];
			    //print_r($currencies);
		      	if($this->_request->isPost()) {
						$postArray  =   $this->getRequest()->getPost();
						$total_count = 0;
						$total_error = 0;
						$adapter       = new Zend_File_Transfer_Adapter_Http();
						$fileInfo 	   = $adapter->getFileInfo('file'); 
						if(isset($fileInfo['file']['name']) && ($fileInfo['file']['name'] != '')) {
						$adapter->addValidator('Count', false, array('min' =>1, 'max' => 2))
						        ->addValidator('Size',false,array('max'=>2024000),'file')
								->addValidator('Extension',false,'xls,xlsx','file');
						$adapter->setDestination("..".$this->view->filepath,'file');
						$fileInfo 	         	  =   $adapter->getFileInfo('file');
						$fileArray		  		  =   explode('.',$fileInfo['file']['name']);
						$postArray['extension']   =   $fileArray['1'];
						$renameFile 		  	  =  "ExcelImportProducts_".rand(10,10000).".".$fileArray['1'];
						$postArray['import']      =   $renameFile;
						$adapter->addFilter('Rename',"..".$this->view->filepath.$renameFile);
							if ($adapter->isValid('file') && $adapter->receive('file')) {
								$postArray['import'] =   $renameFile;
							} else {
								$postArray['import'] =   '';
							}
					} else {
						$postArray['import'] =   '';
					}
				      	$inputFileName = "../".$this->view->filepath.$postArray['import'];

						$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);

						$this->sheetData = $objPHPExcel->getSheet(0)->toArray(null,true,true,true);
						foreach ($this->sheetData as $key => $data) {
							if($key!=1) {
								$post['product_name']  = trim($data['A']);
								$post['product_id']   = trim($data['B']);
								$post['description']   = trim($data['C']);
								$post['price']  = str_replace(",","",$data['D']);
								$post['currency'] = strtoupper($data['E']);
								$post['income'] = trim(strtolower(str_replace(" ", "", $data['F'])));
								if(isset($post['product_name']) && !empty($post['product_name']) && isset($post['product_id']) && !empty($post['product_id'])) {
									 if(!in_array($post['income'], $incomeAccount)) {
									 	$error_status = 'Income Account Not Exists';
									 	$error[$key]['name']   = $post['product_name'];
									 	$error[$key]['status'] = $error_status;
									 	$total_error++;
									 } else {
									 	if(array_key_exists($post['currency'], $currencies)) {
									 		$post['income_account'] = array_search($post['income'], $incomeAccount);
									 		$checkProduct   = $this->settings->checkProductImport($post['product_name'],$post['product_id']);
									 		if($checkProduct) {
									 			$error_status = 'Product Name or Id Already Exists';
											 	$error[$key]['name']   = $post['product_name'];
											 	$error[$key]['status'] = $error_status;
											 	$total_error++;
									 		} else {
									 		$insertProduct  = $this->settings->insertProduct($post,$cid);
									 		if($insertProduct) {
									 			$auditLog	= $this->settings->insertAuditLog(1,10,$post['product_name'],$insertProduct);
									 			$total_count++;
									 		} else {
									 			$error_status = 'Product Already Exists';
											 	$error[$key]['name']   = $post['product_name'];
											 	$error[$key]['status'] = $error_status;
											 	$total_error++;
									 		}
									 	}
									 	} else {
									 		$error_status = 'Currency Name Not Matched With Our Database';
										 	$error[$key]['name']   = $post['product_name'];
										 	$error[$key]['status'] = $error_status;
										 	$total_error++;
									 	}
									 }
								} /*else {
									$error_status = 'Product Name Empty';
									$error[$key]['name']   = $post['product_name'];
									$error[$key]['status'] = $error_status;
									$total_error++;
								}*/
							}
						}

						if($total_count!=0) {
							//$auditLog	= $this->settings->insertAuditLog(10,10,$postArray['import'],$total_count);
							$sessSuccess = new Zend_Session_Namespace('import_products');
				    		$sessSuccess->status = $total_count;
				    		if(sizeof($error)>0) {
				    			$sessError = new Zend_Session_Namespace('import_products_error');
				    			$sessError->error  = $error;
				    		    $sessError->status = $total_error;
				    		}
				    		$this->_redirect('import/products/');	
						} else if($total_count==0) {
							if(sizeof($error)>0) {
				    			$sessError = new Zend_Session_Namespace('import_products_error');
				    			$sessError->error  = $error;
				    		   $sessError->status = $total_error;
				    		}
				    		$this->_redirect('import/products/');	
						}
				}
	      }
    }


        public function incomeAction() {
    	  if(!Zend_Session::namespaceIsset('sess_login')) {
	            $this->_redirect('index');
	      } else {
	      	$logSession = new Zend_Session_Namespace('sess_login');
	      	$error = array();
	      	$incomeAccount = array();
	      	$customers     = array();
	      	$taxes 	       = array();
	      	$approvers 	   = array();
	      	if(isset($logSession->proxy_cid) && !empty($logSession->proxy_cid)) {
		        $cid = $logSession->proxy_cid;
			    $this->json    =  "..".$this->uploadPath.$logSession->proxy_cid."/accounts.json";
		    } else {
				$cid = $logSession->cid;
			    $this->json    =  "..".$this->uploadPath.$logSession->cid."/accounts.json";
			}
			if(isset($logSession->proxy_id) && !empty($logSession->proxy_id)) {
		        $id = $logSession->proxy_id;
		    } else {
				$id = $logSession->id;
			}
			if(Zend_Session::namespaceIsset('import_income')) {
				$sessSuccess = new Zend_Session_Namespace('import_income');
				$this->view->success = $sessSuccess->status.' Income Transactions imported successfully';
				Zend_Session::namespaceUnset('import_income');
			}
			if(Zend_Session::namespaceIsset('import_income_error')) {
				$sessError = new Zend_Session_Namespace('import_income_error');
				$this->view->error = $sessError->status. ' rows cannot be inserted due to mismatch or duplicate or invalid entry';
				Zend_Session::namespaceUnset('import_income_error');
			}
			$this->view->viewpath    =  "../".$this->uploadPath;
			$this->view->filepath    =  $this->uploadPath.$cid."/imports/";
			$getAccountArray         =  $this->accountData->getData(array('currencies','creditTermArray','supplyTaxCodes'));
			$currencies   =  $getAccountArray['currencies'];
			$creditTerm   =  $getAccountArray['creditTermArray'];
			//$supply         =  $getAccountArray['supplyTaxCodes'];
			$this->iras 	    		=  $this->transaction->getIrasTax(2);
			foreach ($this->iras as $iras) {
				$supply[$iras['id']]['name']	    = $iras['name'];
				$supply[$iras['id']]['percentage']  = $iras['percentage'];
				$supply[$iras['id']]['description'] = $iras['description'];
			}

			$customer 		=  $this->transaction->getCustomerDetails();
			$incomeAccounts	=  $this->transaction->getIncomeAccount();
			$taxCode    	=  $this->transaction->getSalesTax(2);
			$approveUser	=  $this->settings->getApproveUsers($cid);

				foreach ($customer as $custom) {
					$customers[$custom['id']] = strtolower($custom['customer_name']); 
				}

			    foreach ($incomeAccounts as $key => $incomes) {
			    	$incomeAccount[$incomes['id']] = strtolower(str_replace(" ", "", $incomes['account_name']));
			    }

			    foreach ($taxCode as $tax) {
			    	foreach ($supply as $key => $sup) {
                        if($tax['tax_code']==$key) {
                            $taxes[$tax['id']]['name']    = strtolower($sup['name']);
                            $taxes[$tax['id']]['percent'] = $tax['tax_percentage'];
                        }
                    }
			    }

			    foreach ($approveUser as $key => $approve) {
			    	$approvers[$approve['id']] = $approve['username'];
			    }
/*
			    print_r($currencies);
			    print_r($creditTerm);
			    print_r($incomeAccount);
			    print_r($taxes);
			    print_r($approvers);*/
			    



		      	if($this->_request->isPost()) {
						$postArray  =   $this->getRequest()->getPost();
						$total_count = 0;
						$total_error = 0;
						$adapter       = new Zend_File_Transfer_Adapter_Http();
						$fileInfo 	   = $adapter->getFileInfo('file'); 
						if(isset($fileInfo['file']['name']) && ($fileInfo['file']['name'] != '')) {
						$adapter->addValidator('Count', false, array('min' =>1, 'max' => 2))
						        ->addValidator('Size',false,array('max'=>2024000),'file')
								->addValidator('Extension',false,'xls,xlsx','file');
						$adapter->setDestination("..".$this->view->filepath,'file');
						$fileInfo 	         	  =   $adapter->getFileInfo('file');
						$fileArray		  		  =   explode('.',$fileInfo['file']['name']);
						$postArray['extension']   =   $fileArray['1'];
						$renameFile 		  	  =  "ExcelImportIncomes_".rand(10,10000).".".$fileArray['1'];
						$postArray['import']      =   $renameFile;
						$adapter->addFilter('Rename',"..".$this->view->filepath.$renameFile);
							if ($adapter->isValid('file') && $adapter->receive('file')) {
								$postArray['import'] =   $renameFile;
							} else {
								$postArray['import'] =   '';
							}
					} else {
						$postArray['import'] =   '';
					}
				      	$inputFileName = "../".$this->view->filepath.$postArray['import'];

						$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);

						$this->sheetData = $objPHPExcel->getSheet(0)->toArray(null,true,true,true);
						//print_r($this->sheetData); die();

						foreach ($this->sheetData as $key => $data) {
							if($key!=1) {

								$post['date']    	  	  = str_replace("/","-",trim($data['A']));
								$post['date'] 		      = date('Y-m-d',strtotime($post['date']));
								$post['receipt']   		  = trim($data['B']);
								$post['customers']     	  = trim(strtolower($data['C']));
								$post['credit_terms']  	  = trim(strtolower($data['D']));
								$post['currency'] 	  	  = trim(strtoupper($data['E']));
								$post['income']       	  = trim(strtolower(str_replace(" ", "", $data['F'])));
								$post['amount']   	  	  = trim($data['G']);
								$post['description']  	  = trim($data['H']);
								$post['taxcode']   	  	  = trim(strtolower($data['I']));
								$post['approval'] 	  	  = trim(strtolower($data['J']));
								

								if(isset($post['date']) && !empty($post['date']) && isset($post['customers']) && !empty($post['customers'])) {

								if(isset($post['customers']) && !empty($post['customers'])) {

									if(in_array($post['customers'], $customers)) {
										$post['customer'] = array_search($post['customers'], $customers);

										if($post['credit_terms']=='cash' || in_array($post['credit_terms'], $creditTerm)) {
											if($post['credit_terms']=='cash') {
												$post['credit_term'] = 1;
											} else {
												$post['credit_term'] = array_search($post['credit_terms'], $creditTerm);
											}

											if(array_key_exists($post['currency'], $currencies)) {
												if(in_array($post['income'], $incomeAccount)) {
													$post['income_type'] = array_search($post['income'], $incomeAccount);
													
													$tax_status = 0;

													if(empty($post['taxcode']) || strtolower($post['taxcode'])=='na') {
														$post['tax_id'] = '';
														$post['tax_percentage'] = '';
														$tax_status = 1;
													} else {

															foreach ($taxes as $key => $tax) {
																if($tax['name']==$post['taxcode']) {
																	$post['tax_id'] = $key;
																	$post['tax_percentage'] = $tax['percent'];
																	$tax_status = 1;
																}
															}

													}

													if($tax_status==1) {

														if(empty($post['approval']) || in_array($post['approval'], $approvers)) {

															if(empty($post['approval'])) {
																$post['approval_for'] = $id;
															} else {
																$post['approval_for'] = array_search($post['approval'], $approvers);
															}

														$checkReceipt = $this->transaction->checkIncomeReceipt($post['receipt']);
														if($checkReceipt) {

															$error_status = 'Receipt No Already Exists';
														 	$error[$key]['name']   = $post['receipt'];
														 	$error[$key]['status'] = $error_status;
														 	$total_error++;

														} else {

															//$post['date'] = PHPExcel_Style_NumberFormat::toFormattedString($post['date'], 'Y-m-d');

														//	$post['date']   = date("Y-m-d",$post['date']);
															$post['amount'] = str_replace(",","",$post['amount']);

															$post['attached_file'] = '';

															$post['exchange_rate'] = '';

															if($post['currency']!='SGD') {
																$exchange_rate = $this->convertCurrency(1,$post['currency']);
																$post['exchange_rate'] = $exchange_rate;
															}

															if($post['credit_term']==1) {

																$incomeTransaction = $this->transaction->insertIncomeTransaction($post,$cid,3);
																if($incomeTransaction) {
																	$auditId      = $this->transaction->insertIncomeAuditTransaction($post,$incomeTransaction,3);
																	$auditLog	  = $this->settings->insertAuditLog(1,1,'Income',$auditId);
																	$total_count++;
																}

															} else {

																$incomeTransaction = $this->transaction->insertIncomeTransaction($post,$cid,2);
																if($incomeTransaction) {
																	$auditId      = $this->transaction->insertIncomeAuditTransaction($post,$incomeTransaction,2);
																	$auditLog	  = $this->settings->insertAuditLog(1,1,'Income',$auditId);
																	$total_count++;
																}

															}

														}

														}  else {
															$error_status = 'Approver Email ID Not Exists';
														 	$error[$key]['name']   = $post['approval'];
														 	$error[$key]['status'] = $error_status;
														 	$total_error++;
														}

													} else {
														$error_status = 'Tax Code Not Exists';
													 	$error[$key]['name']   = $post['taxcode'];
													 	$error[$key]['status'] = $error_status;
													 	$total_error++;
													}


												} else {
													$error_status = 'Income Account Not Exists';
												 	$error[$key]['name']   = $post['income'];
												 	$error[$key]['status'] = $error_status;
												 	$total_error++;
												}

											} else {
												$error_status = 'Currency Not Exists';
											 	$error[$key]['name']   = $post['currency'];
											 	$error[$key]['status'] = $error_status;
											 	$total_error++;
											}

										} else {
											$error_status = 'Credit Term Not Exists';
										 	$error[$key]['name']   = $post['credit_terms'];
										 	$error[$key]['status'] = $error_status;
										 	$total_error++;
										}

									} else {
										$error_status = 'Customer Not Exists';
									 	$error[$key]['name']   = $post['customers'];
									 	$error[$key]['status'] = $error_status;
									 	$total_error++;
									}

								} else {
									$error_status = 'Customer Name Empty';
									$error[$key]['name']   = $post['customers'];
									$error[$key]['status'] = $error_status;
									$total_error++;
								}
							}
						}

					}


						if($total_count!=0) {
							$sessSuccess = new Zend_Session_Namespace('import_income');
				    		$sessSuccess->status = $total_count;
				    		if(sizeof($error)>0) {
				    			$sessError = new Zend_Session_Namespace('import_income_error');
				    			$sessError->error  = $error;
				    		    $sessError->status = $total_error;
				    		}
				    		$this->_redirect('import/income/');	
						} else if($total_count==0) {
							if(sizeof($error)>0) {
				    			$sessError = new Zend_Session_Namespace('import_income_error');
				    			$sessError->error  = $error;
				    		    $sessError->status = $total_error;
				    		}
				    		$this->_redirect('import/income/');	
						}

				}



		  }

		}




    public function invoiceAction() {
    	  if(!Zend_Session::namespaceIsset('sess_login')) {
	            $this->_redirect('index');
	      } else {
	      	$logSession = new Zend_Session_Namespace('sess_login');
	      	$error = array();
	      	$customers     = array();
	      	$products      = array();
	      	$taxes 	       = array();
	      	$approvers 	   = array();
	      	if(isset($logSession->proxy_cid) && !empty($logSession->proxy_cid)) {
		        $cid = $logSession->proxy_cid;
			    $this->json    =  "..".$this->uploadPath.$logSession->proxy_cid."/accounts.json";
		    } else {
				$cid = $logSession->cid;
			    $this->json    =  "..".$this->uploadPath.$logSession->cid."/accounts.json";
			}
			if(isset($logSession->proxy_id) && !empty($logSession->proxy_id)) {
		        $id = $logSession->proxy_id;
		    } else {
				$id = $logSession->id;
			}
			if(Zend_Session::namespaceIsset('import_invoice')) {
				$sessSuccess = new Zend_Session_Namespace('import_invoice');
				$this->view->success = $sessSuccess->status.' Invoice Transactions imported successfully';
				Zend_Session::namespaceUnset('import_invoice');
			}
			if(Zend_Session::namespaceIsset('import_invoice_error')) {
				$sessError = new Zend_Session_Namespace('import_invoice_error');
				$this->view->error = $sessError->status. ' rows cannot be inserted due to mismatch or duplicate or invalid entry';
				Zend_Session::namespaceUnset('import_invoice_error');
			}
			$this->view->viewpath    =  "../".$this->uploadPath;
			$this->view->filepath    =  $this->uploadPath.$cid."/imports/";
			$getAccountArray         =  $this->accountData->getData(array('currencies','creditTermArray','supplyTaxCodes'));
			$currencies   =  $getAccountArray['currencies'];
			$creditTerm   =  $getAccountArray['creditTermArray'];
			//$supply         =  $getAccountArray['supplyTaxCodes'];
			$this->iras 	    		=  $this->transaction->getIrasTax(2);
			foreach ($this->iras as $iras) {
				$supply[$iras['id']]['name']	    = $iras['name'];
				$supply[$iras['id']]['percentage']  = $iras['percentage'];
				$supply[$iras['id']]['description'] = $iras['description'];
			}

			$customer 		=  $this->transaction->getCustomerDetails();
			$taxCode    	=  $this->transaction->getSalesTax(2);
			$approveUser	=  $this->settings->getApproveUsers($cid);
			$product        =  $this->settings->getProducts();
			$invoiceCustom	=  $this->settings->getInvoiceCustomization();

				foreach ($customer as $custom) {
					$customers[$custom['id']] = strtolower(str_replace(" ", "", $custom['customer_name'])); 
				}

			    foreach ($taxCode as $tax) {
			    	foreach ($supply as $key => $sup) {
                        if($tax['tax_code']==$key) {
                            $taxes[$tax['id']]['name']    = strtolower($sup['name']);
                            $taxes[$tax['id']]['percent'] = $tax['tax_percentage'];
                        }
                    }
			    }

			    foreach ($approveUser as $key => $approve) {
			    	$approvers[$approve['id']] = $approve['username'];
			    }

			    foreach ($product as $prod) {
					$products[$prod['id']]['pid']      = $prod['product_id']; 
					$products[$prod['id']]['name']     = $prod['name']; 
					$products[$prod['id']]['price']    = $prod['price'];
					$products[$prod['id']]['currency'] = $prod['currency'];
				}

/*			    print_r($currencies);
			    print_r($creditTerm);
			    print_r($incomeAccount);
			    print_r($taxes);
			    print_r($approvers);
			   print_r($products);

			   die();*/



		      	if($this->_request->isPost()) {
						$postArray  =   $this->getRequest()->getPost();
						$total_count = 0;
						$total_error = 0;
						$adapter       = new Zend_File_Transfer_Adapter_Http();
						$fileInfo 	   = $adapter->getFileInfo('file'); 
						if(isset($fileInfo['file']['name']) && ($fileInfo['file']['name'] != '')) {
						$adapter->addValidator('Count', false, array('min' =>1, 'max' => 2))
						        ->addValidator('Size',false,array('max'=>2024000),'file')
								->addValidator('Extension',false,'xls,xlsx','file');
						$adapter->setDestination("..".$this->view->filepath,'file');
						$fileInfo 	         	  =   $adapter->getFileInfo('file');
						$fileArray		  		  =   explode('.',$fileInfo['file']['name']);
						$postArray['extension']   =   $fileArray['1'];
						$renameFile 		  	  =  "ExcelImportInvoices_".rand(10,10000).".".$fileArray['1'];
						$postArray['import']      =   $renameFile;
						$adapter->addFilter('Rename',"..".$this->view->filepath.$renameFile);
							if ($adapter->isValid('file') && $adapter->receive('file')) {
								$postArray['import'] =   $renameFile;
							} else {
								$postArray['import'] =   '';
							}
					} else {
						$postArray['import'] =   '';
					}
				      	$inputFileName = "../".$this->view->filepath.$postArray['import'];

						$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);

						$this->sheetData = $objPHPExcel->getSheet(0)->toArray(null,true,true,true);

						foreach ($this->sheetData as $key => $data) {
							if($key!=1) {

								$post['id']     	  	  = trim($data['A']);
								$post['date']    	  	  = str_replace("/","-",trim($data['B']));
								$post['date'] 		      = date('Y-m-d',strtotime($post['date']));
								$post['customers']     	  = trim(strtolower(str_replace(" ", "", $data['C'])));
								$post['currency'] 	  	  = trim(strtoupper($data['D']));
								$post['credit_terms']  	  = trim(strtolower($data['E']));
								$post['due_date']         = str_replace("/","-",trim($data['F']));
								$post['due_date'] 		  = date('Y-m-d',strtotime($post['due_date']));
								$post['prompt']       	  = trim(strtolower($data['G']));
								$post['revenue'] 	  	  = trim(strtolower($data['H']));
								$post['do_so_no']  	  	  = trim($data['I']);
								$post['memo']   	  	  = trim(strtolower($data['J']));
								$post['approval'] 	  	  = trim(strtolower($data['K']));
								

								if(isset($post['date']) && !empty($post['date']) && isset($post['customers']) && !empty($post['customers'])) {

								if(isset($post['customers']) && !empty($post['customers'])) {

									if(in_array($post['customers'], $customers)) {
										$post['customer'] = array_search($post['customers'], $customers);

										if($post['credit_terms']=='cash' || in_array($post['credit_terms'], $creditTerm)) {
											if($post['credit_terms']=='cash') {
												$post['credit_term'] = 1;
											} else {
												$post['credit_term'] = array_search($post['credit_terms'], $creditTerm);
											}

											if(array_key_exists($post['currency'], $currencies)) {

														if($post['prompt']=='yes') {
															$post['payment_discount'] = 1;
														} else {
															$post['payment_discount'] = 2;
														}

														if($post['revenue']=='yes') {
															$post['non_revenue_tax'] = 1;
														} else {
															$post['non_revenue_tax'] = 2;
														}
												
													
														if(empty($post['approval']) || in_array($post['approval'], $approvers)) {

															if(empty($post['approval'])) {
																$post['approval_for'] = $id;
															} else {
																$post['approval_for'] = array_search($post['approval'], $approvers);
															}


															$post['attached_file'] = '';

															$post['exchange_rate'] = '';

															if($post['currency']!='SGD') {
																$exchange_rate = $this->convertCurrency(1,$post['currency']);
																$post['exchange_rate'] = $exchange_rate;
															}

															$sheet1 = $objPHPExcel->getSheet(1)->toArray(null,true,true,true); 
															
															$index  = 1;
															$errors = 0;
															foreach ($sheet1 as $key => $value) {

																if($key!=1) {

																	//print_r($value); die();

																$product_status = 0;
																$tax_status  	= 0;
																
																if($value['A']==$post['id'] && $value['B']!='' && $value['C']!='') {

																	foreach ($products as $key => $prod) {

																		if(strtolower(str_replace(" ","",$prod['pid']))==strtolower(str_replace(" ","",$value['B'])) && $prod['currency']==$post['currency']) {

																			$post['product_id_'.$index] = $prod['pid'];
																			$post['product_description_'.$index] = $key."_".$prod['pid']."_".$prod['price'];
																			$post['quantity_'.$index] = $value['C'];
																			$post['discount_amount_'.$index] = $value['D'];
																			$post['price_'.$index] = $prod['price'];

																			$product_status = 1;

																		} 

																	}



																	if(empty($value['E']) || strtolower($value['E'])=='na') {
																		$post['tax_code_'.$index] = '';
																		$tax_status = 1;
																	} else {

																			foreach ($taxes as $key => $tax) {
																				if($tax['name']==trim(strtolower($value['E']))) {
																					$post['tax_code_'.$index] = $key."_".$tax['percent'];
																					$tax_status = 1;
																				}
																			}

																	}

																	if($product_status==1 && $tax_status==1) {
																		$index++;
																	} else {
																		$errors++;
																	}

																}

																

															}

														}

/*														print_r($post); 
														echo $index;
														echo $errors;*/

															if($index>1 && $errors==0) {
																//echo "string";
																$post['product_counter']  = --$index;
																$post['shipping_address'] = 0;
																$post['invoice_custom'] = $invoiceCustom[0]['invoice_prefix'];

																if($post['credit_term']==1) {

																	$invoiceTransaction = $this->transaction->insertInvoiceTransaction($post,$cid,3);
																	if($invoiceTransaction) {
																		$auditId = $this->transaction->insertInvoiceAuditTransaction($post,$invoiceTransaction,3);
																		$auditLog	  = $this->settings->insertAuditLog(1,3,'Invoice',$auditId);
																		$total_count++;
																	}

																} else {

																	$invoiceTransaction = $this->transaction->insertInvoiceTransaction($post,$cid,2);
																	if($invoiceTransaction) {
																		$auditId = $this->transaction->insertInvoiceAuditTransaction($post,$invoiceTransaction,2);
																		$auditLog	  = $this->settings->insertAuditLog(1,3,'Invoice',$auditId);
																		$total_count++;
																	}

																}

															}  else {

																$error_status = 'Invalid Transaction';
															 	$error[$key]['name']   = $post['approval'];
															 	$error[$key]['status'] = $error_status;
															 	$total_error++;

															}


														}  else {
															$error_status = 'Approver Email ID Not Exists';
														 	$error[$key]['name']   = $post['approval'];
														 	$error[$key]['status'] = $error_status;
														 	$total_error++;
														}



												

											} else {
												$error_status = 'Currency Not Exists';
											 	$error[$key]['name']   = $post['currency'];
											 	$error[$key]['status'] = $error_status;
											 	$total_error++;
											}

										} else {
											$error_status = 'Credit Term Not Exists';
										 	$error[$key]['name']   = $post['credit_terms'];
										 	$error[$key]['status'] = $error_status;
										 	$total_error++;
										}

									} else {
										$error_status = 'Customer Not Exists';
									 	$error[$key]['name']   = $post['customers'];
									 	$error[$key]['status'] = $error_status;
									 	$total_error++;
									}

								} else {
									$error_status = 'Customer Name Empty';
									$error[$key]['name']   = $post['customers'];
									$error[$key]['status'] = $error_status;
									$total_error++;
								}
							}
						}

					}


						if($total_count!=0) {
							$sessSuccess = new Zend_Session_Namespace('import_invoice');
				    		$sessSuccess->status = $total_count;
				    		if(sizeof($error)>0) {
				    			$sessError = new Zend_Session_Namespace('import_invoice_error');
				    			$sessError->error  = $error;
				    		    $sessError->status = $total_error;
				    		}
				    		$this->_redirect('import/invoice/');	
						} else if($total_count==0) {
							if(sizeof($error)>0) {
				    			$sessError = new Zend_Session_Namespace('import_invoice_error');
				    			$sessError->error  = $error;
				    		    $sessError->status = $total_error;
				    		}
				    		$this->_redirect('import/invoice/');	
						}

				}



		  }

		}





		 public function expenseAction() {
    	  if(!Zend_Session::namespaceIsset('sess_login')) {
	            $this->_redirect('index');
	      } else {
	      	$logSession = new Zend_Session_Namespace('sess_login');
	      	$error = array();
	      	$vendors        = array();
	      	$expenseAccount = array();
	      	$taxes 	        = array();
	      	$approvers 	    = array();
	      	if(isset($logSession->proxy_cid) && !empty($logSession->proxy_cid)) {
		        $cid = $logSession->proxy_cid;
			    $this->json    =  "..".$this->uploadPath.$logSession->proxy_cid."/accounts.json";
		    } else {
				$cid = $logSession->cid;
			    $this->json    =  "..".$this->uploadPath.$logSession->cid."/accounts.json";
			}
			if(isset($logSession->proxy_id) && !empty($logSession->proxy_id)) {
		        $id = $logSession->proxy_id;
		    } else {
				$id = $logSession->id;
			}
			if(Zend_Session::namespaceIsset('import_expense')) {
				$sessSuccess = new Zend_Session_Namespace('import_expense');
				$this->view->success = $sessSuccess->status.' Expense Transactions imported successfully';
				Zend_Session::namespaceUnset('import_expense');
			}
			if(Zend_Session::namespaceIsset('import_expense_error')) {
				$sessError = new Zend_Session_Namespace('import_expense_error');
				$this->view->error = $sessError->status. ' rows cannot be inserted due to mismatch or duplicate or invalid entry';
				Zend_Session::namespaceUnset('import_expense_error');
			}
			$this->view->viewpath    =  "../".$this->uploadPath;
			$this->view->filepath    =  $this->uploadPath.$cid."/imports/";
			$getAccountArray         =  $this->accountData->getData(array('currencies','creditTermArray','purchaseTaxCodes'));
			$currencies   =  $getAccountArray['currencies'];
			$creditTerm   =  $getAccountArray['creditTermArray'];
			//$purchase       =  $getAccountArray['purchaseTaxCodes'];
			$this->iras 	    		=  $this->transaction->getIrasTax(1);
			foreach ($this->iras as $iras) {
				$purchase[$iras['id']]['name']	    = $iras['name'];
				$purchase[$iras['id']]['percentage']  = $iras['percentage'];
				$purchase[$iras['id']]['description'] = $iras['description'];
			}

			$vendor 		 =  $this->transaction->getVendorDetails();
			$expenseAccounts =  $this->transaction->getExpenseAccount();
			$taxCode    	 =  $this->transaction->getSalesTax(1);
			$approveUser	 =  $this->settings->getApproveUsers($cid);

				foreach ($vendor as $vend) {
					$vendors[$vend['id']] = strtolower($vend['vendor_name']); 
				}

				foreach ($expenseAccounts as $key => $expenses) {
			    	$expenseAccount[$expenses['id']] = strtolower($expenses['account_name']);
			    }

			    foreach ($taxCode as $tax) {
			    	foreach ($purchase as $key => $purc) {
                        if($tax['tax_code']==$key) {
                            $taxes[$tax['id']]['name']    = strtolower($purc['name']);
                            $taxes[$tax['id']]['percent'] = $tax['tax_percentage'];
                        }
                    }
			    }

			    foreach ($approveUser as $key => $approve) {
			    	$approvers[$approve['id']] = $approve['username'];
			    }

			    /*print_r($currencies);
			    print_r($creditTerm);
			    print_r($expenseAccount);
			    print_r($taxes);
			    print_r($approvers);

			    die();*/



		      	if($this->_request->isPost()) {
						$postArray  =   $this->getRequest()->getPost();
						$total_count = 0;
						$total_error = 0;
						$adapter       = new Zend_File_Transfer_Adapter_Http();
						$fileInfo 	   = $adapter->getFileInfo('file'); 
						if(isset($fileInfo['file']['name']) && ($fileInfo['file']['name'] != '')) {
						$adapter->addValidator('Count', false, array('min' =>1, 'max' => 2))
						        ->addValidator('Size',false,array('max'=>2024000),'file')
								->addValidator('Extension',false,'xls,xlsx','file');
						$adapter->setDestination("..".$this->view->filepath,'file');
						$fileInfo 	         	  =   $adapter->getFileInfo('file');
						$fileArray		  		  =   explode('.',$fileInfo['file']['name']);
						$postArray['extension']   =   $fileArray['1'];
						$renameFile 		  	  =  "ExcelImportExpenses_".rand(10,10000).".".$fileArray['1'];
						$postArray['import']      =   $renameFile;
						$adapter->addFilter('Rename',"..".$this->view->filepath.$renameFile);
							if ($adapter->isValid('file') && $adapter->receive('file')) {
								$postArray['import'] =   $renameFile;
							} else {
								$postArray['import'] =   '';
							}
					} else {
						$postArray['import'] =   '';
					}
				      	$inputFileName = "../".$this->view->filepath.$postArray['import'];

						$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);

						$this->sheetData = $objPHPExcel->getSheet(0)->toArray(null,true,true,true);

						foreach ($this->sheetData as $key => $data) {
							if($key!=1) {

								$post['id']     	  	  = trim($data['A']);
								$post['date']    	  	  = str_replace("/","-",trim($data['B']));
								$post['date'] 		      = date('Y-m-d',strtotime($post['date']));
								$post['receipt']     	  = trim($data['C']);
								$post['vendors']     	  = trim(strtolower($data['D']));
								$post['currency'] 	  	  = trim(strtoupper($data['E']));
								$post['credit_terms']  	  = trim(strtolower($data['F']));
								$post['due_date']         = str_replace("/","-",trim($data['G']));
								$post['due_date'] 		  = date('Y-m-d',strtotime($post['due_date']));
								$post['prompt']       	  = trim(strtolower($data['H']));
								$post['permit_no'] 	  	  = trim(strtolower($data['I']));
								$post['do_so_no']  	  	  = trim($data['J']);
								$post['approval'] 	  	  = trim(strtolower($data['K']));
								

								if(isset($post['date']) && !empty($post['date']) && isset($post['vendors']) && !empty($post['vendors'])) {

								if(isset($post['vendors']) && !empty($post['vendors'])) {

									if(in_array($post['vendors'], $vendors)) {
										$post['vendor'] = array_search($post['vendors'], $vendors);

										if($post['credit_terms']=='cash' || in_array($post['credit_terms'], $creditTerm)) {
											if($post['credit_terms']=='cash') {
												$post['credit_term'] = 1;
											} else {
												$post['credit_term'] = array_search($post['credit_terms'], $creditTerm);
											}

											if(array_key_exists($post['currency'], $currencies)) {

														if($post['prompt']=='yes') {
															$post['payment_discount'] = 1;
														} else {
															$post['payment_discount'] = 2;
														}

																							
													
														if(empty($post['approval']) || in_array($post['approval'], $approvers)) {

															if(empty($post['approval'])) {
																$post['approval_for'] = $id;
															} else {
																$post['approval_for'] = array_search($post['approval'], $approvers);
															}


															$post['attached_file'] = '';

															$post['exchange_rate'] = '';

															if($post['currency']!='SGD') {
																$exchange_rate = $this->convertCurrency(1,$post['currency']);
																$post['exchange_rate'] = $exchange_rate;
															}

															$sheet1 = $objPHPExcel->getSheet(1)->toArray(null,true,true,true); 
															
															$index  = 1;
															$errors = 0;
															foreach ($sheet1 as $key => $value) {

																if($key!=1) {

																	//print_r($value); die();

																$product_status = 0;
																$tax_status  	= 0;
																
																if($value['A']==$post['id'] && $value['B']!='' && $value['D']!='' && $value['E']!='') {

																	
																if(in_array(trim(strtolower($value['B'])), $expenseAccount)) {

																	$post['expense_type_'.$index] = array_search(trim(strtolower($value['B'])), $expenseAccount);
																	$post['product_id_'.$index] = trim($value['C']);
																	$post['product_description_'.$index] = trim($value['D']);
																	$post['quantity_'.$index] = trim($value['E']);
																	$post['price_'.$index] = trim($value['F']);

																	$product_status = 1;

																  }



																		if(empty($value['G']) || strtolower($value['G'])=='na') {
																				$post['tax_code_'.$index] = '';
																				$tax_status = 1;
																			} else {

																					foreach ($taxes as $key => $tax) {
																						if($tax['name']==trim(strtolower($value['G']))) {
																							$post['tax_code_'.$index] = $key."_".$tax['percent'];
																							$tax_status = 1;
																						}
																					}

																			}

																	if($product_status==1 && $tax_status==1) {
																		$index++;
																	} else {
																		$errors++;
																	}

																}

																


															}

														}

														/*print_r($post); 
														echo $index;
														echo $errors;*/

														if($index>1 && $errors==0) {
															//echo "string";

																$checkReceipt = $this->transaction->checkExpenseReceipt($post['receipt']);
																if($checkReceipt) {

																	$error_status = 'Receipt No Already Exists';
																 	$error[$key]['name']   = $post['receipt'];
																 	$error[$key]['status'] = $error_status;
																 	$total_error++;

																} else {

																		$post['expense_counter']  = --$index;

																		if($post['credit_term']==1) {

																			$expenseTransaction = $this->transaction->insertExpenseTransaction($post,$cid,3);
																			if($expenseTransaction) {
																				$auditId = $this->transaction->insertExpenseAuditTransaction($post,$expenseTransaction,3);
																				$auditLog	  = $this->settings->insertAuditLog(1,2,'Expense',$auditId);
																				$total_count++;
																			}

																		} else {

																			$expenseTransaction = $this->transaction->insertExpenseTransaction($post,$cid,2);
																			if($expenseTransaction) {
																				$auditId = $this->transaction->insertExpenseAuditTransaction($post,$expenseTransaction,2);
																				$auditLog	  = $this->settings->insertAuditLog(1,2,'Expense',$auditId);
																				$total_count++;
																			}

																		}
																}

															}  else {

																$error_status = 'Approver Email ID Not Exists';
															 	$error[$key]['name']   = $post['approval'];
															 	$error[$key]['status'] = $error_status;
															 	$total_error++;

															}


														}  else {
															$error_status = 'Approver Email ID Not Exists';
														 	$error[$key]['name']   = $post['approval'];
														 	$error[$key]['status'] = $error_status;
														 	$total_error++;
														}



												

											} else {
												$error_status = 'Currency Not Exists';
											 	$error[$key]['name']   = $post['currency'];
											 	$error[$key]['status'] = $error_status;
											 	$total_error++;
											}

										} else {
											$error_status = 'Credit Term Not Exists';
										 	$error[$key]['name']   = $post['credit_terms'];
										 	$error[$key]['status'] = $error_status;
										 	$total_error++;
										}

									} else {
										$error_status = 'Customer Not Exists';
									 	$error[$key]['name']   = $post['customers'];
									 	$error[$key]['status'] = $error_status;
									 	$total_error++;
									}

								} else {
									$error_status = 'Customer Name Empty';
									$error[$key]['name']   = $post['customers'];
									$error[$key]['status'] = $error_status;
									$total_error++;
								}
							}
						}

					}


						if($total_count!=0) {
							$sessSuccess = new Zend_Session_Namespace('import_expense');
				    		$sessSuccess->status = $total_count;
				    		if(sizeof($error)>0) {
				    			$sessError = new Zend_Session_Namespace('import_expense_error');
				    			$sessError->error  = $error;
				    		    $sessError->status = $total_error;
				    		}
				    		$this->_redirect('import/expense/');	
						} else if($total_count==0) {
							if(sizeof($error)>0) {
				    			$sessError = new Zend_Session_Namespace('import_expense_error');
				    			$sessError->error  = $error;
				    		    $sessError->status = $total_error;
				    		}
				    		$this->_redirect('import/expense/');	
						}

				}



		  }

		}







    public function indexAction() {
	      if(!Zend_Session::namespaceIsset('sess_login')) {
	            $this->_redirect('index');
	      } else {
	      	$logSession = new Zend_Session_Namespace('sess_login');
	      }
    }



  	function convertCurrency($amount, $from){
		$to   = 'SGD';
	    $url  = "https://www.google.com/finance/converter?a=$amount&from=$from&to=$to";
	    $data = file_get_contents($url);
	    preg_match("/<span class=bld>(.*)<\/span>/",$data, $converted);
	    $converted = preg_replace("/[^0-9.]/", "", $converted[1]);
	    return round($converted, 5);
	}




}

?>