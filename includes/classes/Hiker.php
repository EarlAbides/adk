<?php
	
	class Hikers{
		
		public $hikers;
		
		public function Hikers(){
			$this->hikers = [];
		}
		
		public function get($con, $ADK_HIKER_CORR_ID){
			$sql_query = sql_getHikers($con, $ADK_HIKER_CORR_ID);
			if($sql_query->execute()){
				$sql_query->store_result();
				$result = sql_get_assoc($sql_query);

				foreach($result as $row){
					$ADK_HIKER = new Hiker();
					$ADK_HIKER->id = $row['ADK_USER_ID'];
					$ADK_HIKER->corrid = $row['ADK_HIKER_CORR_ID'];
					$ADK_HIKER->corrname = $row['ADK_HIKER_CORR_NAME'];
					$ADK_HIKER->username = $row['ADK_USER_USERNAME'];
					$ADK_HIKER->name = $row['ADK_USER_NAME'];
					$ADK_HIKER->email = $row['ADK_USER_EMAIL'];
					$ADK_HIKER->numpeaks = $row['ADK_HIKER_NUMPEAKS'];
					$ADK_HIKER->lastactive = $row['ADK_HIKER_LASTACTIVE_DTE'];
					array_push($this->hikers, $ADK_HIKER);
				}
			}
			else die('There was an error running the query ['.$con->error.']');
		}
		
		public function renderTable(){
		    $html = "<table class=\"selecttable\">
						<thead>
							<tr>
								<th></th>
								<th>Name</th>
								<th>Username</th>
								<th>Email</th>
								<th>Staff Correspondent</th>
								<th>Last Active</th>
								<th>#&nbsp;Peaks</th>
							</tr>
						</thead>
						<tbody>";
		
			if(count($this->hikers) === 0){//If empty
				$html .= '<tr><td colspan="7" style="text-align:center;font-style:italic;">No hikers</td></tr>';
			}	
			else{
				foreach($this->hikers as $ADK_HIKER){
					$ADK_HIKER->lastactive = date("m/d/Y", strtotime($ADK_HIKER->lastactive));
					if(strpos(date("n/j/y", strtotime($ADK_HIKER->lastactive)), '1/1/70') === 0) $ADK_HIKER->lastactive = '--';
					$html .= "<tr>
								<td>
									<a href=\"./hiker?_=".$ADK_HIKER->id."\" class=\"hoverbtn rowselector\">
										<span class=\"glyphicon glyphicon-search\" title=\"View\" data-toggle=\"tooltip\" data-placement=\"right\" data-container=\"body\"></span>
									</a>
								</td>
								<td>".$ADK_HIKER->name."</td>
								<td>".$ADK_HIKER->username."</td>
								<td>".$ADK_HIKER->email."</td>
								<td>".$ADK_HIKER->corrname."</td>
								<td>".$ADK_HIKER->lastactive."</td>
								<td>".$ADK_HIKER->numpeaks."</td>
							</tr>";
				}
			}
		
			$html .= "</tbody></table>";
			
		    echo $html;
		}
		
	}
	
	class Hiker{
		
		public $err;
		public $id, $corrid, $corrname, $photoid, $username, $name, $email, $phone, $age, $sex, $address1, $address2, $city, $state, $zip, $country, $info, $numpeaks, $hikes, $lastactive;
		
		public function Hiker(){
			$this->hikes = [];
		}
		
		public function isValid(){
		    if(strlen($this->address1) === 0 || strlen($this->address1) > 40) $this->err .= 'a';
		    if(strlen($this->city) === 0 || strlen($this->city) > 40) $this->err .= 'c';
		    if(strlen($this->state) === 0 || strlen($this->state) > 2) $this->err .= 's';
		    if(strlen($this->country) === 0 || strlen($this->country) > 40) $this->err .= 'o';
		    if(strlen($this->info) === 0) $this->err .= 'i';
			
		    if(strlen($this->err) > 0) return false;
		    return true;
		}
		
		public function sanitize(){
			$this->info = str_replace('<iframe', '</iframe', $this->info);
			$this->info = str_replace('<script', '</script', $this->info);
		}
		
		public function save($con){
			$sql_query = sql_addHiker($con, $this);
			$sql_query->execute();
		}

		public function get($con){
			$sql_query = sql_getHiker($con, $this->id);
			if($sql_query->execute()){
				$sql_query->store_result();
				$result = sql_get_assoc($sql_query);

				foreach($result as $row){
					$this->corrid = $row['ADK_HIKER_CORR_ID'];
					$this->photoid = intval($row['ADK_HIKER_PHOTO_ID']);
					$this->username = $row['ADK_USER_USERNAME'];
					$this->name = $row['ADK_USER_NAME'];
					$this->email = $row['ADK_USER_EMAIL'];
					$this->phone = $row['ADK_HIKER_PHONE'];
					$this->age = $row['ADK_HIKER_AGE'] != 0? $row['ADK_HIKER_AGE']: '';
					$this->sex = $row['ADK_HIKER_SEX'];
					$this->address1 = $row['ADK_HIKER_ADDRESS1'];
					$this->address2 = $row['ADK_HIKER_ADDRESS2'];
					$this->city = $row['ADK_HIKER_CITY'];
					$this->state = $row['ADK_HIKER_STATE'];
					$this->zip = preg_replace('/(\d{5})(\d{4})/i', '-', $row['ADK_HIKER_ZIP']);
					$this->country = $row['ADK_HIKER_COUNTRY'];
					$this->info = $row['ADK_HIKER_PERSONALINFO'];
					$this->numpeaks = intval($row['ADK_HIKER_NUMPEAKS']);
				}
			}
			else die('There was an error running the query ['.$con->error.']');
		}
		
		public function update($con){
		    $sql_query = sql_updateHiker($con, $this);
		    $sql_query->execute();
		}

		public function updateCorr($con){
		    $sql_query = sql_updateHikerCorr($con, $this->id, $this->corrid);
		    $sql_query->execute();
		}

		public function updatePhotoID($con){
		    $sql_query = sql_updateHikerPhotoID($con, $this);
		    $sql_query->execute();
		}
		
		public function delete($con){
		    $sql_queries = sql_deleteHiker($con, $this->id);
			foreach($sql_queries as $sql_query){
				if(!$sql_query->execute()) die('There was an error running the query ['.$con->error.']');
			}
		}

		public function populateFromApplicant($ADK_USER_ID, $ADK_CORRESPONDENT_ID, $ADK_APPLICANT){
			$this->id = $ADK_USER_ID;
			$this->corrid = $ADK_CORRESPONDENT_ID;
			$this->phone = $ADK_APPLICANT->phone;
			$this->age = $ADK_APPLICANT->age;
			$this->sex = $ADK_APPLICANT->sex;
			$this->address1 = $ADK_APPLICANT->address1;
			$this->address2 = $ADK_APPLICANT->address2;
			$this->city = $ADK_APPLICANT->city;
			$this->state = $ADK_APPLICANT->state;
			$this->zip = $ADK_APPLICANT->zip;
			$this->country = $ADK_APPLICANT->country;
			$this->info = $ADK_APPLICANT->info;
		}

		public function populateFromUpdateHiker(){
			$this->id = intval($_POST['id']);
			$this->phone = $_POST['phone'];
			$this->age = $_POST['age'];
			$this->sex = $_POST['sex'];
			$this->address1 = $_POST['address1'];
			$this->address2 = $_POST['address2'];
			$this->city = $_POST['city'];
			$this->state = $_POST['state'];
			$this->zip = $_POST['zip'];
			$this->country = $_POST['country'];
			$this->info = $_POST['personalinfo'];
		}
		
	}
	
?>