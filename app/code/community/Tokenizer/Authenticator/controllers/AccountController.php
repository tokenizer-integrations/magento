<?php

require_once 'Mage/Customer/controllers/AccountController.php';
require_once (Mage::getBaseDir('lib').'/tokenizer/tokenizer_api.php');

class Tokenizer_Authenticator_AccountController extends Mage_Customer_AccountController {
    public function loginPostTokenizerAction() {
        $cfg = array(
            'id'    => Mage::getStoreConfig('general/authenticator/tokenizer_app_id'),
            'key'   => Mage::getStoreConfig('general/authenticator/tokenizer_key'),
            'host'  => 'http://api.dev.tokenizer.com/',
            'format'=> 'json',
        );
        $api = new TokenizerApi();
        $status = Mage::getStoreConfig('general/authenticator/tokenizer_customer');
        $login = $this->getRequest()->getPost('login');
        if($status == '1'){
        	$id = $api->createAuth($cfg, $login['username']);
	        while($api->getAuth($cfg, $id) == 'pending') sleep(1);
	        if($api->getAuth($cfg, $id) == 'accepted'){
	            
	            $customer_email = $login['username'];
	            $customer = Mage::getModel("customer/customer");
	            $customer->setWebsiteId(Mage::app()->getWebsite()->getId());
	            $customer->loadByEmail($customer_email);

	            $this->_loginPostRedirect();

	            Mage::getSingleton('customer/session')->setCustomerAsLoggedIn($customer);
	        } else {
	            $this->_redirect("/");
	        }	
        } 
    }
}