<?php
	
	//Imports
	require_once 'session.php';
	require_once 'variables_site.php';
	require_once 'db_conn.php';
	require_once 'SELECT.php';
	require_once 'DELETE.php';
	require_once 'classes/Template.php';

	if(!isset($_POST['id']) || !is_numeric($_POST['id'])){
		http_response_code(400);
		exit;
	}
	
	$con = connect_db();

	$ADK_MSG_TMPL = new Template();
	$ADK_MSG_TMPL->id = intval($_POST['id']);
	$ADK_MSG_TMPL->delete($con);

	$ADK_MSG_TMPLS = new Templates();
	$ADK_MSG_TMPLS->get($con, $_SESSION['ADK_USER_ID']);

	$con->close();
	
	echo json_encode($ADK_MSG_TMPLS);
	http_response_code(200);
	
?>