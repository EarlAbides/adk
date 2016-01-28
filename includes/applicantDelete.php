<?php
	
	//Imports
	require_once 'db_conn.php';
	require_once 'DELETE.php';
	require_once 'classes/Applicant.php';
	
	if(!isset($_POST['id']) || !is_numeric($_POST['id'])){
		header('Location: ../applicants?e=i');
		exit;
	}
	
	$con = connect_db();
	
	$ADK_APPLICANT = new Applicant();
	$ADK_APPLICANT->id = intval($_POST['id']);	
	$ADK_APPLICANT->delete($con);
	
	$con->close();
	
	header('Location: ../applicants');
	
?>