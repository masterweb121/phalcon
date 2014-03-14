<?php
namespace Radio;
class Logging extends \Phalcon\Mvc\Collection
{
    public function initialize()
    {
        $this->setConnectionService('radio');
    }
    public function getSource()
    {
        return "logging";
    }

}