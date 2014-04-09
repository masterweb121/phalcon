<?php
namespace Outdoor\Controllers;
class IndexController extends OutdoorController {
	public function initialize()
    {
        //$this->view->setTemplateAfter('common');
        $this->tag->setTitle('Home');
        parent::initialize();
    }
	
    public function indexAction()
    {
        $this->view->activitys = \Outdoor\Models\Activity::find();
    }

}