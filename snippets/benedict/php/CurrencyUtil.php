<?php
class CurrencyUtil {
	
	private static $currencies;

	public static function getCurrencyCodes() {

		$arr = array(
				"AED",
				"AFN",
				"ALL",
				"AMD",
				"AOA",
				"ARS",
				"AUD",
				"AWG",
				"AZN",
				"BAM",
				"BBD",
				"BDT",
				"BGN",
				"BHD",
				"BIF",
				"BMD",
				"BND",
				"BOB",
				"BRL",
				"BSD",
				"BTN",
				"BWP",
				"BYR",
				"BZD",
				"CAD",
				"CDF",
				"CHF",
				"CLP",
				"CNY",
				"COP",
				"CRC",
				"CUP",
				"CVE",
				"CZK",
				"DJF",
				"DKK",
				"DOP",
				"DZD",
				"EGP",
				"ERN",
				"ETB",
				"EUR",
				"FJD",
				"FKP",
				"GBP",
				"GEL",
				"GHS",
				"GMD",
				"GNF",
				"GTQ",
				"GYD",
				"HKD",
				"HNL",
				"HRK",
				"HTG",
				"HUF",
				"IDR",
				"ILS",
				"IMP",
				"INR",
				"IQD",
				"IRR",
				"ISK",
				"JEP",
				"JMD",
				"JOD",
				"JPY",
				"KES",
				"KGS",
				"KHR",
				"KMF",
				"KPW",
				"KRW",
				"KWD",
				"KYD",
				"KZT",
				"LAK",
				"LBP",
				"LKR",
				"LRD",
				"LSL",
				"LTL",
				"LVL",
				"LYD",
				"MAD",
				"MDL",
				"MGA",
				"MKD",
				"MMK",
				"MNT",
				"MOP",
				"MRO",
				"MUR",
				"MVR",
				"MWK",
				"MXN",
				"MYR",
				"MZN",
				"NAD",
				"NGN",
				"NIO",
				"NOK",
				"NPR",
				"NZD",
				"OMR",
				"PAB",
				"PEN",
				"PGK",
				"PHP",
				"PKR",
				"PLN",
				"PRB",
				"PYG",
				"QAR",
				"RON",
				"RSD",
				"RUB",
				"RWF",
				"SAR",
				"SBD",
				"SCR",
				"SDG",
				"SEK",
				"SGD",
				"SHP",
				"SLL",
				"SOS",
				"SRD",
				"SSP",
				"STD",
				"SVC",
				"SYP",
				"SZL",
				"THB",
				"TJS",
				"TMT",
				"TND",
				"TOP",
				"TRY",
				"TTD",
				"TWD",
				"TZS",
				"UAH",
				"UGX",
				"USD",
				"UYU",
				"UZS",
				"VEF",
				"VND",
				"VUV",
				"WST",
				"XAF",
				"XCD",
				"XOF",
				"XPF",
				"YER",
				"ZAR",
				"ZMW",
				"ZWL"
		);
		return $arr;
	
	}

