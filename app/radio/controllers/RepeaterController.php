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
    public function mgmtAction($id){
        //$this->view->setTemplateAfter('maximize');
        if(!$this->session->get('callsign')){
            $this->response->redirect("member/signin");
        }
        $this->tag->setTitle('Radio');
        $this->view->callsign = $this->session->get('callsign');
        
        $this->view->repeater = null;
        if($id){
            $this->view->id = $id;
        }else{
            $this->view->id = null;
        }
        
        if ($this->request->isPost() == true) {
            //$this->view->repeater = (Object)$this->request->getPost();
            if($id){
                $repeater = \Radio\Models\Repeater::findById($id);
            }else{
                $repeater = new \Radio\Models\Repeater();
            }
            $repeater->callsign = $this->request->getPost('callsign');
            $repeater->name     = $this->request->getPost('name');
            $repeater->province = $this->request->getPost('province');
            $repeater->city     = $this->request->getPost('city');
            $repeater->county     = $this->request->getPost('county');
            $repeater->mode      = $this->request->getPost('mode');
            $repeater->timeslot  = $this->request->getPost('timeslot');
            $repeater->color  = $this->request->getPost('color');
            $repeater->frequency= $this->request->getPost('frequency');
            $repeater->shift    = $this->request->getPost('shift');
            $repeater->squelch  = $this->request->getPost('squelch');
            $repeater->code     = $this->request->getPost('code');
            $repeater->band     = $this->request->getPost('band');
            $repeater->coordinate = $this->request->getPost('coordinate');
            $repeater->image    = $this->request->getPost('image');
            $repeater->description   = $this->request->getPost('description');
            $repeater->status   = $this->request->getPost('status');
            $repeater->zone     = array('cq' => $this->request->getPost('cq'), 'itu' => $this->request->getPost('itu'));
            $repeater->save();
            
            $message = new \Radio\Models\Message();
            $message->datetime = date('Y-m-d H:i:s');
            if($id){
                $message->content = sprintf("%s %s 业余中继台，频率 %s 参数更新了！", $repeater->province, $repeater->city, $repeater->callsign, $repeater->frequency);
            }else{
                $message->content = sprintf("%s %s %s 新增中继站，频率 %s 快来看看吧！", $repeater->province, $repeater->city, $repeater->callsign, $repeater->frequency);
            }
            $message->save();
        }
        
        $stations = \Radio\Models\Repeater::find(array('fields' => array('name','frequency')));
        $this->view->stations = $stations;
        
        if($id){
            $repeater = \Radio\Models\Repeater::findById($id);
            //  'fields' => array('owner','province','city','frequency','shift','tone','code','coordinate','status')
            $this->view->repeater = $repeater;
        }
    }
}
