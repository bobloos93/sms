<?php
include_once($_SERVER['DOCUMENT_ROOT'] ."/sms/config.php");
include (ROOT ."include/header.php");

if ($_SERVER['REQUEST_URI']=="/sms/manage/vastekosten/"){
  ?>
<script>location.href='#tab1'</script>
<?php
}
?>


<div id="wrapper">
<article class="tabs">
	<section id="tab1">
    <h2><a href="#tab1">Itemoverzicht</a></h2>
    <div id="content">
<?php include "adminitemsummary.php";
?>

</div>
  </section>

  <section id="tab2">
    <h2><a href="#tab2">Terugkerende items</a></h2>
    <div id="content">
<?php include "adminreturningitemsummary.php";
?>

</div>
  </section>

   <section id="tab3">
    <h2><a href="#tab3">Gebruikersoverzicht</a></h2>
    <div id="content">
<?php include "adminusersummary.php";
?>

</div>
  </section>
</article>
</div>
