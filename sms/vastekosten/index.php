<?php
include_once($_SERVER['DOCUMENT_ROOT'] ."/sms/config.php");
include (ROOT ."include/header.php");
include_once(ROOT ."vastekosten/createvktable.php");

if ($_SERVER['REQUEST_URI']=="/sms/vastekosten/"){
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
  <?php include "itemsummary.php"; ?>
</div>
  </section>

  <section id="tab2">
    <h2><a href="#tab2">Gebruikersoverzicht</a></h2>
    <div id="content">
  <?php include "usersummary.php"; ?>
  </section>
</article>
</div>

<script>
   function scrollWin() {
    window.scrollTo(500,0);
   }
</script>