<?php
	
	//Imports	
	require_once 'includes/session.php';
	require_once 'includes/db/db_conn.php';
	require_once 'includes/db/SELECT.php';
	require_once 'includes/classes/User.php';
	require_once 'includes/classes/Hiker.php';
	require_once 'includes/classes/Message.php';
	
	if(!isset($_SESSION['ADK_USER_ID']) || !is_numeric($_SESSION['ADK_USER_ID'])){header("Location: ./"); exit;}
	$ADK_USERGROUP_CDE = $_SESSION['ADK_USERGROUP_CDE'];
	$ADK_USER_ID = intval($_SESSION['ADK_USER_ID']);

	$ADK_TO_USER_ID = null;
	if(isset($_GET['_']) && is_numeric($_GET['_'])) $ADK_TO_USER_ID = $_GET['_'];
	
	$con = connect_db();
	
	if($ADK_TO_USER_ID){
		$ADK_TO_USER = new User();
		$ADK_TO_USER->id = $ADK_TO_USER_ID;
		$ADK_TO_USER->get($con);
	}
	
	$ADK_MESSAGES = new Messages();
	$ADK_MESSAGES->userid = $ADK_USER_ID;
	$ADK_MESSAGES->foldername = 'Inbox';
	$ADK_MESSAGES->get($con);
	
	$disableMsgs = false;
	switch($ADK_USERGROUP_CDE){
		case 'ADM':
			require_once 'includes/classes/Template.php';
			$ADK_MSG_TMPLS = new Templates();
			$ADK_MSG_TMPLS->get($con, $_SESSION['ADK_USER_ID']);
			$ADK_HIKERS = new Hikers();
			$ADK_HIKERS->get($con, $ADK_USER_ID);
			break;
		case 'COR':
			require_once 'includes/classes/Template.php';
			$ADK_MSG_TMPLS = new Templates();
			$ADK_MSG_TMPLS->get($con, $_SESSION['ADK_USER_ID']);
			$ADK_HIKERS = new Hikers();
			$ADK_HIKERS->get($con, $ADK_USER_ID);
			break;
		case 'HIK':
			require_once 'includes/classes/Correspondent.php';
			$ADK_HIKER = new Hiker();
			$ADK_HIKER->id = $ADK_USER_ID;
			$ADK_HIKER->get($con);
			$ADK_CORRESPONDENT = new Correspondent();
			$ADK_CORRESPONDENT->id = $ADK_HIKER->corrid;
			$ADK_CORRESPONDENT->get($con);
			$disableMsgs = $ADK_HIKER->numpeaks >= 46? 'disabled="disabled"': false;
			break;
	}
	
	$con->close();
	
?>