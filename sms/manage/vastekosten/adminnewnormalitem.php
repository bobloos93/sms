<?php
include (ROOT ."manage/admincheck.php");
?>

<form action="./adminprocessnewnormalitem.php" method="post"> 
<table> 

<tr>
<td>Item-beschrijving</td>
<td>Bedrag</td>
</tr>

<tr>
<td><input type="text" name="itemdescription" /></td>
<td><input type="text" name="amount"/></td>
</tr> 

</table>

<align="center"><input value="Opslaan" type="submit" />
</form>