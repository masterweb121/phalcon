<?php
namespace Technology\Controllers;
class IndexController extends \Phalcon\Mvc\Controller
{
	public function initialize()
    {
        $this->view->setTemplateAfter('theme');
		//Set the document title
        $this->tag->setTitle('Technology');
        $this->view->menu = new \Technology\Components\Menu($this->dispatcher->getControllerName(), $this->dispatcher->getActionName());
    }
	
    public function indexAction()
    {
        
    }

}
