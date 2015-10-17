<?php
	
	//Imports
	require_once 'db_conn.php';
	require_once 'SELECT.php';
	require_once 'Message.php';
	
	$con = connect_db();
	
	echo getNewMessageCount($con, intval($_GET['_']));
	
	$con->close();
	
	http_response_code(200);
	
?>