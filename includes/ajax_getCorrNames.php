<?php
	
	////Imports
	require_once 'db_conn.php';
	require_once 'SELECT.php';
	require_once 'Correspondent.php';
	
	$con = connect_db();//Connect to db
	if(mysqli_connect_errno())
	    return 'Error';
	
	$ADK_CORRESPONDENTS = getMatchingCorrespondents($con, $_GET['term']);
	
	$con->close();
	
	echo json_encode($ADK_CORRESPONDENTS);
	http_response_code(200);
	
?>