<?php

require_once 'Mage/Adminhtml/controllers/IndexController.php';
require_once (Mage::getBaseDir('lib').'/tokenizer/tokenizer_api.php');

class Tokenizer_Authenticator_IndexController extends Mage_Adminhtml_IndexController {
	public function indexAction(){
		$cfg = array(
	        'id'    => Mage::getStoreConfig('general/authenticator/tokenizer_app_id'),
	        'key'   => Mage::getStoreConfig('general/authenticator/tokenizer_key'),
	        'host'  => 'http://api.dev.tokenizer.com/',
	        'format'=> 'json',
    	);
    	$api = new TokenizerApi();
    	$status = Mage::getStoreConfig('general/authenticator/tokenizer_admin');
    	if($status=='1'){
    		$id = $api->createAuth($cfg, 'tokenizer1@niepodam.pl');
			while($api->getAuth($cfg, $id) == 'pending') sleep(1);
			if($api->getAuth($cfg, $id) == 'accepted'){
				$session = Mage::getSingleton('admin/session');
		        $url = $session->getUser()->getStartupPageUrl();
		        if ($session->isFirstPageAfterLogin()) {
		            // retain the "first page after login" value in session (before redirect)
		            $session->setIsFirstPageAfterLogin(true);
		        }
		        $this->_redirect($url);
			}
    	} else {
    		parent::indexAction();
    	}
	}

	public function loginAction()
    {
        if (Mage::getSingleton('admin/session')->isLoggedIn()) {
            $this->_redirect('*');
            return;
        }
        $loginData = $this->getRequest()->getParam('login');
        $username = (is_array($loginData) && array_key_exists('username', $loginData)) ? $loginData['username'] : null;

        $this->loadLayout();
        $this->renderLayout();
    }
}