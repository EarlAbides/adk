<?php
	
	//Imports
	require_once 'includes/db_conn.php';
	require_once 'includes/SELECT.php';
	require_once 'includes/Message.php';
	require_once 'includes/User.php';
	
	if(isset($_SESSION['ADK_USER_ID'])){
		$ADK_USER_ID = $_SESSION['ADK_USER_ID'];
		if($ADK_USER_ID == '') header("Location: ./");
	}
	else header("Location: ./");
	$ADK_TO_USER_ID = '';
	if(isset($_GET['_'])) $ADK_TO_USER_ID = $_GET['_'];
	
	$con = connect_db();
	
	$folderName = 'Inbox';
	
	if($ADK_TO_USER_ID !== '') $ADK_TO_USER = getUser($con, $ADK_TO_USER_ID);
	
	$ADK_MESSAGES = getMessages($con, $ADK_USER_ID, $folderName);
	
	$table_messages = getTableMessages($ADK_MESSAGES, $folderName);
		
	switch($ADK_USERGROUP_CDE){
		case 'ADM':
			require_once 'includes/Hiker.php';
			$ADK_HIKERS = getHikers($con);
			break;
			break;
		case 'COR':
			require_once 'includes/Hiker.php';
			$ADK_HIKERS = getHikers($con, $ADK_USER_ID);
			break;
		case 'HIK':
			require_once 'includes/Correspondent.php';
			require_once 'includes/Hiker.php';
			$ADK_HIKER = getHiker($con, $ADK_USER_ID);
			$ADK_CORRESPONDENT = getCorrespondent($con, $ADK_HIKER['ADK_HIKER_CORR_ID']);
			break;
	}
	
	$con->close();
	
?>