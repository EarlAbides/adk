<?php
	
	//Imports
	require_once 'includes/db_conn.php';
	require_once 'includes/SELECT.php';
	require_once 'includes/Applicant.php';
	
	$con = connect_db();
	
	$ADK_CORRESPONDENTS = getApplicants($con);
	
	$con->close();
	
	$table_applicants = getTableApplicants($ADK_CORRESPONDENTS);
	
?>