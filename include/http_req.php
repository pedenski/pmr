<?php 
include "functions.php";

$endpoint = "https://10.167.63.35:17778/SolarWinds/InformationService/v3/Json/Query";

$post_data = array('query' => "SELECT a.Interface.DisplayName, a.InterfaceID, a.LastTime FROM Orion.Netflow.Source a");

$strdata = json_encode($post_data);
$ch = curl_init($endpoint);

curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_POSTFIELDS, $strdata);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERPWD, "admin:Inn0v@t10nSSA");
//curl_setopt($ch, CURLOPT_HEADER, 1); // This will output response headers
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'Content-Type: application/json',
'Content-Length: ' . strlen($strdata)
));

$result = curl_exec($ch);
$solarwindsdata = json_decode($result);

//checks if existing record for today already exists
$req = "flow";
$val = checkexisting($req);
$val = $val[0]['COUNT(group_id)'];
if($val > 0) {
//contains data for today - dont insert
echo "already existing netflow";
} else {
//no data yet - insert file
$res = insertdata($solarwindsdata);
echo "Data Inserted";
}

/* Existing Bug
 * if 1 date mismatch in a group exist, insertdata() wont execute. to solve, must check data entry and their dates that belongs in the same group_id using foreach
 */


?>
