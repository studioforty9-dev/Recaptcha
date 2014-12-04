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
        $request = Mage::helper('studioforty9_recaptcha/request');
        $response = $request->verify();

        if ($response->isFailure()) {
            Mage::getSingleton('core/session')->addError(
                $request->__('There was an error with the recaptcha code, please try again.')
            );
            
            return Mage::app()->getResponse()->setRedirect('/contacts')->sendResponse();
        }

        return $observer;
    }
}
