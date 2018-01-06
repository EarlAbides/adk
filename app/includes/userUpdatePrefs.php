<?php
	
	require_once "session.php";
	require_once "db/db_conn.php";
	require_once "db/SELECT.php";
	require_once "db/INSERT.php";
	require_once "db/UPDATE.php";
	require_once "classes/Pref.php";

	if(!isset($_POST["id"]) || !is_numeric($_POST["id"])){ header("Location: ../"); exit; }
	else $ADK_USER_ID = $_POST["id"];

	$ADK_USERGROUP_CDE = $_SESSION['ADK_USERGROUP_CDE'];

	$con = connect_db();

	$ADK_PREFS = new Prefs();
	if($ADK_USERGROUP_CDE === "HIK"){
		$ADK_PREFS->set("hiker_receive-inactive-user-emails", isset($_POST["hiker_receive-inactive-user-emails"]));
	}
	$ADK_PREFS->set("user_receive-newsletter", isset($_POST["user_receive-newsletter"]));
	
	$ADK_PREFS->save($con, $ADK_USER_ID);
	
	$con->close();
	
	header("Location: ../");
	
?>
