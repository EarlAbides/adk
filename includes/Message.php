<?php
	
	function makeMessageArray(){
		$ADK_MESSAGE = array(
			'ADK_MESSAGE_FROM_USER_ID' => intval($_POST['id']),
	        'ADK_MESSAGE_TO_USER_ID' => intval($_POST['touserid']),
			'ADK_MESSAGE_TITLE' => $_POST['subject'],
			'ADK_MESSAGE_CONTENT' => $_POST['message']
	    );
		
	    return $ADK_MESSAGE;
	}
	
	function getMessages($con, $ADK_USER_ID, $folderName){
        $ADK_MESSAGES = '';
        switch($folderName){
			case 'Inbox': $sql_query = sql_getMessagesInbox($con, $ADK_USER_ID); break;
			case 'Sent': $sql_query = sql_getMessagesSent($con, $ADK_USER_ID); break;
		}
		if($sql_query->execute()){
            $sql_query->store_result();
            $result = sql_get_assoc($sql_query);

            $i = 0;
			foreach($result as $row){
				$ADK_MESSAGES[$i]['ADK_MESSAGE_ID'] = intval($row['ADK_MESSAGE_ID']);
				$ADK_MESSAGES[$i]['ADK_MESSAGE_FROM_USER_ID'] = intval($row['ADK_MESSAGE_FROM_USER_ID']);
				$ADK_MESSAGES[$i]['ADK_MESSAGE_FROM_USERNAME'] = $row['ADK_MESSAGE_FROM_USERNAME'];
				$ADK_MESSAGES[$i]['ADK_MESSAGE_TO_USER_ID'] = intval($row['ADK_MESSAGE_TO_USER_ID']);
				$ADK_MESSAGES[$i]['ADK_MESSAGE_TO_USERNAME'] = $row['ADK_MESSAGE_TO_USERNAME'];
				$ADK_MESSAGES[$i]['ADK_MESSAGE_TITLE'] = $row['ADK_MESSAGE_TITLE'];
				$ADK_MESSAGES[$i]['ADK_MESSAGE_DTE'] = date("n/j/Y", strtotime($row['ADK_MESSAGE_DTE']));
				$ADK_MESSAGES[$i]['ADK_MESSAGE_TME'] = date('g:ia', strtotime($row['ADK_MESSAGE_DTE']));
				$ADK_MESSAGES[$i]['ADK_MESSAGE_READ'] = ($row['ADK_MESSAGE_READ'] == 1? true: false);
				$ADK_MESSAGES[$i]['ADK_MESSAGE_HASFILES'] = ($row['ADK_MESSAGE_HASFILES'] == 1? true: false);
				$i++;
			}
		}
		else die('There was an error running the query ['.$con->error.']');		
		
		return $ADK_MESSAGES;
	}
	
	function getMessage($con, $ADK_MESSAGE_ID){
        $ADK_MESSAGE = '';
		$sql_query = sql_getMessage($con, $ADK_MESSAGE_ID);
		if($sql_query->execute()){
            $sql_query->store_result();
            $result = sql_get_assoc($sql_query);

            foreach($result as $row){
				$ADK_MESSAGE['ADK_MESSAGE_ID'] = intval($row['ADK_MESSAGE_ID']);
				$ADK_MESSAGE['ADK_MESSAGE_FROM_USER_ID'] = intval($row['ADK_MESSAGE_FROM_USER_ID']);
				$ADK_MESSAGE['ADK_MESSAGE_FROM_USERNAME'] = $row['ADK_MESSAGE_FROM_USERNAME'];
				$ADK_MESSAGE['ADK_MESSAGE_FROM_NAME'] = $row['ADK_MESSAGE_FROM_NAME'];
				$ADK_MESSAGE['ADK_MESSAGE_TO_USER_ID'] = intval($row['ADK_MESSAGE_TO_USER_ID']);
				$ADK_MESSAGE['ADK_MESSAGE_TO_USERNAME'] = $row['ADK_MESSAGE_TO_USERNAME'];
				$ADK_MESSAGE['ADK_MESSAGE_TO_NAME'] = $row['ADK_MESSAGE_TO_NAME'];
				$ADK_MESSAGE['ADK_MESSAGE_TITLE'] = $row['ADK_MESSAGE_TITLE'];
				$ADK_MESSAGE['ADK_MESSAGE_CONTENT'] = $row['ADK_MESSAGE_CONTENT'];
				$ADK_MESSAGE['ADK_MESSAGE_DTE'] = date("n/j/Y", strtotime($row['ADK_MESSAGE_DTE']));
				$ADK_MESSAGE['ADK_MESSAGE_TME'] = date('g:ia', strtotime($row['ADK_MESSAGE_DTE']));
				$ADK_MESSAGE['isFromHiker'] = intval($row['isFromHiker']);

                $ADK_MESSAGE['ADK_FILES'] = '';
                $sql_query = sql_getMessageFiles($con, $ADK_MESSAGE_ID);
                if($sql_query->execute()){
                    $sql_query->store_result();
                    $result = sql_get_assoc($sql_query);

                    $i = 0;
                    foreach($result as $row){
                        $ADK_MESSAGE['ADK_FILES'][$i]['ADK_FILE_ID'] = intval($row['ADK_FILE_ID']);
					    $ADK_MESSAGE['ADK_FILES'][$i]['ADK_FILE_NAME'] = $row['ADK_FILE_NAME'];
					    $ADK_MESSAGE['ADK_FILES'][$i]['ADK_FILE_DESC'] = $row['ADK_FILE_DESC'];
					    $ADK_MESSAGE['ADK_FILES'][$i]['ADK_FILE_SIZE'] = intval($row['ADK_FILE_SIZE']);
					    $i++;
                    }
                }
                else die('There was an error running the query ['.$con->error.']');
			}
		}
		else die('There was an error running the query ['.$con->error.']');
		
		return $ADK_MESSAGE;
	}
	
	function getNewMessageCount($con, $ADK_USER_ID){
        $newMessageCount = 0;
		$sql_query = sql_getNewMessageCount($con, $ADK_USER_ID);
		if($sql_query->execute()){
            $sql_query->store_result();
            $sql_query->bind_result($result);
            $sql_query->fetch();
            $newMessageCount = $result;
		}
		else die('There was an error running the query ['.$con->error.']');
		
		return $newMessageCount;
	}
	
	function addMessage($con){
		$ADK_MESSAGE = makeMessageArray();
				
	    //Add to database
		$sql_query = sql_addMessage($con, $ADK_MESSAGE);
		$sql_query->execute();
		$ADK_MESSAGE['ADK_MESSAGE_ID'] = $sql_query->insert_id;
		
		return $ADK_MESSAGE;
	}
	
	function addSysMessage($con, $ADK_MESSAGE){
		$sql_query = sql_addMessage($con, $ADK_MESSAGE);
		$sql_query->execute();
		$ADK_MESSAGE['ADK_MESSAGE_ID'] = $sql_query->insert_id;
		
		return $ADK_MESSAGE;
	}
	
	function addMessageFileJcts($con, $ADK_MESSAGE_ID, $fileIDs){
		$sql_query = sql_addMessageFileJcts($con);
		$con->query("START TRANSACTION");
		foreach($fileIDs as $fileID){
			$sql_query->bind_param('ii', $ADK_MESSAGE_ID, $fileID);
			$sql_query->execute();
		}
		$sql_query->close();
		$con->query("COMMIT");
		
		return true;
	}
	
	function updateMarkRead($con, $ADK_MESSAGE_ID){
		$sql_query = sql_updateMessageMarkRead($con, $ADK_MESSAGE_ID);
		$sql_query->execute();
	}
	
	function updateDelete($con, $ADK_MESSAGE_ID, $inboxSent){
		$sql_query = sql_updateMessageDelete($con, $ADK_MESSAGE_ID, $inboxSent);
		$sql_query->execute();
	}
	
	//function updateDeleteMessageTrash($con, $ADK_MESSAGE_ID){
	//    $sql_query = sql_updateDeleteMessageTrash($con, $ADK_MESSAGE_ID);
	//    $sql_query->execute();
	//}
	
	//function deleteMessages($con, $ADK_MESSAGE_IDS){
	//    $sql_query = sql_deleteMessage($con);
	//    $con->query("START TRANSACTION");
	//    foreach($ADK_MESSAGE_IDS as $ADK_MESSAGE_ID){
	//        $sql_query->bind_param('i', $ADK_MESSAGE_ID);
	//        $sql_query->execute();
	//    }
	//    $sql_query->close();
	//    $con->query("COMMIT");
		
	//    return true;
	//}
	
	function getTableMessages($ADK_MESSAGES, $folderName){
		$html = "<h4 id=\"h4_folderName\" style=\"border-bottom:1px solid;\">".$folderName."</h4>
				<table id=\"table_messages\" class=\"selecttable\"><thead></thead><tbody>";
		if($ADK_MESSAGES == '') $html .= '<tr><td style="text-align:center;font-style:italic;">No messages</td></tr>';
		else{		
			foreach($ADK_MESSAGES as $ADK_MESSAGE){
				$bold = '';
				switch($folderName){
					case 'Inbox':
						$icon = '<span class="glyphicon glyphicon-envelope"></span>';
						$displayUsername = $ADK_MESSAGE['ADK_MESSAGE_FROM_USERNAME'];
						break;
					case 'Sent':
						$icon = '<span class="glyphicon glyphicon-hand-left"></span>';
						$displayUsername = $ADK_MESSAGE['ADK_MESSAGE_TO_USERNAME'];
						break;
				}
				if($folderName == 'Inbox'){if($ADK_MESSAGE['ADK_MESSAGE_READ'] == false) $bold = ' class="font-bold";';}
				if($ADK_MESSAGE['ADK_MESSAGE_HASFILES']) $icon .= '<span class="glyphicon glyphicon-paperclip"></span>';
				
				$html .= "<tr data-name=\"".$displayUsername."\" data-date=\"".$ADK_MESSAGE['ADK_MESSAGE_DTE']." ".$ADK_MESSAGE['ADK_MESSAGE_TME']."\">
							<td>
								<a class=\"messagebtn hoverbtn rowselector\" data-id=\"".$ADK_MESSAGE['ADK_MESSAGE_ID']."\">
									<div class=\"col-xs-1\" style=\"padding:0;vertical-align:middle;\">".$icon."</div>
									<div class=\"col-xs-11\" style=\"padding:0;\">
										<div class=\"container-fluid nopadding nomargin\">
											<div class=\"col-xs-6 nopadding\" style=\"text-overflow:ellipsis;overflow:hidden;\">
												<span".$bold." style=\"width:120px;display:inline-block;\">".$ADK_MESSAGE['ADK_MESSAGE_TITLE']."</span>
											</div>
											<div class=\"col-xs-6 nopadding\">
												<span class=\"pull-right\">".$ADK_MESSAGE['ADK_MESSAGE_DTE']."</span>
											</div>
										</div>
										<div class=\"container-fluid nopadding nomargin\">
											<div class=\"col-xs-6 nopadding\">
												<span class=\"glyphicon glyphicon-user\" style=\"display:inline-block;vertical-align:text-top;\"></span>
												<span>".$displayUsername."</span>
											</div>
											<div class=\"col-xs-6 nopadding\">
												<span class=\"pull-right\">".$ADK_MESSAGE['ADK_MESSAGE_TME']."</span>
											</div>
										</div>
									</div>
								</a>
							</td>
						</tr>";
			}
		}
		
		$html .= "</tbody></table>";
		
		return $html;
	}
	
?>