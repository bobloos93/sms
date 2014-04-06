<?php
include_once($_SERVER['DOCUMENT_ROOT'] ."/sms/config.php");
include (ROOT ."include/header.php");
include_once(ROOT ."vastekosten/createvktable.php");
?>

<a href="itemsummary.php">Itemoverzicht</a>;
<a href="usersummary.php">Gebruikersoverzicht</a>;

<?php
include (ROOT ."include/footer.php");
?>