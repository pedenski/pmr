<?php
include 'functions.php';

$cwd = dirname(__FILE__);// . "/updater/";
set_include_path(get_include_path() . PATH_SEPARATOR . $cwd . '/phpseclib/');


require_once('Net/SSH2.php');
require_once('Net/SCP.php');
require_once('Net/SFTP.php');

$sftp = new Net_SFTP('192.168.2.12');
if (!$sftp->login('root', 'Inn0v@t10n'))
{
    throw new Exception("Failed to login");
}


//print_r($sftp->lstat('/home/rconfig/data/Routers/Pudge/2017/Sep/12/showstartup-config-006.txt'));




//access db for devices to check device type and name

$getdeviceslist = getdeviceslist();
	foreach($getdeviceslist as $row) {
		$id        = $row['id'];
        $type      = $row['type'];
        $equipment = $row['equipment'];
        $desc      = $row['description'];
        $brand     = $row['brand'];
      

	    //get current day
	    $currentyear = date('Y');
	    $currentmonth = date('M');
	    $currentday = date('j');

         /* 
		 * File Exist in directory?
		 * Search for 'showrunning-config' string in an array for each devices in DB(pmr_devices)

		 * Link: https://stackoverflow.com/questions/12315536/search-for-php-array-element-containing-string
		 
		 * @param $sftp->nlist  = displays directory listing using phpseclib
		 * @param rconfig directory format = /home/rconfig/data/TYPE/EQUIPMENT/YEAR/MONTH/DAY/FILENAME

	   	*/
         //echo '['.$equipment.']';
		   if(!empty($directoryarray = $sftp->nlist('/home/rconfig/data/'.$type.'/'.$equipment.'/'.$currentyear.'/'.$currentmonth.'/'.$currentday))) { ; 

			     //find array element containing string
			     $searchword = 'showrunning';
			 	
			 	 //create new array to put the result
			     $matches = array();

			     	foreach($directoryarray as $k=>$v) {
			     		if(preg_match("/\b$searchword\b/i", $v)) {
			     			echo $matches[$k] = $v. PHP_EOL;
			     		} else {
			     			
			     		}
			     	}

			    } else {

			       //echo '['.$equipment.'] is empty';

			    }
	}

     
  // $test = "zildjian-murai-.txt";
  //      if(preg_match("/^zildjian/", $test)) {
  //      	echo "match";
  //      } else "no match";


    //print_r($sftp->lstat('/home/rconfig/data/Routers/Pudge/2017/Sep/12/showstartup-config-006.txt'));


    //check year date and day
    $gettoday = gettoday();
   // echo date('M', strtotime($gettoday));


//look inside directory if config exists



//check if file exists first
if (empty($sftp->lstat('/home/rconfig/data/Routers/Pudge/2017/Sep/12/showstartup-config-1006.txt'))) {
	//echo "0";
} else {
	//echo "1";
}











/*$sftp->get('/home/rconfig/data/Routers/Pudge/2017/Sep/12/showstartup-config-006.txt','/var/www/html/zild/pmr/rconfig/test3.txt');

	echo 'success!!!!!!!'; 
*/

//print_r($sftp->nlist()); // == $sftp->nlist('.')	
?>