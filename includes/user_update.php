<?php
	
	//Imports
	require_once 'db_conn.php';
	require_once 'SELECT.php';
	require_once 'UPDATE.php';
	require_once 'Correspondent.php';
	require_once 'User.php';
	
	$con = connect_db();//Connect to db
		if(mysqli_connect_errno())
			return 'Error';
	
	$ADK_USERGROUP_ID = 1;
	updateUser($con, $ADK_USERGROUP_ID);
	
	$con->close();
	
	header('Location: ../');
	
?>