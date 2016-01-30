<?php
	
	//Imports
	require_once 'includes/db_conn.php';
	require_once 'includes/SELECT.php';
	require_once 'includes/classes/Correspondent.php';
	
	$con = connect_db();
	
	$ADK_CORRESPONDENTS = new Correspondents();
	$ADK_CORRESPONDENTS->get($con);
	
	$con->close();
	
?>