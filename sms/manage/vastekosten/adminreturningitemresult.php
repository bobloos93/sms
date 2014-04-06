<?php
include_once($_SERVER['DOCUMENT_ROOT'] ."/sms/config.php");
include (ROOT ."include/header.php");
include (ROOT ."manage/admincheck.php");
?>

<p>Het terugkerende item is ingevoerd in het systeem en zal vanaf de eerste dag van de komende maand, maandelijks verwerkt worden totdat het termijn is afgelopen </p>

<p size="small">Je zult binnen vijf seconden worden doorgeleid naar het itemoverzicht</p>

<?php
include (ROOT ."include/footer.php");
?>

<meta http-equiv="refresh" content="5; URL='/sms/manage/vastekosten/adminitemsummary.php'" />