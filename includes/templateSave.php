<?php
	
	////Imports
	require_once 'session.php';
	require_once 'variables_site.php';
	require_once 'db_conn.php';
	require_once 'INSERT.php';	
	require_once 'Template.php';
	
	$con = connect_db();

	$template = new Template($con);
	$template->userid = $_SESSION['ADK_USER_ID'];
	$template->name = $_POST['ADK_MSG_TMPL_NAME'];
	$template->content = $_POST['ADK_MSG_TMPL_CONTENT'];
	$template->save();	
	
	$con->close();

	http_response_code(200);
	exit;
		
?>