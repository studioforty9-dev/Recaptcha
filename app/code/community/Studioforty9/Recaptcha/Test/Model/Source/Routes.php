<?php
/**
 * Studioforty9_Recaptcha
 *
 * @category  Studioforty9
 * @package   Studioforty9_Recaptcha
 * @author    StudioForty9 <info@studioforty9.com>
 * @copyright 2015 StudioForty9 (http://www.studioforty9.com)
 * @license   https://github.com/studioforty9/recaptcha/blob/master/LICENCE BSD
 * @version   1.5.0
 * @link      https://github.com/studioforty9/recaptcha
 */

/**
 * Studioforty9_Recaptcha_Test_Model_Source_Theme
 *
 * @category   Studioforty9
 * @package    Studioforty9_Recaptcha
 * @subpackage Test
 * @author     StudioForty9 <info@studioforty9.com>
 */
class Studioforty9_Recaptcha_Test_Model_Source_Routes extends EcomDev_PHPUnit_Test_Case
{
    /** @var Studioforty9_Recaptcha_Model_Source_Theme $observer */
    protected $model;

    public function setUp()
    {
        $this->model = new Studioforty9_Recaptcha_Model_Source_Routes();
    }

    /**
     * @test
     * @group source
     */
    public function test_toOptionArray_returns_expected_array()
    {
        $options = $this->model->toOptionArray();

        $this->assertInternalType('array', $options);
        
        $this->assertInternalType('array', $options[0]);
        $this->assertArrayHasKey('value', $options[0]);
        $this->assertArrayHasKey('label', $options[0]);
        $this->assertEquals('contacts_index_post', $options[0]['value']);
        $this->assertEquals('Contact Form', $options[0]['label']);
        
        $this->assertInternalType('array', $options[1]);
        $this->assertArrayHasKey('value', $options[1]);
        $this->assertArrayHasKey('label', $options[1]);
        $this->assertEquals('review_product_post', $options[1]['value']);
        $this->assertEquals('Product Review Form', $options[1]['label']);
        
        $this->assertInternalType('array', $options[2]);
        $this->assertArrayHasKey('value', $options[2]);
        $this->assertArrayHasKey('label', $options[2]);
        $this->assertEquals('customer_account_createpost', $options[2]['value']);
        $this->assertEquals('Account Registration Form', $options[2]['label']);
        
        $this->assertInternalType('array', $options[3]);
        $this->assertArrayHasKey('value', $options[3]);
        $this->assertArrayHasKey('label', $options[3]);
        $this->assertEquals('sendfriend_product_sendmail', $options[3]['value']);
        $this->assertEquals('Send to Friend Form', $options[3]['label']);
        
        $this->assertInternalType('array', $options[2]);
        $this->assertArrayHasKey('value', $options[2]);
        $this->assertArrayHasKey('label', $options[2]);
        $this->assertEquals('customer_account_loginpost', $options[2]['value']);
        $this->assertEquals('Login Form', $options[2]['label']);
        
        $this->assertInternalType('array', $options[3]);
        $this->assertArrayHasKey('value', $options[3]);
        $this->assertArrayHasKey('label', $options[3]);
        $this->assertEquals('customer_account_forgotpasswordpost', $options[3]['value']);
        $this->assertEquals('Forgot Password Form', $options[3]['label']);
        
        $this->assertEventDispatched('studioforty9_recaptcha_routes');
    }
}
