<?php
	
	//Imports
	require_once 'includes/db/db_conn.php';
	require_once 'includes/db/SELECT.php';
	require_once 'includes/classes/Correspondent.php';
	require_once 'includes/classes/Hiker.php';
	
	if(!isset($_GET['_']) || !is_numeric($_GET['_'])) header("Location: ./");
	$ADK_CORR_ID = intval($_GET['_']);
	
	$con = connect_db();
	
	$ADK_CORRESPONDENT = new Correspondent();
	$ADK_CORRESPONDENT->id = $ADK_CORR_ID;
	$ADK_CORRESPONDENT->get($con);
	if($ADK_CORRESPONDENT->name == '') header("Location: ./");
	
	$ADK_HIKERS = new Hikers();
	$ADK_HIKERS->get($con, $ADK_CORRESPONDENT->id);
	
	if($GLOBALS['page'] === 'editCorrespondent'){
		$_ADK_CORRESPONDENTS = new Correspondents();
		$ADK_CORRESPONDENTS = new Correspondents();
		$_ADK_CORRESPONDENTS->get($con);
		foreach($_ADK_CORRESPONDENTS->correspondents as $corr){
			if($corr->id !== $ADK_CORRESPONDENT->id) array_push($ADK_CORRESPONDENTS->correspondents, $corr);
		}
	}
	
	$con->close();
	
?>