<?php
class DateUtils {

	const DATE_FORMAT_READABLE_COMPLETE = 'Y.m.d H.i.s';

	const DATE_FORMAT_READABLE = 'Y-m-d';

	const TYPE_SECONDS = 2;

	const TYPE_MINUTES = 3;

	/**
	 * converts time in milliseconds to mssql datetime string
	 *
	 * @param int $time - time in milliseconds
	 * @return string
	 */
	public static function timeToMSSQLDateTime($time) {

		if (is_numeric($time)) {
			$mssqlDateTimeString = date('Y-m-d H:i:s', $time);
			return $mssqlDateTimeString;
		}

	}

	/**
	 * aa
	 * creates a readable date string representing the $millis
	 *
	 * @param int $millis
	 * @return string - the readable date string
	 */
	public static function createReadableDateComplete($millis = null) {

		if (empty($millis)) {
			$millis = time();
		}

		return (date(DateUtils::DATE_FORMAT_READABLE_COMPLETE, $millis));

	}

	public static function createReadableDate($millis = null) {

		if (empty($millis)) {
			$millis = time();
		}

		return (date(DateUtils::DATE_FORMAT_READABLE, $millis));

	}

	/**
	 * calculate the gap of the first date from the second date
	 *
	 * @param string $firstDate - the first date; probably has the greater value; string in date format;
	 * @param string $secondDate - the second date; probably has the lesser value string in date format;
	 * @param number $returnType
	 */
	public static function getGap($firstDate, $secondDate, $returnType) {

		$to_time = strtotime($secondDate);
		$from_time = strtotime($firstDate);

		switch ($returnType) {
			case DateUtils::TYPE_SECONDS :
				return round(abs($to_time - $from_time), 2);
				break;

			case DateUtils::TYPE_MINUTES :
				return round(abs($to_time - $from_time) / (60), 2);
				break;

			default :
				return round(abs($to_time - $from_time), 2);
				break;
		}

	}

	/**
	 *
	 * @return string example:20120409
	 */
	public static function createSimpleIntDate() {

		$date = date('Ymd', time());

		return $date;

	}

	public static function createWebFriendlyDateComplete($millis = null) {

		if (empty($millis)) {
			$millis = time();
		}

		$dateFormat = 'YYMMDD';
		if (StringUtils::isEqualIgnoreCase(date($dateFormat, time()), date($dateFormat, $millis))) {
			$dateString .= 'Today';
		} else {
			$dateString .= date('y-m-d', $millis);
		}
		$dateString .= ' ' . date('h:m:s A', $millis);

		return $dateString;

	}

	public static function getVersionMonth() {

		return date('Ym', time());

	}

	public static function getVersionDay() {

		return date('Ymd', time());

	}

	public static function getAgeDay($birthdate) {

		$age = date_diff(date_create($birthdate), date_create('now'))->y;

		$datetime1 = date_create($birthdate);
		$datetime2 = date_create('now');
		$interval = date_diff($datetime1, $datetime2);
		$age = $interval->days;

		return $age;

	}

	public static function getMonthDifference($date1, $date2) {

		$d1 = new DateTime($date1);
		$d2 = new DateTime($date2);

		return ($d1->diff($d2)->m + ($d1->diff($d2)->y * 12));

	}

}