<?php
	
	class Applicants{
		
		public $applicants;
		
		public function __construct(){
			$this->applicants = [];
		}
		
		public function get($con){
			$sql_query = sql_getApplicants($con);
			if($sql_query->execute()){
				$sql_query->store_result();
				$result = sql_get_assoc($sql_query);

				foreach($result as $row){
					$ADK_APPLICANT = new Applicant();
					$ADK_APPLICANT->id = $row['ADK_APPLICANT_ID'];
					$ADK_APPLICANT->username = $row['ADK_APPLICANT_USERNAME'];
					$ADK_APPLICANT->name = $row['ADK_APPLICANT_NAME'];
					$ADK_APPLICANT->email = $row['ADK_APPLICANT_EMAIL'];
					$ADK_APPLICANT->phone = $row['ADK_APPLICANT_PHONE'];
					$ADK_APPLICANT->state = $row['ADK_APPLICANT_STATE'];
					$ADK_APPLICANT->datetime = $row['ADK_APPLICANT_DTE'];
					array_push($this->applicants, $ADK_APPLICANT);
				}
			}
			else die('There was an error running the query ['.$con->error.']');
		}
		
		public function renderTable(){
			$html = "<table class=\"selecttable\">
						<thead>
							<tr>
								<th style=\"width:2%;\"></th>
								<th style=\"width:28%;\">Name</th>
								<th style=\"width:23%;\">Username</th>
								<th style=\"width:22%;\">Email</th>
								<th style=\"width:7%;\">Phone</th>
								<th style=\"width:8%;\">State</th>
								<th style=\"width:10%;\">Date Added</th>
							</tr>
						</thead>
						<tbody>";
			if(count($this->applicants) === 0){//If empty
				$html .= '<tr><td colspan="6" style="text-align:center;font-style:italic;">No new applicants</td></tr>';
			}	
			else{
				foreach($this->applicants as $ADK_APPLICANT){
					$html .= "<tr>
								<td>
									<a href=\"./applicant?_=".$ADK_APPLICANT->id."\" class=\"hoverbtn rowselector\">
										<span class=\"glyphicon glyphicon-search\" title=\"View\" data-toggle=\"tooltip\" data-placement=\"right\" data-container=\"body\"></span>
									</a>
								</td>
								<td>".$ADK_APPLICANT->name."</td>
								<td>".$ADK_APPLICANT->username."</td>
								<td>".$ADK_APPLICANT->email."</td>
								<td>".$ADK_APPLICANT->phone."</td>
								<td>".$ADK_APPLICANT->state."</td>
								<td>".date('m/d/Y h:ia', strtotime($ADK_APPLICANT->datetime))."</td>
							</tr>";
				}
			}
			
			$html .= "</tbody></table>";
			
			echo $html;
		}
		
	}
	
	class Applicant{
		
		public $err;
		public $id, $username, $name, $email, $phone, $age, $sex, $address1, $address2, $city, $state, $zip, $country, $info, $reqcorr, $peakids, $peaks, $peaklist, $datetime;
		
		public function __construct(){
			$this->peaks = [];
		}
		
		public function isValid(){
			if(strlen($this->username) === 0 || strlen($this->username) > 45) $this->err .= 'u';
			if(strlen($this->name) === 0 || strlen($this->name) > 40) $this->err .= 'n';
			if(strlen($this->email) === 0 || strlen($this->email) > 50) $this->err .= 'e';
			if(!filter_var($this->email, FILTER_VALIDATE_EMAIL) > 50) $this->err .= 'e';
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
			$sql_query = sql_addApplicant($con, $this);
			$sql_query->execute();
			$this->id = $sql_query->insert_id;
		}
		
		public function addPeak($con, $ADK_PEAK){
			$sql_query = sql_addApplicantPeakJcts($con, $this->id, $ADK_PEAK->id);
			$sql_query->execute();
		}
		
		public function get($con){
			$sql_query = sql_getApplicant($con, $this->id);
			if($sql_query->execute()){
				$sql_query->store_result();
				$result = sql_get_assoc($sql_query);
				
				foreach($result as $row){
					$this->username = $row['ADK_APPLICANT_USERNAME'];
					$this->name = $row['ADK_APPLICANT_NAME'];
					$this->email = $row['ADK_APPLICANT_EMAIL'];
					$this->phone = $row['ADK_APPLICANT_PHONE'];
					$this->age = $row['ADK_APPLICANT_AGE'] != 0? $row['ADK_APPLICANT_AGE']: '';
					$this->sex = $row['ADK_APPLICANT_SEX'];
					$this->address1 = $row['ADK_APPLICANT_ADDRESS1'];
					$this->address2 = $row['ADK_APPLICANT_ADDRESS2'];
					$this->city = $row['ADK_APPLICANT_CITY'];
					$this->state = $row['ADK_APPLICANT_STATE'];
					$this->zip = preg_replace('/(\d{5})(\d{4})/i', '-', $row['ADK_APPLICANT_ZIP']);
					$this->country = $row['ADK_APPLICANT_COUNTRY'];
					$this->info = $row['ADK_APPLICANT_PERSONALINFO'];
					$this->reqcorr = $row['ADK_APPLICANT_REQ_CORR'];
					$this->peaklist = ltrim($row['ADK_APPLICANT_PEAKLIST']);
					
					$sql_query = sql_getApplicantsPeaks($con, $this->id);
					if($sql_query->execute()){
						$sql_query->store_result();
						$result = sql_get_assoc($sql_query);

						foreach($result as $row){
							$ADK_PEAK = new Peak();
							$ADK_PEAK->id = intval($row['ADK_PEAK_ID']);
							$ADK_PEAK->name = $row['ADK_PEAK_NAME'];
							$ADK_PEAK->height = $row['ADK_PEAK_HEIGHT'];
							array_push($this->peaks, $ADK_PEAK);
						}
					}
					else die('There was an error running the query ['.$con->error.']');
				}
			}
			else die('There was an error running the query ['.$con->error.']');
		}
		
		public function update($con){
			$sql_query = sql_updateApplicant($con, $this);
			$sql_query->execute();
		}
		
		public function delete($con){
			$this->deletePeaks($con);
			$sql_query = sql_deleteApplicant($con, $this->id);
			if(!$sql_query->execute()) die('There was an error running the query ['.$con->error.']');
		}
		
		public function deletePeaks($con){
			$sql_query = sql_deleteApplicantPeakJcts($con, $this->id);
			if(!$sql_query->execute()) die('There was an error running the query ['.$con->error.']');
		}
		
		public function populateFromSignUp(){
			$this->username = $_POST['username'];
			$this->name = $_POST['name'];
			$this->email = $_POST['email'];
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
			$this->reqcorr = $_POST['reqcorr'];
			$peakIDs = explode(',', $_POST['peakids']);
			foreach($peakIDs as $peakID){
				$ADK_PEAK = new Peak();
				$ADK_PEAK->id = intval($peakID);
				array_push($this->peaks, $ADK_PEAK);
			}
		}
		
		public function populateFromUpdate(){
			$this->id = intval($_POST['id']);
			$this->username = $_POST['username'];
			$this->name = $_POST['name'];
			$this->email = $_POST['email'];
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