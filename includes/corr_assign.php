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
	require_once 'Hike.php';
	require_once 'Hiker.php';
	require_once 'Message.php';
	require_once 'User.php';
	require_once 'randomPW.php';
	require_once 'email.php';
	require_once 'pm.php';
	
	$randomPW = randomPW(8);
	$ADK_CORR_ID = $_POST['corrid'];
	
	$con = connect_db();
	
	$ADK_USERGROUP_ID = 3;
	$ADK_USER = addUser($con, $ADK_USERGROUP_ID, $randomPW);
	$ADK_HIKER = addHiker($con, $ADK_USER['ADK_USER_ID']);
	
	//Make initial hikes
	$ADK_APPLICANT = getApplicant($con, $_POST['id']);
	$ADK_APPLICANT_PEAKIDS = explode(',', $ADK_APPLICANT['ADK_APPLICANT_PEAKIDS']);
	foreach($ADK_APPLICANT_PEAKIDS as $ADK_PEAK_ID){
		$ADK_HIKE = addInitialHikes($con, $ADK_USER['ADK_USER_ID'], $ADK_PEAK_ID);
		addInitialHikesPeaks($con, $ADK_HIKE['ADK_HIKE_ID'], $ADK_PEAK_ID);
	}

	deleteApplicant($con, $ADK_APPLICANT['ADK_APPLICANT_ID']);
	
	$ADK_HIKER['ADK_HIKER_PEAKLIST'] = $ADK_APPLICANT['ADK_APPLICANT_PEAKLIST'];
    $ADK_CORRESPONDENT = getCorrespondent($con, $ADK_CORR_ID);
	
	//Emails
	sendNewHikerEmail($ADK_USER, $ADK_CORRESPONDENT);
	sendCorrNewHikerEmail($ADK_CORRESPONDENT['ADK_USER_EMAIL'], $ADK_USER, $ADK_HIKER);
	
	//PMs
	sendCorrNewHikerPM($con, $ADK_CORRESPONDENT['ADK_USER_ID'], $ADK_USER, $ADK_HIKER);
	
	$con->close();
	
	header("Location: ../applicants");
	
?>