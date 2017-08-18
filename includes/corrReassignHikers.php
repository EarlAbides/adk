<?php
	
	require_once "db/db_conn.php";
	require_once "db/UPDATE.php";
	require_once "classes/Correspondent.php";

	if(!isset($_POST["id"]) || !is_numeric($_POST["id"])){header("Location: ../correspondents?e=i"); exit;}
	if(!isset($_POST["corrid"]) || !is_numeric($_POST["corrid"])){header("Location: ../correspondent?_=".$_POST["id"]."&e=c"); exit;}
	
	$ADK_USER_ID = intval($_POST["corrid"]);
	$old_ADK_CORRESPONDENT_ID = intval($_POST["id"]);
	
	$con = connect_db();

	$ADK_CORRESPONDENT = new Correspondent();
	$ADK_CORRESPONDENT->id = $ADK_USER_ID;
	$ADK_CORRESPONDENT->reassignHikers($con, $old_ADK_CORRESPONDENT_ID);
	
	$con->close();
	
	header("Location: ../correspondent?_=$ADK_USER_ID);
	
?>