<?php include 'inc/header.php'; ?>
<body>
 <div class="mar-bot-5"></div>
    <table class="example1">
    <tr>
      <td>ID</td>
      <td>INT ID</td>
      <td>INTERFACES</td>
      <td>NETFLOW TIME</td>
      <td>SERVER TIME</td>
      <td>SYNC </td>
    </tr>

<?php 
	if(($_GET['page']) == "flow") {
		$date = $_GET['date'];
		$page = $_GET['page'];
		$sql = getdatafromthis($page,$date);

		if(!empty($sql)) {
			foreach($sql as $row) {
				$id 			= $row['id'];
				$gid 			= $row['group_id'];
				$intid 			= $row['interface_id'];
				$intname 		= $row['interface_name'];
				$netflowtime 	= $row['last_time'];	
				$servertime 	= $row['server_time'];
		?>	
		<tr>
			<td><?php echo $id; ?></td>
			<td><?php echo $intid; ?></td>
			<td><?php echo $intname; ?></td>
			<td>
				<?php
					if(empty($netflowtime)){
						echo "No Data";

					} else {
						echo date('Y-m-d',strtotime($netflowtime));
					}
				?>
			</td>
			<td><?php echo $servertime;?>
			</td>
			<td>
				<?php 
				/* KNOWN BUG
				 * page=flow&date<any>
				 * -------------------------------
				 * when date is mismatched, record in table disappears
				 * -------------------------------
				 * SOLUTION THEORY
				 * SQL must be changed to get all similar dates, and then get the group_id
				 * of the result, from there, print values.
				 */
				$e = comparetime($netflowtime, $servertime);
				echo $e;
				?>
			</td>
		</tr>
		<?php	} //endforeach ?>
	</table>

	<?php } //end of $_GET['page'] ?>
	<?php } elseif(($_GET['page']) == "stat") {
		//get day 
		$page = $_GET['page'];
		//echo $_GET['date'];
		//get day 
		$day = $_GET['date'];

		//convert string to date format 
		$day = strtotime($day);
		$date = date('Y-m-d',$day);



		//retrieve data
		$sql = getdatafromthis($page,$date);
		if(!empty($sql)) { 
?>
		<table class="example1">
			<tr>
			  <td>ID</td>
			  <td>TYPE</td>
			  <td>DESCRIPTION</td>
			  <td>BRAND</td>
			  <td>LINK</td>
			  <td>DATE UPLOADED</td>
			</tr>
		<?php
			foreach($sql as $row){
			$id 		= $row['id'];
			$type 		= $row['type'];
			$name 		= $row['equipment'];
			$desc 		= $row['description'];
			$brand 		= $row['brand'];
			$link 		= $row['link'];
			$upload 	= $row['time_upload'];

		?>
			<tr>
			<td><?php echo $id; ?></td>	
			<td><?php echo $type; ?></td>
			<td><?php echo $desc; ?></td>
			<td><?php echo $brand; ?></td>
			<td><a href="<?php echo $link; ?>">
				<?php echo $name; ?>.config
				</a>
				</td>
			<td><?php echo $upload; ?></td>
			</tr>
			<?php } //foreach ?>
			<?php } else {
			echo "NO DATA - Contact zdmurai";
			} ?>	
		</table>	
 </body>	
<?php	} //end of elseif ?>