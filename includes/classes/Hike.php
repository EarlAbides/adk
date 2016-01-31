<?php
	
	class Hikes{
		
		public $hikes, $userid;

		public function Hikes(){
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
				$html .= '<tr><td colspan="4" style="text-align:center;font-style:italic;">No hikes</td></tr>';
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
						$html .= "		<input type=\"hidden\" data-id=\"".$ADK_PEAK->id."\" data-name=\"".$ADK_PEAK->name."\" data-height=\"".$ADK_PEAK->height."\" />";
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
		
		public function Hike(){
			$this->peaks = [];
			$this->files = [];			
		}
		
		//public function isValid(){
		//    if(strlen($this->username) === 0 || strlen($this->username) > 45) $this->err .= 'u';
		//    if(strlen($this->name) === 0 || strlen($this->name) > 40) $this->err .= 'n';
		//    if(strlen($this->email) === 0 || strlen($this->email) > 50) $this->err .= 'e';
		//    if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) > 50) $this->err .= 'e';
		//    if(strlen($this->address1) === 0 || strlen($this->address1) > 40) $this->err .= 'a';
		//    if(strlen($this->city) === 0 || strlen($this->city) > 40) $this->err .= 'c';
		//    if(strlen($this->state) === 0 || strlen($this->state) > 2) $this->err .= 's';
		//    if(strlen($this->country) === 0 || strlen($this->country) > 40) $this->err .= 'o';
		//    if(strlen($this->info) === 0) $this->err .= 'i';
			
		//    if(strlen($this->err) > 0) return false;
		//    return true;
		//}
		
		//public function save($con){
		//    $sql_query = sql_addApplicant($con, $this);
		//    $sql_query->execute();
		//    $this->id = $sql_query->insert_id;
			
		//    function sql_addApplicant($con, $ADK_APPLICANT){
		//        $sql_query = $con->prepare(
		//            "INSERT INTO ADK_APPLICANT(ADK_APPLICANT_USERNAME, ADK_APPLICANT_NAME, ADK_APPLICANT_EMAIL, ADK_APPLICANT_PHONE
		//                ,ADK_APPLICANT_AGE, ADK_APPLICANT_SEX, ADK_APPLICANT_ADDRESS1, ADK_APPLICANT_ADDRESS2
		//                ,ADK_APPLICANT_CITY, ADK_APPLICANT_STATE, ADK_APPLICANT_ZIP, ADK_APPLICANT_COUNTRY, ADK_APPLICANT_PERSONALINFO
		//                ,ADK_APPLICANT_REQ_CORR, ADK_APPLICANT_PEAKIDS)
		//            VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);");
				
		//        $sql_query->bind_param('sssssssssssssss', $ADK_APPLICANT->username, $ADK_APPLICANT->name, $ADK_APPLICANT->email
		//                    ,$ADK_APPLICANT->phone, $ADK_APPLICANT->age, $ADK_APPLICANT->sex, $ADK_APPLICANT->address1
		//                    ,$ADK_APPLICANT->address2, $ADK_APPLICANT->city, $ADK_APPLICANT->state, $ADK_APPLICANT->zip
		//                    ,$ADK_APPLICANT->country, $ADK_APPLICANT->info, $ADK_APPLICANT->reqcorr, $ADK_APPLICANT->peakids);
				
		//        return $sql_query;
		//    }
		//}
		
		
		public function save($con){
			$sql_query = sql_addHike($con, $this);
			$sql_query->execute();
			$this->id = $sql_query->insert_id;
		}

		public function addPeak($con, $ADK_PEAK_ID){
			$sql_query = sql_addHikesPeak($con, $this->id, $ADK_PEAK_ID);
			$sql_query->execute();
		}

		//public function get($con){
		//    $sql_query = sql_getHiker($con, $this->id);
		//    if($sql_query->execute()){
		//        $sql_query->store_result();
		//        $result = sql_get_assoc($sql_query);

		//        foreach($result as $row){
		//            $this->corrid = $row['ADK_HIKER_CORR_ID'];
		//            $this->photoid = intval($row['ADK_HIKER_PHOTO_ID']);
		//            $this->username = $row['ADK_USER_USERNAME'];
		//            $this->name = $row['ADK_USER_NAME'];
		//            $this->email = $row['ADK_USER_EMAIL'];
		//            $this->phone = $row['ADK_HIKER_PHONE'];
		//            $this->age = $row['ADK_HIKER_AGE'] != 0? $row['ADK_HIKER_AGE']: '';
		//            $this->sex = $row['ADK_HIKER_SEX'];
		//            $this->address1 = $row['ADK_HIKER_ADDRESS1'];
		//            $this->address2 = $row['ADK_HIKER_ADDRESS2'];
		//            $this->city = $row['ADK_HIKER_CITY'];
		//            $this->state = $row['ADK_HIKER_STATE'];
		//            $this->zip = preg_replace('/(\d{5})(\d{4})/i', '-', $row['ADK_HIKER_ZIP']);
		//            $this->country = $row['ADK_HIKER_COUNTRY'];
		//            $this->info = $row['ADK_HIKER_PERSONALINFO'];
		//            $this->numpeaks = intval($row['ADK_HIKER_NUMPEAKS']);
		//        }
		//    }
		//    else die('There was an error running the query ['.$con->error.']');
		//}
		
		//public function update($con){
		//    $sql_query = sql_updateApplicant($con, $this);
		//    $sql_query->execute();
			
		//    function sql_updateApplicant($con, $ADK_APPLICANT){
		//        $sql_query = $con->prepare(
		//            "UPDATE ADK_APPLICANT
		//                SET ADK_APPLICANT_USERNAME = ?
		//                    ,ADK_APPLICANT_NAME = ?
		//                    ,ADK_APPLICANT_EMAIL = ?
		//                    ,ADK_APPLICANT_PHONE = ?
		//                    ,ADK_APPLICANT_AGE = ?
		//                    ,ADK_APPLICANT_SEX = ?
		//                    ,ADK_APPLICANT_ADDRESS1 = ?
		//                    ,ADK_APPLICANT_ADDRESS2 = ?
		//                    ,ADK_APPLICANT_CITY = ?
		//                    ,ADK_APPLICANT_STATE = ?
		//                    ,ADK_APPLICANT_ZIP = ?
		//                    ,ADK_APPLICANT_COUNTRY = ?
		//                    ,ADK_APPLICANT_PERSONALINFO = ?
		//            WHERE ADK_APPLICANT_ID = ?;");
				
		//        $sql_query->bind_param('ssssissssssssi', $ADK_APPLICANT->username, $ADK_APPLICANT->name, $ADK_APPLICANT->email
		//                    ,$ADK_APPLICANT->phone, $ADK_APPLICANT->age, $ADK_APPLICANT->sex, $ADK_APPLICANT->address1
		//                    ,$ADK_APPLICANT->address2, $ADK_APPLICANT->city, $ADK_APPLICANT->state, $ADK_APPLICANT->zip
		//                    ,$ADK_APPLICANT->country, $ADK_APPLICANT->info, $ADK_APPLICANT->id);
				
		//        return $sql_query;
		//    }
		//}

		public function delete($con){
			$sql_queries = sql_deleteHike($con, $this->id);
			foreach($sql_queries as $sql_query){
				if(!$sql_query->execute()) die('There was an error running the query ['.$con->error.']');
			}
		}
		
	}
	
?>