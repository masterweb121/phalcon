<?php
namespace Photography\Components;
use Phalcon\Mvc\User\Component;

class Menu extends Component
{
	public function __construct($controller, $action) {
        $this->controller = $controller;
        $this->action = $action;
    }
    public function getChannel(){
		$links = array(
				array('title'=>'Home', 'link'=>'index'),
				array('title'=>'Technology','link'=>'technology'),
				array('title'=>'Photography','link'=>'photography'),
				array('title'=>'Radio','link'=>'radio'),
				
		);
		return($links);
	}
    public function getMenu()
    {
		$menu = array(
            array('title'=>'Home', 'link'=>'photography'),
            array('title'=>'相册', 'link'=>'photography/collection'),
            array('title'=>'摄影器材', 'link'=>'photography/equipment'),
            array('title'=>'后期','link'=>'photoshop'),
		);
		return( $menu );
    }
	public function getSubmenu($menu = null)
    {
		$submenu = array(
			'equipment' => array(
				array('title'=>'镜头','link'=>'equipment/lens'),
				array('title'=>'相机','link'=>'equipment/camera'),
                array('title'=>'滤镜','link'=>'equipment/filter'),
			),
            'collection' => array(
				array('title'=>'2014','link'=>'/photography/collection/album/2014'),
				array('title'=>'2013','link'=>'2013'),
				array('title'=>'2012','link'=>'2012'),
				array('title'=>'2011','link'=>'2011'),
				array('title'=>'2010','link'=>'2010')
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