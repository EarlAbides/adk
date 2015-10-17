<?php
	
	//Imports
	require_once 'db_conn.php';
	require_once 'UPDATE.php';
	require_once 'Message.php';
	
	$con = connect_db();
	
	$ADK_MESSAGE_ID = intval($_POST['id']);
	$inboxSent = $_POST['tofrom'];
	updateDelete($con, $ADK_MESSAGE_ID, $inboxSent);
	
	$con->close();
	
	http_response_code(200);
	
?>