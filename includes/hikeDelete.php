<?php
	
	////Imports
	require_once 'session.php';
	require_once 'db/db_conn.php';
	require_once 'db/SELECT.php';
	require_once 'db/UPDATE.php';
	require_once 'db/DELETE.php';
	require_once 'classes/Hike.php';
	require_once 'classes/Hiker.php';
	require_once 'classes/File.php';
	require_once 'classes/Peak.php';

	if(!isset($_POST['userid']) || !is_numeric($_POST['userid'])){http_response_code(400); exit;}
	if(!isset($_POST['hikeid']) || !is_numeric($_POST['hikeid'])){http_response_code(400); exit;}

	$ADK_USER_ID = intval($_POST['userid']);
	$ADK_HIKE_ID = intval($_POST['hikeid']);
	 
	$con = connect_db();

	$ADK_HIKE = new Hike();
	$ADK_HIKE->id = $ADK_HIKE_ID;
	$ADK_HIKE->userid = $ADK_USER_ID;
	$ADK_HIKE->delete($con);

	$ADK_HIKES = new Hikes();
	$ADK_HIKES->userid = $ADK_USER_ID;
	$ADK_HIKES->get($con);

	$ADK_HIKER = new Hiker();
	$ADK_HIKER->id = $ADK_USER_ID;
	$ADK_HIKER->get($con);

	if($_SESSION['ADK_USERGROUP_CDE'] === 'HIK'){
		Hiker::updateLastActive($con, intval($_SESSION['ADK_USER_ID']));
	}
	
	$con->close();
	
	http_response_code(200);
	$ADK_HIKES->renderTable($ADK_HIKER->numpeaks, $ADK_HIKER->numclimbed, $ADK_HIKER->percent);
	
?>