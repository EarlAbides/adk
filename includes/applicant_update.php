<?php
	
	//Imports
	require_once 'db_conn.php';
	require_once 'SELECT.php';
	require_once 'UPDATE.php';
	require_once 'Applicant.php';
	require_once 'User.php';
	
	$con = connect_db();//Connect to db
		if(mysqli_connect_errno())
			return 'Error';
	
	$ADK_APPLICANT_ID = updateApplicant($con);
	
	$con->close();
	
	header('Location: ../applicant?_='.$ADK_APPLICANT_ID);
	
?>