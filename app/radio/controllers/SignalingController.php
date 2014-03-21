<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Radio\Controllers;

/**
 * Description of SignalingController
 *
 * @author neo
 */
class SignalingController extends RadioController {
    public function initialize()
    {
        $this->view->setTemplateAfter('theme');
        $this->tag->setTitle('- Signaling');
        parent::initialize();
        $this->view->menu = new \Radio\Components\Menu($this->dispatcher->getControllerName(), $this->dispatcher->getActionName());
    }
    public function indexAction(){
        $this->view->signalings = \Radio\Models\Signaling::find(array(
            'fields' => array('callsign','c4fm','mototrbo','mdc1200','qcii','dtmf','selectv')
            )); 
    }
    public function mototrboAction(){
        $this->view->signalings = \Radio\Models\Signaling::find(array(
            'fields' => array('callsign','mototrbo')
            )); 
        $this->view->partial("signaling/index");
    }
    public function downloadAction(){
        $this->response->setHeader('Content-type', 'text/csv');
        $this->response->setHeader('Content-Disposition:', 'attachment; filename="repeater.csv"');
        $this->view->disable();
        $signalings = \Radio\Models\Signaling::find(array(
            'fields' => array('callsign','c4fm','mototrbo','mdc1200','qcii','dtmf','selectv')
            ));
        printf("'callsign','c4fm','mototrbo','mdc1200','qcii','dtmf','selectv'\n");
        foreach ($signalings as $signaling){
            $row = (array)$signaling;
            unset($row['_id']);
            $line = implode ( ',' , $row );
            printf("%s\n",$line);
        }
    }
}
 