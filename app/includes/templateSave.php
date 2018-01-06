<?php
	
	//Imports
	require_once 'session.php';
	require_once 'db/db_conn.php';
	require_once 'db/SELECT.php';
	require_once 'db/INSERT.php';
	require_once 'classes/Template.php';
	
	$con = connect_db();

	$ADK_MSG_TMPL = new Template();
	$ADK_MSG_TMPL->populateFromSave();
	if(!$ADK_MSG_TMPL->isValid()){
	    $con->close();
	    http_response_code(400);
	    echo $ADK_MSG_TMPL->err;
	    exit;
	}
	
	if(isset($_POST['isPrivate']) && $_POST['isPrivate'] == 'false') $ADK_MSG_TMPL->userid = null;	
	$ADK_MSG_TMPL->sanitize();
	$ADK_MSG_TMPL->save($con);

	$ADK_MSG_TMPLS = new Templates();
	$ADK_MSG_TMPLS->get($con, $_SESSION['ADK_USER_ID']);

	$con->close();
	
	echo json_encode($ADK_MSG_TMPLS);
	http_response_code(200);
	
?>