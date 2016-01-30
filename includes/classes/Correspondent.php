<?php
	
	class Correspondents{
		
		public $correspondents;
		
		public function Correspondents(){
		    $this->correspondents = [];
		}
		
		public function get($con){
		    $sql_query = sql_getCorrespondents($con);
		    if($sql_query->execute()){
		        $sql_query->store_result();
		        $result = sql_get_assoc($sql_query);

		        foreach($result as $row){
		            $ADK_CORRESPONDENT = new Correspondent();
		            $ADK_CORRESPONDENT->id = $row['ADK_USER_ID'];
		            $ADK_CORRESPONDENT->photoid = $row['ADK_CORR_PHOTO_ID'];
		            $ADK_CORRESPONDENT->username = $row['ADK_USER_USERNAME'];
		            $ADK_CORRESPONDENT->name = $row['ADK_USER_NAME'];
		            $ADK_CORRESPONDENT->email = $row['ADK_USER_EMAIL'];
		            $ADK_CORRESPONDENT->phone = $row['ADK_CORR_PERSONALINFO'];
		            $ADK_CORRESPONDENT->numhikers = intval($row['ADK_CORR_NUMHIKERS']);
					array_push($this->correspondents, $ADK_CORRESPONDENT);
		        }
		    }
		    else die('There was an error running the query ['.$con->error.']');
		}
		
		public function renderSelectTable(){
			$html = "<table id=\"table_assignCorr\" class=\"selecttable\">
						<thead>
							<tr>
								<th class=\"pointer\">Name</th>
								<th class=\"pointer\">Username</th>
								<th class=\"pointer\">Email</th>
								<th class=\"pointer\"># Hikers</th>
								<th></th>
							</tr>
						</thead>
						<tbody>";
		
			foreach($this->correspondents as $ADK_CORRESPONDENT){
				$html .= "<tr data-id=\"".$ADK_CORRESPONDENT->id."\">
							<td>".$ADK_CORRESPONDENT->name."</td>
							<td>".$ADK_CORRESPONDENT->username."</td>
							<td>".$ADK_CORRESPONDENT->email."</td>
							<td>".$ADK_CORRESPONDENT->numhikers."</td>
							<td><input type=\"radio\" name=\"corrid\" value=\"".$ADK_CORRESPONDENT->id."\" required /></td>
						</tr>";
			}
		
			$html .= "</tbody></table>";
		
			echo $html;
		}

		public function renderViewTable(){
			$html = "<table class=\"selecttable\">
						<thead>
							<tr>
								<th></th>
								<th>Name</th>
								<th>Username</th>
								<th>Email</th>
								<th>#&nbsp;Hikers</th>
							</tr>
						</thead>
						<tbody>";
		
			foreach($this->correspondents as $ADK_CORRESPONDENT){
				$html .= "<tr>
							<td>
								<a href=\"./correspondent?_=".$ADK_CORRESPONDENT->id."\" class=\"hoverbtn rowselector\">
									<span class=\"glyphicon glyphicon-search\"title=\"View\" data-toggle=\"tooltip\" data-placement=\"right\" data-container=\"body\"></span>
								</a>
							</td>
							<td>".$ADK_CORRESPONDENT->name."</td>
							<td>".$ADK_CORRESPONDENT->username."</td>
							<td>".$ADK_CORRESPONDENT->email."</td>
							<td>".$ADK_CORRESPONDENT->numhikers."</td>
						</tr>";
			}
		
			$html .= "</tbody></table>";
		
			echo $html;
		}
				
	}
	
	class Correspondent{
		
		public $err;
		public $id, $photoid, $username, $name, $email, $info, $numhikers;
		
		public function Correspondent(){
			
		}
		
		// public function isValid(){
			// if(strlen($this->username) === 0 || strlen($this->username) > 45) $this->err .= 'u';
			// if(strlen($this->name) === 0 || strlen($this->name) > 40) $this->err .= 'n';
			// if(strlen($this->email) === 0 || strlen($this->email) > 50) $this->err .= 'e';
			// if(!filter_var($this->email, FILTER_VALIDATE_EMAIL) > 50) $this->err .= 'e';
			// if(strlen($this->address1) === 0 || strlen($this->address1) > 40) $this->err .= 'a';
			// if(strlen($this->city) === 0 || strlen($this->city) > 40) $this->err .= 'c';
			// if(strlen($this->state) === 0 || strlen($this->state) > 2) $this->err .= 's';
			// if(strlen($this->country) === 0 || strlen($this->country) > 40) $this->err .= 'o';
			// if(strlen($this->info) === 0) $this->err .= 'i';
			
			// if(strlen($this->err) > 0) return false;
			// return true;
		// }

		// public function sanitize(){
			// $this->info = str_replace('<iframe', '</iframe', $this->info);
			// $this->info = str_replace('<script', '</script', $this->info);
		// }
		
		// public function save($con){
			// $sql_query = sql_addApplicant($con, $this);
			// $sql_query->execute();
			// $this->id = $sql_query->insert_id;
		// }
		
		public function get($con){
			$sql_query = sql_getCorrespondent($con, $this->id);
			if($sql_query->execute()){
				$sql_query->store_result();
				$result = sql_get_assoc($sql_query);

				foreach($result as $row){
					$this->id = intval($row['ADK_USER_ID']);
					$this->photoid = intval($row['ADK_CORR_PHOTO_ID']);
					$this->username = $row['ADK_USER_USERNAME'];
					$this->name = $row['ADK_USER_NAME'];
					$this->email = $row['ADK_USER_EMAIL'];
					$this->info = $row['ADK_CORR_PERSONALINFO'];
					//$this->numhikers = $row['ADK_CORR_PERSONALINFO'];
				}
			}
			else die('There was an error running the query ['.$con->error.']');
		}
		
		// public function update($con){
			// $sql_query = sql_updateApplicant($con, $this);
			// $sql_query->execute();
		// }
		
		// public function delete($con){
			// $sql_query = sql_deleteApplicant($con, $this->id);
			// if(!$sql_query->execute()) die('There was an error running the query ['.$con->error.']');
		// }
		
		// public function populateFromSignUp(){
			// $this->username = $_POST['username'];
			// $this->name = $_POST['name'];
			// $this->email = $_POST['email'];
			// $this->phone = $_POST['phone'];
			// $this->age = $_POST['age'];
			// $this->sex = $_POST['sex'];
			// $this->address1 = $_POST['address1'];
			// $this->address2 = $_POST['address2'];
			// $this->city = $_POST['city'];
			// $this->state = $_POST['state'];
			// $this->zip = $_POST['zip'];
			// $this->country = $_POST['country'];
			// $this->info = $_POST['personalinfo'];
			// $this->reqcorr = $_POST['reqcorr'];
			// $this->peakids = $_POST['peakids'];
		// }
		
	}
	
?>