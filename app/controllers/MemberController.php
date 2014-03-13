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
                $this->session->set('username',$username);
                $this->view->disable();
                $this->response->redirect("member");
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
}
