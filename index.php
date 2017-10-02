<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php include './include/functions.php'; ?>
        <style type="text/css">
        table.example1 {background-color:transparent;border-collapse:collapse;}
        table.example1 td {border:1px solid black;padding:5px;}
        .mar-bot-5 {
          margin-bottom:5px;
        }
        </style>
  </head>



  <body>
  <h2> PMR Netflow Statszzz </h2>

   <a href="./generate.php"><button type="button">Generate</button></a>

   <!-- LOCAL TIME -->
   <?php 
          date_default_timezone_set('Asia/Manila');
          $today = date('F j, Y', time());
          echo $today;
    ?>
   <!-- /LOCAL TIME -->


  <!-- DISPLAY NETFLOW -->
  <div class="mar-bot-5"></div>
    <table class="example1">
    <tr>
      <td>ID</td>
      <td>INTERFACE</td>
      <td>LAST TIME</td>
      <td>STATUS</td>
    </tr>

    <?php
      $displayflow = displaynetflow();
        foreach ($displayflow as $row) {
          $id           = $row['id'];
          $gid          = $row['group_id'];
          $interface    = $row['interface_name'];
          $netflowtime  = $row['last_time'];
          $servertime   = $row['server_time'];
    ?>
    <tr>
    <td> <?php echo $gid; ?> </td>
    <td> <?php echo $interface; ?> </td>
    <td>
          <?php
            //check if last_time contains a date. 
            if(!empty($netflowtime)){
               echo date('F j, Y, g:i a', strtotime($netflowtime));
            } else { ?> 
            no data
     </td> 
          <?php } //end of netflowtime else ?>
     <td>
          <?php
            //check if server time and netflow time (day-month-year) same
            $sync = comparetime($netflowtime, $servertime);  ?>
           <?php echo $sync; ?>
     </td>
     </tr>
           <?php } //end of foreach ?>
    </table>

    <!-- DISPLAY NET DEVICES -->
    <h2>Network Devices List </h2>
    <div class="mar-bot-5"></div>
      <table class="example1">
      <tr>
        <td>Number of Entries</td>
        <td>Date</td>
        <td>Path</td>
        <td>Date</td>
      </tr>


       <?php
       //get list of devices
       /*$getdeviceslist = getdeviceslist();
        foreach($getdeviceslist as $row) {
            $id        = $row['id'];
            $type      = $row['type'];
            $equipment = $row['equipment'];
            $desc      = $row['description'];
            $brand     = $row['brand'];*/

		$countfilesbydate = countfilesbydate();
		//print_r($countfilesbydate);
			foreach($countfilesbydate as $row)    {
				$countid = $row['COUNT(id)'];
				$date = $row['time_upload'];

	     ?>
        <tr> 
        <td><?php echo $countid;?></td>
        <td><a href="viewdate.php?day=<?php echo date('mdy',strtotime($date));?>"><?php echo date('m-d-y',strtotime($date));?></a></td>
        <td>Path</td>
        <td>Date</td>
        <?php } //end of foreach?>
      </tr>



      </table>





  </body>
</html>