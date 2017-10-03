<?php include 'inc/header.php'; ?>

<body>
  

  <div class="wrapper">


   <h2> PMR Netflow Statszzz </h2>
   

   <!-- LOCAL TIME -->
   <?php 
          date_default_timezone_set('Asia/Manila');
          $today = date('F j, Y', time());
        //  echo $today;
    ?>
   <!-- /LOCAL TIME -->


  <!-- DISPLAY NETFLOW -->
  <div class="mar-bot-5"></div>
    <table class="table">
    <tr>
      <a href="./lib/http_req.php"><button type="button" class="btn btn-outline-success">Generate</button></a>
     
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
      <td><span class="badge badge-pill badge-primary"><?php echo $entries; ?> Entries</span></td>
      <td>

        <!-- Block level -->
        <div class="row">
          <div class="col-5 text-truncate">
              <a href="viewdate.php?page=flow&date=<?php echo date('Ymd',strtotime($netflowtime));?>">
              <?php
              //check if last_time contains a date. 
              if(!empty($netflowtime)){
                 echo date('D F j, Y, g:i a', strtotime($netflowtime));?> </a>
              <?php } else { ?> 
              no data
              <?php } //end of netflowtime else ?> 
          </div>
        </div>

        <!-- Inline level -->
        <span class="d-inline-block text-truncate" style="max-width:450px;">
          <small>Praeterea iter est quasdam res quas ex communiPraeterea iter est quasdam res quas ex communi..</small>
        </span>
       
      </td> 
      <td>sdfsdf
        <?php 
         $e = comparetime($netflowtime, $servertime);?>
        <?php echo $e; ?>
      </td>
     
    </tr>
         <?php } //end of foreach ?>
    </table>

    <!-- DISPLAY NET DEVICES -->
    <h2>Network Devices List </h2>
    <a href="./include/ftp_req.php"><button type="button">Generate</button></a>
    <div class="mar-bot-5"></div>
      <table class="table">
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
  </div><!--/wrapper-->
</body>



<?php include 'inc/footer.php'; ?>