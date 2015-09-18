<?php
	
	////Imports
	require_once 'db_conn.php';
	require_once 'UPDATE.php';
	require_once 'Changelog.php';
	
	$con = connect_db();//Connect to db
	if(mysqli_connect_errno())
	    return 'Error';
	
	updateChangeDone($con, intval($_POST['ADK_CHANGE_ID']), intval($_POST['ADK_CHANGE_DONE']));
	
	$con->close();
	
	http_response_code(200);
	
?>