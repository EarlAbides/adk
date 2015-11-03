<?php
	
	//Imports
	require_once 'db_conn.php';
	require_once 'DELETE.php';
	require_once 'Applicant.php';
	
	$con = connect_db();
	
	deleteApplicant($con, $_POST['id']);
		
	$con->close();
	
	header('Location: ../applicants?e=d');
	
?>