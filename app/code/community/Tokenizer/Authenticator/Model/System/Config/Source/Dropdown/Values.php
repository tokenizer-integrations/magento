<?php
 
class Tokenizer_Authenticator_Model_System_Config_Source_Dropdown_Values
{
    public function toOptionArray()
    {
        return array(
            array(
                'value' => '0',
                'label' => 'No',
            ),
            array(
                'value' => '1',
                'label' => 'Yes',
            ),
        );
    }
}