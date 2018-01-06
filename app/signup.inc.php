<?php
	
	//Imports
	require_once 'includes/db/db_conn.php';
	require_once 'includes/db/SELECT.php';
	require_once 'includes/classes/Peak.php';
	
	$err = '';
	if(array_key_exists('e', $_GET)) $err .= $_GET['e'];
	if(array_key_exists('n', $_GET)) $err .= $_GET['n'];
	
	$errMess = '';
	if(strpos($err, 'n') > (-1)) $errMess .= 'This name already exists in the system<br />';
	if(strpos($err, 'e') > (-1)) $errMess .= 'This email address already exists in the system<br />';
	
	$con = connect_db();
	
	$ADK_PEAKS = new Peaks();
	$ADK_PEAKS->get($con);
	
	$con->close();

	function makeCheckbox($ADK_PEAK){
		return '<li><label><input type="checkbox" class="peaks" data-id="'.$ADK_PEAK->id.'" \>'.$ADK_PEAK->name.'</label></li>';
	}

?>