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
 * Studioforty9_Recaptcha_Test_Config_Module
 *
 * @category   Studioforty9
 * @package    Studioforty9_Recaptcha
 * @subpackage Test
 * @author     StudioForty9 <info@studioforty9.com>
 */
class Studioforty9_Recaptcha_Test_Config_Module extends EcomDev_PHPUnit_Test_Case_Config
{

    public function test_module_is_in_correct_code_pool()
    {
        $this->assertModuleCodePool('community');
    }


    public function test_module_version_is_correct()
    {
        $this->assertModuleVersion('1.2.0');
    }


    public function test_block_are_configured()
    {
        $this->assertBlockAlias('studioforty9_recaptcha/autorender', 'Studioforty9_Recaptcha_Block_Autorender');
    }


    public function test_models_are_configured()
    {
        $this->assertModelAlias('studioforty9_recaptcha/observer_contacts', 'Studioforty9_Recaptcha_Model_Observer_Contacts');
    }


    public function test_helpers_are_configured()
    {
        $this->assertHelperAlias('studioforty9_recaptcha/data', 'Studioforty9_Recaptcha_Helper_Data');
        $this->assertHelperAlias('studioforty9_recaptcha/request', 'Studioforty9_Recaptcha_Helper_Request');
        $this->assertHelperAlias('studioforty9_recaptcha/response', 'Studioforty9_Recaptcha_Helper_Response');
    }


    public function test_access_granted_for_config_acl()
    {

        $this->assertConfigNodeValue(
            'adminhtml/acl/resources/admin/children/system/children/config/children/google/children/studioforty9_recaptcha/title',
            'ReCaptcha Configuration Settings'
        );
    }

    public function test_config_has_contact_event_observer_defined()
    {
        $this->assertEventObserverDefined(
            'frontend',
            'controller_action_predispatch_contacts_index_post',
            'studioforty9_recaptcha/observer',
            'onPostPreDispatch'
        );
    }

    public function test_config_has_review_event_observer_defined()
    {
        $this->assertEventObserverDefined(
            'frontend',
            'controller_action_predispatch_review_product_post',
            'studioforty9_recaptcha/observer',
            'onPostPreDispatch'
        );
    }

    public function test_config_has_sendfriend_event_observer_defined()
    {
        $this->assertEventObserverDefined(
            'frontend',
            'controller_action_predispatch_sendfriend_product_sendmail',
            'studioforty9_recaptcha/observer',
            'onPostPreDispatch'
        );
    }

    public function test_config_has_customer_registration_event_observer_defined()
    {
        $this->assertEventObserverDefined(
            'frontend',
            'controller_action_predispatch_customer_account_createpost',
            'studioforty9_recaptcha/observer',
            'onPostPreDispatch'
        );
    }

    public function test_layout_updates_are_correct()
    {
        $this->assertLayoutFileDefined('frontend', 'studioforty9_recaptcha.xml', 'studioforty9_recaptcha');
        $this->assertLayoutFileExists('frontend', 'studioforty9_recaptcha.xml', 'default', 'base');
    }

    public function test_translate_nodes_are_correct()
    {
        $this->assertConfigNodeValue(
            'frontend/translate/modules/studioforty9_recaptcha/files/default',
            'Studioforty9_Recaptcha.csv'
        );
    }
}
