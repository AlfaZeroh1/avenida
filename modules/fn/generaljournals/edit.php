<?php
session_start();
require_once("../../../lib.php");

$obj=$_SESSION['obj'];
$action=$_GET['action'];
$i=$_GET['i'];
$edit=$_GET['edit'];

$shpgeneraljournals=$_SESSION['shpgeneraljournals'];

if($action=="edit"){
	$obj->accountid=$shpgeneraljournals[$i]['accountid'];
	$obj->accountname=$shpgeneraljournals[$i]['accountname'];
	$obj->total=$shpgeneraljournals[$i]['total'];
	$obj->memo=$shpgeneraljournals[$i]['memo'];
	$obj->debit=$shpgeneraljournals[$i]['debit'];
	$obj->credit=$shpgeneraljournals[$i]['credit'];
	$obj->documentno=$shpgeneraljournals[$i]['documentno'];
	$obj->recondate=$shpgeneraljournals[$i]['recondate'];
	$obj->recontime=$shpgeneraljournals[$i]['recontime'];
	$obj->reconstatus=$shpgeneraljournals[$i]['reconstatus'];
	$obj->transactionid=$shpgeneraljournals[$i]['transactionid'];
	$obj->balance=$shpgeneraljournals[$i]['balance'];
	$obj->remarks=$shpgeneraljournals[$i]['remarks'];

	$_SESSION['obj']=$obj;
}

$obj->iterator-=1;

//removes the identified row
$shpgeneraljournals1=array_slice($shpgeneraljournals,0,$i);
$shpgeneraljournals2=array_slice($shpgeneraljournals,$i+1);
$shpgeneraljournals=array_merge($shpgeneraljournals1,$shpgeneraljournals2);

$_SESSION['shpgeneraljournals']=$shpgeneraljournals;

 redirect("addgeneraljournals_proc.php?edit=1");
?>
