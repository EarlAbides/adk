<?php
	
	//Imports
	require_once 'db/db_conn.php';
	require_once 'db/SELECT.php';
	require_once 'db/UPDATE.php';
	require_once 'classes/Applicant.php';
	require_once 'classes/User.php';
	require_once 'classes/Peak.php';
	
	$con = connect_db();
	
	$old_ADK_APPLICANT = new Applicant();
	$old_ADK_APPLICANT->id = intval($_POST['id']);
	$old_ADK_APPLICANT->get($con);

	$ADK_APPLICANT = new Applicant();
	$ADK_APPLICANT->populateFromUpdate();
	
	if(!$ADK_APPLICANT->isValid()){
		$con->close();
		header('Location: ../editApplicant?_='.$ADK_APPLICANT->id.'&e='.$ADK_APPLICANT->err);
		exit;
	}
	if(!User::isUniqueUsername($con, $ADK_APPLICANT->username, $old_ADK_APPLICANT->username)){
		$con->close();
		header('Location: ../editApplicant?_='.$ADK_APPLICANT->id.'&e=q');
		exit;
	}
	
	$ADK_APPLICANT->sanitize();
	$ADK_APPLICANT->update($con);
	
	$con->close();
	
	header('Location: ../applicant?_='.$ADK_APPLICANT->id);
	
?>