<?php
namespace Photography\Controllers;
class IndexController extends \Phalcon\Mvc\Controller
{
	public function initialize()
    {
        $this->view->setTemplateAfter('theme');
		//Set the document title
        $this->tag->setTitle('Photography');
        $this->view->menu = new \Photography\Components\Menu($this->dispatcher->getControllerName(), $this->dispatcher->getActionName());
        //parent::initialize();
    }
	
    public function indexAction()
    {

    }
    public function qrzAction($callsign){

    }

}
