<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Outdoor\Controllers;

/**
 * Description of TravelogueController
 *
 * @author neo
 */
class TravelogueController extends OutdoorController {
    public function initialize()
    {
        $this->tag->setTitle('- Travelogue');
        parent::initialize();
    }
	
    public function indexAction()
    {
        
    }
}
