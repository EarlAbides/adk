<?php
	
	//Imports
	require_once 'db_conn.php';
	require_once 'INSERT.php';
	require_once 'Changelog.php';
	
	$con = connect_db();
	
	addChange($con);
	
	$con->close();
	
	header('Location: ../changelog?e=a');
	
?>