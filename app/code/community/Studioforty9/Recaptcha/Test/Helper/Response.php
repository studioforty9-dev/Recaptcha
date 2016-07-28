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
 * Studioforty9_Recaptcha_Test_Helper_Response
 *
 * @category   Studioforty9
 * @package    Studioforty9_Recaptcha
 * @subpackage Test
 * @author     StudioForty9 <info@studioforty9.com>
 */
class Studioforty9_Recaptcha_Test_Helper_Response extends EcomDev_PHPUnit_Test_Case
{
    /** @var Studioforty9_Recaptcha_Helper_Response $helper */
    protected $helper;

    /**
     * @test
     * @group helpers
     * @group Recaptcha
     */
    public function it_can_construct_with_success_true()
    {
        $helper = new Studioforty9_Recaptcha_Helper_Response(true);
        $this->assertTrue($helper->isSuccess());
    }

    /**
     * @test
     * @group helpers
     * @group Recaptcha
     */
    public function it_can_construct_with_success_false()
    {
        $helper = new Studioforty9_Recaptcha_Helper_Response(false);
        $this->assertTrue($helper->isFailure());
    }

    /**
     * @test
     * @group helpers
     * @group Recaptcha
     */
    public function it_has_correct_error_code_strings()
    {
        $this->assertEquals('missing-input-secret', Studioforty9_Recaptcha_Helper_Response::MISSING_INPUT_SECRET);
        $this->assertEquals('invalid-input-secret', Studioforty9_Recaptcha_Helper_Response::INVALID_INPUT_SECRET);
        $this->assertEquals('missing-input-response', Studioforty9_Recaptcha_Helper_Response::MISSING_INPUT_RESPONSE);
        $this->assertEquals('invalid-input-response', Studioforty9_Recaptcha_Helper_Response::INVALID_INPUT_RESPONSE);
    }

    /**
     * @test
     * @group helpers
     * @group Recaptcha
     */
    public function it_has_correct_error_descriptions()
    {
        $helper = new Studioforty9_Recaptcha_Helper_Response(false);
        
        $this->assertEquals(
            'The secret parameter is missing.', 
            $helper->getErrorDescription(Studioforty9_Recaptcha_Helper_Response::MISSING_INPUT_SECRET)
        );
        $this->assertEquals(
            'The secret parameter is invalid or malformed.', 
            $helper->getErrorDescription(Studioforty9_Recaptcha_Helper_Response::INVALID_INPUT_SECRET)
        );
        $this->assertEquals(
            'The response parameter is missing.', 
            $helper->getErrorDescription(Studioforty9_Recaptcha_Helper_Response::MISSING_INPUT_RESPONSE)
        );
        $this->assertEquals(
            'The response parameter is invalid or malformed.', 
            $helper->getErrorDescription(Studioforty9_Recaptcha_Helper_Response::INVALID_INPUT_RESPONSE)
        );
    }

    /**
     * @test
     * @group helpers
     * @group Recaptcha
     */
    public function it_returns_unknown_error_string_when_something_unknown_is_passed_in()
    {
        $helper = new Studioforty9_Recaptcha_Helper_Response(false);
        $this->assertEquals(
            'Unknown error.', 
            $helper->getErrorDescription('not a real error')
        );
    }

    /**
     * @test
     * @group helpers
     * @group Recaptcha
     */
    public function it_returns_false_when_constructed_with_no_errors()
    {
        $helper = new Studioforty9_Recaptcha_Helper_Response(false);
        $this->assertFalse($helper->hasErrors());
    }

    /**
     * @test
     * @group helpers
     * @group Recaptcha
     */
    public function it_returns_true_when_constructed_with_errors()
    {
        $helper = new Studioforty9_Recaptcha_Helper_Response(false, array(Studioforty9_Recaptcha_Helper_Response::MISSING_INPUT_RESPONSE));
        $this->assertTrue($helper->hasErrors());
    }

    /**
     * @test
     * @group helpers
     * @group Recaptcha
     */
    public function it_returns_expected_descriptions()
    {
        $errorCodes = array(
            Studioforty9_Recaptcha_Helper_Response::MISSING_INPUT_SECRET,
            Studioforty9_Recaptcha_Helper_Response::INVALID_INPUT_SECRET,
            Studioforty9_Recaptcha_Helper_Response::MISSING_INPUT_RESPONSE,
            Studioforty9_Recaptcha_Helper_Response::INVALID_INPUT_RESPONSE
        );
        $helper = new Studioforty9_Recaptcha_Helper_Response(false, $errorCodes);
        $errors = $helper->getErrors();
        
        $this->assertCount(4, $errors);
        $this->assertInternalType('array', $errors);
        $this->assertEquals($errors[0], 'The secret parameter is missing.');
    }
}
