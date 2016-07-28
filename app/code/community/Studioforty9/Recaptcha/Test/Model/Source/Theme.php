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
class Studioforty9_Recaptcha_Test_Model_Source_Theme extends EcomDev_PHPUnit_Test_Case
{
    /** @var Studioforty9_Recaptcha_Model_Source_Theme $observer */
    protected $model;

    public function setUp()
    {
        $this->model = new Studioforty9_Recaptcha_Model_Source_Theme();
    }

    /**
     * @test
     * @group source
     * @group Recaptcha
     */
    public function it_returns_expected_array_items()
    {
        $options = $this->model->toOptionArray();

        $this->assertArrayHasKey('light', $options);
        $this->assertArrayHasKey('dark', $options);

        $this->assertEquals('Light', $options['light']);
        $this->assertEquals('Dark', $options['dark']);
    }
}
