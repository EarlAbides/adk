<?php
	
	if(!isset($_SESSION['ADK_USER_ID'])){//Login page
		include './login.php';
		exit;
	}
	
	if(isset($GLOBALS['page'])){
		switch($GLOBALS['page']){
			case 'applicant': case 'applicants': case 'changelog': case 'correspondent':
			case 'correspondents': case 'editApplicant': case 'editCorrespondent':
				if($_SESSION['ADK_USERGROUP_CDE'] !== 'ADM') header('Location: ./'); break;
			case 'editHiker': case 'guideCorr': case 'hiker': case 'hikers':
				if($_SESSION['ADK_USERGROUP_CDE'] !== 'ADM' && $_SESSION['ADK_USERGROUP_CDE'] !== 'COR') header('Location: ./'); break;
			case 'guideHiker': case 'hikerportal': case 'hiker':
				if($_SESSION['ADK_USERGROUP_CDE'] !== 'HIK') header('Location: ./'); break;
		}
	}
?>