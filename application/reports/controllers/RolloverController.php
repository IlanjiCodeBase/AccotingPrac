<?php 
class Rollover_IndexController extends Zend_Controller_Action {
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
			$this->roll        = new Roll();
			$this->rollover    = new Rollover();
			$this->transaction = new Transaction();
			$this->business    = new Business();
			$this->account     = new Account();
			$this->settings    = new Settings();
			$this->approval    = new Approval();
			$this->accountData = new Account_Data();
			if(Zend_Session::namespaceIsset('sess_login')) {
				$logSession = new Zend_Session_Namespace('sess_login');
				if($logSession->type==0 && !isset($logSession->proxy_type)) {
					$this->_redirect('developer');
				}
				if($logSession->type==0 && isset($logSession->proxy_type) && $logSession->proxy_type==4 || $logSession->proxy_type==5) {
					$this->_redirect('index');
				} 
				if($logSession->type==4 || $logSession->type==5) {
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
		}


		public function glAction() {

			echo "ok";

		}
}