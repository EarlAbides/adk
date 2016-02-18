$(document).ready(function(){
	$.get('includes/weather.php')
	.done(function(ret){
		var weather = JSON.parse(ret);
		var conditions = weather.conditions
			,forecast = weather.forecast.forecast.simpleforecast
			,txt_forecast = weather.forecast.forecast.txt_forecast;
		
		document.getElementById('span_weatherLocation').innerHTML = conditions.location.city + ', ' + conditions.location.state;
		
		document.getElementById('img_weatherIcon').setAttribute('src', conditions.current_observation.icon_url);
		document.getElementById('span_curWeather').innerHTML = conditions.current_observation.weather;
		document.getElementById('h5_forecast').innerHTML = txt_forecast.forecastday[0].fcttext;
		
		document.getElementById('span_curTemp').innerHTML = conditions.current_observation.temperature_string;
		document.getElementById('span_feelsLike').innerHTML = conditions.current_observation.feelslike_string;
		document.getElementById('span_wind').innerHTML = conditions.current_observation.wind_gust_mph + 'mph ' + conditions.current_observation.wind_dir;
		document.getElementById('span_humidity').innerHTML = conditions.current_observation.relative_humidity;
		document.getElementById('span_visibility').innerHTML = conditions.current_observation.visibility_mi + 'mi';
		

		$('.imgForecast').each(function(i){
			this.src = forecast.forecastday[i + 1].icon_url;
		});

		$('.tempHigh').each(function(i){
			this.innerHTML = forecast.forecastday[i + 1].high.fahrenheit;
		});
		$('.tempLow').each(function(i){
			this.innerHTML = forecast.forecastday[i + 1].low.fahrenheit + ' (F)';
		});

		$('.descForecast').each(function(i){
			this.innerHTML = txt_forecast.forecastday[i + 1].fcttext;
		});

		document.getElementById('span_lastUpdated').innerHTML = conditions.current_observation.observation_time;
		
		$('#div_weather').slideDown();
	});
});