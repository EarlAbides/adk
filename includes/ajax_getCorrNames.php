<?php
	
	////Imports
	require_once 'db_conn.php';
	require_once 'SELECT.php';
	require_once 'Correspondent.php';
	
	$con = connect_db();
	
	$ADK_CORRESPONDENTS = getMatchingCorrespondents($con, $_GET['term']);
	
	$con->close();
	
	echo json_encode($ADK_CORRESPONDENTS);
	http_response_code(200);
	
?>