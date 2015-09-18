<?php
	
	////Imports
	require_once 'db_conn.php';
	require_once 'SELECT.php';
	require_once 'User.php';
	
	$con = connect_db();//Connect to db
	if(mysqli_connect_errno())
	    return 'Error';
	
	$goodUsername = checkApplicantAndUserName($con, $_POST['username'], '');
	
	$con->close();
	
	if($goodUsername == true) http_response_code(200);//Good
	else http_response_code(418);//Bad
	
?>