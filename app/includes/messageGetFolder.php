<?php
	
	//Imports
	require_once 'session.php';
	require_once 'db/db_conn.php';
	require_once 'db/SELECT.php';
	require_once 'classes/Message.php';

	if(!isset($_SESSION['ADK_USER_ID']) || !is_numeric($_SESSION['ADK_USER_ID'])){http_response_code(400); exit;}
	if(!isset($_POST['id']) || !is_numeric($_POST['id'])){http_response_code(400); exit;}

	$con = connect_db();

	$ADK_MESSAGES = new Messages();
	$ADK_MESSAGES->userid = intval($_SESSION['ADK_USER_ID']);
	switch(intval($_POST['id'])){
		case 0: $ADK_MESSAGES->foldername = 'Inbox'; break;
		case 1: $ADK_MESSAGES->foldername = 'Sent'; break;
		case 2: $ADK_MESSAGES->foldername = 'Drafts'; break;
	}
	$ADK_MESSAGES->get($con);
	
	$con->close();
	
	$ADK_MESSAGES->renderTable();
	http_response_code(200);
	
?>