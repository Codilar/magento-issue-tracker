<?php

class Hackthon_Pirates_Block_Adminhtml_Board_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('board_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('hackthon_pirates')->__('Board Information'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab('form_section1', array(
            'label'     => Mage::helper('hackthon_pirates')->__('Board Information'),
            'title'     => Mage::helper('hackthon_pirates')->__('Board Information'),
            'content'   => $this->getLayout()->createBlock('hackthon_pirates/adminhtml_board_edit_tab_form')->toHtml(),
        ));

        // $this->addTab('form_section2', array(
        //     'label'     => Mage::helper('hackthon_pirates')->__('Transaction History'),
        //     'title'     => Mage::helper('hackthon_pirates')->__('Transaction History'),
        //     'content'   => $this->getLayout()->createBlock('hackthon_pirates/adminhtml_hackthon_pirates_edit_tab_history')->toHtml()
        // ));

        // $this->addTab('form_section3', array(
        //     'label'     => Mage::helper('hackthon_pirates')->__('Return Payment'),
        //     'title'     => Mage::helper('hackthon_pirates')->__('Return Payment'),
        //     'content'   => $this->getLayout()->createBlock('hackthon_pirates/adminhtml_hackthon_pirates_edit_tab_payment')->toHtml()
        // ));


        return parent::_beforeToHtml();
    }
}