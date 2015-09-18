<?php
	
	//Imports
	require_once 'includes/db_conn.php';
	require_once 'includes/SELECT.php';
	require_once 'includes/Hike.php';
	require_once 'includes/Hiker.php';
	require_once 'includes/Correspondent.php';
	require_once 'includes/Peak.php';
	
	if($_SESSION['ADK_USER_ID']){
		$ADK_USER_ID = $_SESSION['ADK_USER_ID'];
	    if($ADK_USER_ID == '') header("Location: ./");
	}
	else header("Location: ./");
	
	$con = connect_db();//Connect to db
	if(mysqli_connect_errno())
	    return 'Error';
	
	$ADK_HIKER = getHiker($con, $ADK_USER_ID);
	if($ADK_HIKER == '') header("Location: ./");
	$ADK_HIKES = getHikes($con, $ADK_USER_ID);
	$ADK_HIKES = getHikesPeaks($con, $ADK_HIKES);
    $ADK_HIKER['ADK_HIKER_REMAININGPEAKS'] = getRemainingPeaks($con, $ADK_USER_ID);
	$ADK_CORRESPONDENT = getCorrespondent($con, $ADK_HIKER['ADK_HIKER_CORR_ID']);
	
	$con->close();
	
	$table_hikes = getTableHikes($ADK_HIKES);
	
?>