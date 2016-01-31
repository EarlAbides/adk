<?php
	
	//Imports
	require_once 'session.php';
	require_once 'db_conn.php';
	require_once 'UPDATE.php';
	require_once 'classes/Message.php';
	
	if(!isset($_SESSION['ADK_USER_ID']) || !is_numeric($_SESSION['ADK_USER_ID'])){http_response_code(404); echo 0; exit;}
	if(!isset($_POST['ADK_MESSAGE_ID']) || !is_numeric($_POST['ADK_MESSAGE_ID'])){http_response_code(400); echo 0; exit;}
	
	$con = connect_db();

	$ADK_MESSSAGE = new Message();
	$ADK_MESSSAGE->id = intval($_POST['ADK_MESSAGE_ID']);
	$ADK_MESSSAGE->updateRead($con);
	
	$con->close();
	
	http_response_code(200);
	
?>