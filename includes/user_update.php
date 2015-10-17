<?php
	
	//Imports
	require_once 'session.php';
	require_once 'db_conn.php';
	require_once 'SELECT.php';
	require_once 'UPDATE.php';
	require_once 'Correspondent.php';
	require_once 'User.php';
	
	$con = connect_db();
	
	$ADK_USERGROUP_ID = 1;
	$ADK_USER = updateUser($con, $ADK_USERGROUP_ID);
	
	$con->close();

	$_SESSION['ADK_USER_USERNAME'] = $ADK_USER['ADK_USER_USERNAME'];
	
	header('Location: ../');
	
?>