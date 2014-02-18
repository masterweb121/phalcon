<?php

class PhotographyController extends HomeController
{
	public function initialize()
    {
        $this->view->setTemplateAfter('index');
		//Set the document title
        $this->tag->setTitle('photography');
        parent::initialize();
    }
	
    public function indexAction()
    {

    }

}
