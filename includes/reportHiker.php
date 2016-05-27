<?php
	
	//Imports
	require_once 'session.php';
	require_once 'db/db_conn.php';
	require_once 'db/SELECT.php';
	require_once 'classes/HikersPeaks.php';
	require_once 'classes/Hiker.php';
	require_once 'classes/Report.php';

	if(!isset($_GET['_']) || !is_numeric($_GET['_'])){http_response_code(400); exit;}
	$ADK_USER_ID = intval($_GET['_']);

	$con = connect_db();
	
	$ADK_HIKER = new Hiker();
	$ADK_HIKER->id = $ADK_USER_ID;
	$ADK_HIKER->get($con);
	if($ADK_HIKER->name == ''){http_response_code(404); exit;}

	$ADK_HIKERS_PEAKS = new HikersPeaks();
	$ADK_HIKERS_PEAKS->userid = $ADK_USER_ID;
	$ADK_HIKERS_PEAKS->get($con);
	
	$report = new Report();
	$report->getHikerReport($ADK_HIKER, $ADK_HIKERS_PEAKS);
	
	$con->close();
	
	$cleanName = trim(preg_replace('/[^A-Za-z0-9\- ]/', '', $ADK_HIKER->name));

	$output = fopen('php://output', 'w');
	header("Content-type:application/octet-stream");
	header("Content-Disposition:attachment;filename=\"$cleanName.csv\"");
	echo $report->csv;

?>