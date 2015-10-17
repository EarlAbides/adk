<?php
	
	//Imports
	require_once 'includes/db_conn.php';
	require_once 'includes/SELECT.php';
	require_once 'includes/Correspondent.php';
	
	$con = connect_db();
	
	$ADK_CORRESPONDENTS = getCorrespondents($con);
	
	$con->close();
	
	$table_correspondents = getTableViewCorrespondents($ADK_CORRESPONDENTS);
	
?>