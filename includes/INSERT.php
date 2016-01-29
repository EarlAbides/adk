<?php
	
	//Applicant
	function sql_addApplicant($con, $ADK_APPLICANT){
		$sql_query = $con->prepare(
			"INSERT INTO ADK_APPLICANT(ADK_APPLICANT_USERNAME, ADK_APPLICANT_NAME, ADK_APPLICANT_EMAIL, ADK_APPLICANT_PHONE
			    ,ADK_APPLICANT_AGE, ADK_APPLICANT_SEX, ADK_APPLICANT_ADDRESS1, ADK_APPLICANT_ADDRESS2
			    ,ADK_APPLICANT_CITY, ADK_APPLICANT_STATE, ADK_APPLICANT_ZIP, ADK_APPLICANT_COUNTRY, ADK_APPLICANT_PERSONALINFO
			    ,ADK_APPLICANT_REQ_CORR, ADK_APPLICANT_PEAKIDS)
			VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);");
				
		$sql_query->bind_param('sssssssssssssss', $ADK_APPLICANT->username, $ADK_APPLICANT->name, $ADK_APPLICANT->email
			        ,$ADK_APPLICANT->phone, $ADK_APPLICANT->age, $ADK_APPLICANT->sex, $ADK_APPLICANT->address1
			        ,$ADK_APPLICANT->address2, $ADK_APPLICANT->city, $ADK_APPLICANT->state, $ADK_APPLICANT->zip
			        ,$ADK_APPLICANT->country, $ADK_APPLICANT->info, $ADK_APPLICANT->reqcorr, $ADK_APPLICANT->peakids);
				
		return $sql_query;
	}
	
	//Changelog
	function sql_addChange($con, $ADK_CHANGE){
		$sql_query = $con->prepare(
		    "INSERT INTO ADK_CHANGELOG(ADK_CHANGE_TITLE, ADK_CHANGE_DESC, ADK_CHANGE_DTE, ADK_CHANGE_PRIORITY)
		    VALUES(?,?, NOW(),?);");
		
		$sql_query->bind_param('ssi', $ADK_CHANGE['ADK_CHANGE_TITLE'], $ADK_CHANGE['ADK_CHANGE_DESC'], $ADK_CHANGE['ADK_CHANGE_PRIORITY']);
		
		return $sql_query;
	}
	
    //Correspondent
    function sql_addCorrespondent($con, $ADK_CORRESPONDENT){
        $sql_query = $con->prepare("INSERT INTO ADK_CORRESPONDENT(ADK_USER_ID, ADK_CORR_PERSONALINFO) VALUES(?,?);");
		$sql_query->bind_param('is', $ADK_CORRESPONDENT['ADK_USER_ID'], $ADK_CORRESPONDENT['ADK_CORR_PERSONALINFO']);
		
		return $sql_query;
    }

	//File
	function sql_addFile($con){
		$sql_query = $con->prepare("INSERT INTO ADK_FILE(ADK_FILE_NAME, ADK_FILE_SAVENAME, ADK_FILE_DESC, ADK_FILE_SIZE, ADK_FILE_TYPE) VALUES(?,?,?,?,?);");
		return $sql_query;
	}	
	function sql_addMessageFileJcts($con){
		$sql_query = $con->prepare("INSERT INTO ADK_MESSAGE_FILE_JCT(ADK_MESSAGE_ID, ADK_FILE_ID) VALUES(?,?);");
		return $sql_query;
	}
	
	//Hike
	function sql_addHike($con, $ADK_HIKE){
		$null = null;
		$sql_query = $con->prepare("INSERT INTO ADK_HIKE(ADK_USER_ID, ADK_HIKE_NOTES, ADK_HIKE_DTE) VALUES(?,?,?);");
		
		if(!isset($ADK_HIKE->notes) || !$ADK_HIKE->notes != '') $ADK_HIKE->notes = $null;
		if(isset($ADK_HIKE->datetime) && $ADK_HIKE->datetime != '') $ADK_HIKE->datetime = date("m/d/Y", strtotime($ADK_HIKE->datetime));
		else $ADK_HIKE->datetime = $null;
		
		$sql_query->bind_param('iss', $ADK_HIKE->userid, $ADK_HIKE->notes, $ADK_HIKE->datetime);
		
		return $sql_query;
	}

	function sql_addHikesPeak($con, $ADK_HIKE_ID, $ADK_PEAK_ID){
		$sql_query = $con->prepare("INSERT INTO ADK_HIKE_PEAK_JCT(ADK_HIKE_ID, ADK_PEAK_ID) VALUES(?,?);");

		$sql_query->bind_param('ii', $ADK_HIKE_ID, $ADK_PEAK_ID);

		return $sql_query;
	}

	function sql_addHikeFileJcts($con){
		$sql_query = $con->prepare("INSERT INTO ADK_HIKE_FILE_JCT(ADK_HIKE_ID, ADK_FILE_ID) VALUES(?,?);");
		return $sql_query;
	}
	
	//Hiker
	function sql_addHiker($con, $ADK_HIKER){
		$sql_query = $con->prepare(
		    "INSERT INTO ADK_HIKER(ADK_USER_ID, ADK_HIKER_CORR_ID, ADK_HIKER_PHONE, ADK_HIKER_AGE, ADK_HIKER_SEX,
				ADK_HIKER_ADDRESS1, ADK_HIKER_ADDRESS2, ADK_HIKER_CITY, ADK_HIKER_STATE, ADK_HIKER_ZIP, ADK_HIKER_COUNTRY,
		        ADK_HIKER_PERSONALINFO)
		    VALUES(?,?,?,?,?,?,?,?,?,?,?,?);");
		
		$sql_query->bind_param('iisissssssss', $ADK_HIKER->id, $ADK_HIKER->corrid, $ADK_HIKER->phone,
					$ADK_HIKER->age, $ADK_HIKER->sex, $ADK_HIKER->address1, $ADK_HIKER->address2,
					$ADK_HIKER->city, $ADK_HIKER->state, $ADK_HIKER->zip, $ADK_HIKER->country,
					$ADK_HIKER->info);
		
		return $sql_query;
	}
	
	//Message
	function sql_addMessage($con, $ADK_MESSAGE){
		$sql_query = $con->prepare(
			"INSERT INTO ADK_MESSAGE(ADK_MESSAGE_FROM_USER_ID, ADK_MESSAGE_TO_USER_ID, ADK_MESSAGE_TITLE, 
				ADK_MESSAGE_CONTENT, ADK_MESSAGE_DTE, ADK_MESSAGE_DRAFT)
			VALUES(?,?,?,?, SUBTIME(NOW(),'0 12:00:00.00'), ?);"
		);
		
		$sql_query->bind_param('iissi', $ADK_MESSAGE['ADK_MESSAGE_FROM_USER_ID'], $ADK_MESSAGE['ADK_MESSAGE_TO_USER_ID'],
					$ADK_MESSAGE['ADK_MESSAGE_TITLE'], $ADK_MESSAGE['ADK_MESSAGE_CONTENT'], $ADK_MESSAGE['ADK_MESSAGE_DRAFT']);
		
		return $sql_query;
	}

	function sql_addTemplate($con, $ADK_MSG_TMPL){
		$sql_query = $con->prepare("INSERT INTO ADK_MSG_TMPL(ADK_USER_ID, ADK_MSG_TMPL_NAME, ADK_MSG_TMPL_CONTENT) VALUES(?,?,?);");
		
		$sql_query->bind_param('iss', $ADK_MSG_TMPL->userid, $ADK_MSG_TMPL->name, $ADK_MSG_TMPL->content);
		
		return $sql_query;
	}
		
	//User
	function sql_addUser($con, $ADK_USER){
		$sql_query = $con->prepare(
		    "INSERT INTO ADK_USER(ADK_USERGROUP_ID, ADK_USER_USERNAME, ADK_USER_PASSWORD, ADK_USER_NAME, ADK_USER_EMAIL)
		    VALUES(?,?,?,?,?);");
		
		$ADK_USER->pw = md5($ADK_USER->pw);

		$sql_query->bind_param('issss', $ADK_USER->usergroupid, $ADK_USER->username, $ADK_USER->pw,
					$ADK_USER->name, $ADK_USER->email);
		
		return $sql_query;
	}
	
?>