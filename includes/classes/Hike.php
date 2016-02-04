<?php
	
	class Hikes{
		
		public $hikes, $userid;

		public function __construct(){
			$this->hikes = [];
		}


		public function get($con){
			$sql_query = sql_getHikes($con, $this->userid);
			if($sql_query->execute()){
				$sql_query->store_result();
				$result = sql_get_assoc($sql_query);

				foreach($result as $row){
					$ADK_HIKE = new Hike();
					$ADK_HIKE->id = intval($row['ADK_HIKE_ID']);
					$ADK_HIKE->notes = $row['ADK_HIKE_NOTES'];
					$ADK_HIKE->datetime = $row['ADK_HIKE_DTE'] === null? 'N/A': date("m/d/Y", strtotime($row['ADK_HIKE_DTE']));
					$ADK_HIKE->numpeaks = $row['ADK_HIKE_NUMPEAKS'];

					//peaks
					$peakNames = [];
					$sql_query = sql_getHikesPeaks($con, $ADK_HIKE->id);
					if($sql_query->execute()){
						$sql_query->store_result();
						$result = sql_get_assoc($sql_query);

						foreach($result as $row){
							$ADK_PEAK = new Peak();
							$ADK_PEAK->id = intval($row['ADK_PEAK_ID']);
							$ADK_PEAK->name = $row['ADK_PEAK_NAME'];
							$ADK_PEAK->height = $row['ADK_PEAK_HEIGHT'];
							$ADK_PEAK->datetime = $row['ADK_PEAK_DTE'];
							array_push($peakNames, $ADK_PEAK->name);
							array_push($ADK_HIKE->peaks, $ADK_PEAK);
						}
					}
					else die('There was an error running the query ['.$con->error.']');
					$ADK_HIKE->label = join(', ', $peakNames);

					//files
					$sql_query = sql_getHikesFiles($con, $ADK_HIKE->id);
					if($sql_query->execute()){
						$sql_query->store_result();
						$result = sql_get_assoc($sql_query);
                    
						foreach($result as $row){
							$ADK_FILE = new File();
							$ADK_FILE->id = intval($row['ADK_FILE_ID']);
							$ADK_FILE->name = $row['ADK_FILE_NAME'];
							$ADK_FILE->desc = $row['ADK_FILE_DESC'];
							$ADK_FILE->size = intval($row['ADK_FILE_SIZE']);
							array_push($ADK_HIKE->files, $ADK_FILE);
						}
					}

					array_push($this->hikes, $ADK_HIKE);
				}
			}
			else die('There was an error running the query ['.$con->error.']');		
		}


		public function renderTable($numPeaks){
			$peakIDs = [];
			$html = "<table id=\"table_hikes\" class=\"selecttable dt\" data-numpeaks=".$numPeaks.">
						<thead>
							<tr>
								<th style=\"width:5%;\"></th>
								<th style=\"width:72%;\">Peaks</th>
								<th style=\"width:15%;\">Date</th>
								<th style=\"width:8%;\">#&nbsp;Peaks</th>
							</tr>
						</thead>
						<tbody>";
		
			if(count($this->hikes) === 0){//If empty
				$html .= '<tr><td style="width:100%;text-align:center;font-style:italic;">No hikes</td><td style="width:0;"></td><td style="width:0;"></td><td style="width:0;"></td></tr>';
			}	
			else{
				foreach($this->hikes as $ADK_HIKE){
					$html .= "<tr>
								<td>
									<input type=\"hidden\" name=\"hikeid\" value=\"".$ADK_HIKE->id."\" />
									<input type=\"hidden\" name=\"numpeaks\" value=\"".$ADK_HIKE->numpeaks."\" />
									<div name=\"notes\" style=\"display:none;\">".$ADK_HIKE->notes."</div>
									<input type=\"hidden\" name=\"date\" value=\"".$ADK_HIKE->datetime."\" />
									<div style=\"display:none;\">";
					foreach($ADK_HIKE->peaks as $ADK_PEAK){
						array_push($peakIDs, $ADK_PEAK->id);
						$html .= "		<input type=\"hidden\" data-id=\"".$ADK_PEAK->id."\" data-name=\"".$ADK_PEAK->name."\" data-height=\"".$ADK_PEAK->height."\" data-date=\"".date('m/d/Y', strtotime($ADK_PEAK->datetime))."\" />";
					}
					$html .= "		</div><div style=\"display:none;\">";
					foreach($ADK_HIKE->files as $ADK_FILE)
						$html .= "		<input type=\"hidden\" data-id=\"".$ADK_FILE->id."\" data-name=\"".$ADK_FILE->name."\" data-desc=\"".$ADK_FILE->desc."\" data-size=\"".$ADK_FILE->size."\" />";
					$html .= "		</div>
									<a onclick=\"viewHike(this.parentNode);\" class=\"hoverbtn pointer rowselector\">
										<span class=\"glyphicon glyphicon-zoom-in\" title=\"Hike Details\" data-toggle=\"tooltip\" data-placement=\"right\" data-container=\"body\"></span>
									</a>
								</td>
								<td>".$ADK_HIKE->label."</td>
								<td>".$ADK_HIKE->datetime."</td>
								<td style=\"text-align:center;\">".$ADK_HIKE->numpeaks."</td>
							</tr>";
				}
			}
		
			$html .= "</tbody></table><input type=\"hidden\" id=\"hidden_usedPeakIDs\" value=\"".implode(',', $peakIDs)."\" />";
		
			echo $html;
		}
		
	}
	
	class Hike{
		
		public $err;
		public $id, $userid, $notes, $datetime, $peaks, $files, $numpeaks, $label;
		
		public function __construct(){
			$this->peaks = [];
			$this->files = [];			
		}


		private function getEarliestDate(){
			$earliest = '';
			foreach($this->peaks as $ADK_PEAK){
				if(!$earliest) $earliest = $ADK_PEAK->datetime;
				else if(strtotime($ADK_PEAK->datetime) < strtotime($earliest)) $earliest = $ADK_PEAK->datetime;
			}

			return $earliest;
		}
		
		public function isValid(){
			if(isset($this->id) && !is_numeric($this->id)) $this->err .= 'i';
			if(!is_numeric($this->userid)) $this->err .= 'u';
		    if(strlen($this->datetime) === 0) $this->err .= 'd';
		    if(count($this->peaks) === 0) $this->err .= 'p';
			else{
				foreach($this->peaks as $ADK_PEAK){
					if(!is_numeric($ADK_PEAK->id)) $this->err .= 'q';
					if(!preg_match('/(0[1-9]|1[012])[- \/.](0[1-9]|[12][0-9]|3[01])[- \/.](19|20)\d\d/', $ADK_PEAK->datetime)) $this->err .= 'a';
				}
			}
			
		    if(strlen($this->err) > 0) return false;
		    return true;
		}

		public function sanitize(){
			$this->notes = str_replace('<iframe', '</iframe', $this->notes);
			$this->notes = str_replace('<script', '</script', $this->notes);
		}
		
		
		public function save($con){
			$sql_query = sql_addHike($con, $this);
			$sql_query->execute();
			$this->id = $sql_query->insert_id;
		}

		public function addPeak($con, $ADK_PEAK){
			$sql_query = sql_addHikesPeak($con, $this->id, $ADK_PEAK);
			$sql_query->execute();
		}

		public function addFiles($con, $fileIDs){
	        $sql_query = sql_addHikeFileJcts($con);
			$con->query("START TRANSACTION");
			foreach($fileIDs as $fileID){
				$sql_query->bind_param('ii', $this->id, $fileID);
				$sql_query->execute();
			}
			$sql_query->close();
			$con->query("COMMIT");
	    }

		public function update($con){
			$sql_query = sql_updateHike($con, $this);
			$sql_query->execute();
		}

		public function delete($con){
			$sql_queries = sql_deleteHike($con, $this->id);
			foreach($sql_queries as $sql_query){
				if(!$sql_query->execute()) die('There was an error running the query ['.$con->error.']');
			}
		}

		public function deletePeaks($con){
			$sql_query = sql_deleteHikePeakJcts($con, $this->id);
			if(!$sql_query->execute()) die('There was an error running the query ['.$con->error.']');
		}

		public function deleteFiles($con){
			$sql_query = sql_deleteHikeFileJcts($con, $this->id);
			if(!$sql_query->execute()) die('There was an error running the query ['.$con->error.']');
		}


		public function populate(){
			if(isset($_POST['hikeid'])) $this->id = intval($_POST['hikeid']);
			$this->userid = intval($_POST['id']);
			$this->notes = $_POST['notes'];

			$peaks = explode(',', $_POST['peaks']);
			foreach($peaks as $peak){
				$els = explode(' ', $peak);
				$ADK_PEAK = new Peak();
				$ADK_PEAK->id = $els[0];
				$ADK_PEAK->datetime = $els[1];
				array_push($this->peaks, $ADK_PEAK);
			}
			$this->datetime = $this->getEarliestDate();
		}
		
	}
	
?>