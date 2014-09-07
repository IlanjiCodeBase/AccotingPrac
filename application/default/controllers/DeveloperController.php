<?php 
class DeveloperController extends Zend_Controller_Action {
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
		$this->account 	   = new Account();
		$this->approval    = new Approval();
		$this->transaction = new Transaction();
		$this->settings    = new Settings();
		$this->accountData = new Account_Data();
		if(Zend_Session::namespaceIsset('sess_login')) {
			$logSession = new Zend_Session_Namespace('sess_login');
			if($logSession->type!=0 && $logSession->type!=1) {
				$this->_redirect('index');
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

	public function indexAction() {
	      if(!Zend_Session::namespaceIsset('sess_login')) {
	            $this->_redirect('index');
	      } else {
	      	$logSession = new Zend_Session_Namespace('sess_login');

	      	
	      	/*$logSession->companySet = 1;
	      	$remoteSession 	= new Zend_Session_Namespace('sess_remote_database');
						$remoteSession->hostName = "localhost";
						$remoteSession->userName = "root";
						$remoteSession->password = "";
						$remoteSession->dataBase = 'umm_accounting2';
	      	$logSession->cid = 2;*/
	      }
    }

    public function companiesAction() {
	      if(!Zend_Session::namespaceIsset('sess_login')) {
	            $this->_redirect('index');
	      } else {
	      	$logSession = new Zend_Session_Namespace('sess_login');
	      	if(Zend_Session::namespaceIsset('success_company_delete')) {
				$this->view->success = 'Company Deleted Successfully';
				Zend_Session::namespaceUnset('success_company_delete');
			}
	      	$deleteDb = base64_decode($this->_getParam('deleteDb'));
			if((isset($deleteDb) && $deleteDb!='')) {
				$dropDatabase = $this->account->dropDatabase($deleteDb);
				if(isset($logSession->type) && $logSession->type==0) {
					if($dropDatabase) {
						if($logSession->proxy_cid==$deleteDb) {
							unset($logSession->proxy_cid);
							unset($logSession->proxy_name);
							unset($logSession->proxy_id);
							unset($logSession->proxy_type);
							unset($logSession->proxy_currency);
						}
						$sessSuccess = new Zend_Session_Namespace('success_company_delete');
						$sessSuccess->status = 1;
						$this->_redirect('developer/companies');
					}
				} else if(isset($logSession->type) && $logSession->type==1)  {
					if($dropDatabase && Zend_Session::destroy()) {
						$this->_redirect('index');
					} else {
						$this->_redirect('index');
					}
				}
			} 
	      	$getMoneyArray           =  $this->accountData->getData(array('country','account_types'));
			$this->view->countries   =  $getMoneyArray['country'];
			$this->view->accTypes    =  $getMoneyArray['account_types'];
			$this->view->companies   =  $this->account->getCompanies();
			$this->view->logins      =  $this->account->getLoginDetails();
			//echo '<pre>'; print_r($this->view->companies); echo '</pre>';
			//echo '<pre>'; print_r($this->view->logins); echo '</pre>';
	      }
    }

    public function configureDatabaseAction() {
    	if(!Zend_Session::namespaceIsset('sess_login')) {
	            $this->_redirect('index');
	      } else {
	      }
	}

	public function editAction() {
    	if(!Zend_Session::namespaceIsset('sess_login')) {
	            $this->_redirect('index');
	      } else {
	      	if(Zend_Session::namespaceIsset('update_success_company')) {
				$this->view->success = 'Company Details Updated Successfully';
				Zend_Session::namespaceUnset('update_success_company');
			}
			$getAccountArray            =  $this->accountData->getData(array('country'));
			$this->view->countries      =  $getAccountArray['country'];
			$id = base64_decode($this->_getParam('company'));
			if(!isset($id) || $id=='') {
				$this->_redirect('developer/companies');
			} else {
				$this->view->result 		 =  $this->account->getCompany($id);
				if(!$this->view->result) {
					$this->_redirect('developer/companies');
				}
			}
		//	echo '<pre>'; print_r($this->view->result); echo '</pre>';  
			if($this->_request->isPost()) {
				$postArray  				= $this->getRequest()->getPost();
					$result					= $this->account->updateCompany($postArray,$id);
					if($result) {
						$sessSuccess = new Zend_Session_Namespace('update_success_company');
						$sessSuccess->status = 1;
						$this->_redirect('developer/edit/company/'.$this->_getParam('company'));
					} else {
						$this->view->error = 'Company cannot be updated. Kindly try again later';
					}
			}
	      }
	}

	public function usersAction() {
	      if(!Zend_Session::namespaceIsset('sess_login')) {
	            $this->_redirect('index');
	      } else {
	      	if(Zend_Session::namespaceIsset('delete_success_user')) {
				$this->view->success = 'User deleted successfully';
				Zend_Session::namespaceUnset('delete_success_user');
			}
			$delid = base64_decode($this->_getParam('delid'));
			if(isset($delid) && !empty($delid)) {
				$deleteStatus = $this->account->deleteUser($delid);
				if($deleteStatus) {
					$sessSuccess = new Zend_Session_Namespace('delete_success_user');
					$sessSuccess->status = 1;
				}
					$this->_redirect('developer/users');
			}
	      	$getMoneyArray           =  $this->accountData->getData(array('country','account_types'));
			$this->view->countries   =  $getMoneyArray['country'];
			$this->view->accTypes    =  $getMoneyArray['account_types'];
			$this->view->companies   =  $this->account->getCompanies();
			$this->view->logins      =  $this->account->getLoginDetails();
	      }
    }

    public function addUserAction() {
    	if(!Zend_Session::namespaceIsset('sess_login')) {
	            $this->_redirect('index');
	      } else {
	      	if(Zend_Session::namespaceIsset('insert_success_user')) {
				$this->view->success = 'User Created Successfully';
				Zend_Session::namespaceUnset('insert_success_user');
			}
			if(Zend_Session::namespaceIsset('insert_success_error')) {
				$this->view->error = 'Developer Account must have a account name with domain under pinnone.com';
				Zend_Session::namespaceUnset('insert_success_error');
			}
	      	$getMoneyArray           =  $this->accountData->getData(array('country','account_types'));
			$this->view->countries   =  $getMoneyArray['country'];
			$this->view->accTypes    =  $getMoneyArray['account_types'];
			$id = base64_decode($this->_getParam('company'));
			if(!isset($id) || $id=='') {
				$this->_redirect('developer/users');
			} else {
				$this->view->result 		 =  $this->account->getCompany($id);
				if(!$this->view->result) {
					$this->_redirect('developer/users');
				}
			}
			if($this->_request->isPost()) {
				$postArray  				= $this->getRequest()->getPost();
				if($postArray['account_type']==1) {
					$username =explode("@", trim($postArray['username']));
					if($username[1]!='pinnone.com') {
						$sessError = new Zend_Session_Namespace('insert_success_error');
						$sessError->status = 1;
						$this->_redirect('developer/add-user/company/'.$this->_getParam('company'));
					}
				}
				$checkUsername			= $this->account->checkLogin($postArray['username']);
				if(!$checkUsername) {
					$result					= $this->account->insertLogin($postArray,$id);
					if($result) {
						$sessSuccess = new Zend_Session_Namespace('insert_success_user');
						$sessSuccess->status = 1;
						$this->_redirect('developer/add-user/company/'.$this->_getParam('company'));
					} else {
						$this->view->error = 'User cannot be created. Kindly try again later';
					}
				} else {
					$this->view->error = 'Email ID already exists. Kindly try some other email address';
				}
			}
	      }
	}


	public function editUserAction() {
    	if(!Zend_Session::namespaceIsset('sess_login')) {
	            $this->_redirect('index');
	      } else {
	      	if(Zend_Session::namespaceIsset('update_success_user')) {
				$this->view->success = 'User Updated Successfully';
				Zend_Session::namespaceUnset('update_success_user');
			}
			if(Zend_Session::namespaceIsset('insert_success_error')) {
				$this->view->error = 'Developer Account must have a account name with domain under pinnone.com';
				Zend_Session::namespaceUnset('insert_success_error');
			}
	      	$getMoneyArray           =  $this->accountData->getData(array('country','account_types'));
			$this->view->countries   =  $getMoneyArray['country'];
			$this->view->accTypes    =  $getMoneyArray['account_types'];
			$cid = base64_decode($this->_getParam('company'));
			$lid = base64_decode($this->_getParam('user'));
			if((!isset($cid) || $cid=='') && (!isset($lid) || $lid=='')) {
				$this->_redirect('developer/users');
			} else {
				$this->view->company  =  $this->account->getCompany($cid);
				$this->view->login    =  $this->account->getLoginDetails($lid);
				if(!$this->view->company && !$this->view->login) {
					$this->_redirect('developer/users');
				}
			}
			if($this->_request->isPost()) {
				$postArray  				= $this->getRequest()->getPost();
				if($postArray['account_type']==1) {
					$username =explode("@", trim($postArray['username']));
					if($username[1]!='pinnone.com') {
						$sessError = new Zend_Session_Namespace('insert_success_error');
						$sessError->status = 1;
						$this->_redirect('developer/edit-user/user/'.$this->_getParam('user').'/company/'.$this->_getParam('company'));
					}
				}
				$checkUsername			= $this->account->checkLogin($postArray['username'],$lid);
				if(!$checkUsername) {
					$result					= $this->account->updateLogin($postArray,$lid);
					if($result) {
						$sessSuccess = new Zend_Session_Namespace('update_success_user');
						$sessSuccess->status = 1;
						$this->_redirect('developer/edit-user/user/'.$this->_getParam('user').'/company/'.$this->_getParam('company'));
					} else {
						$this->view->error = 'User cannot be updated. Kindly try again later';
					} 
				} else {
					$this->view->error = 'Email ID already exists. Kindly try some other email address';
				}
			}
		}
	}


	public function resetPasswordAction() {
    	if(!Zend_Session::namespaceIsset('sess_login')) {
	            $this->_redirect('index');
	      } else {
	      	if(Zend_Session::namespaceIsset('reset_success_user_password')) {
				$this->view->success = 'Password reset Successfully';
				Zend_Session::namespaceUnset('reset_success_user_password');
			}
	      	$getMoneyArray           =  $this->accountData->getData(array('country','account_types'));
			$this->view->countries   =  $getMoneyArray['country'];
			$this->view->accTypes    =  $getMoneyArray['account_types'];
			$cid = base64_decode($this->_getParam('company'));
			$lid = base64_decode($this->_getParam('user'));
			if((!isset($cid) || $cid=='') && (!isset($lid) || $lid=='')) {
				$this->_redirect('developer/users');
			} else {
				$this->view->company  =  $this->account->getCompany($cid);
				$this->view->login    =  $this->account->getLoginDetails($lid);
				if(!$this->view->company && !$this->view->login) {
					$this->_redirect('developer/users');
				}
			}
			if($this->_request->isPost()) {
				$postArray  				= $this->getRequest()->getPost();
					$result					= $this->account->resetPassword($postArray,$lid);
					if($result) {
						$sessSuccess = new Zend_Session_Namespace('reset_success_user_password');
						$sessSuccess->status = 1;
						$this->_redirect('developer/reset-password/user/'.$this->_getParam('user').'/company/'.$this->_getParam('company'));
					} else {
						$this->view->error = 'Password cannot be reset. Kindly try again later';
					}
			}
	      }
	}


    public function announcementsAction() {
    	if(!Zend_Session::namespaceIsset('sess_login')) {
	            $this->_redirect('index');
	      } else {
	      	if(Zend_Session::namespaceIsset('delete_success_announcement')) {
				$this->view->success = 'Announcement deleted successfully';
				Zend_Session::namespaceUnset('delete_success_announcement');
			}
			if(Zend_Session::namespaceIsset('insert-success-announcement')) {
				$this->view->success = 'Announcement sent successfully';
				Zend_Session::namespaceUnset('insert-success-announcement');
			}
			$delid = base64_decode($this->_getParam('delid'));
			if(isset($delid) && !empty($delid)) { 
				$deleteStatus = $this->account->deleteAnnouncement($delid);
				if($deleteStatus) {
					$sessSuccess = new Zend_Session_Namespace('delete_success_announcement');
					$sessSuccess->status = 1;
				}
					$this->_redirect('developer/announcements');
			}
	      	$this->view->announcements   =  $this->account->getAnnouncements();
	      }
	}

	public function sendAnnouncementAction() {
    	if(!Zend_Session::namespaceIsset('sess_login')) {
	            $this->_redirect('index');
	      } else {
	      	$logSession = new Zend_Session_Namespace('sess_login');
	      
	      	$this->view->companies   =  $this->account->getCompanies();
	      	if(isset($logSession->type) && !empty($logSession->type) && $logSession->type==1) {
				$this->view->userList 	=  $this->account->getCompanyUserDetails($logSession->cid);
			}
	      //	echo '<pre>'; print_r($this->view->companies); echo '</pre>';
	      if($this->_request->isPost()) {
					$postArray  			= $this->getRequest()->getPost();
					if(isset($logSession->type) && $logSession->type==0 && isset($postArray['all']) && $postArray['all']=='all') {
						$postArray['company'] = 0;
						$postArray['users'] = "all";
					} else if(isset($logSession->type) && !empty($logSession->type) && $logSession->type==1 && isset($postArray['all']) && $postArray['all']=='all') {
						$users = array();
						if(isset($this->view->userList) && !empty($this->view->userList)) {
                           foreach ($this->view->userList as $user) {
                           		$users[] = $user['id'];
                           }
                         }
                         $postArray['company'] = $postArray['companies'];
                         $postArray['users'] = implode(",", $users);
					} else {
						$postArray['users'] 	= implode(",", $postArray['users']);
					}
					$result					= $this->account->sendAnnouncement($postArray);
					if($result) {
						$sessSuccess = new Zend_Session_Namespace('insert-success-announcement');
						$sessSuccess->status = 1;
						$this->_redirect('developer/announcements');
					} else {
						$this->view->error = 'Announcement cannot be send right now. Kindly try again later';
					}
			}

	      }
	}



public function editAnnouncementAction() {
    	if(!Zend_Session::namespaceIsset('sess_login')) {
	            $this->_redirect('index');
	      } else {
	      	if(Zend_Session::namespaceIsset('update-success-announcement')) {
				$this->view->success = 'Details Updated Successfully';
				Zend_Session::namespaceUnset('update-success-announcement');
			}

			$id = base64_decode($this->_getParam('aid'));
			if(!isset($id) || $id=='') {
				$this->_redirect('developer/announcements');
			} else {
				$this->view->result 		 =  $this->account->getAnnouncements($id);
				if(!$this->view->result) {
					$this->_redirect('developer/announcements');
				} else {
					$this->view->company   =  $this->account->getCompany($this->view->result[0]['fkcompany_id']);
					$this->view->userList  =  $this->account->getCompanyUserDetails($this->view->result[0]['fkcompany_id']);
				}
			}
			//echo '<pre>'; print_r($this->view->result); echo '</pre>';
			if($this->_request->isPost()) {
				$postArray  				= $this->getRequest()->getPost();
					$result					= $this->account->updateAnnouncement($postArray,$id);
					if($result) {
						$sessSuccess = new Zend_Session_Namespace('update-success-announcement');
						$sessSuccess->status = 1;
						$this->_redirect('developer/edit-announcement/aid/'.$this->_getParam('aid'));
					} else {
						$this->view->error = 'Details cannot be updated right now. Kindly try again later';
					}
			}
	      }
	}


	public function viewAnnouncementAction() {
    	if(!Zend_Session::namespaceIsset('sess_login')) {
	            $this->_redirect('index');
	      } else {
	      	if(Zend_Session::namespaceIsset('update-success-announcement')) {
				$this->view->success = 'Details Updated Successfully';
				Zend_Session::namespaceUnset('update-success-announcement');
			}
			$this->view->companies   =  $this->account->getCompanies();
			$id = base64_decode($this->_getParam('aid'));
			if(!isset($id) || $id=='') {
				$this->_redirect('developer/announcements');
			} else {
				$this->view->result 		 =  $this->account->getAnnouncements($id);
				if(!$this->view->result) {
					$this->_redirect('developer/announcements');
				} else {
					$this->view->userList  =  $this->account->getCompanyUserDetails($this->view->result[0]['fkcompany_id']);
				}
			}
		//	echo '<pre>'; print_r($this->view->userList); echo '</pre>';
			if($this->_request->isPost()) {
				$postArray  				= $this->getRequest()->getPost();
					$result					= $this->account->updateAnnouncement($postArray,$id);
					if($result) {
						$sessSuccess = new Zend_Session_Namespace('update-success-announcement');
						$sessSuccess->status = 1;
						$this->_redirect('developer/edit-announcement/aid/'.$this->_getParam('aid'));
					} else {
						$this->view->error = 'Details cannot be updated right now. Kindly try again later';
					}
			}
	      }
	}

	public function proxySettingsAction() {
	    if(!Zend_Session::namespaceIsset('sess_login')) {
	            $this->_redirect('index');
	    } else {
		   $logSession = new Zend_Session_Namespace('sess_login');
	       if(Zend_Session::namespaceIsset('success_proxy_set')) {
				$this->view->success = 'Proxy set successfully';
				Zend_Session::namespaceUnset('success_proxy_set');
			}
			if(Zend_Session::namespaceIsset('success_proxy_unset')) {
				$this->view->success = 'Proxy unset successfully';
				Zend_Session::namespaceUnset('success_proxy_unset');
			}
			if(Zend_Session::namespaceIsset('success_proxy_unset_delete')) {
				$this->view->success = 'Account has been deleted and Proxy unset successfully';
				Zend_Session::namespaceUnset('success_proxy_unset');
			}
			if(isset($logSession->proxy_cid) && !empty($logSession->proxy_cid)) {
				$this->view->userList 	=  $this->account->getCompanyUserDetails($logSession->proxy_cid);
			}
			if(isset($logSession->type) && !empty($logSession->type) && $logSession->type==1) {
				$this->view->userList 	=  $this->account->getCompanyUserDetails($logSession->cid);
			}
			if($this->_request->isPost()) {
				$postArray  				= $this->getRequest()->getPost();
				if(isset($postArray['set_proxy']) && $postArray['set_proxy']==1) {
					unset($logSession->proxy_cid);
					unset($logSession->proxy_name);
					unset($logSession->proxy_id);
					unset($logSession->proxy_type);
					unset($logSession->proxy_currency);
					$sessSuccess = new Zend_Session_Namespace('success_proxy_unset');
					$sessSuccess->status = 1;
					$this->_redirect('developer/proxy-settings');
				} else if(isset($postArray['set_proxy']) && $postArray['set_proxy']==2) {
					$compControls = explode("_", $postArray['company']);
					$logSession->proxy_cid  = $compControls[0];
					$logSession->proxy_name = $compControls[1];
					$userControls = explode("_", $postArray['users']);
					$logSession->proxy_id    = $userControls[0];
					$logSession->proxy_type  = $userControls[1];
					$companySet = $this->account->getCompanyDatabase($logSession->proxy_cid);
					if($companySet) {

						$remoteSession = new Zend_Session_Namespace('sess_remote_database');
						$remoteSession->hostName = "localhost";
						$remoteSession->userName = "ummadc";
						$remoteSession->password = "accelerated2020";
						$remoteSession->dataBase = $companySet[0]['database_name'];

						$company = $this->account->getCompany($logSession->proxy_cid);

						$logSession->proxy_currency  = $company[0]['currency'];

						$sessSuccess = new Zend_Session_Namespace('success_proxy_set');
						$sessSuccess->status = 1;
						$this->_redirect('developer/proxy-settings');

					} else {

						unset($logSession->proxy_cid);
						unset($logSession->proxy_name);
						unset($logSession->proxy_id);
						unset($logSession->proxy_type);
						$sessError = new Zend_Session_Namespace('error_proxy_set');
						$sessError->status = 1;
						$this->_redirect('developer/proxy-settings');

					}
 				}
			}

			$this->view->companies   =  $this->account->getCompanies();
	    }
	}


	public function irastaxAction() {
		if(!Zend_Session::namespaceIsset('sess_login')) {
			 $this->_redirect('index');
		} else {
 			if(Zend_Session::namespaceIsset('set_success_tax')) {
				$this->view->success = 'IRAS Tax Code has been set as active successfully';
				Zend_Session::namespaceUnset('set_success_tax');
			}
			if(Zend_Session::namespaceIsset('unset_success_tax')) {
				$this->view->success = 'IRAS Tax Code has been unset successfully';
				Zend_Session::namespaceUnset('unset_success_tax');
			}
			if(Zend_Session::namespaceIsset('delete_success_tax')) {
				$this->view->success = 'IRAS Tax Code deleted successfully';
				Zend_Session::namespaceUnset('delete_success_tax');
			}
			if(Zend_Session::namespaceIsset('delete_error_tax')) {
				$this->view->error = 'IRAS Tax Code cannot be deleted. It\'s already associated with income/invoice/expense';
				Zend_Session::namespaceUnset('delete_error_tax');
			}
			if(Zend_Session::namespaceIsset('insert_success_tax')) {
				$this->view->success = 'IRAS Tax Code added successfully';
				Zend_Session::namespaceUnset('insert_success_tax');
			}
			$taxid    = base64_decode($this->_getParam('set-tax-id'));
			$taxname  = base64_decode($this->_getParam('tax-name'));
			$status = $this->_getParam('status');
			if(isset($taxid) && !empty($taxid) && isset($status) && !empty($status)) {
				$setTax = $this->settings->setIrasTax($taxid,$status);
				if($setTax) {
					if($status==1) {
						//$auditLog	 = $this->settings->insertAuditLog(4,9,$taxname,$taxid);
						$sessSuccess = new Zend_Session_Namespace('set_success_tax');
						$sessSuccess->status = 1;
					} else if($status==2) {
						//$auditLog	 = $this->settings->insertAuditLog(5,9,$taxname,$taxid);
						$sessSuccess = new Zend_Session_Namespace('unset_success_tax');
						$sessSuccess->status = 1;
					}
				}
					$this->_redirect('developer/irastax');
			}
			$getAccountArray        =  $this->accountData->getData(array('purchaseTaxCodes','supplyTaxCodes'));
			//$this->view->purchase   =  $getAccountArray['purchaseTaxCodes'];
			//$this->view->supply     =  $getAccountArray['supplyTaxCodes'];
			
			$this->view->taxes  	=  $this->transaction->getIrasTax();
			
		//	echo '<pre>'; print_r($this->view->result); echo '</pre>';
		}
	}

	public function addIrastaxAction() {
		if(!Zend_Session::namespaceIsset('sess_login')) {
			 $this->_redirect('index');
		} else {
			$logSession = new Zend_Session_Namespace('sess_login');
			if(isset($logSession->proxy_cid) && !empty($logSession->proxy_cid)) {
				$cid = $logSession->proxy_cid;
			} else {
				$cid = $logSession->cid;
			}
			$getAccountArray        =  $this->accountData->getData(array('purchaseTaxCodes','supplyTaxCodes'));
			//$this->view->purchase   =  $getAccountArray['purchaseTaxCodes'];
			//$this->view->supply     =  $getAccountArray['supplyTaxCodes'];
			
			
			if($this->_request->isPost()) {
				$postArray  =   $this->getRequest()->getPost();
				//echo '<pre>'; print_r($postArray); echo '</pre>';
				$postArray['tax_code'] = $postArray['category_code'];
				$postArray['description'] = str_replace("\r\n", " ", $postArray['description']);
				$this->tax = $this->settings->insertIrasTax($postArray);
				//$auditLog  = $this->settings->insertAuditLog(1,9,$postArray['tax_code'],$this->tax);
				if(isset($this->tax) && !empty($this->tax)) {
					$sessSuccess = new Zend_Session_Namespace('insert_success_tax');
				    $sessSuccess->status = 1;
					$this->_redirect('developer/irastax');	
				} else {
					$this->view->error = 'Tax cannot be added. Kindly try again later';
				}
			}
		}
	}


	public function themesAction() {
    	if(!Zend_Session::namespaceIsset('sess_login')) {
	            $this->_redirect('index');
	      } else {
	      	$logSession = new Zend_Session_Namespace('sess_login');
			if(isset($logSession->proxy_cid) && !empty($logSession->proxy_cid)) {
				$cid = $logSession->proxy_cid;
			} else {
	 			$cid = $logSession->cid;
	 		}
	 		if(Zend_Session::namespaceIsset('update_theme_success')) {
				$this->view->success = 'Theme Settings Updated Successfully';
				Zend_Session::namespaceUnset('update_theme_success');
			}
	 		if($this->_request->isPost()) {
				$postArray  				= $this->getRequest()->getPost();
					$result					= $this->settings->updateThemes($postArray);
					if($result) {
						$sessSuccess = new Zend_Session_Namespace('update_theme_success');
						$sessSuccess->status = 1;
						$this->_redirect('settings/notification');
					} else {
						$this->view->error = 'Theme cannot be updated. Kindly try again later';
					}
			}
			$this->view->filepath  =  $this->uploadPath.$cid."/";
			$this->view->company   =  $this->account->getCompany($cid);
			$this->view->themes    =  $this->settings->getAllDeveloperThemes();
			//print_r($this->view->themes);
	      }
	}

	public function ajaxRefreshAction() {
		$this->_helper->getHelper('layout')->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		$logSession = new Zend_Session_Namespace('sess_login');
		$cid = $logSession->cid;
		if($this->_request->isXmlHttpRequest()) {
			if ($this->_request->isPost()) {
				$ajaxVal = $this->getRequest()->getPost();
				if($ajaxVal['action']=='companyUsers') {
					$splitcomp = explode("_", $ajaxVal['id']);
					$this->userList 	=  $this->account->getCompanyUserDetails($splitcomp[0]);
					if($this->userList) {
						 $jsonEncode = json_encode($this->userList);
						 echo $jsonEncode;
					}
				}  else if($ajaxVal['action']=='changeTheme') {
					$this->updateTheme = $this->settings->updateDeveloperTheme($ajaxVal['activeid'],$ajaxVal['id']);
					if($this->updateTheme) {
						echo "1";
					} else {
						echo "2";
					}
				}
			}
		}
	}

}

?>