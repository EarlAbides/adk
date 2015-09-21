<?php
	
	//Includes
	require_once 'PHPMailer/PHPMailerAutoload.php';
	
	function PHPMailer($toAddr, $subject, $htmlmessage, $message){
		$mail = new PHPMailer();
		
		$mail->isSMTP();
		//$mail->Host = 'sites.nearlyfreespeech.net';
		$mail->Host = 'smtp.gmail.com';
		$mail->SMTPAuth = true;
		$mail->Username = 'adk46ertrailswm@gmail.com';
		$mail->Password = '123Abbey';
		$mail->SMTPSecure = 'ssl';
		$mail->Port = 465;
		
		$mail->From = 'noreply@adk.nfshost.com';
		$mail->FromName = 'ADK46er Correspondence Website';
		$mail->addAddress($toAddr);
		
		$mail->isHTML(true);
		
		$mail->Subject = $subject;
		$mail->Body = $htmlmessage;
		$mail->AltBody = $message;
		
		$mail->send();
	}
		
	//Applicant
	function sendNewApplicantEmail($ADK_APPLICANT){
		$htmlmessage = "Username:<br>";
		$htmlmessage .= $ADK_APPLICANT['ADK_APPLICANT_USERNAME']."<br><br>";
		$htmlmessage .= "Name:<br>";
		$htmlmessage .= $ADK_APPLICANT['ADK_APPLICANT_NAME']."<br><br>";
		$htmlmessage .= "Email:<br>";
		$htmlmessage .= $ADK_APPLICANT['ADK_APPLICANT_EMAIL']."<br><br>";
		$htmlmessage .= "Phone:<br>";
		$htmlmessage .= $ADK_APPLICANT['ADK_APPLICANT_PHONE']."<br><br>";
		$htmlmessage .= "Age:<br>";
		$htmlmessage .= $ADK_APPLICANT['ADK_APPLICANT_AGE']."<br><br>";
		$htmlmessage .= "Sex:<br>";
		$htmlmessage .= $ADK_APPLICANT['ADK_APPLICANT_SEX']."<br><br>";
		$htmlmessage .= "Address 1:<br>";
		$htmlmessage .= $ADK_APPLICANT['ADK_APPLICANT_ADDRESS1']."<br><br>";
		$htmlmessage .= "Address 2:<br>";
		$htmlmessage .= $ADK_APPLICANT['ADK_APPLICANT_ADDRESS2']."<br><br>";
		$htmlmessage .= "City:<br>";
		$htmlmessage .= $ADK_APPLICANT['ADK_APPLICANT_CITY']."<br><br>";
		$htmlmessage .= "State:<br>";
		$htmlmessage .= $ADK_APPLICANT['ADK_APPLICANT_STATE']."<br><br>";
		$htmlmessage .= "Zip:<br>";
		$htmlmessage .= $ADK_APPLICANT['ADK_APPLICANT_ZIP']."<br><br>";
		$htmlmessage .= "Country:<br>";
		$htmlmessage .= $ADK_APPLICANT['ADK_APPLICANT_COUNTRY']."<br><br>";
		$htmlmessage .= "Total Peaks:<br>";
		$htmlmessage .= $ADK_APPLICANT['ADK_APPLICANT_NUMPEAKS']."<br><br>";
		$htmlmessage .= "Personal info:<br>";
		$htmlmessage .= $ADK_APPLICANT['ADK_APPLICANT_PERSONALINFO']."<br><br>";
		$htmlmessage .= "Requested Correspondent:<br>";
		$htmlmessage .= $ADK_APPLICANT['ADK_APPLICANT_REQ_CORR']."<br><br>";
		$htmlmessage .= "Click <a href=".$GLOBALS['url']."applicant?_=".$ADK_APPLICANT['ADK_APPLICANT_ID'].">here to open this user's profile</a>.<br><br>";	
		
		$message = "Username:\r\n";
		$message .= $ADK_APPLICANT['ADK_APPLICANT_USERNAME']."\r\n\r\n";
		$message .= "Name:\r\n";
		$message .= $ADK_APPLICANT['ADK_APPLICANT_NAME']."\r\n\r\n";
		$message .= "Email:\r\n";
		$message .= $ADK_APPLICANT['ADK_APPLICANT_EMAIL']."\r\n\r\n";
		$message .= "Phone:\r\n";
		$message .= $ADK_APPLICANT['ADK_APPLICANT_PHONE']."\r\n\r\n";
		$message .= "Age:\r\n";
		$message .= $ADK_APPLICANT['ADK_APPLICANT_AGE']."\r\n\r\n";
		$message .= "Sex:\r\n";
		$message .= $ADK_APPLICANT['ADK_APPLICANT_SEX']."\r\n\r\n";
		$message .= "Address 1:\r\n";
		$message .= $ADK_APPLICANT['ADK_APPLICANT_ADDRESS1']."\r\n\r\n";
		$message .= "Address 2:\r\n";
		$message .= $ADK_APPLICANT['ADK_APPLICANT_ADDRESS2']."\r\n\r\n";
		$message .= "City:\r\n";
		$message .= $ADK_APPLICANT['ADK_APPLICANT_CITY']."\r\n\r\n";
		$message .= "State:\r\n";
		$message .= $ADK_APPLICANT['ADK_APPLICANT_STATE']."\r\n\r\n";
		$message .= "Zip:\r\n";
		$message .= $ADK_APPLICANT['ADK_APPLICANT_ZIP']."\r\n\r\n";
		$message .= "Country:\r\n";
		$message .= $ADK_APPLICANT['ADK_APPLICANT_COUNTRY']."\r\n\r\n";
		$message .= "Total Peaks:\r\n";
		$message .= $ADK_APPLICANT['ADK_APPLICANT_NUMPEAKS']."\r\n\r\n";
		$message .= "Personal info:\r\n";
		$message .= $ADK_APPLICANT['ADK_APPLICANT_PERSONALINFO']."\r\n\r\n";
		$message .= "Requested Correspondent:\r\n";
		$message .= $ADK_APPLICANT['ADK_APPLICANT_REQ_CORR']."\r\n\r\n";
		$message .= "Click below to open this user's profile.\r\n";
		$message .= $GLOBALS['url']."applicant?_=".$ADK_APPLICANT['ADK_APPLICANT_ID']."\r\n\r\n";		
		
		$toAddr = $GLOBALS['adminEmail'];
		$subject = 'New Hiker Registration - '.$ADK_APPLICANT['ADK_APPLICANT_NAME'];
		
		PHPMailer($toAddr, $subject, $htmlmessage, $message);
	}
	
	//Correspondent
	function sendCorrNewHikerEmail($ADK_CORRESPONDENT_EMAIL, $ADK_USER, $ADK_HIKER){
		$htmlmessage = "Your have been assigned a new hiker!<br><br>";
		
        $htmlmessage .= "Name:<br>";
		$htmlmessage .= $ADK_HIKER['ADK_USER_NAME']."<br>";
		$htmlmessage .= "Username:<br>";
		$htmlmessage .= $ADK_HIKER['ADK_USER_USERNAME']."<br>";
		$htmlmessage .= "Initial Password:<br>";
		$htmlmessage .= $ADK_USER['ADK_USER_PASSWORD']."<br><br>";

        $htmlmessage .= "First Peak: ".$ADK_HIKER['ADK_HIKER_FIRSTPEAK_NAME']."<br>";
        $htmlmessage .= "Date: ".$ADK_HIKER['ADK_HIKER_FIRSTPEAK_DTE']."<br><br>";
		
		$htmlmessage .= "Click <a href=".$GLOBALS['url']."messages?_=".$ADK_HIKER['ADK_USER_ID'].">here to send the new user a message</a>.<br><br>";	
	    
		$message = "Your have been assigned a new hiker!\r\n\r\n";
		
        $message .= "Name:\r\n";
		$message .= $ADK_HIKER['ADK_USER_NAME']."\r\n";
		$message .= "Username:\r\n";
		$message .= $ADK_HIKER['ADK_USER_USERNAME']."\r\n";
		$message .= "Initial Password:\r\n";
		$message .= $ADK_USER['ADK_USER_PASSWORD']."\r\n\r\n";

        $message .= "First Peak: ".$ADK_HIKER['ADK_HIKER_FIRSTPEAK_NAME']."\r\n";
        $message .= "Date: ".$ADK_HIKER['ADK_HIKER_FIRSTPEAK_DTE']."\r\n\r\n";
		
		$message .= "Click below to send the new user a message:\r\n".$GLOBALS['url']."messages?_=".$ADK_HIKER['ADK_USER_ID']."\r\n\r\n";
		
		$toAddr = $ADK_CORRESPONDENT_EMAIL;
		$subject = 'New Hiker - '.$ADK_HIKER['ADK_USER_USERNAME'];
		
		PHPMailer($toAddr, $subject, $htmlmessage, $message);
	}
	
    function sendOldCorrReassignEmail($ADK_CORRESPONDENT, $ADK_HIKER){
		$htmlmessage = "One of your hikers has been reassigned to a new Staff Correspondent!<br><br>";
		
		$htmlmessage .= "Username:<br>";
		$htmlmessage .= $ADK_HIKER['ADK_USER_USERNAME']."<br>";
		$htmlmessage .= "Name:<br>";
		$htmlmessage .= $ADK_HIKER['ADK_USER_NAME']."<br><br>";
		
        $htmlmessage .= "If you believe that this was done in error, please contact the site administrator at <a href=\"mailto:".$GLOBALS['adminEmail']."\">".$GLOBALS['adminEmail']."</a>.<br><br>";	
	
        $message = "One of your hikers has been reassigned to a new Staff Correspondent!\r\n\r\n";
		
        $message .= "Username:\r\n";
        $message .= $ADK_HIKER['ADK_USER_USERNAME']."\r\n";
        $message .= "Name:\r\n";
        $message .= $ADK_HIKER['ADK_USER_NAME']."\r\n\r\n";
		
        $message .= "If you believe that this was done in error, please contact the site administrator at ".$GLOBALS['adminEmail'].".<br><br>";
		
		$toAddr = $ADK_CORRESPONDENT['ADK_USER_EMAIL'];
		$subject = 'Hiker Reassignment - '.$ADK_HIKER['ADK_USER_USERNAME'];
		
		PHPMailer($toAddr, $subject, $htmlmessage, $message);
	}
	
    function sendNewCorrReassignEmail($ADK_CORRESPONDENT, $ADK_HIKER){
		$htmlmessage = "A hiker has been reassigned to you!<br><br>";
		
		$htmlmessage .= "Username:<br>";
		$htmlmessage .= $ADK_HIKER['ADK_USER_USERNAME']."<br>";
		$htmlmessage .= "Name:<br>";
		$htmlmessage .= $ADK_HIKER['ADK_USER_NAME']."<br><br>";
		
        $htmlmessage .= "If you believe that this was done in error, please contact the site administrator at <a href=\"mailto:".$GLOBALS['adminEmail']."\">".$GLOBALS['adminEmail']."</a>.<br><br>";	
	
        $message = "A hiker has been reassigned to you!\r\n\r\n";
		
        $message .= "Username:\r\n";
        $message .= $ADK_HIKER['ADK_USER_USERNAME']."\r\n";
        $message .= "Name:\r\n";
        $message .= $ADK_HIKER['ADK_USER_NAME']."\r\n\r\n";
		
        $message .= "If you believe that this was done in error, please contact the site administrator at ".$GLOBALS['adminEmail'].".<br><br>";
		
		$toAddr = $ADK_CORRESPONDENT['ADK_USER_EMAIL'];
		$subject = 'Hiker Reassignment - '.$ADK_HIKER['ADK_USER_USERNAME'];
		
		PHPMailer($toAddr, $subject, $htmlmessage, $message);
	}

    function sendNewCorrEmail($ADK_USER, $randomPW){
        $htmlmessage = "Your 46er Staff Corresondent account has been created!<br><br>";
		
		$htmlmessage .= "Username:<br>";
		$htmlmessage .= $ADK_USER['ADK_USER_USERNAME']."<br><br>";
		$htmlmessage .= "Initial Password:<br>";
		$htmlmessage .= $randomPW."<br><br><br><br>";
		
		$htmlmessage .= "Click <a href=".$GLOBALS['url'].">here to visit the site and log in</a>.<br><br>";
		
		$message = "Your 46er Staff Corresondent account has been created!\r\n\r\n";
		
		$message .= "Username:\r\n";
		$message .= $ADK_USER['ADK_USER_USERNAME']."\r\n\r\n";
		$message .= "Initial Password:\r\n";
		$message .= $randomPW."\r\n\r\n\r\n\r\n";

		$message .= "Click below to visit the site and log in:\r\n".$GLOBALS['url']."\r\n\r\n";
				
		$toAddr = $ADK_USER['ADK_USER_EMAIL'];
		$subject = 'Staff Correspondent Account Created - '.$ADK_USER['ADK_USER_USERNAME'];
		
		PHPMailer($toAddr, $subject, $htmlmessage, $message);
    }

	//Hiker
	function sendNewHikerEmail($ADK_USER, $ADK_CORRESPONDENT){
		$htmlmessage = "Your account had been created and you have been assigned a correspondent!<br><br>";
		
		$htmlmessage .= "Username:<br>";
		$htmlmessage .= $ADK_USER['ADK_USER_USERNAME']."<br><br>";
		$htmlmessage .= "Initial Password:<br>";
		$htmlmessage .= $ADK_USER['ADK_USER_PASSWORD']."<br><br><br><br>";
		
		$htmlmessage .= "Your Staff Correspondent's name is ".$ADK_CORRESPONDENT['ADK_USER_NAME'].".<br>";
        $htmlmessage .= "Username:<br>";
		$htmlmessage .= $ADK_CORRESPONDENT['ADK_USER_USERNAME']."<br><br>";
		$htmlmessage .= "Email:<br>";
		$htmlmessage .= "<a href=\"mailto:".$ADK_CORRESPONDENT['ADK_USER_EMAIL']."\">".$ADK_CORRESPONDENT['ADK_USER_EMAIL']."</a><br><br><br><br>";

		$htmlmessage .= "Click <a href=".$GLOBALS['url'].">here to visit the site and log in</a>.<br><br>";
		
		$message = "Your account had been created and you have been assigned a correspondent!\r\n\r\n";
		
		$message .= "Username:\r\n";
		$message .= $ADK_USER['ADK_USER_USERNAME']."\r\n\r\n";
		$message .= "Initial Password:\r\n";
		$message .= $ADK_USER['ADK_USER_PASSWORD']."\r\n\r\n\r\n\r\n";
		
		$message .= "Your Staff Correspondent's name is ".$ADK_CORRESPONDENT['ADK_USER_NAME'].".\r\n";
        $message .= "Username:<br>";
		$message .= $ADK_CORRESPONDENT['ADK_USER_USERNAME']."\r\n\r\n";
		$message .= "Email:<br>";
		$message .= $ADK_CORRESPONDENT['ADK_USER_EMAIL']."\r\n\r\n\r\n\r\n";

		$message .= "Click below to visit the site and log in:\r\n".$GLOBALS['url']."\r\n\r\n";
				
		$toAddr = $ADK_USER['ADK_USER_EMAIL'];
		$subject = 'New Account Created - '.$ADK_USER['ADK_USER_USERNAME'];
		
		PHPMailer($toAddr, $subject, $htmlmessage, $message);
	}

	function send46erCompletionEmail($ADK_USER){
		$url = 'http://adk46er.org/how-to-join.html';
		
		$htmlmessage = "Congratulations!<br><br>";
		
		$htmlmessage .= "Hey I need text for this.<br>";
		$htmlmessage .= "Click <a href=\"$url\">here</a> to see how to become a registered 46er.<br><br>";
		
		$message = "Congratulations!\r\n\r\n";
		
		$message .= "Hey I need text for this.\r\n";
		$message .= "Visit $url to see how to become a registered 46er.\r\n\r\n";
		
		$toAddr = $ADK_USER['ADK_USER_EMAIL'];
		$subject = 'Congratulations - '.$ADK_USER['ADK_USER_NAME'];
		
		PHPMailer($toAddr, $subject, $htmlmessage, $message);
	}

    function sendHikerCorrReassignEmail($ADK_HIKER, $ADK_CORRESPONDENT){
		$htmlmessage = "You have been reassigned to a new Staff Correspondent!<br><br>";
		
		$htmlmessage .= "Username:<br>";
		$htmlmessage .= $ADK_HIKER['ADK_USER_USERNAME']."<br>";
		$htmlmessage .= "Name:<br>";
		$htmlmessage .= $ADK_HIKER['ADK_USER_NAME']."<br><br>";
		
        $htmlmessage .= "If you believe that this was done in error, please contact the site administrator at <a href=\"mailto:".$GLOBALS['adminEmail']."\">".$GLOBALS['adminEmail']."</a>.<br><br>";	
	
        $message = "You have been reassigned to a new Staff Correspondent!\r\n\r\n";
		
        $message .= "Username:\r\n";
        $message .= $ADK_CORRESPONDENT['ADK_USER_USERNAME']."\r\n";
        $message .= "Name:\r\n";
        $message .= $ADK_CORRESPONDENT['ADK_USER_NAME']."\r\n\r\n";
		
        $message .= "If you believe that this was done in error, please contact the site administrator at ".$GLOBALS['adminEmail'].".<br><br>";
		
		$toAddr = $ADK_HIKER['ADK_USER_EMAIL'];
		$subject = 'Hiker Reassignment - '.$ADK_CORRESPONDENT['ADK_USER_USERNAME'];
		
		PHPMailer($toAddr, $subject, $htmlmessage, $message);
	}

	
	//Message
	function sendPMNotifyEmail($ADK_MESSAGE, $ADK_MESSAGE_TO_EMAIL){
        $url = $GLOBALS['url'].'messages';
        
		$htmlmessage = "You have a Private Message waiting for you on the ADK 46er Correspondence Website from:<br>";
		$htmlmessage .= $ADK_MESSAGE['ADK_MESSAGE_FROM_NAME']."<br>";
		$htmlmessage .= "(".$ADK_MESSAGE['ADK_MESSAGE_FROM_USERNAME'].")<br><br>";
		
		$htmlmessage .= "-----------------------------------<br>";
		$htmlmessage .= "Log in to <a href=\"".$GLOBALS['url']."\">".$GLOBALS['url']."</a> now to reply!<br><br><br><br>";
		
		$message = "You have a Private Message waiting for you on the ADK 46er Correspondence Website from:\r\n";
		$message .= $ADK_MESSAGE['ADK_MESSAGE_FROM_NAME']." (".$ADK_MESSAGE['ADK_MESSAGE_FROM_USERNAME'].")\r\n\r\n";
		
		$message .= "-----------------------------------\r\n";
		$message .= "Log in to ".$url." now to reply!\r\n\r\n\r\n\r\n";
			
		$toAddr = $ADK_MESSAGE_TO_EMAIL;
		$subject = 'You have received a Private Message';
		
		PHPMailer($toAddr, $subject, $htmlmessage, $message);
	}
	
	//User
	function sendPWResetLinkEmail($ADK_USER){
		$url = $GLOBALS['url']."forgot?__=".$ADK_USER['last8hash'].$ADK_USER['ADK_USER_ID'];
		
		$htmlmessage = $ADK_USER['ADK_USER_NAME'].",<br><br>";
		$htmlmessage .= "You (or someone) requested a password for your account on ".$GLOBALS['url'].".<br>";
		$htmlmessage .= "If this was not you, please ignore this email. Otherwise, <a href=\"".$url."\">click here to reset your password and log in</a>.<br><br>";
		
		$message = $ADK_USER['ADK_USER_NAME'].",\r\n\r\n";
		$message .= "You (or someone) requested a password for your account on ".$GLOBALS['url'].".\r\n";
		$message .= "If this was not you, please ignore this email. Otherwise, click below to reset your password and log in:\r\n";
		$message .= $url."\r\n\r\n";
				
		$toAddr = $ADK_USER['ADK_USER_EMAIL'];
		$subject = 'Reset Your Password';
		
		PHPMailer($toAddr, $subject, $htmlmessage, $message);
	}
	
?>