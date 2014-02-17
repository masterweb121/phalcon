<?php

use Phalcon\Mvc\User\Component;

class Elements extends Component
{
	public function getChannel(){
		$links = array('<a class="" href="/">Home</a> ','<a class="" href="/">Blog</a> ','<a class="" href="/">News</a> ');
		//foreach ($links as $l){
			//yield $l;
			//echo $link;
		//}
		
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
		$submenu = array('/about/' => array(
				array('title'=>'Home', 'link'=>'/'),
				array('title'=>'Technology','link'=>'/technology/'),
				array('title'=>'About','link'=>'/about/')
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
