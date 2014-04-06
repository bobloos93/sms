<?php
include_once($_SERVER['DOCUMENT_ROOT'] ."/sms/config.php");
$name=$_POST['name'];
$password=$_POST['password'];
$password = sha1($password);
if ($result = $userdb->query("SELECT * FROM users WHERE username='$name' AND password='$password'")){
	while($obj = $result->fetch_object()){
		if($result->num_rows>0){
			echo "succes";
	

			$_SESSION['userid'] = $obj->userid;
			$_SESSION['name'] = $obj->realname;
			$_SESSION['admin'] = $obj->admin;
		}
		else{
			echo "fail";
		}
	}
} 
?>