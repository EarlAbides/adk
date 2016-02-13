<?php
	
	//Imports
	require_once 'variables_site.php';
	require_once 'db/db_conn.php';
	require_once 'db/SELECT.php';
	require_once 'db/INSERT.php';
	require_once 'db/DELETE.php';
	require_once 'randomPW.php';
	require_once 'email.php';
	require_once 'pm.php';
	require_once 'classes/Applicant.php';
	require_once 'classes/Correspondent.php';
	require_once 'classes/Hike.php';
	require_once 'classes/Hiker.php';
	require_once 'classes/Message.php';
	require_once 'classes/Peak.php';
	require_once 'classes/User.php';
	
	if(!isset($_POST['id']) || !is_numeric($_POST['id'])){header('Location: ../applicants?_e=i'); exit;}
	if(!isset($_POST['corrid']) || !is_numeric($_POST['corrid'])){header('Location: ../applicant?_='.$_POST['id'].'&e=c'); exit;}
	
	$ADK_APPLICANT_ID = intval($_POST['id']);
	$ADK_CORRESPONDENT_ID = intval($_POST['corrid']);
	$randomPW = randomPW(8);
	
	$con = connect_db();
	
	$ADK_APPLICANT = new Applicant();
	$ADK_APPLICANT->id = $ADK_APPLICANT_ID;
	$ADK_APPLICANT->get($con);
	$ADK_APPLICANT->delete($con);
	
	$ADK_USER = new User();
	$ADK_USER->populateFromAddHiker($randomPW, $ADK_APPLICANT);
	$ADK_USER->save($con);
	
	$ADK_HIKER = new Hiker();
	$ADK_HIKER->populateFromApplicant($ADK_USER->id, $ADK_CORRESPONDENT_ID, $ADK_APPLICANT);
	$ADK_HIKER->save($con);
	
	foreach($ADK_APPLICANT->peakids as $ADK_PEAK_ID){
		$ADK_HIKE = new Hike();
		$ADK_PEAK = new Peak();
		$ADK_PEAK->id = $ADK_PEAK_ID;
		$ADK_HIKE->userid = $ADK_USER->id;
		$ADK_HIKE->save($con);
		$ADK_HIKE->addPeak($con, $ADK_PEAK);
	}
	
	$ADK_CORRESPONDENT = new Correspondent();
	$ADK_CORRESPONDENT->id = $ADK_HIKER->corrid;
	$ADK_CORRESPONDENT->get($con);	
	
	sendNewHikerEmail($ADK_USER, $ADK_CORRESPONDENT);
	sendCorrNewHikerEmail($ADK_CORRESPONDENT->email, $ADK_USER, $ADK_HIKER, $ADK_APPLICANT);
	sendCorrNewHikerPM($con, $ADK_USER, $ADK_HIKER, $ADK_APPLICANT);
	
	$con->close();
	
	header('Location: ../applicants');
	
?>