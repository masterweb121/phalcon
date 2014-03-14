<?php

use Phalcon\Mvc\User\Component;

class Elements extends Component
{
	public function getChannel(){
		$links = array(
				array('title'=>'Home', 'link'=>'/'),
				array('title'=>'Technology','link'=>'technology'),
				array('title'=>'Photography','link'=>'photography'),
				array('title'=>'Radio','link'=>'radio'),
				array('title'=>'About','link'=>'about')
		);
		return($links);
	}
    public function getMenu($menu)
    {
        $array = explode('/', $menu);
        $menu = $array[1];
		if(empty($menu)){
			$menu = 'home';
		}
		$submenu = array(
			'member' => array(
				array('title'=>'相册管理', 'link'=>'/member/'),
				array('title'=>'电台管理','link'=>'/member/radio'),
				array('title'=>'活动管理','link'=>'')
			),
			'about' => array(
				array('title'=>'Home', 'link'=>'/'),
				array('title'=>'Technology','link'=>'/technology/'),
				array('title'=>'About','link'=>'/about/')
			),
			'technology' => array(
				array('title'=>'Linux', 'link'=>'/technology/linux/'),
				array('title'=>'CentOS','link'=>'/technology/centos/'),
				array('title'=>'MySQL','link'=>'/technology/mysql/'),
				array('title'=>'FreeBSD','link'=>'/technology/freebsd/'),
				array('title'=>'Architect','link'=>'/technology/architect/')
			),
			'photography' => array(
				array('title'=>'2014','link'=>'/photography/album/2014/'),
				array('title'=>'2013','link'=>'/photography/album/2013/'),
				array('title'=>'2012','link'=>'/photography/album/2012/'),
				array('title'=>'2011','link'=>'/photography/album/2011/'),
				array('title'=>'2010','link'=>'/photography/album/2010/')
			),
            'radio' => array(
				array('title'=>'Repeater', 'link'=>'radio/repeater'),
				array('title'=>'Logging','link'=>'radio/logging'),
				array('title'=>'Morse','link'=>'radio/morse'),
                array('title'=>'Zone','link'=>'radio/zone'),
                array('title'=>'APRS','link'=>'radio/aprs'),
                array('title'=>'Software','link'=>'/radio/software')
			),
		);
		if(array_key_exists($menu,$submenu)){
			return($submenu[$menu]);
		}
		return( array($menu));
    }
	public function getSubmenu($menu)
    {
		$array = explode('/', $menu);
        if(count($array) < 3){
            return( array());
        }
        $menu = $array[2];
		if(empty($menu)){
			$menu = 'home';
		}
		$submenu = array(
			'member' => array(
				array('title'=>'相册管理', 'link'=>'/member/'),
				array('title'=>'电台管理','link'=>'/member/radio'),
				array('title'=>'活动管理','link'=>'')
			),
			'about' => array(
				array('title'=>'Home', 'link'=>'/'),
				array('title'=>'Technology','link'=>'/technology/'),
				array('title'=>'About','link'=>'/about/')
			),
			'technology' => array(
				array('title'=>'Linux', 'link'=>'/technology/linux/'),
				array('title'=>'CentOS','link'=>'/technology/centos/'),
				array('title'=>'MySQL','link'=>'/technology/mysql/'),
				array('title'=>'FreeBSD','link'=>'/technology/freebsd/'),
				array('title'=>'Architect','link'=>'/technology/architect/')
			),
			'photography' => array(
				array('title'=>'2014','link'=>'/photography/album/2014/'),
				array('title'=>'2013','link'=>'/photography/album/2013/'),
				array('title'=>'2012','link'=>'/photography/album/2012/'),
				array('title'=>'2011','link'=>'/photography/album/2011/'),
				array('title'=>'2010','link'=>'/photography/album/2010/')
			),
            'repeater' => array(
				array('title'=>'Repeater', 'link'=>'/radio/repeater'),
				array('title'=>'Logging','link'=>'/radio/logging'),
				array('title'=>'Morse','link'=>'/radio/morse'),
                array('title'=>'Zone','link'=>'/radio/zone'),
                array('title'=>'APRS','link'=>'/radio/aprs'),
                array('title'=>'Software','link'=>'/radio/software')
			),
		);
		if(array_key_exists($menu,$submenu)){
			
			return($submenu[$menu]);
		}
		return( array());
    }
    public function getTabs()
    {
        //...
    }

}
