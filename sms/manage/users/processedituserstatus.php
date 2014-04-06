		<?php
		include_once($_SERVER['DOCUMENT_ROOT'] ."/sms/config.php");
		include (ROOT ."manage/admincheck.php");

		//SEARCH FOR THE ITEMS WHICH ARE ADDED AFTER THE "UITSCHRIJFDATUM"
		$date=$_POST['date'];
		$changeuserid=$_POST['userid'];
		$changeuserstatus=$_POST['currentstatus'];
		$currentuserstatus=$userdb->query("SELECT currentstatus FROM users WHERE userid='$changeuserid'")->fetch_object()->currentstatus;







		/////////////////EDIT THE VASTENKOSTEN/////////////////


		if ($currentuserstatus==1){



		//COMPARE date FOR items with a timestamp later than that.
		//CHECK IF THE USER WHO IS UNSUBSCRIBED BY THIS SCRIPT DIDN'T BUY ANYTHING AFTER THE DATE. IF SO RETURN TO A PAGE AND SAY TO CHOOSE A DATE LATER
		$abortaction=$vkdb->query("SELECT * FROM items WHERE DATE(timestamp)>'$date' AND userid='$changeuserid'");

		if ($abortaction->num_rows){
		echo "Je probeert een gebruikerstatus te veranderen die na deze datum nog items heeft toegevoegd. Het is niet mogelijk om deze actie uit te voeren. Kies een latere datum of verwijder de items die deze persoon na de gekozen uitschrijfdatum heeft gekocht";
		}



		else{


		//THE ITEMS ARE VALID AND THE USER CAN BE SUCCESSFULLY UNSUBSCRIBED
		$itemsdata=$vkdb->query("SELECT * FROM items WHERE DATE(timestamp)>'$date'");
		while ($items = $itemsdata->fetch_object()){


			//GET THE AFFECTED USERS PER ITEM
			$affectedusers = json_decode($items->affectedusers);
			$numberofusersaffected=0;
			$numberofcurrentusers=0;

			//DETERMINE THE CHANGE IN COST PER PERSON FOR THAT ITEM
			//COUNT AMOUNT OF PERSONS INVOLVED
			for ($a=0; $a<count($affectedusers); $a++){
				$userdata=$userdb->query("SELECT quantifier FROM users WHERE userid='$affectedusers[$a]'");
						$userdataquantifier=$userdata->fetch_object()->quantifier;
							if ($userdata->num_rows){ 
								$numberofusersaffected=$numberofusersaffected+$userdataquantifier;
								}
			}

			$currentcostperperson=$items->amount/$numberofusersaffected;

			//REMOVE ID OF THE SPECIFIC ROOMMATE FROM THE ARRAY TO PROCESS THE NEW COSTPERPERSON
			$pos=array_search($changeuserid,$affectedusers);
			unset($affectedusers[$pos]); 
			$affectedusersreindexed = array_values($affectedusers); //reindexing


			//RETURN currentcostperpson TO THE UNSUBSCRIBED PERSON
				// DETERMINE THE TABLEID THE ITEM IS INFLUENCING AND THE QUANTIFIER OF THE PERSON
				$tableid=$vkdb->query("SELECT tableid FROM monthyeartableid WHERE monthyear='$items->monthyear'")->fetch_object()->tableid;
				$quantifier=$userdb->query("SELECT quantifier FROM users WHERE userid='$changeuserid'")->fetch_object()->quantifier;
				$vkdb->query("UPDATE `$tableid` SET saldoend=saldoend+('$currentcostperperson'*'$quantifier') WHERE userid='$changeuserid'");
			

			//CALCULATE THE NEW ENDSALDOS  
					for ($j=0;$j<count($affectedusersreindexed);$j++){
					//check if all users are still active users of temporary users. If they are old users they won't get a refunding because eveything is already payed of
						$userexistcheck=$userdb->query("SELECT userid, quantifier FROM users WHERE (userid='$affectedusersreindexed[$j]' AND currentstatus!=2)");
						$userexistquantifier=$userexistcheck->fetch_object()->quantifier;
							if ($userexistcheck->num_rows){ 
								$numberofcurrentusers=$numberofcurrentusers+$userexistquantifier;
								}
							}
						for ($k=0;$k<count($affectedusersreindexed);$k++){
						$quantifieruser=$userdb->query("SELECT quantifier FROM users WHERE userid='$affectedusersreindexed[$k]'")->fetch_object()->quantifier;
						$vkdb->query("UPDATE `$tableid` SET saldoend=saldoend-((('$items->amount'/'$numberofcurrentusers')-$currentcostperperson)*'$quantifieruser') WHERE userid='$affectedusersreindexed[$k]'");
						}


		//// HIER BEN IK NU $vkdb->query("UPDATE monthyeartableid SET costsperson=costs'$amount'/'$numberofcurrentusers' WHERE tableid=`$tableid`")
			recurrence($userdb,$vkdb,$tableid);


			//UPDATE THE AFFECTEDROOMMATES IN THE DATABASE
			$array=json_encode($affectedusersreindexed);
			$vkdb->query("UPDATE items SET affectedusers='$array' WHERE itemid='$items->itemid'");
			$userdb->query("UPDATE users SET currentstatus='$changeuserstatus' WHERE userid='$changeuserid'");

		}


		}

	}

		function recurrence($userdb,$vkdb,$tableid){
		$activeroommates=$userdb->query("SELECT * FROM users WHERE currentstatus=1");
		$highesttableid = $vkdb->query("SELECT tableid FROM monthyeartableid WHERE tableid=(SELECT MAX(tableid) FROM monthyeartableid)")->fetch_object()->tableid;
		for ($i=$tableid; $i<$highesttableid; $i++){

			$nexttableid=($i+1);
				while ($activeroommateinfo=$activeroommates->fetch_object()){
					$oldsaldostart=$vkdb->query("SELECT saldostart FROM `$nexttableid` WHERE userid='$activeroommateinfo->userid'")->fetch_object()->saldostart;
					$vkdb->query("UPDATE `$nexttableid` SET saldostart=(SELECT saldoend FROM `$i` WHERE userid='$activeroommateinfo->userid') WHERE userid='$activeroommateinfo->userid'");
					$vkdb->query("UPDATE `$nexttableid` SET saldoend=saldoend+(saldostart-$oldsaldostart) WHERE userid='$activeroommateinfo->userid'");							
				}
		}
		}




