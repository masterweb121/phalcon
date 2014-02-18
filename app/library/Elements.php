<?php

use Phalcon\Mvc\User\Component;

class Elements extends Component
{
	public function getChannel(){
		$links = array('<a class="" href="/">Home</a> ',
			'<a href="http://netkiller-github-com.iteye.com/">ITEYE 博客</a>',
			'<a href="http://my.oschina.net/neochen/">OSChina 博客</a>',
			'<a href="http://rline.blog.51cto.com/">51CTO 博客</a>'
		);
		
		
		return($links);
	}
    public function getMenu()
    {
		$links = array(
				array('title'=>'Home', 'link'=>'/'),
				array('title'=>'Technology','link'=>'/technology/'),
				array('title'=>'About','link'=>'/about/')
		);
        //...
		return($links);
    }
	public function getMenuitem($menu)
    {
		$menu = substr($menu, 1, strpos($menu,'/',1)-1);
		if(empty($menu)){
			$menu = 'home';
		}
		$submenu = array(
			'home' => array(
				array('title'=>'About', 'link'=>'/about/'),
				array('title'=>'Technology','link'=>'/technology/'),
				array('title'=>'About','link'=>'/about/')
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
			)
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
