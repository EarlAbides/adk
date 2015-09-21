<?php
	
	//Imports
	require_once 'includes/db_conn.php';
	require_once 'includes/SELECT.php';
	require_once 'includes/Correspondent.php';
	require_once 'includes/Hiker.php';
	require_once 'includes/User.php';
	
	if(isset($_SESSION['ADK_USER_ID'])){
		$ADK_USER_ID = intval($_SESSION['ADK_USER_ID']);
		if($ADK_USER_ID == '') header("Location: ./");
	}
	else header("Location: ./");
	
	$ADK_USERGROUP_CDE = $_SESSION['ADK_USERGROUP_CDE'];
	
	$con = connect_db();//Connect to db
	if(mysqli_connect_errno())
		return 'Error';
	
	switch($ADK_USERGROUP_CDE){
		case 'ADM': $ADK_USER = getUser($con, $ADK_USER_ID); break;
		case 'COR': $ADK_CORRESPONDENT = getCorrespondent($con, $ADK_USER_ID); break;
		case 'HIK': $ADK_HIKER = getHiker($con, $ADK_USER_ID); break;
		default: header("Location: ./");
	}
	
	$con->close();
	
?>