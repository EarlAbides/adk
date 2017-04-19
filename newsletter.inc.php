<?php
	
	require_once "includes/session.php";
	require_once "includes/db/db_conn.php";
	require_once "includes/db/SELECT.php";
	require_once "includes/classes/User.php";
	require_once "includes/classes/Batch.php";

	$files = scandir("data/reports/");
	rsort($files);
	$filename = $files[0];
	$file = "data/reports/".$filename;
	$report = @file_get_contents($file);

	$con = connect_db();

	$ADK_USERS = Batch::getQuarterlyReportUsers($con);

	$_corrEmails = [];
	$_hikerEmails = [];

	foreach($ADK_USERS as $ADK_USER){
		if($ADK_USER->usergroupid === 2) array_push($_corrEmails, $ADK_USER->email);
		else array_push($_hikerEmails, $ADK_USER->email);
	}

	$con->close();

?>