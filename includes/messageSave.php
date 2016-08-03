<?php
	
	//Imports
	require_once 'session.php';
	require_once 'variables_site.php';
	require_once 'db/db_conn.php';
	require_once 'db/SELECT.php';
	require_once 'db/INSERT.php';
	require_once 'db/UPDATE.php';
	require_once 'email.php';
	require_once 'classes/File.php';
	require_once 'classes/Message.php';
	require_once 'classes/User.php';
	
	if(!isset($_SESSION['ADK_USER_ID'])) exit;
	
	$ADK_FILES = new Files();
	if(!$ADK_FILES->isValid()){header('Location: ../messages?_'.$_POST['touserid'].'=&e='.$ADK_FILES->err); exit;}
	$ADK_FILES->populate();
	
	$con = connect_db();

	$ADK_MESSAGE = new Message();
	$ADK_MESSAGE->populate();

	if(!$ADK_MESSAGE->isValid()){
		$con->close();
		header('Location: ../messages?e='.$ADK_MESSAGE->err);
		exit;
	}
	$ADK_MESSAGE->sanitize();
	$ADK_MESSAGE->save($con);
	$ADK_MESSAGE->get($con);
	
	if(!isset($_POST['draft'])){
		$ADK_USER = new User();
		$ADK_USER->id = $ADK_MESSAGE->toid;
		$ADK_USER->get($con);
		sendPMNotifyEmail($ADK_MESSAGE, $ADK_USER);
	}
	
    //$replyFileIDs = explode(',', $_POST['replyfileids']);
    //if(count($replyFileIDs) > 0 && $replyFileIDs[0] != '')
    //    addMessageFileJcts($con, $ADK_MESSAGE['ADK_MESSAGE_ID'], $replyFileIDs);
	
	if(count($ADK_FILES->files) > 0){
		$ADK_FILES->save($con);
		$ADK_MESSAGE->addFiles($con, $ADK_FILES->fileIDs);
	}

	if($_SESSION['ADK_USERGROUP_CDE'] === 'HIK'){
		require_once 'classes/Hiker.php';
		Hiker::updateLastActive($con, intval($_SESSION['ADK_USER_ID']));
	}
	
	$con->close();
	
	header('Location: ../messages?m=s');
	
?>