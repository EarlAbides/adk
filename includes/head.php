<!DOCTYPE html>
<html>

<head>
	<title>Adirondack 46ers</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=10">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<link type="text/css" href="css/bootstrap.min.css" rel="stylesheet" media="screen" />
	<link type="text/css" href="css/bootstrap-theme.min.css" rel="stylesheet" media="screen" />
	<link type="text/css" href="css/jquery-ui.min.css" rel="stylesheet" media="screen" />
	<link type="text/css" href="css/jquery-ui.structure.min.css" rel="stylesheet" media="screen" />
	<link type="text/css" href="css/jquery-ui.theme.min.css" rel="stylesheet" media="screen" />
	<link type="text/css" href="css/adk.css"  rel="stylesheet" media="screen" />
	<link href="favicon.ico" rel="shortcut icon" />
	
	<script src="js/jquery-1.11.3.min.js"></script>
	<script src="js/jquery-ui.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/validator.min.js"></script>
	<script src="js/adk.min.js"></script>
	
	<?php
		if($dh = opendir('img/bg/')){
			$i = 0;
			while((($file = readdir($dh)) !== false)){
				if(($file !== '.') && ($file !== '..')){
					$files[$i] = $file;
					$i++;
				}
			}
			closedir($dh);
		}
		$rand_key = array_rand($files, 1);
		$bg_name = $files[$rand_key];
	?>
	<style>#div_logo{background-image:url(img/bg/<?php echo $bg_name;?>);}</style>