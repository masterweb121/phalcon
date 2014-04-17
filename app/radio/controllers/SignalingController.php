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
    public function mdc1200Action(){
        $this->view->signalings = \Radio\Models\Signaling::find(array(
            'fields' => array('callsign','mdc1200')
            ));
        $this->view->partial("signaling/index");
    }
    public function qciiAction(){
        $this->view->signalings = \Radio\Models\Signaling::find(array(
            'fields' => array('callsign','qcii')
            ));
        $this->view->partial("signaling/index");
    }
    public function dtmfAction(){
        $this->view->signalings = \Radio\Models\Signaling::find(array(
            'fields' => array('callsign','dtmf')
            ));
        $this->view->partial("signaling/index");
    }
    public function selectvAction(){
        $this->view->signalings = \Radio\Models\Signaling::find(array(
            'fields' => array('callsign','selectv')
            ));
        $this->view->partial("signaling/index");
    }
    public function c4fmAction(){
        $this->view->signalings = \Radio\Models\Signaling::find(array(
            'fields' => array('callsign','c4fm')
            ));
        $this->view->partial("signaling/index");
    }
    public function downloadAction(){
        $this->response->setHeader('Content-type', 'text/csv');
        $this->response->setHeader('Content-Disposition:', 'attachment; filename="repeater.csv"');
        $this->view->disable();
        $signalings = \Radio\Models\Signaling::find(array(
            'fields' => array('callsign','mototrbo','mdc1200','qcii','dtmf','selectv','c4fm')
            ));
        printf("'callsign','mototrbo','mdc1200','qcii','dtmf','selectv','c4fm'\n");
        foreach ($signalings as $signaling){
            $row = (array)$signaling;
            unset($row['_id']);
            $line = implode ( ',' , $row );
            printf("%s\n",$line);
        }
    }
    public function searchAction(){
        $this->view->signalings = null;
        if($this->request->isGet()){
            $callsign = $this->request->get("callsign", "string");
            if($callsign){
                $this->view->signalings = \Radio\Models\Signaling::find(array(
                    'fields' => array('callsign','c4fm','mototrbo','mdc1200','qcii','dtmf','selectv'),
                    array('callsign'=>$callsign)
                ));
            }else{
                $code = $this->request->get("code", "string");
                $signaling = $this->request->get("signaling", "string");
                if($code && $signaling){
                    $this->view->signalings = \Radio\Models\Signaling::find(array(
                        'fields' => array('callsign','c4fm','mototrbo','mdc1200','qcii','dtmf','selectv'),
                        array($signaling => $code)
                    ));
                }
            }

        }
        $this->view->partial("signaling/index");
    }
}
