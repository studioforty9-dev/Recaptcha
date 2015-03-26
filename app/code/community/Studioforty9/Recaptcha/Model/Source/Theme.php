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
 * Studioforty9_Recaptcha_Model_Source_Theme
 *
 * @category   Studioforty9
 * @package    Studioforty9_Recaptcha
 * @subpackage Model
 * @author     StudioForty9 <info@studioforty9.com>
 */
class Studioforty9_Recaptcha_Model_Source_Theme
{
    /**
     * Return the options for setting the theme.
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            'light' => $this->_getDataHelper()->__('Light'),
            'dark'  => $this->_getDataHelper()->__('Dark')
        );
    }

    /**
     * Fetch the data helper for the module.
     *
     * @codeCoverageIgnore
     * @return Studioforty9_Recaptcha_Helper_Data
     */
    protected function _getDataHelper()
    {
        return Mage::helper('studioforty9_recaptcha');
    }
}
