<?php

$installer = $this;
$installer->startSetup();

$defaultButtonsSelectors = array();
$uniqId = uniqid();
$defaultButtonsSelectors[$uniqId]['routes'] = 'contacts_index';
$defaultButtonsSelectors[$uniqId]['buttons'] = '#contactForm .button:submit';
$uniqId = uniqid();
$defaultButtonsSelectors[$uniqId]['routes'] = 'review_product';
$defaultButtonsSelectors[$uniqId]['buttons'] = '#review-form .button:submit';
$uniqId = uniqid();
$defaultButtonsSelectors[$uniqId]['routes'] = 'customer_account_create';
$defaultButtonsSelectors[$uniqId]['buttons'] = '.account-create #form-validate .button:submit';
$uniqId = uniqid();
$defaultButtonsSelectors[$uniqId]['routes'] = 'sendfriend_product_send';
$defaultButtonsSelectors[$uniqId]['buttons'] = '#product_sendtofriend_form .button:submit';
$uniqId = uniqid();
$defaultButtonsSelectors[$uniqId]['routes'] = 'customer_account_login';
$defaultButtonsSelectors[$uniqId]['buttons'] = '#login-form .button:submit';
$uniqId = uniqid();
$defaultButtonsSelectors[$uniqId]['routes'] = 'customer_account_forgotpassword';
$defaultButtonsSelectors[$uniqId]['buttons'] = '.customer-account-forgotpassword #form-validate .button:submit';

// System Configuration update
$envConfig = array(
    "default" => array(
        "google/recaptcha/buttons_selectors"       	    => serialize($defaultButtonsSelectors)
    )
);
/** @var Mage_Core_Model_Config $coreConfig */
$coreConfig = Mage::getModel('core/config');
// load default
foreach ($envConfig["default"] as $path => $val) {
    $coreConfig->saveConfig($path, $val, 'default', 0);
}

$installer->endSetup();
