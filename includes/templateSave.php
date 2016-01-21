<?php
	
	////Imports
	require_once 'session.php';
	require_once 'variables_site.php';
	require_once 'db_conn.php';
	require_once 'INSERT.php';	
	require_once 'Template.php';
	
	$con = connect_db();

	$ADK_MSG_TMPL = new Template();
	$ADK_MSG_TMPL->populate();
	
	if(!$ADK_MSG_TMPL->isValid(){
		$con->close();
		header('Location: ../messages?e='.$this->err);
		exit;
	}
	
	$ADK_MSG_TMPL->save($con);
	
	$con->close();
	
	http_response_code(200);
	
?>