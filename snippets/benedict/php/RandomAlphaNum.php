<?php
class RandomAlphaNum{
	public static function generatesRandomAlphaNum($length=6){
		// makes a random alpha numeric string of a given lenth
		$aZ09 = array_merge(range('A', 'Z'), range('a', 'z'),range(0, 9));
		$out ='';
		for($c=0;$c < $length;$c++) {
			$out .= $aZ09[mt_rand(0,count($aZ09)-1)];
		}
		return $out;
	}
}