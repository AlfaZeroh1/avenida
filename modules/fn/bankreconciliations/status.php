<?php
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Bankreconciliations_class.php");
require_once '../generaljournals/Generaljournals_class.php';

$db = new DB();

$obj=(object)$_GET;

// $generaljournal = new Generaljournals();
// $fields="*";
// $where=" where id='$obj->id' ";
// $having="";
// $groupby="";
// $orderby="";
// $generaljournal->retrieve($fields, $join, $where, $having, $groupby, $orderby);
// $generaljournal=$generaljournal->fetchObject;
// $generaljournal->reconstatus=$obj->status;
// $generaljournal->recondate=$obj->date;
// 
// $gn = new Generaljournals();

// $shpgeneraljournals[0]=array('id'=>"$generaljournal->id",'tid'=>"$generaljournal->tid",'documentno'=>"$generaljournal->documentno",'remarks'=>"$generaljournal->remarks",'memo'=>"$generaljournal->memo",'accountid'=>"$generaljournal->accountid",'transactionid'=>"$generaljournal->transactionid",'mode'=>"$generaljournal->mode",'debit'=>"$generaljournal->debit",'credit'=>"$generaljournal->credit",'transactdate'=>"$generaljournal->transactdate",'class'=>"$generaljournal->class",'reconstatus'=>"$generaljournal->reconstatus",'recondate'=>"$generaljournal->recondate");

// $gn->edit($generaljournal,"",$shpgeneraljournals);

mysql_query("update fn_generaljournals set reconstatus='$obj->status', recondate='$obj->date' where id='$obj->id'");

?>