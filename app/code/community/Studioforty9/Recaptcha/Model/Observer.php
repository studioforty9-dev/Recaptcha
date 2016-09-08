<?php
/**
 * Studioforty9_Recaptcha
 *
 * @category  Studioforty9
 * @package   Studioforty9_Recaptcha
 * @author    StudioForty9 <info@studioforty9.com>
 * @copyright 2015 StudioForty9 (http://www.studioforty9.com)
 * @license   https://github.com/studioforty9/recaptcha/blob/master/LICENCE BSD
 * @version   1.5.6
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
     * Run the event on the pre dispatch observer for a controller action
     *
     * @param Varien_Event_Observer $observer The dispatched observer
     * @return Mage_Core_Controller_Front_Action
     */
    public function onPostPreDispatch(Varien_Event_Observer $observer)
    {   
        if (! Mage::helper('studioforty9_recaptcha')->isEnabled()) return;

        /** @var Mage_Core_Controller_Front_Action $controller */
        $controller = $observer->getEvent()->getControllerAction();
        if (! $controller->getRequest()->isPost()) return;
        
        $route = $controller->getFullActionName();
        if (! Mage::helper('studioforty9_recaptcha')->isAllowed($route)) return;
        
        /** @var Studioforty9_Recaptcha_Helper_Response $response */
        $response = Mage::helper('studioforty9_recaptcha/request')->verify();
        if ($response->isSuccess()) return;
        
        /** reCAPTCHA Verification Failed **/
        
        Mage::getSingleton('core/session')->addError(
            Mage::helper('studioforty9_recaptcha')->__(
                'There was an error with the recaptcha code, please try again.'
            )
        );
        
        $flag = Mage_Core_Controller_Varien_Action::FLAG_NO_DISPATCH;
        $redirectUrl = Mage::helper('studioforty9_recaptcha/redirect')->getUrl();

        $controller->getRequest()->setDispatched(true);
        $controller->setFlag('', $flag, true);
        $controller->getResponse()->setRedirect($redirectUrl);
        
        $payload = array(
            'controller_action'  => $controller,
            'recaptcha_response' => $response
        );
        
        Mage::dispatchEvent('studioforty9_recaptcha_failed', $payload);
        Mage::dispatchEvent('studioforty9_recaptcha_failed_' . $route, $payload);
				
        return $controller;
    }
    
    /**
     * Run additional logic on a failed recaptcha verification for the review form.
     *
     * @param Varien_Event_Observer $observer The dispatched observer
     * @return Mage_Core_Controller_Front_Action
     */
    public function onFailedRecaptchaProductReview(Varien_Event_Observer $observer)
    {
        $data = $observer->getEvent()->getControllerAction()->getRequest()->getPost();
        Mage::getSingleton('review/session')->setFormData($data);
    }
    
    /**
     * Run additional logic on a failed recaptcha verification for the customer registration form.
     *
     * @param Varien_Event_Observer $observer The dispatched observer
     * @return Mage_Core_Controller_Front_Action
     */
    public function onFailedRecaptchaCustomerRegistration(Varien_Event_Observer $observer)
    {
        $data = $observer->getEvent()->getControllerAction()->getRequest()->getPost();
        Mage::getSingleton('customer/session')->setCustomerFormData($data);
    }
    
    /**
     * Run additional logic on a failed recaptcha verification for the send to friend form.
     *
     * @param Varien_Event_Observer $observer The dispatched observer
     * @return Mage_Core_Controller_Front_Action
     */
    public function onFailedRecaptchaSendFriend(Varien_Event_Observer $observer)
    {
        $data = $observer->getEvent()->getControllerAction()->getRequest()->getPost();
        Mage::getSingleton('catalog/session')->setSendfriendFormData($data);
    }
    
    /**
     * Run additional logic on a failed recaptcha verification for the forgot password form.
     *
     * @param Varien_Event_Observer $observer The dispatched observer
     * @return Mage_Core_Controller_Front_Action
     */
    public function onFailedRecaptchaLogin(Varien_Event_Observer $observer)
    {
        $data = $observer->getEvent()->getControllerAction()->getRequest()->getPost('login');
        $login = isset($data['username']) ? $data['username'] : null;
        Mage::getSingleton('customer/session')->setUsername($login);
    }

    /**
     * Run additional logic on a failed recaptcha verification for the forgot password form.
     *
     * @param Varien_Event_Observer $observer The dispatched observer
     * @return Mage_Core_Controller_Front_Action
     */
    public function onFailedRecaptchaForgotPassword(Varien_Event_Observer $observer)
    {
        $email = $observer->getEvent()->getControllerAction()->getRequest()->getPost('email');
        Mage::getSingleton('customer/session')->setForgottenEmail($email);
    }
}
