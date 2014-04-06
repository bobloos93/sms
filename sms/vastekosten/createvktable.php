<?php 
include_once($_SERVER['DOCUMENT_ROOT'] ."/sms/config.php");
$month=date("m");
$year=date("Y");
$currentmonthyear = ("$month$year");
//receive the date (monthyear) that the last table is made to check if a new one is needed
$lastmonthyearindb = $vkdb->query("SELECT monthyear FROM monthyeartableid WHERE tableid=(SELECT MAX(tableid) FROM monthyeartableid)")->fetch_object();
if ($currentmonthyear==$lastmonthyearindb->monthyear){
//Nothing to do here because the table for this month allready exists
}
else {
//Create a new table with the id that fits with the monthyear
$vkdb->query("INSERT INTO monthyeartableid (monthyear) VALUES ('$currentmonthyear')");
$newtableid = $vkdb->query("SELECT tableid FROM monthyeartableid WHERE monthyear='$currentmonthyear'")->fetch_object()->tableid;
$vkdb->query("CREATE TABLE `$newtableid` (userid int(11) NOT NULL, saldostart decimal(10,2) NOT NULL, saldoend decimal(10,2) NOT NULL,bought decimal(10,2) NOT NULL)");

//At this point we only want to add the users that are stated as huisgenoten
$informationofhuisgenoten=$userdb->query("SELECT * FROM users WHERE currentstatus=1");
while ($info = $informationofhuisgenoten->fetch_object()){
$vkdb->query("INSERT INTO `$newtableid` (userid) VALUES ('$info->userid')");
$previoustableid=$newtableid-1;
$vkdb->query("UPDATE `$newtableid` SET saldostart=(SELECT saldoend FROM `$previoustableid` WHERE userid = '$info->userid'), saldoend=saldostart WHERE userid = '$info->userid' ");
}

//We process the returning items from the returning titems-table in this table!
$returningitems=$vkdb->query("SELECT * FROM returningitems WHERE occurrencesleft>0");
while ($returning=$returningitems->fetch_object()){
processreturningitem($returning->userid,$returning->itemdescription,$returning->amount,$userdb,$vkdb); 
$vkdb->query("UPDATE returningitems SET occurrencesleft=occurrencesleft-1 WHERE returningitemid='$returning->returningitemid'");
}
}

///FUNCTIONS

function processreturningitem($userid,$itemdescription,$amount,$userdb,$vkdb){
//RECEIVE WEEK AND YEAR
$month=date("m");
$year=date("Y");
$monthyear=("$month$year");
$affectedusers = array();
$sumofhuisgenoten=$userdb->query("SELECT SUM(quantifier) AS sum_quantifier FROM users WHERE currentstatus=1")->fetch_object()->sum_quantifier;

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
//this part is for saving an array of ids in the itemtable for repayment when an item is removed.
$affectedusers[] = $info->userid;
}
$affectedusers_serialized=json_encode($affectedusers);
//New item is being processed in the table with all the items
$vkdb->query("INSERT INTO items (userid, itemdescription, amount, monthyear, affectedusers) VALUES ('$userid','$itemdescription', '$amount' , '$monthyear', '$affectedusers_serialized')");
//At this point we need to update the bought variable in the table for the person who bought things. In the earlier sitaution
//roommates who weren't in the list yet are added, so there shouldn't be a problem with that anymore
$vkdb->query("UPDATE `$tableid` SET bought=bought+'$amount', saldoend=saldoend+'$amount' WHERE userid='$userid'");
}







?>