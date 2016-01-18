<?php
	
	////Imports
	require_once 'session.php';
	require_once 'variables_site.php';
	require_once 'db_conn.php';
	require_once 'DELETE.php';
	require_once 'INSERT.php';
	require_once 'SELECT.php';
	require_once 'UPDATE.php';
	require_once 'Correspondent.php';
	require_once 'Hike.php';
	require_once 'Hiker.php';
	require_once 'File.php';
	require_once 'Message.php';
	require_once 'email.php';
	require_once 'pm.php';
	
	if(validateFiles($errMess)) $files = getPOSTFiles();
	else{
		http_response_code(409);
		echo $errMess;
		exit;
	}
	
	$con = connect_db();

	if(hasClimbed($con, intval($_POST['id']), explode(',', $_POST['peakids']), $_POST['hikeid'])){
		$con->close();
		http_response_code(210);
		exit;
	}

	$ADK_HIKE = updateHike($con);
	updateHikesPeaks($con, $ADK_HIKE);
	
	deleteHikeFileJcts($con, $ADK_HIKE['ADK_HIKE_ID']);
	
	$preFileIDs = explode(',', $_POST['prefileids']);
	if(count($preFileIDs) > 0 && $preFileIDs[0] != '')
		addHikeFileJcts($con, $ADK_HIKE['ADK_HIKE_ID'], $preFileIDs);
	if($files !== ''){
		$fileIDs = addFiles($con, $files);
		addHikeFileJcts($con, $ADK_HIKE['ADK_HIKE_ID'], $fileIDs);
	}
	
	$ADK_HIKES = getHikes($con, intval($_POST['id']));
	$ADK_HIKES = getHikesPeaks($con, $ADK_HIKES);

	if($_POST['id'] == $_SESSION['ADK_USER_ID']){//notify corr
		$ADK_HIKER = getHiker($con, intval($_POST['id']));
		$ADK_CORRESPONDENT = getCorrespondent($con, $ADK_HIKER['ADK_HIKER_CORR_ID']);
		$ADK_HIKE['peakNames'] = getPeakNames($con, $_POST['peakids']);

		sendCorrHikeAddUpdateEmail($ADK_HIKER, $ADK_CORRESPONDENT, $ADK_HIKE, true);
		sendCorrHikeAddUpdatePM($con, $ADK_HIKER, $ADK_CORRESPONDENT, $ADK_HIKE, true);
	}

	_46erCompletionEmail($con, $_POST['id'], $ADK_HIKES);
	
	$con->close();
	
	http_response_code(200);
	echo getTableHikes($ADK_HIKES);

?>