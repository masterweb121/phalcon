<?php
namespace Photography\Components;
use Phalcon\Mvc\User\Component;

class Browse extends Component{
	public $path	= '';
	public $format 	= array();
	public $debug	= false;
	public $excludes	= array();
	public $filter		= array();
	public $resources	= array(); //'dir'=> '', 'file'=>''
	private $handle 	= null;

	public function debug($debug){
		$this->debug = $debug;
	}
	public function opendir($dir = null){
		if (is_dir($dir)) {
			$this->path = $dir;
		}
	}
	public function readdir(){
		if ($this->handle = opendir($this->path)) {
		    while (false !== ($file = readdir($this->handle))) {
		    	$this->resources[] = $file;
		    }
		    closedir($this->handle);
		}
		return $this->resources;
	}
	public function scandir($dir = null){
		if($dir){
			$this->path = $dir;
		}
		if(is_dir($this->path)){
			$this->resources = scandir($this->path);
		}
		return $this->resources;
	}
	public function dirlist(){
		$dirs = array();
		foreach ($this->resources as $key => $resource){
			if($this->excludes){
				if(in_array($resource, $this->excludes['dirname'])){
					unset($this->resources[$key]);
					continue;
				}
			}
			if(is_dir($this->path.'/'.$resource)){
				$dirs[] = $resource;
			}
		}
		return $dirs;
	}
	public function filelist(){
		$files = array();
		if(!$this->resources)return;
		foreach ($this->resources as $key => $resource){
			$info = pathinfo($resource);
			if(is_file($this->path.'/'.$resource)){
				if( $this->excludes ){
					if(in_array(strtolower($info['extension']), $this->excludes['extension'])){
						unset($this->resources[$key]);
						continue;
					}
				}
				if( $this->filter ){
					if(!in_array(strtolower($info['extension']), $this->filter['extension'])){
						unset($this->resources[$key]);
						continue;
					}
				}
				$files[] = $resource;
			}
		}
		return $files;
	}
	public function exclude($excludes = null){
		if($excludes){
			$this->excludes = $excludes;
		}else{
			$this->excludes = array('dirname' => array(), 'basename' => array(), 'extension' => array(), 'filename'=> array());
		}
	}
	public function filter($filter = null){
		if($filter){
			$this->filter = $filter;
		}else{
			$this->filter = array('dirname' => array(), 'basename' => array(), 'extension' => array(), 'filename'=> array());
		}
	}
	public function thumbnail(){
	}
	/*
	 * //start the program
	 * echo "<h2>目录为粉红色</h2>";
	 * tree(".");
	 */
	public function tree($directory)
	{
		$mydir=dir($directory);
		echo "<ul>";
		while($file=$mydir->read()){
			if((is_dir("$directory/$file")) AND ($file!=".") AND ($file!="..")){
				echo "<li><font color='#ff00cc'><b>$file</b></font></li>";
				tree("$directory/$file");
			}else{
				echo "<li>$file</li>";
			}
		}
		echo "</ul>";
		$mydir->close();
	}

	public function log(){
		if($this->debug){
		    echo "Directory handle: $this->handle\n";
		}

	}

}