<?php
	
	//Imports
	require_once 'session.php';
	require_once 'db_conn.php';
	require_once 'SELECT.php';
	require_once 'UPDATE.php';
	require_once 'classes/Correspondent.php';
	require_once 'classes/User.php';
	
	$con = connect_db();

	$old_ADK_USER = new User();
	$old_ADK_USER->id = intval($_POST['id']);
	$old_ADK_USER->get($con);

	$ADK_USER = new User();
	$ADK_USER->populate();

	if(!$ADK_USER->isValid()){
		$con->close();
		header('Location: ../profile?_='.$ADK_USER->id.'&e='.$ADK_USER->err);
		exit;
	}
	if(!User::isUniqueUsername($con, $ADK_USER->username, $old_ADK_USER->username)){
		$con->close();
		header('Location: ../profile?_='.$ADK_USER->id.'&e=q');
		exit;
	}
	
	$ADK_USER->update($con);
	
	$con->close();

	$_SESSION['ADK_USER_USERNAME'] = $ADK_USER->username;
	
	header('Location: ../');
	
?>