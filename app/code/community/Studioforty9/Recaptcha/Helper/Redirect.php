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
 * Studioforty9_Recaptcha_Helper_Redirect
 *
 * @category   Studioforty9
 * @package    Studioforty9_Recaptcha
 * @subpackage Helper
 * @author     StudioForty9 <info@studioforty9.com>
 */
class Studioforty9_Recaptcha_Helper_Redirect extends Mage_Core_Helper_Abstract
{
    /** @var Mage_Core_Model_Session $_session */
    protected $_session;
		
    /**
     * Set the session object.
     *
     * @param Mage_Core_Model_Session $$session
     * @return self
     */
    public function setSession(Mage_Core_Model_Session_Abstract $session)
    {
    	$this->_session = $session;
        
    	return $this;
    }

    /**
     * Get the session object.
     *
     * @return Mage_Core_Model_Session
     */
    public function getSession()
    {
    	if (is_null($this->_session)) {
            $this->_session = Mage::getSingleton('core/session');
    	}
	
    	return $this->_session;
    }
		
    /**
     * Get the redirect URL.
     *
     * @return string
     */
    public function getUrl()
    {
        $referer = $this->_getRefererUrl();
        
        if (! empty($referer)) {
            return $referer;
    	}

    	if ($this->_session->hasLastUrl()) {
    		return $this->_session->getLastUrl();
    	}

    	return $this->getRequestUri();
    }
    
    /**
     * Identify referer url via all accepted methods: 
     *  - HTTP_REFERER
     *  - Regular
     *  - base64-encoded request param
     *
     * @return string
     */
    protected function _getRefererUrl()
    {
        $request = Mage::app()->getRequest();
        
        $refererUrl = $request->getServer('HTTP_REFERER');
        if ($url = $request->getParam(Mage_Core_Controller_Front_Action::PARAM_NAME_REFERER_URL)) {
            $refererUrl = $url;
        }
        if ($url = $request->getParam(Mage_Core_Controller_Front_Action::PARAM_NAME_BASE64_URL)) {
            $refererUrl = Mage::helper('core')->urlDecode($url);
        }
        if ($url = $request->getParam(Mage_Core_Controller_Front_Action::PARAM_NAME_URL_ENCODED)) {
            $refererUrl = Mage::helper('core')->urlDecode($url);
        }
        
        return $refererUrl;
    }

    /**
     * Get the request URI.
     *
     * @param array $visitorData
     * @return bool
     */
    protected function getRequestUri()
    {
    	$visitorData = $this->_session->getData('visitor_data');

    	return ($this->hasRequestUri($visitorData)) ? $visitorData['request_uri'] : Mage::getBaseUrl();
    }
	
    /**
     * Does the request have a valid request URI.
     *
     * @param array $visitorData
     * @return bool
     */
    protected function hasRequestUri($visitorData)
    {
        return is_array($visitorData) && array_key_exists('request_uri', $visitorData);
    }
}
