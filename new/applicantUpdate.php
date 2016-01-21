<?php
	
	//Imports
	require_once 'db_conn.php';
	require_once 'SELECT.php';
	require_once 'UPDATE.php';
	require_once 'Applicant.php';
	require_once 'User.php';
	
	$con = connect_db();
	
	$ADK_APPLICANT = new Applicant();
	$old_ADK_APPLICANT = $ADK_APPLICANT->get($con);
	$ADK_APPLICANT->populateFromUpdate();
	
	if(!$ADK_APPLICANT->isValid(){
		$con->close();
		header('Location: ../signup?e='.$this->err);
		exit;
	}
	if(!User::isUniqueUsername($con, $ADK_APPLICANT->username, $old_ADK_APPLICANT->username)){
		$con->close();
		header('Location: ../applicant?e=q');
		exit;
	}
	
	$ADK_APPLICANT->save($con);
	
	$con->close();
	
	header('Location: ../applicant?_='.$ADK_APPLICANT->id);
	
?>