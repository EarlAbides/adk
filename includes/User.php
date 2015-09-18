<?php
	
	function makeUserArray($ADK_USERGROUP_ID, $randomPW = ''){
	    if(isset($_POST['id'])) $id = intval($_POST['id']);
		else $id = '';
		
		$ADK_USER = array(
	        'ADK_USER_ID' => $id,
	        'ADK_USERGROUP_ID' => $ADK_USERGROUP_ID,
	        'ADK_USER_USERNAME' => $_POST['username'],
	        'ADK_USER_PASSWORD' => $randomPW,
			'ADK_USER_NAME' => $_POST['name'],
	        'ADK_USER_EMAIL' => $_POST['email']
	    );
		
	    return $ADK_USER;
	}
	
	function addUser($con, $ADK_USERGROUP_ID, $randomPW){
		$ADK_USER = makeUserArray($ADK_USERGROUP_ID, $randomPW);
		
		//Check username not exists
		$goodUsername = checkUserName($con, $ADK_USER['ADK_USER_USERNAME']);
		if(!$goodUsername){header('Location: ../applicant?_='.$_POST['id'].'&u'); exit;}//TODO: This needs to go back to correspondents OR applicants, depending
		
		//Add to database
		$sql_query = sql_addUser($con, $ADK_USER);
		$sql_query->execute();
		$ADK_USER['ADK_USER_ID'] = $sql_query->insert_id;
		
		return $ADK_USER;
	}
	
	function getUser($con, $ADK_USER_ID){
        $ADK_USER = '';
		$sql_query = sql_getUser($con, $ADK_USER_ID);
		if($sql_query->execute()){
            $sql_query->store_result();
            $result = sql_get_assoc($sql_query);

            foreach($result as $row){
				$ADK_USER['ADK_USER_ID'] = $row['ADK_USER_ID'];
		        $ADK_USER['ADK_USER_USERNAME'] = $row['ADK_USER_USERNAME'];
		        $ADK_USER['ADK_USER_NAME'] = $row['ADK_USER_NAME'];
		        $ADK_USER['ADK_USER_EMAIL'] = $row['ADK_USER_EMAIL'];
			}
		}
		else die('There was an error running the query ['.$con->error.']');
		
		return $ADK_USER;
	}
	
	function getUserEmail($con, $ADK_USER_ID){
        $ADK_USER_EMAIL = '';
		$sql_query = sql_getUserEmail($con, $ADK_USER_ID);
		if($sql_query->execute()){
            $sql_query->store_result();
            $sql_query->bind_result($result);
            $sql_query->fetch();
            $ADK_USER_EMAIL = $result;
		}
		else die('There was an error running the query ['.$con->error.']');
		
		return $ADK_USER_EMAIL;
	}

	function updateUser($con, $ADK_USERGROUP_ID){
		$ADK_USER = makeUserArray($ADK_USERGROUP_ID);
		
		//Check username not exists
		$exempt = $ADK_USER['ADK_USER_USERNAME'];
		$goodUsername = checkApplicantAndUserName($con, $ADK_USER['ADK_USER_USERNAME'], $exempt);
		if(!$goodUsername){header('Location: ../?u=INEEDTOFIXTHIS'); exit;}//TODO: This. maybe pass in page as arg? or as post var? no, first is better
		
		$sql_query = sql_updateUser($con, $ADK_USER);
		$sql_query->execute();
		
		return $ADK_USER['ADK_USER_ID'];
	}
	
	function updateUserPW($con, $ADK_USER_ID, $ADK_USER_PASSWORD){
		$sql_query = sql_updateUserPassword($con, $ADK_USER_ID, $ADK_USER_PASSWORD);
		$sql_query->execute();
		
		return true;
	}
	
	function checkApplicantAndUserName($con, $ADK_APPLICANT_USERNAME, $exempt){
		$COUNT = 0;
		
		$sql_query = sql_checkApplicantAndUsernameNotExists($con, $ADK_APPLICANT_USERNAME, $exempt);
		if($sql_query->execute()){
            $sql_query->store_result();
            $sql_query->bind_result($result);
            $sql_query->fetch();
            $COUNT = $result;
		}
		else die('There was an error running the query ['.$con->error.']');
		
		return $COUNT == 0;
	}
	
	function checkUserName($con, $ADK_USER_USERNAME){
        $COUNT = 0;
		$sql_query = sql_checkUsernameNotExists($con, $ADK_USER_USERNAME);
		if($sql_query->execute()){
            $sql_query->store_result();
            $sql_query->bind_result($result);
            $sql_query->fetch();
            $COUNT = $result;
		}
		else die('There was an error running the query ['.$con->error.']');
		
		return $COUNT == 0;
	}
	
	function checkUserOldPassword($con, $ADK_USER_ID, $ADK_USER_PASSWORD){
        $COUNT = 0;
		$sql_query = sql_checkUserOldPassword($con, $ADK_USER_ID, $ADK_USER_PASSWORD);
		if($sql_query->execute()){
            $sql_query->store_result();
            $sql_query->bind_result($result);
            $sql_query->fetch();
            $COUNT = $result;
		}
		else die('There was an error running the query ['.$con->error.']');
		
		return $COUNT == 1;
	}
	
	function checkIsUser($con, $ADK_USER_USERNAME, $ADK_USER_EMAIL){
        $ADK_USER = '';
		$sql_query = sql_checkIsUser($con, $ADK_USER_USERNAME, $ADK_USER_EMAIL);
		if($sql_query->execute()){
            $sql_query->store_result();
            $result = sql_get_assoc($sql_query);

            foreach($result as $row){
				$ADK_USER['ADK_USER_ID'] = $row['ADK_USER_ID'];
		        $ADK_USER['ADK_USER_USERNAME'] = $row['ADK_USER_USERNAME'];
		        $ADK_USER['ADK_USER_NAME'] = $row['ADK_USER_NAME'];
		        $ADK_USER['ADK_USER_EMAIL'] = $row['ADK_USER_EMAIL'];
				$ADK_USER['last8hash'] = $row['last8hash'];
			}
		}
		else die('There was an error running the query ['.$con->error.']');
		
		return $ADK_USER;
	}
	
	function checkValidHash($con, $ADK_USER_ID, $last8hash){
        //$COUNT = 0;
        //$sql_query = sql_checkValidHash($ADK_USER_ID, $last8hash);
        
        //if($result = $con->query($sql_query)){
        //    while($row = $result->fetch_assoc())
        //        $COUNT = $row['COUNT'];
        //    $result->free();
        //}
        //else die('There was an error running the query ['.$con->error.']');
		
        //return $COUNT;

        $COUNT = 0;
		$sql_query = sql_checkValidHash($con, $ADK_USER_ID, $last8hash);
		if($sql_query->execute()){
            $sql_query->store_result();
            $sql_query->bind_result($result);
            $sql_query->fetch();
            $COUNT = $result;
		}
		else die('There was an error running the query ['.$con->error.']');
		
		return $COUNT == 1;
	}
	
?>