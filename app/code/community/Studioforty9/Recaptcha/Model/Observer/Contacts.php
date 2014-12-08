<?php

class Studioforty9_Recaptcha_Model_Observer_Contacts
{
    /**
     * Run the event on the contacts module, index controller, post action
     * pre dispatch observer.
     *
     * @param Varien_Event_Observer $observer
     * @return Varien_Event_Observer
     */
    public function onContactsPostPreDispatch(Varien_Event_Observer $observer)
    {
        if (!Mage::helper('studioforty9_recaptcha')->isEnabled()) {
            return $observer;
        }

        /** @var Mage_Contacts_IndexController $controller */
        $controller = $observer->getEvent()->getControllerAction();

        $request = Mage::helper('studioforty9_recaptcha/request');
        $response = $request->verify();

        if ($response->isFailure()) {
            Mage::getSingleton('core/session')->addError(
                $request->__('There was an error with the recaptcha code, please try again.')
            );

            $controller->getResponse()->setRedirect('/contacts')->sendResponse();
            $controller->getRequest()->setDispatched(true);
            $controller->setFlag('', Mage_Core_Controller_Front_Action::FLAG_NO_DISPATCH, true);

            return $controller;
        }

        return $observer;
    }
}
