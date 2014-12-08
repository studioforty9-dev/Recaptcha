<?php

class Studioforty9_Recaptcha_Block_Autorender extends Mage_Core_Block_Template
{
    public function getRecaptchaScript()
    {
        if (!Mage::helper('studioforty9_recaptcha')->isEnabled()) {
            return '';
        }

        return '<script src="https://www.google.com/recaptcha/api.js"></script>';
    }

    public function getRecaptchaHtml()
    {
        if (!Mage::helper('studioforty9_recaptcha')->isEnabled()) {
            return '';
        }

        $siteKey = Mage::helper('studioforty9_recaptcha')->getSiteKey();
        return sprintf('<div class="g-recaptcha" data-sitekey="%s"></div>', $siteKey);
    }
}
