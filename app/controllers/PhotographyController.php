<?php

class PhotographyController extends HomeController
{
	public function initialize()
    {
        $this->view->setTemplateAfter('index');
		//Set the document title
        $this->tag->setTitle('photography');
        parent::initialize();
    }
	
    public function indexAction()
    {
		
    }
	public function galleryAction()
    {
		
    }
	public function albumAction(){

		$this->browse->scandir('./img/');
		print_r($this->browse->dirlist());
		$this->browse->filter(array('extension'=> array('jpg','png')));
		$this->browse->exclude(array('extension'=> array('db','gif')));
		$photos = $this->browse->filelist();
		//print_r($photos);
		$this->view->photos = $photos;
	}
	public function thumbnailAction()
    {
		
    }
	public function histogramsAction()
    {
		
    }
	public function exifAction()
    {
		
    }
}
