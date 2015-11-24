<?php
	
	//Imports
	require_once 'session.php';
	require_once 'db_conn.php';
	require_once 'SELECT.php';
	require_once 'Message.php';
	
	if(!isset($_SESSION['ADK_USER_ID'])) exit;
	
	$con = connect_db();
	
	$ADK_MESSAGE_ID = intval($_POST['ADK_MESSAGE_ID']);
	$ADK_MESSAGE = getMessage($con, $ADK_MESSAGE_ID, intval($_SESSION['ADK_USER_ID']));
	
	$con->close();
	
	echo json_encode($ADK_MESSAGE);
	http_response_code(200);
	
?>