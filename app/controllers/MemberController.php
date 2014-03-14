<?php
class MemberController extends HomeController
{
	public function initialize()
    {
        $this->view->setTemplateAfter('index');
		//Set the document title
        $this->tag->setTitle('Signup');
        parent::initialize();
    }
	
    public function indexAction()
    {
        $this->view->member = null;
        //echo $this->view->render('member/sidebar');
        
        if($username = $this->session->get('username')){
            $member = Member::findFirst(array(
                'fields' => array('username','password','callsign'),
                array("username" => $username)
            ));
            $this->view->member = $member;
        }else{
            $this->view->disable();
            $this->response->redirect("member/signin");
        }
        //$this->view->pick('member/sidebar');
    }
    public function signupAction()
    {
        $this->view->status = null;
		if ($this->request->isPost() == true) {
			$username = $this->request->getPost("username", "string");
			$password = $this->request->getPost("password");
			$password2 = $this->request->getPost("password2");
			//$this->view->disable();
			if($password != $password2){
				$this->view->status = "两次输入密码不一至，请重新输入！";
				return;
			}
            $callsign = $this->request->getPost("callsign");
            
            $member = new Member();
            $member->callsign = $callsign;
            $member->username = $username;
            $member->password = $password;
            $member->save();
            
            if ($member->save()) {
                $this->view->status = "Great, a new user was saved successfully!";
                //$this->session->set('username',$username);
                $this->view->disable();
                $this->response->redirect("member/signin");
            } else {
                print_r($member->getMessages());
                $this->view->status = 'Sorry!';
            }
		}

        
    }
    public function signinAction(){
    	$this->view->module = Null;
        $this->view->status = Null;
		if ($this->request->isPost() == true) {
			$username = $this->request->getPost("username", "string");
			$password = $this->request->getPost("password");
            $member = Member::findFirst(array(
                'fields' => array('username','password','callsign'),
                array("username" => $username),
                array("password" => $password)
            ));
            
			if($member){
				$this->session->set('username',$username);
                $this->session->set('callsign',$member->callsign);
			}else{
				$this->view->status = 'Sorry!';
			}			
		}
		if($this->session->get('username')){
			$this->view->disable();
            $this->response->redirect("member");
            $this->view->status = "已登陆";
		}
    }
    public function signoutAction()
    {
    	if($this->session->get('username')){			
			$this->session->remove('username');
			echo '已退出';
			//$this->view->disable();
		}
    }
    public function profileAction(){
        
    }
    public function radioAction(){
        $this->tag->setTitle('Radio');
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
        // 中继列表
        $stations = Radio\Repeater::find(array('fields' => array('frequency')));
        $this->view->stations = $stations;
        
        // 消息列表
        $messages = Radio\Message::find(array(
                'fields' => array('datetime','content'),
                'sort' => array('datetime'=>-1),
                'limit' => 50
            ));
        $this->view->messages = $messages;
        
        // 呼入列表
        $callings = Radio\Logging::find(
            array(
                array('call' => $this->session->get('callsign')),
                'fields' => array('callsign','date','time','frequency','mode','call','rst','watt','notes'),
                'limit' => 10
            )
        );
        $this->view->callings = $callings;
    }
    public function repeaterAction($id){
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
                $repeater = Radio\Repeater::findById($id);
            }else{
                $repeater = new Radio\Repeater();
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
            
            $message = new Radio\Message();
            $message->datetime = date('Y-m-d H:i:s');
            if($id){
                $message->content = sprintf("%s %s 业余中继台，频率 %s 参数更新了！", $repeater->province, $repeater->city, $repeater->owner, $repeater->frequency);
            }else{
                $message->content = sprintf("%s %s %s 新增中继站，频率 %s 快来看看吧！", $repeater->province, $repeater->city, $repeater->owner, $repeater->frequency);
            }
            $message->save();
        }
        
        $stations = Radio\Repeater::find(array('fields' => array('frequency')));
        $this->view->stations = $stations;
        
        if($id){
            $repeater = Radio\Repeater::findById($id);
            //  'fields' => array('owner','province','city','frequency','shift','tone','code','coordinate','status')
            $this->view->repeater = $repeater;
        }
    }
    public function loggingAction(){
        date_default_timezone_set("UTC");
        $this->tag->setTitle('Radio Logging');

        if($this->request->isPost()){
            $logging       = new Radio\Logging();
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
            
            $message = new Radio\Message();
            $message->datetime = date('Y-m-d H:i:s');
            $message->content = $logging->callsign .'与'.$logging->call.'做了一个通联';
            $message->save();
        }

        $this->view->logging = null;
        
        $this->view->callsign  = $this->session->get('callsign');
        $callings = Radio\Logging::find(
            array(
                array('call' => $this->session->get('callsign')),
                'fields' => array('callsign','date','time','frequency','mode','call','rst','watt','notes'),
                'limit' => 100
            )
        );
        $this->view->callings = $callings;
        $loggings = Radio\Logging::find(
            array(
                array('callsign' => $this->session->get('callsign')),
                'fields' => array('callsign','date','time','frequency','mode','call','rst','watt','notes'),
                "sort" => array("date" => -1),
                'limit' => 100
            )
        );
        $this->view->loggings = $loggings;
        
        $incoming =  Radio\Logging::find(array(
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
    public function qslAction(){
        
    }
}
