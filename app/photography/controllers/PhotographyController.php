<?php
namespace Photography\Controllers;
class PhotographyController extends \Phalcon\Mvc\Controller
{
	public function initialize()
    {
        $this->view->setTemplateAfter('theme');
		//Set the document title
        $this->tag->prependTitle('Photography ');
//        parent::initialize();
        $this->view->menu = new \Photography\Components\Menu($this->dispatcher->getControllerName(), $this->dispatcher->getActionName());
        


    }
	
    public function indexAction()
    {

    
    }
    public function galleryAction($year){

    }
	public function previewAction($album){

	}
}
