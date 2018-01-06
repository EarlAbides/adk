<?php
	
	require_once 'includes/db/db_conn.php';
	require_once 'includes/db/SELECT.php';
	require_once 'includes/classes/Hiker.php';
	
	$ADK_USER_ID = $_SESSION['ADK_USER_ID'];
	if($_SESSION['ADK_USERGROUP_CDE'] === 'ADM' || $_SESSION['ADK_USERGROUP_CDE'] === 'EDT') $ADK_USER_ID = '%';
	
	$ADK_USER_ID = $_SESSION['ADK_USERGROUP_CDE'] === 'COR'? $_SESSION['ADK_USER_ID']: '%';

	$con = connect_db();
	
	$ADK_HIKERS = new Hikers();
	$ADK_HIKERS->get($con, $ADK_USER_ID);
	
	$con->close();
	
?>