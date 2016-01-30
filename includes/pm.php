<?php
	
	//Applicant
	function sendNewApplicantPM($con, $ADK_APPLICANT){
		$message = "Username:<br>";
		$message .= $ADK_APPLICANT->username."<br><br>";
		$message .= "Name:<br>";
		$message .= $ADK_APPLICANT->name."<br><br>";
		$message .= "Email:<br>";
		$message .= $ADK_APPLICANT->email."<br><br>";
		$message .= "Phone:r\n";
		$message .= $ADK_APPLICANT->phone."<br><br>";
		$message .= "Age:<br>";
		$message .= $ADK_APPLICANT->age."<br><br>";
		$message .= "Sex:<br>";
		$message .= $ADK_APPLICANT->sex."<br><br>";
		$message .= "Address 1:<br>";
		$message .= $ADK_APPLICANT->address1."<br><br>";
		$message .= "Address 2:<br>";;
		$message .= $ADK_APPLICANT->address2."<br><br>";
		$message .= "City:<br>";
		$message .= $ADK_APPLICANT->city."<br><br>";
		$message .= "State:<br>";
		$message .= $ADK_APPLICANT->state."<br><br>";
		$message .= "Zip:<br>";
		$message .= $ADK_APPLICANT->zip."<br><br>";
		$message .= "Country:<br>";
		$message .= $ADK_APPLICANT->country."<br><br>";
		$message .= "Personal info:<br>";
		$message .= $ADK_APPLICANT->info."<br><br>";
		$message .= "Requested Correspondent:<br>";
		$message .= $ADK_APPLICANT->reqcorr."<br><br>";
		$message .= "Peaks:<br>";
		$message .= $ADK_APPLICANT->peaklist."<br><br>";
		$message .= "Click <a href=\"./applicant?_=".$ADK_APPLICANT->id."\">here</a> to view."."<br><br>";
		
		$ADK_MESSAGE = array(
			'ADK_MESSAGE_FROM_USER_ID' => 1
	        ,'ADK_MESSAGE_TO_USER_ID' => 1
	        ,'ADK_MESSAGE_RESPOND_ID' => ''
	        ,'ADK_MESSAGE_ORIG_ID' => ''
			,'ADK_MESSAGE_TITLE' => 'New Applicant  - '.$ADK_APPLICANT->name
			,'ADK_MESSAGE_CONTENT' => $message
			,'ADK_MESSAGE_DRAFT' => 0
	    );
		
		addSysMessage($con, $ADK_MESSAGE);
	}
	
	//Correspondent
	function sendCorrNewHikerPM($con, $ADK_USER, $ADK_HIKER, $ADK_APPLICANT){
		$message = "Your have been assigned a new hiker!"."<br><br>";
		
		$message .= "Name:<br>";
		$message .= $ADK_USER->name."<br>";
		$message .= "Username:<br>";
		$message .= $ADK_USER->username."<br>";
		$message .= "Initial Password:<br>";
		$message .= $ADK_USER->pw."<br><br>"."<br><br>";

		$message .= "Personal info:<br>";
		$message .= $ADK_HIKER->info."<br><br>";
		$message .= "Peaks:<br>";
		$message .= $ADK_APPLICANT->peaklist."<br><br>"."<br><br>";
				
		$message .= "Click <a href=\"./messages?_=".$ADK_USER->id."\">here</a> to send the new user hiker a message."."<br><br>";
		
		$ADK_MESSAGE = array(
			'ADK_MESSAGE_FROM_USER_ID' => 1
	        ,'ADK_MESSAGE_TO_USER_ID' => $ADK_HIKER->corrid
	        ,'ADK_MESSAGE_RESPOND_ID' => ''
	        ,'ADK_MESSAGE_ORIG_ID' => ''
			,'ADK_MESSAGE_TITLE' => 'New Hiker - '.$ADK_USER->username
			,'ADK_MESSAGE_CONTENT' => $message
			,'ADK_MESSAGE_DRAFT' => 0
	    );
		
		addSysMessage($con, $ADK_MESSAGE);
	}
	
    function sendNewCorrPM($con, $ADK_USER, $randomPW){
		$message = "Username:<br>";
		$message .= $ADK_USER->username."<br><br>";
		$message .= "Name:<br>";
		$message .= $ADK_USER->name."<br><br>";
		$message .= "Email:<br>";
		$message .= $ADK_USER->email."<br><br>";
		$message .= "Initial Password:<br>";
		$message .= $randomPW."<br><br>";

		$message .= "Click <a href=\"./correspondent?_=".$ADK_USER->id."\">here</a> to view."."<br><br>";
		
		$ADK_MESSAGE = array(
			'ADK_MESSAGE_FROM_USER_ID' => 1
	        ,'ADK_MESSAGE_TO_USER_ID' => 1
	        ,'ADK_MESSAGE_RESPOND_ID' => ''
	        ,'ADK_MESSAGE_ORIG_ID' => ''
			,'ADK_MESSAGE_TITLE' => 'New Correspondent - '.$ADK_USER->username
			,'ADK_MESSAGE_CONTENT' => $message
			,'ADK_MESSAGE_DRAFT' => 0
	    );
		
		addSysMessage($con, $ADK_MESSAGE);
	}

	function sendCorrHikeAddUpdatePM($con, $ADK_HIKER, $ADK_CORRESPONDENT, $ADK_HIKE, $isUpdate){
		$headerTxt = '';
		$title = '';

		if($isUpdate){
			$headerTxt = "One of your hikers has updated a hike log!<br><br>";
			$title = "Hike log updated - ".$ADK_HIKER['ADK_USER_USERNAME'];
		}
		else{
			$headerTxt = "One of your hikers has added a hike log!<br><br>";
			$title = "Hike log added - ".$ADK_HIKER['ADK_USER_USERNAME'];
		}

		$message = $headerTxt;
		
		$message .= $ADK_HIKER['ADK_USER_NAME']." (".$ADK_HIKER['ADK_USER_USERNAME'].")<br>";
	    $message .= $ADK_HIKE['peakNames']."<br><br>";

		$message .= "Click <a href=\"".$GLOBALS['url']."hiker?_=".$ADK_HIKER['ADK_USER_ID']."#".$ADK_HIKE['ADK_HIKE_ID']."\">here to see it</a>.<br><br>";
		
		$ADK_MESSAGE = array(
			'ADK_MESSAGE_FROM_USER_ID' => 1
	        ,'ADK_MESSAGE_TO_USER_ID' => $ADK_CORRESPONDENT['ADK_USER_ID']
	        ,'ADK_MESSAGE_RESPOND_ID' => ''
	        ,'ADK_MESSAGE_ORIG_ID' => ''
			,'ADK_MESSAGE_TITLE' => $title
			,'ADK_MESSAGE_CONTENT' => $message
			,'ADK_MESSAGE_DRAFT' => 0
	    );
		
		addSysMessage($con, $ADK_MESSAGE);
	}

?>