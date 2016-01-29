<?php
	
	class Hike{
		
		public $err;
		public $id, $userid, $notes, $datetime;
		
		public function Hike(){
			
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
		    $sql_query = sql_deleteHiker($con, $this->id);
		    if(!$sql_query->execute()) die('There was an error running the query ['.$con->error.']');
		}
		
	}
	
?>