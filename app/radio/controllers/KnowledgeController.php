<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Radio\Controllers;

/**
 * Description of KnowledgeController
 *
 * @author neo
 */
class KnowledgeController extends RadioController {
    public function initialize()
    {
        $this->view->setTemplateAfter('theme');
        $this->tag->setTitle('- Knowledge');
        parent::initialize();
        $this->view->menu = new \Radio\Components\Menu($this->dispatcher->getControllerName(), $this->dispatcher->getActionName());
        
    }
	
    public function indexAction()
    {
        
    }
    public function morseAction(){
        
    }
    public function qcodeAction(){
        
    }        
    public function zoneAction(){
        
    }
    public function aprsAction(){
        
    }
}