	public static function getSymbol($currencyCode) {
		
		// $currencyJSONStr = '{"AFN":{text:"Afghani",fraction:2,symbol:"؋"},"EUR":{text:"Euro",fraction:2,symbol:"€"},"ALL":{text:"Lek",fraction:2,symbol:"Lek"},"DZD":{text:"Algerian Dinar",fraction:2,symbol:false},"USD":{text:"US Dollar",fraction:2,symbol:"$"},"AOA":{text:"Kwanza",fraction:2,symbol:false},"XCD":{text:"East Caribbean Dollar",fraction:2,symbol:"$"},"ARS":{text:"Argentine Peso",fraction:2,symbol:"$"},"AMD":{text:"Armenian Dram",fraction:2,symbol:false},"AWG":{text:"Aruban Florin",fraction:2,symbol:"ƒ"},"AUD":{text:"Australian Dollar",fraction:2,symbol:"$"},"AZN":{text:"Azerbaijanian Manat",fraction:2,symbol:"ман"},"BSD":{text:"Bahamian Dollar",fraction:2,symbol:"$"},"BHD":{text:"Bahraini Dinar",fraction:3,symbol:false},"BDT":{text:"Taka",fraction:2,symbol:false},"BBD":{text:"Barbados Dollar",fraction:2,symbol:"$"},"BYR":{text:"Belarussian Ruble",fraction:0,symbol:"p."},"BZD":{text:"Belize Dollar",fraction:2,symbol:"BZ$"},"XOF":{text:"CF Franc
		// BCEAO",fraction:0,symbol:false},"BMD":{text:"Bermudian Dollar",fraction:2,symbol:"$"},"BTN":{text:"Ngultrum",fraction:2,symbol:false},"INR":{text:"Indian Rupee",fraction:2,symbol:""},"BOB":{text:"Boliviano",fraction:2,symbol:"$b"},"BOV":{text:"Mvdol",fraction:2,symbol:false},"BAM":{text:"Convertible Mark",fraction:2,symbol:"KM"},"BWP":{text:"Pula",fraction:2,symbol:"P"},"NOK":{text:"Norwegian Krone",fraction:2,symbol:"kr"},"BRL":{text:"Brazilian Real",fraction:2,symbol:"R$"},"BND":{text:"Brunei Dollar",fraction:2,symbol:"$"},"BGN":{text:"Bulgarian Lev",fraction:2,symbol:"лв"},"BIF":{text:"Burundi Franc",fraction:0,symbol:false},"KHR":{text:"Riel",fraction:2,symbol:"៛"},"XAF":{text:"CF Franc BEAC",fraction:0,symbol:false},"CAD":{text:"Canadian Dollar",fraction:2,symbol:"$"},"CVE":{text:"Cabo Verde Escudo",fraction:2,symbol:false},"KYD":{text:"Cayman Islands Dollar",fraction:2,symbol:"$"},"CLF":{text:"Unidad de Fomento",fraction:4,symbol:false},"CLP":{text:"Chilean
		// Peso",fraction:0,symbol:"$"},"CNY":{text:"Yuan Renminbi",fraction:2,symbol:"¥"},"COP":{text:"Colombian Peso",fraction:2,symbol:"$"},"COU":{text:"Unidad de Valor Real",fraction:2,symbol:false},"KMF":{text:"Comoro Franc",fraction:0,symbol:false},"CDF":{text:"Congolese Franc",fraction:2,symbol:false},"NZD":{text:"New Zealand Dollar",fraction:2,symbol:"$"},"CRC":{text:"Cost Rican Colon",fraction:2,symbol:"₡"},"HRK":{text:"Croatian Kuna",fraction:2,symbol:"kn"},"CUC":{text:"Peso Convertible",fraction:2,symbol:false},"CUP":{text:"Cuban Peso",fraction:2,symbol:"₱"},"ANG":{text:"Netherlands Antillean Guilder",fraction:2,symbol:"ƒ"},"CZK":{text:"Czech Koruna",fraction:2,symbol:"Kč"},"DKK":{text:"Danish Krone",fraction:2,symbol:"kr"},"DJF":{text:"Djibouti Franc",fraction:0,symbol:false},"DOP":{text:"Dominican Peso",fraction:2,symbol:"RD$"},"EGP":{text:"Egyptian Pound",fraction:2,symbol:"£"},"SVC":{text:"El Salvador
		// Colon",fraction:2,symbol:"$"},"ERN":{text:"Nakfa",fraction:2,symbol:false},"ETB":{text:"Ethiopian Birr",fraction:2,symbol:false},"FKP":{text:"Falkland Islands Pound",fraction:2,symbol:"£"},"FJD":{text:"Fiji Dollar",fraction:2,symbol:"$"},"XPF":{text:"CFP Franc",fraction:0,symbol:false},"GMD":{text:"Dalasi",fraction:2,symbol:false},"GEL":{text:"Lari",fraction:2,symbol:false},"GHS":{text:"Ghan Cedi",fraction:2,symbol:false},"GIP":{text:"Gibraltar Pound",fraction:2,symbol:"£"},"GTQ":{text:"Quetzal",fraction:2,symbol:"Q"},"GBP":{text:"Pound Sterling",fraction:2,symbol:"£"},"GNF":{text:"Guine Franc",fraction:0,symbol:false},"GYD":{text:"Guyan Dollar",fraction:2,symbol:"$"},"HTG":{text:"Gourde",fraction:2,symbol:false},"HNL":{text:"Lempira",fraction:2,symbol:"L"},"HKD":{text:"Hong Kong Dollar",fraction:2,symbol:"$"},"HUF":{text:"Forint",fraction:2,symbol:"Ft"},"ISK":{text:"Iceland Krona",fraction:0,symbol:"kr"},"IDR":{text:"Rupiah",fraction:2,symbol:"Rp"},"XDR":{text:"SDR
		// (Special Drawing Right)",fraction:0,symbol:false},"IRR":{text:"Iranian Rial",fraction:2,symbol:"﷼"},"IQD":{text:"Iraqi Dinar",fraction:3,symbol:false},"ILS":{text:"New Israeli Sheqel",fraction:2,symbol:"₪"},"JMD":{text:"Jamaican Dollar",fraction:2,symbol:"J$"},"JPY":{text:"Yen",fraction:0,symbol:"¥"},"JOD":{text:"Jordanian Dinar",fraction:3,symbol:false},"KZT":{text:"Tenge",fraction:2,symbol:"лв"},"KES":{text:"Kenyan Shilling",fraction:2,symbol:false},"KPW":{text:"North Korean Won",fraction:2,symbol:"₩"},"KRW":{text:"Won",fraction:0,symbol:"₩"},"KWD":{text:"Kuwaiti Dinar",fraction:3,symbol:false},"KGS":{text:"Som",fraction:2,symbol:"лв"},"LAK":{text:"Kip",fraction:2,symbol:"₭"},"LBP":{text:"Lebanese Pound",fraction:2,symbol:"£"},"LSL":{text:"Loti",fraction:2,symbol:false},"ZAR":{text:"Rand",fraction:2,symbol:"R"},"LRD":{text:"Liberian Dollar",fraction:2,symbol:"$"},"LYD":{text:"Libyan Dinar",fraction:3,symbol:false},"CHF":{text:"Swiss
		// Franc",fraction:2,symbol:"CHF"},"LTL":{text:"Lithuanian Litas",fraction:2,symbol:"Lt"},"MOP":{text:"Pataca",fraction:2,symbol:false},"MKD":{text:"Denar",fraction:2,symbol:"ден"},"MGA":{text:"Malagasy riary",fraction:2,symbol:false},"MWK":{text:"Kwacha",fraction:2,symbol:false},"MYR":{text:"Malaysian Ringgit",fraction:2,symbol:"RM"},"MVR":{text:"Rufiyaa",fraction:2,symbol:false},"MRO":{text:"Ouguiya",fraction:2,symbol:false},"MUR":{text:"Mauritius Rupee",fraction:2,symbol:"₨"},"XUA":{text:"ADB Unit of ccount",fraction:0,symbol:false},"MXN":{text:"Mexican Peso",fraction:2,symbol:"$"},"MXV":{text:"Mexican Unidad de Inversion (UDI)",fraction:2,symbol:false},"MDL":{text:"Moldovan Leu",fraction:2,symbol:false},"MNT":{text:"Tugrik",fraction:2,symbol:"₮"},"MAD":{text:"Moroccan Dirham",fraction:2,symbol:false},"MZN":{text:"Mozambique Metical",fraction:2,symbol:"MT"},"MMK":{text:"Kyat",fraction:2,symbol:false},"NAD":{text:"Namibi Dollar",fraction:2,symbol:"$"},"NPR":{text:"Nepalese
		// Rupee",fraction:2,symbol:"₨"},"NIO":{text:"Cordob Oro",fraction:2,symbol:"C$"},"NGN":{text:"Naira",fraction:2,symbol:"₦"},"OMR":{text:"Rial Omani",fraction:3,symbol:"﷼"},"PKR":{text:"Pakistan Rupee",fraction:2,symbol:"₨"},"PAB":{text:"Balboa",fraction:2,symbol:"B/."},"PGK":{text:"Kina",fraction:2,symbol:false},"PYG":{text:"Guarani",fraction:0,symbol:"Gs"},"PEN":{text:"Nuevo Sol",fraction:2,symbol:"S/."},"PHP":{text:"Philippine Peso",fraction:2,symbol:"₱"},"PLN":{text:"Zloty",fraction:2,symbol:"zł"},"QAR":{text:"Qatari Rial",fraction:2,symbol:"﷼"},"RON":{text:"New Romanian Leu",fraction:2,symbol:"lei"},"RUB":{text:"Russian Ruble",fraction:2,symbol:"руб"},"RWF":{text:"Rwand Franc",fraction:0,symbol:false},"SHP":{text:"Saint Helen Pound",fraction:2,symbol:"£"},"WST":{text:"Tala",fraction:2,symbol:false},"STD":{text:"Dobra",fraction:2,symbol:false},"SAR":{text:"Saudi Riyal",fraction:2,symbol:"﷼"},"RSD":{text:"Serbian Dinar",fraction:2,symbol:"Дин."},"SCR":{text:"Seychelles
		// Rupee",fraction:2,symbol:"₨"},"SLL":{text:"Leone",fraction:2,symbol:false},"SGD":{text:"Singapore Dollar",fraction:2,symbol:"$"},"XSU":{text:"Sucre",fraction:0,symbol:false},"SBD":{text:"Solomon Islands Dollar",fraction:2,symbol:"$"},"SOS":{text:"Somali Shilling",fraction:2,symbol:"S"},"SSP":{text:"South Sudanese Pound",fraction:2,symbol:false},"LKR":{text:"Sri Lank Rupee",fraction:2,symbol:"₨"},"SDG":{text:"Sudanese Pound",fraction:2,symbol:false},"SRD":{text:"Surinam Dollar",fraction:2,symbol:"$"},"SZL":{text:"Lilangeni",fraction:2,symbol:false},"SEK":{text:"Swedish Krona",fraction:2,symbol:"kr"},"CHE":{text:"WIR Euro",fraction:2,symbol:false},"CHW":{text:"WIR Franc",fraction:2,symbol:false},"SYP":{text:"Syrian Pound",fraction:2,symbol:"£"},"TWD":{text:"New Taiwan Dollar",fraction:2,symbol:"NT$"},"TJS":{text:"Somoni",fraction:2,symbol:false},"TZS":{text:"Tanzanian
		// Shilling",fraction:2,symbol:false},"THB":{text:"Baht",fraction:2,symbol:"฿"},"TOP":{text:"Pa’anga",fraction:2,symbol:false},"TTD":{text:"Trinidad nd Tobago Dollar",fraction:2,symbol:"TT$"},"TND":{text:"Tunisian Dinar",fraction:3,symbol:false},"TRY":{text:"Turkish Lira",fraction:2,symbol:""},"TMT":{text:"Turkmenistan New Manat",fraction:2,symbol:false},"UGX":{text:"Ugand Shilling",fraction:0,symbol:false},"UAH":{text:"Hryvnia",fraction:2,symbol:"₴"},"AED":{text:"UAE Dirham",fraction:2,symbol:false},"USN":{text:"US Dollar (Next day)",fraction:2,symbol:false},"UYI":{text:"Uruguay Peso en Unidades Indexadas (URUIURUI)",fraction:0,symbol:false},"UYU":{text:"Peso Uruguayo",fraction:2,symbol:"$U"},"UZS":{text:"Uzbekistan Sum",fraction:2,symbol:"лв"},"VUV":{text:"Vatu",fraction:0,symbol:false},"VEF":{text:"Bolivar",fraction:2,symbol:"Bs"},"VND":{text:"Dong",fraction:0,symbol:"₫"},"YER":{text:"Yemeni Rial",fraction:2,symbol:"﷼"},"ZMW":{text:"Zambian
		// Kwacha",fraction:2,symbol:false},"ZWL":{text:"Zimbabwe Dollar",fraction:2,symbol:false}}';
		
		// $currencies = fJSON::decode(htmlspecialchars($currencyJSONStr), false);
		
		//fCore::expose($currencies);
		
		$currencies = self::getCurrencies();
		$currencyCode = strtoupper($currencyCode);
		$currency = $currencies[$currencyCode];
		return $currency['symbol'] ? $currency['symbol'] : $currencyCode;
	
	}
	
