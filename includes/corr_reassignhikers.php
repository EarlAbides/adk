<?php
	
	//Imports
	require_once 'db_conn.php';
	require_once 'UPDATE.php';
	require_once 'Correspondent.php';
	
	$ADK_USER_ID = intval($_POST['id']);
	$newCorrID = intval($_POST['corrid']);
	
	$con = connect_db();
	
	updateReassignCorrsHikers($con, $ADK_USER_ID, $newCorrID);
	
	$con->close();
	
	header('Location: ../correspondent?_='.$ADK_USER_ID);
	
?>