<?php
	
	//Imports
	require_once 'includes/db/db_conn.php';
	require_once 'includes/db/SELECT.php';
    require_once 'includes/classes/File.php';
    require_once 'includes/classes/Gallery.php';
	require_once 'includes/classes/Hiker.php';
    require_once 'includes/classes/Peak.php';
    require_once 'includes/classes/User.php';
	
	if(isset($_GET['_'])) $ADK_USER_ID = intval($_GET['_']);
	else $ADK_USER_ID = 0;
	$ADK_USERGROUP_CDE = $_SESSION['ADK_USERGROUP_CDE'];
	
	$con = connect_db();
    
	if($ADK_USER_ID > 0){
		$ADK_USER = new User();
		$ADK_USER->id = $ADK_USER_ID;
		$ADK_USER->get($con);
	}
	else $ADK_USER_ID = '%';

    $ADK_PEAKS = new Peaks();
	$ADK_PEAKS->get($con);

	$ADK_GALLERY = new Gallery();
	$ADK_GALLERY->userid = $ADK_USER_ID;
	$ADK_GALLERY->get($con);

	if($ADK_USERGROUP_CDE === 'ADM' || $ADK_USERGROUP_CDE === 'EDT'){
		$ADK_HIKERS = new Hikers();
		$ADK_HIKERS->get($con, '%');
	}
	
	$con->close();

	
	function getTitle($photo){
		$title = $photo->name;
		if($photo->peaks != '') $title .= "\n".$photo->peaks;
		if($photo->username != '') $title .= "\n".$photo->username;
		$title = str_replace(',', ', ', $title);

		return $title;
	}
?>