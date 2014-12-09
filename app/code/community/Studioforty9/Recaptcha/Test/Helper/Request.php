<?php

class Mock_Http_Client extends Varien_Http_Client
{
    protected function _trySetCurlAdapter()
    {
        $this->setAdapter(new Zend_Http_Client_Adapter_Test());
        return $this;
    }
}

class Studioforty9_Recaptcha_Test_Helper_Request extends EcomDev_PHPUnit_Test_Case
{
    /** @var Studioforty9_Recaptcha_Helper_Request $helper */
    protected $helper;
    
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

    public function setUp()
    {
        $this->helper = new Studioforty9_Recaptcha_Helper_Request();
    }
    
    public function test_getHttpClient_returns_expected_object_when_set()
    {
        $this->helper->setHttpClient(new Mock_Http_Client());
        $this->assertInstanceOf('Mock_Http_Client', $this->helper->getHttpClient());
    }
    
    public function test_getHttpClient_returns_expected_object_when_not_set()
    {
        $this->assertInstanceOf('Varien_Http_Client', $this->helper->getHttpClient());
    }
    
    public function test_verify_with_missing_secret_key()
    {
        // Create a mock request object and replace the one stored in the registry
        Mage::app()->getRequest()->setPost(Studioforty9_Recaptcha_Helper_Request::REQUEST_RESPONSE_INDEX, 'test');
        $mockResponse = $this->getMockResponse('{"success":false,"error-codes": ["missing-input-secret"]}');
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
    
    public function test_verify_with_invalid_secret_key()
    {
        // Create a mock request object and replace the one stored in the registry
        Mage::app()->getRequest()->setPost(Studioforty9_Recaptcha_Helper_Request::REQUEST_RESPONSE_INDEX, 'test');
        $mockResponse = $this->getMockResponse('{"success":false,"error-codes": ["invalid-input-secret"]}');
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
    
    public function test_verify_with_missing_input_response()
    {
        // Create a mock request object and replace the one stored in the registry
        Mage::app()->getRequest()->setPost(Studioforty9_Recaptcha_Helper_Request::REQUEST_RESPONSE_INDEX, 'test');
        $mockResponse = $this->getMockResponse('{"success":false,"error-codes": ["missing-input-response"]}');
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
    
    public function test_verify_with_invalid_input_response()
    {
        // Create a mock request object and replace the one stored in the registry
        Mage::app()->getRequest()->setPost(Studioforty9_Recaptcha_Helper_Request::REQUEST_RESPONSE_INDEX, 'test');
        $mockResponse = $this->getMockResponse('{"success":false,"error-codes": ["invalid-input-response"]}');
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
}
