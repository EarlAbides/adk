<?php
	
	//Imports
	require_once 'db/db_conn.php';
	require_once 'db/SELECT.php';
	require_once 'File.php';
	
	$ADK_FILE_ID = $_POST['id'];
	
	$con = connect_db();
	
	$ADK_FILE = getFile($con, $ADK_FILE_ID, true, false);
	
	$con->close();
	
	if($ADK_FILE !== ''){
		header("Content-length: ".$ADK_FILE['ADK_FILE_SIZE']."");
		header("Content-type: ".$ADK_FILE['ADK_FILE_TYPE']."");
		header("Content-Disposition: attachment; filename=\"".$ADK_FILE['ADK_FILE_NAME']."\"");
		header("Pragma: public");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	
		echo $ADK_FILE['ADK_FILE_CONTENT'];
	}
	
?>