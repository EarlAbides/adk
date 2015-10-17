<?php
	
	//Imports
	require_once 'variables_site.php';
	require_once 'db_conn.php';
    require_once 'SELECT.php';
	require_once 'INSERT.php';
	require_once 'Correspondent.php';
	require_once 'User.php';
	require_once 'Message.php';
	require_once 'randomPW.php';
    require_once 'email.php';
    require_once 'pm.php';
	
    $randomPW = randomPW(8);

	$con = connect_db();
    
    $ADK_USERGROUP_ID = 2;

    $ADK_USER = addUser($con, $ADK_USERGROUP_ID, $randomPW);
	$ADK_CORRESPONDENT = addCorrespondent($con, $ADK_USER['ADK_USER_ID']);
    	
    //Email
    sendNewCorrEmail($ADK_USER, $randomPW);

    //PM
    sendNewCorrPM($con, $ADK_USER, $randomPW);

    $con->close();

	header('Location: ../correspondent?_='.$ADK_CORRESPONDENT['ADK_USER_ID']);
	
?>