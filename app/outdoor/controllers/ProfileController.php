<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Outdoor\Controllers;

/**
 * Description of CyclingController
 *
 * @author neo
 */
class ProfileController extends OutdoorController{
    public function initialize()
    {
        $this->tag->setTitle('Profile');
        parent::initialize();
        if(!$this->session->get('username')){
            $this->response->redirect("member/signin");
        }
    }
	
    public function indexAction()
    {
        $this->view->activitys = \Outdoor\Models\Activity::find();
    }
    public function mtbAction(){
        
    }
}
