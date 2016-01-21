<?php
	
	////Imports
	require_once 'session.php';
	require_once 'db_conn.php';
	require_once 'SELECT.php';
	require_once 'Template.php';
	
	if(!isset($_GET['_']) || !is_numeric($_GET['_'])){
		http_response_code(400);
		exit;
	}

	$con = connect_db();
	
	$ADK_MSG_TMPL = new Template($con);
	$ADK_MSG_TMPL->id = $_GET['_'];
	$ADK_MSG_TMPL->get();
	
	$con->close();

	if($ADK_MSG_TMPL->name == null){
		http_response_code(404);
		exit;
	}
	
	echo json_encode($ADK_MSG_TMPL);
	http_response_code(200);
	exit;
	
?>