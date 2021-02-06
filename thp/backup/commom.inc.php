<?php 
######################################################
# ePay CubeCart3 module v1.0 written by convict      #
# http://cubecart-mods-skins.com (C)2007             #
# Common part                                        #
######################################################

if (eregi(".inc.php",$HTTP_SERVER_VARS['PHP_SELF']) || eregi(".inc.php",$_SERVER['PHP_SELF'])) {
	echo "<html>\r\n<head>\r\n<title>Forbidden 403</title>\r\n</head>\r\n<body><h3>Forbidden 403</h3>\r\nThe document you are requesting is forbidden.\r\n</body>\r\n</html>";
	exit;
}

// Define domestic country
$domestic = $config['siteCountry'];

$cards_dansk = array("1"=>array('1',"dankort","Dankort"),
                     "2"=>array('1',"visa_dankort","Visa Dankort"),
                     "4"=>array('4',"master","Master Card"),
                     "6"=>array('5',"electron","Visa Electron"),
                     "7"=>array('6',"jcb","JCB"),
                     "8"=>array('8',"diners","Diners"),
                     "9"=>array('14',"maestro","Maestro"),
                     "10"=>array('9',"amex","American Express"),
                     "12"=>array('2',"edk","EDK"),
                     "17"=>array('10',"ewire","ewire"),
                     "18"=>array('3',"visa","Visa"),
                     "20"=>array('15',"others","Others"),                     
                     "21"=>array('12',"nordea","Nordea"),
                     "22"=>array('13',"danske","Danske"),
                     "16"=>array('11',"forb","FORBRUGSFORENINGEN"),
                     "19"=>array("ikano","Ikano"),                     
);

$cards_foreign = array("18"=>array('3',"visa","Visa"),
                    "3"=>array('5',"electron","Visa Electron",''),
                     "5"=>array('4',"master","Master Card"),
                     "13"=>array('8',"diners","Diners"),
                     "14"=>array('9',"amex","American Express"),
                     "15"=>array('14',"maestro","Maestro"),
);

$acceptedCards = $card_screen = array();

# read allowed credit cards
if ($module['mode']==0 && $module[0]==1){
  // ALL
  $acceptedCards[] = '0';
   
  } else {

  if (isset($dankort)) unset($dankort);

  foreach ($cards_dansk as $key=>$carray) {
    if ($module[$carray[0]]==1) {
      $acceptedCards[] = $key;
      // Domestic
      if ($module['mode']==1 && $ccUserData[0]['country']==$domestic) {
        if ($carray[0]==1 && !isset($dankort)){
          $card_screen[] = array('1','dankort','Dankort / Visa Dankort');
          $dankort = 1;
        } elseif ($carray[0]!=1) {
          $card_screen[] = $carray;      
        }
      }     
    }
  }

  foreach ($cards_foreign as $key=>$carray) {
    if ($module[$carray[0]]==1) {
      $acceptedCards[] = $key;
      // Foreign
      if ($ccUserData[0]['country']!=$domestic && $module['mode']==1) $card_screen[] = $carray;
    }
  }
  
  // Others
  if ($module['16']==1) $acceptedCards[] = '20';
}

sort($acceptedCards,SORT_NUMERIC); reset($acceptedCards);
$acceptedCards = implode(",",$acceptedCards);

if    ($config['defaultCurrency']=="USD"){ $currencyNo = 840; }
elseif($config['defaultCurrency']=="CAD"){ $currencyNo = 124; }
elseif($config['defaultCurrency']=="CHF"){ $currencyNo = 756; }
elseif($config['defaultCurrency']=="GBP"){ $currencyNo = 826; }
elseif($config['defaultCurrency']=="AUD"){ $currencyNo = 036; }
elseif($config['defaultCurrency']=="JPY"){ $currencyNo = 392; }
elseif($config['defaultCurrency']=="EUR"){ $currencyNo = 978; }
elseif($config['defaultCurrency']=="SEK"){ $currencyNo = 752; }
elseif($config['defaultCurrency']=="NOK"){ $currencyNo = 578; }
else { $currencyNo = 208; }
	
switch ($lang_folder) {
  case "en": $language = 2; break;
	case "se": $language = 3; break;
	case "no": $language = 4; break;
	default: $language = 1;
}

$amount = $basket['grandTotal']*100;

if ($module['fee']==2 && $ccUserData[0]['country']==$domestic) {
  $order_fee = 0;
} elseif ($module['fee']==2 && $ccUserData[0]['country']!=$domestic) {
  $order_fee = 1;
} else {
  $order_fee = $module['fee'];
}
?>
