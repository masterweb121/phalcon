<?php
namespace Radio\Controllers;
/**
 * Description of RepeaterController
 *
 * @author neo
 */
class RepeaterController extends \Phalcon\Mvc\Controller{
    public function initialize()
    {
        $this->view->setTemplateAfter('theme');
		//Set the document title
        $this->tag->setTitle('Radio - Repeater');
        //parent::initialize();
        //
        // 中继列表
        $this->stations = \Radio\Models\Repeater::find(array('fields' => array('frequency','name')));
    }
    public function indexAction(){
        $this->view->stations = null;
        $stations = \Radio\Models\Repeater::find();
        $this->view->stations = $stations;
        $this->view->stationlists = $this->stations;
       
    }
    public function detailsAction($id = null){
        $this->view->repeater = null;
        if($id){
            $repeater = \Radio\Models\Repeater::findById($id);
            $this->view->repeater = $repeater;
        }
        $this->view->stationlists = $this->stations;        
        //$this->view->pick('repeater/index');
    }
    public function mgmtAction($id){
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
            $repeater->name     = $this->request->getPost('name');
            $repeater->owner    = $this->request->getPost('owner');
            $repeater->province = $this->request->getPost('province');
            $repeater->city     = $this->request->getPost('city');
            $repeater->frequency= $this->request->getPost('frequency');
            $repeater->shift    = $this->request->getPost('shift');
            $repeater->squelch  = $this->request->getPost('squelch');
            $repeater->code     = $this->request->getPost('code');
            $repeater->coordinate = $this->request->getPost('coordinate');
            $repeater->image    = $this->request->getPost('image');
            $repeater->description   = $this->request->getPost('description');
            $repeater->status   = $this->request->getPost('status');
            $repeater->zone     = array('cq' => $this->request->getPost('cq'), 'itu' => $this->request->getPost('itu'));
            $repeater->save();
            
            $message = new \Radio\Models\Message();
            $message->datetime = date('Y-m-d H:i:s');
            if($id){
                $message->content = sprintf("%s %s 业余中继台，频率 %s 参数更新了！", $repeater->province, $repeater->city, $repeater->owner, $repeater->frequency);
            }else{
                $message->content = sprintf("%s %s %s 新增中继站，频率 %s 快来看看吧！", $repeater->province, $repeater->city, $repeater->owner, $repeater->frequency);
            }
            $message->save();
        }
        
        $stations = \Radio\Models\Repeater::find(array('fields' => array('frequency')));
        $this->view->stations = $stations;
        
        if($id){
            $repeater = \Radio\Models\Repeater::findById($id);
            //  'fields' => array('owner','province','city','frequency','shift','tone','code','coordinate','status')
            $this->view->repeater = $repeater;
        }
    }
}