<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Photography\Controllers;

/**
 * Description of EquipmentController
 *
 * @author neo
 */
class CollectionController extends PhotographyController {
    public function initialize()
    {
//        $this->view->setTemplateAfter('theme');
        $this->tag->setTitle('- Collection');
        $this->browse = new \Photography\Components\Browse();
        $this->photodir = '/www/phalcon/public/images';
        parent::initialize();

        // Cache the files for 2 days using a Data frontend
		$frontCache = new \Phalcon\Cache\Frontend\Data(array(
		    "lifetime" => 3600
		));

		// Create the component that will cache "Data" to a "File" backend
		// Set the cache file directory - important to keep the "/" at the end of
		// of the value for the folder
		$this->cache = new \Phalcon\Cache\Backend\File($frontCache, array(
		    "cacheDir" => "/var/tmp/cache/"
		));        
    }
    public function indexAction()
    {
        $this->browse->scandir($this->photodir.'/');
		$this->browse->exclude(array('dirname'=> array('.','..')));
		$this->view->collections = $this->browse->dirlist();
    }

	public function albumAction($collection){
        $this->tag->appendTitle(' - Album');
		$albums   = $this->dirlist($collection);

		$lattices = array();
		foreach ($albums as $album){
			$photos   = $this->filelist($collection, $album);
			$lattices[] = array('album'=>$album,'cover'=>$collection.'/'.$album.'/'.current($photos),'count'=>count($photos));
		}	

		$this->view->collection = $collection;
		$this->view->albums = $albums;
		$this->view->lattices = $lattices;

    }

