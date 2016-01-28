<?php
	
	//Imports
	require_once 'variables_site.php';
	require_once 'db_conn.php';
	require_once 'SELECT.php';
	require_once 'INSERT.php';
	require_once 'Hike.php';
	require_once 'Message.php';
	require_once 'randomPW.php';
	require_once 'email.php';
	require_once 'pm.php';
	require_once 'classes/Applicant.php';
	require_once 'classes/Hiker.php';
	require_once 'classes/User.php';
	
	if(!isset($_POST['id']) || !is_numeric($_POST['id']){header('../applicants?_e=i'); exit;}
	if(!isset($_POST['corrid']) || !is_numeric($_POST['corrid']){header('../applicant?_='.$_POST['id']); exit;}
	
	$ADK_APPLICANT_ID = intval($_POST['id']);
	$ADK_CORRESPONDENT_ID = intval($_POST['corrid']);
	$randomPW = randomPW(8);
	
	$con = connect_db();
	
	$ADK_APPLICANT = new Applicant();
	$ADK_APPLICANT->id = $ADK_APPLICANT_ID;
	$ADK_APPLICANT->get($con);
	$ADK_APPLICANT->delete($con);
	
	$ADK_USER = new User();
	$ADK_USER->populateFromAddHiker($randomPW);
	$ADK_USER->save($con);
	
	$ADK_HIKER = new Hiker();
	$ADK_HIKER->populateFromApplicant($ADK_USER->id, $ADK_CORRESPONDENT_ID, $ADK_APPLICANT);
	$ADK_HIKER->save($con);
	
	//maybe http://blog.fedecarg.com/2009/02/22/mysql-split-string-function/ to split string in getHiker query???
	
	//get peak list
	//add hikes
	
	//get correspondent
	
	
	sendNewHikerEmail($ADK_USER, $ADK_CORRESPONDENT);///////////need emails and pms updated to use objects and not array
	sendCorrNewHikerEmail($ADK_CORRESPONDENT['ADK_USER_EMAIL'], $ADK_USER, $ADK_HIKER);
	sendCorrNewHikerPM($con, $ADK_CORRESPONDENT['ADK_USER_ID'], $ADK_USER, $ADK_HIKER);
	
	$con->close();
	
	header('Location: ../applicants');
	
?>