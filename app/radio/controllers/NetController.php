<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Radio\Controllers;

/**
 * Description of NetController
 *
 * @author neo
 */
class NetController extends RadioController {
    public function initialize()
    {
        $this->view->setTemplateAfter('theme');
		//Set the document title
        $this->tag->setTitle('- Net');
        parent::initialize();
        $this->view->menu = new \Radio\Components\Menu($this->dispatcher->getControllerName(), $this->dispatcher->getActionName());
    }
    public function indexAction(){
//        $logging = \Radio\Models\Logging::find(
//            array( 'fields' => array('callsign','date','time','frequency','mode','call','rst','watt','notes'),
//                    'limit' => 100
//            )
//        );
//        $this->view->loggings = $logging;
    }
    public function checkinAction(){
        $this->tag->appendTitle('Check In');
    }
}
