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

<form action="./processedituser.php" method="post"> 
<input type=hidden name="userid" value="<?php echo $userdata->userid;?>">
<table>
<tr>
<td>Gebruikers-naam</td>
<td>Naam</td>
<td>Wachtwoord</td>
</tr>
<tr>
<td><input type="text" name="username" value="<?php echo $userdata->username;?>" /></td>
<td><input type="text" name="realname" value="<?php echo $userdata->realname;?>" /></td>
<td><input type="text" name="password" value="<?php echo $userdata->password;?>" /></td>
</tr>
<tr>
<td>Huidige status</td>
<td>Admin rechten</td>
<td>Aantal personen op dit account</td>
</tr>
<tr>
<td>
	<?php if($userdata->currentstatus==1){
	echo "Huisgenoot";
	} elseif ($userdata->currentstatus==2){
	echo "Oudhuisgenoot";
	} elseif ($userdata->currentstatus==3){ 
	echo "Tijdelijk uitwonend";
	} ?>
	<br>
	<a href=edituserstatus.php?id=<?php echo $userdata->userid?>#tab1>Wijzig status</a>
																				</td>
																		
<td><?php if($userdata->admin==1){ ?>
	<input type="radio" name="admin" value=1 checked>Ja<br>
	<input type="radio" name="admin" value=0>Nee<br>
	<?php
	} else { ?>
	<input type="radio" name="admin" value=1>Ja<br>
	<input type="radio" name="admin" value=0 checked>Nee<br>
	<?php
	}
	?>
			</td>
<td><input type="number" name="quantifier" min="1" step="1" value="<?php echo $userdata->quantifier;?>" /></td>
																		
																				


</tr>
</table>
<align="center"><input value="Opslaan" type="submit" />
</form>

</div>
  </section>
</article>
</div>