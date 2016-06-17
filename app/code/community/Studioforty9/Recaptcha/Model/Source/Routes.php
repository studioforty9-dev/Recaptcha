<?php
/**
 * Studioforty9_Recaptcha
 *
 * @category  Studioforty9
 * @package   Studioforty9_Recaptcha
 * @author    StudioForty9 <info@studioforty9.com>
 * @copyright 2015 StudioForty9 (http://www.studioforty9.com)
 * @license   https://github.com/studioforty9/recaptcha/blob/master/LICENCE BSD
 * @version   1.5.0
 * @link      https://github.com/studioforty9/recaptcha
 */

/**
 * Studioforty9_Recaptcha_Model_Source_Theme
 *
 * @category   Studioforty9
 * @package    Studioforty9_Recaptcha
 * @subpackage Model
 * @author     StudioForty9 <info@studioforty9.com>
 */
class Studioforty9_Recaptcha_Model_Source_Routes
{
    /**
     * Return the options for setting the theme.
     *
     * @return array
     */
    public function toOptionArray()
    {
        $routes = new Studioforty9_Recaptcha_Model_Routes();
        
        $routes->add('contacts_index', Mage::helper('studioforty9_recaptcha')->__('Contact Form'));
        $routes->add('review_product', Mage::helper('studioforty9_recaptcha')->__('Product Review Form'));
        $routes->add('customer_account_create', Mage::helper('studioforty9_recaptcha')->__('Account Registration Form'));
        $routes->add('sendfriend_product_send', Mage::helper('studioforty9_recaptcha')->__('Send to Friend Form'));
        $routes->add('customer_account_login', Mage::helper('studioforty9_recaptcha')->__('Login Form'));
        $routes->add('customer_account_forgotpassword', Mage::helper('studioforty9_recaptcha')->__('Forgot Password Form'));
        
        Mage::dispatchEvent('studioforty9_recaptcha_routes', array('routes' => $routes));
        
        return $routes->toArray();
    }
}
