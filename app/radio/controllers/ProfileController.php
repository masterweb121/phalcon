<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Radio\Controllers;

/**
 * Description of ProfileController
 *
 * @author neo
 */
class ProfileController  extends RadioController {
    public function initialize()
    {
        $this->view->setTemplateAfter('theme');
		//Set the document title
        $this->tag->prependTitle('Radio');
        parent::initialize();
        if(!$this->session->get('username')){
            $this->response->redirect("member/signin");
        }
        if(!$this->session->get('callsign')){
            $this->response->redirect("member?msg=请你设置呼号");
        }
        $this->callsign = $this->session->get('callsign');
        $this->view->stations = null;
        $this->view->callings = null;
    }
    public function indexAction(){
        $callsign = $this->session->get('callsign');
        $username = $this->session->get('username');
        $this->view->mail = \Radio\Models\Mail::findFirst(array(
                'fields' => array('callsign','addressee','address','zipcode','description'),
                array("callsign" => $callsign)
            ));
        $this->view->qth = \Radio\Models\Qth::findFirst(array(
                'fields' => array('callsign','address','coordinate','zone','description'),
                array("callsign" => $callsign)
            ));

        $this->view->repeaters = \Radio\Models\Repeater::find(array(
            'fields' => array('frequency','name'),
            array("callsign" => $callsign),
            ));
        $this->view->loggings = \Radio\Models\Logging::find(
            array(
                array('callsign' => $this->session->get('callsign')),
                'fields' => array('callsign','date','time','frequency','mode','call','rst','watt','notes'),
                "sort" => array("date" => -1),
                'limit' => 5
            )
        );
        /*
        $this->view->callings = \Radio\Models\Logging::find(
            array(
                array('call' => $this->session->get('callsign')),
                'fields' => array('callsign','date','time','frequency','mode','call','rst','watt','notes'),
                'limit' => 100
            )
        );
        */
        $this->view->callsigns = \Radio\Models\Callsign::find(array(
            'fields' => array('callsign','description'),
            array("username" => $username)
            ));
    }
    public function mailAction(){
        if(!$this->session->get('callsign')){
            $this->response->redirect("member/signin");
        }
        date_default_timezone_set("UTC");
        $this->tag->setTitle('Radio Mail Address');

        $this->view->mail = null;
        if($this->request->isPost()){
            $id = $this->request->getPost("id", "string");
            $mail = null;
            if($id){
                $mail        = \Radio\Models\Mail::findById($id);
            }else{
                $mail        = new \Radio\Models\Mail();
            }

            $mail->callsign  = $this->session->get('callsign'); //$this->request->getPost("callsign", "string");
            $mail->addressee = $this->request->getPost("addressee", "string");
            $mail->address   = $this->request->getPost("address", "string");
            $mail->zipcode   = $this->request->getPost("zipcode", "string");
            $mail->description  = $this->request->getPost("description", "string");
            $mail->save();
            //$this->view->logging = (object)$this->request->getPost();

            $message = new \Radio\Models\Message();
            $message->datetime = date('Y-m-d H:i:s');
            $message->content = sprintf("%s 刚刚更新了QSL卡片邮寄地址", $mail->callsign);
            $message->save();
        }

        $callsign = $this->session->get('callsign');
        $mail = \Radio\Models\Mail::findFirst(array(
                'fields' => array('callsign','addressee','address','zipcode','description'),
                array("callsign" => $callsign)
            ));
        if($mail){
            $this->view->mail = $mail;
        }
    }
    public function qthAction(){
        if(!$this->session->get('callsign')){
            $this->response->redirect("member/signin");
        }
        date_default_timezone_set("UTC");
        $this->tag->setTitle('QTH');

        $this->view->qth = null;
        if($this->request->isPost()){
            $id = $this->request->getPost("id", "string");
            $qth = null;
            if($id){
                $qth        = \Radio\Models\Qth::findById($id);
            }else{
                $qth        = new \Radio\Models\Qth();
            }

            $qth->callsign  = $this->session->get('callsign'); //$this->request->getPost("callsign", "string");
            $qth->addressee = $this->request->getPost("addressee", "string");
            $qth->address   = $this->request->getPost("address", "string");
            $qth->coordinate = $this->request->getPost('coordinate');
            $qth->zone     = array('cq' => $this->request->getPost('cq'), 'itu' => $this->request->getPost('itu'));
            $qth->description  = $this->request->getPost("description", "string");
            $qth->save();
            //$this->view->logging = (object)$this->request->getPost();

            $message = new \Radio\Models\Message();
            $message->datetime = date('Y-m-d H:i:s');
            $message->content = sprintf("%s 刚刚更新了Qth设台地址", $qth->callsign);
            $message->save();
        }

        $callsign = $this->session->get('callsign');
        $qth = \Radio\Models\Qth::findFirst(array(
                'fields' => array('callsign','address','coordinate','zone','description'),
                array("callsign" => $callsign)
            ));
        if($qth){
            $this->view->qth = $qth;
        }
    }
    public function callsignAction(){
        $username = $this->session->get('username');
        if($id = $this->request->get('id')){
            //$this->view->disable();
            //echo $id;
            $callsign = \Radio\Models\Callsign::findById($id);
//            array(
//                array('id'=>$id, "username" => $username)
//            )
            //print_r($callsign);
            if ($callsign->username == $username) {
                $callsign->delete();
            }
        }
        if($this->request->isPost()){
            $callsign           = new \Radio\Models\Callsign();
            $callsign->username = $username;
            $callsign->callsign  = $this->request->getPost("callsign", "string");
            $callsign->description  = $this->request->getPost("description", "string");
//            if($this->request->getPost("default", "string")){
//
//            }
            if($callsign->save()){
                $message = new \Radio\Models\Message();
                $message->datetime = date('Y-m-d H:i:s');
                $message->content = sprintf("%s 刚刚设置了呼号", $this->callsign);
                $message->save();
            }
        }
        $this->view->callsigns = \Radio\Models\Callsign::find(array(
            'fields' => array('callsign','description'),
            array("username" => $username)
            ));
    }
    public function equipmentAction(){
		 if($this->request->isPost()){
            $equipment              = new \Radio\Models\Equipment();
            $equipment->callsign    = $this->callsign;
            $equipment->brand       = $this->request->getPost("brand", "string");
            $equipment->transceiver = $this->request->getPost("transceiver", "string");
            $equipment->antenna     = $this->request->getPost("antbrand", "string").' '.$this->request->getPost("antenna", "string");
            if($equipment->save()){
                $message = new \Radio\Models\Message();
                $message->datetime = date('Y-m-d H:i:s');
                $message->content = sprintf("%s 刚刚新增了一个装备 %s", $this->callsign, $equipment->brand.$equipment->transceiver.$equipment->antenna);
                $message->save();
            }
        }
        $this->view->equipments = \Radio\Models\Equipment::find(array(
            'fields' => array('brand','transceiver','antenna'),
            array("callsign" => $this->callsign)
            ));
	}
    public function netAction(){
		$this->view->nets = \Radio\Models\Net::find();
	}
    public function digitalAction(){

	}
    public function signalingAction(){

		if($this->request->isPost()){
            $id = $this->request->getPost("id", "string");
            $signaling = null;
            if($id){
                $signaling        = \Radio\Models\Signaling::findById($id);
            }else{
                $signaling        = new \Radio\Models\Signaling();
            }
            $signaling->callsign    = $this->callsign;
            $signaling->mototrbo    = $this->request->getPost("mototrbo", "string");
            $signaling->mdc1200     = $this->request->getPost("mdc1200", "string");
            $signaling->qcii        = $this->request->getPost("qcii", "string");
            $signaling->dtmf        = $this->request->getPost("dtmf", "string");
            $signaling->selectv     = $this->request->getPost("selectv", "string");
            $signaling->c4fm        = $this->request->getPost("c4fm", "string");
            if($signaling->save()){
                $message = new \Radio\Models\Message();
                $message->datetime = date('Y-m-d H:i:s');
                $message->content = sprintf("%s 刚刚设置了信令", $this->callsign);
                $message->save();
            }
        }
        $this->view->signaling = \Radio\Models\Signaling::findFirst(array(
            'fields' => array('callsign','c4fm','mototrbo','mdc1200','qcii','dtmf','selectv'),
            array("callsign" => $this->callsign)
            ));
	}
    public function loggingAction(){
        if(!$this->session->get('callsign')){
            $this->response->redirect("member/signin");
        }
        date_default_timezone_set("UTC");
        $this->tag->appendTitle(' - Logging - Management');
//        $this->view->setRenderLevel(View::LEVEL_LAYOUT);
        if($this->request->isPost()){
            $logging       = new \Radio\Models\Logging();
            $logging->callsign  = $this->session->get('callsign'); //$this->request->getPost("callsign", "string");
            $logging->date      = $this->request->getPost("date", "string");
            $logging->time      = $this->request->getPost("time", "string");
            $logging->frequency = $this->request->getPost("frequency", "string");
            $logging->mode      = $this->request->getPost("mode", "string");
            $logging->call      = $this->request->getPost("call", "string");
            $logging->rst       = $this->request->getPost("rst", "string");
            $logging->watt      = $this->request->getPost("watt", "string");
            $logging->notes     = $this->request->getPost("notes", "string");
            if($logging->save()){
                $message = new \Radio\Models\Message();
                $message->datetime = date('Y-m-d H:i:s');
                $message->content = $logging->callsign .'与'.$logging->call.'做了一个通联';
                $message->save();
            }
            $this->view->logging = (object)$this->request->getPost();
        }

        $this->view->logging = null;

        $this->view->callsign  = $this->session->get('callsign');
        $callings = \Radio\Models\Logging::find(
            array(
                array('call' => $this->session->get('callsign')),
                'fields' => array('callsign','date','time','frequency','mode','call','rst','watt','notes'),
                'limit' => 100
            )
        );
        $this->view->callings = $callings;
        $loggings = \Radio\Models\Logging::find(
            array(
                array('callsign' => $this->session->get('callsign')),
                'fields' => array('callsign','date','time','frequency','mode','call','rst','watt','notes'),
                "sort" => array("date" => -1),
                'limit' => 100
            )
        );
        $this->view->loggings = $loggings;

        $incoming =  \Radio\Models\Logging::find(array(
                array('call' => $this->session->get('callsign')),
                'fields' => array('callsign','date','time','frequency','mode','call','rst','watt','notes'),
                "sort" => array("date" => -1),
                'limit' => 100
            ));
        $this->view->incoming = $incoming;

        $datalist = array('frequency'=> array('439.460','439.850','438.275','438.200'),
            'rst'=> array('59','59','55','58')
            );
        $this->view->datalist = $datalist;
    }
    public function repeaterAction($id){
        //$this->view->setTemplateAfter('maximize');
        if(!$this->session->get('callsign')){
            $this->response->redirect("member/signin");
        }
        $this->tag->setTitle('Radio');
        $this->view->callsign = $this->session->get('callsign');

        $this->view->repeater = null;
        if($id){
            $this->view->id = $id;
        }else{
            $this->view->id = null;
        }

        if ($this->request->isPost() == true) {
            //$this->view->repeater = (Object)$this->request->getPost();
            if($id){
                $repeater = \Radio\Models\Repeater::findById($id);
            }else{
                $repeater = new \Radio\Models\Repeater();
            }
            $repeater->callsign = $this->request->getPost('callsign');
            $repeater->name     = $this->request->getPost('name');
            $repeater->province = $this->request->getPost('province');
            $repeater->city     = $this->request->getPost('city');
            $repeater->county     = $this->request->getPost('county');
            $repeater->mode      = $this->request->getPost('mode');
            $repeater->timeslot  = $this->request->getPost('timeslot');
            $repeater->color  = $this->request->getPost('color');
            $repeater->frequency= $this->request->getPost('frequency');
            $repeater->shift    = $this->request->getPost('shift');
            $repeater->squelch  = $this->request->getPost('squelch');
            $repeater->code     = $this->request->getPost('code');
            $repeater->band     = $this->request->getPost('band');
            $repeater->coordinate = $this->request->getPost('coordinate');
            $repeater->image    = $this->request->getPost('image');
            $repeater->description   = $this->request->getPost('description');
            $repeater->status   = $this->request->getPost('status');
            $repeater->zone     = array('cq' => $this->request->getPost('cq'), 'itu' => $this->request->getPost('itu'));
            $repeater->save();

            $message = new \Radio\Models\Message();
            $message->datetime = date('Y-m-d H:i:s');
            if($id){
                $message->content = sprintf("%s %s 业余中继台，频率 %s 参数更新了！", $repeater->province, $repeater->city, $repeater->callsign, $repeater->frequency);
            }else{
                $message->content = sprintf("%s %s %s 新增中继站，频率 %s 快来看看吧！", $repeater->province, $repeater->city, $repeater->callsign, $repeater->frequency);
            }
            $message->save();
        }

        $stations = \Radio\Models\Repeater::find(array('fields' => array('name','frequency')));
        $this->view->stations = $stations;

        if($id){
            $repeater = \Radio\Models\Repeater::findById($id);
            //  'fields' => array('owner','province','city','frequency','shift','tone','code','coordinate','status')
            $this->view->repeater = $repeater;
        }
    }
    public function testAction(){
        $this->view->disable();
        print_r($this->dispatcher->getActionName());
//        $this->dispatcher->getControllerName(),
//        $this->dispatcher->getActionName(),
//        $this->dispatcher->getParams()
        //$this->view->menu = new \Radio\Component\Menu($this->dispatcher->getControllerName(), $this->dispatcher->getActionName());
        print_r($this->view->menu->getMenu());
    }
}
