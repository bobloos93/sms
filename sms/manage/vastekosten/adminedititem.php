<?php
include_once($_SERVER['DOCUMENT_ROOT'] ."/sms/config.php");
include (ROOT ."include/header.php");


if ($_SERVER['REQUEST_URI']=="/sms/manage/vastekosten/adminedititem.php"){
	?>
	<script>location.href='#tab1'</script>

	<?php
}




$changeitemid=$_GET['id'];
//GET USERS INFORMATION FROM THE DATABASE
//GET CURRENT INFORMATION OF THE TO BE EDIT USER
$rowfromdatabase = $vkdb->query("SELECT * FROM items WHERE itemid=".$changeitemid."");
$itemdata=$rowfromdatabase->fetch_object();
//Get the list of affected users for the certain item we want to edit or remove
$listofaffectedusers=$vkdb->query("SELECT affectedusers FROM items WHERE itemid='$changeitemid'")->fetch_object()->affectedusers;
$affectedusers = json_decode($listofaffectedusers);
//The number of users that are affected and are still roommates
$numberofcurrentusers=0;

?>
<div id="wrapper">
	<article class="tabs">

		<section id="tab1">
			<h2><a href="#tab1">Wijzig item</a></h2>
			<div id="content">
				<?php include (ROOT ."manage/admincheck.php"); ?>
				<form action="./adminprocessedititem.php" method="post"> 
					<table>
						<tr>
							<th>Item-id</th>
							<th>Naam</th>
							<th>Itembeschrijving</th>
							<th></th>
						</tr>
						<tr>
							<td><input type="text" name="itemid" value="<?php echo $itemdata->itemid;?>" readonly="readonly"/></td>
							<td><input type="text" name="userid" value="<?php echo $itemdata->userid;?>" readonly="readonly"/></td>
							<td><input type="text" name="itemdescription" value="<?php echo $itemdata->itemdescription;?>" /></td>
							<td></td>


							<tr>
								<th>Bedrag</th>
								<th>Datum</th>
								<th>Timestamp</th>
								<th>Verwijder dit item?</th>
							</tr>
							<tr>

								<td><input type="text" name="amount" value="<?php echo $itemdata->amount;?>" /></td>
								<td><input type="text" name="monthyear" value="<?php echo $itemdata->monthyear;?>" readonly="readonly" /></td>
								<td><?php echo $itemdata->timestamp;?></td>
								<td><input type="radio" name="remove" value=0 checked>Nee<br>
									<input type="radio" name="remove" value=1 >Ja<br>
								</td>
							</tr>
					
						</table>
						<td><align="center"><input value="Opslaan" type="submit" /></td>
						<td><a href="index.php#tab1">Terug naar het overzicht</a></td>
					</form>

				</section>
			</article>
		</div>