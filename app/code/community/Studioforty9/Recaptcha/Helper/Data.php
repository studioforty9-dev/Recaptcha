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
    const MODULE_KEY_SITE = 'google/recaptcha/site_key';
    const MODULE_KEY_SECRET = 'google/recaptcha/secret_key';
    const MODULE_KEY_THEME = 'google/recaptcha/theme';
    const MODULE_KEY_SIZE = 'google/recaptcha/size';
    const MODULE_KEY_TYPE = 'google/recaptcha/type';
    const MODULE_KEY_ROUTES = 'google/recaptcha/enabled_routes';
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
     * The recaptcha widget type.
     *
     * @codeCoverageIgnore
     * @return string
     */
    public function getType()
    {
        return Mage::getStoreConfig(self::MODULE_KEY_TYPE);
    }

    /**
     * The recaptcha widget size.
     *
     * @codeCoverageIgnore
     * @return string
     */
    public function getSize()
    {
        return Mage::getStoreConfig(self::MODULE_KEY_SIZE);
    }

    /**
     * The enabled routes.
     *
     * @codeCoverageIgnore
     * @return string
     */
    public function getEnabledRoutes()
    {
        $routes = array_filter(explode(',', Mage::getStoreConfig(self::MODULE_KEY_ROUTES)));
        array_map('strtolower', $routes);
        
        return $routes;
    }

    /**
     * Is the provided route enabled.
     *
     * @codeCoverageIgnore
     * @param string $route
     * @return bool
     */
    public function isEnabledRoute($route)
    {
        foreach ($this->getEnabledRoutes() as $enabledRoute) {
            if (false !== strpos($route, $enabledRoute)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Is the module allowed to run.
     *
     * @codeCoverageIgnore
     * @param string $route
     * @return bool
     */
    public function isAllowed($route)
    {
        if (! $this->isModuleActive() || ! $this->isEnabled()) {
            return false;
        }
        
        return $this->isEnabledRoute($route);
    }
		
    /**
     * Is the module active.
     *
     * @codeCoverageIgnore
     * @return bool
     */
    public function isModuleActive()
    {
        return Mage::getConfig()
            ->getModuleConfig("Studioforty9_Recaptcha")
            ->is('active', 'true');
    }
}
