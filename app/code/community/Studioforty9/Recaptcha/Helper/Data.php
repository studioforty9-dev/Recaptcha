<?php
/**
 * Studioforty9_Recaptcha
 *
 * @category  Studioforty9
 * @package   Studioforty9_Recaptcha
 * @author    StudioForty9 <info@studioforty9.com>
 * @copyright 2014 StudioForty9 (http://www.studioforty9.com)
 * @license   https://github.com/studioforty9/recaptcha/blob/master/LICENCE MIT
 * @version   1.0.0
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
    const MODULE_ENABLED = 'google/recaptcha/enabled';
    const MODULE_KEY_SITE = 'google/recaptcha/site_key';
    const MODULE_KEY_SECRET = 'google/recaptcha/secret_key';
    const MODULE_KEY_THEME = 'google/recaptcha/theme';

    /**
     * Is the module enabled in configuration.
     *
     * @codeCoverageIgnore
     * @return bool
     */
    public function isEnabled()
    {
        return (bool) Mage::getStoreConfig(self::MODULE_ENABLED);
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
}
