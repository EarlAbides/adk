<?php
	
	class User{
		
		public $err;
		public $id, $usergroupid, $username, $name, $email, $pw;
		
		public function User(){
			
		}
		
		public static function isUniqueUsername($con, $username, $exempt){
			$COUNT = 0;
			$sql_query = sql_isUniqueUsername($con, $username, $exempt);
			if($sql_query->execute()){
				$sql_query->store_result();
				$sql_query->bind_result($result);
				$sql_query->fetch();
				$COUNT = $result;
			}
			else die('There was an error running the query ['.$con->error.']');
			
			return $COUNT == 0;
		}
		
		public function isValid(){
			if(strlen($this->username) === 0 || strlen($this->username) > 45) $this->err .= 'u';
			if(strlen($this->name) === 0 || strlen($this->name) > 40) $this->err .= 'n';
			if(strlen($this->email) === 0 || strlen($this->email) > 50) $this->err .= 'e';
			
			if(strlen($this->err) > 0) return false;
			return true;
		}


		public function get($con){
			$sql_query = sql_getUser($con, $this->id);
			if($sql_query->execute()){
				$sql_query->store_result();
				$result = sql_get_assoc($sql_query);

				foreach($result as $row){
					$this->username = $row['ADK_USER_USERNAME'];
					$this->name = $row['ADK_USER_NAME'];
					$this->email = $row['ADK_USER_EMAIL'];
				}
			}
			else die('There was an error running the query ['.$con->error.']');
		}

		public function save($con){
			$sql_query = sql_addUser($con, $this);
			$sql_query->execute();
			$this->id = $sql_query->insert_id;
		}

		public function update($con){
			$sql_query = sql_updateUser($con, $this);
			$sql_query->execute();
		}


		public function populate(){
			if(isset($_POST['id'])) $this->id = intval($_POST['id']);
			$this->username = $_POST['username'];
			$this->name = $_POST['name'];
			$this->email = $_POST['email'];
		}
		
		public function populateFromAddHiker($randomPW, $ADK_APPLICANT){
			$this->usergroupid = 3;
			$this->username = $ADK_APPLICANT->username;
			$this->name = $ADK_APPLICANT->name;
			$this->email = $ADK_APPLICANT->email;
			$this->pw = $randomPW;
		}
		
	}
	
?>