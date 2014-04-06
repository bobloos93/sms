<?php
include_once($_SERVER['DOCUMENT_ROOT'] ."/sms/config.php");
//RECEIVE WEEK AND YEAR
$itemid=$_POST['itemid'];
$userid=$_POST['userid'];
$itemdescription = $_POST['itemdescription'];
$amount = $_POST['amount'];
$monthyear=$_POST['monthyear'];
$tableid=$vkdb->query("SELECT tableid FROM monthyeartableid WHERE monthyear='$monthyear'")->fetch_object()->tableid;
$remove=$_POST['remove'];
//Get the list of affected users for the certain item we want to edit or remove
$listofaffectedusers=$vkdb->query("SELECT affectedusers FROM items WHERE itemid='$itemid'")->fetch_object()->affectedusers;
$affectedusers = json_decode($listofaffectedusers);
//The number of users that are affected and are still roommates
$numberofcurrentusers=0;
 
echo (count($affectedusers));
echo $affectedusers[0];


if ($remove==1){
//First we check the number of current roommates that are affected by the action so that we know by which number we need to divide
//the amount. 
	for ($j=0;$j<count($affectedusers);$j++){
	//check if all users are still active users of temporary users. If they are old users they won't get a refunding because eveything is already payed of
	$userexistcheck=$userdb->query("SELECT userid, quantifier FROM users WHERE (userid='$affectedusers[$j]' AND currentstatus!=2)");
	$userexistquantifier=$userexistcheck->fetch_object()->quantifier;
		if ($userexistcheck->num_rows){ 
		$numberofcurrentusers=$numberofcurrentusers+$userexistquantifier;
		}
	}
	for ($k=0;$k<count($affectedusers);$k++){
	$quantifieruser=$userdb->query("SELECT quantifier FROM users WHERE userid='$affectedusers[$k]'")->fetch_object()->quantifier;
	$vkdb->query("UPDATE `$tableid` SET saldoend=saldoend+(((SELECT amount FROM items WHERE itemid='$itemid')/'$numberofcurrentusers')*'$quantifieruser') WHERE userid='$affectedusers[$k]'");
	}
	
	$vkdb->query("UPDATE `$tableid` SET bought=bought-(SELECT amount FROM items WHERE itemid='$itemid'), saldoend=saldoend-(SELECT amount FROM items WHERE itemid='$itemid') WHERE userid=(SELECT userid FROM items WHERE itemid='$itemid')");
	$vkdb->query("DELETE FROM items WHERE itemid='$itemid'");
	recurrence($userdb,$vkdb,$tableid);
}
else {
	if ($itemdescription!=$vkdb->query("SELECT itemdescription FROM items WHERE itemid='$itemid'")->fetch_object()->itemdescription){
	$vkdb->query("UPDATE items SET itemdescription='$itemdescription' WHERE itemid='$itemid'");
	}
	if ($amount!=$vkdb->query("SELECT amount FROM items WHERE itemid='$itemid'")->fetch_object()->amount){
	$oldsaldo=$vkdb->query("SELECT amount FROM items WHERE itemid='$itemid'")->fetch_object()->amount;
	$vkdb->query("UPDATE `$tableid` SET bought=bought+('$amount'-'$oldsaldo'), saldoend=saldoend+('$amount'-'$oldsaldo') WHERE userid='$userid'");
		for ($j=0;$j<count($affectedusers);$j++){
			//check if all users are still active users of temporary users. If they are old users they won't get a refunding because eveything is already payed of
				$userexistcheck=$userdb->query("SELECT userid, quantifier FROM users WHERE (userid='$affectedusers[$j]' AND currentstatus!=2)");
				$userexistquantifier=$userexistcheck->fetch_object()->quantifier;
					if ($userexistcheck->num_rows){ 
						$numberofcurrentusers=$numberofcurrentusers+$userexistquantifier;
						}
					}
			for ($k=0;$k<count($affectedusers);$k++){
			$quantifieruser=$userdb->query("SELECT quantifier FROM users WHERE userid='$affectedusers[$k]'")->fetch_object()->quantifier;
			$vkdb->query("UPDATE `$tableid` SET saldoend=saldoend-((('$amount'-'$oldsaldo')/'$numberofcurrentusers')*'$quantifieruser') WHERE userid='$affectedusers[$k]'");
			}
		//// HIER BEN IK NU $vkdb->query("UPDATE monthyeartableid SET costsperson=costs'$amount'/'$numberofcurrentusers' WHERE tableid=`$tableid`")
		$vkdb->query("UPDATE items SET amount='$amount' where itemid='$itemid'");
		recurrence($userdb,$vkdb,$tableid);
		}
}

function recurrence($userdb,$vkdb,$tableid){
$activeroommates=$userdb->query("SELECT * FROM users WHERE currentstatus=1");
$highesttableid = $vkdb->query("SELECT tableid FROM monthyeartableid WHERE tableid=(SELECT MAX(tableid) FROM monthyeartableid)")->fetch_object()->tableid;
for ($i=$tableid; $i<=$highesttableid; $i++){

	$nexttableid=($i+1);
		while ($activeroommateinfo=$activeroommates->fetch_object()){
			$oldsaldostart=$vkdb->query("SELECT saldostart FROM `$nexttableid` WHERE userid='$activeroommateinfo->userid'")->fetch_object()->saldostart;
			$vkdb->query("UPDATE `$nexttableid` SET saldostart=(SELECT saldoend FROM `$i` WHERE userid='$activeroommateinfo->userid') WHERE userid='$activeroommateinfo->userid'");
			$vkdb->query("UPDATE `$nexttableid` SET saldoend=saldoend+(saldostart-$oldsaldostart) WHERE userid='$activeroommateinfo->userid'");							
		}
}
}
?>
<script>location.href='index.php#tab1'</script>








