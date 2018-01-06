<?php

	class Prefs {

		private $prefs;
		
		public function __construct(){
			$prefs = [];
		}

		public function getUsersPrefs($con, $ADK_USER_ID) {
			$sql_query = sql_getUsersPrefs($con, $ADK_USER_ID);
			if($sql_query->execute()){
				$sql_query->store_result();
				$result = sql_get_assoc($sql_query);
				foreach($result as $row) $this->prefs[$row['ADK_PREF_NAME']] = $row['ADK_PREF_VAL'];
			}
			else die('There was an error running the query ['.$con->error.']');
		}

		public function get($name) {
			return $this->prefs[$name];
		}
		
		public function set($name, $value) {
			$this->prefs[$name] = $value;
		}
		
		public function save($con, $ADK_USER_ID) {
			foreach($this->prefs as $ADK_PREF_NAME => $ADK_PREF_VAL){
				$COUNT = 0;
				$sql_query = sql_isPrefSet($con, $ADK_USER_ID, $ADK_PREF_NAME);
				if($sql_query->execute()){
					$sql_query->store_result();
					$sql_query->bind_result($result);
					$sql_query->fetch();
					$COUNT = $result;
				}
				else die('There was an error running the query ['.$con->error.']');
				
				$sql_query = $COUNT == 1 ? sql_updateUserPref($con, $ADK_USER_ID, $ADK_PREF_NAME, $ADK_PREF_VAL) : sql_addUserPref($con, $ADK_USER_ID, $ADK_PREF_NAME, $ADK_PREF_VAL);
				$sql_query->execute();
			}
		}

	}
	
?>
