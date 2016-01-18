<?php
	
	function makeHikeArray(){
		if((isset($_POST['hikeid'])) && ($_POST['hikeid'] !== '')) $ADK_HIKE_ID = intval($_POST['hikeid']);
		else $ADK_HIKE_ID = '';
		
	    $ADK_HIKE = array(
			'ADK_HIKE_ID' => $ADK_HIKE_ID,
	        'ADK_USER_ID' => intval($_POST['id']),
	        'ADK_HIKE_NOTES' => $_POST['notes'],
	        'ADK_HIKE_DTE' => $_POST['date']
	    );
		
	    return $ADK_HIKE;
	}
	
	function makeHikesPeaksArray($ADK_HIKE){
		$peakids = explode(',', $_POST['peakids']);
		
		for($i = 0; $i < count($peakids); $i++){
			$ADK_HIKE['ADK_PEAKS'][$i] = array(
				'ADK_HIKE_ID' => $ADK_HIKE['ADK_HIKE_ID'],
				'ADK_PEAK_ID' => $peakids[$i]
			);
		}
		
	    return $ADK_HIKE;
	}
	
	function getHikes($con, $ADK_USER_ID){
        $ADK_HIKES = '';
		$sql_query = sql_getHikes($con, $ADK_USER_ID);
		if($sql_query->execute()){
            $sql_query->store_result();
            $result = sql_get_assoc($sql_query);

            $i = 0;
			foreach($result as $row){
				$ADK_HIKES[$i]['ADK_HIKE_ID'] = intval($row['ADK_HIKE_ID']);
				$ADK_HIKES[$i]['ADK_HIKE_NOTES'] = $row['ADK_HIKE_NOTES'];
				$ADK_HIKES[$i]['ADK_HIKE_DTE'] = $row['ADK_HIKE_DTE'] === null? 'N/A':date("m/d/Y", strtotime($row['ADK_HIKE_DTE']));
				$ADK_HIKES[$i]['ADK_HIKE_NUMPEAKS'] = $row['ADK_HIKE_NUMPEAKS'];

                $ADK_HIKES[$i]['ADK_FILES'] = '';
                $sql_query = sql_getHikesFiles($con, $ADK_HIKES[$i]['ADK_HIKE_ID']);
                if($sql_query->execute()){
                    $sql_query->store_result();
                    $result = sql_get_assoc($sql_query);
                    
                    $j = 0;
                    foreach($result as $row){
                        $ADK_HIKES[$i]['ADK_FILES'][$j]['ADK_FILE_ID'] = intval($row['ADK_FILE_ID']);
						$ADK_HIKES[$i]['ADK_FILES'][$j]['ADK_FILE_NAME'] = $row['ADK_FILE_NAME'];
						$ADK_HIKES[$i]['ADK_FILES'][$j]['ADK_FILE_DESC'] = $row['ADK_FILE_DESC'];
						$ADK_HIKES[$i]['ADK_FILES'][$j]['ADK_FILE_SIZE'] = intval($row['ADK_FILE_SIZE']);
						$j++;
                    }
                }

				$i++;
			}
		}
		else die('There was an error running the query ['.$con->error.']');		
		
		return $ADK_HIKES;
	}
	
	function getHikesPeaks($con, $ADK_HIKES){
        $hikeCount = 0;
        $ADK_HIKE['ADK_PEAKS'] = [];
		if($ADK_HIKES !== ''){
			foreach($ADK_HIKES as $ADK_HIKE){
				$peakNames = [];

                $sql_query = sql_getHikesPeaks($con, $ADK_HIKE['ADK_HIKE_ID']);
                if($sql_query->execute()){
                    $sql_query->store_result();
                    $result = sql_get_assoc($sql_query);

                    $i = 0;
		            foreach($result as $row){
				        $ADK_HIKE['ADK_PEAKS'][$i]['ADK_PEAK_ID'] = intval($row['ADK_PEAK_ID']);
						$ADK_HIKE['ADK_PEAKS'][$i]['ADK_PEAK_NAME'] = $row['ADK_PEAK_NAME'];
						$ADK_HIKE['ADK_PEAKS'][$i]['ADK_PEAK_HEIGHT'] = $row['ADK_PEAK_HEIGHT'];
						array_push($peakNames, $ADK_HIKE['ADK_PEAKS'][$i]['ADK_PEAK_NAME']);
						$i++;
		            }
                }
                else die('There was an error running the query ['.$con->error.']');

                $label = join(', ', $peakNames);
				$ADK_HIKE['ADK_PEAKS_LABEL'] = $label;
			
				$ADK_HIKES[$hikeCount] = $ADK_HIKE;
				$hikeCount++;
            }
        }
		
        return $ADK_HIKES;
	}
	
	function addHike($con){
		$ADK_HIKE = makeHikeArray();
		$sql_query = sql_addHike($con, $ADK_HIKE);
		$sql_query->execute();
		$ADK_HIKE['ADK_HIKE_ID'] = $sql_query->insert_id;
		
		return $ADK_HIKE;
	}

	function addInitialHikes($con, $ADK_USER_ID, $ADK_PEAK_ID){
		$ADK_HIKE = array('ADK_USER_ID' => $ADK_USER_ID);
		$sql_query = sql_addHike($con, $ADK_HIKE);
		$sql_query->execute();
		$ADK_HIKE['ADK_HIKE_ID'] = $sql_query->insert_id;
		
		return $ADK_HIKE;
	}
	
	function addHikeFileJcts($con, $ADK_HIKE_ID, $fileIDs){
		$sql_query = sql_addHikeFileJcts($con);
		$con->autocommit(FALSE);
		foreach($fileIDs as $fileID){
			$sql_query->bind_param('ii', $ADK_HIKE_ID, $fileID);
			$sql_query->execute();
		}
		$sql_query->close();
		$con->commit();
		
		return true;
	}
	
	function deleteHike($con, $ADK_HIKE_ID){
		deleteHikeFileJcts($con, $ADK_HIKE_ID);
		deleteHikePeakJcts($con, $ADK_HIKE_ID);
		$sql_query = sql_deleteHike($con, $ADK_HIKE_ID);
		if($sql_query->execute()){}
		else die('There was an error running the query ['.$con->error.']');
	}

	function deleteHikePeakJcts($con, $ADK_HIKE_ID){
		$sql_query = sql_deleteHikePeakJcts($con, $ADK_HIKE_ID);
		if($sql_query->execute()){}
		else die('There was an error running the query ['.$con->error.']');
	}

	function deleteHikeFileJcts($con, $ADK_HIKE_ID){
		$sql_query = sql_deleteHikeFileJcts($con, $ADK_HIKE_ID);
		if($sql_query->execute()){}
		else die('There was an error running the query ['.$con->error.']');
	}
	
	function updateHike($con){
		$ADK_HIKE = makeHikeArray();
						
	    //Update
		$sql_query = sql_updateHike($con, $ADK_HIKE);
		$sql_query->execute();
		
		return $ADK_HIKE;
	}
	
	function addHikesPeaks($con, $ADK_HIKE){
		$ADK_HIKE = makeHikesPeaksArray($ADK_HIKE);
						
	    $sql_query = sql_addHikesPeaks($con);
		$con->autocommit(false);
		foreach($ADK_HIKE['ADK_PEAKS'] as $ADK_PEAK){
			$sql_query->bind_param('ii', $ADK_PEAK['ADK_HIKE_ID'], $ADK_PEAK['ADK_PEAK_ID']);
			$sql_query->execute();
		}
		$sql_query->close();
		$con->commit();
		$con->autocommit(true);
		
		return true;
	}

	function addInitialHikesPeaks($con, $ADK_HIKE_ID, $ADK_PEAK_ID){
		$sql_query = sql_addHikesPeaks($con);
		$sql_query->bind_param('ii', $ADK_HIKE_ID, $ADK_PEAK_ID);
		$sql_query->execute();
		return true;
	}
	
	function updateHikesPeaks($con, $ADK_HIKE){
		$ADK_HIKE = makeHikesPeaksArray($ADK_HIKE);
		
		//Delete existing junctions
		deleteHikePeakJcts($con, $ADK_HIKE['ADK_HIKE_ID']);
		
		return addHikesPeaks($con, $ADK_HIKE);
	}
	
	function getTableHikes($ADK_HIKES){
		$peakIDs = '';
		$html = "<table id=\"table_hikes\" class=\"selecttable dt\">
					<thead>
						<tr>
							<th style=\"width:5%;\"></th>
							<th style=\"width:72%;\">Peaks</th>
							<th style=\"width:15%;\">Date</th>
							<th style=\"width:8%;\">#&nbsp;Peaks</th>
						</tr>
					</thead>
					<tbody>";
		
		if($ADK_HIKES == ''){//If empty
			$html .= '<tr><td colspan="4" style="text-align:center;font-style:italic;">No hikes</td></tr>';
		}	
		else{
			foreach($ADK_HIKES as $ADK_HIKE){
				$html .= "<tr>
							<td>
								<input type=\"hidden\" name=\"hikeid\" value=\"".$ADK_HIKE['ADK_HIKE_ID']."\" />
								<input type=\"hidden\" name=\"numpeaks\" value=\"".$ADK_HIKE['ADK_HIKE_NUMPEAKS']."\" />
								<div name=\"notes\" style=\"display:none;\">".$ADK_HIKE['ADK_HIKE_NOTES']."</div>
								<input type=\"hidden\" name=\"date\" value=\"".$ADK_HIKE['ADK_HIKE_DTE']."\" />
								<div style=\"display:none;\">";
				foreach($ADK_HIKE['ADK_PEAKS'] as $ADK_PEAK){
					$peakIDs .= $ADK_PEAK['ADK_PEAK_ID'].',';
				    $html .= "		<input type=\"hidden\" data-id=\"".$ADK_PEAK['ADK_PEAK_ID']."\" data-name=\"".$ADK_PEAK['ADK_PEAK_NAME']."\" data-height=\"".$ADK_PEAK['ADK_PEAK_HEIGHT']."\" />";
				}
				$html .= "		</div><div style=\"display:none;\">";
				if($ADK_HIKE['ADK_FILES'] !== ''){
					foreach($ADK_HIKE['ADK_FILES'] as $ADK_FILE)
						$html .= "		<input type=\"hidden\" data-id=\"".$ADK_FILE['ADK_FILE_ID']."\" data-name=\"".$ADK_FILE['ADK_FILE_NAME']."\" data-desc=\"".$ADK_FILE['ADK_FILE_DESC']."\" data-size=\"".$ADK_FILE['ADK_FILE_SIZE']."\" />";
				}
				$html .= "		</div>
								<a onclick=\"viewHike(this.parentNode);\" class=\"hoverbtn pointer rowselector\">
									<span class=\"glyphicon glyphicon-zoom-in\" title=\"Hike Details\" data-toggle=\"tooltip\" data-placement=\"right\" data-container=\"body\"></span>
								</a>
							</td>
							<td>".$ADK_HIKE['ADK_PEAKS_LABEL']."</td>
							<td>".$ADK_HIKE['ADK_HIKE_DTE']."</td>
							<td style=\"text-align:center;\">".$ADK_HIKE['ADK_HIKE_NUMPEAKS']."</td>
						</tr>";
			}
			$peakIDs = rtrim($peakIDs, ',');
		}
		
		$html .= "</tbody></table><input type=\"hidden\" id=\"hidden_usedPeakIDs\" value=\"".$peakIDs."\" />";
		
		return $html;
	}
	
	function _46erCompletionEmail($con, $ADK_USER_ID, $ADK_HIKES){
		$numPeaks = 0;
		for($i = 0; $i < count($ADK_HIKES); $i++) $numPeaks += count($ADK_HIKES[$i]['ADK_PEAKS']);

		if($numPeaks === 46){
			require_once 'User.php';
			$ADK_USER = getUser($con, $ADK_USER_ID);
			send46erCompletionEmail($ADK_USER);
		}
	}

	function hasClimbed($con, $ADK_USER_ID, $ADK_PEAK_IDS, $ADK_HIKE_ID){
		$COUNT = 0;
		$ADK_PEAK_IDS[0] = '2';
		$sql_query = sql_checkHasClimbed($con, $ADK_USER_ID, $ADK_PEAK_IDS, $ADK_HIKE_ID);
		if($sql_query->execute()){
            $sql_query->store_result();
            $sql_query->bind_result($result);
            $sql_query->fetch();
            $COUNT = $result;
		}
		else die('There was an error running the query ['.$con->error.']');
		
		return $COUNT > 0;
	}
	
	function getPeakNames($con, $ADK_PEAK_IDS){
		$peakNames = '';
		$sql_query = sql_getPeakNames($con, $ADK_PEAK_IDS);
		if($sql_query->execute()){
            $sql_query->store_result();
            $sql_query->bind_result($result);
            $sql_query->fetch();
            $peakNames = $result;
		}
		else die('There was an error running the query ['.$con->error.']');
		
		return $peakNames;
	}

?>