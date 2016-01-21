<?php
	
	class Peaks{
		
		public $peaks;
		
		public function Peaks(){
			$this->peaks = [];
		}
		
		public function get($con){
			$sql_query = sql_getPeaks($con, $ADK_USER_ID);
			if($sql_query->execute()){
				$sql_query->store_result();
				$result = sql_get_assoc($sql_query);

				foreach($result as $row){
					$peak = new Peak();
					$peak->id = $row['ADK_PEAK_ID'];
					$peak->name = $row['ADK_PEAK_NAME'];
					$peak->height = $row['ADK_PEAK_HEIGHT'];
					$peak->complete = $row['ADK_PEAK_COMPLETE'];
					array_push($this->peaks, $peak);
				}
			}
			else die('There was an error running the query ['.$con->error.']');		
			
			function sql_getPeaks($con, $ADK_USER_ID){
				if($ADK_USER_ID !== ''){
					$sql_query = $con->prepare(
						"SELECT A.ADK_PEAK_ID, A.ADK_PEAK_NAME, A.ADK_PEAK_HEIGHT
							,CASE WHEN A.ADK_PEAK_ID IN(
								SELECT B.ADK_PEAK_ID FROM ADK_HIKE_PEAK_JCT B
									LEFT JOIN ADK_HIKE C ON B.ADK_HIKE_ID = C.ADK_HIKE_ID
								WHERE C.ADK_USER_ID = ?
							) THEN 1 ELSE 0 END AS ADK_PEAK_COMPLETE
						FROM ADK_PEAK A;"
					);
					
					$sql_query->bind_param('i', $ADK_USER_ID);
				}
				Else{
					$sql_query = $con->prepare("SELECT ADK_PEAK_ID, ADK_PEAK_NAME, ADK_PEAK_HEIGHT, 0 ADK_PEAK_COMPLETE FROM ADK_PEAK;");
				}

				return $sql_query;
			}
		}
		
		public function getNames($con){
			//may or may not need to be in here, might go better in Hike class, dunno yet
		}
		
	}
	
	class Peak{
		
		public $id, $name, $height, $complete;
		
		public function Peak(){
			
		}
		
	}
	
?>