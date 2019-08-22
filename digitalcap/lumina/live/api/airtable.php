<?php
// Allow from any origin
if (isset($_SERVER['HTTP_ORIGIN'])) {
    // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
    // you want to allow, and if so:
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        // may also be using PUT, PATCH, HEAD etc
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
}

// Only allow ajax requests
/*if( !isset($_SERVER["HTTP_REFERER"]) || !isset($_SERVER["HTTP_X_REQUESTED_WITH"]) || strtolower($_SERVER["HTTP_X_REQUESTED_WITH"]) != "xmlhttprequest" ) {

    exit("N - not allowed");

}*/

$data = array();

$dataJSON = isset($_POST) ? file_get_contents('php://input') : '';

$header = array();
$header[] = 'Content-type: application/json';
$header[] = 'Authorization: Bearer keynY5Sln7qNEY8qb';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.airtable.com/v0/appQxwG3ySJmuCtXQ/EstonianLeads');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $dataJSON);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
$out = curl_exec($ch);

curl_close($ch);

$response = $out;

$decoded_response = json_decode($response);

echo $out;
?>