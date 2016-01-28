<?php
	
	//Imports
	require_once 'session.php';
	require_once 'db_conn.php';
	require_once 'INSERT.php';
	require_once 'UPDATE.php';
	require_once 'File.php';
	require_once 'classes/Hiker.php';
	
	if(validateImageFile($errMess, 'photo')) $file = getPOSTFile('photo');
	else header('Location: ../profile?e='.$errMess);
	
	$con = connect_db();
	
	$hiker = new Hiker();
	$hiker->id = $_SESSION['ADK_USER_ID'];
	
	if($file !== ''){
		$fileIDs = addFiles($con, array($file));
		$hiker->photoid = $fileIDs[0];
		$hiker->updatePhotoID($con);
	}
	$con->close();
	
	header('Location: ../hikerportal');
	
?>