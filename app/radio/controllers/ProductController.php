<?php
namespace Radio\Controllers;
class ProductController extends \Phalcon\Mvc\Controller {

    public function initialize()
    {
        $this->view->setTemplateAfter('theme');
		//Set the document title
        $this->tag->setTitle('Radio product');
        $this->view->menu = new \Radio\Component\Menu($this->dispatcher->getControllerName(), $this->dispatcher->getActionName());
    }

    //...
    public function indexAction()
    {

    }
    public function yaesuAction()
    {

    }
    public function icomAction()
    {

    }
    public function kenwoodAction()
    {

    }
    public function alincoAction()
    {

    }
    public function motorolaAction()
    {

    }
    public function hyteraAction()
    {

    }
    
}
