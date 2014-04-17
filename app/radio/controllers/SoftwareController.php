<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Radio\Controllers;

/**
 * Description of SoftwareController
 *
 * @author neo
 */
class SoftwareController extends RadioController {
    public function initialize()
    {
        $this->view->setTemplateAfter('theme');
		//Set the document title
        $this->tag->setTitle('- Software');
        parent::initialize();
    }
	
    public function indexAction()
    {
        
    }
}
