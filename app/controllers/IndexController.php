<?php
//namespace Home\Controllers;
class IndexController extends \Phalcon\Mvc\Controller
{
	public function initialize()
    {
        //$this->view->setTemplateAfter('common');
		//Set the document title
        $this->tag->setTitle('Home');
        //parent::initialize();
    }
	
    public function indexAction()
    {
//        echo "<h1>Hello!</h1>";
    }

}
