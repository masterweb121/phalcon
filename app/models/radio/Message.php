<?php
namespace Radio;
class Message extends \Phalcon\Mvc\Collection
{
    public function initialize()
    {
        $this->setConnectionService('radio');
    }
}