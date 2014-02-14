<?php

use Phalcon\Mvc\User\Component;

class Elements extends Component
{

    public function getMenu()
    {
        //...
	return("Home | About");
    }

    public function getTabs()
    {
        //...
    }

}
