<?php
	
	//Applicant
	function sendNewApplicantPM($con, $ADK_APPLICANT){
		$message = "Username:".$GLOBALS['crlf'];
		$message .= $ADK_APPLICANT['ADK_APPLICANT_USERNAME'].$GLOBALS['dcrlf'];
		$message .= "Name:".$GLOBALS['crlf'];
		$message .= $ADK_APPLICANT['ADK_APPLICANT_NAME'].$GLOBALS['dcrlf'];
		$message .= "Email:".$GLOBALS['crlf'];
		$message .= $ADK_APPLICANT['ADK_APPLICANT_EMAIL'].$GLOBALS['dcrlf'];
		$message .= "Phone:".$GLOBALS['crlf'];
		$message .= $ADK_APPLICANT['ADK_APPLICANT_PHONE'].$GLOBALS['dcrlf'];
		$message .= "Age:".$GLOBALS['crlf'];
		$message .= $ADK_APPLICANT['ADK_APPLICANT_AGE'].$GLOBALS['dcrlf'];
		$message .= "Sex:".$GLOBALS['crlf'];
		$message .= $ADK_APPLICANT['ADK_APPLICANT_SEX'].$GLOBALS['dcrlf'];
		$message .= "Address 1:".$GLOBALS['crlf'];
		$message .= $ADK_APPLICANT['ADK_APPLICANT_ADDRESS1'].$GLOBALS['dcrlf'];
		$message .= "Address 2:".$GLOBALS['crlf'];;
		$message .= $ADK_APPLICANT['ADK_APPLICANT_ADDRESS2'].$GLOBALS['dcrlf'];
		$message .= "City:".$GLOBALS['crlf'];
		$message .= $ADK_APPLICANT['ADK_APPLICANT_CITY'].$GLOBALS['dcrlf'];
		$message .= "State:".$GLOBALS['crlf'];
		$message .= $ADK_APPLICANT['ADK_APPLICANT_STATE'].$GLOBALS['dcrlf'];
		$message .= "Zip:".$GLOBALS['crlf'];
		$message .= $ADK_APPLICANT['ADK_APPLICANT_ZIP'].$GLOBALS['dcrlf'];
		$message .= "Country:".$GLOBALS['crlf'];
		$message .= $ADK_APPLICANT['ADK_APPLICANT_COUNTRY'].$GLOBALS['dcrlf'];
		$message .= "Personal info:".$GLOBALS['crlf'];
		$message .= $ADK_APPLICANT['ADK_APPLICANT_PERSONALINFO'].$GLOBALS['dcrlf'];
		$message .= "Click <a href=\"./applicant?_=".$ADK_APPLICANT['ADK_APPLICANT_ID']."\">here</a> to view.".$GLOBALS['dcrlf'];
		
		$ADK_MESSAGE = array(
			'ADK_MESSAGE_FROM_USER_ID' => 1,
	        'ADK_MESSAGE_TO_USER_ID' => 1,
	        'ADK_MESSAGE_RESPOND_ID' => '',
	        'ADK_MESSAGE_ORIG_ID' => '',
			'ADK_MESSAGE_TITLE' => 'New Applicant  - '.$ADK_APPLICANT['ADK_APPLICANT_USERNAME'],
			'ADK_MESSAGE_CONTENT' => $message
	    );
		
		addSysMessage($con, $ADK_MESSAGE);
	}
	
	//Correspondent
	function sendCorrNewHikerPM($con, $ADK_CORRESPONDENT_ID, $ADK_USER, $ADK_HIKER){
		$message = "Your have been assigned a new hiker!".$GLOBALS['dcrlf'];
		
		$message .= "Name:".$GLOBALS['crlf'];
		$message .= $ADK_HIKER['ADK_USER_NAME'].$GLOBALS['dcrlf'];
		
        $message .= "Name:".$GLOBALS['crlf'];
		$message .= $ADK_HIKER['ADK_USER_NAME'].$GLOBALS['crlf'];
		$message .= "Username:".$GLOBALS['crlf'];
		$message .= $ADK_HIKER['ADK_USER_USERNAME'].$GLOBALS['crlf'];
		$message .= "Initial Password:".$GLOBALS['crlf'];
		$message .= $ADK_USER['ADK_USER_PASSWORD'].$GLOBALS['dcrlf'].$GLOBALS['dcrlf'];
				
		$message .= "Click <a href=\"./messages?_=".$ADK_HIKER['ADK_USER_ID']."\">here</a> to send the new user hiker a message.".$GLOBALS['dcrlf'];
		
		$ADK_MESSAGE = array(
			'ADK_MESSAGE_FROM_USER_ID' => 1,
	        'ADK_MESSAGE_TO_USER_ID' => $ADK_CORRESPONDENT_ID,
	        'ADK_MESSAGE_RESPOND_ID' => '',
	        'ADK_MESSAGE_ORIG_ID' => '',
			'ADK_MESSAGE_TITLE' => 'New Hiker - '.$ADK_HIKER['ADK_USER_USERNAME'],
			'ADK_MESSAGE_CONTENT' => $message
	    );
		
		addSysMessage($con, $ADK_MESSAGE);
	}
	
    function sendNewCorrPM($con, $ADK_USER, $randomPW){
		$message = "Username:".$GLOBALS['crlf'];
		$message .= $ADK_USER['ADK_USER_USERNAME'].$GLOBALS['dcrlf'];
		$message .= "Name:".$GLOBALS['crlf'];
		$message .= $ADK_USER['ADK_USER_NAME'].$GLOBALS['dcrlf'];
		$message .= "Email:".$GLOBALS['crlf'];
		$message .= $ADK_USER['ADK_USER_EMAIL'].$GLOBALS['dcrlf'];
		$message .= "Initial Password:".$GLOBALS['crlf'];
		$message .= $randomPW.$GLOBALS['dcrlf'];

		$message .= "Click <a href=\"./correspondent?_=".$ADK_USER['ADK_USER_ID']."\">here</a> to view.".$GLOBALS['dcrlf'];
		
		$ADK_MESSAGE = array(
			'ADK_MESSAGE_FROM_USER_ID' => 1,
	        'ADK_MESSAGE_TO_USER_ID' => 1,
	        'ADK_MESSAGE_RESPOND_ID' => '',
	        'ADK_MESSAGE_ORIG_ID' => '',
			'ADK_MESSAGE_TITLE' => 'New Correspondent - '.$ADK_USER['ADK_USER_USERNAME'],
			'ADK_MESSAGE_CONTENT' => $message
	    );
		
		addSysMessage($con, $ADK_MESSAGE);
	}

?>