<?php
	
	//Imports
	require_once 'db_conn.php';
	require_once 'SELECT.php';
	require_once 'Message.php';
	
	$con = connect_db();//Connect to db
	if(mysqli_connect_errno())
	    return 'Error';
	
	$ADK_MESSAGE_ID = intval($_POST['ADK_MESSAGE_ID']);
	$ADK_MESSAGE = getMessage($con, $ADK_MESSAGE_ID);
	
	$con->close();
	
	echo json_encode($ADK_MESSAGE);
	http_response_code(200);
	
?>