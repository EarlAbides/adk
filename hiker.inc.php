<?php
	
	//Imports
	require_once 'includes/db_conn.php';
	require_once 'includes/SELECT.php';
	require_once 'includes/Hike.php';
	require_once 'includes/classes/Correspondent.php';
	require_once 'includes/classes/Hiker.php';
	require_once 'includes/classes/Peak.php';
	
	if(isset($_GET['_'])){
		$ADK_USER_ID = intval($_GET['_']);
		if($ADK_USER_ID == '') header("Location: ./");
	}
	else header("Location: ./");
	
	$con = connect_db();
	
	$ADK_HIKER = new Hiker();
	$ADK_HIKER->id = $ADK_USER_ID;
	$ADK_HIKER->get($con);
	if($ADK_HIKER->name == '') header("Location: ./");

	$ADK_HIKES = getHikes($con, $ADK_USER_ID);
	$ADK_HIKES = getHikesPeaks($con, $ADK_HIKES);

	$ADK_PEAKS = new Peaks();
	$ADK_PEAKS->get($con);

	if($_SESSION['ADK_USERGROUP_CDE'] == 'ADM'){
		if($GLOBALS['page'] === 'editHiker'){
			$ADK_CORRESPONDENTS = new Correspondents();
			$ADK_CORRESPONDENTS->get($con);
		}
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