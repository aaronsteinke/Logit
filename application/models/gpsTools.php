<?php

class Application_Model_gpsTools
{
	public static  function toFloat ($gpsArray)
	{
		print_r($gpsArray);
		$posTrenner = strpos($gpsArray['2'], '/');
		$sekunden = (int)substr($gpsArray['2'], 0, $posTrenner) / (int)substr($gpsArray['2'], $posTrenner+1);
		return (((($sekunden/60) + (int)$gpsArray['1'])/60)+(int)$gpsArray['0']);
	}
	
	public static function getHeight ($gpsLat, $gpsLong)
	{
		/* Höhe per Request an die Google Api setzen, als Fallback falls keine Höhe angegeben ist im GPS
		 * 
		 *http://code.google.com/intl/de/apis/maps/documentation/elevation/
		 */
	}
}