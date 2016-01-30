<?php
	
	//Imports
    require_once 'variables_site.php';
	require_once 'db_conn.php';
    require_once 'SELECT.php';
	require_once 'UPDATE.php';
    require_once 'email.php';
    require_once 'classes/Correspondent.php';
	require_once 'classes/Hiker.php';
	
	if(!isset($_POST['id']) || !is_numeric($_POST['id'])){header('Location: ../applicants?_e=i'); exit;}
	if(!isset($_POST['corrid']) || !is_numeric($_POST['corrid'])){header('Location: ../applicant?_='.$_POST['id'].'&e=c'); exit;}
	
	$ADK_USER_ID = intval($_POST['id']);
	$ADK_CORRESPONDENT_ID = intval($_POST['corrid']);
	
	$con = connect_db();

	$ADK_HIKER = new Hiker();
	$ADK_HIKER->id = $ADK_USER_ID;
	$ADK_HIKER->get($con);

	$old_ADK_CORRESPONDENT = new Correspondent();
	$old_ADK_CORRESPONDENT->id = $ADK_HIKER->corrid;
	$old_ADK_CORRESPONDENT->get($con);

	$ADK_CORRESPONDENT = new Correspondent();
	$ADK_CORRESPONDENT->id = $ADK_CORRESPONDENT_ID;
	$ADK_CORRESPONDENT->get($con);

	$ADK_HIKER->corrid = $ADK_CORRESPONDENT_ID;
	$ADK_HIKER->updateCorr($con);
	
	$con->close();

    sendHikerCorrReassignEmail($ADK_HIKER, $ADK_CORRESPONDENT);
	sendOldCorrReassignEmail($old_ADK_CORRESPONDENT, $ADK_HIKER);
    sendNewCorrReassignEmail($ADK_CORRESPONDENT, $ADK_HIKER);
	
	header('Location: ../hiker?_='.$ADK_USER_ID);
	
?>