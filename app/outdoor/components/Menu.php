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
            array('title'=>'频道首页', 'link'=>'outdoor'),
            array('title'=>'Walking','link'=>'outdoor/activity/category/walking'),
            array('title'=>'Hiking','link'=>'outdoor/hiking'),
            array('title'=>'Cycling','link'=>'outdoor/cycling'),
            array('title'=>'Camping','link'=>'outdoor/camping'),
            array('title'=>'Activity','link'=>'outdoor/activity'),
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
            'hiking' => array(
                array('title'=>'Trekking','link'=>'/outdoor/hiking/trekking'),
                array('title'=>'river trekking','link'=>'/outdoor/hiking/river'),
                //array('title'=>'Backpacking','link'=>'/outdoor/hiking'),
                //array('title'=>'','link'=>'/outdoor/hiking'),
                //array('title'=>'','link'=>'/outdoor/hiking'),
            ),
            'activity' => array(
                array('title'=>'All','link'=>'/outdoor/activity/'),
                array('title'=>'Walking','link'=>'/outdoor/activity/category/walking'),
                array('title'=>'Hiking','link'=>'/outdoor/activity/category/hiking'),
                array('title'=>'Cycling','link'=>'/outdoor/activity/category/cycling'),
                array('title'=>'Camping','link'=>'/outdoor/activity/category/camping'),
                array('title'=>'Technology','link'=>'/outdoor/activity/category/technology'),
                array('title'=>'Photography','link'=>'/outdoor/activity/category/photography'),
                array('title'=>'Radio','link'=>'/outdoor/activity/category/radio/'),
            )
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

