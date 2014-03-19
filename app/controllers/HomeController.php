<?php

class HomeController extends Phalcon\Mvc\Controller
{

    public function initialize()
    {
        //Prepend the application name to the title
        $this->tag->prependTitle(''); 
    }

}
