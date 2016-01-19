<?php
	
	function makeHikerArray(){
	    if(isset($_POST['id'])) intval($id = $_POST['id']);
	    else $id = '';
		
	    $ADK_HIKER = array(
	        'ADK_USER_ID' => $id,
	        'ADK_HIKER_CORR_ID' => intval($_POST['corrid']),
	        'ADK_HIKER_PHONE' => $_POST['phone'],
	        'ADK_HIKER_AGE' => intval($_POST['age']),
	        'ADK_HIKER_SEX' => $_POST['sex'],
	        'ADK_HIKER_ADDRESS1' => $_POST['address1'],
	        'ADK_HIKER_ADDRESS2' => $_POST['address2'],
	        'ADK_HIKER_CITY' => $_POST['city'],
	        'ADK_HIKER_STATE' => $_POST['state'],
	        'ADK_HIKER_ZIP' => $_POST['zip'],
	        'ADK_HIKER_COUNTRY' => $_POST['country'],
	        'ADK_HIKER_PERSONALINFO' => $_POST['personalinfo']
	    );
		
	    return $ADK_HIKER;
	}
	
	function makeHikerArrayFromApplicant($ADK_APPLICANT, $ADK_USER_ID, $ADK_HIKER_CORR_ID){
		$ADK_HIKER = array(
			'ADK_USER_ID' => $ADK_USER_ID,
			'ADK_USERGROUP_ID' => 3,
			'ADK_HIKER_CORR_ID' => $ADK_HIKER_CORR_ID,
			'ADK_USER_USERNAME' => $ADK_APPLICANT['ADK_APPLICANT_USERNAME'],
			'ADK_USER_NAME' => $ADK_APPLICANT['ADK_APPLICANT_NAME'],
			'ADK_USER_EMAIL' => $ADK_APPLICANT['ADK_APPLICANT_EMAIL'],
			'ADK_HIKER_PHONE' => $ADK_APPLICANT['ADK_APPLICANT_PHONE'],
			'ADK_HIKER_AGE' => $ADK_APPLICANT['ADK_APPLICANT_AGE'],
			'ADK_HIKER_SEX' => $ADK_APPLICANT['ADK_APPLICANT_SEX'],
			'ADK_HIKER_ADDRESS1' => $ADK_APPLICANT['ADK_APPLICANT_ADDRESS1'],
			'ADK_HIKER_ADDRESS2' => $ADK_APPLICANT['ADK_APPLICANT_ADDRESS2'],
			'ADK_HIKER_CITY' => $ADK_APPLICANT['ADK_APPLICANT_CITY'],
			'ADK_HIKER_STATE' => $ADK_APPLICANT['ADK_APPLICANT_STATE'],
			'ADK_HIKER_ZIP' => $ADK_APPLICANT['ADK_APPLICANT_ZIP'],
			'ADK_HIKER_COUNTRY' => $ADK_APPLICANT['ADK_APPLICANT_COUNTRY'],
			'ADK_HIKER_PERSONALINFO' => $ADK_APPLICANT['ADK_APPLICANT_PERSONALINFO']
		);
		
		return $ADK_HIKER;
	}
	
	function getHikers($con, $ADK_HIKER_CORR_ID = '%'){
		$ADK_HIKERS = '';
		$sql_query = sql_getHikers($con, $ADK_HIKER_CORR_ID);
		if($sql_query->execute()){
            $sql_query->store_result();
            $result = sql_get_assoc($sql_query);

            $i = 0;
			foreach($result as $row){
				$ADK_HIKERS[$i]['ADK_USER_ID'] = $row['ADK_USER_ID'];
				$ADK_HIKERS[$i]['ADK_HIKER_CORR_ID'] = $row['ADK_HIKER_CORR_ID'];
				$ADK_HIKERS[$i]['ADK_HIKER_CORR_NAME'] = $row['ADK_HIKER_CORR_NAME'];
				$ADK_HIKERS[$i]['ADK_USER_USERNAME'] = $row['ADK_USER_USERNAME'];
				$ADK_HIKERS[$i]['ADK_USER_NAME'] = $row['ADK_USER_NAME'];
				$ADK_HIKERS[$i]['ADK_USER_EMAIL'] = $row['ADK_USER_EMAIL'];
				$ADK_HIKERS[$i]['ADK_HIKER_NUMPEAKS'] = $row['ADK_HIKER_NUMPEAKS'];
				$ADK_HIKERS[$i]['ADK_HIKER_LASTACTIVE_DTE'] = $row['ADK_HIKER_LASTACTIVE_DTE'];
				$i++;
			}
		}
		else die('There was an error running the query ['.$con->error.']');		
		
		return $ADK_HIKERS;
	}
	
	function getHiker($con, $ADK_USER_ID){
		$ADK_HIKER = '';
		$sql_query = sql_getHiker($con, $ADK_USER_ID);
		if($sql_query->execute()){
            $sql_query->store_result();
            $result = sql_get_assoc($sql_query);

            foreach($result as $row){
				$ADK_HIKER['ADK_USER_ID'] = $row['ADK_USER_ID'];
				$ADK_HIKER['ADK_HIKER_CORR_ID'] = $row['ADK_HIKER_CORR_ID'];
				$ADK_HIKER['ADK_USER_USERNAME'] = $row['ADK_USER_USERNAME'];
				$ADK_HIKER['ADK_USER_NAME'] = $row['ADK_USER_NAME'];
				$ADK_HIKER['ADK_USER_EMAIL'] = $row['ADK_USER_EMAIL'];
				$ADK_HIKER['ADK_HIKER_PHONE'] = $row['ADK_HIKER_PHONE'];
				$ADK_HIKER['ADK_HIKER_AGE'] = $row['ADK_HIKER_AGE'];
				if($ADK_HIKER['ADK_HIKER_AGE'] == 0) $ADK_HIKER['ADK_HIKER_AGE'] = '';
				$ADK_HIKER['ADK_HIKER_SEX'] = $row['ADK_HIKER_SEX'];
				$ADK_HIKER['ADK_HIKER_ADDRESS1'] = $row['ADK_HIKER_ADDRESS1'];
				$ADK_HIKER['ADK_HIKER_ADDRESS2'] = $row['ADK_HIKER_ADDRESS2'];
				$ADK_HIKER['ADK_HIKER_CITY'] = $row['ADK_HIKER_CITY'];
				$ADK_HIKER['ADK_HIKER_STATE'] = $row['ADK_HIKER_STATE'];
				$ADK_HIKER['ADK_HIKER_ZIP'] = $row['ADK_HIKER_ZIP'];
				$ADK_HIKER['ADK_HIKER_ZIP'] = preg_replace('/(\d{5})(\d{4})/i', '-', $ADK_HIKER['ADK_HIKER_ZIP']);
				$ADK_HIKER['ADK_HIKER_COUNTRY'] = $row['ADK_HIKER_COUNTRY'];
				$ADK_HIKER['ADK_HIKER_PERSONALINFO'] = $row['ADK_HIKER_PERSONALINFO'];
				$ADK_HIKER['ADK_HIKER_NUMPEAKS'] = $row['ADK_HIKER_NUMPEAKS'];
				$ADK_HIKER['ADK_HIKER_LASTACTIVE_DTE'] = $row['ADK_HIKER_LASTACTIVE_DTE'];
			}
		}
		else die('There was an error running the query ['.$con->error.']');
		
		return $ADK_HIKER;
	}
	
	function addHiker($con, $ADK_USER_ID){
		$ADK_APPLICANT = getApplicant($con, $_POST['id']);
		$ADK_HIKER = makeHikerArrayFromApplicant($ADK_APPLICANT, $ADK_USER_ID, $_POST['corrid']);
		
		$sql_query = sql_addHiker($con, $ADK_HIKER);
		$sql_query->execute();
		$ADK_HIKER['ADK_USER_ID'] = $sql_query->insert_id;
		
		return $ADK_HIKER;
	}
	
	function updateHiker($con){
		$ADK_HIKER = makeHikerArray();
		
		//Update
		$sql_query = sql_updateHiker($con, $ADK_HIKER);
		$sql_query->execute();
		
		return $ADK_HIKER['ADK_USER_ID'];
	}

    function deleteHiker($con, $ADK_USER_ID){
		$sql_queries = sql_deleteHiker($con, $ADK_USER_ID);
        foreach($sql_queries as $sql_query){
		    if($sql_query->execute()){}
		    else die('There was an error running the query ['.$con->error.']');
        }
	}
	
	function updateHikersCorr($con, $ADK_USER_ID, $ADK_CORR_ID){
		$sql_query = sql_updateHikersCorr($con, $ADK_USER_ID, $ADK_CORR_ID);
		$sql_query->execute();
	}
	
	function updateLastActive($con, $ADK_USER_ID){
		$sql_query = sql_updateLastActive($con, $ADK_USER_ID);
		$sql_query->execute();
	}

	function getTableHikers($ADK_HIKERS){
		$html = "<table class=\"selecttable\">
					<thead>
						<tr>
							<th></th>
							<th>Name</th>
							<th>Username</th>
							<th>Email</th>
							<th>Staff Correspondent</th>
							<th>Last Active</th>
							<th>#&nbsp;Peaks</th>
						</tr>
					</thead>
					<tbody>";
		
		if($ADK_HIKERS == ''){//If empty
			$html .= '<tr><td colspan="6" style="text-align:center;font-style:italic;">No hikers</td></tr>';
		}	
		else{
			foreach($ADK_HIKERS as $ADK_HIKER){
				$ADK_HIKER['ADK_HIKER_LASTACTIVE_DTE'] = date("m/d/Y", strtotime($ADK_HIKER['ADK_HIKER_LASTACTIVE_DTE']));
				if(strpos(date("n/j/y", strtotime($ADK_HIKER['ADK_HIKER_LASTACTIVE_DTE'])), '1/1/70') === 0) $ADK_HIKER['ADK_HIKER_LASTACTIVE_DTE'] = '--';
				$html .= "<tr>
							<td>
								<a href=\"./hiker?_=".$ADK_HIKER['ADK_USER_ID']."\" class=\"hoverbtn rowselector\">
									<span class=\"glyphicon glyphicon-search\" title=\"View\" data-toggle=\"tooltip\" data-placement=\"right\" data-container=\"body\"></span>
								</a>
							</td>
							<td>".$ADK_HIKER['ADK_USER_NAME']."</td>
							<td>".$ADK_HIKER['ADK_USER_USERNAME']."</td>
							<td>".$ADK_HIKER['ADK_USER_EMAIL']."</td>
							<td>".$ADK_HIKER['ADK_HIKER_CORR_NAME']."</td>
							<td>".$ADK_HIKER['ADK_HIKER_LASTACTIVE_DTE']."</td>
							<td>".$ADK_HIKER['ADK_HIKER_NUMPEAKS']."</td>
						</tr>";
			}
		}
		
		$html .= "</tbody></table>";
		
		return $html;
	}
	
?>