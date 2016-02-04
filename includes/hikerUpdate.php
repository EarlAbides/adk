<?php
	
	//Imports
	require_once 'session.php';
	require_once 'db/db_conn.php';
	require_once 'db/SELECT.php';
	require_once 'db/UPDATE.php';
	require_once 'classes/Hiker.php';
	require_once 'classes/User.php';
	
	$con = connect_db();

	$old_ADK_USER = new User();
	$old_ADK_USER->id = intval($_POST['id']);
	$old_ADK_USER->get($con);
	
	$ADK_USER = new User();
	$ADK_USER->populate();

	$ADK_HIKER = new Hiker();
	$ADK_HIKER->populateFromUpdateHiker();
	
	if(!$ADK_USER->isValid()){
		$con->close();
		header('Location: ../editHiker?_='.$ADK_USER->id.'&e='.$ADK_USER->err);
		exit;
	}
	if(!$ADK_HIKER->isValid()){
		$con->close();
		header('Location: ../editHiker?_='.$ADK_USER->id.'&e='.$ADK_HIKER->err);
		exit;
	}
	if(!User::isUniqueUsername($con, $ADK_USER->username, $old_ADK_USER->username)){
		$con->close();
		header('Location: ../editHiker?_='.$ADK_USER->id.'&e=q');
		exit;
	}

	$ADK_USER->update($con);
	
	$ADK_HIKER->sanitize();
	$ADK_HIKER->update($con);
		
	$con->close();
	
	switch($_SESSION['ADK_USERGROUP_CDE']){
		case 'ADM': case 'COR': header('Location: ../hiker?_='.$ADK_USER->id); break;
		default: header('Location: ../hikerportal');
	}
	
?>