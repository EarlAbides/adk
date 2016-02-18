$(document).ready(function(){
	$.get('includes/weather.php')
	.done(function(ret){
		var weather = JSON.parse(ret);
		var conditions = weather.conditions
			,forecast = weather.forecast.forecast.simpleforecast.forecastday[0]
			,txt_forecast = weather.forecast.forecast.txt_forecast.forecastday[0];
		
		document.getElementById('span_weatherLocation').innerHTML = conditions.location.city + ', ' + conditions.location.state;
		
		
		
		document.getElementById('span_curTemp').innerHTML = conditions.current_observation.temperature_string;
		document.getElementById('span_feelsLike').innerHTML = conditions.current_observation.feelslike_string;

		document.getElementById('span_curWeather').innerHTML = conditions.current_observation.weather;
		document.getElementById('img_weatherIcon').setAttribute('src', conditions.current_observation.icon_url);
		document.getElementById('span_tempHigh').innerHTML = forecast.high.fahrenheit + 'F (' + forecast.high.celsius + 'C)';
		document.getElementById('span_tempLow').innerHTML = forecast.low.fahrenheit + 'F (' + forecast.low.celsius + 'C)';
		
		document.getElementById('span_forecast').innerHTML = txt_forecast.fcttext;
		document.getElementById('span_humidity').innerHTML = forecast.avehumidity;
		
		document.getElementById('span_wind').innerHTML = forecast.maxwind.mph + 'mph ' + forecast.maxwind.dir;

		document.getElementById('span_lastUpdated').innerHTML = conditions.current_observation.observation_time;
		
		$('#div_weather').slideDown();
	});
});