<?php
	
	$err = '';
	if(array_key_exists('e', $_GET)) $err .= $_GET['e'];
	if(array_key_exists('n', $_GET)) $err .= $_GET['n'];
	
	$errMess = '';
	if(strpos($err, 'n') > (-1)) $errMess .= 'This name already exists in the system<br />';
	if(strpos($err, 'e') > (-1)) $errMess .= 'This email address already exists in the system<br />';
	
?>