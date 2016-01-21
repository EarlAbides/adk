<?php
	
	//Imports
	require_once 'db_conn.php';
	require_once 'DELETE.php';
	require_once 'Applicant.php';
	
	if(!isset($_POST['id']) || !isNumeric($_POST['id'])){
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