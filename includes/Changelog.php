<?php
	
	function makeChangeArray(){
		if(isset($_POST['id'])) $id = $_POST['id'];
		else $id = '';
		
		$ADK_CHANGE = array(
		    'ADK_APPLICANT_ID' => $id,
		    'ADK_CHANGE_TITLE' => $_POST['title'],
		    'ADK_CHANGE_DESC' => $_POST['desc'],
		    'ADK_CHANGE_PRIORITY' => $_POST['priority']
		);
		
		return $ADK_CHANGE;
	}
	
	function addChange($con){
	    $ADK_CHANGE = makeChangeArray();
		
		//Add to database
	    $sql_query = sql_addChange($con, $ADK_CHANGE);
	    $sql_query->execute();
		
		return $sql_query->insert_id;
	}
	
	//function updateChange($con){
	//    $ADK_CHANGE = makeChangeArray();
		
	//    //Update
	//    $sql_query = sql_updateChange($con, $ADK_CHANGE);
	//    $sql_query->execute();
	//}
	
	function updateChangeDone($con, $ADK_CHANGE_ID, $ADK_CHANGE_DONE){
		$sql_query = sql_updateChangeDone($con, $ADK_CHANGE_ID, $ADK_CHANGE_DONE);
	    $sql_query->execute();
	}
	
	//function deleteChange($con){
	//    $ADK_CHANGE_ID = $_POST['id'];
				
	//    //Delete
	//    $sql_query = sql_deleteChange($ADK_CHANGE_ID);
	//    if($result = $con->query($sql_query)){}
	//    else die('There was an error running the query ['.$con->error.']');
	//}
	
	function getChangelog($con){
		$ADK_CHANGES = '';
		$sql_query = sql_getChangelog($con);
		if($sql_query->execute()){
            $sql_query->store_result();
            $result = sql_get_assoc($sql_query);

            $i = 0;
			foreach($result as $row){
				$ADK_CHANGES[$i]['ADK_CHANGE_ID'] = $row['ADK_CHANGE_ID'];
				$ADK_CHANGES[$i]['ADK_CHANGE_TITLE'] = $row['ADK_CHANGE_TITLE'];
				$ADK_CHANGES[$i]['ADK_CHANGE_DESC'] = $row['ADK_CHANGE_DESC'];
				$ADK_CHANGES[$i]['ADK_CHANGE_DTE'] = date("m/d/Y", strtotime($row['ADK_CHANGE_DTE']));
				$ADK_CHANGES[$i]['ADK_CHANGE_PRIORITY'] = $row['ADK_CHANGE_PRIORITY'];
				$ADK_CHANGES[$i]['ADK_CHANGE_DONE'] = $row['ADK_CHANGE_DONE'];
				$i++;
			}
		}
		else die('There was an error running the query ['.$con->error.']');		
		
		return $ADK_CHANGES;
	}
	
	function getTableChangelog($ADK_CHANGES){
		$html = "<table id=\"table_changelog\" class=\"selecttable\">
					<thead>
						<tr>
							<th style=\"width:3%;\"></th>
							<th class=\"pointer\" style=\"width:4%;\">ID</th>
							<th class=\"pointer\" style=\"width:66%;\">Title</th>
							<th class=\"pointer\" style=\"width:15%;\">Date</th>
							<th class=\"pointer\" style=\"width:7%;\">Priority</th>
							<th class=\"pointer\" style=\"width:5%;\">Done</th>
						</tr>
					</thead>
					<tbody>";
		
		if($ADK_CHANGES == ''){//If empty
			$html .= '<tr><td colspan="5" style="text-align:center;font-style:italic;">No records</td></tr>';
		}	
		else{
			foreach($ADK_CHANGES as $ADK_CHANGE){
				if($ADK_CHANGE['ADK_CHANGE_DONE'] == 0) $done = '';
				else $done = ' checked="checked"';
				if($ADK_CHANGE['ADK_CHANGE_DESC'] != '') $icon = '<span class="glyphicon glyphicon-chevron-right"></span>';
				else $icon = '';
				$html .= "<tr class=\"pointer\">
							<td>".$icon."</td>
							<td>".$ADK_CHANGE['ADK_CHANGE_ID']."</td>
							<td>".$ADK_CHANGE['ADK_CHANGE_TITLE']."</td>
							<td>".$ADK_CHANGE['ADK_CHANGE_DTE']."</td>
							<td style=\"text-align:center;\">".$ADK_CHANGE['ADK_CHANGE_PRIORITY']."</td>
							<td style=\"text-align:center;\">
								<input type=\"checkbox\" class=\"checkbox_done\" value=\"".$ADK_CHANGE['ADK_CHANGE_ID']."\"".$done." />
							</td>
						</tr>
						<tr class=\"row-details expand-child\" style=\"display:none;\">
							<td colspan=\"6\">".$ADK_CHANGE['ADK_CHANGE_DESC']."</td>
						</tr>";
			}
		}
		
		$html .= "</tbody></table>";
		
		return $html;
	}
	
?>