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
 * Studioforty9_Recaptcha_Test_Model_Observer
 *
 * @category   Studioforty9
 * @package    Studioforty9_Recaptcha
 * @subpackage Test
 * @author     StudioForty9 <info@studioforty9.com>
 */
class Studioforty9_Recaptcha_Test_Model_Observer extends EcomDev_PHPUnit_Test_Case
{
    /** @var Studioforty9_Recaptcha_Model_Observer $observer */
    protected $observer;

    /** @var Mage_Core_Model_Session $session */
    protected $session;

    public function setUp()
    {
        $this->session = $this->replaceSession('core/session');
        $this->observer = new Studioforty9_Recaptcha_Model_Observer();
    }

    /**
     * The module can be turned off via configuration, by setting
     * 'Enabled' to 'No'. We should ensure that:
     *      1. the verify method is not called
     *      2. the observer which was passed is returned
     *
     * @test
     */
    public function it_doesnt_execute_verify_when_the_module_is_disabled()
    {
        $this->markTestSkipped();

        // helper->isEnabled() called once
        // observer->getEvent() called once
        // event->getControllerAction() called once
        // controller->getRequest() called once
        // request->getRouteName() called once
        // helper->isAllowed() called once
        // requestHelper->verify() should not be called
        // should return observer
    }

    /**
     * @test
     */
    public function it_doesnt_execute_verify_when_the_contact_form_recaptcha_is_disabled()
    {
        $this->markTestSkipped();
    }

    /**
     * @test
     */
    public function it_doesnt_execute_verify_when_the_product_review_form_recaptcha_is_disabled()
    {
        $this->markTestSkipped();
    }

    /**
     * @test
     */
    public function it_doesnt_execute_verify_when_the_send_to_friend_form_recaptcha_is_disabled()
    {
        $this->markTestSkipped();
    }

    /**
     * @test
     */
    public function it_doesnt_execute_verify_when_the_customer_registration_form_recaptcha_is_disabled()
    {
        $this->markTestSkipped();
    }

    public function test_onPostPreDispatch_returns_observer_when_module_disabled()
    {
        $this->markTestSkipped();
        /*
        $dataHelper = $this->getMockDataHelper();
        $dataHelper->expects($this->once())->method('isEnabled')->will($this->returnValue(false));
        $this->replaceByMock('helper', 'studioforty9_recaptcha', $dataHelper);

        $observer = $this->getMockObserver();
        $result = $this->observer->onPostPreDispatch($observer);

        $this->assertInstanceOf('Varien_Event_Observer', $result);*/
    }

    public function test_onPostPreDispatch_returns_observer_on_verify_success_when_module_enabled()
    {
        $this->markTestSkipped();
        /*
        // Expect studioforty9_recaptcha::isEnabled to be called once
        $dataHelper = $this->getMockDataHelper();
        $dataHelper->expects($this->exactly(2))->method('isEnabled')->will($this->returnValue(true));
        $dataHelper->expects($this->once())->method('isContactsEnabled')->will($this->returnValue(false));
        $this->replaceByMock('helper', 'studioforty9_recaptcha', $dataHelper);

        $responseHelper = new Studioforty9_Recaptcha_Helper_Response(true);

        // Expect verify to be called once and return $responseHelper
        $requestHelper = $this->getMockRequestHelper();
        $requestHelper->expects($this->once())->method('verify')->will($this->returnValue($responseHelper));
        $this->replaceByMock('helper', 'studioforty9_recaptcha/request', $requestHelper);

        // Mock the controller object
        $controller = $this->getMockController();

        // Mock the request object
        $request = $this->getMockRequest();

        $controller->expects($this->once())
            ->method('getRequest')
            ->will($this->returnValue($request));

        // Mock the event object
        // Expect getControllerAction to be called once and return $controller
        $event = $this->getMockEvent($controller);
        // Mock the observer object
        $observer = $this->getMockObserver();
        // Expect getEvent to be called once and return the event object
        $observer->expects($this->once())->method('getEvent')->will($this->returnValue($event));

        // Call the onPostPreDispatch method
        $result = $this->observer->onPostPreDispatch($observer);

        $this->assertInstanceOf('Varien_Event_Observer', $result);*/
    }

