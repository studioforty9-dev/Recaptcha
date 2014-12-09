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
        if (! Mage::helper('studioforty9_recaptcha')->isEnabled()) {
            return '';
        }

        return '<script src="https://www.google.com/recaptcha/api.js"></script>';
    }

    /**
     * Get the reCAPTCHA html code.
     *
     * @return string
     */
    public function getRecaptchaHtml()
    {
        $helper = Mage::helper('studioforty9_recaptcha');

        if (! $helper->isEnabled()) {
            return '';
        }

        return sprintf(
            '<div class="g-recaptcha" data-theme="%s" data-sitekey="%s"></div>',
            $helper->getTheme(),
            $helper->getSiteKey()
        );
    }
}
