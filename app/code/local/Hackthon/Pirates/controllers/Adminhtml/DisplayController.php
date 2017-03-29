<?php
  
class Hackthon_Pirates_Adminhtml_DisplayController extends Mage_Adminhtml_Controller_Action
{
  
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('hackthon_pirates/items')
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Issue Manager'), Mage::helper('adminhtml')->__('Issue Manager'));
        return $this;
    }  
    
    public function indexAction() {
        $this->_initAction();   
        $this->loadLayout();   
        $this->_addContent($this->getLayout()->createBlock('hackthon_pirates/adminhtml_display'));
        $this->renderLayout();
    }
  
    public function editAction()
    {
        $issueId     = $this->getRequest()->getParam('id');
        // $issueModel  = Mage::getModel('<module>/<module>')->load($<module>Id);
  
        if ($issueModel->getId() || $issueId == 0) {
  
            Mage::register('pirates_data', $issueModel);
  
            $this->loadLayout();
            $this->_setActiveMenu('hackthon_pirates/items');
            
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Issue Manager'), Mage::helper('adminhtml')->__('Item Manager'));
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Issues'), Mage::helper('adminhtml')->__('Issues'));
            
            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
            
            $this->_addContent($this->getLayout()->createBlock('hackthon_pirates/adminhtml_display_edit'))
                 ->_addLeft($this->getLayout()->createBlock('hackthon_pirates/adminhtml_display_edit_tabs'));
                
            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('hackthon_pirates')->__('Issue does not exist'));
            $this->_redirect('*/*/');
        }
    }
    
    public function newAction()
    {
        $this->_forward('edit');
    }
    
    public function saveAction()
    {
        if ( $this->getRequest()->getPost() ) {
            try {
                $postData = $this->getRequest()->getPost();
                // $issueModel = Mage::getModel('<module>/<module>');
                
                $issueModel->setId($this->getRequest()->getParam('id'))
                    ->setTitle($postData['title'])
                    ->setContent($postData['content'])
                    ->setStatus($postData['status'])
                    ->save();
                
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setPiratesData(false);
  
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setPiratesData($this->getRequest()->getPost());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        $this->_redirect('*/*/');
    }
    
    public function deleteAction()
    {
        if( $this->getRequest()->getParam('id') > 0 ) {
            try {
                $issueModel = Mage::getModel('<module>/<module>');
                
                $issueModel->setId($this->getRequest()->getParam('id'))
                    ->delete();
                    
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }
        $this->_redirect('*/*/');
    }
    /**
     * Product grid for AJAX request.
     * Sort and filter result for example.
     */
    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
               $this->getLayout()->createBlock('hackthon_pirates/adminhtml_display_grid')->toHtml()
        );
    }
} 