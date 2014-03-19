<<<<<<< HEAD
<?php
namespace Multiple\Outdoor\Controllers;
class IndexController extends \Phalcon\Mvc\Controller
{
	public function initialize()
    {
        //$this->view->setTemplateAfter('common');
		//Set the document title
        //$this->tag->setTitle('Home');
        parent::initialize();
    }
	
    public function indexAction()
    {
        echo "<h1>Hello!</h1>";
    }

}
=======
<?php
namespace Outdoor\Controllers;
class IndexController extends \Phalcon\Mvc\Controller
{
	public function initialize()
    {
        //$this->view->setTemplateAfter('common');
		//Set the document title
        //$this->tag->setTitle('Home');
        //parent::initialize();
    }
	
    public function indexAction()
    {
        
    }

}
>>>>>>> 51ce5c10d40da882c42d75bede219723c3c51f6b
