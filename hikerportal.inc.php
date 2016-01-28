<?php
	
	//Imports
	require_once 'includes/db_conn.php';
	require_once 'includes/SELECT.php';
	require_once 'includes/Hike.php';
	require_once 'includes/Correspondent.php';
	require_once 'includes/classes/Hiker.php';
	require_once 'includes/classes/Peak.php';
	
	if($_SESSION['ADK_USER_ID']){
		if($_SESSION['ADK_USER_ID'] == '') header("Location: ./");
	}
	else header("Location: ./");
	
	$con = connect_db();
	
	$ADK_HIKER = new Hiker();
	$ADK_HIKER->id = $_SESSION['ADK_USER_ID'];
	$ADK_HIKER->get($con);
	if($ADK_HIKER->name == '') header("Location: ./");

	$ADK_HIKES = getHikes($con, $_SESSION['ADK_USER_ID']);
	$ADK_HIKES = getHikesPeaks($con, $ADK_HIKES);
    
	$ADK_PEAKS = new Peaks();
	$ADK_PEAKS->get($con);

	$ADK_CORRESPONDENT = getCorrespondent($con, $ADK_HIKER->corrid);
	
	$con->close();
	
	$table_hikes = getTableHikes($ADK_HIKES);
	
?>