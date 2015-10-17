<?php
	
	//Imports
	require_once 'db_conn.php';
	require_once 'SELECT.php';
	require_once 'File.php';
	
	$ADK_FILE_ID = $_GET['_'];
	
	$con = connect_db();
	
	$ADK_FILE = getFile($con, $ADK_FILE_ID, true);
	
	$con->close();
	
	header("Content-length: ".$ADK_FILE['ADK_FILE_SIZE']."");
	header("Content-type: ".$ADK_FILE['ADK_FILE_TYPE']."");
	header("Content-Disposition: attachment; filename=\"".$ADK_FILE['ADK_FILE_NAME']."\"");
	header("Pragma: public");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	
	echo $ADK_FILE['ADK_FILE_CONTENT'];
	
?>