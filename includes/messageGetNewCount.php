<?php
	
	//Imports
	require_once 'session.php';
	require_once 'db_conn.php';
	require_once 'SELECT.php';
	require_once 'classes/Message.php';

	if(!isset($_SESSION['ADK_USER_ID']) || !is_numeric($_SESSION['ADK_USER_ID'])){http_response_code(404); echo 0; exit;}
	
	$con = connect_db();

	$ADK_MESSAGES = new Messages();
	$ADK_MESSAGES->userid = intval($_SESSION['ADK_USER_ID']);
	$newcount = $ADK_MESSAGES->getNewCount($con);
	
	$con->close();
	
	http_response_code(200);
	echo $newcount;
	
?>