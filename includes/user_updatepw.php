<?php
	
	//Imports
	require_once 'db_conn.php';
	require_once 'SELECT.php';
	require_once 'UPDATE.php';
	require_once 'User.php';
	
	$con = connect_db();//Connect to db
		if(mysqli_connect_errno())
			return 'Error';
	
	$ADK_USER_ID = intval($_POST['id']);
	if(!isset($_POST['checkold'])) $ADK_USER_PASSWORD_OLD = md5($_POST['oldpassword']);
	$ADK_USER_PASSWORD = md5($_POST['password']);
	$ADK_USER_PASSWORD_CONFIRM = md5($_POST['confirmpassword']);
	
	if(!isset($_POST['checkold'])) $goodPassword = checkUserOldPassword($con, $ADK_USER_ID, $ADK_USER_PASSWORD_OLD);
	
	$error = '';
	if(!isset($_POST['checkold'])){if($goodPassword == false) $error .= 'o';}
	if($ADK_USER_PASSWORD !== $ADK_USER_PASSWORD_CONFIRM) $error .= 'm';
	if($error !== '') header('Location: ../profile?e='.$error);
	
	updateUserPW($con, $ADK_USER_ID, $ADK_USER_PASSWORD);
	
	$con->close();
	
	switch($_SESSION['ADK_USERGROUP_CDE']){
		case 'COR': header('Location: ../hikers'); break;
		case 'HIK': header('Location: ../hikerportal'); break;
		default: header('Location: ../');
	}
	
?>