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
        //parent::initialize();
        if(!$this->session->get('callsign')){
            $this->response->redirect("member/signin");
        }
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

        if($this->request->isPost()){
            $callsign           = new \Radio\Models\Callsign();
            $callsign->username = $username;
            $callsign->callsign  = $this->request->getPost("callsign", "string");
            $callsign->description  = $this->request->getPost("description", "string");
//            if($this->request->getPost("default", "string")){
//                
//            }
            $callsign->save();         
        }
        $this->view->callsigns = \Radio\Models\Callsign::find(array(
            'fields' => array('callsign','description'),
            array("username" => $username)
            )); 
    }
    public function equipmentAction(){
		
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
