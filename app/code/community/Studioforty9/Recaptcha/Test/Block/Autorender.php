<?php

class Studioforty9_Recaptcha_Test_Block_Autorender extends EcomDev_PHPUnit_Test_Case
{
    /** @var Studioforty9_Recaptcha_Block_Autorender */
    protected $block;

    public function setUp()
    {
        $this->block = new Studioforty9_Recaptcha_Block_Autorender();
    }

    public function test_getRecaptchaScript_returns_expected_script_html()
    {
        $expected = '<script src="https://www.google.com/recaptcha/api.js"></script>';
        $actual = $this->block->getRecaptchaScript();
        $this->assertEquals($expected, $actual);
    }

    public function test_getRecaptchaHtml_returns_expected_html()
    {
        $theme = Mage::helper('studioforty9_recaptcha')->getTheme();
        $siteKey = Mage::helper('studioforty9_recaptcha')->getSiteKey();
        $expected = sprintf('<div class="g-recaptcha" data-theme="%s" data-sitekey="%s"></div>', $theme, $siteKey);
        $actual = $this->block->getRecaptchaHtml();
        $this->assertEquals($expected, $actual);
    }
}
