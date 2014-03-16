<?php
class RadioController extends HomeController
{
	public function initialize()
    {
        $this->view->setTemplateAfter('index');
		//Set the document title
        $this->tag->setTitle('Amateur Radio');
        parent::initialize();
    }
	
    public function indexAction()
    {
        if($this->request->get('qrz')){
            $this->view->disable();
            $this->response->redirect("radio/qrz/".$this->request->get('qrz'));
        }
		// 消息列表
        $messages = Radio\Message::find(array(
                'fields' => array('datetime','content'),
                'sort' => array('datetime'=>-1),
                'limit' => 50
            ));
        $this->view->messages = $messages;
        
        
    }
     public function qrzAction($callsign){
        if($this->request->get('qrz')){
            $this->view->disable();
            $this->response->redirect("radio/qrz/".$this->request->get('qrz'));
        }
        $member = Member::findFirst(array(
                'fields' => array('username','name','callsign'),
                array("callsign" => $callsign)
        ));
        $this->view->qrz = $member;
        $message = new Radio\Message();
        $message->datetime = date('Y-m-d H:i:s');
        $message->content = sprintf("%s 您的呼号被查询了一次.", $callsign);
        $message->save();
    }
    public function repeaterAction($id){
        $this->view->stations = null;
        $this->view->repeater = null;

        if(empty($id)){
            // 中继列表
            $stations = Radio\Repeater::find();
            $this->view->stations = $stations;
        }else{
            $repeater = Radio\Repeater::findById($id);
            $this->view->repeater = $repeater;
        }
        $stations = Radio\Repeater::find(array('fields' => array('frequency','name')));
        $this->view->stationlists = $stations;
    }
    public function beaconAction(){
        
    }
    public function loggingAction(){
        $logging = Radio\Logging::find(
            array( 'fields' => array('callsign','date','time','frequency','mode','call','rst','watt','notes'),
                    'limit' => 100
            )
        );
        $this->view->loggings = $logging;
    }
    public function morseAction(){
        
    }
    public function zoneAction(){
        
    }
    public function aprsAction(){
        
    }
    public function softwareAction(){
        
    }
    public function registerAction()
    {
        $user = new Users();

        //Store and check for errors
        $success = $user->save($this->request->getPost(), array('name', 'email'));

        if ($success) {
            echo "Thanks for registering!";
        } else {
            echo "Sorry, the following problems were generated: ";
            foreach ($user->getMessages() as $message) {
                echo $message->getMessage(), "<br/>";
            }
        }

        $this->view->disable();
    }
}
