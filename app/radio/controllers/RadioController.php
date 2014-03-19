<?php
namespace Radio\Controllers;
class RadioController extends \Phalcon\Mvc\Controller {
	public function initialize()
    {
        $this->view->setTemplateAfter('theme'); 
        $this->tag->prependTitle('Amateur Radio ');
        $this->view->menu = new \Radio\Components\Menu($this->dispatcher->getControllerName(), $this->dispatcher->getActionName());
    }
    /*
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
     * 
     */
}
