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
					$ADK_HIKER->numpeaks = $row["ADK_HIKER_NUMPEAKS"];
					$ADK_HIKER->datetime = $row["ADK_HIKER_DTE"];
					$ADK_HIKER->lastactive = $row["ADK_HIKER_LASTACTIVE_DTE"];
					array_push($ADK_HIKERS, $ADK_HIKER);
				}
			}
			else die("There was an error running the query [".$con->error."]");

			foreach($ADK_HIKERS as $ADK_HIKER) sendInactiveUserEmail($ADK_HIKER);
		}

		public static function batch_quarterlyReport($con) {

		}

	}

?>
