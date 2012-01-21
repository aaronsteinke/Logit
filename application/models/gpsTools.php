<?php

class Application_Model_gpsTools {
	public static function toFloat($gpsArray)
	{
		$posTrenner = strpos($gpsArray['1'], '/');
		$minuten = (int)substr($gpsArray['1'], 0, $posTrenner) / (int)substr($gpsArray['1'], $posTrenner + 1);
		$posTrenner = strpos($gpsArray['2'], '/');
		$sekunden = (int)substr($gpsArray['2'], 0, $posTrenner) / (int)substr($gpsArray['2'], $posTrenner + 1);
		return (int)$gpsArray['0'] + ($minuten / 60) + ($sekunden / 3600);
	}

	public static function getHeight($gpsLat, $gpsLong)
	{
		$urlBase = 'http://maps.google.com/maps/api/elevation/json?locations=';
		$url = $urlBase . $gpsLat . ',' . $gpsLong . '&sensor=false';

		$height = '0';
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, false);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

		$result = json_decode(curl_exec($ch), true);
		if ($result['status'] = 'OK') {
			$height = $result['results']['0']['elevation'];
		}
		curl_close($ch);

		return $height;

	}

	public static function geocode($gpsLat, $gpsLong)
	{
		$urlBase = 'http://maps.google.com/maps/api/geocode/json?language=de&latlng=';
		$url = $urlBase . $gpsLat . ',' . $gpsLong . '&sensor=false';

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, false);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		
		$result = json_decode(curl_exec($ch), true);
		
		curl_close($ch);

		return $result;
		
	}

}
