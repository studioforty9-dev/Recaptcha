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
 * Studioforty9_Recaptcha_Model_Routes
 *
 * @category   Studioforty9
 * @package    Studioforty9_Recaptcha
 * @subpackage Model
 * @author     StudioForty9 <info@studioforty9.com>
 */
class Studioforty9_Recaptcha_Model_Routes implements Countable
{
    /** @var array */
    protected $routes = array();
    
    /**
     * Add a route.
     *
     * @param string $route
     * @param string $label
     * @return self
     */
    public function add($route, $label)
    {
        $this->routes[$route] = array(
            'value' => $route,
            'label' => $label,
        );
        
        return $this;
    }
    
    /**
     * Remove a route.
     *
     * @param string $route
     * @return self
     */
    public function remove($route)
    {
        if (array_key_exists($route, $this->routes)) {
            unset($this->routes[$route]);
        }
        
        return $this;
    }
    
    /**
     * Find a route.
     *
     * @param string $route
     * @return array
     */
    public function find($route)
    {
        if (! isset($this->routes[$route])) {
            throw new Exception(
                "$route could not be found or was not allocated."
            );
        }
        
        return $this->routes[$route];
    }
    
    /**
     * Clear all routes.
     *
     * @return self
     */
    public function clear()
    {
        $this->routes = array();
        
        return $this;
    }
    
    /**
     * Count the number routes.
     *
     * @return int
     */
    public function count()
    {
        return count($this->routes);
    }
    
    /**
     * Cast the object to an array.
     *
     * @return aray
     */
    public function toArray()
    {
        return array_values($this->routes);
    }
}
