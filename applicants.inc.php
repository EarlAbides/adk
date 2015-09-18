<?php
	
	//Imports
	require_once 'includes/db_conn.php';
	require_once 'includes/SELECT.php';
	require_once 'includes/Applicant.php';
	
	$con = connect_db();//Connect to db
	if(mysqli_connect_errno())
		return 'Error';
	
	$ADK_CORRESPONDENTS = getApplicants($con);
	
	$con->close();
	
	$table_applicants = getTableApplicants($ADK_CORRESPONDENTS);
	
?>