<?php
	
	//Imports
	require_once 'session.php';
	require_once 'db_conn.php';
	require_once 'INSERT.php';
	require_once 'UPDATE.php';
	require_once 'Correspondent.php';
	require_once 'File.php';
	
	if(validateImageFile($errMess, 'photo')) $file = getPOSTFile('photo');
	else header('Location: ../profile?e='.$errMess);
	
	$con = connect_db();
	
	$ADK_USER_ID = intval($_POST['id']);
	
	if($file !== ''){
		$files = array($file);
		$fileIDs = addFiles($con, $files);
		updateCorrPhotoID($con, $ADK_USER_ID, $fileIDs[0]);
	}
	$con->close();
	
	header('Location: ../hikers');
	
?>