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
 * Studioforty9_Recaptcha_Model_Observer_Contacts
 *
 * @category   Studioforty9
 * @package    Studioforty9_Recaptcha
 * @subpackage Model
 * @author     StudioForty9 <info@studioforty9.com>
 */
class Studioforty9_Recaptcha_Model_Observer_Contacts
{
    /**
     * Run the event on the contacts module, index controller, post action
     * pre dispatch observer.
     *
     * @param Varien_Event_Observer $observer The observer from the controller
     *
     * @return Varien_Event_Observer
     */
    public function onContactsPostPreDispatch(Varien_Event_Observer $observer)
    {
        if (!Mage::helper('studioforty9_recaptcha')->isEnabled()) {
            return $observer;
        }

        /** @var Mage_Contacts_IndexController $controller */
        $controller = $observer->getEvent()->getControllerAction();

        /** @var Studioforty9_Recaptcha_Helper_Request $request */
        $request = Mage::helper('studioforty9_recaptcha/request');
        /** @var Studioforty9_Recaptcha_Helper_Response $response */
        $response = $request->verify();

        if ($response->isFailure()) {
            Mage::getSingleton('core/session')->addError(
                $response->__(
                    'There was an error with the recaptcha code, please try again.'
                )
            );

            if ($response->hasErrors()) {
                $this->_logErrors($response);
            }

            $redirectUrl = $controller->getRequest()->getBaseUrl() . '/contacts';
            $controller->getResponse()->setRedirect($redirectUrl)->sendResponse();
            $controller->getRequest()->setDispatched(true);
            $controller->setFlag(
                '',
                Mage_Core_Controller_Front_Action::FLAG_NO_DISPATCH,
                true
            );

            return $controller;
        }

        return $observer;
    }

    /**
     * Log the errors from Google reCAPTCHA to system.log
     *
     * @param Studioforty9_Recaptcha_Helper_Response $response The response helper
     *
     * @return void
     */
    protected function _logErrors(Studioforty9_Recaptcha_Helper_Response $response)
    {
        Mage::log(
            sprintf(
                'reCAPTCHA Errors: %1$s',
                implode(', ', $response->getErrors())
            )
        );
    }
}
