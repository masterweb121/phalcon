<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Radio\Models;

/**
 * Description of Mail
 *
 * @author neo
 */
class Netlog extends \Phalcon\Mvc\Collection {
    public function initialize()
    {
        $this->setConnectionService('radio');
    }
}
