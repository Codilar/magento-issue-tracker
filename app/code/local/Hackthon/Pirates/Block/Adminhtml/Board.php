<?php
class Hackthon_Pirates_Block_Adminhtml_Board extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_board';
    $this->_blockGroup = 'hackthon_pirates';
    $this->_headerText = Mage::helper('hackthon_pirates')->__('Create New Board');
    $this->_addButtonLabel = Mage::helper('hackthon_pirates')->__('Create Board');
    parent::__construct();
  }
}