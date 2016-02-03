<?php
	
	//Imports
	require_once 'session.php';
	require_once 'db/db_conn.php';
	require_once 'db/SELECT.php';
	require_once 'db/UPDATE.php';
	require_once 'classes/Correspondent.php';
	require_once 'classes/User.php';
	
	$con = connect_db();

	$old_ADK_USER = new User();
	$old_ADK_USER->id = intval($_POST['id']);
	$old_ADK_USER->get($con);
	
	$ADK_USER = new User();
	$ADK_USER->populate();

	$ADK_CORRESPONDENT = new Correspondent();
	$ADK_CORRESPONDENT->id = intval($_POST['id']);
	$ADK_CORRESPONDENT->info = $_POST['personalinfo'];

	if(!$ADK_USER->isValid()){
		$con->close();
		header('Location: ../editCorrespondent?_='.$ADK_USER->id.'&e='.$ADK_USER->err);
		exit;
	}
	if(!User::isUniqueUsername($con, $ADK_USER->username, $old_ADK_USER->username)){
		$con->close();
		header('Location: ../editCorrespondent?_='.$ADK_USER->id.'&e=q');
		exit;
	}

	$ADK_USER->update($con);
	
	$ADK_CORRESPONDENT->sanitize();
	$ADK_CORRESPONDENT->update($con);
		
	$con->close();
	
	switch($_SESSION['ADK_USERGROUP_CDE']){
		case 'ADM': header('Location: ../correspondent?_='.$ADK_USER->id); break;
		case 'COR': header('Location: ../hikers'); break;
		default: header('Location: ../');
	}
	
?>