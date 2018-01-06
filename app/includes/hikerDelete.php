<?php
	
	//Imports
	require_once 'session.php';
	require_once 'db/db_conn.php';
	require_once 'db/DELETE.php';
	require_once 'classes/Hiker.php';
	
	if(!isset($_POST['id']) || !is_numeric($_POST['id'])){
		header('Location: ../hikers?e=i');
		exit;
	}

	$ADK_USER_ID = intval($_POST['id']);

	$con = connect_db();

	$ADK_HIKER = new Hiker();
	$ADK_HIKER->id = $ADK_USER_ID;
	$ADK_HIKER->delete($con);
	
	$con->close();
	
	header('Location: ../hikers');
	
?>