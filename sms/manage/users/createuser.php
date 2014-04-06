<?php
include_once($_SERVER['DOCUMENT_ROOT'] ."/sms/config.php");
include (ROOT ."include/header.php");



if ($_SERVER['REQUEST_URI']=="/sms/manage/users/createuser.php"){
  ?>
<script>location.href='#tab1'</script>
<?php
}

?>


<div id="wrapper">
<article class="tabs">
	<section id="tab1">
    <h2><a href="#tab1">Maak nieuwe gebruiker aan</a></h2>
    <div id="content">

  <?php  	include (ROOT ."manage/admincheck.php"); ?>


<form action="./processcreateuser.php" method="post"> 
<table> 
<tr>
<td>Gebruikers-naam</td>
<td>Naam</td>
<td>Wachtwoord</td>
</tr>

<tr>
<td><input type="text" name="username"/></td>
<td><input type="text" name="realname"/></td>
<td><input type="text" name="password"/></td>
</tr> 

</table>
<align="center"><input value="Opslaan" type="submit" />
</form>  
</div>
  </section>
</article>
</div>

