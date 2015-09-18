<?php
	
	function getPeaks($con){		
		$ADK_PEAKS = '';
		$sql_query = sql_getPeaks($con);
		if($sql_query->execute()){
            $sql_query->store_result();
            $result = sql_get_assoc($sql_query);

            $i = 0;
			foreach($result as $row){
				$ADK_PEAKS[$i]['ADK_PEAK_ID'] = $row['ADK_PEAK_ID'];
				$ADK_PEAKS[$i]['ADK_PEAK_NAME'] = $row['ADK_PEAK_NAME'];
				$ADK_PEAKS[$i]['ADK_PEAK_HEIGHT'] = $row['ADK_PEAK_HEIGHT'];
				$i++;
			}
		}
		else die('There was an error running the query ['.$con->error.']');		
		
		return $ADK_PEAKS;
	}
	
	function getRemainingPeaks($con, $ADK_USER_ID){		
		$ADK_PEAKS = '';
		$sql_query = sql_getRemainingPeaks($con, $ADK_USER_ID);
		if($sql_query->execute()){
            $sql_query->store_result();
            $result = sql_get_assoc($sql_query);

            $i = 0;
			foreach($result as $row){
				$ADK_PEAKS[$i]['ADK_PEAK_ID'] = $row['ADK_PEAK_ID'];
				$ADK_PEAKS[$i]['ADK_PEAK_NAME'] = $row['ADK_PEAK_NAME'];
				$ADK_PEAKS[$i]['ADK_PEAK_HEIGHT'] = $row['ADK_PEAK_HEIGHT'];
                $ADK_PEAKS[$i]['ADK_PEAK_COMPLETE'] = $row['ADK_PEAK_COMPLETE'];
				$i++;
			}
		}
		else die('There was an error running the query ['.$con->error.']');		
		
		return $ADK_PEAKS;
	}
	
?>