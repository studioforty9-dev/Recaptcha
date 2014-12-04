<?php

class Studioforty9_Recaptcha_Test_Helper_Data extends EcomDev_PHPUnit_Test_Case
{
    /** @var Studioforty9_Recaptcha_Helper_Data $helper */
    protected $helper;

    public function setUp()
    {
        $this->helper = new Studioforty9_Recaptcha_Helper_Data();
    }
    
    public function test_isEnabled_returns_correct_state()
    {
        $expected = (bool) Mage::getStoreConfig(Studioforty9_Recaptcha_Helper_Data::MODULE_ENABLED);
        $actual = $this->helper->isEnabled();
        
        $this->assertSame($expected, $actual);
    }

    
    public function test_getSiteKey_returns_correct_value()
    {
        $expected = Mage::getStoreConfig(Studioforty9_Recaptcha_Helper_Data::MODULE_KEY_SITE);
        $actual = $this->helper->getSiteKey();
        
        $this->assertSame($expected, $actual);
    }
    
    public function test_getSecretKey_returns_correct_value()
    {
        $expected = Mage::getStoreConfig(Studioforty9_Recaptcha_Helper_Data::MODULE_KEY_SECRET);
        $actual = $this->helper->getSecretKey();
        
        $this->assertSame($expected, $actual);
    }
}
