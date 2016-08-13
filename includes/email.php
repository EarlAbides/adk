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
		$mail->Password = '123Abbey!';
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
		$htmlmessage .= $ADK_APPLICANT->username."<br><br>";
		$htmlmessage .= "Name:<br>";
		$htmlmessage .= $ADK_APPLICANT->name."<br><br>";
		$htmlmessage .= "Email:<br>";
		$htmlmessage .= $ADK_APPLICANT->email."<br><br>";
		$htmlmessage .= "Phone:<br>";
		$htmlmessage .= $ADK_APPLICANT->phone."<br><br>";
		$htmlmessage .= "Age:<br>";
		$htmlmessage .= $ADK_APPLICANT->age."<br><br>";
		$htmlmessage .= "Sex:<br>";
		$htmlmessage .= $ADK_APPLICANT->sex."<br><br>";
		$htmlmessage .= "Address 1:<br>";
		$htmlmessage .= $ADK_APPLICANT->address1."<br><br>";
		$htmlmessage .= "Address 2:<br>";
		$htmlmessage .= $ADK_APPLICANT->address2."<br><br>";
		$htmlmessage .= "City:<br>";
		$htmlmessage .= $ADK_APPLICANT->city."<br><br>";
		$htmlmessage .= "State:<br>";
		$htmlmessage .= $ADK_APPLICANT->state."<br><br>";
		$htmlmessage .= "Zip:<br>";
		$htmlmessage .= $ADK_APPLICANT->zip."<br><br>";
		$htmlmessage .= "Country:<br>";
		$htmlmessage .= $ADK_APPLICANT->country."<br><br>";
		$htmlmessage .= "Personal info:<br>";
		$htmlmessage .= $ADK_APPLICANT->info."<br><br>";
		$htmlmessage .= "Requested Correspondent:<br>";
		$htmlmessage .= $ADK_APPLICANT->reqcorr."<br><br>";
		$htmlmessage .= "Peaks:<br>";
		$htmlmessage .= $ADK_APPLICANT->peaklist."<br><br>";
		$htmlmessage .= "Click <a href=".$GLOBALS['url']."applicant?_=".$ADK_APPLICANT->id.">here to open this user's profile</a>.<br><br>";	
		
		$message = "Username:\r\n";
		$message .= $ADK_APPLICANT->username."\r\n\r\n";
		$message .= "Name:\r\n";
		$message .= $ADK_APPLICANT->name."\r\n\r\n";
		$message .= "Email:\r\n";
		$message .= $ADK_APPLICAN->email."\r\n\r\n";
		$message .= "Phone:\r\n";
		$message .= $ADK_APPLICANT->phone."\r\n\r\n";
		$message .= "Age:\r\n";
		$message .= $ADK_APPLICANT->age."\r\n\r\n";
		$message .= "Sex:\r\n";
		$message .= $ADK_APPLICANT->sex."\r\n\r\n";
		$message .= "Address 1:\r\n";
		$message .= $ADK_APPLICANT->address1."\r\n\r\n";
		$message .= "Address 2:\r\n";
		$message .= $ADK_APPLICANT->address2."\r\n\r\n";
		$message .= "City:\r\n";
		$message .= $ADK_APPLICANT->city."\r\n\r\n";
		$message .= "State:\r\n";
		$message .= $ADK_APPLICANT->state."\r\n\r\n";
		$message .= "Zip:\r\n";
		$message .= $ADK_APPLICANT->zip."\r\n\r\n";
		$message .= "Country:\r\n";
		$message .= $ADK_APPLICANT->country."\r\n\r\n";
		$message .= "Personal info:\r\n";
		$message .= $ADK_APPLICANT->info."\r\n\r\n";
		$message .= "Requested Correspondent:\r\n";
		$message .= $ADK_APPLICANT->reqcorr."\r\n\r\n";
		$message .= "Peaks:\r\n";
		$message .= $ADK_APPLICANT->peaklist."\r\n\r\n";
		$message .= "Click below to open this user's profile.\r\n";
		$message .= $GLOBALS['url']."applicant?_=".$ADK_APPLICANT->id."\r\n\r\n";		
		
		$toAddr = $GLOBALS['adminEmail'];
		$subject = 'New Hiker Registration - '.$ADK_APPLICANT->name;
		
		PHPMailer($toAddr, $subject, $htmlmessage, $message);
	}
	
	//Correspondent
	function sendCorrNewHikerEmail($ADK_CORRESPONDENT_EMAIL, $ADK_USER, $ADK_HIKER, $ADK_APPLICANT){
		$htmlmessage = "You have been assigned a new hiker!<br><br>";
		
        $htmlmessage .= "Name:<br>";
		$htmlmessage .= $ADK_USER->name."<br>";
		$htmlmessage .= "Username:<br>";
		$htmlmessage .= $ADK_USER->username."<br>";
		$htmlmessage .= "Personal info:<br>";
		$htmlmessage .= $ADK_HIKER->info."<br><br>";
		$htmlmessage .= "Peaks:<br>";
		$htmlmessage .= $ADK_APPLICANT->peaklist."<br><br>";
		
		$htmlmessage .= "Click <a href=".$GLOBALS['url']."messages?_=".$ADK_USER->id.">here to send the new user a message</a>.<br><br>";
	    
		$message = "You have been assigned a new hiker!\r\n\r\n";
		
        $message .= "Name:\r\n";
		$message .= $ADK_USER->name."\r\n";
		$message .= "Username:\r\n";
		$message .= $ADK_USER->username."\r\n";
		$message .= "Personal info:\r\n";
		$message .= $ADK_HIKER->info."\r\n\r\n";
		$message .= "Peaks:\r\n";
		$message .= $ADK_APPLICANT->peaklist."\r\n\r\n";
		
		$message .= "Click below to send the new user a message:\r\n".$GLOBALS['url']."messages?_=".$ADK_USER->id."\r\n\r\n";
		
		$toAddr = $ADK_CORRESPONDENT_EMAIL;
		$subject = 'New Hiker - '.$ADK_USER->username;
		
		PHPMailer($toAddr, $subject, $htmlmessage, $message);
	}
	
    function sendOldCorrReassignEmail($ADK_CORRESPONDENT, $ADK_HIKER){
		$htmlmessage = "One of your hikers has been reassigned to a new Staff Correspondent!<br><br>";
		
		$htmlmessage .= "Username:<br>";
		$htmlmessage .= $ADK_HIKER->username."<br>";
		$htmlmessage .= "Name:<br>";
		$htmlmessage .= $ADK_HIKER->name."<br><br>";
		
        $htmlmessage .= "If you believe that this was done in error, please contact the site administrator at <a href=\"mailto:".$GLOBALS['adminEmail']."\">".$GLOBALS['adminEmail']."</a>.<br><br>";	
	
        $message = "One of your hikers has been reassigned to a new Staff Correspondent!\r\n\r\n";
		
        $message .= "Username:\r\n";
        $message .= $ADK_HIKER->username."\r\n";
        $message .= "Name:\r\n";
        $message .= $ADK_HIKER->name."\r\n\r\n";
		
        $message .= "If you believe that this was done in error, please contact the site administrator at ".$GLOBALS['adminEmail'].".<br><br>";
		
		$toAddr = $ADK_CORRESPONDENT->email;
		$subject = 'Hiker Reassignment - '.$ADK_HIKER->username;
		
		PHPMailer($toAddr, $subject, $htmlmessage, $message);
	}
	
    function sendNewCorrReassignEmail($ADK_CORRESPONDENT, $ADK_HIKER){
		$htmlmessage = "A hiker has been reassigned to you!<br><br>";
		
		$htmlmessage .= "Username:<br>";
		$htmlmessage .= $ADK_HIKER->username."<br>";
		$htmlmessage .= "Name:<br>";
		$htmlmessage .= $ADK_HIKER->name."<br><br>";
		
        $htmlmessage .= "If you believe that this was done in error, please contact the site administrator at <a href=\"mailto:".$GLOBALS['adminEmail']."\">".$GLOBALS['adminEmail']."</a>.<br><br>";	
	
        $message = "A hiker has been reassigned to you!\r\n\r\n";
		
        $message .= "Username:\r\n";
        $message .= $ADK_HIKER->username."\r\n";
        $message .= "Name:\r\n";
        $message .= $ADK_HIKER->name."\r\n\r\n";
		
        $message .= "If you believe that this was done in error, please contact the site administrator at ".$GLOBALS['adminEmail'].".<br><br>";
		
		$toAddr = $ADK_CORRESPONDENT->email;
		$subject = 'Hiker Reassignment - '.$ADK_HIKER->username;
		
		PHPMailer($toAddr, $subject, $htmlmessage, $message);
	}
	
    function sendNewCorrEmail($ADK_USER, $randomPW){
		$url1 = "https://pogoplug.com/s/0Crhw6PdEjs/";
		$url2 = "http://adk.nfshost.com/signup";
		$url3 = "http://adk.nfshost.com/";
		
		////////////////////////

        $htmlmessage = "Hello new Correspondent! I wish to express my excitement and enthusiasm with the successful launch of the program and the rebirth of the 46er tradition. We have both long time veteran correspondents as well as many newbies here. I look forward to meeting you, and invite communication between correspondents. I fully believe in continued success and growth of this program. Let's have some fun!<br><br><br>";
		
		$htmlmessage .= "Your login information<br>";

		$htmlmessage .= "Username:<br>";
		$htmlmessage .= "<b>".$ADK_USER->username."</b><br><br>";
		$htmlmessage .= "Initial Password:<br>";
		$htmlmessage .= "<b>".$randomPW."</b><br><br>";
		$htmlmessage .= "It is recommended that you update your password and edit your profile upon first logging in.<br><br><br><br>";
		
		$htmlmessage .= "My name is Mark Simpson and together with my son Neil and support from so many wonderful people, we have built this program from scratch. Neil and I are fellow 46ers. It is our wish keep the correspondence program alive, and while honoring the old format we need to use digital technology because of what it can do for us. Although Grace has left us, let's always remember and honor this unique tradition of the Adirondack 46ers.<br><br>";
		$htmlmessage .= "I do my very best to distribute the hikers in a balanced and intelligent fashion. I have not refused any Hiker applicant, but will do so when I detect monkey business in the application, and have no issue barring a hiker upon your request (at the IP level). I can also easily reassign hikers to another correspondent. When all 46 peaks are logged, both hiker and correspondent will receive an email notice pointing them to the Office of the Historian and suggestions of giving back.<br><br><br>";

		$htmlmessage .= "I have created a cloud based folder for our use. It is available <a href=\"$url1\">here</a>. Please bookmark it. At this time, I have placed correspondence samples from years ago for you to look at to mimic or borrow verbiage, LNT info, a current Correspondents list and some other items.<br><br><br>";

		$htmlmessage .= "There is no intent to overwhelm anyone. However, hikers shouldn't wait too long for a response. It is a complete balance of I don't want to over task correspondents vs. I want the experience to be solid, consistent, professional, and available. Please don't get overly concerned if you get bunches of messages in a short period, because this will happen. I certainly don't care if you simply reply quickly and tell the Hiker you'll review and get back to them or something similar. It might have taken several weeks under the old system for the Correspondent to reply. However, I fully wish that every trip report garners a Correspondent response.<br><br>";
		$htmlmessage .= "This is how it works: Hiker messaging and logged hikes send an automated email to the Correspondent indicating that the Hiker logged a hike. This so the Correspondent can go online, see it, and perhaps message the Hiker (that is what I would hope you would do.). To avoid runaways or edits or multiple loggings creating and email notification frenzy, we have a 24 hour timer so that another email will not be sent for 24 hours after the last logging or edit of a hike. Further, all logs and edits have a date stamp on the Hiker page. Conversely, when a Correspondent sends a message to a Hiker, they get an automated email indicating a message from their Correspondent has been posted.<br><br><br>";

		$htmlmessage .= "Introduction letters and messaging - To facilitate a rapport with the Hiker, I ask that you, the Correspondent, send a message to the new Hiker as soon as possible after being notified. There are a couple templates that can be used when you are busy, but they are not complete. They are there to aid. Make each message special and meaningful to the Hiker, just like Grace did. I will not accept us acting like a computer generated response.<br><br>";
		$htmlmessage .= "Lack of response from a hiker - It's way too early to cooment on this other than to use your own judgement whether to send another follow up message. The site can handle as many users as we can throw at it, and we can work on filtering or making hiker groups for your convenience later next year.<br><br>";
		$htmlmessage .= "Hiker education - As stated above, there is information posted in the cloud location <a href=\"$url1\">here</a>. Please use forum this as an opportunity for education. It would be a shame to see all the good work that has been done in reseeding and getting the trails to where they are presently. We can and should do our part to toward Hiker education and turning neophytes into good 46ers.<br><br>";
		$htmlmessage .= "Hiking advice - This is the most difficult item we have, and it will come up as a question time and time again. Here is an excellent response:<br><br>";
		
		$htmlmessage .= "&emsp;<i>If I had confidence in a hiker and had established a relationship, I don't think I would have a problem telling them which route I took (if asked directly). It would include a little disclaimer and the plusses & minuses of any alternate routes. I would also tell them to read trip reports on the ADK High Peaks Forum to help them decide. I certainly wouldn't encourage anyone to go outside of their comfort zone. If you are really not comfortable offering your experience, then don't. I think you just have to do what you think is best based on the info you have to work with. Good luck!</i><br><br>";

		$htmlmessage .= "Hikers acknowledged a disclaimer at sign up. In the legal world, it means crap. If, for example, a correspondent tells a hiker, \"No problem, you can EASILY climb Saddleback from Basin in February, it's a piece of cake. You are real experienced, and HECK, I did it! My Mom did it! Probably won't even need cramp-ons!\" and the hiker gets hurt, we are in deep doo-doo, disclaimer or not. Straight to the point, don't give out trail advice. I like the statement above as he tells them what he did and then he points the hiker to a resource.<br><br><br>";

		$htmlmessage .= "Further, and as help if you have to be away for for a period, 10 days or more, I can easily move your the hikers to me until your return.<br><br><br><br>";


		$htmlmessage .= "Whereas you are now a Correspondent on the website, YOU HAVE NO HIKERS. There will be a test. I will not assign you any Hikers until you pass this test. I encourage for you to \"train\" by creating a hiker account so to 'see the other side'. Simply sign up <a href=\"$url2\">here</a> and create a Hiker Acct and name yourself as Correspondent. FYI, when you access a Hikers account or any table on the site, click on the magnifying glass to the left for more information. I will be sending you the test *soon*.<br><br><br>";

		$htmlmessage .= "Thanks for your desire to give back by being an ADK 46er Correspondent. You are the spirit of Grace Hudowalski and honor the unique tradition of the 46ers. Be mindful in your message towards conservation and preservation of the Adirondacks Mountains we are so privileged to share.<br><br><br><br>";

		$htmlmessage .= "Forward We Go!<br><br>";
		$htmlmessage .= "Best Regards,<br><br>";
		$htmlmessage .= "Mark Simpson #6038<br><br><br>";

		$htmlmessage .= "<a href=\"$url3\">$url3</a><br>";
		
		////////////////////////

		$message = "Hello new Correspondent! I wish to express my excitement and enthusiasm with the successful launch of the program and the rebirth of the 46er tradition. We have both long time veteran correspondents as well as many newbies here. I look forward to meeting you, and invite communication between correspondents. I fully believe in continued success and growth of this program. Let's have some fun!\r\n\r\n\r\n";
		
		$message .= "Your login information\r\n";

		$message .= "Username:\r\n";
		$message .= $ADK_USER->username."\r\n\r\n";
		$message .= "Initial Password:\r\n";
		$message .= $randomPW."\r\n";
		$message .= "It is recommended that you update your password and edit your profile upon first logging in.\r\n\r\n\r\n\r\n";

		$message .= "My name is Mark Simpson and together with my son Neil and support from so many wonderful people, we have built this program from scratch. Neil and I are fellow 46ers. It is our wish keep the correspondence program alive, and while honoring the old format we need to use digital technology because of what it can do for us. Although Grace has left us, let's always remember and honor this unique tradition of the Adirondack 46ers.\r\n\r\n";
		$message .= "I do my very best to distribute the hikers in a balanced and intelligent fashion. I have not refused any Hiker applicant, but will do so when I detect monkey business in the application, and have no issue barring a hiker upon your request (at the IP level). I can also easily reassign hikers to another correspondent. When all 46 peaks are logged, both hiker and correspondent will receive an email notice pointing them to the Office of the Historian and suggestions of giving back.\r\n\r\n";

		$message .= "I have created a cloud based folder for our use. It is available at $url1. Please bookmark it. At this time, I have placed correspondence samples from years ago for you to look at to mimic or borrow verbiage, LNT info, a current Correspondents list and some other items.\r\n\r\n\r\n";

		$message .= "There is no intent to overwhelm anyone. However, hikers shouldn't wait too long for a response. It is a complete balance of I don't want to over task correspondents vs. I want the experience to be solid, consistent, professional, and available. Please don't get overly concerned if you get bunches of messages in a short period, because this will happen. I certainly don't care if you simply reply quickly and tell the Hiker you'll review and get back to them or something similar. It might have taken several weeks under the old system for the Correspondent to reply. However, I fully wish that every trip report garners a Correspondent response.\r\n\r\n";
		$message .= "This is how it works: Hiker messaging and logged hikes send an automated email to the Correspondent indicating that the Hiker logged a hike. This so the Correspondent can go online, see it, and perhaps message the Hiker (that is what I would hope you would do.). To avoid runaways or edits or multiple loggings creating and email notification frenzy, we have a 24 hour timer so that another email will not be sent for 24 hours after the last logging or edit of a hike. Further, all logs and edits have a date stamp on the Hiker page. Conversely, when a Correspondent sends a message to a Hiker, they get an automated email indicating a message from their Correspondent has been posted.\r\n\r\n\r\n";

		$message .= "Introduction letters and messaging - To facilitate a rapport with the Hiker, I ask that you, the Correspondent, send a message to the new Hiker as soon as possible after being notified. There are a couple templates that can be used when you are busy, but they are not complete. They are there to aid. Make each message special and meaningful to the Hiker, just like Grace did. I will not accept us acting like a computer generated response.\r\n\r\n";
		$message .= "Lack of response from a hiker - It's way too early to cooment on this other than to use your own judgement whether to send another follow up message. The site can handle as many users as we can throw at it, and we can work on filtering or making hiker groups for your convenience later next year.\r\n\r\n";
		$message .= "Hiker education - As stated above, there is information posted in the cloud location at $url1. Please use forum this as an opportunity for education. It would be a shame to see all the good work that has been done in reseeding and getting the trails to where they are presently. We can and should do our part to toward Hiker education and turning neophytes into good 46ers.\r\n\r\n";
		$message .= "Hiking advice - This is the most difficult item we have, and it will come up as a question time and time again. Here is an excellent response:\r\n\r\n";
		
		$message .= "\tIf I had confidence in a hiker and had established a relationship, I don't think I would have a problem telling them which route I took (if asked directly). It would include a little disclaimer and the plusses & minuses of any alternate routes. I would also tell them to read trip reports on the ADK High Peaks Forum to help them decide. I certainly wouldn't encourage anyone to go outside of their comfort zone. If you are really not comfortable offering your experience, then don't. I think you just have to do what you think is best based on the info you have to work with. Good luck!\r\n\r\n";

		$message .= "Hikers acknowledged a disclaimer at sign up. In the legal world, it means crap. If, for example, a correspondent tells a hiker, \"No problem, you can EASILY climb Saddleback from Basin in February, it's a piece of cake. You are real experienced, and HECK, I did it! My Mom did it! Probably won't even need cramp-ons!\" and the hiker gets hurt, we are in deep doo-doo, disclaimer or not. Straight to the point, don't give out trail advice. I like the statement above as he tells them what he did and then he points the hiker to a resource.\r\n\r\n\r\n";

		$message .= "Further, and as help if you have to be away for for a period, 10 days or more, I can easily move your the hikers to me until your return.\r\n\r\n\r\n\r\n";


		$message .= "Whereas you are now a Correspondent on the website, YOU HAVE NO HIKERS. There will be a test. I will not assign you any Hikers until you pass this test. I encourage for you to \"train\" by creating a hiker account so to 'see the other side'. Simply sign up at $url2 and create a Hiker Acct and name yourself as Correspondent. FYI, when you access a Hikers account or any table on the site, click on the magnifying glass to the left for more information. I will be sending you the test *soon*.\r\n\r\n\r\n";

		$message .= "Thanks for your desire to give back by being an ADK 46er Correspondent. You are the spirit of Grace Hudowalski and honor the unique tradition of the 46ers. Be mindful in your message towards conservation and preservation of the Adirondacks Mountains we are so privileged to share.\r\n\r\n\r\n\r\n";

		$message .= "Forward We Go!\r\n\r\n";
		$message .= "Best Regards,\r\n\r\n";
		$message .= "Mark Simpson #6038\r\n\r\n";

		$message .= "$url3\r\n";

		////////////////////////
				
		$toAddr = $ADK_USER->email;
		$subject = 'Staff Correspondent Account Created - '.$ADK_USER->username;
		
		PHPMailer($toAddr, $subject, $htmlmessage, $message);
    }
	
	function sendCorrHikeAddUpdateEmail($ADK_HIKER, $ADK_CORRESPONDENT, $ADK_HIKE, $isUpdate){
	    $headerTxt = $isUpdate? 'One of your hikers has updated a hike log!': 'One of your hikers has added a hike log!';
		
		$htmlmessage = $headerTxt."<br><br>";
		
	    $htmlmessage .= $ADK_HIKER->name." (".$ADK_HIKER->username.")<br>";
	    $htmlmessage .= $ADK_HIKE->label."<br><br>";
		
	    $htmlmessage .= "Click <a href=".$GLOBALS['url']."hiker?_=".$ADK_HIKER->id."#".$ADK_HIKE->id.">here to see it</a>.<br><br>";
	    
	    $message = $headerTxt."\r\n\r\n";
		
	    $message .= $ADK_HIKER->name." (".$ADK_HIKER->username.")\r\n";
	    $message .= $ADK_HIKE->label."\r\n\r\n";
		
	    $message .= "Click below to see it:\r\n".$GLOBALS['url']."hiker?_=".$ADK_HIKER->id."#".$ADK_HIKE->id."\r\n\r\n";
		
	    $toAddr = $ADK_CORRESPONDENT->email;
	    $subject = $isUpdate? 'Hike Log Updated - '.$ADK_HIKER->username: 'Hike Log Added - '.$ADK_HIKER->username;
		
	    PHPMailer($toAddr, $subject, $htmlmessage, $message);
	}
	
	function sendCorr46erCompletionEmail($ADK_HIKER, $ADK_CORRESPONDENT){
		$url = 'http://adk46er.org/how-to-join.html';
		
		$htmlmessage = "One of your hikers just completed their 46!<br><br>";
		$htmlmessage .= $ADK_HIKER->name."<br><br>";
		
		$htmlmessage .= "Hey I need text for this.<br>";
		$htmlmessage .= "Click <a href=\"$url\">here</a> to see how to become a registered 46er.<br><br>";
		
		$message = "One of your hikers just completed their 46!\r\n\r\n";
		$message .= $ADK_HIKER->name."\r\n\r\n";
		
		$message .= "Hey I need text for this.\r\n";
		$message .= "Visit $url to see how to become a registered 46er.\r\n\r\n";
		
		$toAddr = $ADK_CORRESPONDENT->email;
		$subject = '46er Completion - '.$ADK_HIKER->username;
		
		PHPMailer($toAddr, $subject, $htmlmessage, $message);
	}
	
	//Hiker
	function sendNewHikerEmail($ADK_USER, $ADK_CORRESPONDENT){
		$htmlmessage = "Greetings Aspiring 46er,<br><br>";

		$htmlmessage .= "We welcome you to the Adirondack 46ers electronic correspondent program. We are excited you have chosen to take part in a 46er tradition that separates us from other hiking groups.  This historical convention was started by Grace Hudowalski 46er #9, first female 46er, and matriarch of our organization. We want to hear from you. We want to continue the traditions established by Grace. The 46ers are unique as the only mountain climbing organization that encourages its climbers to write about their hikes and accomplishments. Writing in your reports sets the 46ers apart.<br><br>";
		$htmlmessage .= "You will be able to list your mountains, post your pictures and tell us about your journey. Grace once said \"I do not want just a list of mountains, that was boring and climbing the high peaks is not boring.\" Grace wanted to hear about what you saw, how you felt, and details of your trip. We ask you to report often and fully immerse yourself in this experience. We are unpaid volunteers and there will be times of the year that we are very busy with hikers. So please be patient we will respond as quickly as we can.<br><br><br>";
		
		$htmlmessage .= "<b>Your login information</b><br><br>";

		$htmlmessage .= "Username:<br>";
		$htmlmessage .= "<b>".$ADK_USER->username."</b><br><br>";
		$htmlmessage .= "Initial Password:<br>";
		$htmlmessage .= "<b>".$ADK_USER->pw."</b><br><br><br><br>";

		$htmlmessage .= "This is how it works - Hiker messaging and logged hikes send an automated email to the Correspondent indicating the Hiker's post. This so the Correspondent can go online, see it, and message the Hiker. To avoid runaways or edits or multiple logging creating an email creation frenzy, we have a 24 hour timer so that another email will not be sent for 24 hours after the last logging or edit of a hike. Further, all logs and edits have a date stamp on the Hiker page. Conversely, when a Correspondent sends a message to a Hiker, they get an automated email indicating a message from their Correspondent has been posted. Post your picture once you log in so we can know what you look like! Also feel free to change your password under Edit Profile.<br><br>";
		
		$htmlmessage .= "Your Staff Correspondent's name is ".$ADK_CORRESPONDENT->name.".<br>";
        $htmlmessage .= "His/her username is ".$ADK_CORRESPONDENT->username.".<br><br>";
		
		$htmlmessage .= "We look forward to hearing from you and hope that you join us at our spring, fall, and winter meetings and meet us in person. Please volunteer in one or more of our projects and enjoy the experience of giving back.<br><br>";
		$htmlmessage .= "Our group of correspondents look forward to hearing from you and as Grace always said, \"We wish you good climbing\"<br>";


		$message = "Greetings Aspiring 46er,\r\n\r\n";

		$message .= "We welcome you to the Adirondack 46ers electronic correspondent program. We are excited you have chosen to take part in a 46er tradition that separates us from other hiking groups.  This historical convention was started by Grace Hudowalski 46er #9, first female 46er, and matriarch of our organization. We want to hear from you. We want to continue the traditions established by Grace. The 46ers are unique as the only mountain climbing organization that encourages its climbers to write about their hikes and accomplishments. Writing in your reports sets the 46ers apart.\r\n\r\n";
		$message .= "You will be able to list your mountains, post your pictures and tell us about your journey. Grace once said \"I do not want just a list of mountains, that was boring and climbing the high peaks is not boring.\" Grace wanted to hear about what you saw, how you felt, and details of your trip. We ask you to report often and fully immerse yourself in this experience. We are unpaid volunteers and there will be times of the year that we are very busy with hikers. So please be patient we will respond as quickly as we can.\r\n\r\n\r\n";
		
		$message .= "Your login information\r\n\r\n";
		
		$message .= "Username:\r\n";
		$message .= $ADK_USER->username."\r\n\r\n";
		$message .= "Initial Password:\r\n";
		$message .= $ADK_USER->pw."<br><br>\r\n\r\n";

		$message .= "This is how it works - Hiker messaging and logged hikes send an automated email to the Correspondent indicating the Hiker's post. This so the Correspondent can go online, see it, and message the Hiker. To avoid runaways or edits or multiple logging creating an email creation frenzy, we have a 24 hour timer so that another email will not be sent for 24 hours after the last logging or edit of a hike. Further, all logs and edits have a date stamp on the Hiker page. Conversely, when a Correspondent sends a message to a Hiker, they get an automated email indicating a message from their Correspondent has been posted. Post your picture once you log in so we can know what you look like! Also feel free to change your password under Edit Profile.\r\n\r\n";
		
		$message .= "Your Staff Correspondent's name is ".$ADK_CORRESPONDENT->name.".\r\n";
        $message .= "His/her username is ".$ADK_CORRESPONDENT->username.".\r\n\r\n";
		
		$message .= "We look forward to hearing from you and hope that you join us at our spring, fall, and winter meetings and meet us in person. Please volunteer in one or more of our projects and enjoy the experience of giving back.\r\n\r\n";
		$message .= "Our group of correspondents look forward to hearing from you and as Grace always said, \"We wish you good climbing\"\r\n";
				
		$toAddr = $ADK_USER->email;
		$subject = 'New Account Created - '.$ADK_USER->username;
		
		PHPMailer($toAddr, $subject, $htmlmessage, $message);
	}
	
	function send46erCompletionEmail($ADK_HIKER){
		$url = 'http://adk46er.org/how-to-join.html';
		$url2 = 'http://adk46er.org/trail-crew.html';
		
		$htmlmessage = "Congratulations! Successfully ascending the high 46 is a wonderful life accomplishment.<br><br>";
		
		$htmlmessage .= "It's been wonderful to have you here. We hope that you have made a friend with your correspondent and can get to meet him/her at either graduation at the 2017 Spring Meeting in Lake Placid or on the trails.<br><br>";
		
		$htmlmessage .= "Your next step is to register formally.<br>";
		$htmlmessage .= "Click <a href=\"$url\">here</a> to see how to become a registered 46er.<br><br>";

		$htmlmessage .= "Now that you have finished, you will still be able to access your account on this the Correspondent Program for records. However, you will not be able to send messages to your staff correspondent.<br><br>";
		$htmlmessage .= "But the journey does not need to end here. Learn more about the 46er organization and get involved. We sponsor many conservation efforts and do our part to support initiatives to keep this one of a kind experience available for the next generations. Teach people 'Leave No Trace' and 'Walk Softly' and set an example as a 46er.<br><br>";
		$htmlmessage .= "An easy and fun way to get involved is join a trail work session. The schedule is posted <a href=\"$url2\">here</a><br><br>";

		$htmlmessage .= "Another alternative to getting involved is becoming a correspondent within this program. This is a great way to make more friends and swap stories with the aspiring 46ers as you teach them the ways to walk softly and leave no trace. If interested please send an email to this website administrator.<br><br><br>";

		$htmlmessage .= "Forward we go!<br>";


		$message = "Congratulations! Successfully ascending the high 46 is a wonderful life accomplishment.\r\n\r\n";
		
		$message .= "It's been wonderful to have you here. We hope that you have made a friend with your correspondent and can get to meet him/her at either graduation at the 2017 Spring Meeting in Lake Placid or on the trails.\r\n\r\n";
		
		$message .= "Your next step is to register formally.\r\n";
		$message .= "Go to $url to see how to become a registered 46er.\r\n\r\n";

		$message .= "Now that you have finished, you will still be able to access your account on this the Correspondent Program for records. However, you will not be able to send messages to your staff correspondent.\r\n\r\n";
		$message .= "But the journey does not need to end here. Learn more about the 46er organization and get involved. We sponsor many conservation efforts and do our part to support initiatives to keep this one of a kind experience available for the next generations. Teach people 'Leave No Trace' and 'Walk Softly' and set an example as a 46er.\r\n\r\n";
		$message .= "An easy and fun way to get involved is join a trail work session. The schedule is posted at $url2\r\n\r\n";

		$message .= "Another alternative to getting involved is becoming a correspondent within this program. This is a great way to make more friends and swap stories with the aspiring 46ers as you teach them the ways to walk softly and leave no trace. If interested please send an email to this website administrator.\r\n\r\n\r\n";

		$message .= "Forward we go!\r\n";
		
		$toAddr = $ADK_HIKER->email;
		$subject = 'Congratulations - '.$ADK_HIKER->name;
		
		PHPMailer($toAddr, $subject, $htmlmessage, $message);
	}

    function sendHikerCorrReassignEmail($ADK_HIKER, $ADK_CORRESPONDENT){
		$htmlmessage = "You have been reassigned to a new Staff Correspondent!<br><br>";
		
		$htmlmessage .= "Username:<br>";
		$htmlmessage .= $ADK_HIKER->username."<br>";
		$htmlmessage .= "Name:<br>";
		$htmlmessage .= $ADK_HIKER->name."<br><br>";
		
        $htmlmessage .= "If you believe that this was done in error, please contact the site administrator at <a href=\"mailto:".$GLOBALS['adminEmail']."\">".$GLOBALS['adminEmail']."</a>.<br><br>";	
	
        $message = "You have been reassigned to a new Staff Correspondent!\r\n\r\n";
		
        $message .= "Username:\r\n";
        $message .= $ADK_CORRESPONDENT->username."\r\n";
        $message .= "Name:\r\n";
        $message .= $ADK_CORRESPONDENT->name."\r\n\r\n";
		
        $message .= "If you believe that this was done in error, please contact the site administrator at ".$GLOBALS['adminEmail'].".<br><br>";
		
		$toAddr = $ADK_HIKER->email;
		$subject = 'Hiker Reassignment - '.$ADK_CORRESPONDENT->username;
		
		PHPMailer($toAddr, $subject, $htmlmessage, $message);
	}
	
	//Message
	function sendPMNotifyEmail($ADK_MESSAGE, $ADK_USER){
        $url = $GLOBALS['url'].'messages';
        
		$htmlmessage = "You have a Private Message waiting for you on the ADK 46er Correspondence Website from:<br>";
		$htmlmessage .= $ADK_MESSAGE->fromname."<br>";
		$htmlmessage .= "(".$ADK_MESSAGE->fromusername.")<br><br>";
		
		$htmlmessage .= "-----------------------------------<br>";
		$htmlmessage .= "Log in to <a href=\"".$GLOBALS['url']."\">".$GLOBALS['url']."</a> now to reply!<br><br><br><br>";
		
		$message = "You have a Private Message waiting for you on the ADK 46er Correspondence Website from:\r\n";
		$message .= $ADK_MESSAGE->fromname." (".$ADK_MESSAGE->fromusername.")\r\n\r\n";
		
		$message .= "-----------------------------------\r\n";
		$message .= "Log in to ".$url." now to reply!\r\n\r\n\r\n\r\n";
			
		$toAddr = $ADK_USER->email;
		$subject = 'You have received a Private Message';
		
		PHPMailer($toAddr, $subject, $htmlmessage, $message);
	}
	
	//User
	function sendPWResetLinkEmail($ADK_USER){
		$url = $GLOBALS['url']."forgot?_=".$ADK_USER->last8hash.$ADK_USER->id;
		
		$htmlmessage = $ADK_USER->name.",<br><br>";
		$htmlmessage .= "You (or someone) requested a password for your account on ".$GLOBALS['url'].".<br>";
		$htmlmessage .= "If this was not you, please ignore this email. Otherwise, <a href=\"".$url."\">click here to reset your password and log in</a>.<br><br>";
		
		$message = $ADK_USER->name.",\r\n\r\n";
		$message .= "You (or someone) requested a password for your account on ".$GLOBALS['url'].".\r\n";
		$message .= "If this was not you, please ignore this email. Otherwise, click below to reset your password and log in:\r\n";
		$message .= $url."\r\n\r\n";
				
		$toAddr = $ADK_USER->email;
		$subject = 'Reset Your Password';
		
		PHPMailer($toAddr, $subject, $htmlmessage, $message);
	}
	
?>