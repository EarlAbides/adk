<?php
	
	//Applicant
	function sql_addApplicant($con, $ADK_APPLICANT){
		$sql_query = $con->prepare(
			"INSERT INTO ADK_APPLICANT(ADK_APPLICANT_USERNAME, ADK_APPLICANT_NAME, ADK_APPLICANT_EMAIL, ADK_APPLICANT_PHONE,
				ADK_APPLICANT_AGE, ADK_APPLICANT_SEX, ADK_APPLICANT_ADDRESS1, ADK_APPLICANT_ADDRESS2,
				ADK_APPLICANT_CITY, ADK_APPLICANT_STATE, ADK_APPLICANT_ZIP, ADK_APPLICANT_COUNTRY, ADK_APPLICANT_PERSONALINFO, 
				ADK_APPLICANT_FIRSTPEAK_ID, ADK_APPLICANT_FIRSTPEAK_DTE, ADK_APPLICANT_NUMPEAKS, ADK_APPLICANT_REQ_CORR)
			VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);");
		
		$month = substr($ADK_APPLICANT['ADK_APPLICANT_FIRSTPEAK_DTE'], 0, 2);
		$day = substr($ADK_APPLICANT['ADK_APPLICANT_FIRSTPEAK_DTE'], 3, 2);
		$year = substr($ADK_APPLICANT['ADK_APPLICANT_FIRSTPEAK_DTE'], 6, 4);
		$ADK_APPLICANT['ADK_APPLICANT_FIRSTPEAK_DTE'] = date("Y-m-d", mktime(0, 0, 0, $month, $day, $year));
		
		$sql_query->bind_param('sssssssssssssisis', $ADK_APPLICANT['ADK_APPLICANT_USERNAME'], $ADK_APPLICANT['ADK_APPLICANT_NAME'],
					$ADK_APPLICANT['ADK_APPLICANT_EMAIL'], $ADK_APPLICANT['ADK_APPLICANT_PHONE'], $ADK_APPLICANT['ADK_APPLICANT_AGE'],
					$ADK_APPLICANT['ADK_APPLICANT_SEX'], $ADK_APPLICANT['ADK_APPLICANT_ADDRESS1'], $ADK_APPLICANT['ADK_APPLICANT_ADDRESS2'],
					$ADK_APPLICANT['ADK_APPLICANT_CITY'], $ADK_APPLICANT['ADK_APPLICANT_STATE'], $ADK_APPLICANT['ADK_APPLICANT_ZIP'],
					$ADK_APPLICANT['ADK_APPLICANT_COUNTRY'], $ADK_APPLICANT['ADK_APPLICANT_PERSONALINFO'], $ADK_APPLICANT['ADK_APPLICANT_FIRSTPEAK_ID'],
					$ADK_APPLICANT['ADK_APPLICANT_FIRSTPEAK_DTE'], $ADK_APPLICANT['ADK_APPLICANT_NUMPEAKS'], $ADK_APPLICANT['ADK_APPLICANT_REQ_CORR']);
		
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
		$sql_query = $con->prepare("INSERT INTO ADK_HIKE(ADK_USER_ID, ADK_HIKE_NOTES, ADK_HIKE_DTE) VALUES(?,?,?);");
		
		$month = substr($ADK_HIKE['ADK_HIKE_DTE'], 0, 2);
		$day = substr($ADK_HIKE['ADK_HIKE_DTE'], 3, 2);
		$year = substr($ADK_HIKE['ADK_HIKE_DTE'], 6, 4);
		$ADK_HIKE['ADK_HIKE_DTE'] = date("Y-m-d", mktime(0, 0, 0, $month, $day, $year));
		
		
		$sql_query->bind_param('iss', $ADK_HIKE['ADK_USER_ID'], $ADK_HIKE['ADK_HIKE_NOTES'], $ADK_HIKE['ADK_HIKE_DTE']);
		
		return $sql_query;
	}
	function sql_addHikesPeaks($con, $ADK_HIKE){
		$sql_query = $con->prepare("INSERT INTO ADK_HIKE_PEAK_JCT(ADK_HIKE_ID, ADK_PEAK_ID) VALUES(?,?);");
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
		        ADK_HIKER_PERSONALINFO, ADK_HIKER_FIRSTPEAK_ID, ADK_HIKER_FIRSTPEAK_DTE)
		    VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?);");
		
		$month = substr($ADK_HIKER['ADK_HIKER_FIRSTPEAK_DTE'], 0, 2);
		$day = substr($ADK_HIKER['ADK_HIKER_FIRSTPEAK_DTE'], 3, 2);
		$year = substr($ADK_HIKER['ADK_HIKER_FIRSTPEAK_DTE'], 6, 4);
		$ADK_HIKER['ADK_HIKER_FIRSTPEAK_DTE'] = date("Y-m-d", mktime(0, 0, 0, $month, $day, $year));
		
		$sql_query->bind_param('iisissssssssis', $ADK_HIKER['ADK_USER_ID'], $ADK_HIKER['ADK_HIKER_CORR_ID'], $ADK_HIKER['ADK_HIKER_PHONE'],
					$ADK_HIKER['ADK_HIKER_AGE'], $ADK_HIKER['ADK_HIKER_SEX'], $ADK_HIKER['ADK_HIKER_ADDRESS1'], $ADK_HIKER['ADK_HIKER_ADDRESS2'],
					$ADK_HIKER['ADK_HIKER_CITY'], $ADK_HIKER['ADK_HIKER_STATE'], $ADK_HIKER['ADK_HIKER_ZIP'], $ADK_HIKER['ADK_HIKER_COUNTRY'],
					$ADK_HIKER['ADK_HIKER_PERSONALINFO'], $ADK_HIKER['ADK_HIKER_FIRSTPEAK_ID'], $ADK_HIKER['ADK_HIKER_FIRSTPEAK_DTE']);
		
		return $sql_query;
	}
	
	//Message
	function sql_addMessage($con, $ADK_MESSAGE){
		$sql_query = $con->prepare(
			"INSERT INTO ADK_MESSAGE(ADK_MESSAGE_FROM_USER_ID, ADK_MESSAGE_TO_USER_ID, ADK_MESSAGE_TITLE, 
				ADK_MESSAGE_CONTENT, ADK_MESSAGE_DTE)
			VALUES(?,?,?,?, SUBTIME(NOW(),'0 12:00:00.00'));");
		
		$sql_query->bind_param('iiss', $ADK_MESSAGE['ADK_MESSAGE_FROM_USER_ID'], $ADK_MESSAGE['ADK_MESSAGE_TO_USER_ID'],
					$ADK_MESSAGE['ADK_MESSAGE_TITLE'], $ADK_MESSAGE['ADK_MESSAGE_CONTENT']);
		
		return $sql_query;
	}
		
	//User
	function sql_addUser($con, $ADK_USER){
		$sql_query = $con->prepare(
		    "INSERT INTO ADK_USER(ADK_USERGROUP_ID, ADK_USER_USERNAME, ADK_USER_PASSWORD, ADK_USER_NAME, ADK_USER_EMAIL)
		    VALUES(?,?,?,?,?);");
		
		$ADK_USER['ADK_USER_PASSWORD'] = md5($ADK_USER['ADK_USER_PASSWORD']);
		
		$sql_query->bind_param('issss', $ADK_USER['ADK_USERGROUP_ID'], $ADK_USER['ADK_USER_USERNAME'], $ADK_USER['ADK_USER_PASSWORD'],
					$ADK_USER['ADK_USER_NAME'], $ADK_USER['ADK_USER_EMAIL']);
		
		return $sql_query;
	}
	
?>