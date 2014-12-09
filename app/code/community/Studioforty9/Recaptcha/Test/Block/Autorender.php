<?php
/**
 * Studioforty9_Recaptcha
 *
 * @category  Studioforty9
 * @package   Studioforty9_Recaptcha
 * @author    StudioForty9 <info@studioforty9.com>
 * @copyright 2014 StudioForty9 (http://www.studioforty9.com)
 * @license   https://github.com/studioforty9/recaptcha/blob/master/LICENCE BSD
 * @version   1.0.0
 * @link      https://github.com/studioforty9/recaptcha
 */

/**
 * Studioforty9_Recaptcha_Test_Block_Autorender
 *
 * @category   Studioforty9
 * @package    Studioforty9_Recaptcha
 * @subpackage Test
 * @author     StudioForty9 <info@studioforty9.com>
 */
class Studioforty9_Recaptcha_Test_Block_Autorender extends EcomDev_PHPUnit_Test_Case
{
    /** @var Studioforty9_Recaptcha_Block_Autorender */
    protected $block;

    public function setUp()
    {
        $this->block = new Studioforty9_Recaptcha_Block_Autorender();

        parent::setUp();
    }

    protected function getMockDataHelper($enabled, $theme = 'light', $siteKey = '123456789', $secretKey = '987654321')
    {
        $helper = $this->getHelperMock('studioforty9_recaptcha', array(
            'isEnabled', 'getSiteKey', 'getSecretKey', 'getTheme'
        ), false, array(), null, false);

        $helper->expects($this->any())
            ->method('isEnabled')
            ->will($this->returnValue($enabled));


        $helper->expects($this->any())
            ->method('getSiteKey')
            ->will($this->returnValue($siteKey));


        $helper->expects($this->any())
            ->method('getSecretKey')
            ->will($this->returnValue($secretKey));


        $helper->expects($this->any())
            ->method('getTheme')
            ->will($this->returnValue($theme));

        return $helper;
    }

    public function test_getRecaptchaScript_returns_empty_string_when_module_disabled()
    {
        $dataHelper = $this->getMockDataHelper(false);
        $this->replaceByMock('helper', 'studioforty9_recaptcha', $dataHelper);

        $expected = '';
        $actual = $this->block->getRecaptchaScript();
        $this->assertEquals($expected, $actual);
    }

    public function test_getRecaptchaScript_returns_script_tag_html_when_module_enabled()
    {
        $dataHelper = $this->getMockDataHelper(true);
        $this->replaceByMock('helper', 'studioforty9_recaptcha', $dataHelper);

        $expected = '<script src="https://www.google.com/recaptcha/api.js"></script>';
        $actual = $this->block->getRecaptchaScript();
        $this->assertEquals($expected, $actual);
    }

    public function test_getRecaptchaHtml_returns_empty_string_when_module_disabled()
    {
        $dataHelper = $this->getMockDataHelper(false);
        $this->replaceByMock('helper', 'studioforty9_recaptcha', $dataHelper);

        $expected = '';
        $actual   = $this->block->getRecaptchaHtml();
        $this->assertEquals($expected, $actual);
    }

    public function test_getRecaptchaHtml_returns_expected_html_when_module_enabled_using_light_theme()
    {
        $dataHelper = $this->getMockDataHelper(true, 'light');
        $this->replaceByMock('helper', 'studioforty9_recaptcha', $dataHelper);

        $theme    = 'light';
        $siteKey  = '123456789';
        $expected = sprintf('<div class="g-recaptcha" data-theme="%s" data-sitekey="%s"></div>', $theme, $siteKey);
        $actual   = $this->block->getRecaptchaHtml();
        $this->assertEquals($expected, $actual);
    }

    public function test_getRecaptchaHtml_returns_expected_html_when_module_enabled_using_dark_theme()
    {
        $dataHelper = $this->getMockDataHelper(true, 'dark');
        $this->replaceByMock('helper', 'studioforty9_recaptcha', $dataHelper);

        $theme    = 'dark';
        $siteKey  = '123456789';
        $expected = sprintf('<div class="g-recaptcha" data-theme="%s" data-sitekey="%s"></div>', $theme, $siteKey);
        $actual   = $this->block->getRecaptchaHtml();
        $this->assertEquals($expected, $actual);
    }
}
