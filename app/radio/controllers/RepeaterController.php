<?php
namespace Radio\Controllers;
/**
 * Description of RepeaterController
 *
 * @author neo
 */
class RepeaterController extends RadioController {
    public function initialize()
    {
        $this->view->setTemplateAfter('theme');
        $this->tag->setTitle('- Repeater');
        parent::initialize();
        $this->view->menu = new \Radio\Components\Menu($this->dispatcher->getControllerName(), $this->dispatcher->getActionName());
        // 中继列表
//        $this->stations = \Radio\Models\Repeater::find(array('fields' => array('frequency','name')));
    }
    public function indexAction(){
        $this->view->stations = null;
        $stations = \Radio\Models\Repeater::find();
        $this->view->stations = $stations;
        $this->view->stationlists = \Radio\Models\Repeater::find(array('fields' => array('frequency','name')));
       
    }
    public function detailsAction($id = null){
        $this->view->repeater = null;
        if($id){
            $repeater = \Radio\Models\Repeater::findById($id);
            $this->view->repeater = $repeater;
        }
        //$this->view->stationlists = $this->stations;        
        //$this->view->pick('repeater/index');
    }
    
    public function AnalogAction(){
        $this->view->stations = null;
        $stations = \Radio\Models\Repeater::find(array(
                array('mode'=>'Analog')
            ));
        $this->view->stations = $stations;
        $this->view->stationlists = \Radio\Models\Repeater::find(array('fields' => array('frequency','name'),array('mode'=>'Analog')));;
       
    }
    public function digitalAction(){
        $this->view->stations = null;
        $stations = \Radio\Models\Repeater::find(array(
            array('mode'=>'Digital')
            ));
        $this->view->stations = $stations;
        $this->view->stationlists = \Radio\Models\Repeater::find(array('fields' => array('frequency','name'),array('mode'=>'Digital')));
       
    }
    public function uhfAction(){
        $this->view->stations = null;
        $stations = \Radio\Models\Repeater::find(array(
            array('band'=>'UHF')
            ));
        $this->view->stations = $stations;
        $this->view->stationlists = \Radio\Models\Repeater::find(array('fields' => array('frequency','name'),array('band'=>'UHF')));
       
    }
    public function vhfAction(){
        $this->view->stations = null;
        $stations = \Radio\Models\Repeater::find(array(
            array('band'=>'VHF')
            ));
        $this->view->stations = $stations;
        $this->view->stationlists = \Radio\Models\Repeater::find(array('fields' => array('frequency','name'),array('band'=>'VHF')));
       
    }
    public function downloadAction(){
        $this->response->setHeader('Content-type', 'text/csv');
        $this->response->setHeader('Content-Disposition:', 'attachment; filename="repeater.csv"');
        $this->view->disable();
        $repeaters = \Radio\Models\Repeater::find(array('fields' => array('name','province','city','county','frequency','shift','squelch','code','band')));
        foreach ($repeaters as $repeater){
            $row = (array)$repeater;
            unset($row['_id']);
            $line = implode ( ',' , $row );
            printf("%s\n",$line);
        }
//        $this->view->repeater = null;
//        if($id){
//            
//            $this->view->repeater = $repeater;
//        }
//        $this->view->stationlists = $this->stations;        
        //$this->view->pick('repeater/index');
    }
    
}
