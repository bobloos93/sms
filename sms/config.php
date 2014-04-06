<?php
//CONNECTION TO THE DATABASE
session_start();
		$loggedin = false;
		if(isset($_SESSION['userid'])){
		$loggedin = true;
}

// connect to the server
$userdb = new mysqli('localhost', 'root', 'root', 'bloos_patiousers');
$vkdb = new mysqli('localhost', 'root', 'root', 'bloos_vk');

// check connection
if (mysqli_connect_errno()) {
  exit('Connect failed: '. mysqli_connect_error());
}
else {
}

?>


<?php
//SETUP LOCATION OF THE MAIN FOLDER
define("ROOT", $_SERVER['DOCUMENT_ROOT']."/sms/");

//SETUP THE LOCAL LANGUAGE
	setlocale(LC_ALL, 'nl_NL');
?>

<script>
function hasHtml5Validation () {
 return typeof document.createElement('input').checkValidity === 'function';
}

</script>

<META HTTP-EQUIV="refresh" CONTENT="300">