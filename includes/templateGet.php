<?php
	
	////Imports
	require_once 'session.php';
	require_once 'db_conn.php';
	require_once 'SELECT.php';
	require_once 'classes/Template.php';
	
	if(!isset($_GET['_']) || !is_numeric($_GET['_'])){
		http_response_code(400);
		exit;
	}

	$con = connect_db();
	
	$ADK_MSG_TMPL = new Template();
	$ADK_MSG_TMPL->id = intval($_GET['_']);
	$ADK_MSG_TMPL->get($con, $_SESSION['ADK_USER_ID']);
	
	$con->close();

	if($ADK_MSG_TMPL->name == null){
		http_response_code(404);
		exit;
	}
	if($ADK_MSG_TMPL->userid != null && $ADK_MSG_TMPL->userid != $_SESSION['ADK_USER_ID']){
		http_response_code(403);
		exit;
	}
	
	echo json_encode($ADK_MSG_TMPL);
	http_response_code(200);
	
?>