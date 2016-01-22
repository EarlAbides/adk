<?php
	
    class Templates{
		
		public $public, $private;
		
		public function Templates(){
			$this->public = [];
			$this->private = [];
		}		
		
		public function get($con, $ADK_USER_ID){
			$sql_query = sql_getTemplates($con, $ADK_USER_ID);
			if($sql_query->execute()){
			    $sql_query->store_result();
			    $result = sql_get_assoc($sql_query);
				
				foreach($result as $row){
					$template = new Template();
			        $template->id = intval($row['ADK_MSG_TMPL_ID']);
			        $template->userid = intval($row['ADK_USER_ID']);
			        $template->name = $row['ADK_MSG_TMPL_NAME'];
					
					if($template->userid === $ADK_USER_ID) array_push($this->private, $template);
					else array_push($this->public, $template);
			    }
				
			}
			else die('There was an error running the query ['.$con->error.']');	
		}
		
	}
	
	class Template{
		
		public $err;
		public $id, $userid, $name, $content, $datetime;
		
		public function Template(){
			
		}
		
		public function isValid(){
			if(!is_numeric($this->userid)) $this->err .= 'u';
			if(strlen($this->name) === 0 || strlen($this->name) > 45) $this->err .= 'n';
			//TODO: content length?
			
			if(strlen($this->err) > 0) return false;
			$this->sanitize();
			return true;
		}

		public function sanitize(){
			$this->content = str_replace('<iframe', '</iframe', $this->content);
			$this->content = str_replace('<script', '</script', $this->content);
		}
		
		public function save($con){
			$sql_query = sql_addTemplate($con, $this);
			$sql_query->execute();
			$this->id = $sql_query->insert_id;
		}
		
		public function get($con){
			$sql_query = sql_getTemplate($con, $this->id);
			if($sql_query->execute()){
			    $sql_query->store_result();
			    $result = sql_get_assoc($sql_query);
				
				foreach($result as $row){
					$this->userid = intval($row['ADK_USER_ID']);
			        $this->name = $row['ADK_MSG_TMPL_NAME'];
			        $this->content = $row['ADK_MSG_TMPL_CONTENT'];
			        $this->datetime = $row['ADK_MSG_TMPL_DTE'];
			    }

			}
			else die('There was an error running the query ['.$con->error.']');	
		}

		public function delete($con){
			$sql_query = sql_deleteTemplate($con, $this->id);
			if(!$sql_query->execute()) die('There was an error running the query ['.$con->error.']');
		}
		
		public function populate(){
			$this->userid = $_SESSION['ADK_USER_ID'];
			$this->name = $_POST['ADK_MSG_TMPL_NAME'];
			$this->content = $_POST['ADK_MSG_TMPL_CONTENT'];
		}
		
	}

?>