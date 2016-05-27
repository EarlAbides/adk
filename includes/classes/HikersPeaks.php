<?php
	
	class HikersPeaks{
		
		public $hikerspeaks, $userid;

		public function __construct(){
			$this->hikerspeaks = [];
		}


		public function get($con){
			$sql_query = sql_getHikersPeaks($con, $this->userid);
			if($sql_query->execute()){
				$sql_query->store_result();
				$result = sql_get_assoc($sql_query);

				foreach($result as $row){
					$ADK_HIKERS_PEAK = new HikersPeak();
					$ADK_HIKERS_PEAK->peakname = $row['ADK_PEAK_NAME'];
					$ADK_HIKERS_PEAK->datetime = $row['ADK_HIKE_DTE'];
					array_push($this->hikerspeaks, $ADK_HIKERS_PEAK);
				}
			}
			else die('There was an error running the query ['.$con->error.']');		
		}
		
	}
	
	class HikersPeak{
		
		public $err;
		public $peakname, $datetime;
		
		public function __construct(){
					
		}
		
	}
	
?>