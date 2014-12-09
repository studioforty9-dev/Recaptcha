<?php

class Studioforty9_Recaptcha_Test_Model_Source_Theme extends EcomDev_PHPUnit_Test_Case
{
    /** @var Studioforty9_Recaptcha_Model_Source_Theme $observer */
    protected $model;

    public function setUp()
    {
        $this->model = new Studioforty9_Recaptcha_Model_Source_Theme();
    }

    public function test_toOptionArray_returns_expected_array()
    {
        $options = $this->model->toOptionArray();

        $this->assertArrayHasKey('light', $options);
        $this->assertArrayHasKey('dark', $options);

        $this->assertEquals('Light', $options['light']);
        $this->assertEquals('Dark', $options['dark']);
    }
}
