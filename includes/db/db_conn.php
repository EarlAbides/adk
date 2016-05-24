<?php
    
    $db_conf = getDBConf();
    define('DB_SERVER', $db_conf[0]);
    define('DB_USER', $db_conf[1]);
    define('DB_PWD', $db_conf[2]);
    define('DB_NAME', $db_conf[3]);
	
    function connect_db(){
		$con = new mysqli(DB_SERVER, DB_USER, DB_PWD, DB_NAME);
		if($con->connect_errno > 0)
			die('Unable to connect to database [' . $con->connect_error . ']');
		
		$con->set_charset("utf8");
		
		return $con;
	}

    function getDBConf(){
        $db_conf = [];
        $handle = fopen('../.adk_db', 'r');
        if($handle){
            while(($line = fgets($handle)) !== false) array_push($db_conf, rtrim($line));
            fclose($handle);
        }
        else die('Unable to get database credentials');

        return $db_conf;
    }

    function sql_get_assoc($sql_query){
        $meta = $sql_query->result_metadata();

        while($field = $meta->fetch_field()) $params[] = &$row[$field->name];

        call_user_func_array(array($sql_query, 'bind_result'), $params);
        $result = [];
        while($sql_query->fetch()){
            foreach($row as $key => $val) $c[$key] = $val;
            $result[] = $c;
        }
        $sql_query->close();

        return $result;
    }

?>