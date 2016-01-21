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
			
			function sql_isUniqueUsername($con, $username, $exempt){
				$sql_query = $con->prepare(
					"SELECT
						(SELECT COUNT(*) FROM ADK_USER WHERE ADK_USER_USERNAME = ? AND ADK_USER_USERNAME <> ?) +
						(SELECT COUNT(*) FROM ADK_APPLICANT WHERE ADK_APPLICANT_USERNAME = ? AND ADK_APPLICANT_USERNAME <> ?)
					AS COUNT;"
				);
				
				$sql_query->bind_param('ssss', $username, $exempt, $username, $exempt);
				
				return $sql_query;
			}
		}
		
	}
	
?>