<?php
	
	//Imports
	require_once 'session.php';
	require_once 'db_conn.php';
	require_once 'INSERT.php';
	require_once 'UPDATE.php';
	require_once 'File.php';
	require_once 'classes/Hiker.php';
	
	if(validateImageFile($errMess, $name)) $file = getPOSTFile('photo');
	else header('Location: ../profile?e='.$errMess);
	
	$con = connect_db();
	
	$hiker = new Hiker();
	$hiker->populateFromUpdatePhoto();
	
	if($file !== ''){
		$fileIDs = addFiles($con, array($file));
		hiker->updatePhoto($con, $fileIDs[0]);
	}
	$con->close();
	
	header('Location: ../hikerportal');
	
?>