<?php
	
	function randomPW($length){
		$valid_chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!@';
		$num_valid_chars = strlen($valid_chars) - 1;
		
		$randomPW = 'a';
		for($i = 0; $i < $length; $i++){
			$random_num = mt_rand(0, $num_valid_chars);
			$random_char = $valid_chars[$random_num];
			$randomPW .= $random_char;
		}
		
		return $randomPW;
	}
	
?>