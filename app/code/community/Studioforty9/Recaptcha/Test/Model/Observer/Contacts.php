<?php

class Studioforty9_Recaptcha_Test_Model_Observer_Contacts extends EcomDev_PHPUnit_Test_Case
{
    /** @var Studioforty9_Recaptcha_Model_Observer_Contacts $observer */
    protected $observer;

    public function setUp()
    {
        $this->observer = new Studioforty9_Recaptcha_Model_Observer_Contacts();
    }

    protected function getMockEvent($controller)
    {
        $event = $this->getMockBuilder('Varien_Event')
            ->disableOriginalConstructor()
            ->setMethods(array('getControllerAction'))
            ->getMock();

        $event->expects($this->once())
            ->method('getControllerAction')
            ->will($this->returnValue($controller));

        return $event;
    }

    protected function getMockController($forFailure = true)
    {
        // Mock Response
        $response = $this->getMockBuilder('Zend_Controller_Response_Abstract')
            ->disableOriginalConstructor()
            ->setMethods(array('setRedirect', 'sendResponse'))
            ->getMock();

        // setRedirect call
        $response->expects($forFailure ? $this->once() : $this->never())
            ->method('setRedirect')
            ->with($this->equalTo('/contacts'))
            ->will($this->returnSelf());

        // sendResponse call
        $response->expects($forFailure ? $this->once() : $this->never())
            ->method('sendResponse')
            ->will($this->returnSelf());

        // Mock Request
        $request = $this->getMockBuilder('Zend_Controller_Request_Abstract')
            ->disableOriginalConstructor()
            ->setMethods(array('setDispatched'))
            ->getMock();

        // setDispatched call
        $request->expects($forFailure ? $this->once() : $this->never())
            ->method('setDispatched')
            ->with($this->equalTo(true))
            ->will($this->returnSelf());

        // Mock Controller
        $controller = $this->getMockBuilder('Mage_Core_Controller_Front_Action')
            ->disableOriginalConstructor()
            ->setMethods(array('getResponse', 'getRequest', 'setFlag'))
            ->getMock();

        // getResponse call
        $controller->expects($forFailure ? $this->once() : $this->never())
            ->method('getResponse')
            ->will($this->returnValue($response));

        // getRequest call
        $controller->expects($forFailure ? $this->once() : $this->never())
            ->method('getRequest')
            ->will($this->returnValue($request));

        // setFlag call
        $controller->expects($forFailure ? $this->once() : $this->never())
            ->method('setFlag')
            ->with($this->equalTo(''), $this->equalTo(Mage_Core_Controller_Front_Action::FLAG_NO_DISPATCH), $this->equalTo(true))
            ->will($this->returnSelf());

        return $controller;
    }

    protected function getMockHelper($response)
    {
        $helper = $this->getHelperMock('studioforty9_recaptcha/request', array('verify'), false, array(), null, false);
        $helper->expects($this->once())
            ->method('verify')
            ->will($this->returnValue($response));

        return $helper;
    }

    protected function getMockObserver($response, $forFailure = true)
    {
        $controller = $this->getMockController($forFailure);
        $event = $this->getMockEvent($controller);

        $observer = $this->getMockBuilder('Varien_Event_Observer')
            ->disableOriginalConstructor()
            ->setMethods(array('getEvent'))
            ->getMock();

        $observer->expects($this->once())->method('getEvent')->will($this->returnValue($event));

        $helper = $this->getMockHelper($response);
        $this->replaceByMock('helper', 'studioforty9_recaptcha/request', $helper);

        return $observer;
    }

    protected function replaceSession($type)
    {
        $session = $this->getModelMockBuilder($type)
            ->disableOriginalConstructor()
            ->setMethods(null)
            ->getMock();

        $this->replaceByMock('singleton', $type, $session);

        return $session;
    }

    public function test_onContactsPostPreDispatch_calls_verify_request_and_returns_the_observer_on_success()
    {
        // Mock the required objects
        $response = new Studioforty9_Recaptcha_Helper_Response(true);
        $observer = $this->getMockObserver($response, false);

        // Run the observer
        $result = $this->observer->onContactsPostPreDispatch($observer);

        // If all went to plan, we should have our observer back
        $this->assertInstanceOf('Varien_Event_Observer', $result);
    }

    public function test_onContactsPostPreDispatch_adds_error_message_to_session_on_failure()
    {
        // Mock the session
        $sessionMock = $this->replaceSession('core/session');

        // Mock the required objects
        $response = new Studioforty9_Recaptcha_Helper_Response(false);
        $observer = $this->getMockObserver($response);

        // Run the observer
        $result = $this->observer->onContactsPostPreDispatch($observer);

        // If all went to plan, we should have our controller back
        $this->assertInstanceOf('Mage_Core_Controller_Front_Action', $result);

        // Does the session mock have a new message?
        $this->assertEquals(
            'There was an error with the recaptcha code, please try again.',
            $sessionMock->getMessages()->getLastAddedMessage()->getCode()
        );
    }
}