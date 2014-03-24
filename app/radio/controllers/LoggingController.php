<?php
namespace Radio\Controllers;
//use Phalcon\Mvc\View;
class LoggingController extends RadioController{
    public function initialize()
    {
        $this->view->setTemplateAfter('theme');
        $this->tag->setTitle('- Logging');
        parent::initialize();
        $this->view->menu = new \Radio\Components\Menu($this->dispatcher->getControllerName(), $this->dispatcher->getActionName());
    }
    public function indexAction(){
        $logging = \Radio\Models\Logging::find(
            array( 'fields' => array('callsign','date','time','frequency','mode','call','rst','watt','notes'),
                    'sort' => array('date'=>-1, 'time'=>-1),
                    'limit' => 100
            )
        );
        $this->view->loggings = $logging;
    }
    private function category($mode){
        $logging = \Radio\Models\Logging::find(array( 
                'fields' => array('callsign','date','time','frequency','mode','call','rst','watt','notes'),
                array('mode'=>$mode),
                'sort' => array('date'=>-1, 'time'=>-1),
                'limit' => 100
            ));
        return($logging);
    }
    public function fmAction(){
        $this->view->loggings = $this->category('FM');
        $this->view->partial("logging/index");
    }
    public function amAction(){
        $this->view->loggings = $this->category('AM');
        $this->view->partial("logging/index");
    }
    public function usbAction(){
        $this->view->loggings = $this->category('USB');
        $this->view->partial("logging/index");
    }
    public function lsbAction(){
        $this->view->loggings = $this->category('LSB');
        $this->view->partial("logging/index");
    }
    public function cwAction(){
        $this->view->loggings = $this->category('CW');
        $this->view->partial("logging/index");
    }
    public function rttyAction(){
        $this->view->loggings = $this->category('RTTY');
        $this->view->partial("logging/index");
    }
    public function sstvAction(){
        $this->view->loggings = $this->category('SSTV');
        $this->view->partial("logging/index");
    }
    public function fskAction(){
        $this->view->loggings = $this->category('FSK');
        $this->view->partial("logging/index");
    }
    public function pskAction(){
        $this->view->loggings = $this->category('PSK');
        $this->view->partial("logging/index");
    }
    public function hfAction(){
        $this->view->loggings = $this->category('PSK');
        $this->view->partial("logging/index");
    }
    public function uhfAction(){
        $this->view->loggings = $this->category('PSK');
        $this->view->partial("logging/index");
    }
    public function vhfAction(){
        $this->view->loggings = $this->category('PSK');
        $this->view->partial("logging/index");
    }
    public function kuhfAction(){
        $this->view->loggings = $this->category('PSK');
        $this->view->partial("logging/index");
    }
}
