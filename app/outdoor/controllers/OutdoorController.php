<?php
namespace Outdoor\Controllers;
/**
 * Description of TestController
 *
 * @author neo
 */
class OutdoorController extends \Phalcon\Mvc\Controller {
    public function initialize()
    {
        $this->view->setTemplateAfter('theme'); 
        $this->tag->prependTitle('Outdoor ');
        $this->view->menu = new \Outdoor\Components\Menu($this->dispatcher->getControllerName(), $this->dispatcher->getActionName());
    }
}
