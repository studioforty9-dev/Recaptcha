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
 * Studioforty9_Recaptcha_Test_Model_Observer
 *
 * @category   Studioforty9
 * @package    Studioforty9_Recaptcha
 * @subpackage Test
 * @author     StudioForty9 <info@studioforty9.com>
 */
class Studioforty9_Recaptcha_Test_Model_Routes extends EcomDev_PHPUnit_Test_Case
{
    /** @var Studioforty9_Recaptcha_Model_Routes $model */
    protected $model;

    public function setUp()
    {
        $this->model = new Studioforty9_Recaptcha_Model_Routes();
    }
    
    /**
     * @test
     * @group routes
     * @group Recaptcha
     */
    public function it_can_add_a_route()
    {
        $this->model->add('some_fake_action', 'Some fake action');
        
        $route = $this->model->find('some_fake_action');
        
        $this->assertArrayHasKey('value', $route);
        $this->assertArrayHasKey('label', $route);
        
        $this->assertEquals('some_fake_action', $route['value']);
        $this->assertEquals('Some fake action', $route['label']);
    }
    
    /**
     * @test
     * @group routes
     * @group Recaptcha
     */
    public function it_can_remove_a_route()
    {
        $this->model->add('some_fake_action', 'Some fake action');
        
        $this->model->remove('some_fake_action');
        
        $this->assertCount(0, $this->model);
    }
    
    /**
     * @test
     * @group routes
     * @group Recaptcha
     */
    public function it_can_find_a_route()
    {
        $this->model->add('some_fake_action', 'Some fake action');
        
        $route = $this->model->find('some_fake_action');
        
        $this->assertInternalType('array', $route);
    }
    
    /**
     * @test
     * @group routes
     * @group Recaptcha
     * @expectedException Exception
     * @expectedExceptionMessage some_fake_action could not be found or was not allocated.
     */
    public function it_throws_an_exception_when_a_route_cannot_be_found()
    {
        $this->model->add('some_fake_action', 'Some fake action');
        
        $this->model->remove('some_fake_action');
        
        $this->model->find('some_fake_action');
    }
    
    /**
     * @test
     * @group routes
     * @group Recaptcha
     */
    public function it_can_count_all_routes()
    {
        $this->model->add('route_action_one', 'Route Action One');
        $this->model->add('route_action_two', 'Route Action Two');
        
        $this->assertCount(2, $this->model);
    }
    
    /**
     * @test
     * @group routes
     * @group Recaptcha
     */
    public function it_can_clear_all_routes()
    {
        $this->model->add('route_action_one', 'Route Action One');
        $this->model->add('route_action_two', 'Route Action Two');
        
        $this->assertCount(2, $this->model);
        
        $this->model->clear();
        
        $this->assertCount(0, $this->model);
    }
    
    /**
     * @test
     * @group routes
     * @group Recaptcha
     */
    public function it_can_cast_routes_to_an_array()
    {
        $this->model->add('route_action_one', 'Route Action One');
        
        $array = $this->model->toArray();
        $this->assertInternalType('array', $array);
        $this->assertArrayNotHasKey('route_action_one', $array);
    }
}
