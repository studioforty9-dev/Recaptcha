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
 * Mock_Http_Client
 *
 * @category   Studioforty9
 * @package    Studioforty9_Recaptcha
 * @subpackage Test
 * @author     StudioForty9 <info@studioforty9.com>
 */
class Mock_Http_Client extends Varien_Http_Client
{
    protected function _trySetCurlAdapter()
    {
        $this->setAdapter(new Zend_Http_Client_Adapter_Test());
        return $this;
    }
}

/**
 * Studioforty9_Recaptcha_Test_Helper_Request
 *
 * @category   Studioforty9
 * @package    Studioforty9_Recaptcha
 * @subpackage Test
 * @author     StudioForty9 <info@studioforty9.com>
 */
class Studioforty9_Recaptcha_Test_Helper_Request extends EcomDev_PHPUnit_Test_Case
{
    /** @var Studioforty9_Recaptcha_Helper_Request $helper */
    protected $helper;

    /**
     * Set up the test case by assigning the helper as a member property.
     */
    public function setUp()
    {
        $this->helper = new Studioforty9_Recaptcha_Helper_Request();
    }

    /**
     * @test
     * @group helpers
     * @group Recaptcha
     */
    public function it_returns_expected_object_when_set_by_user()
    {
        $this->helper->setHttpClient(new Mock_Http_Client());
        $this->assertInstanceOf('Mock_Http_Client', $this->helper->getHttpClient());
    }

    /**
     * @test
     * @group helpers
     * @group Recaptcha
     */
    public function it_returns_expected_object_when_not_set_by_user()
    {
        $this->assertInstanceOf('Zend_Http_Client', $this->helper->getHttpClient());
    }

    /**
     * @test
     * @group helpers
     * @group Recaptcha
     */
    public function it_reports_errors_when_verified_with_missing_secret_key()
    {
        // Create a mock request object and replace the one stored in the registry
        $mockResponse = $this->getMockResponse('{"success":false,"error-codes":["missing-input-secret"]}');
        $mockRequest  = $this->getMockRequest($mockResponse);
        
        // Create a mock client object and set it on the object
        $this->helper->setHttpClient($mockRequest);
        $response = $this->helper->verify();
        
        $this->assertInstanceOf('Studioforty9_Recaptcha_Helper_Response', $response);
        $this->assertFalse($response->isSuccess());
        $this->assertTrue($response->hasErrors());
        $errors = $response->getErrors();
        $this->assertEquals('The secret parameter is missing.', $errors[0]);
    }

    /**
     * @test
     * @group helpers
     * @group Recaptcha
     */
    public function it_verifies_using_a_post_request()
    {
        $mockResponse = $this->getMockResponse('{"success":false,"error-codes":["missing-input-secret"]}');
        $mockRequest = $this->getMockBuilder('Mock_Http_Client')
            ->disableOriginalConstructor()
            ->setMethods(array('request', 'setParameterPost'))
            ->getMock();

        $mockRequest->expects($this->once())
            ->method('setParameterPost');

        $mockRequest->expects($this->once())
            ->method('request')
            ->with($this->stringContains('POST'))
            ->will($this->returnValue($mockResponse));

        $this->helper->setHttpClient($mockRequest);
        $this->helper->verify();
    }

    /**
     * @test
     * @group helpers
     * @group Recaptcha
     */
    public function it_reports_errors_when_verified_with_invalid_secret_key()
    {
        // Create a mock request object and replace the one stored in the registry
        Mage::app()->getRequest()->setPost(Studioforty9_Recaptcha_Helper_Request::REQUEST_RESPONSE, 'test');
        $mockResponse = $this->getMockResponse('{"success":false,"error-codes":["invalid-input-secret"]}');
        $mockRequest  = $this->getMockRequest($mockResponse);
        
        // Create a mock client object and set it on the object
        $this->helper->setHttpClient($mockRequest);
        $response = $this->helper->verify();
        
        $this->assertInstanceOf('Studioforty9_Recaptcha_Helper_Response', $response);
        $this->assertFalse($response->isSuccess());
        $this->assertTrue($response->hasErrors());
        $errors = $response->getErrors();
        $this->assertEquals('The secret parameter is invalid or malformed.', $errors[0]);
    }

