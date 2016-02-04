<?php
	
	//Imports
	require_once 'session.php';
	require_once 'db/db_conn.php';
	require_once 'db/UPDATE.php';
	require_once 'classes/Message.php';

	if(!isset($_POST['id']) || !is_numeric($_POST['id'])){http_response_code(400); exit;}
	if(!isset($_POST['tofrom']) || count($_POST['tofrom']) !== 1){http_response_code(400); exit;}

	$inboxSent = $_POST['tofrom'];
	
	$con = connect_db();

	$ADK_MESSAGE = new Message();
	$ADK_MESSAGE->id = intval($_POST['id']);
	$ADK_MESSAGE->delete($con, $inboxSent);

	if($_SESSION['ADK_USERGROUP_CDE'] === 'HIK'){
		require_once 'classes/Hiker.php';
		Hiker::updateLastActive($con, intval($_SESSION['ADK_USER_ID']));
	}
	
	$con->close();
	
	http_response_code(200);
	
?>