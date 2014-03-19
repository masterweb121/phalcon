<?php

class AboutController extends HomeController
{
	public function initialize()
    {
        $this->view->setTemplateAfter('index');
		//Set the document title
        $this->tag->setTitle('About');
        parent::initialize();
    }
	
    public function indexAction()
    {

    }

}
