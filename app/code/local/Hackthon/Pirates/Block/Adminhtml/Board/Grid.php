<?php

class Hackthon_Pirates_Block_Adminhtml_Board_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('boardGrid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }
    
    protected function _prepareCollection()
    {
        $token  = Mage::getStoreConfig('pirates_options/pirates_group/pirates_inputToken',Mage::app()->getStore());
        $key =  Mage::getStoreConfig('pirates_options/pirates_group/pirates_inputSecret',Mage::app()->getStore());
        $UID =  Mage::getStoreConfig('pirates_options/pirates_group/pirates_inputID',Mage::app()->getStore());
        $url ="https://api.trello.com/1/members/".urlencode($UID)."/boards?key=".urlencode($key)."&token=".urlencode($token);
        $curl = curl_init();
        
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
                "postman-token: 183c1d9f-3a3f-18e3-74e7-b152c1d1444f"
            )
        ));
        
        $response = curl_exec($curl);
        $err      = curl_error($curl);
        
        curl_close($curl);
        
        if ($err)
        {
            echo "cURL Error #:" . $err;
        }
        else
        {
          $result = json_decode($response);
          // echo '<pre>' . print_r($result, true) . '</pre>';
         // echo print_r($result['0']['name'],true) ;
          $i=0;
          foreach ($result as $data) {

            $board_data[$i]['name']=$data->name;
            $board_data[$i]['id'] =$data->id;
            $i++; 
          }
            // echo $response;
        }
      $collection = new Varien_Data_Collection(); 
          if ($result)
          {           
              foreach ($board_data as $row) {
                  $rowObj = new Varien_Object();
                  $rowObj->setData($row);
                  $collection->addItem($rowObj);
              }           
          }
    $this->setCollection($collection);
    return parent::_prepareCollection();
    }
    
    protected function _prepareColumns()
    {

        $this->addColumn('id', array(
            'header' => Mage::helper('hackthon_pirates')->__('ID'),
            'width' => '10px',
            'index' => 'id'
        ));
        
        $this->addColumn('name', array(
            'header' => Mage::helper('hackthon_pirates')->__('Name'),
            'align' => 'left',
            'index' => 'name',
            'width' => '50px'
        ));
        
        
        // $this->addColumn('content', array(
        //     'header'    => Mage::helper('employee')->__('Description'),
        //     'width'     => '150px',
        //     'index'     => 'content',
        // ));
        return parent::_prepareColumns();
    }
    
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }
}