<?php
	
    function getFiles($con, $ADK_USER_ID){
        $ADK_FILES = '';
        $sql_query = sql_getFileGallery($con, $ADK_USER_ID);
		if($sql_query->execute()){
            $sql_query->store_result();
            $result = sql_get_assoc($sql_query);

            $i = 0;
			foreach($result as $row){
				$ADK_FILES[$i]['ADK_FILE_ID'] = $row['ADK_FILE_ID'];
				$ADK_FILES[$i]['ADK_FILE_NAME'] = $row['ADK_FILE_NAME'];
                $ADK_FILES[$i]['ADK_FILE_SAVENAME'] = $row['ADK_FILE_SAVENAME'];
                $ADK_FILES[$i]['ADK_FILE_DESC'] = $row['ADK_FILE_DESC'];
				$ADK_FILES[$i]['ADK_FILE_SIZE'] = $row['ADK_FILE_SIZE'];
				$ADK_FILES[$i]['ADK_FILE_TYPE'] = $row['ADK_FILE_TYPE'];
                $ADK_FILES[$i]['ADK_FILE_PEAKS'] = $row['ADK_FILE_PEAKS'];
				$i++;
			}
		}
		else die('There was an error running the query ['.$con->error.']');		
		
		return $ADK_FILES;
    }
    
	function getFileGallery($con, $ADK_USER_ID){
        $ADK_FILES = getFiles($con, $ADK_USER_ID);
        if($ADK_FILES === '') return $ADK_FILES;
        return new FileGallery($ADK_FILES);
    }

    class FileGallery{
        
        public $files = [];
        
        public function FileGallery($ADK_FILES){
            for($i = 0; $i < count($ADK_FILES); $i++){array_push($this->files, new FileGalleryItem($ADK_FILES[$i]));}
        }

        public function getPhotos(){return $this->getByFileType('photo');}
        public function getVideos(){return $this->getByFileType('video');}
        public function getDocsAndFiles(){return $this->getByFileType('file');}

        private function getByFileType($type){
            $files = [];
            for($i = 0; $i < count($this->files); $i++){
                $ext = $this->files[$i]->type;
                switch($ext){
                    case 'jpg': case 'jpeg': case 'png': case 'gif': case 'tif': case 'tiff': $category = 'photo'; break;
                    case 'mpg': case 'mpeg': case 'avi': case 'mov': case 'webm': case 'mkv': case 'flv': case 'ogg':
                    case 'oggv': case 'wmv': case 'mp4': $category = 'video'; break;
                    default: $category = 'file'; break;
                }
                if($category === $type) array_push($files, $this->files[$i]);
            }

            return $files;
        }
        
    }

    class FileGalleryItem{
        
        public function FileGalleryItem($ADK_FILE){
            $this->id = $ADK_FILE['ADK_FILE_ID'];
            $this->name = $ADK_FILE['ADK_FILE_NAME'];
            $this->savename = $ADK_FILE['ADK_FILE_SAVENAME'];
            $this->desc = $ADK_FILE['ADK_FILE_DESC'];
            $this->size = $ADK_FILE['ADK_FILE_SIZE'];
            $this->type = $ADK_FILE['ADK_FILE_TYPE'];
            $this->peaks = $ADK_FILE['ADK_FILE_PEAKS'];
        }

        public $id;
        public $name;
        public $savename;
        public $desc;
        public $size;
        public $type;
        public $peaks;
    }

?>