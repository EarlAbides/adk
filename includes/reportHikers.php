<?php
	
	//Imports
	require_once 'session.php';
	require_once 'db/db_conn.php';
	require_once 'db/SELECT.php';
	require_once 'classes/Hiker.php';
	require_once 'classes/Report.php';

	if($_SESSION['ADK_USERGROUP_CDE'] !== 'ADM'){http_response_code(404); exit;}

	$con = connect_db();
	
	$ADK_HIKERS = new Hikers();
	$ADK_HIKERS->get($con, '%');

	$report = new Report();
	$report->getHikersReport($ADK_HIKERS);
	
	$con->close();

	$output = fopen('php://output', 'w');
	header("Content-type:application/octet-stream");
	header("Content-Disposition:attachment;filename=\"hikers.csv\"");
	echo $report->csv;

?>