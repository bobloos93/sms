<?php
include_once($_SERVER['DOCUMENT_ROOT'] ."/sms/config.php");
include (ROOT ."manage/admincheck.php");

//RECEIVE VARIABLES FROM THE CREATEUSER.PHP CODE
$password=$_POST['password'];
$password = sha1($password);
$userdb->query("INSERT INTO users (username, password, realname) VALUES ('$_POST[username]','$password', '$_POST[realname]')");
?>

<script>location.href='./'</script>