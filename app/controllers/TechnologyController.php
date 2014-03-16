<?php

class TechnologyController extends HomeController
{
	public function initialize()
    {
        $this->view->setTemplateAfter('index');
		//Set the document title
        $this->tag->setTitle('Technology');
        parent::initialize();
    }
	
    public function indexAction()
    {
		
		//$content = $cache->start($book.'/'.$page);
		// If $content is null then the content will be generated for the cache
		//if ($content === null) {	
			// Store the output into the cache file
		//	$cache->save();

		//} 
    }
	public function linuxAction(){
		$book='linux';

		$html = $this->docbook($book);
		$response = new \Phalcon\Http\Response();
		$response->setContent($html);
		
		//$expireDate = new DateTime();
		//$expireDate->modify('+5 minutes');
		//$response->setExpires($expireDate);		
		echo $html;
	}
	public function centosAction(){
		$book='centos';
		$html = $this->docbook($book);
		
		$response = new \Phalcon\Http\Response();
		$response->setContent($html);
		
		$expireDate = new DateTime();
		$expireDate->modify('+5 minutes');
		$response->setExpires($expireDate);		
		echo $html;
	}
	public function mysqlAction(){
		$book='mysql';
		$html = $this->docbook($book);
		
		$response = new \Phalcon\Http\Response();
		$response->setContent($html);
		
		$expireDate = new DateTime();
		$expireDate->modify('+5 minutes');
		$response->setExpires($expireDate);		
		echo $html;
	}
	public function freebsdAction(){
		$book='freebsd';
		$html = $this->docbook($book);
		
		$response = new \Phalcon\Http\Response();
		$response->setContent($html);
		
		$expireDate = new DateTime();
		$expireDate->modify('+5 minutes');
		$response->setExpires($expireDate);		
		echo $html;
	}
	public function architectAction(){
		$book='architect';
		$html = $this->docbook($book);
		
		$response = new \Phalcon\Http\Response();
		$response->setContent($html);
		
		$expireDate = new DateTime();
		$expireDate->modify('+5 minutes');
		$response->setExpires($expireDate);		
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

		$page = str_replace('/technology/'.$book.'/','', $_GET['_url']);
		if(empty($page)){
			$page = 'index.html';
		}
		
		$subdir = substr($page, 0, strrpos($page,'/'));
		
		$img = strrpos($page,'.png');
		if($img){
			$this->view->disable();
		}

		//Create an Output frontend. Cache the files for 2 days
		$frontCache = new Phalcon\Cache\Frontend\Output(array(
			"lifetime" => 172800
		));

		// Create the component that will cache from the "Output" to a "File" backend
		// Set the cache file directory - it's important to keep the "/" at the end of
		// the value for the folder
		$cache = new Phalcon\Cache\Backend\File($frontCache, array(
			"cacheDir" => "/var/tmp/cache/"
		));

		$url = 'http://192.168.6.2/'.$book.'/'.$page;
		
		// Try to get cached records
		$cacheKey = 'doc.'.crc32($url);
		$content    = $cache->get($cacheKey);
		if ($content === null) {
			$content = @file_get_contents($url); 
			
			if($subdir){
				$prefix='/technology/'.$book.'/'.$subdir.'/';
			}else{
				$prefix='/technology/'.$book.'/';
			}
			$content = str_replace('href="', 'href="'.$prefix, $content);
			$content = str_replace('src="', 'src="'.$prefix, $content);
			$content = str_replace('href="'.$prefix.'http://', 'href="http://', $content);
			
			// Store it in the cache
			$cache->save($cacheKey, $content);
		}	

		return( $content );
	} 

	public function searchAction(){
	
	}
	// crypt and htpasswd
	public function cryptAction($password){
        	print(crypt($password));
        	$this->view->disable();
	}
	public function md5Action($digst){
        	print(md5($digst));
        	$this->view->disable();
	}
	public function sha1Action($digst){
        	print(sha1($digst));
        	$this->view->disable();
	}
    public function myipAction(){
        print($_SERVER['REMOTE_ADDR']);
        $this->view->disable();
	}
    public function ipAction(){
        $this->view->result = null;
        if($this->request->getPost()){
            $ipaddr = $this->request->getPost("ip", "string");
            $url = sprintf("http://api.map.baidu.com/location/ip?ak=IoN3tUhZjq78v2DyeztYLQEO&ip=%s&coor=bd09ll",$ipaddr);
            
            $result = json_decode(file_get_contents($url), TRUE);
            $this->view->result = $result;
            //print_r($result);
            
        }
    }
}
