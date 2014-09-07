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
				$this->view->viewpath    =  "../".$this->uploadPath;
			    $this->view->filepath    =  $this->uploadPath.$cid."/imports/";
			    $getAccountArray         =  $this->accountData->getData(array('country'));
			    $countries   =  $getAccountArray['country'];
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

						$this->sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
						foreach ($this->sheetData as $key => $data) {
							if($key!=1) {
								$post['customer_name']  = trim($data['A']);
								$post['customer_reg_no']   = $data['B'];
								$post['company_gst_no']   = $data['C'];
								$post['gst_status']  = $data['D'];
								$post['email'] = $data['E'];
								$post['office_number'] = $data['F'];
								$post['fax_number']   = $data['G'];
								$post['website']   = $data['H'];
								$post['address1'] = $data['I'];
								$post['address2'] = $data['J'];
								$post['city']  = $data['K'];
								$post['state'] = $data['L'];
								$post['postcode']   = $data['M'];
								$post['count'] = $data['N'];
								if(isset($post['customer_name']) && !empty($post['customer_name'])) {
									 $checkCustomer = $this->business->checkCustomer($post['customer_name']); 
									 if($checkCustomer) {
									 	$error_status = 'Customer Already Exists';
									 	$error[$key]['name']   = $post['customer_name'];
									 	$error[$key]['status'] = $error_status;
									 	$total_error++;
									 } else {
									 	if(in_array($post['count'], $countries)) {
									 		$post['country'] = array_search($post['count'], $countries);
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
									 		$error_status = 'Country Name Not Matched With Our Database';
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
				    		    $sessError->status = 2;
				    		}
				    		$this->_redirect('import/customers/');	
						} else if($total_count==0) {
							if(sizeof($error)>0) {
				    			$sessError = new Zend_Session_Namespace('import_customer_error');
				    			$sessError->error  = $error;
				    		    $sessError->status = 2;
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
				$this->view->viewpath    =  "../".$this->uploadPath;
			    $this->view->filepath    =  $this->uploadPath.$cid."/imports/";
			    $getAccountArray         =  $this->accountData->getData(array('country'));
			    $countries   =  $getAccountArray['country'];
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

						$this->sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
						foreach ($this->sheetData as $key => $data) {
							if($key!=1) {
								$post['vendor_name']  = trim($data['A']);
								$post['company_registration_no']   = $data['B'];
								$post['company_gst_no']   = $data['C'];
								$post['gst_status']  = $data['D'];
								$post['email'] = $data['E'];
								$post['office_number'] = $data['F'];
								$post['fax_number']   = $data['G'];
								$post['website']   = $data['H'];
								$post['address1'] = $data['I'];
								$post['address2'] = $data['J'];
								$post['city']  = $data['K'];
								$post['state'] = $data['L'];
								$post['postcode']   = $data['M'];
								$post['count'] = $data['N'];
								if(isset($post['vendor_name']) && !empty($post['vendor_name'])) {
									 $checkVendor = $this->business->checkVendor($post['vendor_name']); 
									 if($checkVendor) {
									 	$error_status = 'Vendor Already Exists';
									 	$error[$key]['name']   = $post['vendor_name'];
									 	$error[$key]['status'] = $error_status;
									 	$total_error++;
									 } else {
									 	if(in_array($post['count'], $countries)) {
									 		$post['country'] = array_search($post['count'], $countries);
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
									 		$error_status = 'Country Name Not Matched With Our Database';
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
				    		    $sessError->status = 2;
				    		}
				    		$this->_redirect('import/vendors/');	
						} else if($total_count==0) {
							if(sizeof($error)>0) {
				    			$sessError = new Zend_Session_Namespace('import_vendor_error');
				    			$sessError->error  = $error;
				    		    $sessError->status = 2;
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
				if(Zend_Session::namespaceIsset('import_coa_error')) {
					$sessError = new Zend_Session_Namespace('import_coa_error');
					$this->view->error = $sessError->status. ' rows cannot be inserted due to mismatch or duplicate or invalid entry';
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
		      						$asset[strtolower($keys)][strtolower($key1)][$key2] = strtolower($value2);
		      					}
		      				}
		      		}
		      	 }  else  if($key=='Liabilities') {
		      		foreach ($value as $keys => $values) {
		      				foreach ($values as $key1 => $value1) {
		      					foreach ($value1 as $key2 => $value2) {
		      						$liability[strtolower($keys)][strtolower($key1)][$key2] = strtolower($value2);
		      					}
		      				}
		      		}
		      	 }  else  if($key=='Income') {
		      		foreach ($value as $keys => $values) {
		      				foreach ($values as $key1 => $value1) {
		      					foreach ($value1 as $key2 => $value2) {
		      						$income[strtolower($keys)][strtolower($key1)][$key2] = strtolower($value2);
		      					}
		      				}
		      		}
		      	 }  else  if($key=='Expense') {
		      		foreach ($value as $keys => $values) {
		      				foreach ($values as $key1 => $value1) {
		      					foreach ($value1 as $key2 => $value2) {
		      						$expense[strtolower($keys)][strtolower($key1)][$key2] = strtolower($value2);
		      					}
		      				}
		      		}
		      	 }  else  if($key=='Equity') {
		      		foreach ($value as $keys => $values) {
		      				foreach ($values as $key1 => $value1) {
		      					foreach ($value1 as $key2 => $value2) {
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
		      	$getAccount	=  $this->settings->getAccounts();
		      	$getAccountArray  =  $this->accountData->getData(array('currencies'));
				$currencies =  $getAccountArray['currencies'];
				foreach ($getAccount as $key => $accounts) {
					$account[] = strtolower($accounts['account_name']);
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

					$this->sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
					$this->view->uploaded = 1;
					foreach ($this->sheetData as $key => $data) {
						if($key!=1) {
							$accName = strtolower($data['A']);
							$level1 = strtolower($data['B']);
							$level2 = strtolower($data['C']);
							$level3 = strtolower($data['D']);
							$currency = strtoupper($data['E']);
							if($level1=='assets') {
								if(array_key_exists($level2, $asset)) {
									if(array_key_exists($level3, $asset[$level2])) {
										if(array_key_exists($currency, $currencies)) {
											if(in_array($accName, $asset[$level2][$level3])) {
												if(!in_array($accName,$account)) {
													$key = array_search($accName, $asset[$level2][$level3]);
													$post['company_id'] = $cid;
													$post['account_type'] = 1;
													$post['account_id'] = $key;
													$post['account_name'] = $data['A'];
													$post['currency'] = $currency;
													$post['pay_status'] = 2;
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
											//	print_r($asset[$level2][$level3]);
												/*end($asset[$level2][$level3]);       
												$key = key($asset[$level2][$level3]);  
												$newkey = $key+1;
												$asset[$level2][$level3][$newkey] = $accName;*/
												$error_status = 'Invalid Account Name';
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
							} else if($level1=='liabilities') {
								if(array_key_exists($level2, $liability)) {
									if(array_key_exists($level3, $liability[$level2])) {
										if(array_key_exists($currency, $currencies)) {
											if(in_array($accName, $liability[$level2][$level3])) {
												if(!in_array($accName,$account)) {
													$key = array_search($accName, $liability[$level2][$level3]);
													$post['company_id'] = $cid;
													$post['account_type'] = 2;
													$post['account_id'] = $key;
													$post['account_name'] = $data['A'];
													$post['currency'] = $currency;
													$post['pay_status'] = 2;
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
												$error_status = 'Invalid Account Name';
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
									if(array_key_exists($level3, $income[$level2])) {
										if(array_key_exists($currency, $currencies)) {
											if(in_array($accName, $income[$level2][$level3])) {
												if(!in_array($accName,$account)) {
													$key = array_search($accName, $income[$level2][$level3]);
													$post['company_id'] = $cid;
													$post['account_type'] = 2;
													$post['account_id'] = $key;
													$post['account_name'] = $data['A'];
													$post['currency'] = $currency;
													$post['pay_status'] = 2;
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
												$error_status = 'Invalid Account Name';
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
									if(array_key_exists($level3, $expense[$level2])) {
										if(array_key_exists($currency, $currencies)) {
											if(in_array($accName, $expense[$level2][$level3])) {
												if(!in_array($accName,$account)) {
													$key = array_search($accName, $expense[$level2][$level3]);
													$post['company_id'] = $cid;
													$post['account_type'] = 2;
													$post['account_id'] = $key;
													$post['account_name'] = $data['A'];
													$post['currency'] = $currency;
													$post['pay_status'] = 2;
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
												$error_status = 'Invalid Account Name';
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
									if(array_key_exists($level3, $equity[$level2])) {
										if(array_key_exists($currency, $currencies)) {
											if(in_array($accName, $equity[$level2][$level3])) {
												if(!in_array($accName,$account)) {
													$key = array_search($accName, $equity[$level2][$level3]);
													$post['company_id'] = $cid;
													$post['account_type'] = 2;
													$post['account_id'] = $key;
													$post['account_name'] = $data['A'];
													$post['currency'] = $currency;
													$post['pay_status'] = 2;
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
												$error_status = 'Invalid Account Name';
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



						if($total_count!=0) {
							//$auditLog	= $this->settings->insertAuditLog(10,8,$postArray['import'],$total_count);
							$sessSuccess = new Zend_Session_Namespace('import_coa');
				    		$sessSuccess->status = $total_count;
				    		if(sizeof($error)>0) {
				    			$sessError = new Zend_Session_Namespace('import_coa_error');
				    			$sessError->error  = $error;
				    		    $sessError->status = 2;
				    		}
				    		$this->_redirect('import/coa/');	
						} else if($total_count==0) {
							if(sizeof($error)>0) {
				    			$sessError = new Zend_Session_Namespace('import_coa_error');
				    			$sessError->error  = $error;
				    		    $sessError->status = 2;
				    		}
				    		$this->_redirect('import/coa/');	
						}
					//echo '<pre>'; print_r($this->view->sheetData); echo '</pre>';
				}

				/*echo '<pre>'; print_r($this->view->asset); echo '</pre>';
				echo '<pre>'; print_r($account); echo '</pre>';
				echo '<pre>'; print_r($this->view->liability); echo '</pre>';
				echo '<pre>'; print_r($this->view->income); echo '</pre>';
				echo '<pre>'; print_r($this->view->expense); echo '</pre>';
				echo '<pre>'; print_r($this->view->equity); echo '</pre>';*/


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
			    	$incomeAccount[$incomes['id']] = $incomes['account_name'];
			    }
			    $currencies   =  $getAccountArray['currencies'];
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

						$this->sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
						foreach ($this->sheetData as $key => $data) {
							if($key!=1) {
								$post['product_name']  = trim($data['A']);
								$post['product_id']   = $data['B'];
								$post['description']   = $data['C'];
								$post['price']  = $data['D'];
								$post['currency'] = $data['E'];
								$post['income'] = $data['F'];
								if(isset($post['product_name']) && !empty($post['product_name'])) {
									 if(!in_array($post['income'], $incomeAccount)) {
									 	$error_status = 'Income Account Not Exists';
									 	$error[$key]['name']   = $post['product_name'];
									 	$error[$key]['status'] = $error_status;
									 	$total_error++;
									 } else {
									 	if(array_key_exists($post['currency'], $currencies)) {
									 		$post['income_account'] = array_search($post['income'], $incomeAccount);
									 		//print_r($post); die();
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
									 	} else {
									 		$error_status = 'Currency Name Not Matched With Our Database';
										 	$error[$key]['name']   = $post['product_name'];
										 	$error[$key]['status'] = $error_status;
										 	$total_error++;
									 	}
									 }
								} else {
									$error_status = 'Product Name Empty';
									$error[$key]['name']   = $post['product_name'];
									$error[$key]['status'] = $error_status;
									$total_error++;
								}
							}
						}

						if($total_count!=0) {
							//$auditLog	= $this->settings->insertAuditLog(10,10,$postArray['import'],$total_count);
							$sessSuccess = new Zend_Session_Namespace('import_products');
				    		$sessSuccess->status = $total_count;
				    		if(sizeof($error)>0) {
				    			$sessError = new Zend_Session_Namespace('import_products_error');
				    			$sessError->error  = $error;
				    		    $sessError->status = 2;
				    		}
				    		$this->_redirect('import/products/');	
						} else if($total_count==0) {
							if(sizeof($error)>0) {
				    			$sessError = new Zend_Session_Namespace('import_products_error');
				    			$sessError->error  = $error;
				    		    $sessError->status = 2;
				    		}
				    		$this->_redirect('import/products/');	
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




}

?>