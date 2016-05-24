<?php
	
	$filepath = '../data/weather.json';
	
	$dt = new DateTime();
	$dt->sub(new DateInterval('PT1H'));
	
	if(filemtime($filepath) < $dt->getTimestamp()){
		$apiKeys = [];
        $handle = fopen('../.adk_api', 'r');
        if($handle){
            while(($line = fgets($handle)) !== false) array_push($apiKeys, rtrim($line));
            fclose($handle);
        }
        else die('Unable to get api key');
		
		$key = $apiKeys[0];
		$url_forecast = 'http://api.wunderground.com/api/'.$key.'/geolookup/forecast/q/NY/Keene.json';
		$url_conditions = 'http://api.wunderground.com/api/'.$key.'/geolookup/conditions/q/NY/Keene.json';

		file_put_contents($filepath, '{"forecast":');
		file_put_contents($filepath, fopen($url_forecast, 'r'), FILE_APPEND | LOCK_EX);
		file_put_contents($filepath, ',"conditions":', FILE_APPEND | LOCK_EX);
		file_put_contents($filepath, fopen($url_conditions, 'r'), FILE_APPEND | LOCK_EX);
		file_put_contents($filepath, '}', FILE_APPEND | LOCK_EX);
	}

	echo file_get_contents($filepath);
	
?>