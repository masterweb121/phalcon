<?php
#include_once('HomeController.php');
class ProductController extends HomeController
{

    public function initialize()
    {
        //Set the document title
        $this->tag->setTitle('Manage your product types');
        parent::initialize();
    }

    //...
    public function indexAction()
    {

    }
}
