<?php
	
	//Applicant
	function sql_updateApplicant($con, $ADK_CORRESPONDENT){
		$sql_query = $con->prepare(
			"UPDATE ADK_APPLICANT
				SET ADK_APPLICANT_USERNAME = ?,
					ADK_APPLICANT_NAME = ?,
					ADK_APPLICANT_EMAIL = ?,
					ADK_APPLICANT_PHONE = ?,
					ADK_APPLICANT_AGE = ?,
					ADK_APPLICANT_SEX = ?,
					ADK_APPLICANT_ADDRESS1 = ?,
					ADK_APPLICANT_ADDRESS2 = ?,
					ADK_APPLICANT_CITY = ?,
					ADK_APPLICANT_STATE = ?,
					ADK_APPLICANT_ZIP = ?,
					ADK_APPLICANT_COUNTRY = ?,
					ADK_APPLICANT_PERSONALINFO = ?,
					ADK_APPLICANT_FIRSTPEAK_ID = ?,
					ADK_APPLICANT_FIRSTPEAK_DTE = ?
			WHERE ADK_APPLICANT_ID = ?;");
		
		$month = substr($ADK_CORRESPONDENT['ADK_APPLICANT_FIRSTPEAK_DTE'], 0, 2);
		$day = substr($ADK_CORRESPONDENT['ADK_APPLICANT_FIRSTPEAK_DTE'], 3, 2);
		$year = substr($ADK_CORRESPONDENT['ADK_APPLICANT_FIRSTPEAK_DTE'], 6, 4);
		$ADK_CORRESPONDENT['ADK_APPLICANT_FIRSTPEAK_DTE'] = date("Y-m-d", mktime(0, 0, 0, $month, $day, $year));
		
		$sql_query->bind_param('sssssssssssssisi', $ADK_CORRESPONDENT['ADK_APPLICANT_USERNAME'], $ADK_CORRESPONDENT['ADK_APPLICANT_NAME'],
					$ADK_CORRESPONDENT['ADK_APPLICANT_EMAIL'], $ADK_CORRESPONDENT['ADK_APPLICANT_PHONE'], $ADK_CORRESPONDENT['ADK_APPLICANT_AGE'],
					$ADK_CORRESPONDENT['ADK_APPLICANT_SEX'], $ADK_CORRESPONDENT['ADK_APPLICANT_ADDRESS1'], $ADK_CORRESPONDENT['ADK_APPLICANT_ADDRESS2'],
					$ADK_CORRESPONDENT['ADK_APPLICANT_CITY'], $ADK_CORRESPONDENT['ADK_APPLICANT_STATE'], $ADK_CORRESPONDENT['ADK_APPLICANT_ZIP'],
					$ADK_CORRESPONDENT['ADK_APPLICANT_COUNTRY'], $ADK_CORRESPONDENT['ADK_APPLICANT_PERSONALINFO'], $ADK_CORRESPONDENT['ADK_APPLICANT_FIRSTPEAK_ID'],
					$ADK_CORRESPONDENT['ADK_APPLICANT_FIRSTPEAK_DTE'], $ADK_CORRESPONDENT['ADK_APPLICANT_ID']);
		
		return $sql_query;
	}
	
	//Change log
	function sql_updateChangeDone($con, $ADK_CHANGE_ID, $ADK_CHANGE_DONE){
		$sql_query = $con->prepare(
		    "UPDATE ADK_CHANGELOG SET ADK_CHANGE_DONE = ? WHERE ADK_CHANGE_ID = ?;");
		
		$sql_query->bind_param('ii', $ADK_CHANGE_DONE, $ADK_CHANGE_ID);
		
		return $sql_query;
	}
	
	//Correspondent
	function sql_updateCorrespondent($con, $ADK_CORRESPONDENT){
		$sql_query = $con->prepare("UPDATE ADK_CORRESPONDENT SET ADK_CORR_PHOTO_ID = ?, ADK_CORR_PERSONALINFO = ? WHERE ADK_USER_ID = ?;");
		
		$sql_query->bind_param('isi', $ADK_CORRESPONDENT['ADK_CORR_PHOTO_ID'], $ADK_CORRESPONDENT['ADK_CORR_PERSONALINFO'], $ADK_CORRESPONDENT['ADK_USER_ID']);
		
		return $sql_query;
	}
	
	function sql_updateCorrPhotoID($con, $ADK_USER_ID, $ADK_FILE_ID){
        $sql_query = $con->prepare("UPDATE ADK_CORRESPONDENT SET ADK_CORR_PHOTO_ID = ? WHERE ADK_USER_ID = ?;");
		
		$sql_query->bind_param('ii', $ADK_FILE_ID, $ADK_USER_ID);
		
		return $sql_query;
	}
	
	function sql_updateReassignCorrsHikers($con, $ADK_USER_ID, $newCorrID){
		$sql_query = $con->prepare("UPDATE ADK_HIKER SET ADK_HIKER_CORR_ID = ? WHERE ADK_HIKER_CORR_ID = ?;");
		
		$sql_query->bind_param('ii', $newCorrID, $ADK_USER_ID);
		
		return $sql_query;
	}

	//Hike
	function sql_updateHike($con, $ADK_HIKE){
		$sql_query = $con->prepare(
			"UPDATE ADK_HIKE
				SET ADK_HIKE_NOTES = ?,
					ADK_HIKE_DTE = ?
			WHERE ADK_HIKE_ID = ?;");
		
		$month = substr($ADK_HIKE['ADK_HIKE_DTE'], 0, 2);
		$day = substr($ADK_HIKE['ADK_HIKE_DTE'], 3, 2);
		$year = substr($ADK_HIKE['ADK_HIKE_DTE'], 6, 4);
		$ADK_HIKE['ADK_HIKE_DTE'] = date("Y-m-d", mktime(0, 0, 0, $month, $day, $year));
		
		$sql_query->bind_param('ssi', $ADK_HIKE['ADK_HIKE_NOTES'], $ADK_HIKE['ADK_HIKE_DTE'], $ADK_HIKE['ADK_HIKE_ID']);
		
		return $sql_query;
	}
	
	//Hiker
	function sql_updateHiker($con, $ADK_HIKER){
		$sql_query = $con->prepare(
			"UPDATE ADK_HIKER
				SET ADK_HIKER_PHONE = ?,
					ADK_HIKER_AGE = ?,
					ADK_HIKER_SEX = ?,
					ADK_HIKER_ADDRESS1 = ?,
					ADK_HIKER_ADDRESS2 = ?,
					ADK_HIKER_CITY = ?,
					ADK_HIKER_STATE = ?,
					ADK_HIKER_ZIP = ?,
					ADK_HIKER_COUNTRY = ?,
					ADK_HIKER_PERSONALINFO = ?
			WHERE ADK_USER_ID = ?;");
		
		$sql_query->bind_param('sissssssssi', $ADK_HIKER['ADK_HIKER_PHONE'], $ADK_HIKER['ADK_HIKER_AGE'],
					$ADK_HIKER['ADK_HIKER_SEX'], $ADK_HIKER['ADK_HIKER_ADDRESS1'], $ADK_HIKER['ADK_HIKER_ADDRESS2'],
					$ADK_HIKER['ADK_HIKER_CITY'], $ADK_HIKER['ADK_HIKER_STATE'], $ADK_HIKER['ADK_HIKER_ZIP'],
					$ADK_HIKER['ADK_HIKER_COUNTRY'], $ADK_HIKER['ADK_HIKER_PERSONALINFO'], $ADK_HIKER['ADK_USER_ID']);
		
		return $sql_query;
	}
	
	function sql_updateHikersCorr($con, $ADK_USER_ID, $ADK_CORR_ID){
		$sql_query = $con->prepare("UPDATE ADK_HIKER SET ADK_HIKER_CORR_ID = ? WHERE ADK_USER_ID = ?;");
		
		$sql_query->bind_param('ii', $ADK_CORR_ID, $ADK_USER_ID);
		
		return $sql_query;
	}
	
	//Message
	function sql_updateDeleteMessageTrash($con, $ADK_MESSAGE_ID){
		$sql_query = $con->prepare("UPDATE ADK_MESSAGE SET ADK_MESSAGE_DELETED = '1' WHERE ADK_MESSAGE_ID = ?;");
		
        $sql_query->bind_param('i', $ADK_MESSAGE_ID);

		return $sql_query;
	}
	
	function sql_updateMessageMarkRead($con, $ADK_MESSAGE_ID){
		$sql_query = $con->prepare("UPDATE ADK_MESSAGE SET ADK_MESSAGE_READ = '1' WHERE ADK_MESSAGE_ID = ?;");

        $sql_query->bind_param('i', $ADK_MESSAGE_ID);
		
		return $sql_query;
	}
	
	function sql_updateMessageDelete($con, $ADK_MESSAGE_ID, $inboxSent){
		if($inboxSent === 'i') $sql_query = $con->prepare("UPDATE ADK_MESSAGE SET ADK_MESSAGE_TO_DELETED = '1' WHERE ADK_MESSAGE_ID = ?;");
		else $sql_query = $con->prepare("UPDATE ADK_MESSAGE SET ADK_MESSAGE_FROM_DELETED = '1' WHERE ADK_MESSAGE_ID = ?;");

        $sql_query->bind_param('i', $ADK_MESSAGE_ID);
		
		return $sql_query;
	}
	
	//User
	function sql_updateUser($con, $ADK_USER){
		$sql_query = $con->prepare(
			"UPDATE ADK_USER
				SET ADK_USERGROUP_ID = ?,
					ADK_USER_USERNAME = ?,
					ADK_USER_NAME = ?,
					ADK_USER_EMAIL = ?
			WHERE ADK_USER_ID = ?;");
		
		$sql_query->bind_param('isssi', $ADK_USER['ADK_USERGROUP_ID'], $ADK_USER['ADK_USER_USERNAME'], $ADK_USER['ADK_USER_NAME'],
								$ADK_USER['ADK_USER_EMAIL'], $ADK_USER['ADK_USER_ID']);
		
		return $sql_query;
	}
	
	function sql_updateUserPassword($con, $ADK_USER_ID, $ADK_USER_PASSWORD){
		$sql_query = $con->prepare("UPDATE ADK_USER SET ADK_USER_PASSWORD = ? WHERE ADK_USER_ID = ?;");
		
		$sql_query->bind_param('si', $ADK_USER_PASSWORD, $ADK_USER_ID);
		
		return $sql_query;
	}
	
?>