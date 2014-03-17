<?php
namespace Radio\Controllers;

class LoggingController extends \Phalcon\Mvc\Controller{
    public function initialize()
    {
        $this->view->setTemplateAfter('theme');
		//Set the document title
        $this->tag->setTitle('Radio - Logging');
        //parent::initialize();
    }
    public function indexAction(){
        $logging = \Radio\Models\Logging::find(
            array( 'fields' => array('callsign','date','time','frequency','mode','call','rst','watt','notes'),
                    'limit' => 100
            )
        );
        $this->view->loggings = $logging;
    }
    public function mgmtAction(){
        if(!$this->session->get('callsign')){
            $this->response->redirect("member/signin");
        }
        date_default_timezone_set("UTC");
        $this->tag->setTitle('Radio Logging');

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
            $logging->save();
            $this->view->logging = (object)$this->request->getPost();
            
            $message = new \Radio\Models\Message();
            $message->datetime = date('Y-m-d H:i:s');
            $message->content = $logging->callsign .'与'.$logging->call.'做了一个通联';
            $message->save();
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
}
