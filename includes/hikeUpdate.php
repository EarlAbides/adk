<?php

	require_once "session.php";
	require_once "variables_site.php";
	require_once "db/db_conn.php";
	require_once "db/SELECT.php";
	require_once "db/INSERT.php";
	require_once "db/UPDATE.php";
	require_once "db/DELETE.php";
	require_once "email.php";
	require_once "pm.php";
	require_once "classes/File.php";
	require_once "classes/Hike.php";
	require_once "classes/Hiker.php";
	require_once "classes/Message.php";
	require_once "classes/Peak.php";

	if(!isset($_SESSION["ADK_USER_ID"])){http_response_code(404); exit;}

	$ADK_FILES = new Files();
	if(!$ADK_FILES->isValid()){http_response_code(409); exit;}
	$ADK_FILES->populate();
	
	$con = connect_db();

	$ADK_HIKE = new Hike();
	$ADK_HIKE->populate();

	if(!$ADK_HIKE->isValid()){
		$con->close();
		http_response_code(409);
		echo $ADK_HIKE->err;
		exit;
	}
	$ADK_HIKE->sanitize();
	$ADK_HIKE->deletePeaks($con);
	$ADK_HIKE->deleteFiles($con);
	$ADK_HIKE->update($con);
	foreach($ADK_HIKE->peaks as $ADK_PEAK) $ADK_HIKE->addPeak($con, $ADK_PEAK);

	$preFileIDs = explode(",", $_POST["prefileids"]);
	if(count($preFileIDs) > 0 && $preFileIDs[0] != "") $ADK_HIKE->addFiles($con, $preFileIDs);
	if(count($ADK_FILES->files) > 0){
		$ADK_FILES->save($con);
		$ADK_HIKE->addFiles($con, $ADK_FILES->fileIDs);
	}

	$ADK_HIKES = new Hikes();
	$ADK_HIKES->userid = $ADK_HIKE->userid;
	$ADK_HIKES->get($con);

	$ADK_HIKER = new Hiker();
	$ADK_HIKER->id = $ADK_HIKE->userid;
	$ADK_HIKER->get($con);

	if($_SESSION["ADK_USERGROUP_CDE"] === "HIK" && hasNotNotifiedInLastDay($ADK_HIKE->id, $ADK_HIKES)){ // notify corr
		require_once "classes/Correspondent.php";
		$ADK_CORRESPONDENT = new Correspondent();
		$ADK_CORRESPONDENT->id = $ADK_HIKER->corrid;
		$ADK_CORRESPONDENT->get($con);
		foreach($ADK_HIKES->hikes as $hike){
			if($hike->id === $ADK_HIKE->id) $ADK_HIKE->label = $hike->label;
		}
		sendCorrHikeAddUpdateEmail($ADK_HIKER, $ADK_CORRESPONDENT, $ADK_HIKE, false);
		sendCorrHikeAddUpdatePM($con, $ADK_HIKER, $ADK_CORRESPONDENT, $ADK_HIKE, false);
		Hiker::updateLastActive($con, intval($_SESSION["ADK_USER_ID"]));
	}

	if($ADK_HIKER->numpeaks == 46 && !$ADK_HIKER->completedate){ // completion
		$lastHike = $ADK_HIKES->getLastHike();
		$ADK_HIKER->completedate = $lastHike->getLatestDate();
		$ADK_HIKER->saveCompleteDate($con);
		require_once "classes/Correspondent.php";
		$ADK_CORRESPONDENT = new Correspondent();
		$ADK_CORRESPONDENT->id = $ADK_HIKER->corrid;
		$ADK_CORRESPONDENT->get($con);
		send46erCompletionEmail($ADK_HIKER, $ADK_CORRESPONDENT);
		sendCorr46erCompletionEmail($ADK_HIKER, $ADK_CORRESPONDENT);
	}

    $con->close();
	
	http_response_code(200);
	$ADK_HIKES->renderTable($ADK_HIKER->numpeaks, $ADK_HIKER->numclimbed, $ADK_HIKER->percent);



	function hasNotNotifiedInLastDay($ADK_HIKE_ID, $ADK_HIKES){
		$dawnOfTime = strtotime("1969-12-31");
		$mostRecentTS = $dawnOfTime;
		foreach($ADK_HIKES->hikes as $ADK_HIKE){
			if($ADK_HIKE->ts !== "" && $ADK_HIKE_ID !== $ADK_HIKE->id){
				if(strtotime($ADK_HIKE->ts) > $mostRecentTS) $mostRecentTS = strtotime($ADK_HIKE->ts);
			}
		}

		$dt = new DateTime();
		$dt->sub(new DateInterval("PT24H"));
		
		if($mostRecentTS !== $dawnOfTime && $mostRecentTS < $dt->getTimestamp()) return true;
		return false;
	}

?>