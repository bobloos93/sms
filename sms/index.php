<?php
include_once($_SERVER['DOCUMENT_ROOT'] ."/sms/config.php");
include (ROOT ."include/header.php");

if ($_SERVER['REQUEST_URI']=="/sms/"){
 ?>
<script>location.href='#tab1'</script>
<?php
}
?>













<div id="wrapper">
<article class="tabs">
	<section id="tab1">
    <h2><a href="#tab1">Welkom</a></h2>
    <div id="content">
<h1>Welkom</h1>
<?php
if (!$loggedin){
?>
<p>Om gebruik te maken van dit portaal, zul je je eerst moeten inloggen!</p>
<?php
}
else{
?>
<p>Kies een van de lijsten om verder te gaan</p>
<?php
}
?>

</div>
  </section>
</article>
</div>



