<?php

class Application_Model_gpsTools
{
	public static  function toFloat ($gpsArray)
	{
		$posTrenner = strpos($gpsArray['1'], '/');
		$minuten = (int)substr($gpsArray['1'], 0, $posTrenner) / (int)substr($gpsArray['1'], $posTrenner+1);
		$posTrenner = strpos($gpsArray['2'], '/');
		$sekunden = (int)substr($gpsArray['2'], 0, $posTrenner) / (int)substr($gpsArray['2'], $posTrenner+1);
		return (int)$gpsArray['0'] + ($minuten/60) + ($sekunden / 3600);
	}
	
	public static function getHeight ($gpsLat, $gpsLong)
	{
		/* H�he per Request an die Google Api setzen, als Fallback falls keine H�he angegeben ist im GPS
		 * 
		 *http://code.google.com/intl/de/apis/maps/documentation/elevation/
		 */
	}
}