<?php
class Hackthon_Pirates_Adminhtml_BoardController extends Mage_Adminhtml_Controller_action
{
	
	public function indexAction() {
		$this->loadLayout();
		$this->_addContent($this->getLayout()->createBlock('hackthon_pirates/adminhtml_board'));
		$this->renderLayout();
	}

	public function editAction()
	{
		 $boardId     = $this->getRequest()->getParam('id');
		 $token  = Mage::getStoreConfig('pirates_options/pirates_group/pirates_inputToken',Mage::app()->getStore());
		$key =  Mage::getStoreConfig('pirates_options/pirates_group/pirates_inputSecret',Mage::app()->getStore());

		 $url = "https://api.trello.com/1/boards/".urlencode($boardId)."/lists?key=".urlencode($key)."&token=".urlencode($token);
		
       $curl = curl_init($url);

		curl_setopt_array($curl, array(
		  CURLOPT_URL => $url,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_HTTPHEADER => array(
		    "cache-control: no-cache",
		    "postman-token: 71838290-8f41-0638-9d77-3fda1bc1ad76"
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);

		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
		  // echo $response;
			$result =(array) json_decode($response,true);
			 $i=0;
          foreach ($result as $data) {

			$list_data[$i]['id'] =$data['id'];
            $list_data[$i]['name']=$data['name'];
            $i++; 
          }
          var_dump($list_data);
          $collection = new Varien_Data_Collection(); 
          if ($result)
          {           
              foreach ($board_data as $row) {
                  $rowObj = new Varien_Object();
                  $rowObj->setData($row);
                  $collection->addItem($rowObj);
              }           
          }

		}
  
        if ($response) {
  
            Mage::register('board_data', $result);
  
            $this->loadLayout();
            $this->_setActiveMenu('hackthon_pirates/items');
            
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Issue Manager'), Mage::helper('adminhtml')->__('Issue Manager'));
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Issues'), Mage::helper('adminhtml')->__('Issues'));
            
            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
            
            $this->_addContent($this->getLayout()->createBlock('hackthon_pirates/adminhtml_board_edit'))
                 ->_addLeft($this->getLayout()->createBlock('hackthon_pirates/adminhtml_board_edit_tabs'));
                
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
		if ( $this->getRequest()->getPost() )
		{
			try {

				$board= $this->getRequest()->getParams();
				$token  = Mage::getStoreConfig('pirates_options/pirates_group/pirates_inputToken',Mage::app()->getStore());
				$key =  Mage::getStoreConfig('pirates_options/pirates_group/pirates_inputSecret',Mage::app()->getStore());

				$url ="https://api.trello.com/1/boards?name=".urlencode($board['name'])."&desc=".urlencode($board['desc'])."&defaultLists=false&defaultLabels=false&key=".urlencode($key)."&token=".urlencode($token);
				$curl = curl_init($url);

				curl_setopt_array($curl, array(
					CURLOPT_URL => $url,
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_ENCODING => "",
					CURLOPT_MAXREDIRS => 10,
					CURLOPT_TIMEOUT => 30,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_CUSTOMREQUEST => "POST",
					CURLOPT_HTTPHEADER => array(
						"cache-control: no-cache",
						"postman-token: 9270deb7-d98c-c04c-6c98-52721e3e6c82"
						),
					));

				$response = curl_exec($curl);
				$err = curl_error($curl);

				curl_close($curl);

				if ($err) {
					echo "cURL Error #:" . $err;
				} else {
					echo $response;
					die();
					
				}
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Board Created  successfully'));
				Mage::getSingleton('adminhtml/session')->setBoardData(false);
				$this->_redirect('*/*/');
				return;
			} catch (Exception $e)
			{
				Mage::getSingleton('adminhtml/session')->addError("Board not created");
//                $e->getMessage() replace this with text for sql error
				Mage::getSingleton('adminhtml/session')->setLimitData($this->getRequest()->getPost());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				return;
			}
		}
		$this->_redirect('*/*/');
	}
}







