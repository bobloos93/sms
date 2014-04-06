<?php
include_once($_SERVER['DOCUMENT_ROOT'] ."/sms/config.php");
include (ROOT ."include/header.php");
?>

<div id="wrapper">
<article class="tabs">
	<section id="tab1">
    <h2><a href="#tab1">Wijzig gebruiker</a></h2>
    <div id="content">
<?php include (ROOT ."manage/admincheck.php"); 

$changeuserid=$_GET['id'];
//GET USERS INFORMATION FROM THE DATABASE
//GET CURRENT INFORMATION OF THE TO BE EDIT USER
$rowfromdatabase = $userdb->query("SELECT * FROM users WHERE userid=".$changeuserid."");
$userdata=$rowfromdatabase->fetch_object();
?>

<form action="./processedituserstatus.php" method="post"> 
<input type=hidden name="userid" value="<?php echo $userdata->userid;?>">
<table>
<tr>
<td>Je staat op het punt om de status van <?php echo $userdata->realname;?> aan te passen<br></td>
</tr>
<tr>
<td>Nieuwe status</td>
<td>Ingangsdatum</td>
</tr>
<tr>
<td>
	<?php if($userdata->currentstatus==1){ ?>
	<input type="radio" name="currentstatus" value=1 checked>Huisgenoot<br>
	<input type="radio" name="currentstatus" value=2>Oud-huisgenoot<br>
	<input type="radio" name="currentstatus" value=3>Tijdelijk uitwonend<br>
	<?php 
	} elseif ($userdata->currentstatus==2){ ?>
	<input type="radio" name="currentstatus" value=1>Huisgenoot<br>
	<input type="radio" name="currentstatus" value=2 checked>Oud-huisgenoot<br>
	<input type="radio" name="currentstatus" value=3>Tijdelijk uitwonend<br>
	<?php
	} elseif ($userdata->currentstatus==3){ ?>
	<input type="radio" name="currentstatus" value=1>Huisgenoot<br>
	<input type="radio" name="currentstatus" value=2>Oud-huisgenoot<br>
	<input type="radio" name="currentstatus" value=3 checked>Tijdelijk uitwonend<br>
	<?php 
	} ?>
																				</td>
<td><input type=date name="date" value="<?php echo date("Y-m-d ");?>" min="2014-01-01"></td>
																		
</tr>
</table>
<align="center"><input value="Opslaan" type="submit" />
</form>

</div>
  </section>
</article>
</div>