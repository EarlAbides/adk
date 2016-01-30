<?php
	
	////Imports
	require_once 'db_conn.php';
	require_once 'SELECT.php';
	require_once 'classes/User.php';
	
	
	$exempt = isset($_GET['_'])? $_GET['_']: '';

	$con = connect_db();
	
	if(!User::isUniqueUsername($con, $_POST['username'], $exempt)) $code = 418;
	else $code = 200;

	$con->close;

	http_response_code($code);
	
?>