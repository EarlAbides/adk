<?php
	
	require_once "includes/session.php";
	require_once "includes/db/db_conn.php";
	require_once "includes/db/SELECT.php";
	require_once "includes/classes/Correspondent.php";
	require_once "includes/classes/Hiker.php";
	require_once "includes/classes/Pref.php";
	require_once "includes/classes/User.php";
	
	if(!isset($_SESSION["ADK_USER_ID"]) || !is_numeric($_SESSION["ADK_USER_ID"])){header("Location: ./"); exit;}

	$ADK_USER_ID = intval($_SESSION["ADK_USER_ID"]);
	
	$con = connect_db();

	$ADK_PREFS = new Prefs();
	$ADK_PREFS->getUsersPrefs($con, $ADK_USER_ID);
	
	switch($ADK_USERGROUP_CDE){
		case "ADM": case "EDT":
			$ADK_USER = new User();
			$ADK_USER->id = $ADK_USER_ID;
			$ADK_USER->get($con);
			break;
		case "COR":
			$ADK_CORRESPONDENT = new Correspondent();
			$ADK_CORRESPONDENT->id = $ADK_USER_ID;
			$ADK_CORRESPONDENT->get($con);
			break;
		case "HIK":
			$ADK_HIKER = new Hiker($con);
			$ADK_HIKER->id = $ADK_USER_ID;
			$ADK_HIKER->get($con);
			break;
		default: header("Location: ./");
	}
	
	$con->close();
	
?>
