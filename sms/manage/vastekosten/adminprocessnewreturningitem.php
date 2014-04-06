<?php
include_once($_SERVER['DOCUMENT_ROOT'] ."/sms/config.php");

$userid=$_POST['userid'];
$itemdescription = $_POST['itemdescription'];
$amount = $_POST['amount'];
$occurrences=$_POST['occurrences'];
//For telling from which table on it will be implemented
//NOT THE CURRENT MONTH BUT THE NEXT MONTH
if ($month!=12){
	$month=sprintf("%02s", date("m")+1);
	$year=date("Y");
	}
	else{
		$month = sprintf("%02s", 1);
		$year = date("Y")+1;
		}
$usedfrom=("$month$year");

$vkdb->query("INSERT INTO returningitems (userid,itemdescription,amount,usedfrom,occurrences,occurrencesleft) VALUES ('$userid', '$itemdescription','$amount','$usedfrom','$occurrences','$occurrences')");
?>
<script>location.href='adminreturningitemresult.php'</script>




