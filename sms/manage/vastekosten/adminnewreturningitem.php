<?php
include (ROOT ."manage/admincheck.php");
?>

<form action="./adminprocessnewreturningitem.php" method="post"> 
<table> 
<tr>
<td>Gebruiker</td>
<td>Item-beschrijving</td>
<td>Bedrag</td>
<td>Aantal keer invoeren (inclusief komende maand)</td>
</tr>

<tr>
<td>
<select name="userid">
			<?php $userdatafromdb=$userdb->query("SELECT * FROM users WHERE currentstatus!=2 ORDER BY realname ASC" );
			while ($userdata = $userdatafromdb->fetch_object()){
			?>
   <option value="<?php echo $userdata->userid;?>"><?php echo $userdata->realname;?> </option>
			<?php
			}
			?>    
  </select>
 </td>
<td><input type="text" name="itemdescription" /></td>
<td><input type="text" name="amount"/></td>
<td><input type="number" name="occurrences" value='2' min='2' max='12'/><td>
</tr> 

</table>
<align="center"><input value="Opslaan" type="submit" />
</form>  