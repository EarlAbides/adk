<?php
	
	//Imports
	require_once 'db/db_conn.php';
	require_once 'db/UPDATE.php';
	require_once 'classes/User.php';

	if(!isset($_POST['id']) || !is_numeric($_POST['id'])){header('Location: ../'); exit;}
	
	$con = connect_db();

	$ADK_USER_PASSWORD = $_POST['password'];
	$ADK_USER_PASSWORD_CONFIRM = $_POST['confirmpassword'];

	$ADK_USER = new User();
	$ADK_USER->id = intval($_POST['id']);
	$ADK_USER->pw = $_POST['password'];

	if(isset($_POST['checkold'])){
		require_once 'SELECT.php';
		if(!$ADK_USER->isOldPassword($con, $_POST['oldpassword'])){header('Location: ../profile?e=o'); exit;}
	}
	if($ADK_USER_PASSWORD !== $ADK_USER_PASSWORD_CONFIRM){header('Location: ../profile?e=m'); exit;}
	
	$ADK_USER->updatePW($con);

	$con->close();
	
	switch($_SESSION['ADK_USERGROUP_CDE']){
		case 'COR': header('Location: ../hikers'); break;
		case 'HIK': header('Location: ../hikerportal'); break;
		default: header('Location: ../?123');
	}
	
?>