<?php
namespace Technology\Components;
use Phalcon\Mvc\User\Component;

class Menu extends Component
{
	public function __construct($controller, $action) {
        $this->controller = $controller;
        $this->action = $action;
    }
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
    public function getMenu()
    {
		$menu = array(
            array('title'=>'Home', 'link'=>'technology'),
            array('title'=>'电子书', 'link'=>'technology/book/'),
            array('title'=>'Linux', 'link'=>'technology/book/linux/index.html'),
            array('title'=>'CentOS','link'=>'/technology/book/centos/index.html'),
            array('title'=>'MySQL','link'=>'/technology/book/mysql/index.html'),
            array('title'=>'FreeBSD','link'=>'/technology/book/freebsd/index.html'),
            array('title'=>'Architect','link'=>'/technology/book/architect/index.html')  
            /*
            array('title'=>'操作系统', 'link'=>'technology/repeater'),
            array('title'=>'编程语言','link'=>'technology/logging'),
            array('title'=>'数据库','link'=>'technology/net'),
            array('title'=>'安全','link'=>'technology/beacon'),
            array('title'=>'性能','link'=>'technology/morse'),
            array('title'=>'Software','link'=>'/technology/software')
             * 
             */
		);
		return( $menu );
    }
	public function getSubmenu($menu = null)
    {
		$submenu = array(
            'technology' => array(
				array('title'=>'Linux', 'link'=>'/technology/linux/'),
				array('title'=>'CentOS','link'=>'/technology/centos/'),
				array('title'=>'MySQL','link'=>'/technology/mysql/'),
				array('title'=>'FreeBSD','link'=>'/technology/freebsd/'),
				array('title'=>'Architect','link'=>'/technology/architect/')
			),            
			'logging' => array(
				array('title'=>'HF','link'=>'/photography/album/2011/'),
                array('title'=>'VHF','link'=>'/photography/album/2013/'),
                array('title'=>'UHF','link'=>'/photography/album/2014/'),
				array('title'=>'KUHF','link'=>'/photography/album/2012/'),
				array('title'=>'FSK','link'=>'/photography/album/2010/')
			),
            'repeater' => array(
				array('title'=>'UHF', 'link'=>'/radio/repeater'),
				array('title'=>'VHF','link'=>'/radio/logging'),
				array('title'=>'Morse','link'=>'/radio/morse'),
                array('title'=>'Zone','link'=>'/radio/zone'),
                array('title'=>'APRS','link'=>'/radio/aprs'),
                array('title'=>'Software','link'=>'/radio/software')
			),
             'product' => array(
				array('title'=>'Yaesu', 'link'=>'/radio/repeater'),
				array('title'=>'ICOM','link'=>'/radio/logging'),
				array('title'=>'Kenwood','link'=>'/radio/morse'),
                array('title'=>'Alinco','link'=>'/radio/aprs'),
                array('title'=>'Motorola','link'=>'/radio/zone'),
                array('title'=>'Hytera','link'=>'/radio/software')
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
