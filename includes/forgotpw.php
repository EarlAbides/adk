<?php
	
	//Imports
	require_once 'session.php';
	require_once 'variables_site.php';
	require_once 'db_conn.php';
	require_once 'SELECT.php';
	require_once 'User.php';
	require_once 'email.php';
	
	$con = connect_db();
	
	$ADK_USER_USERNAME = $_POST['username'];
	$ADK_USER_EMAIL = $_POST['email'];
	$ADK_USER = checkIsUser($con, $ADK_USER_USERNAME, $ADK_USER_EMAIL);
	if($ADK_USER == ''){header('Location: ../forgot?ue'); exit;}
	
	$con->close();
	
	sendPWResetLinkEmail($ADK_USER);
	
	header('Location: ../forgot?s='.$ADK_USER['ADK_USER_EMAIL']);
	
?>