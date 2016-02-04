<?php
	
	//Imports
	require_once 'variables_site.php';
	require_once 'db_conn.php';
	require_once 'SELECT.php';
	require_once 'INSERT.php';
	require_once 'email.php';
	require_once 'pm.php';
	require_once 'classes/Applicant.php';
	require_once 'classes/Message.php';
	require_once 'classes/User.php';
	
	$con = connect_db();
	
	$ADK_APPLICANT = new Applicant();
	$ADK_APPLICANT->populateFromSignUp();
		
	if(!$ADK_APPLICANT->isValid()){
		$con->close();
		header('Location: ../signup?e='.$this->err);
		exit;
	}
	if(!User::isUniqueUsername($con, $ADK_APPLICANT->username, '')){
		$con->close();
		header('Location: ../signup?e=q');
		exit;
	}
	
	$ADK_APPLICANT->sanitize();
	$ADK_APPLICANT->save($con);
	$ADK_APPLICANT->get($con);
	
	sendNewApplicantEmail($ADK_APPLICANT);
	sendNewApplicantPM($con, $ADK_APPLICANT);
	
	$con->close();
	
	header('Location: ../thankyou');
	
?>