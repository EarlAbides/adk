<?php
	
	//Imports
	require_once 'db/db_conn.php';
	require_once 'db/SELECT.php';
	require_once 'classes/File.php';

	if(!isset($_POST['id']) || !is_numeric($_POST['id'])){http_response_code(404); exit;}
		
	$con = connect_db();

	$ADK_FILE = new File();
	$ADK_FILE->id = intval($_POST['id']);
	$ADK_FILE->get($con, true, false);
	
	$con->close();
	
	if($ADK_FILE->name != ''){
		header("Content-length: ".$ADK_FILE->size);
		header("Content-type: ".$ADK_FILE->type);
		header("Content-Disposition: attachment; filename=\"".$ADK_FILE->name."\"");
		header("Pragma: public");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	
		echo $ADK_FILE->content;
	}
	
?>