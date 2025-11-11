<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Generaljournals_class.php");
require_once("../generaljournalaccounts/Generaljournalaccounts_class.php");
require_once("../../sys/paymentmodes/Paymentmodes_class.php");


$ob=(object)$_POST;

$obj->createdby=1;
$obj->createdon=date("Y-m-d H:i:s");
$obj->lasteditedby=1;
$obj->lasteditedon=date("Y-m-d H:i:s");
$obj->ipaddress=$_SERVER['REMOTE_ADDR'];

//account to credit
$generaljournalaccounts = new Generaljournalaccounts();
$fields="*";
$where=" where refid='4' and acctypeid='1'";
$join="";
$having="";
$groupby="";
$orderby="";
$generaljournalaccounts->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$generaljournalaccounts=$generaljournalaccounts->fetchObject;

/*$paymentmodes = new Paymentmodes();
$fields=" * ";
$having="";
$groupby="";
$orderby="";
$where=" where id='$ob->paymentmode'";
$join=" ";
$paymentmodes->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$paymentmodes = $paymentmodes->fetchObject;*/

		//retrieve account to debit
$generaljournalaccounts2 = new Generaljournalaccounts();
$fields="*";
$where=" where refid='$ob->paymentmode' and acctypeid='8'";
$join="";
$having="";
$groupby="";
$orderby="";
$generaljournalaccounts2->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$generaljournalaccounts2=$generaljournalaccounts2->fetchObject;

		//make credit entry
$generaljournal = new Generaljournals();
$obj->tid=$ob->id;
$obj->documentno="$ob->documentno";
$obj->remarks="Payment ";
$obj->memo=$ob->remarks;
$obj->accountid=$generaljournalaccounts->id;
$obj->daccountid=$generaljournalaccounts2->id;
$obj->transactionid=1;
$obj->mode=$ob->paymentmode;
$obj->class="A";
$obj->debit=0;
$obj->credit=$ob->total;
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
$obj->documentno=$ob->documentno;
$obj->remarks="Receipt ";
$obj->memo=$ob->remarks;
$obj->daccountid=$generaljournalaccounts->id;
$obj->accountid=$generaljournalaccounts2->id;
$obj->transactionid=1;
$obj->mode=$ob->paymentmode;
$obj->debit=$ob->total;
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

?>