<?php
	
	//Imports
	require_once 'session.php';
	require_once 'variables_site.php';
	require_once 'db_conn.php';
	require_once 'SELECT.php';
	require_once 'INSERT.php';
	require_once 'UPDATE.php';
	require_once 'Message.php';
	require_once 'File.php';
	require_once 'User.php';
	require_once 'email.php';
		
	if(validateFiles($errMess)) $files = getPOSTFiles();
	else header('Location: ../messages?_'.$_POST['touserid'].'=&e='.$errMess);
	
	$con = connect_db();//Connect to db
		if(mysqli_connect_errno())
			return 'Error';
	
	$ADK_MESSAGE = addMessage($con);
	$ADK_MESSAGE = getMessage($con, $ADK_MESSAGE['ADK_MESSAGE_ID']);
	
	if(!isset($_POST['draft'])){
		$ADK_MESSAGE_TO_EMAIL = getUserEmail($con, $_POST['touserid']);
		sendPMNotifyEmail($ADK_MESSAGE, $ADK_MESSAGE_TO_EMAIL);
	}
	
    //$replyFileIDs = explode(',', $_POST['replyfileids']);
    //if(count($replyFileIDs) > 0 && $replyFileIDs[0] != '')
    //    addMessageFileJcts($con, $ADK_MESSAGE['ADK_MESSAGE_ID'], $replyFileIDs);
	
	if($files !== ''){
		$fileIDs = addFiles($con, $files);
		addMessageFileJcts($con, $ADK_MESSAGE['ADK_MESSAGE_ID'], $fileIDs);
	}
	
	$con->close();
	
	//Redirect
	switch($_SESSION['ADK_USERGROUP_CDE']){
		case 'ADM': header('Location: ../messages'); break;
		case 'COR': header('Location: ../hiker?_='.$ADK_MESSAGE['ADK_MESSAGE_TO_USER_ID']); break;
		case 'HIK': header('Location: ../hikerportal'); break;
	}
	
	
?>