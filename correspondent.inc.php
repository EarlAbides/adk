<?php
	
	//Imports
	require_once 'includes/db_conn.php';
	require_once 'includes/SELECT.php';
	require_once 'includes/Correspondent.php';
	require_once 'includes/Hiker.php';
	
	if(isset($_GET['_'])){
		$ADK_CORR_ID = $_GET['_'];
		if($ADK_CORR_ID == '') header("Location: ./");
	}
	else header("Location: ./");
	
	$con = connect_db();
	
	$ADK_CORRESPONDENT = getCorrespondent($con, $ADK_CORR_ID);
	if($ADK_CORRESPONDENT == '') header("Location: ./");
	
	$ADK_HIKERS = getHikers($con, $ADK_CORRESPONDENT['ADK_USER_ID']);
	
	$table_hikers = getTableHikers($ADK_HIKERS);

	//if page is editCorr, 
		$_ADK_CORRESPONDENTS = getCorrespondents($con);
		$ADK_CORRESPONDENTS = array();
		for($i = 0; $i < count($_ADK_CORRESPONDENTS); $i++)
			if($_ADK_CORRESPONDENTS[$i]['ADK_USER_ID'] !== $ADK_CORRESPONDENT['ADK_USER_ID'])
				array_push($ADK_CORRESPONDENTS, $_ADK_CORRESPONDENTS[$i]);
		$table_correspondents = getTableSelectCorrespondents($ADK_CORRESPONDENTS);
	//}
	$con->close();
	
?>