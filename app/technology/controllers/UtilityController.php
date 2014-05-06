<?php
namespace Technology\Controllers;
class UtilityController extends \Phalcon\Mvc\Controller
{
	public function initialize()
    {
        $this->view->setTemplateAfter('theme');
		//Set the document title
        $this->tag->setTitle('Technology - Utility Programs');
        $this->view->menu = new \Technology\Components\Menu($this->dispatcher->getControllerName(), $this->dispatcher->getActionName());
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
        $this->view->encrypt = null;
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
        $this->view->url = null;
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
    public function usbtokenAction(){
        if ($this->request->isPost() == true) {
            //$this->view->disable();
            //printf("USB Key: %s", $this->request->getPost("usbkey", "string"));
        }
	}
    public function passwordAction(){
        //$this->view->password = system("cat /dev/urandom | tr -cd [:alnum:] | fold -w30 | head -n 20");
        $this->view->password = '';
    }
    public function soapAction(){
        $this->view->forms = null;
        if ($this->request->isPost() == true) {
            $this->view->forms = (object)$this->request->getPost();
            $options = array('uri' => $this->request->getPost("uri", "string"),
                'location'=>$this->request->getPost("location", "string"),
                'compression' => 'SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP',
                'login'=>$this->request->getPost("login", "string"),
                'password'=>$this->request->getPost("password", "string"),
                'trace'=>true
                                );
            try {
                $client = new \SoapClient(null, $options);
                $func   = $this->request->getPost("func", "string");
                $param  = $this->request->getPost("param", "string");
                if($param){
                    $this->view->output = call_user_func_array(array($client, $func),  explode($delimiter = ',', $param));
                }else{
                    $this->view->output = $client->$func();
                }
            }
            catch (Exception $e)
            {
                $this->view->disable();
                echo 'Caught exception: ',  $e->getMessage(), "\n";
            }
        }
    }
    public function jsonAction($op = null){
        $this->view->output = null;
        if ($this->request->isPost() == true){
            if($op === 'code'){
                $type = $this->request->getPost("type", "string");
                if($type == "encode"){
                    $string = $_POST['string'];
                    $arr = explode(",", $string);
                    print_r(json_encode($arr));
                    $this->view->output = json_encode($arr);
                }
                if($type == "decode"){

                    $json = $_POST['string'];
                    $assoc = $this->request->getPost("assoc");
                    //stripslashes($this->request->getPost("string", "string"));
                    //print_r(json_decode($json, $assoc));

                    if($assoc == 'Y'){
                        $this->view->output = print_r(json_decode($json, true),true);
                    }else{
                        $this->view->output = var_export(json_decode($json, false),true);
                    }
                }
            }
            if($op === 'get'){
                //$this->view->disable();
                echo $this->request->getPost("decode");
                if($this->request->getPost("decode")){
                    $this->view->output = print_r(json_decode(file_get_contents($this->request->getPost("url", "string"))),true);
                }else{
                    $this->view->output = file_get_contents($this->request->getPost("url", "string"));
                }
            }
        }
    }
    public function hash_hmacAction(){
        $algos = array();
        foreach(hash_algos() as $key=>$val){
            $algos[$val] = $val;
        }
        $this->view->algos =$algos;
        $this->view->hmac = null;
        if ($this->request->isPost() == true) {
            $this->view->hmac = hash_hmac($this->request->getPost("algos"), $this->request->getPost("string"), $this->request->getPost("secret"));
        }
    }
    public function uniqidAction(){
        $this->view->uniqid = null;
        $this->view->uniqid = uniqid();
        if ($this->request->isPost() == true) {
            if($this->request->getPost("prefix")){
                $this->view->uniqid = uniqid($this->request->getPost("prefix"));
            }
        }
    }
    public function sshkeygenAction(){

    }
}
