<?php
	
	//Imports
	require_once 'variables_site.php';
	require_once 'db/db_conn.php';
    require_once 'db/SELECT.php';
	require_once 'db/INSERT.php';
	require_once 'Message.php';
	require_once 'randomPW.php';
    require_once 'email.php';
    require_once 'pm.php';
	require_once 'classes/Correspondent.php';
	require_once 'classes/User.php';

	$randomPW = randomPW(8);

	$con = connect_db();
    
	$ADK_USER = new User();
	$ADK_USER->populate($randomPW);
	$ADK_USER->usergroupid = 2;
	$ADK_USER->pw = $randomPW;
	
	$ADK_CORRESPONDENT = new Correspondent();
	$ADK_CORRESPONDENT->info = $_POST['personalinfo'];

	if(!$ADK_USER->isValid()){
		$con->close();
		header('Location: ../editCorrespondent?_='.$ADK_USER->id.'&e='.$ADK_USER->err);
		exit;
	}
	if(!User::isUniqueUsername($con, $ADK_USER->username, '')){
		$con->close();
		header('Location: ../editCorrespondent?_='.$ADK_USER->id.'&e=q');
		exit;
	}
	
	$ADK_USER->save($con);
	$ADK_CORRESPONDENT->id = $ADK_USER->id;
	$ADK_CORRESPONDENT->save($con);

    sendNewCorrEmail($ADK_USER, $randomPW);
	sendNewCorrPM($con, $ADK_USER, $randomPW);

    $con->close();

	header('Location: ../correspondent?_='.$ADK_USER->id);
	
?>