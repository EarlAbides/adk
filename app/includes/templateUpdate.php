<?php
	
	//Imports
	require_once 'session.php';
	require_once 'db/db_conn.php';
	require_once 'db/SELECT.php';
	require_once 'db/UPDATE.php';
	require_once 'classes/Template.php';

	$con = connect_db();

	$ADK_MSG_TMPL = new Template();
	$ADK_MSG_TMPL->populateFromUpdate();
	if(!$ADK_MSG_TMPL->isValid()){
	    $con->close();
	    http_response_code(400);
	    echo $ADK_MSG_TMPL->err;
	    exit;
	}
	
	$ADK_MSG_TMPL->sanitize();
	$ADK_MSG_TMPL->update($con);

	$ADK_MSG_TMPLS = new Templates();
	$ADK_MSG_TMPLS->get($con, $_SESSION['ADK_USER_ID']);

	$con->close();
	
	echo json_encode($ADK_MSG_TMPLS);
	http_response_code(200);
	
?>