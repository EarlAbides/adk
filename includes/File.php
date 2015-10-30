<?php
	
	function addFiles($con, $files){		
		$null = null;
		$fileIDs = array();
		$fileIndex = 0;
		$con->autocommit(false);
		
		foreach($files as $file){
			$fp = fopen($file, 'r');
			$fileSize = filesize($file);
            $ADK_FILE_SAVENAME = sha1(openssl_random_pseudo_bytes(40));
			$ADK_FILE_DESC = 'Correspondent Profile Photo';
			if(isset($_POST['file_'.$fileIndex.'_desc'])) $ADK_FILE_DESC = $_POST['file_'.$fileIndex.'_desc'];
			
			$ADK_FILE = array(
				'ADK_FILE_NAME' => addslashes(basename($file))
                ,'ADK_FILE_SAVENAME' => $ADK_FILE_SAVENAME
				,'ADK_FILE_DESC' => $ADK_FILE_DESC
				,'ADK_FILE_SIZE' => $fileSize
				,'ADK_FILE_TYPE' => pathinfo($file, PATHINFO_EXTENSION)
			);
			
			//Add file info
			$sql_query = sql_addFile($con);
            $sql_query->bind_param('sssis', $ADK_FILE['ADK_FILE_NAME'], $ADK_FILE['ADK_FILE_SAVENAME'], $ADK_FILE['ADK_FILE_DESC'], 
                        $ADK_FILE['ADK_FILE_SIZE'], $ADK_FILE['ADK_FILE_TYPE']);
            fclose($fp);
			$sql_query->execute();
			$fileIDs[$fileIndex] = $sql_query->insert_id;
            
            //Move to /uploads/... and rename
            moveFileToProtected($file, $ADK_FILE_SAVENAME);
			
			$fileIndex++;
		}
		
		$con->commit();
        $con->autocommit(true);
		
		return $fileIDs;
	}

    function moveFileToProtected($file, $ADK_FILE_SAVENAME){
        $path = '../uploads/'.$ADK_FILE_SAVENAME[0].'/'.$ADK_FILE_SAVENAME[1];
        if(!is_dir($path)) mkdir($path, 0777, true);
        rename($file, $path.'/'.$ADK_FILE_SAVENAME);
    }
	
	function validateFiles(&$errMess){		
		$valid = true;
		$totalFileSize = 0;
		for($i = 0; $i < count($_FILES); $i++){
			for($j = 0; $j < count($_FILES['file'.$i]['tmp_name']); $j++){
				if($_FILES['file'.$i]['size'][$j] !== 0){
					$ext = pathinfo($_FILES['file'.$i]['name'][$j], PATHINFO_EXTENSION);
					$fileTypes = array('pdf', 'doc', 'docx', 'txt', 'csv', 'jpg', 'jpeg', 'png', 'gif', 'tif', 'tiff', 'bmp'
                                        ,'mpg', 'mpeg', 'avi', 'mov', 'webm', 'mkv', 'flv', 'ogg', 'oggv', 'wmv', 'mp4');

					//File type
					if(!in_array($ext, $fileTypes)){
						$errMess .= 't';
						$valid = false;
					}

					//PHP error
					if($_FILES['file'.$i]['error'][$j] !== 0){
						$errMess .= 'f';
						$valid = false;
					}
					
					$totalFileSize += $_FILES['file'.$i]['size'][$j];
				}
			}
		}
		
		//Total file size
		if($totalFileSize >= 104856500){//100Mb (-1000 bytes)
			$errMess .= 'm';
			$valid = false;
		}
		
		return $valid;
	}
	
	function validateImageFile(&$errMess, $name){
		$valid = true;
		if($_FILES[$name]['size'] !== 0){
			$ext = pathinfo($_FILES[$name]['name'], PATHINFO_EXTENSION);
			$fileTypes = array('jpg', 'jpeg', 'png', 'gif', 'tif', 'tiff', 'bmp');
					
			//File size
			if($_FILES[$name]['size'] > 104856500){//100Mb (-1000 bytes)
				$errMess .= 's';
				$valid = false;
			}
					
			//File type
			if(!in_array($ext, $fileTypes)){
				$errMess .= 't';
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
					$target = '../uploads/'.basename($_FILES['file'.$i]['name'][$j]);
                    if(move_uploaded_file($_FILES['file'.$i]['tmp_name'][$j], $target)){
						$files[$numFiles] = $target;
						$numFiles++;
					}
					else{}//Error
				}
				
			}
		}
		
		return $files;
	}
	
	function getPOSTFile($name){
		$file = '';
		$target = '../uploads/'.basename($_FILES[$name]['name']);
		if(move_uploaded_file($_FILES[$name]['tmp_name'], $target)) $file = $target;
		else{}//Error
		
		return $file;
	}
	
	function getFile($con, $ADK_FILE_ID, $returnContent){
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
            $file = '../uploads/'.$ADK_FILE['ADK_FILE_SAVENAME'][0].'/'.$ADK_FILE['ADK_FILE_SAVENAME'][1].'/'.$ADK_FILE['ADK_FILE_SAVENAME'];
            $fp = fopen($file, 'r');
            $ADK_FILE['ADK_FILE_CONTENT'] = fread($fp, $ADK_FILE['ADK_FILE_SIZE']);
            fclose($fp);
        }
		
		return $ADK_FILE;
	}
	
?>