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


		public static function batch_quarterlyReport($con) {
			$data = Batch::getQuarterlyReportData($con);
			Batch::buildQuarterlyReport($data);
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
				foreach($result as $row) array_push($data["peaksMostClimbed"], [ $row["ADK_PEAK_NAME"] => $row["PEAKCOUNT"] ]);
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
			$report .= "# New Hikers - ".$data["numNewHikers"]."\n";

			$report .= "Hiker\n";
			$report .= "# Hikes logged - ".$data["numNewHikes"]."\n";
			$report .= "# Peaks climbed - ".$data["numNewPeaks"]."\n";
			$report .= "Peaks most climbed\n";
			foreach($data["peaksMostClimbed"] as $peak) $report .= "\t".$peak["ADK_PEAK_NAME"]."\t\t".$peak["PEAKCOUNT"]."\n";
			$report .= "Hiker who climbed the most peaks - ".$data["hikerWithMostPeaks"]." (".$data["hikerWithMostPeaksCount"].")\n";
			$report .= "Hikers who finishedtheir 46th -";
			foreach($data["peaksMostClimbed"] as $peak) $report .= "\t".$peak["ADK_PEAK_NAME"]."\t\t".$peak["PEAKCOUNT"]."\n"; 
			

			//# Messages
			//- #Messages sent by hikers
			//- Hiker who sent the most messages (and that number)
			echo $report;
		}

	}

?>
