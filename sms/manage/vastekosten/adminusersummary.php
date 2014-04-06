<?php
include (ROOT ."manage/admincheck.php");
include_once(ROOT ."vastekosten/createvktable.php");
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

//Check if a previous table exists and if so create the link for it
if ($vkdb->query("SELECT * FROM `$previoustableid`")){ 
?>
<a href=?tableid=<?php echo $previoustableid?>#tab3>Vorige tabel</a>
<?php
}

if ($vkdb->query("SELECT * FROM `$nexttableid`")){ 
?>
<a href=?tableid=<?php echo $nexttableid?>#tab3>Volgende tabel</a>
<?php
}
?>

<p>Je kijkt nu naar de tabel met naam: <?echo $tabledate ?></p>

<table>
<tr>
<td>Naam</td>
<td>Beginsaldo deze maand</td>
<td>Ingekocht deze maand</td>
<td>Eindsaldo </td>
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

<?php
include (ROOT ."include/footer.php");
?>