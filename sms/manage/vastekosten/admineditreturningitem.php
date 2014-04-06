<?php
include_once($_SERVER['DOCUMENT_ROOT'] ."/sms/config.php");
include (ROOT ."include/header.php");


if ($_SERVER['REQUEST_URI']=="/sms/manage/vastekosten/admineditreturningitem.php"){
  ?>
<script>location.href='#tab1'</script>

<?php
}




$changeitemid=$_GET['id'];
//GET USERS INFORMATION FROM THE DATABASE
//GET CURRENT INFORMATION OF THE TO BE EDIT USER
$rowfromdatabase = $vkdb->query("SELECT * FROM returningitems WHERE returningitemid=".$changeitemid."");
$itemdata=$rowfromdatabase->fetch_object();
?>
<div id="wrapper">
<article class="tabs">

  <section id="tab1">
    <h2><a href="#tab1">Wijzig terugkerende item</a></h2>
    <div id="content">
    	<?php include (ROOT ."manage/admincheck.php"); ?>
<form action="./adminprocessedititem.php" method="post"> 
<table>
<tr>
<td>Terugkerende item-id</td>
<td>Naam</td>
<td>Itembeschrijving</td>
</tr>
<tr>
	<td><input type="text" name="itemid" value="<?php echo $itemdata->returningitemid;?>" readonly="readonly"/></td>
<td><input type="text" name="userid" value="<?php echo $itemdata->userid;?>" readonly="readonly"/></td>
<td><input type="text" name="itemdescription" value="<?php echo $itemdata->itemdescription;?>" /></td>

</tr>
<tr>
<td>Bedrag</td>
<td>Ingevoerd vanaf</td>
<td>Voor het laatst ingevoerd</td>
</tr>
<tr>
<td><input type="text" name="amount" value="<?php echo $itemdata->amount;?>" /></td>
<td><input type="text" name="from" value="<?php echo $itemdata->usedfrom;?>" /></td>
<td><input type="text" name="from" value="<?php echo $itemdata->lastdate;?>" readonly="readonly"/></td>

</tr>
<tr>
<td>Aantal keer</td>
<td>Aantal keer over</td>
<td>Verwijder dit item?</td>
</tr>
<tr>


<td><input type="text" name="occurrences" value="<?php echo $itemdata->occurrences;?>" /></td>
<td><input type="text" name="occurrencesleft" value="<?php echo $itemdata->occurrencesleft;?>" /></td>
<td><input type="radio" name="remove" value=0 checked>Nee<br>
<input type="radio" name="remove" value=1 >Ja<br>
</td>
</tr>
</table>
<align="center"><input value="Opslaan" type="submit" />
</form>

 </section>
</article>
</div>