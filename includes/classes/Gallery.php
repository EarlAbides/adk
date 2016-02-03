<?php
	
    class Gallery extends Files{
		
		public $photos, $videos, $docs;
		
		public function __construct(){
			parent::__construct();
			$this->photos = [];
			$this->videos = [];
			$this->docs = [];
		}
		
	}
	
	class GalleryItem extends File{
		
		public $peaks;
		
		public function __construct(){
			parent::__construct();
		}
		
	}
	
?>