<?php
/**
 * Studioforty9_Recaptcha
 *
 * @category  Studioforty9
 * @package   Studioforty9_Recaptcha
 * @author    StudioForty9 <info@studioforty9.com>
 * @copyright 2015 StudioForty9 (http://www.studioforty9.com)
 * @license   https://github.com/studioforty9/recaptcha/blob/master/LICENCE BSD
 * @version   1.5.7
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
    protected $_languages = array(
        'ar_DZ|ar_SA|ar_KW|ar_MA|ar_EG|az_AZ|' => 'ar',
        'bg_BG' => 'bg',
        'ca_ES' => 'ca',
        'zh_CN' => 'zh-CN',
        'zh_HK|zh_TW' => 'zh-TW',
        'hr_HR' => 'hr',
        'cs_CZ' => 'cs',
        'da_DK' => 'da',
        'nl_NL' => 'nl',
        'en_GB|en_AU|en_NZ|en_IE|cy_GB' => 'en-GB',
        'en_US|en_CA' => 'en',
        'fil_PH' => 'fil',
        'fi_FI' => 'fi',
        'fr_FR' => 'fr',
        'fr_CA' => 'fr-CA',
        'de_DE' => 'de',
        'de_AT)' => 'de-AT',
        'de_CH' => 'de-CH',
        'el_GR' => 'el',
        'he_IL' => 'iw',
        'hi_IN' => 'hi',
        'hu_HU' => 'hu',
        'gu_IN|id_ID' => 'id',
        'it_IT|it_CH' => 'it',
        'ja_JP' => 'ja',
        'ko_KR' => 'ko',
        'lv_LV' => 'lv',
        'lt_LT' => 'lt',
        'nb_NO' => 'no',
        'fa_IR' => 'fa',
        'pl_PL' => 'pl',
        'pt_BR' => 'pt-BR',
        'pt_PT' => 'pt-PT',
        'ro_RO' => 'ro',
        'ru_RU' => 'ru',
        'sr_RS' => 'sr',
        'sk_SK' => 'sk',
        'sl_SI' => 'sl',
        'es_ES|gl_ES' => 'es',
        'es_AR|es_CL|es_CO|es_CR|es_MX|es_PA|es_PE|es_VE' => 'es-419',
        'sv_SE' => 'sv',
        'th_TH' => 'th',
        'tr_TR' => 'tr',
        'uk_UA' => 'uk',
        'vi_VN' => 'vi'
    );

    /**
     * Is the block allowed to display.
     *
     * @param string $route
     * @return bool
     */
    public function isAllowed($route = '')
    {
        if ($this->hasData('allow')) {
            return (bool) $this->getData('allow');
        }

        return $this->_getHelper()->isAllowed($route);
    }

    /**
     * Get the recaptcha site key.
     *
     * @codeCoverageIgnore
     * @return string
     */
    public function getSiteKey()
    {
        return $this->_getHelper()->getSiteKey();
    }

    /**
     * Get the recaptcha theme setting.
     *
     * @codeCoverageIgnore
     * @return string
     */
    public function getTheme()
    {
        return $this->_getHelper()->getTheme();
    }

    /**
     * Get the recaptcha type setting.
     *
     * @codeCoverageIgnore
     * @return string
     */
    public function getType()
    {
        return $this->_getHelper()->getType();
    }

    /**
     * Get the recaptcha size setting.
     *
     * @codeCoverageIgnore
     * @return string
     */
    public function getSize()
    {
        return $this->_getHelper()->getSize();
    }

    /**
     * Get the reCAPTACHA javascript code.
     *
     * @return string
     */
    public function getRecaptchaScript()
    {
        if (! $this->_getHelper()->isEnabled()) {
            return '';
        }

        $language = Mage::app()->getLocale()->getLocale()->toString();
        $lang = 'en';

        foreach ($this->_languages as $options => $_lang) {
            if (stristr($options, $language)) {
                $lang = $_lang;
            }
        }

        $query = array(
            'onload' => 'onloadCallback',
            'render' => 'explicit',
            'hl'     => $lang
        );

        return sprintf(
            '<script src="https://www.google.com/recaptcha/api.js?%s" async defer></script>',
            http_build_query($query)
        );
    }

    /**
     * Get a unique ID for the recaptcha block.
     *
     * @return string
     */
    public function getRecaptchaId()
    {
        return uniqid();
    }

    /**
     * Get the recaptcha helper.
     *
     * @return Studioforty9_Recaptcha_Helper_Data
     */
    protected function _getHelper()
    {
        return Mage::helper('studioforty9_recaptcha');
    }
}
