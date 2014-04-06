<?php
include_once($_SERVER['DOCUMENT_ROOT'] ."/sms/config.php");
include (ROOT ."include/header.php");

if ($_SERVER['REQUEST_URI']=="/sms/manage/vastekosten/adminnewitem.php"){
  ?>
<script>location.href='#tab1'</script>
<?php
}
?>


<div id="wrapper">
<article class="tabs">

  <section id="tab1">
    <h2><a href="#tab1">Nieuw normaal item</a></h2>
    <div id="content">
  <?php include "adminnewnormalitem.php"; ?>
</div>
  </section>

  <section id="tab2">
    <h2><a href="#tab2">Nieuw terugkerend item</a></h2>
    <div id="content">
  <?php include "adminnewreturningitem.php"; ?>
  </section>
</article>
</div>
