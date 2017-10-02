<?php


//used in functions.php
function dbcon() {

	try {
		$us = 'root';
		$pw = 'a1b2c3d4';
		$db = new PDO('mysql:host=localhost;dbname=zild_db', $us, $pw);	
	    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	    return $db;
	} catch (PDOException $e) {
	    echo 'Connection failed: ' . $e->getMessage();
	}
}

//insert db (http_req.php)
function insertdata($solarwindsdata) {

	//@data = array from curl

	$db = dbcon();

	$count=0;
	$count_group_id = "SELECT MAX(group_id) from pmr"; //get last digit entry of group_id 
	$sql = $db->prepare($count_group_id); //prepare statement
	$row = $sql->execute(); //returns if 1 if data exists
	$row = $sql->fetchALL(PDO::FETCH_ASSOC); //returns row with from result set

	/*
	@print_r($row) returns below
	
	!!if new entry, use 0
	!!if not 0, add + 1 by getting last digit from group_id and add + 1

	Array
	(
	    [0] => Array
	        (
	            [MAX(group_id)] => 10 //number of existing value
	        )

	)*/

	$count = ($row[0]['MAX(group_id)']) + 1; 

	$query = "INSERT INTO pmr (id, group_id, interface_id, interface_name, last_time) VALUES (:id, :group_id, :interface_id, :interface_name, :last_time)";
	$q = $db->prepare($query);

		//@data contains array from solarwinds
		foreach($solarwindsdata->results as $test => $results) {

			//check if LastTime from Solarwinds contains a date before insert
			if(empty($results->LastTime)) {
				$results->LastTime = "";
			}

			$q->execute(array(':id'				=> '',
							  ':group_id'		=> $count,
							  ':interface_id' 	=> $results->InterfaceID,
							  ':interface_name'	=> $results->DisplayName,
							  ':last_time'		=> $results->LastTime));
		}
}

//display netflow (index.php)
function displaynetflow() {
	try {
		$db = dbcon();
		$query = "SELECT * FROM pmr";
		$sql = $db->prepare($query);
		$sql->execute();
		$sql = $sql->fetchALL(PDO::FETCH_ASSOC);
		return $sql;

	} catch (PDOException $e) {
	    echo 'Connection failed: ' . $e->getMessage();
	}
}

//this is to check if server time stamp (the date the record was inserted, was the same in solwarwinds netflow time (m-d-y) (index.php)
function comparetime($netflowtime, $servertime) {
	$netflowtime = new DateTime($netflowtime);
	$servertime = new DateTime($servertime);

	$servertime = $servertime->format('m-d-Y');
	$netflowtime = $netflowtime->format('m-d-Y');
	
	if($servertime == $netflowtime) {
		return "synced";
	}	else {
		return "not synced";
	}
}


//this is to check if server time stamp and current year is same, this is to know if folder where file is stored is correct (ftp_req.php)
function compareyear($time) {
	if(date('Y') == date('Y',$time)){
		return 1;
	} else {
		return 0;
	}
}


//retrieve devices list (index.php |ftp_req.php)
function getdeviceslist(){
	try {
		$db = dbcon();
		$query = "SELECT * FROM pmr_devices";
		$sql = $db->prepare($query);
		$sql->execute();
		$sql = $sql->fetchALL(PDO::FETCH_ASSOC);
		return $sql;


	} catch(PDOException $e ) {
		echo 'Connection Failed:'.$e->getMessage();
	}
}



//insert rconfig info update to db(ftp.req.php)
function insertrconfig($row) {
	try {
		$db = dbcon();

		$query = "INSERT INTO pmr_device_status (id, type, equipment, description, brand, link, time_upload)
				  VALUES  (:id, :type, :equipment, :description, :brand, :link, NOW())";
				
		$sql = $db->prepare($query);
		$sql = $sql->execute(array(':id' 			=>'',
								   ':type'			=>$row['type'],
								   ':equipment' 	=>$row['equipment'],
								   ':description' 	=>$row['description'],
								   ':brand'			=>$row['brand'],
								   ':link'			=>$row['link'],
								  ));
		echo "successfully added";
		

	} catch(PDOException $e ) {
		echo 'Connection Failed:'.$e->getMessage();
	} 

}


//get rconfig info from db(ftp_req.php)
function checkexisting(){
	try {
		$db = dbcon();
		$date = date('Y-m-d'); //today

		$query = "SELECT COUNT(id) from pmr_device_status WHERE DATE(time_upload) = '{$date}' ";
			
		$sql = $db->prepare($query);
		$sql->execute();
		$sql = $sql->fetchALL(PDO::FETCH_ASSOC);
		return $sql; 

	} catch(PDOException $e ) {
		echo 'Connection Failed:'.$e->getMessage();
	}
}

//get all rconfig files and group by date
function countfilesbydate(){
	try {
		$db = dbcon();
		$query = "SELECT COUNT(id), time_upload from pmr_device_status WHERE DAY(time_upload) GROUP BY time_upload LIMIT 0, 30"; 

		$sql = $db->prepare($query);
		$sql->execute();
		$sql = $sql->fetchALL(PDO::FETCH_ASSOC);
		return $sql;

	} catch(PDOException $e){
		echo 'Connection Failed:'.$e->getMessage();
	}

}

/* function gettoday() {
	$today = date("Y-m-d");
	return $today;
	//$today = date('F j, Y',strtotime($today)); //convert to readable format
	//return $today;
}
*/




function test($data) {
	foreach($data->results as $id => $results) {
		echo $results->DisplayName;
	}
}

function haha() {
	echo "TESSST";
}
?>

