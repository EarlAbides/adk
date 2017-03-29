<?php

	$files = scandir("data/reports/");
	rsort($files);
	$filename = $files[0];
	$file = "data/reports/".$filename;
	$report = @file_get_contents($file);

?>
