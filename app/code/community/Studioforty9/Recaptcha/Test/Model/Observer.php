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
     * The module can be turned off via configuration, by setting 'Enabled' to 'No'.
     * We should ensure that the verify method is not called.
     *
     * @test
     * @group observer
     * @group Recaptcha
     */
    public function it_doesnt_execute_verify_when_the_module_is_disabled()
    {
        // Mock the data helper
        $dataHelper = $this->getMockDataHelper();
        $dataHelper->expects($this->once())->method('isEnabled')->will($this->returnValue(false));
        $this->replaceByMock('helper', 'studioforty9_recaptcha', $dataHelper);
        // Mock the observer object
        $observer = $this->getMockObserver();
        
        $result = $this->observer->onPostPreDispatch($observer);

        $this->assertNull($result);
    }
    
    /**
     * @test
     * @group observer
     * @group onPostPreDispatch
     * @group Recaptcha
     */
    public function onPostPreDispatch_returns_null_when_request_method_is_not_post()
    {
        // Mock the data helper
        $dataHelper = $this->getMockDataHelper();
        $dataHelper->expects($this->once())->method('isEnabled')->will($this->returnValue(true));
        $this->replaceByMock('helper', 'studioforty9_recaptcha', $dataHelper);
        
        // Mock the request object
        $request = $this->getMockRequest();
        $request->expects($this->once())->method('isPost')->will($this->returnValue(false));
        
        // Mock the controller object
        $controller = $this->getMockController();
        $controller->expects($this->once())
            ->method('getRequest')
            ->will($this->returnValue($request));

        // Mock the event object, expects getControllerAction to be called once and return $controller
        $event = $this->getMockEvent($controller);
        
        // Mock the observer object
        $observer = $this->getMockObserver();
        
        // Expect getEvent to be called once and return the event object
        $observer->expects($this->once())->method('getEvent')->will($this->returnValue($event));
        
        // Call the observer method
        $result = $this->observer->onPostPreDispatch($observer);

        $this->assertNull($result);
    }
    
    /**
     * @test
     * @group observer
     * @group onPostPreDispatch
     * @group Recaptcha
     */
    public function onPostPreDispatch_returns_null_when_route_is_not_allowed()
    {
        // Mock the data helper
        $dataHelper = $this->getMockDataHelper();
        $dataHelper->expects($this->once())->method('isEnabled')->will($this->returnValue(true));
        $dataHelper->expects($this->once())->method('isAllowed')
            ->with($this->equalTo('route_controller_action'))
            ->will($this->returnValue(false));
        $this->replaceByMock('helper', 'studioforty9_recaptcha', $dataHelper);
        
        // Mock the request object
        $request = $this->getMockRequest();
        $request->expects($this->once())->method('isPost')->will($this->returnValue(true));
        
        // Mock the controller object
        $controller = $this->getMockController();
        $controller->expects($this->once())
            ->method('getRequest')
            ->will($this->returnValue($request));
        
        $controller->expects($this->once())
            ->method('getFullActionName')
            ->will($this->returnValue('route_controller_action'));

        // Mock the event object, expects getControllerAction to be called once and return $controller
        $event = $this->getMockEvent($controller);
        
        // Mock the observer object
        $observer = $this->getMockObserver();
        
        // Expect getEvent to be called once and return the event object
        $observer->expects($this->once())->method('getEvent')->will($this->returnValue($event));
        
        // Call the observer method
        $result = $this->observer->onPostPreDispatch($observer);

        $this->assertNull($result);
    }

    /**
     * @test
     * @group observer
     * @group onPostPreDispatch
     * @group Recaptcha
     */
    public function onPostPreDispatch_returns_observer_on_verify_success_when_module_enabled()
    {
        // Mock the data helper
        $dataHelper = $this->getMockDataHelper();
        $dataHelper->expects($this->once())->method('isEnabled')->will($this->returnValue(true));
        $dataHelper->expects($this->once())->method('isAllowed')
            ->with($this->equalTo('route_controller_action'))
            ->will($this->returnValue(true));
        $this->replaceByMock('helper', 'studioforty9_recaptcha', $dataHelper);

        $responseHelper = new Studioforty9_Recaptcha_Helper_Response(true);

        // Expect verify to be called once and return $responseHelper
        $requestHelper = $this->getMockRequestHelper();
        $requestHelper->expects($this->once())->method('verify')->will($this->returnValue($responseHelper));
        $this->replaceByMock('helper', 'studioforty9_recaptcha/request', $requestHelper);

        // Mock the request object
        $request = $this->getMockRequest();
        $request->expects($this->once())->method('isPost')->will($this->returnValue(true));
        
        // Mock the controller object
        $controller = $this->getMockController();
        $controller->expects($this->once())->method('getRequest')->will($this->returnValue($request));
        $controller->expects($this->once())->method('getFullActionName')->will($this->returnValue('route_controller_action'));
        
        // Mock the event object, expects getControllerAction to be called once and return $controller
        $event = $this->getMockEvent($controller);
        
        // Mock the observer object
        $observer = $this->getMockObserver();
        
        // Expect getEvent to be called once and return the event object
        $observer->expects($this->once())->method('getEvent')->will($this->returnValue($event));

        // Call the onPostPreDispatch method
        $result = $this->observer->onPostPreDispatch($observer);

        $this->assertNull($result);
    }

    public function test_onPostPreDispatch_returns_controller_on_verify_failed_with_module_enabled()
    {
        $url = Mage::getBaseUrl() . 'contacts';
        
        // Mock the data helper
        $dataHelper = $this->getMockDataHelper();
        $dataHelper->expects($this->once())->method('isEnabled')->will($this->returnValue(true));
        $dataHelper->expects($this->once())->method('isAllowed')
            ->with($this->equalTo('route_controller_action'))
            ->will($this->returnValue(true));
        $this->replaceByMock('helper', 'studioforty9_recaptcha', $dataHelper);
        
        $redirectHelper = $this->getMockRedirectHelper();
        $redirectHelper->expects($this->once())->method('getUrl')->will($this->returnValue($url));
        $this->replaceByMock('helper', 'studioforty9_recaptcha/redirect', $redirectHelper);

        // Setup the expected response
        $responseHelper = new Studioforty9_Recaptcha_Helper_Response(false, array('missing-input-response'));

        // Mock the request helper
        $requestHelper = $this->getMockRequestHelper();
        // Expect verify to be called once and return $responseHelper
        $requestHelper->expects($this->once())->method('verify')->will($this->returnValue($responseHelper));
        $this->replaceByMock('helper', 'studioforty9_recaptcha/request', $requestHelper);

        // Mock the response object
        $response = $this->getMockResponse();

        // Expect setRedirect to be called once
        // It should set the redirect url to the base url + /contacts
        // And return the response object
        $response->expects($this->once())->method('setRedirect')->with($this->equalTo($url))->will($this->returnSelf());

        // Mock the request object
        $request = $this->getMockRequest();
        $request->expects($this->once())->method('isPost')->will($this->returnValue(true));
        $request->expects($this->once())->method('setDispatched')->with($this->equalTo(true))->will($this->returnSelf());

        // Mock the controller object
        $controller = $this->getMockController();
        $controller->expects($this->once())->method('getFullActionName')->will($this->returnValue('route_controller_action'));
        $controller->expects($this->once())->method('getResponse')->will($this->returnValue($response));
        $controller->expects($this->exactly(2))->method('getRequest')->will($this->returnValue($request));
        $controller->expects($this->once())->method('setFlag')->will($this->returnSelf())->with(
            $this->equalTo(''),
            $this->equalTo(Mage_Core_Controller_Front_Action::FLAG_NO_DISPATCH),
            $this->equalTo(true)
        );

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
        
        // Were the custom event dispatched
        $this->assertEventDispatched('studioforty9_recaptcha_failed');
        $this->assertEventDispatched('studioforty9_recaptcha_failed_route_controller_action');
    }
    
    /**
     * @test
     * @group observer
     * @group Recaptcha
     */
    public function it_saves_data_back_on_product_review_form_when_recaptcha_fails()
    {
        $this->replaceSession('review/session');
        
        $post = array('name' => 'value');
        
        // Mock the request object
        $request = $this->getMockRequest();
        $request->expects($this->once())->method('getPost')->will($this->returnValue($post));
        
        // Mock the controller object
        $controller = $this->getMockBuilder('Mage_Core_Controller_Front_Action')
            ->disableOriginalConstructor()
            ->setMethods(array('getRequest'))
            ->getMock();
        $controller->expects($this->once())->method('getRequest')->will($this->returnValue($request));

        // Mock the observer object
        $observer = $this->getMockObserver();

        // Mock the event object
        $event = $this->getMockEvent($controller);

        // Expect getEvent to be called once and return the event object
        $observer->expects($this->once())->method('getEvent')->will($this->returnValue($event));

        // Run the observer
        $this->observer->onFailedRecaptchaProductReview($observer);
        
        $formData = Mage::getSingleton('review/session')->getFormData();
        
        $this->assertInternalType('array', $formData);
        $this->assertArrayHasKey('name', $formData);
        $this->assertEquals('value', $formData['name']);
    }
    
    /**
     * @test
     * @group observer
     * @group Recaptcha
     */
    public function it_saves_data_back_on_customer_resgistration_form_when_recaptcha_fails()
    {
        $this->replaceSession('customer/session');
        
        $post = array('name' => 'value');
        
        // Mock the request object
        $request = $this->getMockRequest();
        $request->expects($this->once())->method('getPost')->will($this->returnValue($post));
        
        // Mock the controller object
        $controller = $this->getMockBuilder('Mage_Core_Controller_Front_Action')
            ->disableOriginalConstructor()
            ->setMethods(array('getRequest'))
            ->getMock();
        $controller->expects($this->once())->method('getRequest')->will($this->returnValue($request));

        // Mock the observer object
        $observer = $this->getMockObserver();

        // Mock the event object
        $event = $this->getMockEvent($controller);

        // Expect getEvent to be called once and return the event object
        $observer->expects($this->once())->method('getEvent')->will($this->returnValue($event));

        // Run the observer
        $this->observer->onFailedRecaptchaCustomerRegistration($observer);
        
        $formData = Mage::getSingleton('customer/session')->getCustomerFormData();
        
        $this->assertInternalType('array', $formData);
        $this->assertArrayHasKey('name', $formData);
        $this->assertEquals('value', $formData['name']);
    }
    
    /**
     * @test
     * @group observer
     * @group Recaptcha
     */
    public function it_saves_data_back_on_sendfriend_form_when_recaptcha_fails()
    {
        $this->replaceSession('catalog/session');
        
        $post = array('name' => 'value');
        
        // Mock the request object
        $request = $this->getMockRequest();
        $request->expects($this->once())->method('getPost')->will($this->returnValue($post));
        
        // Mock the controller object
        $controller = $this->getMockBuilder('Mage_Core_Controller_Front_Action')
            ->disableOriginalConstructor()
            ->setMethods(array('getRequest'))
            ->getMock();
        $controller->expects($this->once())->method('getRequest')->will($this->returnValue($request));

        // Mock the observer object
        $observer = $this->getMockObserver();

        // Mock the event object
        $event = $this->getMockEvent($controller);

        // Expect getEvent to be called once and return the event object
        $observer->expects($this->once())->method('getEvent')->will($this->returnValue($event));

        // Run the observer
        $this->observer->onFailedRecaptchaSendFriend($observer);
        
        $formData = Mage::getSingleton('catalog/session')->getSendfriendFormData();
        
        $this->assertInternalType('array', $formData);
        $this->assertArrayHasKey('name', $formData);
        $this->assertEquals('value', $formData['name']);
    }
    
    /**
     * @test
     * @group observer
     * @group Recaptcha
     */
    public function it_saves_data_back_on_login_form_when_recaptcha_fails()
    {
        $this->replaceSession('customer/session');
        
        $post = array('username' => 'user@domain.tld');
        
        // Mock the request object
        $request = $this->getMockRequest();
        $request->expects($this->once())->method('getPost')->with($this->equalTo('login'))->will($this->returnValue($post));
        
        // Mock the controller object
        $controller = $this->getMockBuilder('Mage_Core_Controller_Front_Action')->disableOriginalConstructor()->setMethods(array('getRequest'))->getMock();
        $controller->expects($this->once())->method('getRequest')->will($this->returnValue($request));

        // Mock the observer object
        $observer = $this->getMockObserver();

        // Mock the event object
        $event = $this->getMockEvent($controller);

        // Expect getEvent to be called once and return the event object
        $observer->expects($this->once())->method('getEvent')->will($this->returnValue($event));

        // Run the observer
        $this->observer->onFailedRecaptchaLogin($observer);
        
        $username = Mage::getSingleton('customer/session')->getUsername();
        
        $this->assertEquals('user@domain.tld', $username);
    }

    /* ----- MOCK OBJECTS ----- */

    protected function getMockResponse()
    {
        // Mock Response
        $response = $this->getMockBuilder('Zend_Controller_Response_Abstract')
            ->disableOriginalConstructor()
            ->setMethods(array('setRedirect'))
            ->getMock();

        return $response;
    }

    protected function getMockRequest()
    {
        $request = $this->getMockBuilder('Zend_Controller_Request_Abstract')
            ->disableOriginalConstructor()
            ->setMethods(array('setDispatched', 'isPost', 'getPost'))
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
            ->setMethods(array('getResponse', 'getRequest', 'setFlag', 'getFullActionName'))
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
            'isEnabled', 'getSiteKey', 'getSecretKey', 'getTheme', 'getType', 'getSize', 'isAllowed'
        ), false, array(), null, false);

        return $helper;
    }

    protected function getMockRedirectHelper()
    {
        $helper = $this->getHelperMock('studioforty9_recaptcha/redirect', array('getUrl'), false, array(), null, false);

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
}
