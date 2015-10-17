<?php
	
	//Imports
	require_once 'session.php';
	require_once 'db_conn.php';
	require_once 'SELECT.php';
	require_once 'UPDATE.php';
	require_once 'Correspondent.php';
	require_once 'User.php';
	
	$con = connect_db();
	
	$ADK_USERGROUP_ID = 2;
	updateUser($con, $ADK_USERGROUP_ID);
	$ADK_CORRESPONDENT_ID = updateCorrespondent($con);
	
	$con->close();
	
	switch($_SESSION['ADK_USERGROUP_CDE']){
		case 'ADM': header('Location: ../correspondent?_='.$ADK_CORRESPONDENT_ID); break;
		case 'COR': header('Location: ../hikers'); break;
		default: header('Location: ../');
	}
	
?>