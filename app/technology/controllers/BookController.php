<?php
namespace Technology\Controllers;
class BookController extends \Phalcon\Mvc\Controller
{
	public function initialize()
    {
        $this->view->setTemplateAfter('theme');
		//Set the document title
        //$this->tag->setTitle('Home');
        $this->view->menu = new \Technology\Components\Menu($this->dispatcher->getControllerName(), $this->dispatcher->getActionName());
    }
	
    public function indexAction()
    {
        echo "<h1>Hello!</h1>";
    }
	public function linuxAction(){
		$book='linux';

		$html = $this->docbook($book);
		//$response = new \Phalcon\Http\Response();
		//$response->setContent($html);
		
		//$expireDate = new DateTime();
		//$expireDate->modify('+5 minutes');
		//$response->setExpires($expireDate);		
		echo $html;
	}
	public function centosAction(){
		$book='centos';
		$html = $this->docbook($book);
		/*
		$response = new \Phalcon\Http\Response();
		$response->setContent($html);
		
		$expireDate = new DateTime();
		$expireDate->modify('+5 minutes');
		$response->setExpires($expireDate);		
         * 
         */
        //$this->view->partial('layouts/book');
		echo $html;
	}
	public function mysqlAction(){
		$book='mysql';
		$html = $this->docbook($book);
		
//		$response = new \Phalcon\Http\Response();
//		$response->setContent($html);
//		
//		$expireDate = new DateTime();
//		$expireDate->modify('+5 minutes');
//		$response->setExpires($expireDate);		
		echo $html;
	}
	public function freebsdAction(){
		$book='freebsd';
		$html = $this->docbook($book);
		
//		$response = new \Phalcon\Http\Response();
//		$response->setContent($html);
//		
//		$expireDate = new DateTime();
//		$expireDate->modify('+5 minutes');
//		$response->setExpires($expireDate);		
		echo $html;
	}
	public function architectAction(){
		$book='architect';
		$html = $this->docbook($book);
		
//		$response = new \Phalcon\Http\Response();
//		$response->setContent($html);
//		
//		$expireDate = new DateTime();
//		$expireDate->modify('+5 minutes');
//		$response->setExpires($expireDate);		
		echo $html;
	}
	public function developerAction(){
		$book='developer';
		$html = $this->docbook($book);
		echo $html;
	}
	public function phpAction(){
		$book='php';
		$html = $this->docbook($book);
		echo $html;
	}
	public function freebookAction($book){
		print_r( $this->elements->getChannel());
	}
	public function docbook($book){

		$page = str_replace('/technology/book/'.$book.'/','', $_GET['_url']);
		if(empty($page)){
			$page = 'index.html';
		}
		$subdir = substr($page, 0, strrpos($page,'/'));
		
		$img = strrpos($page,'.png');
		if($img){
			$this->view->disable();
		}
        $url = 'http://192.168.6.2/'.$book.'/'.$page;
		//echo $url;
        
		//Create an Output frontend. Cache the files for 2 days
		$frontCache = new \Phalcon\Cache\Frontend\Output(array(
			"lifetime" => 172800
		));

		// Create the component that will cache from the "Output" to a "File" backend
		// Set the cache file directory - it's important to keep the "/" at the end of
		// the value for the folder
		$cache = new \Phalcon\Cache\Backend\File($frontCache, array(
			"cacheDir" => "/var/tmp/cache/"
		));

		// Try to get cached records
		$cacheKey = 'doc.'.crc32($url);
		$content    = $cache->get($cacheKey);
		if ($content === null) {
			$content = @file_get_contents($url); 
			
			if($subdir){
				$prefix='/technology/book/'.$book.'/'.$subdir.'/';
			}else{
				$prefix='/technology/book/'.$book.'/';
			}
			$content = str_replace('href="', 'href="'.$prefix, $content);
			$content = str_replace('src="', 'src="'.$prefix, $content);
			$content = str_replace('href="'.$prefix.'http://', 'href="http://', $content);
			
			// Store it in the cache
			$cache->save($cacheKey, $content);
		}	

		return( $content );
	} 
}