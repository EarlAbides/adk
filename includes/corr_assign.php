<?php
	
	//Imports
	require_once 'variables_site.php';
	require_once 'db_conn.php';
	require_once 'SELECT.php';
	require_once 'INSERT.php';
	require_once 'UPDATE.php';
	require_once 'DELETE.php';
	require_once 'Applicant.php';
	require_once 'Correspondent.php';
	require_once 'Hiker.php';
	require_once 'Message.php';
	require_once 'User.php';
	require_once 'randomPW.php';
	require_once 'email.php';
	require_once 'pm.php';
	
	$randomPW = randomPW(8);
	$ADK_CORR_ID = $_POST['corrid'];
	
	$con = connect_db();//Connect to db
		if(mysqli_connect_errno())
			return 'Error';
	
	$ADK_USERGROUP_ID = 3;
	$ADK_USER = addUser($con, $ADK_USERGROUP_ID, $randomPW);
	addHiker($con, $ADK_USER['ADK_USER_ID']);
	deleteApplicant($con);
	
    $ADK_HIKER = getHiker($con, $ADK_USER['ADK_USER_ID']);
	$ADK_CORRESPONDENT = getCorrespondent($con, $ADK_CORR_ID);
	
	//Emails
	sendNewHikerEmail($ADK_USER, $ADK_CORRESPONDENT);
	sendCorrNewHikerEmail($ADK_CORRESPONDENT['ADK_USER_EMAIL'], $ADK_USER, $ADK_HIKER);
	
	//PMs
	sendCorrNewHikerPM($con, $ADK_CORRESPONDENT['ADK_USER_ID'], $ADK_USER, $ADK_HIKER);
	
	$con->close();
	
	header("Location: ../applicants?e=a");
	
?>