<?php
	
	function addFiles($con, $files){
		$null = null;
		$fileIDs = array();
		$fileIndex = 0;
		$con->autocommit(false);
		
		foreach($files as $file){
			$ADK_FILE_SAVENAME = sha1(openssl_random_pseudo_bytes(40));
			$ADK_FILE_DESC = 'Correspondent Profile Photo';
			if(isset($_POST['file_'.$fileIndex.'_desc'])) $ADK_FILE_DESC = $_POST['file_'.$fileIndex.'_desc'];
			$ADK_FILE = array(
				'ADK_FILE_NAME' => $file['name']
                ,'ADK_FILE_SAVENAME' => $ADK_FILE_SAVENAME
				,'ADK_FILE_DESC' => $ADK_FILE_DESC
				,'ADK_FILE_SIZE' => $file['size']
				,'ADK_FILE_TYPE' => strtolower(pathinfo($file['name'], PATHINFO_EXTENSION))
			);
			$ADK_FILE['ADK_FILE_NAME'] = str_replace(pathinfo($file['name'], PATHINFO_EXTENSION), $ADK_FILE['ADK_FILE_TYPE'], $ADK_FILE['ADK_FILE_NAME']);

			//Move to /uploads/...
            $src = moveFileToProtected($file, $ADK_FILE_SAVENAME);

			//Make thumbnail
			$formatOk = $ADK_FILE['ADK_FILE_TYPE'] === 'jpg' || $ADK_FILE['ADK_FILE_TYPE'] === 'jpeg' ||
						$ADK_FILE['ADK_FILE_TYPE'] === 'png' || $ADK_FILE['ADK_FILE_TYPE'] === 'gif';
			if($formatOk){
				$path = '../uploads/thumb/'.$ADK_FILE_SAVENAME[0].'/'.$ADK_FILE_SAVENAME[1];
				if(!is_dir($path)) mkdir($path, 0777, true);
				
				makeThumbnail($src, $path.'/'.$ADK_FILE_SAVENAME, 160, $ADK_FILE['ADK_FILE_TYPE']);
			}
			
			//Add file info
			$sql_query = sql_addFile($con);
            $sql_query->bind_param('sssis', $ADK_FILE['ADK_FILE_NAME'], $ADK_FILE['ADK_FILE_SAVENAME'], $ADK_FILE['ADK_FILE_DESC'], 
                        $ADK_FILE['ADK_FILE_SIZE'], $ADK_FILE['ADK_FILE_TYPE']);
            $sql_query->execute();
			$fileIDs[$fileIndex] = $sql_query->insert_id;
            
			$fileIndex++;
		}
		
		$con->commit();
        $con->autocommit(true);

		return $fileIDs;
	}

	function makeThumbnail($src, $dest, $desired_width, $ext){
		$ext = strtolower($ext);
		ini_set('memory_limit', '128M');
		
		/* read the source image */
		switch($ext){
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
		switch($ext){
			case 'jpg': case 'jpeg': imagejpeg($virtual_image, $dest); break;
			case 'png': imagepng($virtual_image, $dest); break;
			case 'gif': imagegif($virtual_image, $dest); break;
		}
	}

    function moveFileToProtected($file, $ADK_FILE_SAVENAME){
		$path = '../uploads/'.$ADK_FILE_SAVENAME[0].'/'.$ADK_FILE_SAVENAME[1];
		if(!is_dir($path)) mkdir($path, 0777, true);
		$src = $path.'/'.$ADK_FILE_SAVENAME;
		if(!move_uploaded_file($file['tmp_name'], $src)) echo 'Error getting files';

		return $src;
    }
	
	function validateFiles(&$errMess){
		$valid = true;
		for($i = 0; $i < count($_FILES); $i++){
			for($j = 0; $j < count($_FILES['file'.$i]['tmp_name']); $j++){
				if($_FILES['file'.$i]['size'][$j] !== 0){
					$ext = strtolower(pathinfo($_FILES['file'.$i]['name'][$j], PATHINFO_EXTENSION));
					$fileTypes = array('pdf', 'doc', 'docx', 'txt', 'csv', 'jpg', 'jpeg', 'png', 'gif', 'tif', 'tiff', 'bmp'
                                        ,'mpg', 'mpeg', 'avi', 'mov', 'webm', 'mkv', 'flv', 'ogg', 'oggv', 'wmv', 'mp4');
					
					//File type
					if(!in_array($ext, $fileTypes)){
						$errMess .= 't';
						$valid = false;
					}
					
					//PHP error
					if($_FILES['file'.$i]['error'][$j] !== 0){
						$errMess .= 'p'.$_FILES['file'.$i]['error'][$j];
						$valid = false;
					}
				}
			}
		}

		return $valid;
	}
	
	function validateImageFile(&$errMess, $name){
		$valid = true;
		if($_FILES[$name]['size'] !== 0){
			$ext = strtolower(pathinfo($_FILES[$name]['name'], PATHINFO_EXTENSION));
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
	
	function getPOSTFiles(){
		$files = '';
		$numFiles = 0;
		for($i = 0; $i < count($_FILES); $i++){
			for($j = 0; $j < count($_FILES['file'.$i]['tmp_name']); $j++){
				if($_FILES['file'.$i]['size'][$j] !== 0){
					$files[$numFiles]['name'] = basename($_FILES['file'.$i]['name'][$j]);
					$files[$numFiles]['tmp_name'] = $_FILES['file'.$i]['tmp_name'][$j];
					$files[$numFiles]['size'] = $_FILES['file'.$i]['size'][$j];
					$numFiles++;
				}
				
			}
		}
		
		return $files;
	}
	
	function getPOSTFile($name){
		$file = '';
		if($_FILES[$name]['size'] > 0){
			$file['name'] = basename($_FILES[$name]['name']);
			$file['tmp_name'] = $_FILES[$name]['tmp_name'];
			$file['size'] = $_FILES[$name]['size'];
		}
		
		return $file;
	}
	
	function getFile($con, $ADK_FILE_ID, $returnContent, $getThumb){
        $ADK_FILE = '';
		$sql_query = sql_getFile($con, $ADK_FILE_ID);
		if($sql_query->execute()){
            $sql_query->store_result();
            $result = sql_get_assoc($sql_query);

            foreach($result as $row){
				$ADK_FILE['ADK_FILE_ID'] = $row['ADK_FILE_ID'];
				$ADK_FILE['ADK_FILE_NAME'] = $row['ADK_FILE_NAME'];
                $ADK_FILE['ADK_FILE_SAVENAME'] = $row['ADK_FILE_SAVENAME'];
				$ADK_FILE['ADK_FILE_SIZE'] = $row['ADK_FILE_SIZE'];
				$ADK_FILE['ADK_FILE_TYPE'] = $row['ADK_FILE_TYPE'];
			}
		}
		else die('There was an error running the query ['.$con->error.']');

		if($returnContent && $ADK_FILE != ''){
			if($getThumb) $file = '../uploads/thumb/'.$ADK_FILE['ADK_FILE_SAVENAME'][0].'/'.$ADK_FILE['ADK_FILE_SAVENAME'][1].'/'.$ADK_FILE['ADK_FILE_SAVENAME'];
			else $file = '../uploads/'.$ADK_FILE['ADK_FILE_SAVENAME'][0].'/'.$ADK_FILE['ADK_FILE_SAVENAME'][1].'/'.$ADK_FILE['ADK_FILE_SAVENAME'];
			$fp = fopen($file, 'r');
			if($getThumb) $ADK_FILE['ADK_FILE_SIZE'] = filesize($file);
			$ADK_FILE['ADK_FILE_CONTENT'] = fread($fp, $ADK_FILE['ADK_FILE_SIZE']);
			fclose($fp);
		}

		return $ADK_FILE;
	}
	
?>