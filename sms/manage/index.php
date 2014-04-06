<?php
include_once($_SERVER['DOCUMENT_ROOT'] ."/sms/config.php");
include (ROOT ."include/header.php");

if ($_SERVER['REQUEST_URI']=="/sms/manage/"){
  ?>
<script>location.href='#tab1'</script>
<?php
}
?>


<div id="wrapper">
<article class="tabs">
	<section id="tab1">
    <h2><a href="#tab1">Manage</a></h2>
    <div id="content">
    <?php	include (ROOT ."manage/admincheck.php"); ?>
<a href="./users/">Gebruikers</a> <br>
<a href="./vastekosten/">Vastekosten</a>

</div>
  </section>
</article>
</div>
