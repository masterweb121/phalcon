<?php
namespace Radio\Models;
class Message extends \Phalcon\Mvc\Collection
{
    public function initialize()
    {
        $this->setConnectionService('radio');
    }
    public function beforeCreate()
    {
        // Set the creation date
        $this->datetime = date('Y-m-d H:i:s');
    }

    public function beforeUpdate()
    {
        // Set the modification date
        //$this->modified_in = date('Y-m-d H:i:s');
    }    
}