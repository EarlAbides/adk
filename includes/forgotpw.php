<?php
	
	//Imports
	require_once 'session.php';
	require_once 'variables_site.php';
	require_once 'db_conn.php';
	require_once 'SELECT.php';
	require_once 'email.php';
	require_once 'classes/User.php';
	
	$con = connect_db();
	
	$ADK_USER = new User();
	$ADK_USER->username = $_POST['username'];
	$ADK_USER->email = $_POST['email'];
	$ADK_USER->isUser($con);
	if($ADK_USER->name == ''){header('Location: ../forgot?ue'); exit;}

	$con->close();
	
	sendPWResetLinkEmail($ADK_USER);
	
	header('Location: ../forgot?s='.$ADK_USER->email);
	
?>