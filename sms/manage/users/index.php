<?php
include_once($_SERVER['DOCUMENT_ROOT'] ."/sms/config.php");
include (ROOT ."include/header.php");

if ($_SERVER['REQUEST_URI']=="/sms/manage/users/"){
  ?>
<script>location.href='#tab1'</script>
<?php
}
?>


<div id="wrapper">
<article class="tabs">
	<section id="tab1">
    <h2><a href="#tab1">Gebruikers</a></h2>
    <div id="content">
<?php include "users.php";
?>

</div>
  </section>
</article>
</div>
