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
 * Studioforty9_Recaptcha_Model_Source_Size
 *
 * @category   Studioforty9
 * @package    Studioforty9_Recaptcha
 * @subpackage Model
 * @author     StudioForty9 <info@studioforty9.com>
 */
class Studioforty9_Recaptcha_Model_Source_Size
{
    /**
     * Return the options for setting the size.
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            'normal'  => Mage::helper('studioforty9_recaptcha')->__('Normal'),
            'compact' => Mage::helper('studioforty9_recaptcha')->__('Compact')
        );
    }
}
