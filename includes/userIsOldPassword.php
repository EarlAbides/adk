<?php
	
	////Imports
	require_once 'db_conn.php';
	require_once 'SELECT.php';
	require_once 'classes/User.php';

	if(!isset($_POST['id']) || !is_numeric($_POST['id'])){http_response_code(400); exit;}
	if(!isset($_POST['oldpassword']) || count($_POST['oldpassword']) === 0){http_response_code(400); exit;}
	
	$ADK_USER_PASSWORD = $_POST['oldpassword'];

	$ADK_USER = new User();
	$ADK_USER->id = intval($_POST['id']);
	
	$con = connect_db();
	
	if(!$ADK_USER->isOldPassword($con, $ADK_USER_PASSWORD)) $code = 418;
	else $code = 200;
	
	$con->close;

	http_response_code($code);
	
?>