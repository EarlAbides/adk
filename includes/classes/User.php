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
		
	}
	
?>