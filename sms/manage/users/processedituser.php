<?php
include_once($_SERVER['DOCUMENT_ROOT'] ."/sms/config.php");
include (ROOT ."manage/admincheck.php");

//RECEIVE VARIABLES FROM THE CREATEUSER.PHP CODE
$password=$_POST['password'];
$password = sha1($password);
$userdb->query("UPDATE users SET username='$_POST[username]', password='$password', realname='$_POST[realname]', admin='$_POST[admin]', quantifier='$_POST[quantifier]' WHERE userid='$_POST[userid]'");
?>
<script>location.href='./#tab2'</script>
