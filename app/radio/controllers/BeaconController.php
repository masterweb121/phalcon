<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Radio\Controllers;

/**
 * Description of QrzController
 *
 * @author neo
 */
class BeaconController extends \Phalcon\Mvc\Controller {
    public function initialize()
    {
        $this->view->setTemplateAfter('theme');
		//Set the document title
        $this->tag->setTitle('Radio - Beacon');
        //parent::initialize();
        $this->view->menu = new \Radio\Component\Menu($this->dispatcher->getControllerName(), $this->dispatcher->getActionName());
        // 中继列表
        $this->stations = \Radio\Models\Beacon::find(array('fields' => array('name','frequency','callsign','coordinate','description')));
    }
    public function indexAction(){
        $this->tag->appendTitle('');
        $this->view->stations = $this->stations;
    }
    public function detailsAction($id = null){
        $this->view->beacon = null;
        if($id){
            $this->view->beacon = \Radio\Models\Beacon::findById($id);;
        }
        $this->view->stations = $this->stations;        
        //$this->view->pick('repeater/index');
    }
    public function mgmtAction($id){
        //$this->view->setTemplateAfter('maximize');
        if(!$this->session->get('callsign')){
            $this->response->redirect("member/signin");
        }
        $this->tag->setTitle('Radio');
        $this->view->callsign = $this->session->get('callsign');
        
        $this->view->beacon = null;
        if($id){
            $this->view->id = $id;
        }else{
            $this->view->id = null;
        }
        
        if ($this->request->isPost() == true) {
            //$this->view->beacon = (Object)$this->request->getPost();
            if($id){
                $beacon = \Radio\Models\Beacon::findById($id);
            }else{
                $beacon = new \Radio\Models\Beacon();
            }
            $beacon->callsign = $this->request->getPost('callsign');
            $beacon->name     = $this->request->getPost('name');
            $beacon->province = $this->request->getPost('province');
            $beacon->city     = $this->request->getPost('city');
            $beacon->frequency= $this->request->getPost('frequency');
            $beacon->watt     = $this->request->getPost('watt');
            $beacon->band     = $this->request->getPost('band');
            $beacon->coordinate = $this->request->getPost('coordinate');
            $beacon->image    = $this->request->getPost('image');
            $beacon->description   = $this->request->getPost('description');
            $beacon->status   = $this->request->getPost('status');
            $beacon->zone     = array('cq' => $this->request->getPost('cq'), 'itu' => $this->request->getPost('itu'));
            $beacon->save();
            
            $message = new \Radio\Models\Message();
            $message->datetime = date('Y-m-d H:i:s');
            if($id){
                $message->content = sprintf("%s %s 信标台，频率 %s 参数更新了！", $beacon->province, $beacon->city, $beacon->callsign, $beacon->frequency);
            }else{
                $message->content = sprintf("%s %s %s 信标台，频率 %s 快来看看吧！", $beacon->province, $beacon->city, $beacon->callsign, $beacon->frequency);
            }
            $message->save();
        }
        
        $stations = \Radio\Models\Beacon::find(array('fields' => array('name','frequency')));
        $this->view->stations = $stations;
        
        if($id){
            $beacon = \Radio\Models\Beacon::findById($id);
            //  'fields' => array('owner','province','city','frequency','shift','tone','code','coordinate','status')
            $this->view->beacon = $beacon;
        }
    }
}
