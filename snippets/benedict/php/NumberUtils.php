<?php
class NumberUtils{
	public static function to2Decimals($number){

		if(is_numeric($number)){
			$number = number_format($number,2);
		}

		return $number;
	}

	public static function toWhole($number){

		if(is_numeric($number)){
			$number = number_format($number,0);
		}

		return $number;
	}


	public static function NumberToWords($x) {
		$nwords = array("zero", "one", "two", "three", "four", "five", "six", "seven",
				"eight", "nine", "ten", "eleven", "twelve", "thirteen", "fourteen", "fifteen",
				"sixteen", "seventeen", "eighteen", "nineteen", "twenty", 30 => "thirty",
				40 => "forty", 50 => "fifty", 60 => "sixty", 70 => "seventy", 80 => "eighty",
				90 => "ninety" );

		if(!is_numeric($x)) {
			$w = '#';

		}else if(fmod($x, 1) != 0) {
			$w = '#';

		}else{
			if($x < 0) {
				$w = 'minus ';
				$x = -$x;
			}else{
				$w = '';
			}

			if($x < 21) {
				$w .= $nwords[$x];

			}else if($x < 100) {
				$w .= $nwords[10 * floor($x/10)];
				$r = fmod($x, 10);
				if($r > 0) {
					$w .= '-'. $nwords[$r];
				}

			} else if($x < 1000) {
				$w .= $nwords[floor($x/100)] .' hundred';
				$r = fmod($x, 100);
				if($r > 0) {
					$w .= ' and '. self::NumberToWords($r);
				}

			} else if($x < 100000) {
				$w .= self::NumberToWords(floor($x/1000)) .' thousand';
				$r = fmod($x, 1000);

				if($r > 0) {
					$w .= ' ';
					if($r < 100) {
						$w .= 'and ';
					}

					$w .= self::NumberToWords($r);
				}

			} else {
				$w .= self::NumberToWords(floor($x/100000)) .' lakh';
				$r = fmod($x, 100000);
				if($r > 0) {
					$w .= ' ';
					if($r < 100) {
						$word .= 'and ';
					}
					$w .= self::NumberToWords($r);
				}
			}
		}

		return $w;
	}

	public static function getPluralPostfix($value){
		if($value>1){
			return 's';
		}

		return '';
	}

	public static function formatToCurrency($number){
		if(is_numeric($number)){
			$number = number_format($number, 2, ",", ".");
		}

		return $number;
	}
	
	public static function getClosest($search, $arr) {
		$closest = null;
		foreach ($arr as $item) {
			if ($closest === null || abs($search - $closest) > abs($item - $search)) {
				$closest = $item;
			}
		}
		return $closest;
	}
}