<?php

    error_reporting(E_ERROR|E_WARNING);
    if(!isset($_GET["_"]) && $_GET["_"] !== "123") exit;

	require "../db/db_conn.php";
	require "../db/SELECT.php";
	require "../classes/Applicant.php";
	require "../classes/Batch.php";
	require "../classes/Correspondent.php";
	require "../classes/File.php";
	require "../classes/Gallery.php";
	require "../classes/Hike.php";
	require "../classes/Hiker.php";
	require "../classes/HikersPeaks.php";
	require "../classes/Message.php";
	require "../classes/Peak.php";
	require "../classes/Pref.php";
	require "../classes/Report.php";
	require "../classes/Template.php";
	require "../classes/User.php";

	$con = connect_db();

	// batch_hikersCorrespondenceHistory
	//$correspondenceHistory = Batch::batch_hikersCorrespondenceHistory($con, 253);
	//echo $correspondenceHistory;

	// batch_hikersHikeData
	$hikersHikeData = Batch::batch_hikersHikeData($con, 35);
	//var_dump($hikersHikeData);

	$con->close();

?>
