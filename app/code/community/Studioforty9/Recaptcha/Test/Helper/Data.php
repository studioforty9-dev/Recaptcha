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
 * Studioforty9_Recaptcha_Test_Helper_Data
 *
 * @category   Studioforty9
 * @package    Studioforty9_Recaptcha
 * @subpackage Test
 * @author     StudioForty9 <info@studioforty9.com>
 */
class Studioforty9_Recaptcha_Test_Helper_Data extends EcomDev_PHPUnit_Test_Case
{
    /** @var Studioforty9_Recaptcha_Helper_Data $helper */
    protected $helper;

    public function setUp()
    {
        $this->helper = new Studioforty9_Recaptcha_Helper_Data();
    }

    /**
     * @test
     * @group helpers
     * @group Recaptcha
     */
    public function it_can_get_enabled_routes_as_an_array()
    {
        $routes = $this->helper->getEnabledRoutes();
	
        $this->assertInternalType('array', $routes);
    }

    /**
     * @test
     * @group wip
     * @group helpers
     * @group Recaptcha
     * @loadFixture config
     */
    public function it_returns_an_empty_array_when_no_routes_are_configured()
    {
        // We have to reset the routes in order to run this test
        $keyRoutes = Studioforty9_Recaptcha_Helper_Data::MODULE_KEY_ROUTES;
        $oldRoutes = Mage::getStoreConfig($keyRoutes);
        Mage::app()->getStore(0)->setConfig($keyRoutes, ',,,');

        $routes = $this->helper->getEnabledRoutes();

        $this->assertInternalType('array', $routes);
        $this->assertEmpty($routes);

        Mage::app()->getStore(0)->setConfig($keyRoutes, $oldRoutes);
    }
}
