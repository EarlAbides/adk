<?php
	
	function makeApplicantArray(){
		if(isset($_POST['id'])) $id = intval($_POST['id']);
		else $id = '';

		if(isset($_POST['reqcorr'])){
			$ADK_APPLICANT = array(
				'ADK_APPLICANT_ID' => $id,
				'ADK_APPLICANT_USERNAME' => $_POST['username'],
				'ADK_APPLICANT_NAME' => $_POST['name'],
				'ADK_APPLICANT_EMAIL' => $_POST['email'],
				'ADK_APPLICANT_PHONE' => $_POST['phone'],
				'ADK_APPLICANT_AGE' => $_POST['age'],
				'ADK_APPLICANT_SEX' => $_POST['sex'],
				'ADK_APPLICANT_ADDRESS1' => $_POST['address1'],
				'ADK_APPLICANT_ADDRESS2' => $_POST['address2'],
				'ADK_APPLICANT_CITY' => $_POST['city'],
				'ADK_APPLICANT_STATE' => $_POST['state'],
				'ADK_APPLICANT_ZIP' => $_POST['zip'],
				'ADK_APPLICANT_COUNTRY' => $_POST['country'],
				'ADK_APPLICANT_PERSONALINFO' => $_POST['personalinfo'],
				'ADK_APPLICANT_REQ_CORR' => $_POST['reqcorr']
			);
		}
		else{
			$ADK_APPLICANT = array(
				'ADK_APPLICANT_ID' => $id,
				'ADK_APPLICANT_USERNAME' => $_POST['username'],
				'ADK_APPLICANT_NAME' => $_POST['name'],
				'ADK_APPLICANT_EMAIL' => $_POST['email'],
				'ADK_APPLICANT_PHONE' => $_POST['phone'],
				'ADK_APPLICANT_AGE' => $_POST['age'],
				'ADK_APPLICANT_SEX' => $_POST['sex'],
				'ADK_APPLICANT_ADDRESS1' => $_POST['address1'],
				'ADK_APPLICANT_ADDRESS2' => $_POST['address2'],
				'ADK_APPLICANT_CITY' => $_POST['city'],
				'ADK_APPLICANT_STATE' => $_POST['state'],
				'ADK_APPLICANT_ZIP' => $_POST['zip'],
				'ADK_APPLICANT_COUNTRY' => $_POST['country'],
				'ADK_APPLICANT_PERSONALINFO' => $_POST['personalinfo']
			);
		}
		
		return $ADK_APPLICANT;
	}
	
	function addApplicant($con){
		$ADK_APPLICANT = makeApplicantArray();
				
		$con = connect_db();//Connect to db
		if(mysqli_connect_errno())
			return 'Error';
		
		//Check username not exists
		$goodUsername = checkApplicantAndUserName($con, $ADK_APPLICANT['ADK_APPLICANT_USERNAME'], '');
		if(!$goodUsername){header('Location: ../signup?u='.$ADK_APPLICANT['ADK_APPLICANT_USERNAME']); exit;}
		
		//Add to database
		$sql_query = sql_addApplicant($con, $ADK_APPLICANT);
		$sql_query->execute();
		$ADK_APPLICANT['ADK_APPLICANT_ID'] = $sql_query->insert_id;
		
		return $ADK_APPLICANT;
	}
	
	function updateApplicant($con){
		$ADK_APPLICANT = makeApplicantArray();
		
		//Check username not exists
		$exempt = $ADK_APPLICANT['ADK_APPLICANT_USERNAME'];
		$goodUsername = checkApplicantAndUserName($con, $ADK_APPLICANT['ADK_APPLICANT_USERNAME'], $exempt);
		if(!$goodUsername){header('Location: ../editApplicant?u'); exit;}
		
		//Update
		$sql_query = sql_updateApplicant($con, $ADK_APPLICANT);
		$sql_query->execute();
		
		return $ADK_APPLICANT['ADK_APPLICANT_ID'];
	}
	
	function deleteApplicant($con){
		$ADK_APPLICANT = $_POST['id'];
		$sql_query = sql_deleteApplicant($con, $ADK_APPLICANT);
		if($sql_query->execute()){}
		else die('There was an error running the query ['.$con->error.']');
	}
	
	function getApplicants($con){
		$ADK_APPLICANTS = '';
		$sql_query = sql_getApplicants($con);
		if($sql_query->execute()){
            $sql_query->store_result();
            $result = sql_get_assoc($sql_query);

            $i = 0;
			foreach($result as $row){
				$ADK_APPLICANTS[$i]['ADK_APPLICANT_ID'] = $row['ADK_APPLICANT_ID'];
				$ADK_APPLICANTS[$i]['ADK_APPLICANT_USERNAME'] = $row['ADK_APPLICANT_USERNAME'];
				$ADK_APPLICANTS[$i]['ADK_APPLICANT_NAME'] = $row['ADK_APPLICANT_NAME'];
				$ADK_APPLICANTS[$i]['ADK_APPLICANT_EMAIL'] = $row['ADK_APPLICANT_EMAIL'];
				$ADK_APPLICANTS[$i]['ADK_APPLICANT_PHONE'] = $row['ADK_APPLICANT_PHONE'];
				$ADK_APPLICANTS[$i]['ADK_APPLICANT_AGE'] = $row['ADK_APPLICANT_AGE'];
				if($ADK_APPLICANTS[$i]['ADK_APPLICANT_AGE'] == 0) $ADK_APPLICANTS[$i]['ADK_APPLICANT_AGE'] = '';
				$ADK_APPLICANTS[$i]['ADK_APPLICANT_SEX'] = $row['ADK_APPLICANT_SEX'];
				$ADK_APPLICANTS[$i]['ADK_APPLICANT_ADDRESS1'] = $row['ADK_APPLICANT_ADDRESS1'];
				$ADK_APPLICANTS[$i]['ADK_APPLICANT_ADDRESS2'] = $row['ADK_APPLICANT_ADDRESS2'];
				$ADK_APPLICANTS[$i]['ADK_APPLICANT_CITY'] = $row['ADK_APPLICANT_CITY'];
				$ADK_APPLICANTS[$i]['ADK_APPLICANT_STATE'] = $row['ADK_APPLICANT_STATE'];
				$ADK_APPLICANTS[$i]['ADK_APPLICANT_ZIP'] = $row['ADK_APPLICANT_ZIP'];
				$ADK_APPLICANTS[$i]['ADK_APPLICANT_ZIP'] = preg_replace('/(\d{5})(\d{4})/i', '-', $ADK_APPLICANTS[$i]['ADK_APPLICANT_ZIP']);
				$ADK_APPLICANTS[$i]['ADK_APPLICANT_COUNTRY'] = $row['ADK_APPLICANT_COUNTRY'];
				$ADK_APPLICANTS[$i]['ADK_APPLICANT_PERSONALINFO'] = $row['ADK_APPLICANT_PERSONALINFO'];
				$ADK_APPLICANTS[$i]['ADK_APPLICANT_REQ_CORR'] = $row['ADK_APPLICANT_REQ_CORR'];
				$i++;
			}
		}
		else die('There was an error running the query ['.$con->error.']');		
		
		return $ADK_APPLICANTS;
	}
	
	function getApplicant($con, $ADK_APPLICANT_ID){
		$ADK_APPLICANT = '';
		$sql_query = sql_getApplicant($con, $ADK_APPLICANT_ID);
		if($sql_query->execute()){
            $sql_query->store_result();
            $result = sql_get_assoc($sql_query);

			foreach($result as $row){
				$ADK_APPLICANT['ADK_APPLICANT_ID'] = $row['ADK_APPLICANT_ID'];
				$ADK_APPLICANT['ADK_APPLICANT_USERNAME'] = $row['ADK_APPLICANT_USERNAME'];
				$ADK_APPLICANT['ADK_APPLICANT_NAME'] = $row['ADK_APPLICANT_NAME'];
				$ADK_APPLICANT['ADK_APPLICANT_EMAIL'] = $row['ADK_APPLICANT_EMAIL'];
				$ADK_APPLICANT['ADK_APPLICANT_PHONE'] = $row['ADK_APPLICANT_PHONE'];
				$ADK_APPLICANT['ADK_APPLICANT_AGE'] = $row['ADK_APPLICANT_AGE'];
				if($ADK_APPLICANT['ADK_APPLICANT_AGE'] == 0) $ADK_APPLICANT['ADK_APPLICANT_AGE'] = '';
				$ADK_APPLICANT['ADK_APPLICANT_SEX'] = $row['ADK_APPLICANT_SEX'];
				$ADK_APPLICANT['ADK_APPLICANT_ADDRESS1'] = $row['ADK_APPLICANT_ADDRESS1'];
				$ADK_APPLICANT['ADK_APPLICANT_ADDRESS2'] = $row['ADK_APPLICANT_ADDRESS2'];
				$ADK_APPLICANT['ADK_APPLICANT_CITY'] = $row['ADK_APPLICANT_CITY'];
				$ADK_APPLICANT['ADK_APPLICANT_STATE'] = $row['ADK_APPLICANT_STATE'];
				$ADK_APPLICANT['ADK_APPLICANT_ZIP'] = $row['ADK_APPLICANT_ZIP'];
				$ADK_APPLICANT['ADK_APPLICANT_ZIP'] = preg_replace('/(\d{5})(\d{4})/i', '-', $ADK_APPLICANT['ADK_APPLICANT_ZIP']);
				$ADK_APPLICANT['ADK_APPLICANT_COUNTRY'] = $row['ADK_APPLICANT_COUNTRY'];
				$ADK_APPLICANT['ADK_APPLICANT_PERSONALINFO'] = $row['ADK_APPLICANT_PERSONALINFO'];
				$ADK_APPLICANT['ADK_APPLICANT_REQ_CORR'] = $row['ADK_APPLICANT_REQ_CORR'];
			}
		}
		else die('There was an error running the query ['.$con->error.']');		
		
		return $ADK_APPLICANT;
	}
	
	function getTableApplicants($ADK_APPLICANTS){
		$html = "<table class=\"selecttable\">
					<thead>
						<tr>
							<th></th>
							<th class=\"pointer\">Name</th>
							<th class=\"pointer\">Username</th>
							<th class=\"pointer\">Email</th>
							<th class=\"pointer\">Phone</th>
							<th class=\"pointer\">State</th>
						</tr>
					</thead>
					<tbody>";		
		if($ADK_APPLICANTS == ''){//If empty
			$html .= '<tr><td colspan="6" style="text-align:center;font-style:italic;">No new applicants</td></tr>';
		}	
		else{
			foreach($ADK_APPLICANTS as $ADK_APPLICANT){
				$html .= "<tr>
							<td>
								<a href=\"./applicant?_=".$ADK_APPLICANT['ADK_APPLICANT_ID']."\" class=\"hoverbtn rowselector\">
									<span class=\"glyphicon glyphicon-search\" title=\"View\" data-toggle=\"tooltip\" data-placement=\"right\" data-container=\"body\"></span>
								</a>
							</td>
							<td>".$ADK_APPLICANT['ADK_APPLICANT_NAME']."</td>
							<td>".$ADK_APPLICANT['ADK_APPLICANT_USERNAME']."</td>
							<td>".$ADK_APPLICANT['ADK_APPLICANT_EMAIL']."</td>
							<td>".$ADK_APPLICANT['ADK_APPLICANT_PHONE']."</td>
							<td>".$ADK_APPLICANT['ADK_APPLICANT_STATE']."</td>
						</tr>";
			}
		}
		
		$html .= "</tbody></table>";
		
		return $html;
	}
	
?>