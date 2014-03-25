<?php
//namespace Home\Controllers;
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

        if($username = $this->session->get('username')){
            $member = Member::findFirst(array(
                /*'fields' => array('username','password','callsign'),*/
                array("username" => $username)
            ));
            if ($this->request->isPost() == true) {
                $member->sex = $this->request->getPost("sex", "string");
                $member->callsign = $this->request->getPost("callsign", "string");
                $member->save();
            }
            $this->view->member = $member;
            $this->view->msg = $this->request->get('msg');
        }else{
            $this->view->disable();
            $this->response->redirect("member/signin");
        }
        //$this->view->pick('member/sidebar');
    }
    public function changeAction(){
        
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
            //$callsign = $this->request->getPost("callsign");
            
            $member = new Member();
            //$member->callsign = $callsign;
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
            if(in_array('HTTP_REFERER', $_SERVER) ){
                $this->response->redirect($_SERVER['HTTP_REFERER']);
            }else{
                $this->response->redirect("member");
            }
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
    
    
    public function unsubscribeAction(){
        
    }
    public function subscribeAction(){
        
    }
}
