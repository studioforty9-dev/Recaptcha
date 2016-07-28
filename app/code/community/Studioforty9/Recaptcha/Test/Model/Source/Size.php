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
 * Studioforty9_Recaptcha_Test_Model_Source_Size
 *
 * @category   Studioforty9
 * @package    Studioforty9_Recaptcha
 * @subpackage Test
 * @author     StudioForty9 <info@studioforty9.com>
 */
class Studioforty9_Recaptcha_Test_Model_Source_Size extends EcomDev_PHPUnit_Test_Case
{
    /** @var Studioforty9_Recaptcha_Model_Source_Size $observer */
    protected $model;

    public function setUp()
    {
        $this->model = new Studioforty9_Recaptcha_Model_Source_Size();
    }

    /**
     * @test
     * @group source
     * @group Recaptcha
     */
    public function it_returns_expected_array_items()
    {
        $options = $this->model->toOptionArray();

        $this->assertArrayHasKey('normal', $options);
        $this->assertArrayHasKey('compact', $options);

        $this->assertEquals('Normal', $options['normal']);
        $this->assertEquals('Compact', $options['compact']);
    }
}
