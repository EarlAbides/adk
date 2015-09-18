<?php
	
	//Imports
	require_once 'db_conn.php';
	require_once 'DELETE.php';
	require_once 'Applicant.php';
	
	$con = connect_db();//Connect to db
		if(mysqli_connect_errno())
			return 'Error';
	
	deleteApplicant($con);
		
	$con->close();
	
	header('Location: ../applicants?e=d');
	
?>