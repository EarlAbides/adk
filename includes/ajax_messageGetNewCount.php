<?php
	
	//Imports
	require_once 'session.php';
	require_once 'db_conn.php';
	require_once 'SELECT.php';
	require_once 'Message.php';

	if(!isset($_SESSION['ADK_USER_ID'])){echo 0; exit;}
	
	$con = connect_db();
	
	echo getNewMessageCount($con, intval($_SESSION['ADK_USER_ID']));
	
	$con->close();
	
	http_response_code(200);
	
?>