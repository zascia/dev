<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
ini_set("log_errors", 1);
ini_set("error_log", __DIR__ . '/logs/error.log');
include_once __DIR__ . '/settings.php';
/**
 * PHP/cURL function to check a web site status. If HTTP status is not 200 or 302, or
 * the requests takes longer than 10 seconds, the website is unreachable.
 *
 * Follow me on Twitter: @HertogJanR
 * Send your donation through https://www.paypal.me/jreilink. Thanks!
 *
 * @param string $url URL that must be checked
 */

function url_test( $url ) {
  $errorMsg = '';
  $timeout = 10;
  $ch = curl_init($url);
  //curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
  // Set request options
    curl_setopt_array($ch, array(
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_NOBODY => true,
      CURLOPT_TIMEOUT => $timeout,
      CURLOPT_FAILONERROR => true,
      CURLOPT_USERAGENT => "page-check/1.0"
    ));

  $http_respond = curl_exec($ch);

  if (curl_errno($ch)) {
      error_log($errorMsg);
      curl_close($ch);
      return false;
  }

  $http_code = curl_getinfo( $ch, CURLINFO_RESPONSE_CODE  );
  curl_close( $ch );

  if ( ( $http_code == "200" ) || ( $http_code == "302" ) ) {
    // domain is ok
    return true;
  } else {
    // domain failed
    return false;
  }

}

// here we fix the failed root with another domain
function fixFailedRoot($failedDomain, $newDomain, $apikey) {
    // get all landings

    $landingsUrl = 'https://odintrk.com/index.php?action=landing_getall&api_key=10000017bf0628f872d0ab4b7204e9ebc341794';
    /*$landingsUrl = 'https://odintrk.com/index.php?action=landing_get&id=76&api_key=10000017bf0628f872d0ab4b7204e9ebc341794';*/
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $landingsUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $landingsListJSON = curl_exec($ch);
    curl_close($ch);

    $landingsList = json_decode($landingsListJSON);

    // FOREACH ITEM FROM COLLECTION DO THE FOLLOWING
    // change domain here
    foreach ($landingsList as $landingsListItem) {
        $landingsListItem->url = str_replace($failedDomain, $newDomain, $landingsListItem->url);

        // send request to change doamin in tracking
        $postRequest = array(
            'api_key' => $apikey,
            'action' => 'landing_edit',
            'id' => $landingsListItem->id,
            'url' => $landingsListItem->url
        );

        $ch = curl_init('https://odintrk.com/index.php');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postRequest);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $apiResponse = curl_exec($ch);
        curl_close($ch);

        // $apiResponse - available data from the API request
        //echo 'apiresponse after change ' . $apiResponse;
        $jsonArrayResponse = json_decode($apiResponse);
    }

    // EO FOREACH ITEM FROM COLLECTION DO THE FOLLOWING
    return true;
}
function notifyAboutFail($failedDomain, $newDomain, $fixStatus) {
    require __DIR__ . '/classes/PushBullet.class.php';
    try {

      #### AUTHENTICATION ####
      // Get your API key here: https://www.pushbullet.com/account
      $p = new PushBullet('o.n7pwmbtS1vxiemJtzJNUxFeTlF5CgnQK');

      #### Push methods
      // Push to email me@example.com a note with a title 'Hey!' and a body 'It works!'
      //$p->pushNote('ch@leadcapdigital.com', 'Hey! It is domain replace alert.', 'Old domain ' . $failedDomain . ' to the new domain ' . $newDomain . ' with status ' . $fixStatus);

      #### Pushing to multiple devices

      // Push to all of your own devices, if you set the first argument to NULL or an empty string
      $p->pushNote(NULL, 'Hey! It is domain replace alert.', 'Old domain ' . $failedDomain . ' to the new domain ' . $newDomain . ' with status ' . $fixStatus);
      //$p->pushNote('', 'Some title', 'Some text');

    } catch (PushBulletException $e) {
      // Exception handling
      die($e->getMessage());
    }

}

// file with source of live domains, extracts the content of file into the array of rows
$actualDomainList = file($live_domain_list_filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

//temporary array of failed domains
$tmpDomainsArray = array();

// check for domain availability
foreach ($actualDomainList as $domainKey => $domain) {
    $domain = trim($domain);

    // domain is down
    $serverPingResult = url_test($domain);
    if( !$serverPingResult ) {
        $tmpDomainsArray[$domain] = '';
      // remove it from the live domain list
      unset($actualDomainList[$domainKey]);
    }
    else {  }
}

// do something with landing pages api
if (count($tmpDomainsArray) > 0) {
    $archivedDomainList = array();
    $reserveDomainList = file($reserve_domain_list_filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($tmpDomainsArray as $failedDomain => $newDomain) {
        $newDomain = array_shift($reserveDomainList);
        $fixStatus = fixFailedRoot($failedDomain, $newDomain, $apikey);
        notifyAboutFail($failedDomain, $newDomain, $fixStatus);
        $tmpDomainsArray[$failedDomain] = $newDomain;
        $actualDomainList[] = $newDomain;
        $archivedDomainList[] = $failedDomain;
    }
    // update the list of reserve servers
    $f=fopen($reserve_domain_list_filename,"w");
    foreach($reserveDomainList as $domain)
    {
        fwrite($f,$domain."\r\n");
    }
    fclose($f);

    // update the list of archived servers
    $f=fopen($archived_domain_list_filename,"a");
    foreach($archivedDomainList as $domain)
    {
        fwrite($f,$domain."\r\n");
    }
    fclose($f);
}

// update the list of live servers
$f=fopen($live_domain_list_filename,"w");
foreach($actualDomainList as $domain)
{
    fwrite($f,$domain."\r\n");
}
fclose($f);


?>