<?php
	
	//Imports
	require_once 'variables_site.php';
	require_once 'db_conn.php';
	require_once 'SELECT.php';
	require_once 'INSERT.php';
	require_once 'Applicant.php';
	require_once 'Message.php';
	require_once 'User.php';
	require_once 'email.php';
	require_once 'pm.php';
	
	$con = connect_db();
	
	$ADK_APPLICANT = addApplicant($con);
	
	//Email
	sendNewApplicantEmail($ADK_APPLICANT);
	
	//PM
	sendNewApplicantPM($con, $ADK_APPLICANT);
	
	$con->close();
	
	header('Location: ../thankyou');
?>