<?php
	
	if(!isset($_SESSION['ADK_USER_ID'])){//Login page
		include './login.php';
		exit;
	}
	else $ADK_USERGROUP_CDE = $_SESSION['ADK_USERGROUP_CDE'];

	if(isset($GLOBALS['page'])){
		switch($GLOBALS['page']){
			case 'applicant': case 'applicants': case 'correspondent':
			case 'correspondents': case 'editApplicant': case 'editCorrespondent':
				if($ADK_USERGROUP_CDE !== 'ADM') header('Location: ./'); break;
			case 'editHiker': case 'guideCorr': case 'hiker': case 'hikers': case 'news':
				if($ADK_USERGROUP_CDE === 'HIK') header('Location: ./'); break;
			case 'guideHiker': case 'hikerportal':
				if($ADK_USERGROUP_CDE !== 'HIK') header('Location: ./'); break;
			case 'messages':
				if($ADK_USERGROUP_CDE === 'EDT') header('Location: ./'); break;
		}
	}
?>