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
    public function repeaterAction(){
        
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
