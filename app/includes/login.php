<?php
	
	//Imports
	require_once 'db/db_conn.php';
	require_once 'db/SELECT.php';
	require_once 'classes/User.php';
	
	if(empty($_POST['username'])){header("Location: index?e=un"); exit;} 
	if(empty($_POST['password'])){header("Location: index?e=pw"); exit;}
	
	$ADK_USER_USERNAME = $_POST['username'];
	$ADK_USER_PASSWORD = md5($_POST['password']);
	$page = $_POST['page'];
	if($page === 'index' || $page === 'login') $page = '';
	
	$con = connect_db();

	$sql_query = sql_login_check($con, $ADK_USER_USERNAME, $ADK_USER_PASSWORD);
	if($sql_query->execute()){
		$sql_query->store_result();
		$result = sql_get_assoc($sql_query);

		foreach($result as $row){
			$ADK_USER = new User();
			$ADK_USER->id = $row['ADK_USER_ID'];
			$ADK_USER->username = $row['ADK_USER_USERNAME'];
			$ADK_USER->usernameusergroupid = $row['ADK_USERGROUP_ID'];
			$ADK_USER->name = $row['ADK_USER_NAME'];
			$ADK_USER->email = $row['ADK_USER_EMAIL'];
			$ADK_USER->usergroupcde = $row['ADK_USERGROUP_CDE'];
		}
	}
	else die('There was an error running the query ['.$con->error.']');
	
	$con->close();
	
	//If no user, exit
	if(!isset($ADK_USER)){header("Location: ../".$page."?e=l"); exit;}
	
	//Start session
	session_set_cookie_params(0);
	session_start();
	$_SESSION['ADK_USER_ID'] =$ADK_USER->id;
	$_SESSION['ADK_USER_USERNAME'] = $ADK_USER->username;
	$_SESSION['ADK_USER_NAME'] = $ADK_USER->name;
	$_SESSION['ADK_USER_EMAIL'] = $ADK_USER->email;
	$_SESSION['ADK_USERGROUP_CDE'] = $ADK_USER->usergroupcde;
	
	header("Location: ../".$page);
	
?>