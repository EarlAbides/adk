<?php
	
	//Imports
	require_once 'db_conn.php';
	require_once 'UPDATE.php';
	require_once 'Message.php';
	
	$con = connect_db();
	
	$ADK_MESSAGE_ID = intval($_POST['ADK_MESSAGE_ID']);
	updateMarkRead($con, $ADK_MESSAGE_ID);
	
	$con->close();
	
	http_response_code(200);
	
?>