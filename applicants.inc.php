<?php
	
	require_once 'includes/db/db_conn.php';
	require_once 'includes/db/SELECT.php';
	require_once 'includes/classes/Applicant.php';
	
	$con = connect_db();
	
	$ADK_APPLICANTS = new Applicants();
	$ADK_APPLICANTS->get($con);
	
	$con->close();
	
?>