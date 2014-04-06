<?php
include (ROOT ."manage/admincheck.php");
include_once(ROOT ."vastekosten/createvktable.php");
?>

<a href="adminnewitem.php">Voer nieuw item in</a>
<table>
<tr>
<td>Terugkerende itemid</td>
<td>Gebruiker</td>
<td>Item-beschrijving</td>
<td>Bedrag</td>
<td>Ingevoerd vanaf</td>
<td>Aantal keer invoeren</td>
<td>Aantal keer invoeren over</td>
<td>Voor het laatst ingevoerd</td>
<td></td>

<?php
$returningitemdatafromdatabase = $vkdb->query("SELECT * FROM returningitems WHERE occurrencesleft>0 ORDER BY occurrencesleft ASC");
while ($returningitemdata = $returningitemdatafromdatabase->fetch_object()){
?>

<tr>
<td><?php echo $returningitemdata->returningitemid;?></td>
<td><?php $namefromuserdatabase = $userdb->query("SELECT realname FROM users WHERE userid='$returningitemdata->userid'");
		  $name=$namefromuserdatabase->fetch_object(); 
		  echo $name->realname; ?></td>
<td><?php echo $returningitemdata->itemdescription;?></td>
<td><?php echo $returningitemdata->amount;?></td>
<td><?php echo $returningitemdata->usedfrom;?></td>
<td><?php echo $returningitemdata->occurrences;?></td>
<td><?php echo $returningitemdata->occurrencesleft;?></td>
<td><?php echo $returningitemdata->lastdate;?></td>
<td><a href="./admineditreturningitem.php?id=<?php echo $returningitemdata->returningitemid;?>#tab1">Wijzig item</a>

</tr>
<?php
}
?>
</table>
<?php
include (ROOT ."include/footer.php");
?>