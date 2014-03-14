<?php
namespace Radio;
class Repeater extends \Phalcon\Mvc\Collection
{
    public function initialize()
    {
        $this->setConnectionService('radio');
    }
    /*
    public function getSource()
    {
        return "member";
    }
    
     */
}
