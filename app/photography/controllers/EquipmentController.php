<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Photography\Controllers;

/**
 * Description of EquipmentController
 *
 * @author neo
 */
class EquipmentController extends \Phalcon\Mvc\Controller {
    public function initialize()
    {
        $this->view->setTemplateAfter('theme');
		//Set the document title
        $this->tag->setTitle('Radio');
        $this->view->menu = new \Photography\Components\Menu($this->dispatcher->getControllerName(), $this->dispatcher->getActionName());
        //parent::initialize();
    }
    public function indexAction()
    {

    }
    public function lensAction()
    {

    }
    public function cameraAction()
    {

    }
    public function filterAction()
    {

    }
}
