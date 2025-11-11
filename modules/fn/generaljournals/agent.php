<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Generaljournals_class.php");
require_once("../generaljournalaccounts/Generaljournalaccounts_class.php");
require_once("../../sys/paymentmodes/Paymentmodes_class.php");

//197.254.22.228/wisedigits/modules/fn/generaljournals/agent.php?transactionid=&amount=&paymentmode=&incomeid=&details
$ob=(object)$_POST;

echo "Received for Processing....<br/>";

$obj->createdby=1;
$obj->createdon=date("Y-m-d H:i:s");
$obj->lasteditedby=1;
$obj->lasteditedon=date("Y-m-d H:i:s");
$obj->ipaddress=$_SERVER['REMOTE_ADDR'];

if($ob->type=="payment"){echo "Processing....</br>";
  //account to credit
  $generaljournalaccounts = new Generaljournalaccounts();
  $fields="*";
  $where=" where refid='$ob->incomeid' and acctypeid='1'";
  $join="";
  $having="";
  $groupby="";
  $orderby="";
  $generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);
  $generaljournalaccounts=$generaljournalaccounts->fetchObject;

  $paymentmodes = new Paymentmodes();
  $fields=" * ";
  $having="";
  $groupby="";
  $orderby="";
  $where=" where id='$ob->paymentmode'";
  $join=" ";
  $paymentmodes->retrieve($fields, $join, $where, $having, $groupby, $orderby);
  $paymentmodes = $paymentmodes->fetchObject;

		  //retrieve account to debit
  $generaljournalaccounts2 = new Generaljournalaccounts();
  $fields="*";
  $where=" where refid='$ob->paymentmode' and acctypeid='$paymentmodes->acctypeid'";
  $join="";
  $having="";
  $groupby="";
  $orderby="";
  $generaljournalaccounts2->retrieve($fields, $join, $where, $having, $groupby, $orderby);
  $generaljournalaccounts2=$generaljournalaccounts2->fetchObject;

		  //make credit entry
  $generaljournal = new Generaljournals();
  $obj->tid=$ob->id;
  $obj->documentno="$ob->transactionid";
  $obj->remarks="Revenue ";
  $obj->memo=$ob->details;
  $obj->accountid=$generaljournalaccounts->id;
  $obj->daccountid=$generaljournalaccounts2->id;
  $obj->transactionid=1;
  $obj->mode=$ob->paymentmode;
  $obj->class="A";
  $obj->debit=0;
  $obj->credit=$ob->amount;
  $obj->transactdate=$ob->transactdate;
  $generaljournal->setObject($obj);
  //$generaljournal->add($generaljournal);

  $it=0;
  $shpgeneraljournals=array();

  $shpgeneraljournals[$it]=array('accountid'=>"$generaljournal->accountid", 'tid'=>"$generaljournal->tid", 'documentno'=>"$generaljournal->documentno", 'class'=>"A", 'accountname'=>"$generaljournalaccounts->name", 'memo'=>"$generaljournal->memo", 'remarks'=>"$generaljournal->remarks", 'debit'=>"$generaljournal->debit", 'credit'=>"$generaljournal->credit", 'total'=>"$generaljournal->total",'transactdate'=>"$generaljournal->transactdate");

  $it++;

		  //make credit entry
  $generaljournal2 = new Generaljournals();
  $obj->tid=$ob->id;
  $obj->documentno=$ob->transactionid;
  $obj->remarks="Revenue ";
  $obj->memo=$ob->details;
  $obj->daccountid=$generaljournalaccounts->id;
  $obj->accountid=$generaljournalaccounts2->id;
  $obj->transactionid=1;
  $obj->mode=$ob->paymentmode;
  $obj->debit=$ob->amount;
  $obj->credit=0;
  $obj->class="A";
  $obj->transactdate=$ob->transactdate;
  $obj->did=$generaljournal->id;
  $generaljournal2->setObject($obj);
  //$generaljournal2->add($generaljournal2);

  $shpgeneraljournals[$it]=array('accountid'=>"$generaljournal2->accountid", 'tid'=>"$generaljournal2->tid", 'documentno'=>"$generaljournal->documentno", 'class'=>"A", 'accountname'=>"$generaljournalaccounts2->name", 'memo'=>"$generaljournal2->memo",'remarks'=>"$generaljournal2->remarks", 'debit'=>"$generaljournal2->debit", 'credit'=>"$generaljournal2->credit", 'total'=>"$generaljournal2->total",'transactdate'=>"$generaljournal->transactdate");
	  
  $gn = new Generaljournals();
  if($gn->add($obj, $shpgeneraljournals))
    echo "SUCCESS";
  else
    echo "FAILURE";
}
if($obj->type=="deposit"){
  
}
?>