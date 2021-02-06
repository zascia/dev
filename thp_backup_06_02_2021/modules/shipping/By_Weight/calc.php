<?php
/*
+--------------------------------------------------------------------------
|   CubeCart v3.0.17
|   ========================================
|   by Alistair Brookbanks
|	CubeCart is a Trade Mark of Devellion Limited
|   Copyright Devellion Limited 2005 - 2006. All rights reserved.
|   Devellion Limited,
|   5 Bridge Street,
|   Bishops Stortford,
|   HERTFORDSHIRE.
|   CM23 2JU
|   UNITED KINGDOM
|   http://www.devellion.com
|	UK Private Limited Company No. 5323904
|   ========================================
|   Web: http://www.cubecart.com
|   Date: Tuesday, 17th July 2007
|   Email: sales (at) cubecart (dot) com
|	License Type: CubeCart is NOT Open Source Software and Limitations Apply 
|   Licence Info: http://www.cubecart.com/site/faq/license.php
+--------------------------------------------------------------------------
|	calc.php
|   ========================================
|	Calculates shipping by weight (Lbs or Kgs)	
+--------------------------------------------------------------------------
*/
// per category shipping module
$module = fetchDbConfig("By_Weight");

if($module['status']==1){

// get the delivery ISO
$countryISO = countryIso($basket['delInf']['country']);

// build array of ISO Codes
$zones['1'] = explode(",",str_replace(" ","",strtoupper($module['zone1Countries'])));
$zones['2'] = explode(",",str_replace(" ","",strtoupper($module['zone2Countries'])));
$zones['3'] = explode(",",str_replace(" ","",strtoupper($module['zone3Countries'])));
$zones['4'] = explode(",",str_replace(" ","",strtoupper($module['zone4Countries'])));

// find the country
foreach ($zones as $key => $value){

	foreach($zones[$key] as $no => $iso){
	
		if($iso == $countryISO){
		
			$shipZone = $key;
		
		}
	
	}

}

// work out cost
$shipBands = explode(",",str_replace(" ","",$module['zone'.$shipZone.'RatesClass1']));
$noBands = count($shipBands);

if($noBands>0){

	for($n=0; $n<count($shipBands);$n++){
	
		$wheightCost = explode(":",str_replace(" ","",$shipBands[$n]));
		
		if($totalWeight<=$wheightCost[0]){
			
			$sumClass1 = $wheightCost[1]+$module['zone'.$shipZone.'Handling'];
			break;
			
		} elseif($totalWeight>$wheightCost[0] && $n+1==$noBands){
		
			$overWeight = TRUE;
		
		}
	
	}
	
}

unset($shipBands, $noBands);

$shipBands = explode(",",str_replace(" ","",$module['zone'.$shipZone.'RatesClass2']));
$noBands = count($shipBands);

if($noBands>0){

	for($n=0; $n<count($shipBands);$n++){
	
		$wheightCost = explode(":",str_replace(" ","",$shipBands[$n]));
		
		if($totalWeight<=$wheightCost[0]){
			
			$sumClass2 = $wheightCost[1]+$module['zone'.$shipZone.'Handling'];
			break;
			
		} elseif($totalWeight>$wheightCost[0] && $n+1==$noBands){
		
			$overWeight = TRUE;
		
		}
	
	}
	
}

unset($shipBands, $noBands);

if($sum == 0){
	$sum = 0.00;
}

$taxVal = taxRate($module['tax']);

if($sumClass1>0){

	if($taxVal>0){
	
		$val = ($taxVal / 100) * $sumClass1;
		$sumClass1 = $sumClass1 + $val;
	}

	$shippingPrice .= "<option value='".$shipKey."'";
	
	if($shipKey ==$basket['shipKey']){
		$shippingPrice .= " selected='selected'";
		$basket = $cart->setVar($lang['misc']['byWeight1stClass'],"shipMethod");
		$basket = $cart->setVar(sprintf("%.2f",$sumClass1),"shipCost");
	}
	
	$sum = $sumClass1;
	
	$shippingPrice .= ">".priceFormat($sumClass1)." ".$lang['misc']['1stClass']."</option>\r\n";
	$shippingAvailable = TRUE;
	
	$shipKey++;
}

if($sumClass2>0){

	if($taxVal>0){
	
		$val = ($taxVal / 100) * $sumClass2;
		$sumClass2 = $sumClass2 + $val;
	}

	$shippingPrice .= "<option value='".$shipKey."'";
	
	if($shipKey ==$basket['shipKey']){
		$shippingPrice .= " selected='selected'";
		$basket = $cart->setVar($lang['misc']['byWeight2ndClass'],"shipMethod");
		$basket = $cart->setVar(sprintf("%.2f",$sumClass2),"shipCost");
	}
	
	$sum = $sumClass2;
	
	$shippingPrice .= ">".priceFormat($sumClass2)." ".$lang['misc']['2ndClass']."</option>\r\n";
	$shippingAvailable = TRUE;
	$shipKey++;
}
unset($module, $taxVal, $shipBands, $noBands, $zones, $wheightCost, $countryISO);
}
?>