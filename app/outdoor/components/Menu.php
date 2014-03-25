<?php
namespace Outdoor\Components;
use Phalcon\Mvc\User\Component;

class Menu extends Component
{
	public function __construct($controller, $action) {
        $this->controller = $controller;
        $this->action = $action;
    }
    public function getChannel(){
		$links = array(

		);
		return($links);
	}
    public function getMenu()
    {
		$menu = array(
            array('title'=>'Home', 'link'=>'outdoor'),
            array('title'=>'Walking','link'=>'outdoor'),
            array('title'=>'Hiking','link'=>'outdoor'),
            array('title'=>'Cycling','link'=>'outdoor/cycling'),
            array('title'=>'Camping','link'=>'outdoor'),
            array('title'=>'Activity','link'=>'outdoor'),
            array('title'=>'Travelogue','link'=>'outdoor/travelogue'),
            
		);
		return( $menu );
    }
	public function getSubmenu($menu = null)
    {
		$submenu = array(
            'index' => array(
                array('title'=>'Weather','link'=>'/outdoor/weather'),
                array('title'=>'Routes','link'=>'/outdoor/'),
                array('title'=>'Waypoint','link'=>'/outdoor/'),
                array('title'=>'Track','link'=>'/outdoor/'),
                array('title'=>'Navigation','link'=>'/outdoor/'),
            ),
            'cycling' => array(
                array('title'=>'Mountain bike','link'=>'/outdoor/cycling/mtb'),
                array('title'=>'Road Cycling','link'=>'/outdoor/'),
                array('title'=>'自行车协会','link'=>'/outdoor'),
                array('title'=>'','link'=>'/outdoor/'),
                array('title'=>'','link'=>'/outdoor/'),
            ),
		);
		if(array_key_exists($this->controller,$submenu)){
			
			return($submenu[$this->controller]);
		}
		return( array());
    }
    public function getTabs()
    {
        //...
    }

}

