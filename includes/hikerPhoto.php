<?php
	
	//Imports
	require_once 'session.php';
	require_once 'db_conn.php';
	require_once 'INSERT.php';
	require_once 'UPDATE.php';
	require_once 'classes/File.php';
	require_once 'classes/Hiker.php';
	
	if(!isset($_SESSION['ADK_USER_ID'])) exit;
	
	$ADK_FILE = new File();
	if(!$ADK_FILE->isValid()){header('Location: ../profile?e='.$ADK_FILE->err); exit;}
	$ADK_FILE->populate();

	$con = connect_db();
	
	$ADK_HIKER = new Hiker();
	$ADK_HIKER->id = intval($_SESSION['ADK_USER_ID']);
	
	$ADK_FILES = new Files();
	$ADK_FILES->files[0] = $ADK_FILE;
	$ADK_FILES->save($con);

	$ADK_HIKER->photoid = $ADK_FILES->fileIDs[0];
	$ADK_HIKER->updatePhotoID($con);

	$con->close();
	
	header('Location: ../hikerportal');
	
?>