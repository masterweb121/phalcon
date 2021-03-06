<?php
namespace Radio\Controllers;
class IndexController extends RadioController {
	public function initialize()
    {
        $this->view->setTemplateAfter('theme');
		//Set the document title
        $this->tag->setTitle('- Home');
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
                'limit' => 20
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
        $this->view->callsigns = \Radio\Models\Callsign::find(array(
            'fields' => array('callsign','description'),
            array("username" => $member->username)
            )); 
        $this->view->qrz = $member;
        
        $this->view->mail = \Radio\Models\Mail::findFirst(array(
                'fields' => array('callsign','addressee','address','zipcode','description'),
                array("callsign" => $callsign)
            )); 
        $this->view->qth = \Radio\Models\Qth::findFirst(array(
                'fields' => array('callsign','address','coordinate','zone','description'),
                array("callsign" => $callsign)
            ));
//        $this->view->callsigns = \Radio\Models\Callsign::find(array(
//            'fields' => array('callsign'),
//            array("username" => $username)
//            )); 
        $this->view->equipments = \Radio\Models\Equipment::find(array(
            'fields' => array('brand','transceiver','antenna'),
            array("callsign" => $callsign)
            )); 
        $this->view->signaling = \Radio\Models\Signaling::findFirst(array(
            'fields' => array('callsign','c4fm','mototrbo','mdc1200','qcii','dtmf','selectv'),
            array("callsign" => $callsign)
            )); 
        
        date_default_timezone_set('UTC'); 
        $who = $this->session->get('callsign');
        $message = new \Radio\Models\Message();
        $message->datetime = date('Y-m-d H:i:s');
        $message->content = sprintf("%s 您的呼号被%s查询了一次.", $callsign, $who);
        $message->save();
    }
    public function brandAction($category){
        $this->view->disable();
        $brands = array(
            'transceiver' => array("Yaesu",'Icom', "Kenwood",'Alinco', "Motorola",'Hytera'),
            'antenna' => array("Diamond",'Nagoya', "Eagle" /*'Icom', "Kenwood"=>'Kenwood'*/),
        );
        print(json_encode(
            $brands[$category]
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
