<?php
	
	////Imports
	require_once 'db/db_conn.php';
	require_once 'db/SELECT.php';
	require_once 'classes/Correspondent.php';
	
	$con = connect_db();

	$ADK_CORRESPONDENTS = new Correspondents();
	$ADK_CORRESPONDENT_NAMES = $ADK_CORRESPONDENTS->getMatchingNames($con, $_GET['term']);
	
	$con->close();
	
	echo json_encode($ADK_CORRESPONDENT_NAMES);
	http_response_code(200);
	
?>