<?php

class Hackthon_Pirates_Block_Adminhtml_Board_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'hackthon_pirates';
        $this->_controller = 'adminhtml_board';

        $this->_updateButton('save', 'label', Mage::helper('hackthon_pirates')->__('Save Profile'));
//    $this->_updateButton('delete', 'label', Mage::helper('credit')->__('Delete Profile'));
        $this->_removeButton('delete');
    }

    public function getHeaderText()
    {
        if( Mage::registry('board_data') && Mage::registry('board_data')) {
            return Mage::helper('hackthon_pirates')->__("Trello Board  '%s'", $this->htmlEscape(Mage::registry('board_data')));
        } else {
            return Mage::helper('hackthon_pirates')->__('No boards found');
        }
    }
}