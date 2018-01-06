<?php
	
	//Imports
	require_once 'includes/db/db_conn.php';
	require_once 'includes/db/SELECT.php';
    require_once 'includes/classes/File.php';
    require_once 'includes/classes/Gallery.php';
    require_once 'includes/classes/Peak.php';
	
	$ADK_USER_ID = isset($_GET['_']) && is_numeric($_GET['_'])? intval($_GET['_']): '%';
	$ADK_USERGROUP_CDE = $_SESSION['ADK_USERGROUP_CDE'];

	if($ADK_USERGROUP_CDE === 'HIK' && $ADK_USER_ID != $_SESSION['ADK_USER_ID']){header('Location: ./hikerportal'); exit;}
	
	$con = connect_db();
    
	if($ADK_USER_ID !== '%'){
		require_once 'includes/classes/Hike.php';
		require_once 'includes/classes/User.php';

		$ADK_USER = new User();
		$ADK_USER->id = $ADK_USER_ID;
		$ADK_USER->get($con);

		$ADK_HIKES = new Hikes();
		$ADK_HIKES->userid = $ADK_USER_ID;
		$ADK_HIKES->get($con);
	}

    $ADK_PEAKS = new Peaks();
	$ADK_PEAKS->get($con);

	$ADK_GALLERY = new Gallery();
	$ADK_GALLERY->userid = $ADK_USER_ID;
	if($ADK_USERGROUP_CDE === 'COR') $ADK_GALLERY->corrid = $_SESSION['ADK_USER_ID'];
	$ADK_GALLERY->get($con);

	if($ADK_USERGROUP_CDE !== 'HIK'){
		require_once 'includes/classes/Hiker.php';

		$ADK_HIKERS = new Hikers();
		$ADK_HIKERS->get($con, $ADK_USERGROUP_CDE === 'COR'? $_SESSION['ADK_USER_ID']: '%');
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