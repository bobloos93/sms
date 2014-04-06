<?php
include_once($_SERVER['DOCUMENT_ROOT'] ."/sms/config.php");

$userid=$_SESSION['userid'];
$itemdescription = $_POST['itemdescription'];
$amount = $_POST['amount'];
$monthyear=$_POST['monthyear'];
$affectedusers = array();
//This variable is for determining the number of roommates the amount has to be divided over.
$sumofhuisgenoten=$userdb->query("SELECT SUM(quantifier) AS sum_quantifier FROM users WHERE currentstatus=1")->fetch_object()->sum_quantifier;

//New item is being processed in the table with all the items
//The new item will be processed over the users
//Find out which table it needs to affect
$tableid = $vkdb->query("SELECT tableid FROM monthyeartableid WHERE monthyear='$monthyear'")->fetch_object()->tableid;
$vkdb->query("UPDATE monthyeartableid SET totalcosts=totalcosts +'$amount' WHERE monthyear='$monthyear'");
//Only the roommates that currently live here have to be charged

//First we calculate what the costs for this month per person is. So we take the previous costperson
//and add $amount/number of roommates

$informationofhuisgenoten=$userdb->query("SELECT * FROM users WHERE currentstatus=1");
$vkdb->query("UPDATE monthyeartableid SET costsperson=costsperson+('$amount'/'$sumofhuisgenoten') WHERE monthyear='$monthyear'");

// At this point we have to process the costs per person in the usersummarytable of this month
// For all persons that are in the table and are still active as roommmate do the following:
while ($info = $informationofhuisgenoten->fetch_object()){
//We first have to check if this user is already in the VK table and if not add him with standard values 0 and 0
$vkdb->query("UPDATE `$tableid` SET saldoend=saldoend-(('$amount'/'$sumofhuisgenoten')*'$info->quantifier') WHERE userid='$info->userid'");
if ($vkdb->affected_rows<1){
//als er bij de vorige query blijkt dat die niet uitgevoerd is voor die userid, terwjil de userid dus wel bestaan in de users tabel
//Wordt het saldo bijpassend bij het userid uit de usertable gehaald en hier ingevoert. Zo kan een tijdelijk uitwonend huisgenoot weer
//aangemeld worden voor de VK.
$vksaldo=$userdb->query("SELECT vksaldo FROM users WHERE userid='$info->userid'")->fetch_object()->vksaldo;
$vkdb->query("INSERT INTO `$tableid` (userid,saldostart,saldoend) VALUES ('$info->userid','$vksaldo', '$vksaldo')");
$vkdb->query("UPDATE `$tableid` SET saldoend=saldoend-(('$amount'/'$sumofhuisgenoten')*'$info->quantifier') WHERE userid='$info->userid'");
}
$affectedusers[] = $info->userid;
}
$affectedusers_serialized=(json_encode($affectedusers));
$vkdb->query("INSERT INTO items (userid, itemdescription, amount, monthyear, affectedusers) VALUES ('$userid','$itemdescription', '$amount' , '$monthyear', '$affectedusers_serialized')");
//At this point we need to update the bought variable in the table for the person who bought things. In the earlier sitaution
//roommates who weren't in the list yet are added, so there shouldn't be a problem with that anymore
$vkdb->query("UPDATE `$tableid` SET bought=bought+'$amount', saldoend=saldoend+'$amount' WHERE userid='$userid'");


//receive the highest tableid that the last table is made to check if a new one is needed
//This part is for the recurrence in the program. So that if an item is added to a earlier table, that is will influence the next table
$activeroommates=$userdb->query("SELECT * FROM users WHERE currentstatus=1");
$highesttableid = $vkdb->query("SELECT tableid FROM monthyeartableid WHERE tableid=(SELECT MAX(tableid) FROM monthyeartableid)")->fetch_object()->tableid;
for ($i=$tableid; $i<$highesttableid; $i++){
	$nexttableid=($i+1);
	echo $nexttableid;
		while ($activeroommateinfo=$activeroommates->fetch_object()){
			$vkdb->query("UPDATE `$nexttableid` SET saldostart=(SELECT saldoend FROM `$i` WHERE userid='$activeroommateinfo->userid') WHERE userid='$activeroommateinfo->userid'");
			$vkdb->query("UPDATE `$nexttableid` SET saldoend=saldoend+((saldostart+bought)-saldoend) WHERE userid='$activeroommateinfo->userid'");
			}
		}		
?>
<script>location.href='index.php#tab1'</script>




