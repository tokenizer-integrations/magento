<?php

class Tokenizer_Authenticator_Block_Login extends Mage_Core_Block_Template {
	protected function _construct() {
		Mage::register('tokenizer_authenticator_button_text', $this->__('Login'));

        $this->setTemplate('tokenizer/authenticator/login.phtml');
	}

	protected function _getColSet()
    {
        return 'col'.$this->numEnabled.'-set';
    }

    protected function _getDescCol()
    {
        return 'col-'.++$this->numDescShown;
    }

    protected function _getButtCol()
    {
        return 'col-'.++$this->numButtShown;
    }

    protected function _tokenizerEnabled() {
        return Mage::getStoreConfig('general/authenticator/tokenizer_customer');
    }
}