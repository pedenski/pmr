<?php 
echo $a = date('Y-m-d');
die();

//get day 
$day = $_GET['day'];
//split number every 2nd char into array [12],[34],[45]
$chunks = str_split($day, 2);
//implode - for each array
$date = implode('-', $chunks);







?>