<?php
	
    class Gallery extends Files{
		
		public $userid, $corrid, $photos, $videos, $docs;
		
		public function __construct(){
			parent::__construct();
			$this->photos = [];
			$this->videos = [];
			$this->docs = [];
			$this->corrid = '%';
		}
		

		public function get($con){
			 $sql_query = sql_getFileGallery($con, $this->userid, $this->corrid);
			if($sql_query->execute()){
				$sql_query->store_result();
				$result = sql_get_assoc($sql_query);

				foreach($result as $row){
					$ADK_GALLERY_ITEM = new GalleryItem();
					$ADK_GALLERY_ITEM->id = $row['ADK_FILE_ID'];
					$ADK_GALLERY_ITEM->name = $row['ADK_FILE_NAME'];
					$ADK_GALLERY_ITEM->savename = $row['ADK_FILE_SAVENAME'];
					$ADK_GALLERY_ITEM->desc = $row['ADK_FILE_DESC'];
					$ADK_GALLERY_ITEM->size = $row['ADK_FILE_SIZE'];
					$ADK_GALLERY_ITEM->type = $row['ADK_FILE_TYPE'];
					$ADK_GALLERY_ITEM->peaks = $row['ADK_FILE_PEAKS']? $row['ADK_FILE_PEAKS']: 'Private Message';
					$ADK_GALLERY_ITEM->username = $row['ADK_USER_USERNAME'];
					
					array_push($this->files, $ADK_GALLERY_ITEM);
					switch($ADK_GALLERY_ITEM->type){
						case 'jpg': case 'jpeg': case 'png': case 'gif': case 'tif': case 'tiff': array_push($this->photos, $ADK_GALLERY_ITEM); break;
						case 'mpg': case 'mpeg': case 'avi': case 'mov': case 'webm': case 'mkv': case 'flv': case 'ogg':
						case 'oggv': case 'wmv': case 'mp4': array_push($this->videos, $ADK_GALLERY_ITEM); break;
						default: array_push($this->docs, $ADK_GALLERY_ITEM);
					}
				}
			}
			else die('There was an error running the query ['.$con->error.']');
		}

	}
	
	class GalleryItem extends File{
		
		public $peaks;
		
		public function __construct(){
			parent::__construct();
		}
		
	}
	
?>