<?php
	
	//Imports
	require_once 'session.php';
	require_once 'db_conn.php';
	require_once 'DELETE.php';
	require_once 'Hiker.php';
	
	$con = connect_db();//Connect to db
		if(mysqli_connect_errno())
			return 'Error';

	$ADK_USER_ID = intval($_POST['id']);
	deleteHiker($con, $ADK_USER_ID);
	
	$con->close();
	
	header('Location: ../hikers');
	
?>