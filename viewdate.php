<?php 
include 'include/functions.php';

//get day 
$day = $_GET['day'];

//convert string to date format 
$day = strtotime($day);
$day = date('Y-m-d',$day);

/*split number every 2nd char into array [12],[34],[45]
$chunks = str_split($day, 2);
//implode - for each array
$date = implode('-', $chunks);
echo $date;*/


$sql = getdatafromthis($day);
print_r($sql);



?>