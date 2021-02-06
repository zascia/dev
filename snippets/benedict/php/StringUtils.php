<?php
class StringUtils {

	public static function startsWith($string, $char) {

		$length = strlen($char);
		return (substr($string, 0, $length) === $char);

	}

	public static function endsWith($string, $char) {

		$length = strlen($char);
		$start = $length * - 1; // negative
		return (substr($string, $start, $length) === $char);

	}

	/**
	 *
	 * @param string $string
	 * @param string $substring - a string or an array of string
	 * @param boolean $sensitive
	 * @throws InvalidArgumentException
	 * @return boolean
	 */
	public static function contains($string, $substring, $sensitive = true) {

		if ($sensitive) {

			if (is_string($substring)) {
				if (strstr($string, $substring) != FALSE) {
					return true;
				}
			} else if (ArrayUtils::hasContent($substring)) {
				foreach($substring as $substring1) {
					if (strstr($string, $substring1) != FALSE) {
						return true;
					}
				}
			}

			return false;
		} else {

			if (is_string($substring)) {
				if (stristr($string, $substring) != FALSE) {
					return true;
				}
			} else if (ArrayUtils::hasContent($substring)) {
				foreach($substring as $substring1) {
					if (stristr($string, $substring1) != FALSE) {
						return true;
					}
				}
			}

			return false;
		}

	}

	/**
	 * removes all spaces, new line
	 *
	 * @param string $string
	 * @return mixed
	 */
	public static function superTrim($string) {

		$sPattern = '/\s*/m';
		$sReplace = '';
		try {
			if (! is_string($string)) {
				$string = print_r($string, true);
			}
			return preg_replace($sPattern, $sReplace, $string);
		} catch ( Exception $e ) {
		}

		return $string;

	}

	public static function removeNewLines($string) {

		$string = trim(preg_replace('/\s+/', ' ', $string));

		return $string;

	}

	public static function createLF() {

		return '

				';

	}

	public static function addSpaceBetweenCamel($string) {

		$pattern = '/(.*?[a-z]{1})([A-Z]{1}.*?)/';
		$replace = '${1} ${2}';

		return preg_replace($pattern, $replace, $string);

	}

	public static function getOnlyValid($str, $length) {

		if (StringUtils::isNotBlank($str) && is_numeric($length)) {
			$str = StringUtils::superTrim($str);
			$str = substr($str, 0, abs($length));
			return $str;
		}

		return '';

	}

	public static function getAlphaOnly($str) {

		return preg_replace("/[^A-Z]+/", "", $str);

	}

	public static function getAlphaNumOnly($str) {

		return preg_replace("/[^a-zA-Z0-9]+/", "", $str);

	}

	public static function getAlphaNumOnly2($str) {

		return preg_replace('/[^\w]/', '', $str);

	}

	public static function getAlphaNumDashUndescoreOnly($str) {

		return preg_replace('/[^\w-]/', "", $str);

	}

	public static function removeExtraSpaces($str) {

		return trim($str);

	}

	public static function getNumbOnly($str) {

		return preg_replace("/[^0-9]/", "", $str);

	}

	public static function insertAfter($str, $search, $insert) {

		$index = stripos($str, $search);
		if ($index === false) {
			return $str;
		}
		return substr_replace($str, $search . $insert, $index, strlen($search));

	}

	public static function getSubstringBetween($subject, $prefixStr, $suffixStr) {

		$temp1 = strpos($subject, $prefixStr) + strlen($prefixStr);
		$result = substr($subject, $temp1, strlen($subject));
		$dd = strpos($result, $suffixStr);
		if ($dd == 0) {
			$dd = strlen($result);
		}

		return substr($result, 0, $dd);

	}

	public static function getSubstringBetweenLastOccurrence($subject, $prefixStr, $suffixStr) {

		$temp1 = strrpos($subject, $prefixStr) + strlen($prefixStr);
		$result = substr($subject, $temp1, strlen($subject));
		$dd = strpos($result, $suffixStr);
		if ($dd == 0) {
			$dd = strlen($result);
		}

		return substr($result, 0, $dd);

	}

	public static function getNumbersAsGroups($str) {

		$matches = array();
		preg_match_all('!\d+\.*\d*!', $str, $matches);

		return $matches[0];

	}

}