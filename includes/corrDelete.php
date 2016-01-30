<?php
	
	//Imports
	require_once 'session.php';
	require_once 'db_conn.php';
	require_once 'SELECT.php';
	require_once 'DELETE.php';
	require_once 'classes/Correspondent.php';
	
	if(!isset($_POST['id']) || !is_numeric($_POST['id'])){
		header('Location: ../correspondents?e=i');
		exit;
	}

	$ADK_USER_ID = intval($_POST['id']);

	$con = connect_db();

	$ADK_CORRESPONDENT = new Correspondent();
	$ADK_CORRESPONDENT->id = $ADK_USER_ID;
	$ADK_CORRESPONDENT->get($con);

	if($ADK_CORRESPONDENT->numhikers > 0){
		header('Location: ../correspondent?_='.$ADK_USER_ID.'&e=h');
		exit;
	}

	$ADK_CORRESPONDENT->delete($con);
	
	$con->close();
	
	header('Location: ../correspondents');
	
?>