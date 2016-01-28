<?php
	
	//Imports
	require_once 'includes/db_conn.php';
	require_once 'includes/SELECT.php';
	require_once 'includes/Correspondent.php';
	require_once 'includes/classes/Applicant.php';
	require_once 'includes/classes/Peak.php';
	
	if(!isset($_GET['_']) || !is_numeric($_GET['_'])) header("Location: ./");
	
	$con = connect_db();
	
	$ADK_APPLICANT = new Applicant();
	$ADK_APPLICANT->id = intval($_GET['_']);
	$ADK_APPLICANT->get($con);
	if($ADK_APPLICANT->name ==  '') header("Location: ./");
	
	$ADK_CORRESPONDENTS = getCorrespondents($con);
	
	$ADK_PEAKS = new Peaks();
	$ADK_PEAKS->get($con);
	
	$con->close();
	
	$table_correspondents = getTableSelectCorrespondents($ADK_CORRESPONDENTS);
	
?>