<?php

class Studioforty9_Recaptcha_Helper_Response extends Mage_Core_Helper_Abstract
{
    const MISSING_INPUT_SECRET   = 'missing-input-secret';
    const INVALID_INPUT_SECRET   = 'invalid-input-secret';
    const MISSING_INPUT_RESPONSE = 'missing-input-response';
    const INVALID_INPUT_RESPONSE = 'invalid-input-response';

    /**
     * @var bool $_success
     */
    protected $_success = false;

    /**
     * @var array $_errorCodes
     */
    protected $_errorCodes = array();

    /**
     * @var array $_errorDescriptions
     */
    protected $_errorDescriptions = array(
        self::MISSING_INPUT_SECRET   => 'The secret parameter is missing.',
        self::INVALID_INPUT_SECRET   => 'The secret parameter is invalid or malformed.',
        self::MISSING_INPUT_RESPONSE => 'The response parameter is missing.',
        self::INVALID_INPUT_RESPONSE => 'The response parameter is invalid or malformed.'
    );

    /**
     * The constructor allows for a shortcut method of setting the $success and
     * $errorCodes properties.
     *
     * @param bool $success
     * @param array $errorCodes
     */
    public function __construct($success, $errorCodes = array())
    {
        $this->setSuccess($success);
        $this->setErrorCodes($errorCodes);
    }

    /**
     * Set the success flag.
     *
     * @param bool $success
     * @return $this
     */
    public function setSuccess($success)
    {
        $this->_success = $success;
        return $this;
    }

    /**
     * Set the array of error codes from the response.
     *
     * @param array $errorCodes
     * @return $this
     */
    public function setErrorCodes($errorCodes)
    {
        $this->_errorCodes = $errorCodes;
        return $this;
    }

    /**
     * Is the response a success.
     *
     * @return bool
     */
    public function isSuccess()
    {
        return ($this->_success === true);
    }

    /**
     * Is the response a failure.
     *
     * @return bool
     */
    public function isFailure()
    {
        return !$this->isSuccess();
    }

    /**
     * Are there any errors passed in from the response.
     *
     * @return bool
     */
    public function hasErrors()
    {
        return !empty($this->_errorCodes);
    }

    /**
     * An array of descriptive errors.
     *
     * @return array
     */
    public function getErrors()
    {
        $errors = array();
        foreach ($this->_errorCodes as $errorCode) {
            $errors[] = $this->getErrorDescription($errorCode);
        }

        return $errors;
    }

    /**
     * Get the error description.
     *
     * @param string $errorCode
     * @return string
     */
    public function getErrorDescription($errorCode)
    {
        if (!array_key_exists($errorCode, $this->_errorDescriptions)) {
            return 'Unknown error.';
        }

        return $this->_errorDescriptions[$errorCode];
    }
}
