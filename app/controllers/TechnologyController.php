<?php

class TechnologyController extends HomeController
{
	public function initialize()
    {
        //$this->view->setTemplateAfter('home');
		//Set the document title
        $this->tag->setTitle('Signup');
        parent::initialize();
    }
	
    public function indexAction()
    {

    }
	public function linuxAction(){
		$book='linux';
		$page = str_replace('/technology/'.$book.'/','', $_GET['_url']);
		if(empty($page)){
			$page = 'index.html';
		}
		//print_r($_GET);
		$html = $this->docbook($book,$page);
		$response = new \Phalcon\Http\Response();
		$response->setContent($html);
		
		$expireDate = new DateTime();
		$expireDate->modify('+1 minutes');
		$response->setExpires($expireDate);
		echo $html;
	}
	public function docbook($book,$page){
	
		$url = 'http://netkiller.github.io/'.$book.'/'.$page;
		//echo $url;
		$html = @file_get_contents($url); 
		
		$html = str_replace('href="', 'href="/technology/'.$book.'/', $html);
		$html = str_replace('src="', 'src="/technology/'.$book.'/', $html);
		
		return( $html );
	} 
    public function registerAction()
    {
        $user = new Users();

        //Store and check for errors
        $success = $user->save($this->request->getPost(), array('name', 'email'));

        if ($success) {
            echo "Thanks for registering!";
        } else {
            echo "Sorry, the following problems were generated: ";
            foreach ($user->getMessages() as $message) {
                echo $message->getMessage(), "<br/>";
            }
        }

        $this->view->disable();
    }
}
