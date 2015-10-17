<?php
	
	//Imports
	require_once 'includes/db_conn.php';
	require_once 'includes/SELECT.php';
	require_once 'includes/Changelog.php';
	
	$con = connect_db();
	
	$ADK_CHANGES = getChangelog($con);
	
	$con->close();
	
	$table_changelog = getTableChangelog($ADK_CHANGES);
	
?>