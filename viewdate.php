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
<?php 
	//get day 
	$day = $_GET['date'];

	//convert string to date format 
	$day = strtotime($day);
	$date = date('Y-m-d',$day);
?>

	<?php
	//retrieve data
	$sql = getdatafromthis($date);
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
</html>


