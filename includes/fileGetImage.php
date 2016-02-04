<?php
	
	//Imports
	require_once 'db_conn.php';
	require_once 'SELECT.php';
	require_once 'classes/File.php';
	
	if(!isset($_GET['_']) || !is_numeric($_GET['_'])){http_response_code(404); exit;}

	$con = connect_db();
	
	//$ADK_FILE = getFile($con, $ADK_FILE_ID, true, $getThumb);
	$ADK_FILE = new File();
	$ADK_FILE->id = intval($_GET['_']);
	$ADK_FILE->get($con, true, isset($_GET['t']));
	
	$con->close();

	if($ADK_FILE->name != ''){
		header("Content-length: ".$ADK_FILE->size."");
		header("Content-type: ".$ADK_FILE->type."");
		header("Content-Disposition: attachment; filename=\"".$ADK_FILE->name."\"");
		header("Pragma: public");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	
		echo $ADK_FILE->content;
	}
	else header("Location: ../img/question.png");
	
?>