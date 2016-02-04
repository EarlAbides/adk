<?php
	
	class Peaks{
		
		public $peaks;
		
		public function Peaks(){
			$this->peaks = [];
		}
		
		public function get($con){
			$sql_query = sql_getPeaks($con);
			if($sql_query->execute()){
				$sql_query->store_result();
				$result = sql_get_assoc($sql_query);

				foreach($result as $row){
					$peak = new Peak();
					$peak->id = intval($row['ADK_PEAK_ID']);
					$peak->name = $row['ADK_PEAK_NAME'];
					$peak->height = $row['ADK_PEAK_HEIGHT'];
					array_push($this->peaks, $peak);
				}
			}
			else die('There was an error running the query ['.$con->error.']');
		}
		
		public function getNames($con){
			//may or may not need to be in here, might go better in Hike class, dunno yet
		}
		
	}
	
	class Peak{
		
		public $id, $name, $height, $datetime;
		
		public function __construct(){
			
		}
		
	}
	
?>