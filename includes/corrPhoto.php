<?php
	
	//Imports
	require_once 'session.php';
	require_once 'db/db_conn.php';
	require_once 'db/INSERT.php';
	require_once 'db/UPDATE.php';
	require_once 'classes/Correspondent.php';
	require_once 'File.php';
	
	if(validateImageFile($errMess, 'photo')) $file = getPOSTFile('photo');
	else header('Location: ../profile?e='.$errMess);
	
	$con = connect_db();
	
	$ADK_CORRESPONDENT = new Correspondent();
	$ADK_CORRESPONDENT->id = intval($_SESSION['ADK_USER_ID']);
	
	if($file !== ''){
		$fileIDs = addFiles($con, array($file));
		$ADK_CORRESPONDENT->photoid = $fileIDs[0];
		$ADK_CORRESPONDENT->updatePhotoID($con);
	}
	$con->close();
	
	header('Location: ../hikers');
	
?>