<?php include 'inc/header.php'; ?>

<body>
  <h2> PMR Netflow Statszzz </h2>

   <a href="./include/http_req.php"><button type="button">Generate</button></a>

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
      <td>DATE</td>
      <td>ENTRIES</td>
    </tr>

    <?php
      $displayflow = displaynetflow();
        foreach ($displayflow as $row) {
          $id           = $row['id'];
          $gid          = $row['group_id'];
          $interface    = $row['interface_name'];
          $netflowtime  = $row['last_time'];
          $servertime   = $row['server_time'];
          $entries      = $row['COUNT(group_id)'];   
    ?>
    <tr>
      <td> <?php echo $gid; ?> </td>
      <td>
        <a href="viewdate.php?page=flow&date=<?php echo date('Ymd',strtotime($netflowtime));?>">
            <?php
              //check if last_time contains a date. 
              if(!empty($netflowtime)){
                 echo date('D F j, Y, g:i a', strtotime($netflowtime));
              } else { ?> 
              no data
        </a>
       </td> 
            <?php } //end of netflowtime else ?>
      
       <td><?php echo $entries; ?></td>
     </tr>
           <?php } //end of foreach ?>
    </table>

    <!-- DISPLAY NET DEVICES -->
    <h2>Network Devices List </h2>
    <a href="./include/ftp_req.php"><button type="button">Generate</button></a>
    <div class="mar-bot-5"></div>
      <table class="example1">
      <tr>
        <td>Entries</td>
        <td>Date</td>
      </tr>


     <?php
     $countfilesbydate = countfilesbydate();
		//print_r($countfilesbydate);
			foreach($countfilesbydate as $row) {
				$countid = $row['COUNT(id)'];
				$date = $row['time_upload'];

	     ?>
        <tr> 
        <td><?php echo $countid;?></td>
        <td><a href="viewdate.php?page=stat&date=<?php echo date('Ymd',strtotime($date));?>"><?php echo date('D-M-j-Y',strtotime($date));?></a></td>
        <?php } //end of foreach?>
      </tr>



      </table>
  </body>



<?php include 'inc/footer.php'; ?>