<?php
	
	//Imports
	require_once 'includes/db_conn.php';
	require_once 'includes/SELECT.php';
	require_once 'includes/classes/Correspondent.php';
	require_once 'includes/classes/File.php';
	require_once 'includes/classes/Hike.php';
	require_once 'includes/classes/Hiker.php';
	require_once 'includes/classes/Peak.php';

	if(!isset($_GET['_']) || !is_numeric($_GET['_'])) header("Location: ./");
	
	$ADK_USER_ID = intval($_GET['_']);
	
	$con = connect_db();
	
	$ADK_HIKER = new Hiker();
	$ADK_HIKER->id = $ADK_USER_ID;
	$ADK_HIKER->get($con);
	if($ADK_HIKER->name == '') header("Location: ./");

	$ADK_HIKES = new Hikes();
	$ADK_HIKES->userid = $ADK_USER_ID;
	$ADK_HIKES->get($con);

	$ADK_PEAKS = new Peaks();
	$ADK_PEAKS->get($con);

	if($_SESSION['ADK_USERGROUP_CDE'] == 'ADM'){
		if($GLOBALS['page'] === 'editHiker'){
			$ADK_CORRESPONDENTS = new Correspondents();
			$ADK_CORRESPONDENTS->get($con);
		}
	}
	
	if(isset($_GET['m']) && is_numeric($_GET['m'])){
		require_once 'includes/classes/File.php';
		require_once 'includes/classes/Message.php';
		$ADK_MESSAGE = new Message();
		$ADK_MESSAGE->id = $_GET['m'];
		$ADK_MESSAGE->userid = intval($_SESSION['ADK_USER_ID']);
		$ADK_MESSAGE->get($con);
		if($ADK_MESSAGE->title == '') unset($ADK_MESSAGE);
	}
	
	$con->close();
	
?>