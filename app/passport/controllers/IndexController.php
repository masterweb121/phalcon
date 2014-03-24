<?php
namespace Home\Controllers;
class IndexController extends \Phalcon\Mvc\Controller
{
	public function initialize()
    {
        $this->view->setTemplateAfter('theme');
		//Set the document title
        $this->tag->setTitle('Member');
        //parent::initialize();
    }
	
    public function indexAction()
    {
        
    }

}
