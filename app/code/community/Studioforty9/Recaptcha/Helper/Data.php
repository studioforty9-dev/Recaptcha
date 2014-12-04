<?php

class Studioforty9_Recaptcha_Helper_Data extends Mage_Core_Helper_Abstract
{
    const MODULE_ENABLED = 'studioforty9_recaptcha/settings/enabled';
    const MODULE_KEY_SITE = 'studioforty9_recaptcha/settings/site_key';
    const MODULE_KEY_SECRET = 'studioforty9_recaptcha/settings/secret_key';

    /**
     * Is the module enabled in configuration
     * @return bool
     */
    public function isEnabled()
    {
        return (bool) Mage::getStoreConfig(self::MODULE_ENABLED);
    }

    /**
     * The recaptcha site key.
     *
     * @return string
     */
    public function getSiteKey()
    {
        return Mage::getStoreConfig(self::MODULE_KEY_SITE);
    }

    /**
     * The recaptcha secret key.
     *
     * @return string
     */
    public function getSecretKey()
    {
        return Mage::getStoreConfig(self::MODULE_KEY_SECRET);
    }
}
