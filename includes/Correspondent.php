<?php
	
	function makeCorrespondentArray(){
		if(isset($_POST['id'])) $id = intval($_POST['id']);
		else $id = '';
		
		if(isset($_POST['photoid']) && $_POST['photoid'] !== '') $photoid = intval($_POST['$photoid']);
		else $photoid = null;
		
		$ADK_CORRESPONDENT = array(
			'ADK_USER_ID' => $id,
			'ADK_CORR_PHOTO_ID' => $photoid,
			'ADK_CORR_PERSONALINFO' => $_POST['personalinfo']
		);
		
		return $ADK_CORRESPONDENT;
	}
	
	function addCorrespondent($con, $ADK_USER_ID){
		$ADK_CORRESPONDENT = array(
			'ADK_USER_ID' => $ADK_USER_ID,
			'ADK_CORR_PERSONALINFO' => $_POST['personalinfo']
		);

        $sql_query = sql_addCorrespondent($con, $ADK_CORRESPONDENT);
		$sql_query->execute();

        return $ADK_CORRESPONDENT;
	}
	
	function getCorrespondents($con){
		$ADK_CORRESPONDENTS = '';
		$sql_query = sql_getCorrespondents($con);
		if($sql_query->execute()){
            $sql_query->store_result();
            $result = sql_get_assoc($sql_query);

            $i = 0;
			foreach($result as $row){
				$ADK_CORRESPONDENTS[$i]['ADK_USER_ID'] = $row['ADK_USER_ID'];
				$ADK_CORRESPONDENTS[$i]['ADK_USER_USERNAME'] = $row['ADK_USER_USERNAME'];
				$ADK_CORRESPONDENTS[$i]['ADK_USER_NAME'] = $row['ADK_USER_NAME'];
				$ADK_CORRESPONDENTS[$i]['ADK_USER_EMAIL'] = $row['ADK_USER_EMAIL'];
				$ADK_CORRESPONDENTS[$i]['ADK_CORR_PHOTO_ID'] = $row['ADK_CORR_PHOTO_ID'];
				$ADK_CORRESPONDENTS[$i]['ADK_CORR_PERSONALINFO'] = $row['ADK_CORR_PERSONALINFO'];
				$ADK_CORRESPONDENTS[$i]['ADK_CORR_NUMHIKERS'] = $row['ADK_CORR_NUMHIKERS'];
				$i++;
			}
		}
		else die('There was an error running the query ['.$con->error.']');		
		
		return $ADK_CORRESPONDENTS;
	}
	
	function getCorrespondent($con, $ADK_USER_ID){
		$ADK_CORRESPONDENT = '';
		$sql_query = sql_getCorrespondent($con, $ADK_USER_ID);
		if($sql_query->execute()){
            $sql_query->store_result();
            $result = sql_get_assoc($sql_query);

            foreach($result as $row){
				$ADK_CORRESPONDENT['ADK_USER_ID'] = intval($row['ADK_USER_ID']);
		        $ADK_CORRESPONDENT['ADK_USER_USERNAME'] = $row['ADK_USER_USERNAME'];
		        $ADK_CORRESPONDENT['ADK_USER_NAME'] = $row['ADK_USER_NAME'];
		        $ADK_CORRESPONDENT['ADK_USER_EMAIL'] = $row['ADK_USER_EMAIL'];
		        $ADK_CORRESPONDENT['ADK_CORR_PHOTO_ID'] = intval($row['ADK_CORR_PHOTO_ID']);
		        $ADK_CORRESPONDENT['ADK_CORR_PERSONALINFO'] = $row['ADK_CORR_PERSONALINFO'];
			}
		}
		else die('There was an error running the query ['.$con->error.']');
		
		return $ADK_CORRESPONDENT;
	}
	
	function getMatchingCorrespondents($con, $ADK_APPLICANT_REQ_CORR){
		$ADK_CORRESPONDENTS = '';
		$sql_query = sql_getMatchingCorrespondents($con, $ADK_APPLICANT_REQ_CORR);
		if($sql_query->execute()){
            $sql_query->store_result();
            $result = sql_get_assoc($sql_query);

            $i = 0;
			foreach($result as $row){
				$ADK_CORRESPONDENTS[$i] = $row['ADK_CORRESPONDENT'];
				$i++;
			}
		}
		else die('There was an error running the query ['.$con->error.']');		
		
		return $ADK_CORRESPONDENTS;
	}
	
	function updateCorrespondent($con){
		$ADK_CORRESPONDENT = makeCorrespondentArray();
		$sql_query = sql_updateCorrespondent($con, $ADK_CORRESPONDENT);
		$sql_query->execute();
		
		return $ADK_CORRESPONDENT['ADK_USER_ID'];
	}
	
	function updateCorrPhotoID($con, $ADK_USER_ID, $ADK_FILE_ID){
		$sql_query = sql_updateCorrPhotoID($con, $ADK_USER_ID, $ADK_FILE_ID);
		$sql_query->execute();
	}
	
	function updateReassignCorrsHikers($con, $ADK_USER_ID, $newCorrID){
		$sql_query = sql_updateReassignCorrsHikers($con, $ADK_USER_ID, $newCorrID);
		$sql_query->execute();
	}

	function deleteCorrespondent($con){
		//$ADK_APPLICANT = $_POST['id'];
				
		////Delete
		//$sql_query = sql_deleteApplicant($ADK_APPLICANT);
		//if($result = $con->query($sql_query)){}
		//else die('There was an error running the query ['.$con->error.']');
	}
	
	function getTableViewCorrespondents($ADK_CORRESPONDENTS){
		$html = "<table class=\"selecttable\">
					<thead>
						<tr>
							<th></th>
							<th class=\"pointer\">Name</th>
							<th class=\"pointer\">Username</th>
							<th class=\"pointer\">Email</th>
							<th class=\"pointer\">#&nbsp;Hikers</th>
							<th></th>
						</tr>
					</thead>
					<tbody>";
		
		foreach($ADK_CORRESPONDENTS as $ADK_CORRESPONDENT){
			$html .= "<tr>
						<td>
							<a href=\"./correspondent?_=".$ADK_CORRESPONDENT['ADK_USER_ID']."\" class=\"hoverbtn rowselector\">
								<span class=\"glyphicon glyphicon-search\"title=\"View\" data-toggle=\"tooltip\" data-placement=\"right\" data-container=\"body\"></span>
							</a>
						</td>
						<td>".$ADK_CORRESPONDENT['ADK_USER_NAME']."</td>
						<td>".$ADK_CORRESPONDENT['ADK_USER_USERNAME']."</td>
						<td>".$ADK_CORRESPONDENT['ADK_USER_EMAIL']."</td>
						<td>".$ADK_CORRESPONDENT['ADK_CORR_NUMHIKERS']."</td>
					</tr>";
		}
		
		$html .= "</tbody></table>";
		
		return $html;
	}
	
	function getTableSelectCorrespondents($ADK_CORRESPONDENTS){
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
		
		foreach($ADK_CORRESPONDENTS as $ADK_CORRESPONDENT){
			$html .= "<tr data-id=\"".$ADK_CORRESPONDENT['ADK_USER_ID']."\">
						<td>".$ADK_CORRESPONDENT['ADK_USER_NAME']."</td>
						<td>".$ADK_CORRESPONDENT['ADK_USER_USERNAME']."</td>
						<td>".$ADK_CORRESPONDENT['ADK_USER_EMAIL']."</td>
						<td>".$ADK_CORRESPONDENT['ADK_CORR_NUMHIKERS']."</td>
						<td><input type=\"radio\" name=\"corrid\" value=\"".$ADK_CORRESPONDENT['ADK_USER_ID']."\" required /></td>
					</tr>";
		}
		
		$html .= "</tbody></table>";
		
		return $html;
	}
	
?>