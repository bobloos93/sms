<?php
// We need to define what is the latest table to select data from.
$tableid=$_GET['tableid'];
$tabledate=$vkdb->query("SELECT monthyear FROM monthyeartableid WHERE tableid='$tableid'")->fetch_object()->monthyear;
// If there is a tableid in the url then this will be used, if not then the highest tableid will be pulled from the database
if (empty($_GET['tableid'])){
	$tableinformation=$vkdb->query("SELECT * FROM monthyeartableid WHERE tableid=(SELECT MAX(tableid) FROM monthyeartableid)")->fetch_object();
	$tabledate=$tableinformation->monthyear;
	$tableid=$tableinformation->tableid;


}
	
	$monthNum=substr($tabledate, -6, 2);
	$monthName=ucfirst(strftime ("%B", mktime(0, 0, 0, $monthNum, 10)));
	$yearNumb=substr($tabledate, -4, 4);

//For the use of the table navigator
$previoustableid=$tableid-1;
$nexttableid=$tableid+1;


//CHANGE MONTH-BAR
//Check if a previous table exists and if so create the link for it
?>


<div class="timebar">

<div class="timebarleft">

	<?php
	//Previoustable
	if ($vkdb->query("SELECT * FROM `$previoustableid`")){ 
		?>
		<a href=?tableid=<?php echo $previoustableid?>#tab1>Vorige tabel</a>
		<?php
	}
?>
</div>
<div class="timebarmiddle">
	<?php
	//This table

	echo ("$monthName $yearNumb"); 

?>
</div>
<div class="timebarright">
	<?php
	//Nexttable
	if ($vkdb->query("SELECT * FROM `$nexttableid`")){ 
		?>
		<a href=?tableid=<?php echo $nexttableid?>#tab1>Volgende tabel</a>
		<?php
	}
	?>
</div>
</div>
<div class="clear"></div>
<br>

<br>
<a href="newitem.php">Voer nieuw item in</a>
<table>
	<tr>
		<th>Naam</th>
		<th>Item-beschrijving</th>
		<th>Bedrag</th>
	</tr>
</th>


		<?php
		$itemdatafromdatabase = $vkdb->query("SELECT * FROM items WHERE monthyear='$tabledate'");
		while ($itemdata = $itemdatafromdatabase->fetch_object()){
			?>

			<tr>
				<td><?php $namefromuserdatabase = $userdb->query("SELECT realname FROM users WHERE userid='$itemdata->userid'");
				$name=$namefromuserdatabase->fetch_object(); 
				echo $name->realname; ?></td>
				<td><?php echo $itemdata->itemdescription;?></td>
				<td><?php echo $itemdata->amount;?></td>

			</tr>
			<?php
		}
		?>
	</table>

	<script type="text/javascript">
	$(document).ready(function () {
		window.scrollTo(0,0);
	});
	</script>
