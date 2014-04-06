<?php
include (ROOT ."manage/admincheck.php");

?>
<a href="./createuser.php">Maak nieuwe gebruiker aan</a>
<table>
<tr>
<td>Gebruikers-naam</td>
<td>Naam</td>
<td>Huidige status</td>
<td>Admin-rechten</td>
<td>Aantal personen</td>
<td></td>

<?
$userdatafromdatabase =  $userdb->query("SELECT * FROM users");
while ($userdata = $userdatafromdatabase->fetch_object()){
?>

<tr>
<td><?php echo $userdata->username;?></td>
<td><?php echo $userdata->realname;?></td>
<td><?php if ($userdata->currentstatus==1){
			echo "Huisgenoot";
			}
			elseif ($userdata->currentstatus==2){
			echo "Oud-huisgenoot";
			}
			else {
			echo "Tijdelijk uitwonend";
			} ?>
										</td>
<td><?php if ($userdata->admin==1){
			echo "Ja";
			}
			elseif ($userdata->admin==0){
			echo "Nee";
			}
			?>
</td>
<td><?php echo $userdata->quantifier;?></td>
<td><a href="./edituser.php?id=<?php echo $userdata->userid;?>#tab1">Wijzig</a>

</tr>
<?php
}
?>
</table>

<?php
include (ROOT ."include/footer.php");
?>