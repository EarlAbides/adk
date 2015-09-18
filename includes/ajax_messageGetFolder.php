<?php
	
	//Imports
	require_once 'db_conn.php';
	require_once 'SELECT.php';
	require_once 'Message.php';
	
	$con = connect_db();//Connect to db
	if(mysqli_connect_errno())
	    return 'Error';
	
	$ADK_USER_ID = intval($_POST['ADK_USER_ID']);
	$folderID = $_POST['id'];
	switch($folderID){
		case 0: $folderName = 'Inbox'; break;
		case 1: $folderName = 'Sent'; break;
	}
	
	$ADK_MESSAGES = getMessages($con, $ADK_USER_ID, $folderName);
	
	$table_messages = getTableMessages($ADK_MESSAGES, $folderName);
	
	$con->close();
	
	echo $table_messages;
	http_response_code(200);
	
?>