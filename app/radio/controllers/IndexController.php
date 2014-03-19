<?php
namespace Radio\Controllers;
class IndexController extends RadioController {
	public function initialize()
    {
        $this->view->setTemplateAfter('theme');
		//Set the document title
        $this->tag->setTitle('Radio');
        parent::initialize();
    }
	
    public function indexAction()
    {
        if($this->request->get('qrz')){
            $this->view->disable();
            $this->response->redirect("radio/index/qrz/".$this->request->get('qrz'));
        }
		// 消息列表
        $messages = \Radio\Models\Message::find(array(
                'fields' => array('datetime','content'),
                'sort' => array('datetime'=>-1),
                'limit' => 50
            ));
        $this->view->messages = $messages; 
    }
    public function qrzAction($callsign){
        if($this->request->get('qrz')){
            $this->view->disable();
            $this->response->redirect("radio/index/qrz/".$this->request->get('qrz'));
        }
        $member = \Member::findFirst(array(
                'fields' => array('username','name','callsign'),
                array("callsign" => $callsign)
        ));
        $this->view->qrz = $member;
        
        date_default_timezone_set('UTC'); 
        $message = new \Radio\Models\Message();
        $message->datetime = date('Y-m-d H:i:s');
        $message->content = sprintf("%s 您的呼号被查询了一次.", $callsign);
        $message->save();
    }
    public function brandAction(){
        $this->view->disable();
        print(json_encode(
            array("Yaesu",'Icom', "Kenwood",'Alinco', "Motorola",'Hytera')
        ));

    }
    public function transceiverAction(){
        $this->view->disable();
        $brand = $this->request->get('brand');
        $transceiver = array(
            'Yaesu' => array('FT-60R','FT-7800R'),
            'Icom' => array('T90','IC-7200'),
            'Kenwood' => array('71A','D710'),
        );
        print(json_encode($transceiver[$brand]));
    }
    public function antbrandAction(){
        $this->view->disable();
        print(json_encode(
            array("Diamond",'Nagoya', "Eagle" /*'Icom', "Kenwood"=>'Kenwood'*/)
        ));
    }
    public function antennaAction(){
        $this->view->disable();
        $brand = $this->request->get('brand');
        $transceiver = array(
            'Diamond' => array('770H','710H'),
            'Nagoya' => array('79EL-3W','Nagoya 770H'),
            'Eagle' => array('71A','D710'),
        );
        print(json_encode($transceiver[$brand]));
    }
    public function provinceAction(){
       $area = new \Radio\Components\Area();
       $this->view->disable();
       print($area->province());
    }
    public function cityAction($province = null){
       if(empty($province)){
           $province = $this->request->get('province');
       }
       $area = new \Radio\Components\Area();
       $this->view->disable();
       print($area->city($province));
    }
    public function countyAction($province = null){
        $province = $this->request->get('province');
        $city = $this->request->get('city');
        $area = new \Radio\Components\Area();
        $this->view->disable();
        print($area->county($province,$city));
    }
}
