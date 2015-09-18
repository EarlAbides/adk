<?php
	
	//Imports
	require_once 'db_conn.php';
	require_once 'SELECT.php';
	
	login();
	
	function login(){
		
		//Check username and password exist
		if(empty($_POST['username'])){header("Location: index?e=un"); exit;} 
		if(empty($_POST['password'])){header("Location: index?e=pw"); exit;}
		
		$ADK_USER_USERNAME = $_POST['username'];
		$ADK_USER_PASSWORD = md5($_POST['password']);
		$page = $_POST['page'];
		if($page === 'index' || $page === 'login') $page = '';
		
		$con = connect_db();//Connect to db
		if(mysqli_connect_errno())
			return 'Error';
	
		$sql_query = sql_login_check($con, $ADK_USER_USERNAME, $ADK_USER_PASSWORD);
		if($sql_query->execute()){
            $sql_query->store_result();
            $result = sql_get_assoc($sql_query);

            foreach($result as $row){
				$ADK_USER['ADK_USER_ID'] = $row['ADK_USER_ID'];
				$ADK_USER['ADK_USER_USERNAME'] = $row['ADK_USER_USERNAME'];
				$ADK_USER['ADK_USERGROUP_ID'] = $row['ADK_USERGROUP_ID'];
				$ADK_USER['ADK_USER_NAME'] = $row['ADK_USER_NAME'];
				$ADK_USER['ADK_USER_EMAIL'] = $row['ADK_USER_EMAIL'];
				$ADK_USER['ADK_USERGROUP_CDE'] = $row['ADK_USERGROUP_CDE'];
				$ADK_USER['ADK_USERGROUP_DESC'] = $row['ADK_USERGROUP_DESC'];
			}
		}
		else die('There was an error running the query ['.$con->error.']');
		
		$con->close();
		
		//If no user, exit
		if(!isset($ADK_USER)){header("Location: ../".$page."?e=l"); exit;}
		
		//Start session
		session_set_cookie_params(0);
		session_start();
		$_SESSION['ADK_USER_ID'] = $ADK_USER['ADK_USER_ID'];
		$_SESSION['ADK_USER_USERNAME'] = $ADK_USER['ADK_USER_USERNAME'];
		$_SESSION['ADK_USER_NAME'] = $ADK_USER['ADK_USER_NAME'];
		$_SESSION['ADK_USER_EMAIL'] = $ADK_USER['ADK_USER_EMAIL'];
		$_SESSION['ADK_USERGROUP_CDE'] = $ADK_USER['ADK_USERGROUP_CDE'];
		
		header("Location: ../".$page);
	}
	
?>