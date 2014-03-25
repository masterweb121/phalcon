<?php

class Member extends \Phalcon\Mvc\Collection
{
    public function initialize()
    {
        $this->setConnectionService('member');
    }
    
    public function getSource()
    {
        return "member";
    }
}