    private function dirlist($collection){
    	$cacheKey = 'photo.'.$collection;
		$albums = $this->cache->get($cacheKey);
		if ($albums === null) {
			$dir = $this->browse->scandir($this->photodir.'/'.$collection);
			$this->browse->exclude(array('dirname'=> array('.','..')));
			$albums = $this->browse->dirlist();
			$this->cache->save($cacheKey, $albums);
		}
		return($albums);
    }
    private function filelist($collection, $album){
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
		return($photos);
    }  
	public function slideAction($collection, $album, $image){ //maximize
		$photos   = $this->filelist($collection, $album);

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
		$this->view->album 		= $album;
		$this->view->related 	= $related;
		$this->view->image 		= $image;
		$this->view->imagepath	= $collection.'/'.$album.'/'.$image;
		$this->view->exif 		= $this->exif($this->photodir.'/'.$collection.'/'.$album.'/'.$image);
	}
	public function viewAction($collection, $album, $page = null){

		// Try to get cached records
		$cacheKey = 'photo.matrixs.'.$collection.'.'.$album;
		$matrixs   = $this->cache->get($cacheKey);
		if ($matrixs === null) {
			$photos = $this->filelist($collection, $album);
			if($photos){
				$matrixs = array_chunk(array_chunk($photos, 4, true), 4, false);	
				// Store it in the cache
				$this->cache->save($cacheKey, $matrixs);
			}
		}
        //print_r($matrixs);
        //$this->view->disable();
		if(empty($page)) $page = 0;
		if($page > count($matrixs)) $page = count($matrixs) - 1;

		$pages['count'] = count($matrixs)-1;
		$pages['current'] = $page;
		$pages['first'] = 0;
		$pages['previous'] = $page<0?$page=0:$page-1;
		$pages['next'] = $page>$pages['count']?$page=$pages['count']:$page+1;
		$pages['last'] = $pages['count'];

		$albums   = $this->dirlist($collection);

		$this->view->collection = $collection;
		$this->view->album = $album;
		$this->view->albums = $albums;
		$this->view->matrixs = $matrixs[$page];
		$this->view->pages = $pages;

	}
	public function photoAction($collection, $album, $image){

		$photos   = $this->filelist($collection, $album);

		$length=12;
		$current_image_key = current(array_keys($photos, $image));
		echo $current_image_key;
				if($current_image_key == 0){
					$offset = 0;
				}else if($current_image_key < 4){
					$offset = 0;
				}else if($current_image_key + 4 > count($photos)-1 ){ //&& $current_image_key < count($photos)
					$offset = count($photos) - $length;
				}else{
					$offset = $current_image_key - 4;
				}

		$related = array_slice($photos,$offset,$length,$preserve = true);

		$this->view->collection = $collection;
		$this->view->album 		= $album;
		$this->view->related 	= $related;
		$this->view->image 		= $image;
		$this->view->imagepath	= $collection.'/'.$album.'/'.$image;
		$this->view->exif 		= $this->exif($this->photodir.'/'.$collection.'/'.$album.'/'.$image);

		//$this->view->histogram = $image;

	}
	public function propertiesAction($collection, $album, $image){
		$this->view->collection = $collection;
		$this->view->album = $album;
		$this->view->image = $this->photodir.'/'.$collection.'/'.$album.'/'.$image;
	}
	public function thumbnailAction($collection,$album,$image)
    {

		$path = $this->photodir.'/'.$collection.'/'.$album.'/'.$image;
//		echo $path;

//		$expireDate = new \DateTime();
//		$expireDate->modify('+1 days');

		$response = new \Phalcon\Http\Response();
//		$response->setExpires($expireDate);

		//Starting from now, cache the page for one day
//		$response->setHeader('Cache-Control', 'max-age=86400');

		//Send an E-Tag header
		$eTag = md5($path);        
		$response->setHeader('E-Tag', $eTag);

		flush();
		if (file_exists($path)) {
			ob_start();
			if ($image = exif_thumbnail($path, $width, $height, $type)) {
				// Expires one month later
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
    public function imageAction($collection, $album, $image){
    	$path = $this->photodir.'/'.$collection.'/'.$album.'/'.$image;
		//$path_parts = pathinfo($imagefile);
		//if($path_parts['extension'] == 'gif'){
    	if (file_exists($path)) {
			//header("Expires: " .gmdate ("D, d M Y H:i:s", time() + 3600 * 24 * 30). " GMT");
			header('Content-type: ' .mime_content_type($path));
			flush();
			ob_start();
			readfile($path);
			ob_end_flush();
		}
		$this->view->disable();
    }
	public function histogramAction($collection, $album, $image)
    {
    	$imageFile = $this->photodir.'/'.$collection.'/'.$album.'/'.$image;
    	$cacheDir 	= '/var/tmp/cache/histograms';
    	$cacheFile	= $cacheDir.'/'.$collection.'/'.$album.'/'.$image;
    	if(!is_dir(dirname($cacheFile))){
    		mkdir( dirname($cacheFile),'755',true);	

    	}
		if (!file_exists($cacheFile)) {
			$this->makeMassHistogram($imageFile,$cacheFile,'#000000');
		}
		$this->view->disable();
		header('Content-type: ' .mime_content_type($cacheFile));
		flush();
		ob_start();
		readfile ($cacheFile);
		ob_end_flush();
    }
	private function exif($image)
    {
		if(!function_exists('exif_read_data')) {
			die('please install exif module!');
		}
		$exifdata = @exif_read_data($image, 'EXIF');
		$filter = array(
			'Make',
			'Model',
			'ExposureProgram',
			'ApertureFNumber',
			'FNumber',
			'ExposureTime',
			'FocalLength',
			'ISOSpeedRatings',
			'MeteringMode',
			'WhiteBalance',
			'ExposureBiasValue',
			'Flash',
		/*	'ShutterSpeedValue',
		 	'ApertureValue',*/
			'Software',
			'DateTime'
		);
		$exif = array();
		foreach($exifdata as $k=>$v){
			if(in_array($k,$filter)){
				switch($k){
					case 'FNumber':
					case 'ShutterSpeedValue':
					case 'ApertureValue':
						list($v1,$v2) = explode('/',$v);
						$value = intval($v1) / intval($v2);
						$exif[$k] = 'f'.$value;
						break;
					case 'FocalLength':
						list($v1,$v2) = explode('/',$v);
						$value = intval($v1) / intval($v2);
						$exif[$k] = $value.'MM';
						break;
					case 'ExposureProgram':
						$value = array(
							'0' => '',
							'1' => 'Means manual control',
							'2' => 'Program normal',
							'3' => 'Aperture priority',
							'4' => 'Shutter priority',
							'5' => 'Program creative (slow program)',
							'6' => 'Program action(high-speed program)',
							'7' => 'Portrait mode',
							'8' => 'Landscape mode'
						);

						if(array_key_exists($v, $value)){
							$exif[$k] = $value[$v];
                        }else{
                        	$exif[$k] = $v;
                        }
						break;
					case 'MeteringMode':
						$value = array(
							'0' => 'means unknown',
							'1' => 'average',
							'2' => 'center weighted average',
							'3' => 'spot',
							'4' => 'multi-spot',
							'5' => 'multi-segment',
							'6' => 'partial',
							'255' => 'other'
						);

						if(array_key_exists($v, $value)){
							$exif[$k] = $value[$v];
                        }else{
                        	$exif[$k] = $v;
                        }
						break;
					case 'WhiteBalance':
						$value = array(
							'0' => 'auto',
							'1' => 'Sunny',
							'2' => 'Cloudy',
							'3' => 'Tungsten',
							'4' => 'Flourescent',
							'5' => 'Flash',
							'6' => 'Custom'
						);
						if(array_key_exists($v, $value)){
							$exif[$k] = $value[$v];
                        }else{
                        	$exif[$k] = $v;
                        }
						break;
					case 'Flash':
						$value = array(

							'0' => 'flash not fired',
							'1' => 'auto',
							'2' => 'on',
							'3' => 'red-eye reduction',
							'4' => 'slow synchro',
							'5' => 'auto + red-eye reduction',
							'6' => 'on + red-eye reduction',
/*							'16' =>'external flash',*/

							'16' =>'flash not fired',
							'9' => 'auto + red-eye reduction',
							'25' =>'external flash'
						);
						if(array_key_exists($v, $value)){
							$exif[$k] = $value[$v];
						}else{
							$exif[$k] = $v;
						}
						break;
					case 'ExposureBiasValue':
						$exif[$k] = $v.' EV';
						break;
					default:
						$exif[$k] = $v;
				}

				//$myexif[($language['zh-cn'][$k])] = $exif[$k];
			}
			//					print_r("$k: $v <br>") ;
		}

		return($exif);
    }



    private function makeMassHistogram($image, $histogram, $color) {

		set_time_limit(500);

		$histType = 'combined';

		//HISTOGRAM VARIABLES
		//		$cfgrow = array();
		$source_file = $image;
		$maxheight = 100;
		$barwidth = 1;
		$iscolor = false;
		$im = @ImageCreateFromJpeg($source_file);

		$imgw = imagesx($im);
		$imgh = imagesy($im);
		$n = $imgw*$imgh;
		$histo = array();
		$histoR = array();
		$histoG = array();
		$histoB = array();

		// ZERO HISTOGRAM VALUES

		for ($i=0; $i<256; $i++) {
			$histo[$i] = 0;
			$histoR[$i] = 0;
			$histoG[$i] = 0;
			$histoB[$i] = 0;
		}

		// CALCULATE PIXELS

		for ($i=0; $i<$imgw; $i++) {
			for ($j=0; $j<$imgh; $j++) {
				$rgb = ImageColorAt($im, $i, $j);
				$r = ($rgb >> 16) & 0xFF;
				$g = ($rgb >> 8) & 0xFF;
				$b = $rgb & 0xFF;
				$V = round(($r + $g + $b) / 3);
				$histo[$V] += 1;

				$V = round($r * 1);
				$histoR[$V] += 1 ;
				$V = round($g * 1);
				$histoG[$V] += 1 ;
				$V = round($b * 1);
				$histoB[$V] += 1 ;
			}
		}
		imagedestroy($im);

		// COLOR OR GRAYSCALE
		for ($a=0; $a < count($histoR); $a++) {
			if( $histoR[$a]!= $histoG[$a] || $histoG[$a]!= $histoB[$a]){
				$iscolor = true;
				break;
			}
		}

		//CREATE HISTOGRAM IMAGE
		//if(($_POST['histType'] == 'combined') or ($iscolor == false)) {
		if(($histType == 'combined') or ($iscolor == false)) {
			$imR = imagecreatetruecolor(256, 100)
			or die ("Cannot Initialize new GD image stream");
		} else {
			$imR = imagecreatetruecolor(256, 300)
			or die ("Cannot Initialize new GD image stream");
		}

		// CONVERT BACKGROUND COLOR TO RGB

		$rgbcolor = $this->html2rgb($color);


		//RGB

		if ($iscolor)
		{
			// MAKE BACKGROUND
			$back = imagecolorallocate($imR, $rgbcolor[0], $rgbcolor[1], $rgbcolor[2]);

			// compute bounds of vertical axis

			// sort the histograms to find tallest bins
			$sHistoR = $histoR;
			$sHistoG = $histoG;
			$sHistoB = $histoB;
			sort($sHistoR);
			sort($sHistoG);
			sort($sHistoB);

			// we allow clipping of at most the 5 tallest histogram bins, but clipping
			// also needs to be useful. i.e. if clipping does not change the vertical
			// range much, then don't do it. The following heuristic code enforces this.
			$lerpR = min(max(($sHistoR[255]/$sHistoR[250] - 1.15)/2.0, 0.0), 1.0);
			$lerpG = min(max(($sHistoG[255]/$sHistoG[250] - 1.15)/2.0, 0.0), 1.0);
			$lerpB = min(max(($sHistoB[255]/$sHistoB[250] - 1.15)/2.0, 0.0), 1.0);
			$histoClipR = (1.0 - $lerpR)*$sHistoR[255] + $lerpR*$sHistoR[250];
			$histoClipG = (1.0 - $lerpG)*$sHistoG[255] + $lerpG*$sHistoG[250];
			$histoClipB = (1.0 - $lerpB)*$sHistoB[255] + $lerpB*$sHistoB[250];
			$histoClip = max($histoClipR, $histoClipG, $histoClipB);

			//    if ($_POST['histType'] == 'combined')
			if ($histType == 'combined')
			{
				// COMBINED COLOR HISTOGRAM
				imagefilledrectangle($imR, 0, 0, 256, 100, $back);

				// CREATE GRAPH
				for ($a = 0; $a < 256; $a++)
				{
					$heightsRGB = array(min($histoR[$a]/$histoClip, 1.0)*$maxheight,
					min($histoG[$a]/$histoClip, 1.0)*$maxheight,
					min($histoB[$a]/$histoClip, 1.0)*$maxheight);
					$lineOrder = array(0, 1, 2);
					array_multisort($heightsRGB, $lineOrder);

					// Draw 3 vertical lines.
					// First a white line, for the extent that all the histograms overlap,
					// Then as we cross each histogram, remove that appropriate color
					// component.
					$lineRGB = array(255, 255, 255);
					$lineColor = ImageColorAllocateAlpha ($imR, $lineRGB[0], $lineRGB[1], $lineRGB[2], 0);
					$start = $maxheight - $heightsRGB[0];
					$end = $maxheight;
					imageline ($imR,($a+1),$start,($a+1),$end,$lineColor);

					$lineRGB[$lineOrder[0]] = 0;
					$lineColor = ImageColorAllocateAlpha ($imR, $lineRGB[0], $lineRGB[1], $lineRGB[2], 0);
					$start = $maxheight - $heightsRGB[1];
					$end = $maxheight - $heightsRGB[0];
					imageline ($imR,($a+1),$start,($a+1),$end,$lineColor);

					$lineRGB[$lineOrder[1]] = 0;
					$lineColor = ImageColorAllocateAlpha ($imR, $lineRGB[0], $lineRGB[1], $lineRGB[2], 0);
					$start = $maxheight - $heightsRGB[2];
					$end = $maxheight - $heightsRGB[1];
					imageline ($imR,($a+1),$start,($a+1),$end,$lineColor);
				}
			}
			else
			{   // SEPARATE R G B HISTOGRAMS
				imagefilledrectangle($imR, 0, 0, 256, 300, $back);

				// CREATE GRAPH
				for ($a = 0; $a < 256; $a++)
				{
					$lineColor = ImageColorAllocateAlpha ($imR, 255, 0, 0, 0);
					$start = $maxheight - min($histoR[$a]/$histoClipR, 1.0)*$maxheight;
					$end = $maxheight;
					imageline ($imR,($a+1),$start,($a+1),$end,$lineColor);

					$lineColor = ImageColorAllocateAlpha ($imR, 0, 255, 0, 0);
					$start = $maxheight - min($histoG[$a]/$histoClipG, 1.0)*$maxheight;
					$end = $maxheight;
					imageline ($imR,($a+1),$start+100,($a+1),$end+100,$lineColor);

					$lineColor = ImageColorAllocateAlpha ($imR, 0, 0, 255, 0);
					$start = $maxheight - min($histoB[$a]/$histoClipB, 1.0)*$maxheight;
					$end = $maxheight;
					imageline ($imR,($a+1),$start+200,($a+1),$end+200,$lineColor);
				}
			}
		}
		else
		{   // GRAYSCALE

			// COMPUTE MAX VALUES
			$max = max($histo);

			// compute bounds of vertical axis

			// sort the histogram to find tallest bins
			$sortedHisto = $histo;
			sort($sortedHisto);

			// we allow clipping of at most the 5 tallest histogram bins, but clipping
			// also needs to be useful. i.e. if clipping does not change the vertical
			// range much, then don't do it. The following heuristic code enforces this.
			$lerpFactor = min(max(($sortedHisto[255]/$sortedHisto[250] - 1.15)/2.0, 0.0), 1.0);
			$histoClip = (1.0 - $lerpFactor)*$sortedHisto[255] + $lerpFactor*$sortedHisto[250];

			// CREATE HISTOGRAM BACKGROUND
			$back = imagecolorallocate($imR, $rgbcolor[0], $rgbcolor[1], $rgbcolor[2]);
			imagefilledrectangle($imR, 0, 0, 256, 100, $back);

			// MAKE HISTOGRAM COLOR NOT MATCH BACKGROUND LIGHTNESS
			if ((($rgbcolor[0] + $rgbcolor[0] + $rgbcolor[0])/3) < 127) {
				$graphcolor = 255;
			} else {
				$graphcolor = 0;
			}
			$text_color = ImageColorAllocateAlpha ($imR, $graphcolor, $graphcolor, $graphcolor, 0);

			// CREATE HISTOGRAM
			for ($a = 0; $a < 256; $a++){
				$h = min($histo[$a]/$histoClip, 1.0)*$maxheight;
				$start = ($maxheight - $h);
				imageline ($imR,($a+1),$start,($a+1),$maxheight,$text_color);
			}

			// ENG GRAY HISTOGRAM
		}




		// GET FILENAME OF FULL SIZE PHOTO
		// SAVE HISTOGRAM AND DESTROY RESOURCE
		touch($histogram);
		if(is_writable($histogram)) {

			$histW = 255;
			if($histW != 256) {
				$newW = $histW;
				$scale = $newW / 256;

				$width = imagesx($imR);
				$height = imagesy($imR);



				$new_width = floor($scale*$width);
				$new_height = floor($scale*$height);
				$tmp_img = imagecreatetruecolor($new_width,$new_height);
				// gd 2.0.1 or later: imagecopyresampled
				// gd less than 2.0: imagecopyresized
				if(function_exists('imagecopyresampled')) {
					imagecopyresampled($tmp_img, $imR, 0,0,0,0,$new_width,$new_height,$width,$height);
				} else {
					imagecopyresized($tmp_img, $imR, 0,0,0,0,$new_width,$new_height,$width,$height);
				}
				imagedestroy($imR);
				$imR = $tmp_img;

			}


			//			imagejpeg($imR,"../histograms/hist_$file", 100);
			//			$histogram = "../histograms/hist_$file";
			//			chmod($histogram,0644);
			//			imagedestroy($imR);
			//			$perms = fileperms("../histograms");

			
			imagejpeg($imR,$histogram, 100);
			imagedestroy($imR);
			chmod($histogram,0644);
			//$perms = fileperms($this->config->item('photography_library_path')."/histograms");

		} else {
			echo '<div class="content"><h4>Histogram NOT Created! Check Directory(/histograms) Permissions</h4></div>';
		}

	}

	private function html2rgb($color)
	{
		if ($color[0] == '#')
		$color = substr($color, 1);
		if (strlen($color) == 6)
		list($r, $g, $b) = array($color[0].$color[1],
		$color[2].$color[3],
		$color[4].$color[5]);
		elseif (strlen($color) == 3)
		list($r, $g, $b) = array($color[0], $color[1], $color[2]);
		else
		return false;
		$r = hexdec($r); $g = hexdec($g); $b = hexdec($b);
		return array($r, $g, $b);
	}    
}
