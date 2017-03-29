<?php

class Hackthon_Pirates_Block_Adminhtml_Board_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
//    customer informatio form
    protected function _prepareForm()
    {


        $currencyCode = Mage::app()->getStore()->getCurrentCurrencyCode();
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('board_form', array('legend'=>Mage::helper('hackthon_pirates')->__('Board information')));

        $fieldset->addField('board_name', 'text', array(
            'label'     => Mage::helper('hackthon_pirates')->__('Board Name'),
            'name'      => 'name',
        ));

        $fieldset->addField('desc', 'text', array(
            'label'     => Mage::helper('hackthon_pirates')->__('Board Description'),
            'name'      => 'desc'
        ));
        
        if ( Mage::getSingleton('adminhtml/session')->getCreditData() )
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getCreditData());
            Mage::getSingleton('adminhtml/session')->setCreditData(null);
        }
        elseif ( Mage::registry('board_data') ) {
            $form->setValues(Mage::registry('board_data'));
        }
        return parent::_prepareForm();
    }
}