<?php

$collection = \Mage::getModel('core/config_data')->getCollection()->addFieldToFilter('path', array('in' => array(
    'google/recaptcha/enabled_contacts',
    'google/recaptcha/enabled_reviews',
    'google/recaptcha/enabled_sendfriend',
    'google/recaptcha/enabled_customer_registration',
)));

foreach ($collection as $model) {
    $model->delete();
}
