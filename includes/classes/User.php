<?php
	
	class User{
		
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
		
		public function save($con){
			$sql_query = sql_addUser($con, $this);
			$sql_query->execute();
			$this->id = $sql_query->insert_id;
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