<?php
	
	//Imports
	require_once 'session.php';
	require_once 'db_conn.php';
	require_once 'SELECT.php';
	require_once 'classes/File.php';
	require_once 'classes/Message.php';
	
	if(!isset($_SESSION['ADK_USER_ID'])){http_response_code(400); exit;}
	if(!isset($_POST['ADK_MESSAGE_ID']) || !is_numeric($_POST['ADK_MESSAGE_ID'])){http_response_code(400); exit;}
	
	$con = connect_db();
	
	$ADK_MESSAGE = new Message();
	$ADK_MESSAGE->id = intval($_POST['ADK_MESSAGE_ID']);
	$ADK_MESSAGE->userid = intval($_SESSION['ADK_USER_ID']);
	$ADK_MESSAGE->get($con);
	
	$con->close();
	
	echo json_encode($ADK_MESSAGE);
	http_response_code(200);
	
?>