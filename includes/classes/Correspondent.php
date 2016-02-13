<?php
	
	class Correspondents{
		
		public $correspondents;
		
		public function __construct(){
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
		            $ADK_CORRESPONDENT->datetime = $row['ADK_CORR_DTE'];
					array_push($this->correspondents, $ADK_CORRESPONDENT);
		        }
		    }
		    else die('There was an error running the query ['.$con->error.']');
		}
		
		public function getMatchingNames($con, $term){
		    $ADK_CORRESPONDENT_NAMES = [];
			$sql_query = sql_getMatchingCorrespondents($con, $term);
		    if($sql_query->execute()){
		        $sql_query->store_result();
		        $result = sql_get_assoc($sql_query);

		        foreach($result as $row) array_push($ADK_CORRESPONDENT_NAMES, $row['ADK_CORRESPONDENT']);
		    }
		    else die('There was an error running the query ['.$con->error.']');

			return $ADK_CORRESPONDENT_NAMES;
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
								<th>Member Since</th>
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
							<td>".date('m/d/Y', strtotime($ADK_CORRESPONDENT->datetime))."</td>
							<td>".$ADK_CORRESPONDENT->numhikers."</td>
						</tr>";
			}
		
			$html .= "</tbody></table>";
		
			echo $html;
		}
				
	}
	
	class Correspondent{
		
		public $err;
		public $id, $photoid, $username, $name, $email, $info, $numhikers, $datetime;
		
		public function __construct(){
			
		}

		public function sanitize(){
			$this->info = str_replace('<iframe', '</iframe', $this->info);
			$this->info = str_replace('<script', '</script', $this->info);
		}
		
		public function save($con){
			$sql_query = sql_addCorrespondent($con, $this);
			$sql_query->execute();
			$this->id = $sql_query->insert_id;
		}
		
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
					$this->numhikers = $row['ADK_CORR_NUMHIKERS'];
				}
			}
			else die('There was an error running the query ['.$con->error.']');
		}
		
		public function update($con){
			$sql_query = sql_updateCorrespondent($con, $this);
			$sql_query->execute();
		}

		public function updatePhotoID($con){
		    $sql_query = sql_updateCorrPhotoID($con, $this);
		    $sql_query->execute();
		}
				
		public function reassignHikers($con, $old_ADK_CORRESPONDENT_ID){
			$sql_query = sql_updateReassignCorrsHikers($con, $this->id, $old_ADK_CORRESPONDENT_ID);
			$sql_query->execute();
		}

		public function delete($con){
			$sql_query = sql_deleteCorrespondent($con, $this->id);
			if(!$sql_query->execute()) die('There was an error running the query ['.$con->error.']');
		}
		
	}
	
?>