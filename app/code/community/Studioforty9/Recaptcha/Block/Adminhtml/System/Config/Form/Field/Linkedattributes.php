<?php

/**
 * Class Studioforty9_Recaptcha_Block_Adminhtml_System_Config_Form_Field_Linkedattributes
 */
class Studioforty9_Recaptcha_Block_Adminhtml_System_Config_Form_Field_Linkedattributes extends Mage_Adminhtml_Block_System_Config_Form_Field_Array_Abstract
{
    protected $optionsArray;

    /**
     *
     */
    public function __construct()
    {
        $this->optionsArray = array();

        $this->addColumn('routes', array(
            'label' => Mage::helper('adminhtml')->__('Route'),
            'size'  => 20,
        ));

        $this->addColumn('parent_block_name', array(
            'label' => Mage::helper('adminhtml')->__('Parent Block Name'),
            'size'  => 20,
        ));
        
        $this->addColumn('buttons', array(
            'label' => Mage::helper('adminhtml')->__('Button Selector'),
            'size'  => 20,
        ));

        $this->_addAfter = false;
        $this->_addButtonLabel = Mage::helper('adminhtml')->__('Add new selector');

        parent::__construct();
        $this->setTemplate('studioforty9/recaptcha/system/config/form/field/array_dropdown.phtml');

        $this->optionsArray['routes'] = array();
        $routes = Mage::getModel('studioforty9_recaptcha/source_routes')->toOptionArray();
        foreach ($routes as $route) {
            $this->optionsArray['routes'][$route['value']] = $route['label'];
        }
    }

    /**
     * @param string $columnName
     * @return string
     * @throws Exception
     */
    protected function _renderCellTemplate($columnName)
    {
        if (empty($this->_columns[$columnName])) {
            throw new Exception('Wrong column name specified.');
        }
        $column     = $this->_columns[$columnName];
        $inputName  = $this->getElement()->getName() . '[#{_id}][' . $columnName . ']';
        if (isset($this->optionsArray[$columnName])){
            $rendered = '<select name="'.$inputName.'">';
            $rendered .= '<option value=""></option>';
            foreach($this->optionsArray[$columnName] as $att => $name)
            {
                $rendered .= '<option value="'.$att.'">'.$name.'</option>';
            }
            $rendered .= '</select>';
        }
        else
        {
            return '<input type="text" class="input-text" name="' . $inputName . '" value="#{' . $columnName . '}" ' . ($column['size'] ? 'size="' . $column['size'] . '"' : '') . '/>';
        }

        return $rendered;
    }
}
