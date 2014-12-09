<?php

class Studioforty9_Recaptcha_Model_Source_Theme
{
    /**
     * Return the options for setting the theme.
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            'light' => $this->_getDataHelper()->__('Light'),
            'dark'  => $this->_getDataHelper()->__('Dark')
        );
    }

    /**
     * Fetch the data helper for the module.
     *
     * @codeCoverageIgnore
     * @return Studioforty9_Recaptcha_Helper_Data
     */
    protected function _getDataHelper()
    {
        return Mage::helper('studioforty9_recaptcha');
    }
}
