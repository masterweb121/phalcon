<?php

class PhotographyController extends HomeController
{
	public function initialize()
    {
        $this->view->setTemplateAfter('index');
		//Set the document title
        $this->tag->setTitle('photography');
        parent::initialize();
        $this->photodir = 'images';

        // Cache the files for 2 days using a Data frontend
		$frontCache = new Phalcon\Cache\Frontend\Data(array(
		    "lifetime" => 3600
		));

		// Create the component that will cache "Data" to a "File" backend
		// Set the cache file directory - important to keep the "/" at the end of
		// of the value for the folder
		$this->cache = new Phalcon\Cache\Backend\File($frontCache, array(
		    "cacheDir" => "/var/tmp/cache/"
		));
    }
	
    public function indexAction()
    {

    
    }
    public function galleryAction($year){

    }
	public function collectionAction()
    {
		$this->browse->scandir($this->photodir.'/');
		$this->browse->exclude(array('dirname'=> array('.','..')));
		$this->view->collections = $this->browse->dirlist();
    }
    
	public function albumAction($collection){

		$cacheKey = 'photo.'.$collection;
		$albums   = $this->cache->get($cacheKey);
		if ($albums === null) {

			$this->browse->scandir($this->photodir.'/'.$collection);
			$this->browse->exclude(array('dirname'=> array('.','..')));
			$albums = $this->browse->dirlist();
			$this->cache->save($cacheKey, $albums);
		}
		$lattices = array();
		foreach ($albums as $album){
			$cacheKey = 'photo.'.$collection.'.'.$album;
			$photos   = $this->cache->get($cacheKey);
			if ($photos === null) {

				$this->browse->scandir($this->photodir.'/'.$collection.'/'.$album);
				//print_r($this->browse->dirlist());
				$this->browse->filter(array('extension'=> array('jpg','png')));
				$this->browse->exclude(array('extension'=> array('db','gif')));
				$photos = $this->browse->filelist();
			    // Store it in the cache
			    $this->cache->save($cacheKey, $photos);
			}
			$lattices[] = array('album'=>$album,'cover'=>$this->photodir.'/'.$collection.'/'.$album.'/'.current($photos),'count'=>count($photos));
		}	

		$this->view->collection = $collection;
		$this->view->albums = $albums;
		$this->view->lattices = $lattices;

	}
	public function slideAction($album){

	}
	public function previewAction($album){

	}
	public function viewAction($collection, $album, $page = null){

		// Try to get cached records
		$cacheKey = $collection.'.'.$album;
		$matrixs   = $this->cache->get($cacheKey);
		if ($matrixs === null) {

			$this->browse->scandir($this->photodir.'/'.$collection.'/'.$album);
			//print_r($this->browse->dirlist());
			$this->browse->filter(array('extension'=> array('jpg','png')));
			$this->browse->exclude(array('extension'=> array('db','gif')));
			$photos = $this->browse->filelist();

			$matrixs = @array_chunk(@array_chunk($photos, 4, true), 4, false);
		    // Store it in the cache
		    $this->cache->save($cacheKey, $matrixs);
		}

		if(empty($page)) $page = 0;
		if($page > count($matrixs)) $page = count($matrixs) - 1;

		$pages['count'] = count($matrixs)-1;
		$pages['current'] = $page;
		$pages['first'] = 0;
		$pages['previous'] = $page<0?$page=0:$page-1;
		$pages['next'] = $page>$pages['count']?$page=$pages['count']:$page+1;
		$pages['last'] = $pages['count'];

		$this->view->collection = $collection;
		$this->view->album = $album;
		$this->view->matrixs = $matrixs[$page];
		$this->view->pages = $pages;

	}
	public function photoAction($collection, $album, $image){

		$cacheKey = 'photo.'.$collection.'.'.$album;
		$photos   = $this->cache->get($cacheKey);
		if ($photos === null) {

			$this->browse->scandir($this->photodir.'/'.$collection.'/'.$album);
			//print_r($this->browse->dirlist());
			$this->browse->filter(array('extension'=> array('jpg','png')));
			$this->browse->exclude(array('extension'=> array('db','gif')));
			$photos = $this->browse->filelist();
		    // Store it in the cache
		    $this->cache->save($cacheKey, $photos);
		}

		$length=9;
		$current_image_key = current(array_keys($photos, $image));
		echo $current_image_key;
				if($current_image_key == 0){
					$offset = 0;
				}else if($current_image_key < 4){
					$offset = 0;
				}else if($current_image_key + 4 > count($photos)-1 ){ //&& $current_image_key < count($photos)
					$offset = count($photos) - 9;
				}else{
					$offset = $current_image_key - 4;
				}

		$related = array_slice($photos,$offset,$length,$preserve = true);

		$this->view->collection = $collection;
		$this->view->album = $album;
		$this->view->related = $related;
		$this->view->image = $this->photodir.'/'.$collection.'/'.$album.'/'.$image;

	}
	public function propertiesAction($collection, $album, $image){
		$this->view->collection = $collection;
		$this->view->album = $album;
		$this->view->image = $this->photodir.'/'.$collection.'/'.$album.'/'.$image;
	}
	public function thumbnailAction($collection,$album,$image)
    {

		$path = $this->photodir.'/'.$collection.'/'.$album.'/'.$image;
		//$path = 'images/2014/BBBB/IMG_2618.JPG'
		//echo $path;
/*
		$path_parts = pathinfo($imagefile);
		if($path_parts['extension'] == 'gif'){
			//header("Expires: " .gmdate ("D, d M Y H:i:s", time() + 3600 * 24 * 30). " GMT");
			header('Content-type: ' .mime_content_type($path));
			flush();
			readfile($path);
			exit;
		}
*/
		if (file_exists($path)) {
			ob_start();
			if ($image = @exif_thumbnail($path, $width, $height, $type)) {
				// Expires one month later
				header("Expires: " .gmdate ("D, d M Y H:i:s", time() + 3600 * 24 * 30). " GMT");
				header('Content-type: ' .image_type_to_mime_type($type));
				flush();
				echo $image;
			}else{
				// File and new size
				$filename = $path;
				// Get new sizes
				list($width, $height) = getimagesize($filename);
//				$percent = 0.5;
//				$newwidth = $width * $percent;
//				$newheight = $height * $percent;

				if($width >$height){
					$newwidth = 160;
					$newheight = 112;
				}else{
					$newwidth = 112;
					$newheight = 160;
				}
				// Load
				$thumb = imagecreatetruecolor($newwidth, $newheight);
				$source = imagecreatefromjpeg($filename);
				// Resize
				imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
				// Content type
				header('Content-type: ' .mime_content_type($path));
				// Output
				imagejpeg($thumb);
			}
			ob_end_flush();
		}
		$this->view->disable();
    }
	public function histogramsAction()
    {
		
    }
	public function exifAction()
    {
		
    }
}
