<?php
class ObjectUtils {
	public static function toHTMLTable($object){
		$html .= "<table>";
		$array = get_object_vars($object);
		$html .= "<tr>";
		foreach($array as $key=>$row) {
			
			$html .= "<td><div>" . $key . "</div>";
			$html .= "<div>" . $row . "</div></td>";
			
		}
		$html .= "</tr>";
		$html .= "</table>";

		return $html;
	}
	
	public static function arrayToObject($array){
		$obj = json_decode (json_encode ($array), FALSE);
		
		return $obj;
	}
}