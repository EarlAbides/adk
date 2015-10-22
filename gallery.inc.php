<?php
	
	//Imports
	require_once 'includes/db_conn.php';
	require_once 'includes/SELECT.php';
    require_once 'includes/Gallery.php';
	require_once 'includes/Hiker.php';
    require_once 'includes/User.php';
    require_once 'includes/Peak.php';
	
	if(isset($_GET['_'])) $ADK_USER_ID = intval($_GET['_']);
	else $ADK_USER_ID = 0;
	
	$con = connect_db();
    
	if($ADK_USER_ID > 0) $ADK_USER = getUser($con, $ADK_USER_ID);
	else $ADK_USER_ID = '%';

    $ADK_PEAKS = getPeaks($con);

	$ADK_FILE_GALLERY = getFileGallery($con, $ADK_USER_ID);

	if($ADK_USERGROUP_CDE === 'ADM' || $ADK_USERGROUP_CDE === 'EDT') $ADK_HIKERS = getHikers($con);
	
	$con->close();


    if($ADK_FILE_GALLERY !== ''){
        $photos = $ADK_FILE_GALLERY->getPhotos();
        $videos = $ADK_FILE_GALLERY->getVideos();
        $docsFiles = $ADK_FILE_GALLERY->getDocsAndFiles();
    }

	function getTitle($photo){
		$title = $photo->name;
		if($photo->peaks != '') $title .= "\n".$photo->peaks;
		if($photo->username != '') $title .= "\n".$photo->username;
		$title = str_replace(',', ', ', $title);

		return $title;
	}
?>