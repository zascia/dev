<?php
class TimeUtils{
	/**
	 * converts hour to milliseconds
	 * @param float $hour
	 * @return int - the millisecond equivalent
	 */
	public static function hourToMillis($hour){
		if(is_numeric($hour)){
			$millis = $hour * 60 * 60;
			return $millis;
		}
	}
	
	public static function secondsToTime($seconds){
		return floor($seconds / 3600) . gmdate(":i:s", $seconds % 3600);
	}
	
	public static function strtotime_to_seonds($str){
	    return strtotime($str,0);
	}
}