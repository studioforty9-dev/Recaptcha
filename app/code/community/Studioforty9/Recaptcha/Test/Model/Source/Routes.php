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
     * @group Recaptcha
     */
    public function test_toOptionArray_returns_expected_array()
    {
        $options = $this->model->toOptionArray();

        $this->assertInternalType('array', $options);
        
        $contacts = $options[0];
        $this->assertInternalType('array', $contacts);
        $this->assertArrayHasKey('value', $contacts);
        $this->assertArrayHasKey('label', $contacts);
        $this->assertEquals('contacts_index', $contacts['value']);
        $this->assertEquals('Contact Form', $contacts['label']);
        
        $review = $options[1];
        $this->assertInternalType('array', $review);
        $this->assertArrayHasKey('value', $review);
        $this->assertArrayHasKey('label', $review);
        $this->assertEquals('review_product', $review['value']);
        $this->assertEquals('Product Review Form', $review['label']);
        
        $register = $options[2];
        $this->assertInternalType('array', $register);
        $this->assertArrayHasKey('value', $register);
        $this->assertArrayHasKey('label', $register);
        $this->assertEquals('customer_account_create', $register['value']);
        $this->assertEquals('Account Registration Form', $register['label']);
        
        $sendfriend = $options[3];
        $this->assertInternalType('array', $sendfriend);
        $this->assertArrayHasKey('value', $sendfriend);
        $this->assertArrayHasKey('label', $sendfriend);
        $this->assertEquals('sendfriend_product_send', $sendfriend['value']);
        $this->assertEquals('Send to Friend Form', $sendfriend['label']);
        
        $login = $options[4];
        $this->assertInternalType('array', $login);
        $this->assertArrayHasKey('value', $login);
        $this->assertArrayHasKey('label', $login);
        $this->assertEquals('customer_account_login', $login['value']);
        $this->assertEquals('Login Form', $login['label']);
        
        $password = $options[5];
        $this->assertInternalType('array', $password);
        $this->assertArrayHasKey('value', $password);
        $this->assertArrayHasKey('label', $password);
        $this->assertEquals('customer_account_forgotpassword', $password['value']);
        $this->assertEquals('Forgot Password Form', $password['label']);
        
        $this->assertEventDispatched('studioforty9_recaptcha_routes');
    }
}