	public static function getName($currencyCode) {
	
		$currencies = self::getCurrencies();
		$currencyCode = strtoupper($currencyCode);
		$currency = $currencies[$currencyCode];
		return $currency['text'];
	
	}

	public static function getCurrencies(){
		if(!isset(self::$currencies)){
			self::$currencies = array(
					"AFN" => array(
							"text" => "Afghani",
							"fraction" => 2,
							"symbol" => "؋"
					),
					"EUR" => array(
							"text" => "Euro",
							"fraction" => 2,
							"symbol" => "€"
					),
					"ALL" => array(
							"text" => "Lek",
							"fraction" => 2,
							"symbol" => "Lek"
					),
					"DZD" => array(
							"text" => "Algerian Dinar",
							"fraction" => 2,
							"symbol" => false
					),
					"USD" => array(
							"text" => "US Dollar",
							"fraction" => 2,
							"symbol" => "$"
					),
					"AOA" => array(
							"text" => "Kwanza",
							"fraction" => 2,
							"symbol" => false
					),
					"XCD" => array(
							"text" => "East Caribbean Dollar",
							"fraction" => 2,
							"symbol" => "$"
					),
					"ARS" => array(
							"text" => "Argentine Peso",
							"fraction" => 2,
							"symbol" => "$"
					),
					"AMD" => array(
							"text" => "Armenian Dram",
							"fraction" => 2,
							"symbol" => false
					),
					"AWG" => array(
							"text" => "Aruban Florin",
							"fraction" => 2,
							"symbol" => "ƒ"
					),
					"AUD" => array(
							"text" => "Australian Dollar",
							"fraction" => 2,
							"symbol" => "$"
					),
					"AZN" => array(
							"text" => "Azerbaijanian Manat",
							"fraction" => 2,
							"symbol" => "ман"
					),
					"BSD" => array(
							"text" => "Bahamian Dollar",
							"fraction" => 2,
							"symbol" => "$"
					),
					"BHD" => array(
							"text" => "Bahraini Dinar",
							"fraction" => 3,
							"symbol" => false
					),
					"BDT" => array(
							"text" => "Taka",
							"fraction" => 2,
							"symbol" => false
					),
					"BBD" => array(
							"text" => "Barbados Dollar",
							"fraction" => 2,
							"symbol" => "$"
					),
					"BYR" => array(
							"text" => "Belarussian Ruble",
							"fraction" => 0,
							"symbol" => "p."
					),
					"BZD" => array(
							"text" => "Belize Dollar",
							"fraction" => 2,
							"symbol" => "BZ$"
					),
					"XOF" => array(
							"text" => "CF Franc BCEAO",
							"fraction" => 0,
							"symbol" => false
					),
					"BMD" => array(
							"text" => "Bermudian Dollar",
							"fraction" => 2,
							"symbol" => "$"
					),
					"BTN" => array(
							"text" => "Ngultrum",
							"fraction" => 2,
							"symbol" => false
					),
					"INR" => array(
							"text" => "Indian Rupee",
							"fraction" => 2,
							"symbol" => ""
					),
					"BOB" => array(
							"text" => "Boliviano",
							"fraction" => 2,
							"symbol" => "$b"
					),
					"BOV" => array(
							"text" => "Mvdol",
							"fraction" => 2,
							"symbol" => false
					),
					"BAM" => array(
							"text" => "Convertible Mark",
							"fraction" => 2,
							"symbol" => "KM"
					),
					"BWP" => array(
							"text" => "Pula",
							"fraction" => 2,
							"symbol" => "P"
					),
					"NOK" => array(
							"text" => "Norwegian Krone",
							"fraction" => 2,
							"symbol" => "kr"
					),
					"BRL" => array(
							"text" => "Brazilian Real",
							"fraction" => 2,
							"symbol" => "R$"
					),
					"BND" => array(
							"text" => "Brunei Dollar",
							"fraction" => 2,
							"symbol" => "$"
					),
					"BGN" => array(
							"text" => "Bulgarian Lev",
							"fraction" => 2,
							"symbol" => "лв"
					),
					"BIF" => array(
							"text" => "Burundi Franc",
							"fraction" => 0,
							"symbol" => false
					),
					"KHR" => array(
							"text" => "Riel",
							"fraction" => 2,
							"symbol" => "៛"
					),
					"XAF" => array(
							"text" => "CF Franc BEAC",
							"fraction" => 0,
							"symbol" => false
					),
					"CAD" => array(
							"text" => "Canadian Dollar",
							"fraction" => 2,
							"symbol" => "$"
					),
					"CVE" => array(
							"text" => "Cabo Verde Escudo",
							"fraction" => 2,
							"symbol" => false
					),
					"KYD" => array(
							"text" => "Cayman Islands Dollar",
							"fraction" => 2,
							"symbol" => "$"
					),
					"CLF" => array(
							"text" => "Unidad de Fomento",
							"fraction" => 4,
							"symbol" => false
					),
					"CLP" => array(
							"text" => "Chilean Peso",
							"fraction" => 0,
							"symbol" => "$"
					),
					"CNY" => array(
							"text" => "Yuan Renminbi",
							"fraction" => 2,
							"symbol" => "¥"
					),
					"COP" => array(
							"text" => "Colombian Peso",
							"fraction" => 2,
							"symbol" => "$"
					),
					"COU" => array(
							"text" => "Unidad de Valor Real",
							"fraction" => 2,
							"symbol" => false
					),
					"KMF" => array(
							"text" => "Comoro Franc",
							"fraction" => 0,
							"symbol" => false
					),
					"CDF" => array(
							"text" => "Congolese Franc",
							"fraction" => 2,
							"symbol" => false
					),
					"NZD" => array(
							"text" => "New Zealand Dollar",
							"fraction" => 2,
							"symbol" => "$"
					),
					"CRC" => array(
							"text" => "Cost Rican Colon",
							"fraction" => 2,
							"symbol" => "₡"
					),
					"HRK" => array(
							"text" => "Croatian Kuna",
							"fraction" => 2,
							"symbol" => "kn"
					),
					"CUC" => array(
							"text" => "Peso Convertible",
							"fraction" => 2,
							"symbol" => false
					),
					"CUP" => array(
							"text" => "Cuban Peso",
							"fraction" => 2,
							"symbol" => "₱"
					),
					"ANG" => array(
							"text" => "Netherlands Antillean Guilder",
							"fraction" => 2,
							"symbol" => "ƒ"
					),
					"CZK" => array(
							"text" => "Czech Koruna",
							"fraction" => 2,
							"symbol" => "Kč"
					),
					"DKK" => array(
							"text" => "Danish Krone",
							"fraction" => 2,
							"symbol" => "kr"
					),
					"DJF" => array(
							"text" => "Djibouti Franc",
							"fraction" => 0,
							"symbol" => false
					),
					"DOP" => array(
							"text" => "Dominican Peso",
							"fraction" => 2,
							"symbol" => "RD$"
					),
					"EGP" => array(
							"text" => "Egyptian Pound",
							"fraction" => 2,
							"symbol" => "£"
					),
					"SVC" => array(
							"text" => "El Salvador Colon",
							"fraction" => 2,
							"symbol" => "$"
					),
					"ERN" => array(
							"text" => "Nakfa",
							"fraction" => 2,
							"symbol" => false
					),
					"ETB" => array(
							"text" => "Ethiopian Birr",
							"fraction" => 2,
							"symbol" => false
					),
					"FKP" => array(
							"text" => "Falkland Islands Pound",
							"fraction" => 2,
							"symbol" => "£"
					),
					"FJD" => array(
							"text" => "Fiji Dollar",
							"fraction" => 2,
							"symbol" => "$"
					),
					"XPF" => array(
							"text" => "CFP Franc",
							"fraction" => 0,
							"symbol" => false
					),
					"GMD" => array(
							"text" => "Dalasi",
							"fraction" => 2,
							"symbol" => false
					),
					"GEL" => array(
							"text" => "Lari",
							"fraction" => 2,
							"symbol" => false
					),
					"GHS" => array(
							"text" => "Ghan Cedi",
							"fraction" => 2,
							"symbol" => false
					),
					"GIP" => array(
							"text" => "Gibraltar Pound",
							"fraction" => 2,
							"symbol" => "£"
					),
					"GTQ" => array(
							"text" => "Quetzal",
							"fraction" => 2,
							"symbol" => "Q"
					),
					"GBP" => array(
							"text" => "Pound Sterling",
							"fraction" => 2,
							"symbol" => "£"
					),
					"GNF" => array(
							"text" => "Guine Franc",
							"fraction" => 0,
							"symbol" => false
					),
					"GYD" => array(
							"text" => "Guyan Dollar",
							"fraction" => 2,
							"symbol" => "$"
					),
					"HTG" => array(
							"text" => "Gourde",
							"fraction" => 2,
							"symbol" => false
					),
					"HNL" => array(
							"text" => "Lempira",
							"fraction" => 2,
							"symbol" => "L"
					),
					"HKD" => array(
							"text" => "Hong Kong Dollar",
							"fraction" => 2,
							"symbol" => "$"
					),
					"HUF" => array(
							"text" => "Forint",
							"fraction" => 2,
							"symbol" => "Ft"
					),
					"ISK" => array(
							"text" => "Iceland Krona",
							"fraction" => 0,
							"symbol" => "kr"
					),
					"IDR" => array(
							"text" => "Rupiah",
							"fraction" => 2,
							"symbol" => "Rp"
					),
					"XDR" => array(
							"text" => "SDR (Special Drawing Right)",
							"fraction" => 0,
							"symbol" => false
					),
					"IRR" => array(
							"text" => "Iranian Rial",
							"fraction" => 2,
							"symbol" => "﷼"
					),
					"IQD" => array(
							"text" => "Iraqi Dinar",
							"fraction" => 3,
							"symbol" => false
					),
					"ILS" => array(
							"text" => "New Israeli Sheqel",
							"fraction" => 2,
							"symbol" => "₪"
					),
					"JMD" => array(
							"text" => "Jamaican Dollar",
							"fraction" => 2,
							"symbol" => "J$"
					),
					"JPY" => array(
							"text" => "Yen",
							"fraction" => 0,
							"symbol" => "¥"
					),
					"JOD" => array(
							"text" => "Jordanian Dinar",
							"fraction" => 3,
							"symbol" => false
					),
					"KZT" => array(
							"text" => "Tenge",
							"fraction" => 2,
							"symbol" => "лв"
					),
					"KES" => array(
							"text" => "Kenyan Shilling",
							"fraction" => 2,
							"symbol" => false
					),
					"KPW" => array(
							"text" => "North Korean Won",
							"fraction" => 2,
							"symbol" => "₩"
					),
					"KRW" => array(
							"text" => "Won",
							"fraction" => 0,
							"symbol" => "₩"
					),
					"KWD" => array(
							"text" => "Kuwaiti Dinar",
							"fraction" => 3,
							"symbol" => false
					),
					"KGS" => array(
							"text" => "Som",
							"fraction" => 2,
							"symbol" => "лв"
					),
					"LAK" => array(
							"text" => "Kip",
							"fraction" => 2,
							"symbol" => "₭"
					),
					"LBP" => array(
							"text" => "Lebanese Pound",
							"fraction" => 2,
							"symbol" => "£"
					),
					"LSL" => array(
							"text" => "Loti",
							"fraction" => 2,
							"symbol" => false
					),
					"ZAR" => array(
							"text" => "Rand",
							"fraction" => 2,
							"symbol" => "R"
					),
					"LRD" => array(
							"text" => "Liberian Dollar",
							"fraction" => 2,
							"symbol" => "$"
					),
					"LYD" => array(
							"text" => "Libyan Dinar",
							"fraction" => 3,
							"symbol" => false
					),
					"CHF" => array(
							"text" => "Swiss Franc",
							"fraction" => 2,
							"symbol" => "CHF"
					),
					"LTL" => array(
							"text" => "Lithuanian Litas",
							"fraction" => 2,
							"symbol" => "Lt"
					),
					"MOP" => array(
							"text" => "Pataca",
							"fraction" => 2,
							"symbol" => false
					),
					"MKD" => array(
							"text" => "Denar",
							"fraction" => 2,
							"symbol" => "ден"
					),
					"MGA" => array(
							"text" => "Malagasy riary",
							"fraction" => 2,
							"symbol" => false
					),
					"MWK" => array(
							"text" => "Kwacha",
							"fraction" => 2,
							"symbol" => false
					),
					"MYR" => array(
							"text" => "Malaysian Ringgit",
							"fraction" => 2,
							"symbol" => "RM"
					),
					"MVR" => array(
							"text" => "Rufiyaa",
							"fraction" => 2,
							"symbol" => false
					),
					"MRO" => array(
							"text" => "Ouguiya",
							"fraction" => 2,
							"symbol" => false
					),
					"MUR" => array(
							"text" => "Mauritius Rupee",
							"fraction" => 2,
							"symbol" => "₨"
					),
					"XUA" => array(
							"text" => "ADB Unit of ccount",
							"fraction" => 0,
							"symbol" => false
					),
					"MXN" => array(
							"text" => "Mexican Peso",
							"fraction" => 2,
							"symbol" => "$"
					),
					"MXV" => array(
							"text" => "Mexican Unidad de Inversion (UDI)",
							"fraction" => 2,
							"symbol" => false
					),
					"MDL" => array(
							"text" => "Moldovan Leu",
							"fraction" => 2,
							"symbol" => false
					),
					"MNT" => array(
							"text" => "Tugrik",
							"fraction" => 2,
							"symbol" => "₮"
					),
					"MAD" => array(
							"text" => "Moroccan Dirham",
							"fraction" => 2,
							"symbol" => false
					),
					"MZN" => array(
							"text" => "Mozambique Metical",
							"fraction" => 2,
							"symbol" => "MT"
					),
					"MMK" => array(
							"text" => "Kyat",
							"fraction" => 2,
							"symbol" => false
					),
					"NAD" => array(
							"text" => "Namibi Dollar",
							"fraction" => 2,
							"symbol" => "$"
					),
					"NPR" => array(
							"text" => "Nepalese Rupee",
							"fraction" => 2,
							"symbol" => "₨"
					),
					"NIO" => array(
							"text" => "Cordob Oro",
							"fraction" => 2,
							"symbol" => "C$"
					),
					"NGN" => array(
							"text" => "Naira",
							"fraction" => 2,
							"symbol" => "₦"
					),
					"OMR" => array(
							"text" => "Rial Omani",
							"fraction" => 3,
							"symbol" => "﷼"
					),
					"PKR" => array(
							"text" => "Pakistan Rupee",
							"fraction" => 2,
							"symbol" => "₨"
					),
					"PAB" => array(
							"text" => "Balboa",
							"fraction" => 2,
							"symbol" => "B/."
					),
					"PGK" => array(
							"text" => "Kina",
							"fraction" => 2,
							"symbol" => false
					),
					"PYG" => array(
							"text" => "Guarani",
							"fraction" => 0,
							"symbol" => "Gs"
					),
					"PEN" => array(
							"text" => "Nuevo Sol",
							"fraction" => 2,
							"symbol" => "S/."
					),
					"PHP" => array(
							"text" => "Philippine Peso",
							"fraction" => 2,
							"symbol" => "₱"
					),
					"PLN" => array(
							"text" => "Zloty",
							"fraction" => 2,
							"symbol" => "zł"
					),
					"QAR" => array(
							"text" => "Qatari Rial",
							"fraction" => 2,
							"symbol" => "﷼"
					),
					"RON" => array(
							"text" => "New Romanian Leu",
							"fraction" => 2,
							"symbol" => "lei"
					),
					"RUB" => array(
							"text" => "Russian Ruble",
							"fraction" => 2,
							"symbol" => "руб"
					),
					"RWF" => array(
							"text" => "Rwand Franc",
							"fraction" => 0,
							"symbol" => false
					),
					"SHP" => array(
							"text" => "Saint Helen Pound",
							"fraction" => 2,
							"symbol" => "£"
					),
					"WST" => array(
							"text" => "Tala",
							"fraction" => 2,
							"symbol" => false
					),
					"STD" => array(
							"text" => "Dobra",
							"fraction" => 2,
							"symbol" => false
					),
					"SAR" => array(
							"text" => "Saudi Riyal",
							"fraction" => 2,
							"symbol" => "﷼"
					),
					"RSD" => array(
							"text" => "Serbian Dinar",
							"fraction" => 2,
							"symbol" => "Дин."
					),
					"SCR" => array(
							"text" => "Seychelles Rupee",
							"fraction" => 2,
							"symbol" => "₨"
					),
					"SLL" => array(
							"text" => "Leone",
							"fraction" => 2,
							"symbol" => false
					),
					"SGD" => array(
							"text" => "Singapore Dollar",
							"fraction" => 2,
							"symbol" => "$"
					),
					"XSU" => array(
							"text" => "Sucre",
							"fraction" => 0,
							"symbol" => false
					),
					"SBD" => array(
							"text" => "Solomon Islands Dollar",
							"fraction" => 2,
							"symbol" => "$"
					),
					"SOS" => array(
							"text" => "Somali Shilling",
							"fraction" => 2,
							"symbol" => "S"
					),
					"SSP" => array(
							"text" => "South Sudanese Pound",
							"fraction" => 2,
							"symbol" => false
					),
					"LKR" => array(
							"text" => "Sri Lank Rupee",
							"fraction" => 2,
							"symbol" => "₨"
					),
					"SDG" => array(
							"text" => "Sudanese Pound",
							"fraction" => 2,
							"symbol" => false
					),
					"SRD" => array(
							"text" => "Surinam Dollar",
							"fraction" => 2,
							"symbol" => "$"
					),
					"SZL" => array(
							"text" => "Lilangeni",
							"fraction" => 2,
							"symbol" => false
					),
					"SEK" => array(
							"text" => "Swedish Krona",
							"fraction" => 2,
							"symbol" => "kr"
					),
					"CHE" => array(
							"text" => "WIR Euro",
							"fraction" => 2,
							"symbol" => false
					),
					"CHW" => array(
							"text" => "WIR Franc",
							"fraction" => 2,
							"symbol" => false
					),
					"SYP" => array(
							"text" => "Syrian Pound",
							"fraction" => 2,
							"symbol" => "£"
					),
					"TWD" => array(
							"text" => "New Taiwan Dollar",
							"fraction" => 2,
							"symbol" => "NT$"
					),
					"TJS" => array(
							"text" => "Somoni",
							"fraction" => 2,
							"symbol" => false
					),
					"TZS" => array(
							"text" => "Tanzanian Shilling",
							"fraction" => 2,
							"symbol" => false
					),
					"THB" => array(
							"text" => "Baht",
							"fraction" => 2,
							"symbol" => "฿"
					),
					"TOP" => array(
							"text" => "Pa’anga",
							"fraction" => 2,
							"symbol" => false
					),
					"TTD" => array(
							"text" => "Trinidad nd Tobago Dollar",
							"fraction" => 2,
							"symbol" => "TT$"
					),
					"TND" => array(
							"text" => "Tunisian Dinar",
							"fraction" => 3,
							"symbol" => false
					),
					"TRY" => array(
							"text" => "Turkish Lira",
							"fraction" => 2,
							"symbol" => ""
					),
					"TMT" => array(
							"text" => "Turkmenistan New Manat",
							"fraction" => 2,
							"symbol" => false
					),
					"UGX" => array(
							"text" => "Ugand Shilling",
							"fraction" => 0,
							"symbol" => false
					),
					"UAH" => array(
							"text" => "Hryvnia",
							"fraction" => 2,
							"symbol" => "₴"
					),
					"AED" => array(
							"text" => "UAE Dirham",
							"fraction" => 2,
							"symbol" => false
					),
					"USN" => array(
							"text" => "US Dollar (Next day)",
							"fraction" => 2,
							"symbol" => false
					),
					"UYI" => array(
							"text" => "Uruguay Peso en Unidades Indexadas (URUIURUI)",
							"fraction" => 0,
							"symbol" => false
					),
					"UYU" => array(
							"text" => "Peso Uruguayo",
							"fraction" => 2,
							"symbol" => "$U"
					),
					"UZS" => array(
							"text" => "Uzbekistan Sum",
							"fraction" => 2,
							"symbol" => "лв"
					),
					"VUV" => array(
							"text" => "Vatu",
							"fraction" => 0,
							"symbol" => false
					),
					"VEF" => array(
							"text" => "Bolivar",
							"fraction" => 2,
							"symbol" => "Bs"
					),
					"VND" => array(
							"text" => "Dong",
							"fraction" => 0,
							"symbol" => "₫"
					),
					"YER" => array(
							"text" => "Yemeni Rial",
							"fraction" => 2,
							"symbol" => "﷼"
					),
					"ZMW" => array(
							"text" => "Zambian Kwacha",
							"fraction" => 2,
							"symbol" => false
					),
					"ZWL" => array(
							"text" => "Zimbabwe Dollar",
							"fraction" => 2,
							"symbol" => false
					)
			);
		}
		
		
		return self::$currencies;
	}
}