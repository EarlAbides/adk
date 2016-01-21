<?php
	
    class Templates{
		
		private $con;
		public $public, $private;
		
		public function Templates($con){
			$this->con = $con;
			$this->public = [];
			$this->private = [];
		}		

		public function get($ADK_USER_ID){
			$sql_query = sql_getTemplates($this->con, $ADK_USER_ID);
			if($sql_query->execute()){
			    $sql_query->store_result();
			    $result = sql_get_assoc($sql_query);
				
				foreach($result as $row){
					$template = new Template(null);
			        $template->id = intval($row['ADK_MSG_TMPL_ID']);
			        $template->userid = intval($row['ADK_USER_ID']);
			        $template->name = $row['ADK_MSG_TMPL_NAME'];
					
					if($template->userid === $ADK_USER_ID) array_push($this->private, $template);
					else array_push($this->public, $template);
			    }

			}
			else die('There was an error running the query ['.$this->con->error.']');	
		}

	}

	class Template{
		
		private $con;
		public $id, $userid, $name, $content, $datetime;

		public function Template($con){
			$this->con = $con;
		}

		public function save(){
			$sql_query = sql_addTemplate($this->con, $this);
			$sql_query->execute();
			$this->id = $sql_query->insert_id;
		}

		public function get(){
			$sql_query = sql_getTemplate($this->con, $this->id);
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
			else die('There was an error running the query ['.$this->con->error.']');	
		}

	}

?>