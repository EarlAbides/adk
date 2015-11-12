<?php
	
	////Imports
	require_once 'db_conn.php';
	require_once 'SELECT.php';
	require_once 'INSERT.php';
	require_once 'Hike.php';
	require_once 'File.php';
	require_once 'email.php';
	
    if(validateFiles($errMess)) $files = getPOSTFiles();
    else{
		http_response_code(409);
		echo $errMess;
		exit;
	}
	
    $con = connect_db();

	if(hasClimbed($con, intval($_POST['id']), explode(',', $_POST['peakids']), null)){
		$con->close();
		http_response_code(210);
		exit;
	}
	
    $ADK_HIKE = addHike($con);
    addHikesPeaks($con, $ADK_HIKE);
	
    $preFileIDs = explode(',', $_POST['prefileids']);
    if(count($preFileIDs) > 0 && $preFileIDs[0] != '')
        addHikeFileJcts($con, $ADK_HIKE['ADK_HIKE_ID'], $preFileIDs);
    if($files !== ''){
        $fileIDs = addFiles($con, $files);
        addHikeFileJcts($con, $ADK_HIKE['ADK_HIKE_ID'], $fileIDs);
    }
	
    $ADK_HIKES = getHikes($con, $ADK_HIKE['ADK_USER_ID']);
    $ADK_HIKES = getHikesPeaks($con, $ADK_HIKES);
    _46erCompletionEmail($con, $_POST['id'], $ADK_HIKES);

    $con->close();
	
    echo getTableHikes($ADK_HIKES);
	http_response_code(200);
	
?>