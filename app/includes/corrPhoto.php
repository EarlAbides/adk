<?php
	
	//Imports
	require_once 'session.php';
	require_once 'db/db_conn.php';
	require_once 'db/INSERT.php';
	require_once 'db/UPDATE.php';
	require_once 'classes/Correspondent.php';
	require_once 'classes/File.php';

	$ADK_FILE = new File();
	if(!$ADK_FILE->isValid()){header('Location: ../profile?e='.$ADK_FILE->err); exit;}
	$ADK_FILE->populate();
	
	$con = connect_db();
	
	$ADK_CORRESPONDENT = new Correspondent();
	$ADK_CORRESPONDENT->id = intval($_SESSION['ADK_USER_ID']);
	
	$ADK_FILES = new Files();
	$ADK_FILES->files[0] = $ADK_FILE;
	$ADK_FILES->save($con);

	$ADK_CORRESPONDENT->photoid = $ADK_FILES->fileIDs[0];
	$ADK_CORRESPONDENT->updatePhotoID($con);

	$con->close();
	
	header('Location: ../hikers');
	
?>