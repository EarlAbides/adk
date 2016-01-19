<?php
	
	//Imports
	require_once 'includes/db_conn.php';
	require_once 'includes/SELECT.php';
	require_once 'includes/Hike.php';
	require_once 'includes/Hiker.php';
	require_once 'includes/Correspondent.php';
	require_once 'includes/Peak.php';
	
	if(isset($_GET['_'])){
		$ADK_USER_ID = intval($_GET['_']);
		if($ADK_USER_ID == '') header("Location: ./");
	}
	else header("Location: ./");
	
	$con = connect_db();
	
	$ADK_HIKER = getHiker($con, $ADK_USER_ID);
	if($ADK_HIKER == '') header("Location: ./");
	$ADK_HIKES = getHikes($con, $ADK_USER_ID);
	$ADK_HIKES = getHikesPeaks($con, $ADK_HIKES);
	$ADK_HIKER['ADK_HIKER_REMAININGPEAKS'] = getRemainingPeaks($con, $ADK_USER_ID);
	if($_SESSION['ADK_USERGROUP_CDE'] == 'ADM'){
		$ADK_CORRESPONDENTS = getCorrespondents($con);
		if($GLOBALS['page'] === 'editHiker') $table_correspondents = getTableSelectCorrespondents($ADK_CORRESPONDENTS);
	}
	
	if(isset($_GET['m'])){
		if($_GET['m'] !== ''){
			require_once 'includes/Message.php';
			$ADK_MESSAGE = getMessage($con, $_GET['m']);
			if($ADK_MESSAGE == '') unset($ADK_MESSAGE);
			else $ADK_MESSAGE = htmlspecialchars(json_encode($ADK_MESSAGE));
			
			
		}
	}
	
	$con->close();
	
	$table_hikes = getTableHikes($ADK_HIKES);
	
?>