<?php
include_once($_SERVER['DOCUMENT_ROOT'] ."/sms/config.php");
include (ROOT ."include/header.php");

if ($_SERVER['REQUEST_URI']=="/sms/vastekosten/newitem.php"){
  ?>
<script>location.href='#tab1'</script>
<?php
}
?>


<article class="tabs">
<section id="tab1">
<h2><a href="#tab1">Nieuw item invoeren</a></h2>
<div id="content">
<form class="validate-form" action="./processnewitem.php" method="post"> 
<table> 
<tr>
<td>Item-beschrijving</td>
<td>Bedrag</td>
</tr>

<tr>
<td><input type="text" name="itemdescription" required/></td>
<td><input type="text" name="amount" onkeyup="commadot(this)"/ required></td>
</tr> 

</table>
<align="center"><input value="Opslaan" type="submit" />
</form>  
<a href="./index.php#tab1">Terug naar itemoverzicht<a>
 </section>
</article>
</div>


<script type="text/javascript">
if (hasHtml5Validation()) {
 $('.validate-form').submit(function (e) {
   if (!this.checkValidity()) {
     // Prevent default stops form from firing
     e.preventDefault();
     $(this).addClass('invalid');
     $('#status').html('invalid');
   } else {
     $(this).removeClass('invalid');
     $('#status').html('submitted');
   }
 });
}</script>


