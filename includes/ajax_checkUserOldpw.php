<?php
	
	////Imports
	require_once 'db_conn.php';
	require_once 'SELECT.php';
	require_once 'User.php';
	
	$con = connect_db();
	
	$ADK_USER_ID = intval($_POST['id']);
	$ADK_USER_PASSWORD = md5($_POST['oldpassword']);
	
	$goodPassword = checkUserOldPassword($con, $ADK_USER_ID, $ADK_USER_PASSWORD);
	
	$con->close();
	
	if($goodPassword == true) http_response_code(200);//Good
	else http_response_code(418);//Bad
	
?>