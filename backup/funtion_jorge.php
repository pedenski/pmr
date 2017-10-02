<?php
//connect to db
function dbcon() {
	$us = 'root';
	$pw = 'a1b2c3d4';
	$db = new PDO('mysql:host=localhost;dbname=zild_db', $us, $pw);
	return $db;
}

//insert db
function insertdata($data) {
	$db = dbcon();
	$count=0;

	$count_group_id = "SELECT MAX(group_id) from pmr";
	$sql = $db->prepare($count_group_id);
	$row = $sql->execute(); //returns if 1 if data exists
	$row = $sql->fetchALL(PDO::FETCH_ASSOC); //returns row from result set
	
	/*
	@print_r($row) returns below

	Array
	(
	    [0] => Array
	        (
	            [MAX(group_id)] => 10 //number of existing value
	        )

	)*/

	$count = ($row[0]['MAX(group_id)']) + 1;
	
	

/*
	$query="SELECT group_id from pmr ORDER BY ID DESC LIMIT 0,1";
	$sql = $db->prepare($query);
	$sql->execute();
	$row = $sql->fetchALL();
	//zprint_r($row);
	//$count=($row[0])+1;

	if (isset($row))
	{
		$count=$row[0]["group_id"]+1;
	}

*/



	$query = "INSERT INTO pmr (id, group_id, interface_id, interface_name, last_time) VALUES (:id, :group_id, :interface_id, :interface_name, :last_time)";
	$q = $db->prepare($query);


	foreach($data->results as $test => $results) {
		$q->execute(array(':id'				=> '',
						  ':group_id'		=> $count,
						  ':interface_id' 	=> $results->InterfaceID,
						  ':interface_name'	=> $results->DisplayName,
						  ':last_time'		=> $results->LastTime));

		
	}

	echo $count;
}



function test($data) {
		
	foreach($data->results as $id => $results) {
		echo $results->DisplayName;
		
	}



}

?>