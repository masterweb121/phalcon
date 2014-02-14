<?php
#include_once('HomeController.php');
class ProductController extends HomeController
{

    public function initialize()
    {
        $this->view->setTemplateAfter('home');
		//Set the document title
        $this->tag->setTitle('Manage your product types');
        parent::initialize();
    }

    //...
    public function indexAction()
    {

    }
}
