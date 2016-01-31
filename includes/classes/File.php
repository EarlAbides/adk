<?php
	
	class Files{
		
		public $err;
		public $files, $fileIDs;

		public function Files(){
			$this->err = '';
			$this->files = [];
			$this->fileIDs = [];
		}

		private function moveFileToProtected(){
			$path = '../uploads/'.$this->savename[0].'/'.$this->savename[1];
			if(!is_dir($path)) mkdir($path, 0777, true);
			$src = $path.'/'.$this->savename;
			if(!move_uploaded_file($ADK_FILE->tmp_name, $src)) echo 'Error getting files';

			return $src;
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
				$src = $ADK_FILE->moveToProtected();//Move to /uploads/...

			    //Make thumbnail
			    $isImage = $ADK_FILE->type === 'jpg' || $ADK_FILE->type === 'jpeg' || $ADK_FILE->type === 'png' || $ADK_FILE->type === 'gif';
			    if($isImage){
			        $path = '../uploads/thumb/'.$ADK_FILE->savename[0].'/'.$ADK_FILE->savename[1];
			        if(!is_dir($path)) mkdir($path, 0777, true);
					
			        $ADK_FILE->makeThumbnail($src, $path, 160);
			    }
				
			    //Add file info
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

		public function populateSingle(){
			if($_FILES[$name]['size'] > 0){
				$ADK_FILE = new File();
				$ADK_FILE->name = basename($_FILES[$name]['name']);
				$ADK_FILE->tmp_name = $_FILES[$name]['tmp_name'];
				$ADK_FILE->size = $_FILES[$name]['size'];
				array_push($this->files, $ADK_FILE);
			}
		
			return $file;
		}
	}
	
	class File{
		
		public $err;
		public $id, $name, $tmp_name, $savename, $desc, $size, $type;
		
		public function File(){
			
		}

		public function moveToProtected(){
			$path = '../uploads/'.$this->savename[0].'/'.$this->savename[1];
			if(!is_dir($path)) mkdir($path, 0777, true);
			$src = $path.'/'.$this->savename;
			if(!move_uploaded_file($this->tmp_name, $src)) $this->err .= 't';

			return $src;
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

			if($returnContent && $ADK_FILE->savename != ''){
				if($getThumb) $file = '../uploads/thumb/'.$ADK_FILE->savename[0].'/'.$ADK_FILE->savename[1].'/'.$ADK_FILE->savename;
				else $file = '../uploads/'.$ADK_FILE->savename[0].'/'.$ADK_FILE->savename[1].'/'.$ADK_FILE->savename;
				$fp = fopen($file, 'r');
				if($getThumb) $ADK_FILE->size = filesize($file);
				$ADK_FILE->content = fread($fp, $ADK_FILE->size);
				fclose($fp);
			}

			return $ADK_FILE;
		}

		//public function save($con){
		//    $sql_query = sql_addUser($con, $this);
		//    $sql_query->execute();
		//    $this->id = $sql_query->insert_id;
		//}

		//public function update($con){
		//    $sql_query = sql_updateUser($con, $this);
		//    $sql_query->execute();
		//}


		//public function populate(){
		//    if(isset($_POST['id'])) $this->id = intval($_POST['id']);
		//    $this->username = $_POST['username'];
		//    $this->name = $_POST['name'];
		//    $this->email = $_POST['email'];
		//}
		
		//public function populateFromAddHiker($randomPW, $ADK_APPLICANT){
		//    $this->usergroupid = 3;
		//    $this->username = $ADK_APPLICANT->username;
		//    $this->name = $ADK_APPLICANT->name;
		//    $this->email = $ADK_APPLICANT->email;
		//    $this->pw = $randomPW;
		//}
		
	}
	
?>