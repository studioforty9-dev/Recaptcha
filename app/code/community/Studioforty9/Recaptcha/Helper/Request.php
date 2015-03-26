<?php
/**
 * Studioforty9_Recaptcha
 *
 * @category  Studioforty9
 * @package   Studioforty9_Recaptcha
 * @author    StudioForty9 <info@studioforty9.com>
 * @copyright 2015 StudioForty9 (http://www.studioforty9.com)
 * @license   https://github.com/studioforty9/recaptcha/blob/master/LICENCE BSD
 * @version   1.2.0
 * @link      https://github.com/studioforty9/recaptcha
 */

/**
 * Studioforty9_Recaptcha_Helper_Request
 *
 * @category   Studioforty9
 * @package    Studioforty9_Recaptcha
 * @subpackage Helper
 * @author     StudioForty9 <info@studioforty9.com>
 */
class Studioforty9_Recaptcha_Helper_Request extends Mage_Core_Helper_Abstract
{
    const REQUEST_URL = 'https://www.google.com/recaptcha/api/siteverify';
    const REQUEST_RESPONSE = 'g-recaptcha-response';

    /**
     * @var Varien_Http_Client $_client
     */
    protected $_client;

    /**
     * Set the client to make the request to recaptca.
     *
     * @param Varien_Http_Client $client The http client to use
     *
     * @return $this
     */
    public function setHttpClient(Varien_Http_Client $client)
    {
        $this->_client = $client;
        return $this;
    }

    /**
     * Get the Http Client to use for the request to reCAPTCHA
     *
     * @return Varien_Http_Client
     */
    public function getHttpClient()
    {
        if (is_null($this->_client)) {
            $this->_client = new Varien_Http_Client();
        }
        
        $this->_client->setUri(self::REQUEST_URL);

        return $this->_client;
    }

    /**
     * Verify the details of the recaptcha request.
     *
     * @return Studioforty9_Recaptcha_Helper_Response
     */
    public function verify()
    {
        $params = array(
            'secret'   => $this->_getHelper()->getSecretKey(),
            'response' => $this->_getRequest()->getPost(self::REQUEST_RESPONSE),
            'remoteip' => $this->_getRequest()->getClientIp(true)
        );
        
        $client = $this->getHttpClient();
        $client->setParameterGet($params);
        $errors = array();

        try {
            $response = $client->request('GET');
            $data = Mage::helper('core')->jsonDecode($response->getBody());
            if (array_key_exists('error-codes', $data)) {
                $errors = $data['error-codes'];
            }
        } catch (Exception $e) {
            $data = array('success' => false);
            Mage::logException($e);
        }

        return new Studioforty9_Recaptcha_Helper_Response($data['success'], $errors);
    }

    /**
     * Get the module data helper.
     *
     * @codeCoverageIgnore
     * @return Studioforty9_Recaptcha_Helper_Data
     */
    protected function _getHelper()
    {
        return Mage::helper('studioforty9_recaptcha');
    }
}
