<?php
	
	class Messages{
		
		public $userid, $messages, $foldername;
		
		public function Messages(){
		    $this->messages = [];
		}

		public function get($con){
		    switch($this->foldername){
				case 'Inbox': $sql_query = sql_getMessagesInbox($con, $this->userid); break;
				case 'Sent': $sql_query = sql_getMessagesSent($con, $this->userid); break;
				case 'Drafts': $sql_query = sql_getMessagesDrafts($con, $this->userid); break;
			}
			if($sql_query->execute()){
				$sql_query->store_result();
				$result = sql_get_assoc($sql_query);

				foreach($result as $row){
					$ADK_MESSAGE = new Message();
					$ADK_MESSAGE->id = intval($row['ADK_MESSAGE_ID']);
					$ADK_MESSAGE->fromid = intval($row['ADK_MESSAGE_FROM_USER_ID']);
					$ADK_MESSAGE->fromusername = $row['ADK_MESSAGE_FROM_USERNAME'];
					$ADK_MESSAGE->toid = intval($row['ADK_MESSAGE_TO_USER_ID']);
					$ADK_MESSAGE->tousername = $row['ADK_MESSAGE_TO_USERNAME'];
					$ADK_MESSAGE->title = $row['ADK_MESSAGE_TITLE'];
					$ADK_MESSAGE->date = date("n/j/Y", strtotime($row['ADK_MESSAGE_DTE']));
					$ADK_MESSAGE->time = date('g:ia', strtotime($row['ADK_MESSAGE_DTE']));
					$ADK_MESSAGE->isread = $row['ADK_MESSAGE_READ'] == 1;
					$ADK_MESSAGE->hasfiles = $row['ADK_MESSAGE_HASFILES'] == 1;
					array_push($this->messages, $ADK_MESSAGE); 
				}
			}
			else die('There was an error running the query ['.$con->error.']');
		}

		public function getNewCount($con){
			$COUNT = 0;
			$sql_query = sql_getNewMessageCount($con, $this->userid);
			if($sql_query->execute()){
				$sql_query->store_result();
				$sql_query->bind_result($result);
				$sql_query->fetch();
				$COUNT = $result;
			}
			else die('There was an error running the query ['.$con->error.']');
		
			return $COUNT;
		}
		

		public function renderTable(){
			$html = "<h4 id=\"h4_folderName\" style=\"border-bottom:1px solid;\">".$this->foldername."</h4>
					<table id=\"table_messages\" class=\"selecttable\"><thead></thead><tbody>";
			if(count($this->messages) === 0) $html .= '<tr><td style="text-align:center;font-style:italic;">No messages</td></tr>';
			else{		
				foreach($this->messages as $ADK_MESSAGE){
					$bold = '';
					switch($this->foldername){
						case 'Inbox':
							$icon = '<span class="glyphicon glyphicon-envelope"></span>';
							$displayUsername = $ADK_MESSAGE->fromusername;
							break;
						case 'Sent': case 'Drafts':
							$icon = '<span class="glyphicon glyphicon-hand-left"></span>';
							$displayUsername = $ADK_MESSAGE->tousername;
							break;
					}
					if($this->foldername === 'Inbox'){if($ADK_MESSAGE->isread == false) $bold = ' class="font-bold";';}
					if($ADK_MESSAGE->hasfiles) $icon .= '<span class="glyphicon glyphicon-paperclip"></span>';
				
					$html .= "<tr data-name=\"".$displayUsername."\" data-date=\"".$ADK_MESSAGE->date." ".$ADK_MESSAGE->time."\">
								<td>
									<a class=\"messagebtn hoverbtn rowselector\" data-id=\"".$ADK_MESSAGE->id."\">
										<div class=\"col-xs-1\" style=\"padding:0;vertical-align:middle;\">".$icon."</div>
										<div class=\"col-xs-11\" style=\"padding:0;\">
											<div class=\"container-fluid nopadding nomargin\">
												<div class=\"col-xs-6 nopadding\" style=\"text-overflow:ellipsis;overflow:hidden;\">
													<span".$bold." style=\"width:120px;display:inline-block;\">".$ADK_MESSAGE->title."</span>
												</div>
												<div class=\"col-xs-6 nopadding\">
													<span class=\"pull-right\">".$ADK_MESSAGE->date."</span>
												</div>
											</div>
											<div class=\"container-fluid nopadding nomargin\">
												<div class=\"col-xs-6 nopadding\">
													<span class=\"glyphicon glyphicon-user\" style=\"display:inline-block;vertical-align:text-top;\"></span>
													<span>".$displayUsername."</span>
												</div>
												<div class=\"col-xs-6 nopadding\">
													<span class=\"pull-right\">".$ADK_MESSAGE->time."</span>
												</div>
											</div>
										</div>
									</a>
								</td>
							</tr>";
				}
			}
		
			$html .= "</tbody></table>";
		
			echo $html;
		}
		
	}
	
	class Message{
		
	    public $err;
	    public $id, $userid, $fromid, $fromusername, $toid, $tousername, $title, $content, $date, $time, $files, $isread, $hasfiles, $isfromhiker, $isdraff;
		
	    public function Message(){
			$this->files = [];
	    }

		public function isValid(){
			if(!isset($this->userid)) $this->err .= 'u';
			if(!isset($this->fromid)) $this->err .= 'f';
			if(!isset($this->toid)) $this->err .= 't';
			if(!isset($this->title)) $this->err .= 'i';
			
			if(strlen($this->err) > 0) return false;
			return true;
		}

	    public function sanitize(){
	        $this->content = str_replace('<iframe', '</iframe', $this->content);
	        $this->content = str_replace('<script', '</script', $this->content);
	    }
		

	    public function save($con){
	        $sql_query = sql_addMessage($con, $this);
	        $sql_query->execute();
	        $this->id = $sql_query->insert_id;
	    }

		public function addFiles($con, $fileIDs){
	        $sql_query = sql_addMessageFileJcts($con);
			$con->query("START TRANSACTION");
			foreach($fileIDs as $fileID){
				$sql_query->bind_param('ii', $this->id, $fileID);
				$sql_query->execute();
			}
			$sql_query->close();
			$con->query("COMMIT");
	    }
		
	    public function get($con){
	        $sql_query = sql_getMessage($con, $this);
	        if($sql_query->execute()){
	            $sql_query->store_result();
	            $result = sql_get_assoc($sql_query);

	            foreach($result as $row){
	                $this->fromid = intval($row['ADK_MESSAGE_FROM_USER_ID']);
					$this->fromname = $row['ADK_MESSAGE_FROM_NAME'];
					$this->fromusername = $row['ADK_MESSAGE_FROM_USERNAME'];
					$this->toid = intval($row['ADK_MESSAGE_TO_USER_ID']);
					$this->toname = $row['ADK_MESSAGE_TO_NAME'];
					$this->tousername = $row['ADK_MESSAGE_TO_USERNAME'];
					$this->title = $row['ADK_MESSAGE_TITLE'];
					$this->content = $row['ADK_MESSAGE_CONTENT'];
					$this->date = date("n/j/Y", strtotime($row['ADK_MESSAGE_DTE']));
					$this->time = date('g:ia', strtotime($row['ADK_MESSAGE_DTE']));
					$this->isread = $row['ADK_MESSAGE_READ'] == 1;
					$this->isfromhiker = intval($row['isFromHiker']);
					$this->isdraft = intval($row['ADK_MESSAGE_DRAFT']);

					$sql_query = sql_getMessageFiles($con, $this->id);
					if($sql_query->execute()){
						$sql_query->store_result();
						$result = sql_get_assoc($sql_query);

						foreach($result as $row){
							$ADK_FILE = new File();
							$ADK_FILE->id = intval($row['ADK_FILE_ID']);
							$ADK_FILE->name = $row['ADK_FILE_NAME'];
							$ADK_FILE->desc = $row['ADK_FILE_DESC'];
							$ADK_FILE->size = intval($row['ADK_FILE_SIZE']);
							array_push($this->files, $ADK_FILE);
						}
					}
					else die('There was an error running the query ['.$con->error.']');
	            }
	        }
	        else die('There was an error running the query ['.$con->error.']');
	    }

		function updateRead($con){
			$sql_query = sql_updateMessageMarkRead($con, $this->id);
			$sql_query->execute();
		}
		
		public function delete($con, $inboxSent){
			$sql_query = sql_updateMessageDelete($con, $this->id, $inboxSent);
			$sql_query->execute();
		}


		function populate(){
			$this->id = isset($_POST['messageid'])? intval($_POST['messageid']): null;
			$this->userid = intval($_SESSION['ADK_USER_ID']);
			$this->fromid = intval($_POST['id']);
	        $this->toid = intval($_POST['touserid']);
			$this->title = $_POST['subject'];
			$this->content = $_POST['message'];
			$this->isdraft = isset($_POST['draft']);
		}
		
	}
	
?>