<?php
	
	//Applicant
	function sql_deleteApplicant($con, $ADK_APPLICANT_ID){
		$sql_query = $con->prepare("DELETE FROM ADK_APPLICANT WHERE ADK_APPLICANT_ID = ?;");

        $sql_query->bind_param('i', $ADK_APPLICANT_ID);

        return $sql_query;
	}
	
	//Hike
	function sql_deleteHike($con, $ADK_HIKE_ID){
		$sql_query = $con->prepare("DELETE FROM ADK_HIKE WHERE ADK_HIKE_ID = ?;");

        $sql_query->bind_param('i', $ADK_HIKE_ID);

        return $sql_query;
	}
	
	function sql_deleteHikePeakJcts($con, $ADK_HIKE_ID){
		$sql_query = $con->prepare("DELETE FROM ADK_HIKE_PEAK_JCT WHERE ADK_HIKE_ID = ?;");

        $sql_query->bind_param('i', $ADK_HIKE_ID);

        return $sql_query;
	}
	
	function sql_deleteHikeFileJcts($con, $ADK_HIKE_ID){
		$sql_query = $con->prepare("DELETE FROM ADK_HIKE_FILE_JCT WHERE ADK_HIKE_ID = ?;");

        $sql_query->bind_param('i', $ADK_HIKE_ID);

        return $sql_query;
	}

    //Hiker
    function sql_deleteHiker($con, $ADK_USER_ID){
        $queries = array(
            "SET SQL_SAFE_UPDATES = 0;"
            ,"DELETE FROM ADK_FILE WHERE ADK_FILE_ID IN(SELECT ADK_FILE_ID FROM ADK_MESSAGE WHERE ADK_MESSAGE_FROM_USER_ID = ? OR ADK_MESSAGE_TO_USER_ID = ?);"
            ,"DELETE FROM ADK_FILE WHERE ADK_FILE_ID IN(SELECT ADK_FILE_ID FROM ADK_HIKE WHERE ADK_USER_ID = ?);"
            ,"DELETE FROM ADK_MESSAGE_FILE_JCT WHERE ADK_MESSAGE_ID IN(SELECT ADK_MESSAGE_ID FROM ADK_MESSAGE WHERE ADK_MESSAGE_FROM_USER_ID = ? OR ADK_MESSAGE_TO_USER_ID = ?);"
            ,"DELETE FROM ADK_MESSAGE WHERE ADK_MESSAGE_FROM_USER_ID = ? OR ADK_MESSAGE_TO_USER_ID = ?;"
            ,"DELETE FROM ADK_HIKE_PEAK_JCT WHERE ADK_HIKE_ID IN(SELECT ADK_HIKE_ID FROM ADK_HIKE WHERE ADK_USER_ID = ?);"
            ,"DELETE FROM ADK_HIKE WHERE ADK_USER_ID = ?;"
            ,"DELETE FROM ADK_HIKER WHERE ADK_USER_ID = ?;"
            ,"DELETE FROM ADK_USER WHERE ADK_USER_ID = ?;"
            ,"SET SQL_SAFE_UPDATES = 1;"
        );
        
        $sql_queries = array(
            $con->prepare($queries[0])
            ,$con->prepare($queries[1])
            ,$con->prepare($queries[2])
            ,$con->prepare($queries[3])
            ,$con->prepare($queries[4])
            ,$con->prepare($queries[5])
            ,$con->prepare($queries[6])
            ,$con->prepare($queries[7])
            ,$con->prepare($queries[8])
            ,$con->prepare($queries[9])
        );

        for($i = 0; $i < count($sql_queries); $i++){
            $_ADK_USER_ID = []; $types = '';
            $qCount = substr_count($queries[$i], '?');
            for($j = 0; $j < $qCount; $j++) array_push($_ADK_USER_ID, $ADK_USER_ID);
            foreach($_ADK_USER_ID as $id) $types .= 'i';
            $_ADK_USER_ID = array_merge(array($types), $_ADK_USER_ID);
            if($qCount > 0) call_user_func_array(array($sql_queries[$i], 'bind_param'), refValues($_ADK_USER_ID));
        }

        return $sql_queries;
    }

    function refValues($arr){//Needed for above func
        $refs = array();
        foreach($arr as $key => $value) $refs[$key] = &$arr[$key];
        return $refs;
    }

?>