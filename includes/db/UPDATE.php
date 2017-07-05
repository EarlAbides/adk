<?php
	
	// Applicant
	function sql_updateApplicant($con, $ADK_APPLICANT) {
		$sql_query = $con->prepare(
			"UPDATE ADK_APPLICANT
				SET ADK_APPLICANT_USERNAME = ?
					, ADK_APPLICANT_NAME = ?
					, ADK_APPLICANT_EMAIL = ?
					, ADK_APPLICANT_PHONE = ?
					, ADK_APPLICANT_AGE = ?
					, ADK_APPLICANT_SEX = ?
					, ADK_APPLICANT_ADDRESS1 = ?
					, ADK_APPLICANT_ADDRESS2 = ?
					, ADK_APPLICANT_CITY = ?
					, ADK_APPLICANT_STATE = ?
					, ADK_APPLICANT_ZIP = ?
					, ADK_APPLICANT_COUNTRY = ?
					, ADK_APPLICANT_PERSONALINFO = ?
			WHERE ADK_APPLICANT_ID = ?;");
				
		$sql_query->bind_param('ssssissssssssi', $ADK_APPLICANT->username, $ADK_APPLICANT->name, $ADK_APPLICANT->email
					,$ADK_APPLICANT->phone, $ADK_APPLICANT->age, $ADK_APPLICANT->sex, $ADK_APPLICANT->address1
					,$ADK_APPLICANT->address2, $ADK_APPLICANT->city, $ADK_APPLICANT->state, $ADK_APPLICANT->zip
					,$ADK_APPLICANT->country, $ADK_APPLICANT->info, $ADK_APPLICANT->id);
				
		return $sql_query;
	}
	
	// Correspondent
	function sql_updateCorrespondent($con, $ADK_CORRESPONDENT) {
		$sql_query = $con->prepare("UPDATE ADK_CORRESPONDENT SET ADK_CORR_PERSONALINFO = ? WHERE ADK_USER_ID = ?;");
		
		$sql_query->bind_param('si', $ADK_CORRESPONDENT->info, $ADK_CORRESPONDENT->id);
		
		return $sql_query;
	}
	
	function sql_updateCorrPhotoID($con, $ADK_CORRESPONDENT) {
        $sql_query = $con->prepare("UPDATE ADK_CORRESPONDENT SET ADK_CORR_PHOTO_ID = ? WHERE ADK_USER_ID = ?;");
		
		$sql_query->bind_param('ii', $ADK_CORRESPONDENT->photoid, $ADK_CORRESPONDENT->id);
		
		return $sql_query;
	}
	
	function sql_updateReassignCorrsHikers($con, $ADK_USER_ID, $old_ADK_CORRESPONDENT_ID) {
		$sql_query = $con->prepare("UPDATE ADK_HIKER SET ADK_HIKER_CORR_ID = ? WHERE ADK_HIKER_CORR_ID = ?;");
		
		$sql_query->bind_param('ii', $ADK_USER_ID, $old_ADK_CORRESPONDENT_ID);
		
		return $sql_query;
	}

	// Hike
	function sql_updateHike($con, $ADK_HIKE){
		$null = null;
		$sql_query = $con->prepare(
			"UPDATE ADK_HIKE
				SET ADK_HIKE_NOTES = ?
					, ADK_HIKE_DTE = ?
					, ADK_HIKE_TS = CURRENT_TIMESTAMP
			WHERE ADK_HIKE_ID = ?;");
		
		if($ADK_HIKE->notes == '') $ADK_HIKE->notes = $null;
		$dt = $ADK_HIKE->datetime != ''? date('Y-m-d', strtotime($ADK_HIKE->datetime)): $null;
		
		$sql_query->bind_param('ssi', $ADK_HIKE->notes, $dt, $ADK_HIKE->id);
		
		return $sql_query;
	}
	
	// Hiker
	function sql_updateHiker($con, $ADK_HIKER) {
		$sql_query = $con->prepare(
			"UPDATE ADK_HIKER
				SET ADK_HIKER_PHONE = ?
					, ADK_HIKER_AGE = ?
					, ADK_HIKER_SEX = ?
					, ADK_HIKER_ADDRESS1 = ?
					, ADK_HIKER_ADDRESS2 = ?
					, ADK_HIKER_CITY = ?
					, ADK_HIKER_STATE = ?
					, ADK_HIKER_ZIP = ?
					, ADK_HIKER_COUNTRY = ?
					, ADK_HIKER_PERSONALINFO = ?
			WHERE ADK_USER_ID = ?;"
		);
		
		$sql_query->bind_param('sissssssssi', $ADK_HIKER->phone, $ADK_HIKER->age, $ADK_HIKER->sex, $ADK_HIKER->address1, $ADK_HIKER->address2,
					$ADK_HIKER->city, $ADK_HIKER->state, $ADK_HIKER->zip, $ADK_HIKER->country, $ADK_HIKER->info, $ADK_HIKER->id);
		
		return $sql_query;
	}
	
	function sql_updateCompleteDate($con, $ADK_HIKER) {
		$sql_query = $con->prepare("UPDATE ADK_HIKER SET ADK_HIKER_COMPLETE_DTE = ? WHERE ADK_USER_ID = ?;");

		$dt = date('Y-m-d', strtotime($ADK_HIKER->completedate));

		$sql_query->bind_param('si', $dt, $ADK_HIKER->id);
		
		return $sql_query;
	}

	function sql_updateHikerCorr($con, $ADK_USER_ID, $ADK_CORR_ID) {
		$sql_query = $con->prepare("UPDATE ADK_HIKER SET ADK_HIKER_CORR_ID = ? WHERE ADK_USER_ID = ?;");
		
		$sql_query->bind_param('ii', $ADK_CORR_ID, $ADK_USER_ID);
		
		return $sql_query;
	}

	function sql_updateHikerPhotoID($con, $ADK_HIKER) {
        $sql_query = $con->prepare("UPDATE ADK_HIKER SET ADK_HIKER_PHOTO_ID = ? WHERE ADK_USER_ID = ?;");
		
		$sql_query->bind_param('ii', $ADK_HIKER->photoid, $ADK_HIKER->id);
		
		return $sql_query;
	}
	
	function sql_updateLastActive($con, $ADK_USER_ID) {
		$sql_query = $con->prepare("UPDATE ADK_HIKER SET ADK_HIKER_LASTACTIVE_DTE = NOW() WHERE ADK_USER_ID = ?;");
		
		$sql_query->bind_param('i', $ADK_USER_ID);
		
		return $sql_query;
	}
	
	// Message
	function sql_updateDeleteMessageTrash($con, $ADK_MESSAGE_ID) {
		$sql_query = $con->prepare("UPDATE ADK_MESSAGE SET ADK_MESSAGE_DELETED = '1' WHERE ADK_MESSAGE_ID = ?;");
		
        $sql_query->bind_param('i', $ADK_MESSAGE_ID);

		return $sql_query;
	}
	
	function sql_updateMessageMarkRead($con, $ADK_MESSAGE_ID) {
		$sql_query = $con->prepare("UPDATE ADK_MESSAGE SET ADK_MESSAGE_READ = '1' WHERE ADK_MESSAGE_ID = ?;");

        $sql_query->bind_param('i', $ADK_MESSAGE_ID);
		
		return $sql_query;
	}
	
	function sql_updateMessageDelete($con, $ADK_MESSAGE_ID, $inboxSent) {
		if($inboxSent === 'i') $sql_query = $con->prepare("UPDATE ADK_MESSAGE SET ADK_MESSAGE_TO_DELETED = '1' WHERE ADK_MESSAGE_ID = ?;");
		else $sql_query = $con->prepare("UPDATE ADK_MESSAGE SET ADK_MESSAGE_FROM_DELETED = '1' WHERE ADK_MESSAGE_ID = ?;");

        $sql_query->bind_param('i', $ADK_MESSAGE_ID);
		
		return $sql_query;
	}

	function sql_sendDraft($con, $ADK_MESSAGE) {
		$sql_query = $con->prepare(
			"UPDATE ADK_MESSAGE
				SET ADK_MESSAGE_TITLE = ?
					, ADK_MESSAGE_CONTENT = ?
					, ADK_MESSAGE_DTE = NOW()
					, ADK_MESSAGE_READ = 0
					, ADK_MESSAGE_DRAFT = 0
			WHERE ADK_MESSAGE_ID = ?;");
		
		$sql_query->bind_param('ssi', $ADK_MESSAGE->title, $ADK_MESSAGE->content, $ADK_MESSAGE->id);
		
		return $sql_query;
	}

	function sql_updateDraft($con, $ADK_MESSAGE) {
		$sql_query = $con->prepare(
			"UPDATE ADK_MESSAGE
				SET ADK_MESSAGE_TITLE = ?
					, ADK_MESSAGE_CONTENT = ?
					, ADK_MESSAGE_DTE = NOW()
					, ADK_MESSAGE_DRAFT = 1
			WHERE ADK_MESSAGE_ID = ?;"
		);
		
		$sql_query->bind_param('ssi', $ADK_MESSAGE->title, $ADK_MESSAGE->content, $ADK_MESSAGE->id);
		
		return $sql_query;
	}

	function sql_updateTemplate($con, $ADK_MSG_TMPL) {
		$sql_query = $con->prepare(
			"UPDATE ADK_MSG_TMPL
				SET ADK_MSG_TMPL_NAME = ?
					, ADK_MSG_TMPL_CONTENT = ?
					, ADK_MSG_TMPL_DTE = NOW()
			WHERE ADK_MSG_TMPL_ID = ?;"
		);
		
		$sql_query->bind_param('ssi', $ADK_MSG_TMPL->name, $ADK_MSG_TMPL->content, $ADK_MSG_TMPL->id);
		
		return $sql_query;
	}
	
	// Pref
	function sql_updateUserPref($con, $ADK_USER_ID, $ADK_PREF_NAME, $ADK_PREF_VAL) {
		$sql_query = $con->prepare(
			"UPDATE ADK_USER_PREF SET ADK_PREF_VAL = ?
			WHERE ADK_PREF_NAME = ? AND ADK_USER_ID = ?;"
		);
		
		$sql_query->bind_param('isi', $ADK_PREF_VAL, $ADK_PREF_NAME, $ADK_USER_ID);
		
		return $sql_query;
	}

	// User
	function sql_updateUser($con, $ADK_USER) {
		$sql_query = $con->prepare(
			"UPDATE ADK_USER
				SET ADK_USER_USERNAME = ?
					, ADK_USER_NAME = ?
					, ADK_USER_EMAIL = ?
			WHERE ADK_USER_ID = ?;"
		);
		
		$sql_query->bind_param('sssi', $ADK_USER->username, $ADK_USER->name, $ADK_USER->email, $ADK_USER->id);
		
		return $sql_query;
	}
	
	function sql_updateUserPW($con, $ADK_USER) {
		$sql_query = $con->prepare("UPDATE ADK_USER SET ADK_USER_PASSWORD = ? WHERE ADK_USER_ID = ?;");
		
		$pw = md5($ADK_USER->pw);

		$sql_query->bind_param('si', $pw, $ADK_USER->id);
		
		return $sql_query;
	}
	
?>