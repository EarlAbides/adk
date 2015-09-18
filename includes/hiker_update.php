<?php
	
	//Imports
	require_once 'session.php';
	require_once 'db_conn.php';
	require_once 'SELECT.php';
	require_once 'UPDATE.php';
	require_once 'Hiker.php';
	require_once 'User.php';
	
	$con = connect_db();//Connect to db
		if(mysqli_connect_errno())
			return 'Error';
	
	$ADK_USERGROUP_ID = 3;
	updateUser($con, $ADK_USERGROUP_ID);
	$ADK_USER_ID = updateHiker($con);
	
	$con->close();
	
	switch($_SESSION['ADK_USERGROUP_CDE']){
		case 'ADM': case 'COR': header('Location: ../hiker?_='.$ADK_USER_ID); break;
		default: header('Location: ../hikerportal');
	}
	
?>