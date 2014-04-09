<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Radio\Controllers;

/**
 * Description of NetController
 *
 * @author neo
 */
class NetController extends RadioController {
    public function initialize()
    {
        $this->view->setTemplateAfter('theme');
		//Set the document title
        $this->tag->setTitle('- Net');
        parent::initialize();
    }
    public function indexAction(){
        $this->view->nets = \Radio\Models\Net::find();
    }
    public function logAction($id = null){
        $this->tag->appendTitle(' - radio net log');
        if($id){
            $this->view->checkins = \Radio\Models\Netlog::find(array(
                'fields'=>array('datetime','callsign','rst','qth','device','watt','message'),
                array('netId'=>$id)
                ));
            $this->view->net = \Radio\Models\Net::findById($id);
            
            $coordinates = array();
            foreach($this->view->checkins as $checkin){
                $qth = \Radio\Models\Qth::findFirst(array(
                    'fields' => array('coordinate'),
                    array("callsign" => $checkin->callsign)
                ));
                $coordinates[$checkin->callsign] = $qth->coordinate;
            }
            $this->view->coordinates = $coordinates;
        }else{
            $this->view->checkins = null;
        }
    }
    
    public function startAction(){
        if(!$this->session->get('callsign')){
            $this->response->redirect("member/signin");
        }else{
            $this->view->callsign = $this->session->get('callsign');
        }
        date_default_timezone_set("UTC");

        $this->view->repeater = null;
        $this->tag->appendTitle(' - Starting radio net');
        if($this->request->isPost()){
            $net            = new \Radio\Models\Net();
            $net->callsign  = $this->session->get('callsign');
            $net->datetime  = $this->request->getPost("datetime", "string");
            $net->frequency = $this->request->getPost("frequency", "string");
            $net->host      = $this->request->getPost("host", "string");
            $net->topic     = $this->request->getPost("topic", "string");
            $net->coordinate = $this->request->getPost("coordinate", "string");
            if($net->save()){
                $this->response->redirect("radio/net/checkin/".$net->_id);
            }
        }
        $this->view->nets = \Radio\Models\Net::find();
    }
    public function checkinAction($id){
        if(!$this->session->get('callsign')){
            $this->response->redirect("member/signin");
        }else{
            $this->view->callsign = $this->session->get('callsign');
            $this->view->id =   $id;
        }
        date_default_timezone_set("UTC");
        $this->tag->appendTitle(' - Check In');
        $this->view->net = \Radio\Models\Net::findById($id);
        
        if($this->request->isPost()){
            $net            = new \Radio\Models\Netlog();
            $net->netId    = $id;
            $net->datetime  = date('Y-m-d H:i:s');
            $net->callsign  = $this->request->getPost('callsign', "string");
            $net->rst       = $this->request->getPost("rst", "string");
            $net->qth       = $this->request->getPost("qth", "string");
            $net->device    = $this->request->getPost("device", "string");
            $net->watt      = $this->request->getPost("watt", "string");
            $net->message   = $this->request->getPost("message", "string");
            if($net->save()){
                $this->response->redirect("radio/net/checkin/".$id);
            }
        }
        $this->view->checkins = \Radio\Models\Netlog::find(array(
            'fields'=>array('datetime','callsign','rst','qth','device','watt','message'),
            array('netId'=>$id)
            ));
    }
}
