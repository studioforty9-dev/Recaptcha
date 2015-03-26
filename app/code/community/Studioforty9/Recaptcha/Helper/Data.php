<?php
/**
 * Studioforty9_Recaptcha
 *
 * @category  Studioforty9
 * @package   Studioforty9_Recaptcha
 * @author    StudioForty9 <info@studioforty9.com>
 * @copyright 2015 StudioForty9 (http://www.studioforty9.com)
 * @license   https://github.com/studioforty9/recaptcha/blob/master/LICENCE BSD
 * @version   1.2.0
 * @link      https://github.com/studioforty9/recaptcha
 */

/**
 * Studioforty9_Recaptcha_Helper_Data
 *
 * @category   Studioforty9
 * @package    Studioforty9_Recaptcha
 * @subpackage Helper
 * @author     StudioForty9 <info@studioforty9.com>
 */
class Studioforty9_Recaptcha_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**#@+
     * Configuration paths.
     * @var string
     */
    const MODULE_ENABLED = 'google/recaptcha/enabled';
    const MODULE_ENABLED_CONTACTS = 'google/recaptcha/enabled_contacts';
    const MODULE_ENABLED_REVIEWS = 'google/recaptcha/enabled_reviews';
    const MODULE_ENABLED_SENDFRIEND = 'google/recaptcha/enabled_sendfriend';
    const MODULE_ENABLED_CUSTOMER_REG = 'google/recaptcha/enabled_customer_registration';
    const MODULE_KEY_SITE = 'google/recaptcha/site_key';
    const MODULE_KEY_SECRET = 'google/recaptcha/secret_key';
    const MODULE_KEY_THEME = 'google/recaptcha/theme';
    /**#@-*/

    /**
     * Is the module enabled in configuration.
     *
     * @codeCoverageIgnore
     * @return bool
     */
    public function isEnabled()
    {
        return Mage::getStoreConfigFlag(self::MODULE_ENABLED);
    }

    /**
     * Is the recaptcha enabled on the contacts form.
     *
     * @codeCoverageIgnore
     * @return bool
     */
    public function isContactsEnabled()
    {
        return Mage::getStoreConfigFlag(self::MODULE_ENABLED_CONTACTS);
    }

    /**
     * Is the recaptcha enabled on the product review form.
     *
     * @codeCoverageIgnore
     * @return bool
     */
    public function isReviewsEnabled()
    {
        return Mage::getStoreConfigFlag(self::MODULE_ENABLED_REVIEWS);
    }

    /**
     * Is the recaptcha enabled on the product send to friend form.
     *
     * @codeCoverageIgnore
     * @return bool
     */
    public function isSendFriendEnabled()
    {
        return Mage::getStoreConfigFlag(self::MODULE_ENABLED_SENDFRIEND);
    }

    /**
     * Is the recaptcha enabled on the customer registration form.
     *
     * @codeCoverageIgnore
     * @return bool
     */
    public function isCustomerRegistrationEnabled()
    {
        return Mage::getStoreConfigFlag(self::MODULE_ENABLED_CUSTOMER_REG);
    }

    /**
     * The recaptcha site key.
     *
     * @codeCoverageIgnore
     * @return string
     */
    public function getSiteKey()
    {
        return Mage::getStoreConfig(self::MODULE_KEY_SITE);
    }

    /**
     * The recaptcha secret key.
     *
     * @codeCoverageIgnore
     * @return string
     */
    public function getSecretKey()
    {
        return Mage::getStoreConfig(self::MODULE_KEY_SECRET);
    }

    /**
     * The recaptcha widget theme.
     *
     * @codeCoverageIgnore
     * @return string
     */
    public function getTheme()
    {
        return Mage::getStoreConfig(self::MODULE_KEY_THEME);
    }

    /**
     * Get the redirect URL.
     *  - no visitor_data or last_url stored in core/session
     *      return the base_url
     *  - no visitor_data but last_url is stored in core/session
     *      return the last_url
     *  - visitor_data exists but request_uri does not, but last_url is stored in core/session
     *      return the last_url
     * - request_uri exists
     *      return the request_uri
     *
     * @todo Unit Test this method.
     * @return string
     */
    public function getRedirectUrl()
    {
        $_session = Mage::getSingleton('core/session');

        if (! $_session->hasVisitorData() && !$_session->hasLastUrl()) {
            return Mage::getBaseUrl();
        }

        if (! $_session->hasVisitorData() && $_session->hasLastUrl()) {
            return $_session->getLastUrl();
        }

        $visitorData = $_session->getVisitorData();
        if (! array_key_exists('request_uri', $visitorData) && $_session->hasLastUrl()) {
            return $_session->getLastUrl();
        }

        return $visitorData['request_uri'];
    }

    /**
     * Is the module allowed to run.
     *
     * @todo Unit Test this method.
     * @param string $route
     * @return bool
     */
    public function isAllowed($route)
    {
        if (! Mage::getConfig()->getModuleConfig("Studioforty9_Recaptcha")->is('active', 'true')) {
            return false;
        }
        
        $acl = array(
            'contacts'   => $this->isContactsEnabled(),
            'review'     => $this->isReviewsEnabled(),
            'customer'   => $this->isCustomerRegistrationEnabled(),
            'sendfriend' => $this->isSendFriendEnabled()
        );

        return ($this->isEnabled() && array_key_exists($route, $acl) && $acl[$route] === true);
    }
}
