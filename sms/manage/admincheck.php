<?php
include_once($_SERVER['DOCUMENT_ROOT'] ."/sms/config.php");

if ($_SESSION['admin']==1){
?>
<div id="admincheck">
<p> Je bevindt je op dit moment in het admin-portaal. Vergeet straks niet uit te loggen! </p>
</div>
<?php
}
else {
?>
<script>location.href='/sms/noacces.php'</script>
<?php
}
?>


