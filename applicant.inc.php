<?php
	
	//Imports
	require_once 'includes/db_conn.php';
	require_once 'includes/SELECT.php';
	require_once 'includes/Applicant.php';
	require_once 'includes/Correspondent.php';
	require_once 'includes/Peak.php';
	
	if(isset($_GET['_'])){
		$ADK_APPLICANT_ID = $_GET['_'];
		if($ADK_APPLICANT_ID == '') header("Location: ./");
	}
	else header("Location: ./");
	
	
	$con = connect_db();
	
	$ADK_APPLICANT = getApplicant($con, $ADK_APPLICANT_ID);
	if($ADK_APPLICANT == '') header("Location: ./");
	
	$ADK_CORRESPONDENTS = getCorrespondents($con);
	
	$ADK_PEAKS = getPeaks($con);
	
	$con->close();
	
	$table_correspondents = getTableSelectCorrespondents($ADK_CORRESPONDENTS);
	
?>