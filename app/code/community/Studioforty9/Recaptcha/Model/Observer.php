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
 * Studioforty9_Recaptcha_Model_Observer
 *
 * @category   Studioforty9
 * @package    Studioforty9_Recaptcha
 * @subpackage Model
 * @author     StudioForty9 <info@studioforty9.com>
 */
class Studioforty9_Recaptcha_Model_Observer
{
    /**
     * @var Studioforty9_Recaptcha_Helper_Data
     */
    protected $_helper;

    /**
     * Set the module data helper.
     */
    public function __construct()
    {
        $this->_helper = Mage::helper('studioforty9_recaptcha');
    }

    /**
     * Get the module data helper
     *
     * @return Studioforty9_Recaptcha_Helper_Data
     */
    public function getHelper()
    {
        return $this->_helper;
    }

    /**
     * Run the event on the pre dispatch observer for:
     *  - controller_action_predispatch_index_post
     *  - controller_action_predispatch_review_product_post
     *
     * @param Varien_Event_Observer $observer The observer from the controller
     * @return Varien_Event_Observer
     */
    public function onPostPreDispatch(Varien_Event_Observer $observer)
    {
        if (! $this->getHelper()->isEnabled()) {
            return $observer;
        }
        /** @var Mage_Core_Controller_Front_Action $controller */
        $controller = $observer->getEvent()->getControllerAction();

        if (! $this->getHelper()->isAllowed($controller->getRequest()->getRouteName())) {
            return $observer;
        }

        /** @var Studioforty9_Recaptcha_Helper_Request $request */
        $request = Mage::helper('studioforty9_recaptcha/request');
        /** @var Studioforty9_Recaptcha_Helper_Response $response */
        $response = $request->verify();

        if ($response->isSuccess()) {
            return $observer;
        }

        Mage::getSingleton('core/session')->addError(
            $response->__(
                'There was an error with the recaptcha code, please try again.'
            )
        );

        if ($response->hasErrors()) {
            $response->log();
        }

        $flag = Mage_Core_Controller_Varien_Action::FLAG_NO_DISPATCH;
        $redirectUrl = $this->getHelper()->getRedirectUrl();
        $controller->getResponse()->setRedirect($redirectUrl)->sendResponse();
        $controller->getRequest()->setDispatched(true);
        $controller->setFlag('', $flag, true);

        return $controller;
    }
}
