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

}
