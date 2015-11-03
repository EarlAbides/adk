<?php
	
	//Applicant
	function sendNewApplicantPM($con, $ADK_APPLICANT){
		$message = "Username:\r\n";
		$message .= $ADK_APPLICANT['ADK_APPLICANT_USERNAME']."\r\n\r\n";
		$message .= "Name:\r\n";
		$message .= $ADK_APPLICANT['ADK_APPLICANT_NAME']."\r\n\r\n";
		$message .= "Email:\r\n";
		$message .= $ADK_APPLICANT['ADK_APPLICANT_EMAIL']."\r\n\r\n";
		$message .= "Phone:r\n";
		$message .= $ADK_APPLICANT['ADK_APPLICANT_PHONE']."\r\n\r\n";
		$message .= "Age:\r\n";
		$message .= $ADK_APPLICANT['ADK_APPLICANT_AGE']."\r\n\r\n";
		$message .= "Sex:\r\n";
		$message .= $ADK_APPLICANT['ADK_APPLICANT_SEX']."\r\n\r\n";
		$message .= "Address 1:\r\n";
		$message .= $ADK_APPLICANT['ADK_APPLICANT_ADDRESS1']."\r\n\r\n";
		$message .= "Address 2:\r\n";;
		$message .= $ADK_APPLICANT['ADK_APPLICANT_ADDRESS2']."\r\n\r\n";
		$message .= "City:\r\n";
		$message .= $ADK_APPLICANT['ADK_APPLICANT_CITY']."\r\n\r\n";
		$message .= "State:\r\n";
		$message .= $ADK_APPLICANT['ADK_APPLICANT_STATE']."\r\n\r\n";
		$message .= "Zip:\r\n";
		$message .= $ADK_APPLICANT['ADK_APPLICANT_ZIP']."\r\n\r\n";
		$message .= "Country:\r\n";
		$message .= $ADK_APPLICANT['ADK_APPLICANT_COUNTRY']."\r\n\r\n";
		$message .= "Personal info:\r\n";
		$message .= $ADK_APPLICANT['ADK_APPLICANT_PERSONALINFO']."\r\n\r\n";
		$message .= "Requested Correspondent:\r\n";
		$message .= $ADK_APPLICANT['ADK_APPLICANT_REQ_CORR']."\r\n\r\n";
		$message .= "Peaks:\r\n";
		$message .= $ADK_APPLICANT['ADK_APPLICANT_PEAKLIST']."\r\n\r\n";
		$message .= "Click <a href=\"./applicant?_=".$ADK_APPLICANT['ADK_APPLICANT_ID']."\">here</a> to view."."\r\n\r\n";
		
		$ADK_MESSAGE = array(
			'ADK_MESSAGE_FROM_USER_ID' => 1
	        ,'ADK_MESSAGE_TO_USER_ID' => 1
	        ,'ADK_MESSAGE_RESPOND_ID' => ''
	        ,'ADK_MESSAGE_ORIG_ID' => ''
			,'ADK_MESSAGE_TITLE' => 'New Applicant  - '.$ADK_APPLICANT['ADK_APPLICANT_USERNAME']
			,'ADK_MESSAGE_CONTENT' => $message
			,'ADK_MESSAGE_DRAFT' => 0
	    );
		
		addSysMessage($con, $ADK_MESSAGE);
	}
	
	//Correspondent
	function sendCorrNewHikerPM($con, $ADK_CORRESPONDENT_ID, $ADK_USER, $ADK_HIKER){
		$message = "Your have been assigned a new hiker!"."\r\n\r\n";
		
		$message .= "Name:\r\n";
		$message .= $ADK_HIKER['ADK_USER_NAME']."\r\n";
		$message .= "Username:\r\n";
		$message .= $ADK_HIKER['ADK_USER_USERNAME']."\r\n";
		$message .= "Initial Password:\r\n";
		$message .= $ADK_USER['ADK_USER_PASSWORD']."\r\n\r\n"."\r\n\r\n";

		$message .= "Personal info:\r\n";
		$message .= $ADK_HIKER['ADK_HIKER_PERSONALINFO']."\r\n\r\n";
		$message .= "Peaks:\r\n";
		$message .= $ADK_HIKER['ADK_HIKER_PEAKLIST']."\r\n\r\n"."\r\n\r\n";
				
		$message .= "Click <a href=\"./messages?_=".$ADK_HIKER['ADK_USER_ID']."\">here</a> to send the new user hiker a message."."\r\n\r\n";
		
		$ADK_MESSAGE = array(
			'ADK_MESSAGE_FROM_USER_ID' => 1
	        ,'ADK_MESSAGE_TO_USER_ID' => $ADK_CORRESPONDENT_ID
	        ,'ADK_MESSAGE_RESPOND_ID' => ''
	        ,'ADK_MESSAGE_ORIG_ID' => ''
			,'ADK_MESSAGE_TITLE' => 'New Hiker - '.$ADK_HIKER['ADK_USER_USERNAME']
			,'ADK_MESSAGE_CONTENT' => $message
			,'ADK_MESSAGE_DRAFT' => 0
	    );
		
		addSysMessage($con, $ADK_MESSAGE);
	}
	
    function sendNewCorrPM($con, $ADK_USER, $randomPW){
		$message = "Username:\r\n";
		$message .= $ADK_USER['ADK_USER_USERNAME']."\r\n\r\n";
		$message .= "Name:\r\n";
		$message .= $ADK_USER['ADK_USER_NAME']."\r\n\r\n";
		$message .= "Email:\r\n";
		$message .= $ADK_USER['ADK_USER_EMAIL']."\r\n\r\n";
		$message .= "Initial Password:\r\n";
		$message .= $randomPW."\r\n\r\n";

		$message .= "Click <a href=\"./correspondent?_=".$ADK_USER['ADK_USER_ID']."\">here</a> to view."."\r\n\r\n";
		
		$ADK_MESSAGE = array(
			'ADK_MESSAGE_FROM_USER_ID' => 1
	        ,'ADK_MESSAGE_TO_USER_ID' => 1
	        ,'ADK_MESSAGE_RESPOND_ID' => ''
	        ,'ADK_MESSAGE_ORIG_ID' => ''
			,'ADK_MESSAGE_TITLE' => 'New Correspondent - '.$ADK_USER['ADK_USER_USERNAME']
			,'ADK_MESSAGE_CONTENT' => $message
			,'ADK_MESSAGE_DRAFT' => 0
	    );
		
		addSysMessage($con, $ADK_MESSAGE);
	}

?>