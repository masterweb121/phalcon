<?php

class SignupController extends HomeController
{
	public function initialize()
    {
        $this->view->setTemplateAfter('home');
		//Set the document title
        $this->tag->setTitle('Signup');
        parent::initialize();
    }
	
    public function indexAction()
    {

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
