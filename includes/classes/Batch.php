<?php

	class Batch {

		public static function inactiveUsers($con) {			
			$ADK_HIKERS = [];
			$sql_query = sql_batch_inactiveUsers($con);
			if($sql_query->execute()){
				$sql_query->store_result();
				$result = sql_get_assoc($sql_query);

				foreach($result as $row){
					$ADK_HIKER = new Hiker();
					$ADK_HIKER->id = $row["ADK_USER_ID"];
					$ADK_HIKER->corrid = $row["ADK_HIKER_CORR_ID"];
					$ADK_HIKER->corrname = $row["ADK_HIKER_CORR_NAME"];
					$ADK_HIKER->username = $row["ADK_USER_USERNAME"];
					$ADK_HIKER->name = $row["ADK_USER_NAME"];
					$ADK_HIKER->email = $row["ADK_USER_EMAIL"];

					array_push($ADK_HIKERS, $ADK_HIKER);
				}
			}
			else die("There was an error running the query [".$con->error."]");

			foreach($ADK_HIKERS as $ADK_HIKER) sendInactiveUserEmail($ADK_HIKER);
		}

		public static function getQuarterlyReportUsers($con) {			
			$ADK_USERS = [];
			$sql_query = sql_batch_getQuarterlyReportUsers($con);
			if($sql_query->execute()){
				$sql_query->store_result();
				$result = sql_get_assoc($sql_query);

				foreach($result as $row){
					$ADK_USER = new User();
					$ADK_USER->id = $row["ADK_USER_ID"];
					$ADK_USER->usergroupid = $row["ADK_USERGROUP_ID"];
					$ADK_USER->username = $row["ADK_USER_USERNAME"];
					$ADK_USER->name = $row["ADK_USER_NAME"];
					$ADK_USER->email = $row["ADK_USER_EMAIL"];

					array_push($ADK_USERS, $ADK_USER);
				}
			}
			else die("There was an error running the query [".$con->error."]");

			return $ADK_USERS;
		}


		public static function batch_quarterlyReport($con) {
			$data = Batch::getQuarterlyReportData($con);
			$report = Batch::buildQuarterlyReport($data);
			Batch::saveQuarterlyReport($report);
		}

		private static function getQuarterlyReportData($con) {
			$data = [
				"numNewHikers" => 0
				, "numNewHikes" => 0
				, "numNewPeaks" => 0
				, "peaksMostClimbed" => []
				, "hikerWithMostPeaks" => ""
				, "hikerWithMostPeaksCount" => 0
				, "hikerWithMostUploads" => ""
				, "hikerWithMostUploadsCount" => 0
				, "hikersWhoFinished46" => []
				, "numMessagesSentByHikers" => 0
				, "hikerWhoSentMostMessages" => ""
				, "hikerWhoSentMostMessagesCount" => 0
			];
			
			//// Hikers
			// # New Hikers
			$sql_query = sql_batch_getNumNewHikers($con);
			if($sql_query->execute()){
				$sql_query->store_result();
				$sql_query->bind_result($result);
				$sql_query->fetch();
				$data["numNewHikers"] = $result;
			}
			else die('There was an error running the query ['.$con->error.']');
			
			//// Hikes
			// # Hikes logged
			$sql_query = sql_batch_getNumNewHikes($con);
			if($sql_query->execute()){
				$sql_query->store_result();
				$sql_query->bind_result($result);
				$sql_query->fetch();
				$data["numNewHikes"] = $result;
			}
			else die('There was an error running the query ['.$con->error.']');

			// # Peaks climbed
			$sql_query = sql_batch_getNumNewPeaksClimbed($con);
			if($sql_query->execute()){
				$sql_query->store_result();
				$sql_query->bind_result($result);
				$sql_query->fetch();
				$data["numNewPeaks"] = $result;
			}
			else die('There was an error running the query ['.$con->error.']');

			// List of peaks most climbed
			$sql_query = sql_batch_getPeaksMostClimbed($con);
			if($sql_query->execute()){
				$sql_query->store_result();
				$result = sql_get_assoc($sql_query);
				foreach($result as $row) $data["peaksMostClimbed"][$row["ADK_PEAK_NAME"]] = $row["PEAKCOUNT"];
			}
			else die('There was an error running the query ['.$con->error.']');
			
			// Hiker who's logged the most peaks
			$sql_query = sql_batch_getHikerWithMostPeaks($con);
			if($sql_query->execute()){
				$sql_query->store_result();
				$result = sql_get_assoc($sql_query);

				foreach($result as $row){
					$data["hikerWithMostPeaks"] = $row["ADK_USER_NAME"];
					$data["hikerWithMostPeaksCount"] = $row["NUMPEAKS"];
				}
			}
			else die("There was an error running the query [".$con->error."]");
			
			// Hiker who's uploaded the most content
			$sql_query = sql_batch_getHikerWithMostUploads($con);
			if($sql_query->execute()){
				$sql_query->store_result();
				$result = sql_get_assoc($sql_query);

				foreach($result as $row){
					$data["hikerWithMostUploads"] = $row["ADK_USER_NAME"];
					$data["hikerWithMostUploadsCount"] = $row["NUMFILES"];
				}
			}
			else die("There was an error running the query [".$con->error."]");

			// Any hikers who've finished their 46th
			$sql_query = sql_batch_getNewHikersWhoFinished46($con);
			if($sql_query->execute()){
				$sql_query->store_result();
				$result = sql_get_assoc($sql_query);
				foreach($result as $row) array_push($data["hikersWhoFinished46"], $row["ADK_USER_NAME"]);
			}
			else die('There was an error running the query ['.$con->error.']');
			
			//// Messages
			// # Messages sent by hikers
			$sql_query = sql_batch_getNumMessagesSentByHikers($con);
			if($sql_query->execute()){
				$sql_query->store_result();
				$sql_query->bind_result($result);
				$sql_query->fetch();
				$data["numMessagesSentByHikers"] = $result;
			}
			else die('There was an error running the query ['.$con->error.']');

			// Hiker who sent the most messages (and that number)
			$sql_query = sql_batch_getHikerWhoSentMostMessages($con);
			if($sql_query->execute()){
				$sql_query->store_result();
				$result = sql_get_assoc($sql_query);

				foreach($result as $row){
					$data["hikerWhoSentMostMessages"] = $row["ADK_USER_NAME"];
					$data["hikerWhoSentMostMessagesCount"] = $row["NUMMESSAGES"];
				}
			}
			else die("There was an error running the query [".$con->error."]");
			
			return $data;
		}

		private static function buildQuarterlyReport($data) {			
			$report = "Since ".date("n/j/Y", strtotime("-3 Months"))."\n\n\n";

			$report .= "Hikers\n";
			$report .= "# New Hikers - ".$data["numNewHikers"]."\n\n\n";

			$report .= "Hiker\n";
			$report .= "# Hikes logged - ".$data["numNewHikes"]."\n";
			$report .= "# Peaks climbed - ".$data["numNewPeaks"]."\n";
			$report .= "Hiker who climbed the most peaks - ".$data["hikerWithMostPeaks"]." (".$data["hikerWithMostPeaksCount"].")\n";
			$report .= "Peaks most climbed\n";
			foreach($data["peaksMostClimbed"] as $peak => $peakCount) $report .= "\t$peak ($peakCount)\n";
			$report .= "Hikers who finished their 46th:\n";
			foreach($data["hikersWhoFinished46"] as $hiker) $report .= "\t$hiker\n"; 
			
			$report .= "\n\nMessages\n";
			$report .= "# messages sent by hikers - ".$data["numMessagesSentByHikers"]."\n";
			$report .= "Hiker who sent the most messages - ".$data["hikerWhoSentMostMessages"]." (".$data["hikerWhoSentMostMessagesCount"].")\n";

			return $report;
		}

		private static function saveQuarterlyReport($report) {
			$filename = date("Ymd")."-quarterlyNewsletter.txt";
			$file = "data/reports/".$filename;

			file_put_contents($file, $report);
		}


		public static function batch_hikersCorrespondenceHistory($con, $ADK_USER_ID) {
			$ADK_MESSAGES = Batch::getHikersCorrespondenceHistory($con, $ADK_USER_ID);
			$ADK_MESSAGES = Batch::condenseMessageReplies($ADK_MESSAGES);
			$messages = Batch::formatMessages($ADK_USER_ID, $ADK_MESSAGES);
			
			return $messages;
		}

		public static function getHikersCorrespondenceHistory($con, $ADK_USER_ID) {
			$ADK_MESSAGES = [];
			$sql_query = sql_batch_getHikersCorrespondenceHistory($con, $ADK_USER_ID);
			if($sql_query->execute()){
				$sql_query->store_result();
				$result = sql_get_assoc($sql_query);

				foreach($result as $row){
					$ADK_MESSAGE = new Message();
					$ADK_MESSAGE->id = $row["ADK_MESSAGE_ID"];
					$ADK_MESSAGE->fromid = $row["ADK_MESSAGE_FROM_USER_ID"];
					$ADK_MESSAGE->fromname = $row["ADK_MESSAGE_FROM_NAME"];
					$ADK_MESSAGE->fromusername = $row["ADK_MESSAGE_FROM_USERNAME"];
					$ADK_MESSAGE->toid = $row["ADK_MESSAGE_TO_USER_ID"];
					$ADK_MESSAGE->toname = $row["ADK_MESSAGE_TO_NAME"];
					$ADK_MESSAGE->tousername = $row["ADK_MESSAGE_TO_USERNAME"];
					$ADK_MESSAGE->respondid = $row["ADK_MESSAGE_RESPOND_ID"];
					$ADK_MESSAGE->title = $row["ADK_MESSAGE_TITLE"];
					$ADK_MESSAGE->content = $row["ADK_MESSAGE_CONTENT"];
					$ADK_MESSAGE->date = strtotime($row["ADK_MESSAGE_DTE"]);

					array_push($ADK_MESSAGES, $ADK_MESSAGE);
				}
			}
			else die("There was an error running the query [".$con->error."]");

			return $ADK_MESSAGES;
		}

		private static function condenseMessageReplies($ADK_MESSAGES) {
			$toKill = [];

			for($i = 0; $i < count($ADK_MESSAGES); $i++){
				if($ADK_MESSAGES[$i]->respondid){
					for($j = 0; $j < count($ADK_MESSAGES); $j++){
						if(Batch::isProperResponse($ADK_MESSAGES[$j], $ADK_MESSAGES[$i])){
							array_push($toKill, $j);
						}
					}
				}
			}
			
			for($i = count($toKill) - 1; $i >= 0; $i--) unset($ADK_MESSAGES[$toKill[$i]]);

			return $ADK_MESSAGES;
		}

		private static function isProperResponse($orig, $reply) {
			if($reply->respondid !== $orig->id) return false;
			if(strpos($orig->content, $reply->content)) return false;
			return true;
		}

		private static function formatMessages($ADK_USER_ID, $ADK_MESSAGES) {
			$messages = "";
			$le = "<br>";

			foreach($ADK_MESSAGES as $ADK_MESSAGE){
				if($ADK_USER_ID === $ADK_MESSAGE->toid) $messages .= "From: ".$ADK_MESSAGE->fromname." (".$ADK_MESSAGE->fromusername.")$le";
				else $messages .= "To: ".$ADK_MESSAGE->toname." (".$ADK_MESSAGE->tousername.")$le";

				$messages .= "Date: ".date('d/m/Y g:i', $ADK_MESSAGE->date).$le;
				$messages .= "Subject: ".$ADK_MESSAGE->title.$le.$le.$le;
				$messages .= $ADK_MESSAGE->content.$le.$le.$le;

				$messages .= "<hr>";
			}
			
			return $messages;
		}

	}

?>
