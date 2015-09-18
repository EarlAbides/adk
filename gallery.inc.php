<?php
	
	//Imports
	require_once 'includes/db_conn.php';
	require_once 'includes/SELECT.php';
    require_once 'includes/Gallery.php';
    require_once 'includes/User.php';
    require_once 'includes/Peak.php';
	
	if(isset($_GET['_'])){
		$ADK_USER_ID = $_GET['_'];
		if($ADK_USER_ID == '') header("Location: ./");
	}
	else header("Location: ./");
	
	$con = connect_db();//Connect to db
	if(mysqli_connect_errno())
	    return 'Error';
    
    $ADK_USER = getUser($con, $ADK_USER_ID);

    $ADK_PEAKS = getPeaks($con);

	$ADK_FILE_GALLERY = getFileGallery($con, $ADK_USER_ID);
	
	$con->close();

    if($ADK_FILE_GALLERY !== ''){
        $photos = $ADK_FILE_GALLERY->getPhotos();
        $videos = $ADK_FILE_GALLERY->getVideos();
        $docsFiles = $ADK_FILE_GALLERY->getDocsAndFiles();
    }
	
?>