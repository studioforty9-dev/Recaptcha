<?php
/**
 * Studioforty9_Recaptcha
 *
 * @category  Studioforty9
 * @package   Studioforty9_Recaptcha
 * @author    StudioForty9 <info@studioforty9.com>
 * @copyright 2015 StudioForty9 (http://www.studioforty9.com)
 * @license   https://github.com/studioforty9/recaptcha/blob/master/LICENCE BSD
 * @version   1.1.0
 * @link      https://github.com/studioforty9/recaptcha
 */

/**
 * Studioforty9_Recaptcha_Block_Explicit
 *
 * @category   Studioforty9
 * @package    Studioforty9_Recaptcha
 * @subpackage Block
 */
class Studioforty9_Recaptcha_Block_Explicit extends Mage_Core_Block_Template
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

        return '<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>';
    }

    /**
     * Get the recaptcha theme setting.
     *
     * @return string
     */
    public function getTheme()
    {
        return Mage::helper('studioforty9_recaptcha')->getTheme();
    }

    /**
     * Get the recaptcha site key.
     *
     * @return string
     */
    public function getSiteKey()
    {
        return Mage::helper('studioforty9_recaptcha')->getSiteKey();
    }

    /**
     * Determine if the module configuration settings allow displaying
     * the widget in the current context.
     *
     * @param string $route
     * @return bool
     */
    public function isAllowed($route)
    {
        if ($this->hasData('allow') && $this->getData('allow')) {
            return true;
        }

        return Mage::helper('studioforty9_recaptcha')->isAllowed($route);
    }
}
