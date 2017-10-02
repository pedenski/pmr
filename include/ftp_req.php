<?php
/* Check database pmr_device to know what equipment must have rconfig file (Pudge/Tiny/Switches/Etc)
 * Get date today 
 * Check if file existing in 192.168.2.12 rconfig directory
 *   if yes, then copy file from 192.168.2.12(rconfig) && update db for status 
 *   else, dont copy && update db for status null
 */

include 'functions.php';

$cwd = dirname(__FILE__);// . "/updater/";
set_include_path(get_include_path() . PATH_SEPARATOR . $cwd . '/phpseclib/');

require_once('Net/SSH2.php');
require_once('Net/SCP.php');
require_once('Net/SFTP.php');

$sftp = new Net_SFTP('192.168.2.12');
if (!$sftp->login('root', 'Inn0v@t10n')) {
    throw new Exception("Failed to login");
}


//get current day
$currentyear = date('Y');
$currentmonth = date('M');
$currentday = date('d');
$time = time(); //get timestamp

// check if this year is currentyear
if (!empty(compareyear($time))) {
	if(!file_exists('/var/www/html/zild/pmr/rconfig'.'/'.$currentyear)) {
		mkdir('/var/www/html/zild/pmr/rconfig/'.$currentyear.'/', 0777, true);
		echo "folder created ".$currentyear.PHP_EOL;
		//log year of folder creation
	} else {
		echo $currentyear." folder already exists".PHP_EOL;

	}
} 

//checks if existing record for today already exists
$val = checkexisting();
$val = $val[0]['COUNT(id)'];
if($val > 0) {
	//contains data for today - dont insert
	$insertrecord = 1;
} else {
	//no data yet - insert file
	$insertrecord = 0;
}

//access db for devices to check device type and name
$getdeviceslist = getdeviceslist();
	foreach($getdeviceslist as $row) {
		$id        = $row['id'];
        $type      = $row['type'];
        $equipment = $row['equipment'];
        $desc      = $row['description'];
        $brand     = $row['brand'];
      
         /* 
		 * File Exist in directory?
		 * Search for 'showrunning-config' string in an array for each devices in DB(pmr_devices)

		 * Link: https://stackoverflow.com/questions/12315536/search-for-php-array-element-containing-string
		 
		 * @param $sftp->nlist  = displays directory listing using phpseclib
		 * @param rconfig directory format = /home/rconfig/data/TYPE/EQUIPMENT/YEAR/MONTH/DAY/FILENAME
		 * @param destination file = /var/www/html/zild/pmr/rconfig/FILE

	   	*/
     
        if(!empty($directoryarray = $sftp->nlist('/home/rconfig/data/'.$type.'/'.$equipment.'/'.$currentyear.'/'.$currentmonth.'/'.$currentday))) {  
     
       		     //find array element if containing string of showrunning-config
			     $searchword = 'showrunning-config';
			 	 $found=0;
				 	 
				foreach($directoryarray as $file) {
			     	if(preg_match("/\b$searchword\b/i", $file)) {
			     		$found=1; //if match then echo
			     		//echo $equipment.'----'.$file.PHP_EOL;

			     		//get file from 192.168.2.12
			     		$sftp->get('/home/rconfig/data/'.$type.'/'.$equipment.'/'.$currentyear.'/'.$currentmonth.'/'.$currentday.'/'.$file,'/var/www/html/zild/pmr/rconfig/'.$currentyear.'/'.$currentyear.'_'.$currentmonth.'_'.$currentday.'_'.$equipment.'.txt');

						//set path
			     		$path = '/var/www/html/zild/pmr/rconfig/'.$currentyear.'/'.$currentyear.'_'.$currentmonth.'_'.$currentday.'_'.$equipment.'.txt';
						//add 'key => link and value=> path' to existing array $row['$key'] = $val
		     			$row['link'] = $path;
			     		
			     		//checks if existing record for today already exists	
			     		if($insertrecord == 0) {
			     			//if record is empty then insert to db
				     		$e = insertrconfig($row);
			     			echo $equipment.'-'.$e.''.PHP_EOL;
			     		} else {
			     			echo $equipment.' already existing in db'.PHP_EOL;
			     		}
				    } //endif(preg_match)
 			 	}//end foreach
			 		
			 	if(empty($found)) {
			    	echo $equipment.' empty file, check rconfig connection and directory /home/rconfig/data/ @ 192.168.2.12'.PHP_EOL;
			    }
		} //end (!empty directory)
} //end foreach getdevicelist



/*
10-2-17
	- date mismatch, i was printing numeric value of '2' instead of '02'
	@param date('z'); to date('d');
	- changed syntax of SQL from DAY(time_upload) to DATE(time_upload)
*/
?>

