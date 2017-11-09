<?php

/**
 * Class Studioforty9_Recaptcha_Model_Backend_Routes
 */
class Studioforty9_Recaptcha_Model_Backend_Routes extends Mage_Core_Model_Config_Data {

    /**
     * Workaround to be able to add the billing save controller to the config
     */
    protected function _beforeSave()
    {
        $value = $this->getValue();
        if (in_array('checkout_onepage_index', $value)) {
            $value[] = 'checkout_onepage_saveBilling';
            $this->setValue($value);
        } elseif (($key = array_search('checkout_onepage_saveBilling', $value)) !== false) {
            unset($value[$key]);
            $this->setValue($value);
        }
    }
}