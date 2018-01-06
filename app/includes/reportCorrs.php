<?php
	
	//Imports
	require_once 'session.php';
	require_once 'db/db_conn.php';
	require_once 'db/SELECT.php';
	require_once 'classes/Correspondent.php';
	require_once 'classes/Report.php';

	if($_SESSION['ADK_USERGROUP_CDE'] !== 'ADM'){http_response_code(404); exit;}

	$con = connect_db();
	
	$ADK_CORRESPONDENTS = new Correspondents();
	$ADK_CORRESPONDENTS->get($con);

	$report = new Report();
	$report->getCorrsReport($ADK_CORRESPONDENTS);
	
	$con->close();

	$output = fopen('php://output', 'w');
	header("Content-type:application/octet-stream");
	header("Content-Disposition:attachment;filename=\"correspondents.csv\"");
	echo $report->csv;

?>