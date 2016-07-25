<?php
	
	//Imports
	require_once 'includes/db/db_conn.php';
	require_once 'includes/db/SELECT.php';
	require_once 'includes/classes/Correspondent.php';
	require_once 'includes/classes/File.php';
	require_once 'includes/classes/Hike.php';
	require_once 'includes/classes/Hiker.php';
	require_once 'includes/classes/Peak.php';
	
	if(!isset($_SESSION['ADK_USER_ID']) || !is_numeric($_SESSION['ADK_USER_ID'])) header("Location: ./");
	
	$ADK_USER_ID = intval($_SESSION['ADK_USER_ID']);
	
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
	
	$ADK_CORRESPONDENT = new Correspondent();
	$ADK_CORRESPONDENT->id = $ADK_HIKER->corrid;
	$ADK_CORRESPONDENT->get($con);
	
	$con->close();
	
?>