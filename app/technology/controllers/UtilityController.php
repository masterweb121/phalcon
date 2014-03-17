<?php
namespace Technology\Controllers;
class UtilityController extends \Phalcon\Mvc\Controller
{
	public function initialize()
    {
        $this->view->setTemplateAfter('theme');
		//Set the document title
        $this->tag->setTitle('Technology - Utility Programs');
        //parent::initialize();
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


	public function searchAction(){
	
	}
	// crypt and htpasswd
	public function cryptAction($password = null){

		if($password){
			print(crypt($password));
			$this->view->disable();
		}else if ($this->request->isPost() == true) {
			$password = $this->request->getPost("password", "string");
			if($salt = $this->request->getPost('salt','string')){
				$encrypt = crypt($password, $salt);
			}else{
				$encrypt = crypt($password);
			}
			$this->view->encrypt = $encrypt;
		}
	}
	public function md5Action($string){
        $this->view->digest = '';
		if($string){
        	print(md5($string));
        	$this->view->disable();
        }else if ($this->request->isPost() == true) {
			$string = $this->request->getPost("string", "string");
			$this->view->digest = md5($string);
		}
	}
	public function sha1Action($string){
        $this->view->digest = '';
		if($string){
        	print(sha1($string));
        	$this->view->disable();
        }else if ($this->request->isPost() == true) {
			$string = $this->request->getPost("string", "string");
			$this->view->digest = sha1($string);
		}        	
	}
    public function crc32Action($string){
        $this->view->digest = '';
		if($string){
        	print(crc32($string));
        	$this->view->disable();
        }else if ($this->request->isPost() == true) {
			$string = $this->request->getPost("string", "string");
			$this->view->digest = crc32($string);
		}        	
	}
    public function urlAction($type,$url){

		if($type == 'encode'){
        	print(urlencode( $url ));
            $this->view->disable();
        }else if ($type == 'decode') {
			print(urldecode( $url ));
            $this->view->disable();
		}
        if ($this->request->isPost() == true) {
            $type = $this->request->getPost("type", "string");
            $url = $this->request->getPost("url", "string");
            if($type == 'encode'){
                $this->view->url = urlencode( $url );
            }else{
                $this->view->url = urldecode( $url );
            }
        }
	}
    public function base64Action($type,$url){

		if($type == 'encode'){
        	print(base64_encode( $url ));
            $this->view->disable();
        }else if ($type == 'decode') {
			print(base64_decode( $url ));
            $this->view->disable();
		}
        $this->view->text = '';
        if ($this->request->isPost() == true) {
            $type = $this->request->getPost("type", "string");
            $text = $this->request->getPost("text", "string");

            if($type == 'encode'){
                $this->view->text = base64_encode( $text );
            }else{
                $this->view->text = base64_decode( $text );
            }
        }
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