    /**
     * @test
     * @group helpers
     * @group Recaptcha
     */
    public function it_reports_errors_when_verified_with_missing_input_response()
    {
        // Create a mock request object and replace the one stored in the registry
        Mage::app()->getRequest()->setPost(Studioforty9_Recaptcha_Helper_Request::REQUEST_RESPONSE, 'test');
        $mockResponse = $this->getMockResponse('{"success":false,"error-codes":["missing-input-response"]}');
        $mockRequest  = $this->getMockRequest($mockResponse);
        
        // Create a mock client object and set it on the object
        $this->helper->setHttpClient($mockRequest);
        $response = $this->helper->verify();
        
        $this->assertInstanceOf('Studioforty9_Recaptcha_Helper_Response', $response);
        $this->assertFalse($response->isSuccess());
        $this->assertTrue($response->hasErrors());
        $errors = $response->getErrors();
        $this->assertEquals('The response parameter is missing.', $errors[0]);
    }

    /**
     * @test
     * @group helpers
     * @group Recaptcha
     */
    public function it_cannot_verify_with_invalid_input_response()
    {
        // Create a mock request object and replace the one stored in the registry
        Mage::app()->getRequest()->setPost(Studioforty9_Recaptcha_Helper_Request::REQUEST_RESPONSE, 'test');
        $mockResponse = $this->getMockResponse('{"success":false,"error-codes":["invalid-input-response"]}');
        $mockRequest  = $this->getMockRequest($mockResponse);
        
        // Create a mock client object and set it on the object
        $this->helper->setHttpClient($mockRequest);
        $response = $this->helper->verify();
        
        $this->assertInstanceOf('Studioforty9_Recaptcha_Helper_Response', $response);
        $this->assertFalse($response->isSuccess());
        $this->assertTrue($response->hasErrors());
        $errors = $response->getErrors();
        $this->assertEquals('The response parameter is invalid or malformed.', $errors[0]);
    }

    /**
     * @test
     * @group helpers
     * @group Recaptcha
     */
    public function it_returns_the_correct_response_object_when_an_exception_occurs_during_verification()
    {
        // Create a mock request object and replace the one stored in the registry
        Mage::app()->getRequest()->setPost(Studioforty9_Recaptcha_Helper_Request::REQUEST_RESPONSE, 'test');
        $mockResponse = $this->getMockBuilder('Zend_Http_Response')
            ->disableOriginalConstructor()
            ->setMethods(array('getBody'))
            ->getMock();
        
        $mockResponse->expects($this->any())->method('getBody')->will($this->throwException(new \Exception('Some error message')));
        $mockRequest = $this->getMockRequest($mockResponse);
        
        // Create a mock client object and set it on the object
        $this->helper->setHttpClient($mockRequest);
        $response = $this->helper->verify();
        
        $this->assertInstanceOf('Studioforty9_Recaptcha_Helper_Response', $response);
        $this->assertFalse($response->isSuccess());
    }



    /**
     * Get a mock response object with the body value already set.
     *
     * @param string $body
     * @return Zend_Http_Response
     */
    protected function getMockResponse($body)
    {
        $response = $this->getMockBuilder('Zend_Http_Response')
            ->disableOriginalConstructor()
            ->setMethods(array('getBody'))
            ->getMock();

        $response->expects($this->any())->method('getBody')->will($this->returnValue($body));

        return $response;
    }

    /**
     * Get a mock request object with the response value already set.
     *
     * @param string $response
     * @return Mock_Http_Client
     */
    protected function getMockRequest($response)
    {
        $client = $this->getMockBuilder('Mock_Http_Client')
            ->disableOriginalConstructor()
            ->setMethods(array('request'))
            ->getMock();

        $client->expects($this->any())->method('request')->will($this->returnValue($response));

        return $client;
    }
}
