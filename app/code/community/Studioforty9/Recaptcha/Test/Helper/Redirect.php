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
 * Studioforty9_Recaptcha_Test_Helper_Redirect
 *
 * @category   Studioforty9
 * @package    Studioforty9_Recaptcha
 * @subpackage Test
 * @author     StudioForty9 <info@studioforty9.com>
 */
class Studioforty9_Recaptcha_Test_Helper_Redirect extends EcomDev_PHPUnit_Test_Case
{
    /** @var Studioforty9_Recaptcha_Test_Helper_Redirect $helper */
    protected $helper;

    public function setUp()
    {
        $this->helper = new Studioforty9_Recaptcha_Helper_Redirect();
    }

    /**
     * @test
     * @group helpers
     * @group Recaptcha
     */
    public function it_automatically_creates_a_session_instance_if_none_is_set()
    {
        $session = $this->getModelMockBuilder('core/session')->disableOriginalConstructor()->getMock();
        $this->replaceByMock('singleton', 'core/session', $session);

        $session = $this->helper->getSession();

        $this->assertInstanceOf('Mage_Core_Model_Session', $session);
    }

    /**
     * @test
     * @group helpers
     * @group Recaptcha
     */
    public function it_can_set_a_different_session_instance()
    {
        $session = $this->getModelMockBuilder('customer/session')->disableOriginalConstructor()->getMock();
        
        $this->helper->setSession($session);
        $session = $this->helper->getSession();
	
        $this->assertInstanceOf('Mage_Customer_Model_Session', $session);
    }

    /**
     * @test
     * @group helpers
     * @group Recaptcha
     */
    public function it_can_get_the_refereral_url_as_a_priority()
    {
        $url = 'http://www.priority.com';
        
        $session = $this->getModelMockBuilder('core/session')
            ->disableOriginalConstructor()
            ->getMock();

        $_SERVER['HTTP_REFERER'] = $url;
        
        $this->helper->setSession($session);
        
        $referer = $this->helper->getUrl();
        
        $this->assertEquals($url, $referer);
    }

    /**
     * @test
     * @group helpers
     * @group Recaptcha
     */
    public function it_can_get_the_referer_param_when_http_referer_is_missing()
    {
        $url = 'http://www.referer-param.com';
        
        $session = $this->getModelMockBuilder('core/session')
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->helper->setSession($session);
        
        Mage::app()->getRequest()->setParam(Mage_Core_Controller_Front_Action::PARAM_NAME_REFERER_URL, $url);
        
        $referer = $this->helper->getUrl();
        
        $this->assertEquals($url, $referer);
    }

    /**
     * @test
     * @group helpers
     * @group Recaptcha
     */
    public function it_can_get_the_referer_base64_url_param_when_referer_param_missing()
    {
        $url = 'http://www.referer-base64.com';
        
        $session = $this->getModelMockBuilder('core/session')
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->helper->setSession($session);
        
        Mage::app()->getRequest()->setParam(Mage_Core_Controller_Front_Action::PARAM_NAME_BASE64_URL, $url);
        
        $referer = $this->helper->getUrl();
        
        $this->assertEquals(Mage::helper('core')->urlDecode($url), $referer);
    }

    /**
     * @test
     * @group helpers
     * @group Recaptcha
     */
    public function it_can_get_the_referer_encoded_url_when_referer_base64_url_param_missing()
    {
        $url = 'http://www.referer-encoded.com';
        
        $session = $this->getModelMockBuilder('core/session')
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->helper->setSession($session);
        
        Mage::app()->getRequest()->setParam(Mage_Core_Controller_Front_Action::PARAM_NAME_URL_ENCODED, $url);
        
        $referer = $this->helper->getUrl();
        
        $this->assertEquals(Mage::helper('core')->urlDecode($url), $referer);
    }

    /**
     * @test
     * @group helpers
     * @group Recaptcha
     */
    public function it_can_use_the_session_last_url_as_a_backup()
    {
        $url = 'http://www.backup.com';
        
        $session = $this->getModelMockBuilder('core/session')
            ->disableOriginalConstructor()
            ->setMethods(array('getLastUrl', 'hasLastUrl'))
            ->getMock();
        
        $session->expects($this->once())->method('getLastUrl')->will($this->returnValue($url));
        $session->expects($this->once())->method('hasLastUrl')->will($this->returnValue(true));
        
        $this->helper->setSession($session);
        
        $referer = $this->helper->getUrl();
        
        $this->assertEquals($url, $referer);
    }

    /**
     * @test
     * @group helpers
     * @group Recaptcha
     */
    public function it_can_use_the_session_visitor_data_as_a_fallback()
    {
        $url = 'http://www.fallback.com';
        $visitorData = array('request_uri' => $url);
        
        $session = $this->getModelMockBuilder('core/session')
            ->disableOriginalConstructor()
            ->setMethods(array('getData'))
            ->getMock();

        $session->expects($this->once())->method('getData')->with($this->equalTo('visitor_data'))->will($this->returnValue($visitorData));
        
        $this->helper->setSession($session);
        
        $referer = $this->helper->getUrl();
        
        $this->assertEquals($url, $referer);
    }

    /**
     * @test
     * @group helpers
     * @group Recaptcha
     */
    public function it_can_use_the_store_base_url_as_a_last_resort()
    {   
        $session = $this->getModelMockBuilder('core/session')
            ->disableOriginalConstructor()
            ->setMethods(array('getData'))
            ->getMock();

        $session->expects($this->once())->method('getData')->with($this->equalTo('visitor_data'))->will($this->returnValue(array()));
        
        $this->helper->setSession($session);
        
        $referer = $this->helper->getUrl();
        
        $this->assertEquals(Mage::getBaseUrl(), $referer);
    }
    
    public function tearDown()
    {
        Mage::app()->getRequest()->setParam(Mage_Core_Controller_Front_Action::PARAM_NAME_REFERER_URL, '');
        Mage::app()->getRequest()->setParam(Mage_Core_Controller_Front_Action::PARAM_NAME_BASE64_URL, '');
        Mage::app()->getRequest()->setParam(Mage_Core_Controller_Front_Action::PARAM_NAME_URL_ENCODED, '');
    }
}
