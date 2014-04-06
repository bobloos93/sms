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
		<a href=?tableid=<?php echo $previoustableid?>#tab2>Vorige tabel</a>
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
		<a href=?tableid=<?php echo $nexttableid?>#tab2>Volgende tabel</a>
		<?php
	}
	?>
</div>
</div>
<div class="clear"></div>
<br>

<br>

<table>
<tr>
<th>Naam</th>
<th>Beginsaldo deze maand</th>
<th>Ingekocht deze maand</th>
<th>Eindsaldo </th>
</tr>

<?php
$userdatafromdatabase = $vkdb->query("SELECT * FROM `$tableid`");
while ($userdata = $userdatafromdatabase->fetch_object()){
?>

<tr>
<td><?php $namefromuserdatabase = $userdb->query("SELECT realname FROM users WHERE userid='$userdata->userid'");
		  $name=$namefromuserdatabase->fetch_object(); 
		  echo $name->realname; ?></td>
<td><?php echo $userdata->saldostart;?></td>
<td><?php echo $userdata->bought;?></td>
<td><?php echo $userdata->saldoend;?></td>

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