    public function test_onPostPreDispatch_returns_controller_on_verify_failed_with_module_enabled()
    {
        $this->markTestSkipped();
        /*
        // Mock the data helper
        $dataHelper = $this->getMockDataHelper();
        // Expect isEnabled to called once and return true
        $dataHelper->expects($this->exactly(2))->method('isEnabled')->will($this->returnValue(true));
        $this->replaceByMock('helper', 'studioforty9_recaptcha', $dataHelper);

        // Setup the expected response
        $responseHelper = new Studioforty9_Recaptcha_Helper_Response(false, array('missing-input-response'));

        // Mock the request helper
        $requestHelper = $this->getMockRequestHelper();
        // Expect verify to be called once and return the $responseHelper
        $requestHelper->expects($this->once())->method('verify')->will($this->returnValue($responseHelper));
        $this->replaceByMock('helper', 'studioforty9_recaptcha/request', $requestHelper);

        // Mock the response object
        $response = $this->getMockResponse();

        // Expect setRedirect to be called once
        // It should set the redirect url to the base url + /contacts
        // And return the response object
        $response->expects($this->once())
            ->method('setRedirect')
            ->with($this->equalTo(Mage::getBaseUrl() . 'contacts'))
            ->will($this->returnSelf());

        // Expect sendResponse to be called once
        // And return the response object
        $response->expects($this->once())
            ->method('sendResponse')
            ->will($this->returnSelf());

        // Mock the request object
        $request = $this->getMockRequest();

        // Expect setDispatched to be called once
        // It should set the value to true
        // And return the request object
        $request->expects($this->once())
            ->method('setDispatched')
            ->with($this->equalTo(true))
            ->will($this->returnSelf());

        // Expect getBaseUrl to be called once
        // And return the base url of the website
        $request->expects($this->any())
            ->method('getBaseUrl')
            ->will($this->returnValue(Mage::getBaseUrl()));

        // Mock the controller object
        $controller = $this->getMockController();

        // Expect getResponse to be called once
        // And return the response object
        $controller->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue($response));

        // Expect getRequest to be called twice
        //  1. For getBaseUrl
        //  2. For setDispatched
        // And return the request object
        $controller->expects($this->once())
            ->method('getRequest')
            ->will($this->returnValue($request));

        // Expect setFlag to be called once
        // It should set the following parameters:
        //  1. $action  : '' (empty string)
        //  2. $flag    : Mage_Core_Controller_Front_Action::FLAG_NO_DISPATCH ('no-dispatch')
        //  3. $value   : true
        // And return the controller object
        $controller->expects($this->once())
            ->method('setFlag')
            ->with(
                $this->equalTo(''),
                $this->equalTo(Mage_Core_Controller_Front_Action::FLAG_NO_DISPATCH),
                $this->equalTo(true)
            )
            ->will($this->returnSelf());

        // Mock the event object
        $event = $this->getMockEvent($controller);

        // Mock the observer object
        $observer = $this->getMockObserver();

        // Expect getEvent to be called once and return the event object
        $observer->expects($this->once())->method('getEvent')->will($this->returnValue($event));

        // Run the observer
        $result = $this->observer->onPostPreDispatch($observer);

        // If all went to plan, we should have our controller back
        $this->assertInstanceOf('Mage_Core_Controller_Front_Action', $result);

        // Does the session have a new message?
        $this->assertEquals(
            'There was an error with the recaptcha code, please try again.',
            $this->session->getMessages()->getLastAddedMessage()->getCode()
        );
        */
    }

    /* ----- MOCK OBJECTS ----- */

    protected function getMockResponse()
    {
        // Mock Response
        $response = $this->getMockBuilder('Zend_Controller_Response_Abstract')
            ->disableOriginalConstructor()
            ->setMethods(array('setRedirect', 'sendResponse'))
            ->getMock();

        return $response;
    }

    protected function getMockRequest()
    {
        $request = $this->getMockBuilder('Zend_Controller_Request_Abstract')
            ->disableOriginalConstructor()
            ->setMethods(array('setDispatched', 'getBaseUrl', 'getRouteName'))
            ->getMock();

        // Expect getRouteName to be called
        // And return the route name of the module being called
        $request->expects($this->any())
            ->method('getRouteName')
            ->will($this->returnValue('contacts'));

        return $request;
    }

    protected function getMockController()
    {
        // Mock Controller
        $controller = $this->getMockBuilder('Mage_Core_Controller_Front_Action')
            ->disableOriginalConstructor()
            ->setMethods(array('getResponse', 'getRequest', 'setFlag'))
            ->getMock();

        return $controller;
    }

    protected function getMockObserver()
    {
        $observer = $this->getMockBuilder('Varien_Event_Observer')
            ->disableOriginalConstructor()
            ->setMethods(array('getEvent'))
            ->getMock();

        return $observer;
    }

    protected function getMockDataHelper()
    {
        $helper = $this->getHelperMock('studioforty9_recaptcha', array(
            'isEnabled', 'getSiteKey', 'getSecretKey', 'getTheme', 'isContactsEnabled'
        ), false, array(), null, false);

        return $helper;
    }

    protected function getMockRequestHelper()
    {
        $helper = $this->getHelperMock('studioforty9_recaptcha/request', array('verify'), false, array(), null, false);

        return $helper;
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

    protected function replaceSession($type)
    {
        $session = $this->getModelMockBuilder($type)
            ->disableOriginalConstructor()
            ->setMethods(array('getVisitorData', 'getLastUrl', 'hasVisitorData', 'hasLastUrl'))
            ->getMock();

        $session->expects($this->any())
            ->method('getVisitorData')
            ->will($this->returnValue(array('request_uri' => Mage::getBaseUrl() . 'contacts')));

        $session->expects($this->any())
            ->method('getLastUrl')
            ->will($this->returnValue(Mage::getBaseUrl() . 'contacts'));

        $session->expects($this->any())
            ->method('hasVisitorData')
            ->will($this->returnValue(true));

        $session->expects($this->any())
            ->method('hasLastUrl')
            ->will($this->returnValue(true));

        $this->replaceByMock('singleton', $type, $session);

        return $session;
    }

    private function _expects($object, $times, $method, $value)
    {
        $object->expects($times)->method($method)->will($value);
        return $object;
    }
}
