<?php
	
	//Imports
	require_once 'includes/db_conn.php';
	require_once 'includes/SELECT.php';
	require_once 'includes/Correspondent.php';
	
	$con = connect_db();//Connect to db
	if(mysqli_connect_errno())
		return 'Error';
	
	$ADK_CORRESPONDENTS = getCorrespondents($con);
	
	$con->close();
	
	$table_correspondents = getTableViewCorrespondents($ADK_CORRESPONDENTS);
	
?>