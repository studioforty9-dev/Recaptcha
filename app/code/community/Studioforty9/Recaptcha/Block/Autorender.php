<?php

class Studioforty9_Recaptcha_Block_Autorender extends Mage_Core_Block_Template
{
    /**
     * Get the reCAPTACHA javascript code.
     *
     * @return string
     */
    public function getRecaptchaScript()
    {
        return '<script src="https://www.google.com/recaptcha/api.js"></script>';
    }

    /**
     * Get the reCAPTCHA html code.
     *
     * @return string
     */
    public function getRecaptchaHtml()
    {
        $siteKey = Mage::helper('studioforty9_recaptcha')->getSiteKey();
        return sprintf('<div class="g-recaptcha" data-sitekey="%s"></div>', $siteKey);
    }
}
