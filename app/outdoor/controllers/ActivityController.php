<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Outdoor\Controllers;
/**
 * Description of ActivityContorller
 *
 * @author neo
 */
class ActivityController extends OutdoorController {
    public function initialize()
    {
        $this->tag->setTitle('- Activity');
        parent::initialize();
        date_default_timezone_set('Asia/Harbin');
    }
	
    public function indexAction()
    {
        $this->view->activitys = \Outdoor\Models\Activity::find();
    }
    public function detailAction($id)
    {
        if($id){
            $this->view->activity = \Outdoor\Models\Activity::findById($id);
        }
    }
    public function categoryAction($category)
    {
        if($category){
            $this->view->activitys = \Outdoor\Models\Activity::find(array(
                array('category'=>$category),
            ));
            $this->view->partial("activity/index");
        }
        
    }
    public function createAction(){
        if(!$this->session->get('username')){
            $this->response->redirect("member/signin");
        }
        $this->view->activity = null;
    }
    public function changeAction($id = null){
        if(!$this->session->get('username')){
            $this->response->redirect("member/signin");
        }
        if ($this->request->isPost() == true) {
            $this->view->disable();
//            if($id){
//                $id = $this->request->getPost('id');
//            }
            if($id){
                $activity = \Outdoor\Models\Activity::findById($id);
            }else{
                $activity = new \Outdoor\Models\Activity();
            }
            $activity->username     = $this->session->get('username');
            $activity->category     = $this->request->getPost('category');
            $activity->title        = $this->request->getPost('title');
            $activity->province     = $this->request->getPost('province');
            $activity->city         = $this->request->getPost('city');
            $activity->county       = $this->request->getPost('county');
            $activity->coordinate   = $this->request->getPost('coordinate');
            $activity->begin        = $this->request->getPost('begin');
            $activity->end          = $this->request->getPost('end');
            $activity->content      = $this->request->getPost('content');
            if($activity->save()){
                $this->response->redirect("outdoor/activity/change/".$id);
            }
            
//            $message = new \Radio\Models\Message();
//            $message->datetime = date('Y-m-d H:i:s');
//            if($id){
//                $message->content = sprintf("%s %s 信标台，频率 %s 参数更新了！", $activity->province, $activity->city, $activity->callsign, $activity->frequency);
//            }else{
//                $message->content = sprintf("%s %s %s 信标台，频率 %s 快来看看吧！", $activity->province, $activity->city, $activity->callsign, $activity->frequency);
//            }
//            $message->save();
        }
        $this->view->activity = \Outdoor\Models\Activity::findById($id);
    }
    public function removeAction(){
        if(!$this->session->get('username')){
            $this->response->redirect("member/signin");
        }
    }
}
