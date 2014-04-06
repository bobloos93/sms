<?php
include_once($_SERVER['DOCUMENT_ROOT'] ."/sms/config.php");
include (ROOT ."include/header.php");
?>
<p>Je hebt geen adminrechten en daarom geen toegang tot het admin-portaal. Binnen 5 seconden wordt je teruggestuurd naar de hoofdpagina. Klik <a href="/sms">hier</a> als je niet wordt doorgestuurd!</p>
<meta http-equiv="refresh" content="5; URL='/sms'" />
<?php
include (ROOT ."include/footer.php");
?>