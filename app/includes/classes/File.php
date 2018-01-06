<?php
	
	class Files{
		
		public $err;
		public $files, $fileIDs;

		public function __construct(){
			$this->err = '';
			$this->files = [];
			$this->fileIDs = [];
		}


		public function isValid(){
			$valid = true;
			for($i = 0; $i < count($_FILES); $i++){
				for($j = 0; $j < count($_FILES['file'.$i]['tmp_name']); $j++){
					if($_FILES['file'.$i]['size'][$j] !== 0){
						$ext = strtolower(pathinfo($_FILES['file'.$i]['name'][$j], PATHINFO_EXTENSION));
						$fileTypes = array('pdf', 'doc', 'docx', 'txt', 'csv', 'jpg', 'jpeg', 'png', 'gif', 'tif', 'tiff', 'bmp'
											,'mpg', 'mpeg', 'avi', 'mov', 'webm', 'mkv', 'flv', 'ogg', 'oggv', 'wmv', 'mp4');
						
						//File type
						if(!in_array($ext, $fileTypes)){
							$this->err .= 't';
							$valid = false;
						}
						
						//PHP error
						if($_FILES['file'.$i]['error'][$j] !== 0){
							$this->err .= 'p'.$_FILES['file'.$i]['error'][$j];
							$valid = false;
						}
					}
				}
			}

			return $valid;
		}

		public function save($con){
			$null = null;
			$fileIDs = array();
			$con->autocommit(false);
		
			foreach($this->files as $ADK_FILE){
				$src = $ADK_FILE->moveToProtected();//move to /uploads/...

			    //make thumbnail
			    $isImage = $ADK_FILE->type === 'jpg' || $ADK_FILE->type === 'jpeg' || $ADK_FILE->type === 'png' || $ADK_FILE->type === 'gif';
			    if($isImage){
			        $path = '../uploads/thumb/'.$ADK_FILE->savename[0].'/'.$ADK_FILE->savename[1];
			        if(!is_dir($path)) mkdir($path, 0777, true);
					
			        $ADK_FILE->makeThumbnail($src, $path, 160);
			    }
				
			    //add file info
			    $sql_query = sql_addFile($con);
			    $sql_query->bind_param('sssis', $ADK_FILE->name, $ADK_FILE->savename, $ADK_FILE->desc, $ADK_FILE->size, $ADK_FILE->type);
			    $sql_query->execute();
				$ADK_FILE->id = $sql_query->insert_id;
				array_push($this->fileIDs, $ADK_FILE->id);
			}
			
			$con->commit();
			$con->autocommit(true);
		}

		public function populate(){
			for($i = 0; $i < count($_FILES); $i++){
				for($j = 0; $j < count($_FILES['file'.$i]['tmp_name']); $j++){
					if($_FILES['file'.$i]['size'][$j] !== 0){
						$ADK_FILE = new File();
						$ADK_FILE->name = basename($_FILES['file'.$i]['name'][$j]);
						$ADK_FILE->savename = sha1(openssl_random_pseudo_bytes(40));
						$ADK_FILE->desc = isset($_POST['file_'.count($this->files).'_desc'])? $_POST['file_'.count($this->files).'_desc']: 'Profile Photo';
						$ADK_FILE->tmp_name = $_FILES['file'.$i]['tmp_name'][$j];
						$ADK_FILE->size = $_FILES['file'.$i]['size'][$j];
						$ADK_FILE->type = strtolower(pathinfo($_FILES['file'.$i]['name'][$j], PATHINFO_EXTENSION));
						array_push($this->files, $ADK_FILE);
					}
				}
			}
		}
		
	}
	
	class File{
		
		public $err;
		public $id, $name, $tmp_name, $savename, $desc, $size, $type;
		
		public function __construct(){
			
		}
		
		public function getType(){
			switch($this->type){
				case 'jpg': case 'jpeg': case 'png': case 'gif': case 'tif': case 'tiff': return 'photo';
				case 'mpg': case 'mpeg': case 'avi': case 'mov': case 'webm': case 'mkv': case 'flv': case 'ogg': case 'oggv': case 'wmv': case 'mp4': return 'video';
				default: return 'doc';
			}
		}
		
		public function moveToProtected(){
			$path = '../uploads/'.$this->savename[0].'/'.$this->savename[1];
			if(!is_dir($path)) mkdir($path, 0777, true);
			$src = $path.'/'.$this->savename;
			if(!move_uploaded_file($this->tmp_name, $src)) $this->err .= 't';

			return $src;
		}
		
		public function isValid(){
			$valid = true;
			if($_FILES['photo']['size'] !== 0){
				$ext = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
				$fileTypes = array('jpg', 'jpeg', 'png', 'gif', 'tif', 'tiff', 'bmp');
			
				//File type
				if(!in_array($ext, $fileTypes)){
					$errMess .= 't';
					$valid = false;
				}
			
				//PHP error
				if($_FILES['photo']['error'] !== 0){
					$errMess .= 'p'.$_FILES['photo']['error'];
					$valid = false;
				}
			}
		
			return $valid;
		}
		
		public function makeThumbnail($src, $path, $desired_width){
			$dest = $path.'/'.$this->savename;
			
			$this->type = strtolower($this->type);
			ini_set('memory_limit', '128M');
		
			/* read the source image */
			switch($this->type){
				case 'jpg': case 'jpeg': $source_image = imagecreatefromjpeg($src); break;
				case 'png': $source_image = imagecreatefrompng($src); break;
				case 'gif': $source_image = imagecreatefromgif($src); break;
				default:
					if(!copy($src, $dest)) echo "failed to copy $file...\n";
					else return;
			}
			$width = imagesx($source_image);
			$height = imagesy($source_image);
		
			/* find the "desired height" of this thumbnail, relative to the desired width  */
			$desired_height = floor($height * ($desired_width / $width));
		
			/* create a new, "virtual" image */
			$virtual_image = imagecreatetruecolor($desired_width, $desired_height);
		
			/* copy source image at a resized size */
			imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
		
			/* create the physical thumbnail image to its destination */
			switch($this->type){
				case 'jpg': case 'jpeg': imagejpeg($virtual_image, $dest); break;
				case 'png': imagepng($virtual_image, $dest); break;
				case 'gif': imagegif($virtual_image, $dest); break;
			}
		}
		
		
		public function get($con, $returnContent, $getThumb){
			$sql_query = sql_getFile($con, $this->id);
			if($sql_query->execute()){
				$sql_query->store_result();
				$result = sql_get_assoc($sql_query);

				foreach($result as $row){
					$this->id = $row['ADK_FILE_ID'];
					$this->name = $row['ADK_FILE_NAME'];
					$this->savename = $row['ADK_FILE_SAVENAME'];
					$this->size = $row['ADK_FILE_SIZE'];
					$this->type = $row['ADK_FILE_TYPE'];
				}
			}
			else die('There was an error running the query ['.$con->error.']');
			
			if($returnContent && $this->savename != ''){
				if($getThumb) $file = '../uploads/thumb/'.$this->savename[0].'/'.$this->savename[1].'/'.$this->savename;
				else $file = '../uploads/'.$this->savename[0].'/'.$this->savename[1].'/'.$this->savename;
				$fp = fopen($file, 'r');
				if($getThumb) $this->size = filesize($file);
				$this->content = fread($fp, $this->size);
				fclose($fp);
			}
		}
		
		public function populate(){
			if($_FILES['photo']['size'] > 0){
				$this->name = basename($_FILES['photo']['name']);
				$this->savename = sha1(openssl_random_pseudo_bytes(40));
				$this->desc = 'Profile Photo';
				$this->tmp_name = $_FILES['photo']['tmp_name'];
				$this->size = $_FILES['photo']['size'];
				$this->type = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
			}
		
			return $file;
		}
		
	}
	
?>