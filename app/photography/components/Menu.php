<<<<<<< HEAD
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
            array('title'=>'Home', 'link'=>'photography'),
            array('title'=>'相册', 'link'=>'photography/album'),
            array('title'=>'镜头','link'=>'photography/lens'),
            array('title'=>'相机','link'=>'photography/camera'),
		);
		return( $menu );
    }
	public function getSubmenu($menu = null)
    {
		$submenu = array(
            'photography' => array(
				array('title'=>'2014','link'=>'/photography/album/2014/'),
				array('title'=>'2013','link'=>'/photography/album/2013/'),
				array('title'=>'2012','link'=>'/photography/album/2012/'),
				array('title'=>'2011','link'=>'/photography/album/2011/'),
				array('title'=>'2010','link'=>'/photography/album/2010/')
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
=======
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
				array('title'=>'About','link'=>'about')
		);
		return($links);
	}
    public function getMenu()
    {
		$menu = array(
            array('title'=>'Home', 'link'=>'photography'),
            array('title'=>'相册', 'link'=>'photography/album'),

		);
		return( $menu );
    }
	public function getSubmenu($menu = null)
    {
		$submenu = array(
			'index' => array(
				array('title'=>'镜头','link'=>'photography/lens'),
				array('title'=>'相机','link'=>'photography/camera'),
			),
            'photography' => array(
				array('title'=>'2014','link'=>'/photography/album/2014/'),
				array('title'=>'2013','link'=>'/photography/album/2013/'),
				array('title'=>'2012','link'=>'/photography/album/2012/'),
				array('title'=>'2011','link'=>'/photography/album/2011/'),
				array('title'=>'2010','link'=>'/photography/album/2010/')
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
>>>>>>> 51ce5c10d40da882c42d75bede219723c3c51f6b
