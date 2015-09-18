<?php
	
	//Imports
    require_once 'variables_site.php';
	require_once 'db_conn.php';
    require_once 'SELECT.php';
	require_once 'UPDATE.php';
    require_once 'Correspondent.php';
	require_once 'Hiker.php';
    require_once 'email.php';
	
	$ADK_USER_ID = intval($_POST['id']);
	$ADK_CORR_ID = intval($_POST['corrid']);
	
	$con = connect_db();//Connect to db
		if(mysqli_connect_errno())
			return 'Error';
	
	updateHikersCorr($con, $ADK_USER_ID, $ADK_CORR_ID);

    $ADK_HIKER = getHiker($con, $ADK_USER_ID);
    $oldCorr = getCorrespondent($con, $ADK_HIKER['ADK_HIKER_CORR_ID']);
    $newCorr = getCorrespondent($con, $ADK_CORR_ID);
	
	$con->close();

    //Email
    sendHikerCorrReassignEmail($ADK_HIKER, $newCorr);
	sendOldCorrReassignEmail($oldCorr, $ADK_HIKER);
    sendNewCorrReassignEmail($newCorr, $ADK_HIKER);
	
	header('Location: ../hiker?_='.$ADK_USER_ID);
	
?>