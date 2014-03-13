<?php

class RadioController extends HomeController
{
	public function initialize()
    {
        //$this->view->setTemplateAfter('radio');
		//Set the document title
        $this->tag->setTitle('Amateur Radio');
        parent::initialize();
    }
	
    public function indexAction()
    {
		//$this->view->disable();
    }
    public function repeaterAction($id){
        $stations = array(
            '439.460'=>array(
                'frequency' => '439.460',
                'name' => '深圳业余无线电中继',
                'description' => '深圳业余无线电中继',
                'owner' => 'BG7JAX',
                'point' => array(114.055309, 22.559879),
                ),
            '439.790'=>array(
                'frequency' => '439.790',
                'name' => '深圳业余无线电数字中继',
                'description' => '深圳业余无线电数字中继，DMR制式',
                'owner' => 'BG7MEO',
                'point' => array(114.121281, 22.549048),
                ),
            '439.220'=>array(
                'frequency' => '439.220',
                'name' => '深圳北模拟中继',
                'description' => '深圳业余无线电数字中继',
                'owner' => 'BG7IVQ',
                'point' => array(114.077371, 22.633201),
                ),            
        );
        $this->view->stations = null;
        $this->view->repeater = null;
        foreach($stations as $key=>$value){
            $lists[$key] = $key.' '.$value['name'];
        }
        $this->view->lists = $lists;
        if(empty($id)){
            $this->view->stations = $stations;
        }else{
            $this->view->repeater = $stations[$id];
        }
        
    }
    public function beaconAction(){
        
    }
    public function loggingAction(){

        $this->view->post = null;
        if($this->request->isPost()){
            $logging       = new Logging();
            $logging->callsign = 'BG7NYT'; //$this->request->getPost("callsign", "string");
            $logging->date = $this->request->getPost("date", "string");
            $logging->time = $this->request->getPost("time", "string");
            $logging->frequency = $this->request->getPost("frequency", "string");
            $logging->mode = $this->request->getPost("mode", "string");
            $logging->call = $this->request->getPost("call", "string");
            $logging->rst = $this->request->getPost("rst", "string");
            $logging->watt = $this->request->getPost("watt", "string");
            $logging->notes = $this->request->getPost("notes", "string");
            $logging->save();
            $this->view->post = $this->request->getPost();
        }
        //print_r($logging);
        //$this->view->disable();
        $logging = Logging::find(
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
