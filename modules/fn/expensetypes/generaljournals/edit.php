<?php
session_start();
require_once("../../../lib.php");

$obj=$_SESSION['obj'];
$action=$_GET['action'];
$i=$_GET['i'];
$edit=$_GET['edit'];

$obj = preg_replace('!s:(\d+):"(.*?)";!e', "'s:'.strlen('$2').':\"$2\";'", $_GET['obj']);

$obj = str_replace("\\","",$obj);
$obj=unserialize($obj);

$shpgeneraljournals=$_SESSION['shpgeneraljournals'];

if($action=="edit"){
	$obj->accountid=$shpgeneraljournals[$i]['accountid'];
	$obj->accountname=$shpgeneraljournals[$i]['accountname'];
	$obj->total=$shpgeneraljournals[$i]['total'];
	$obj->memo=$shpgeneraljournals[$i]['memo'];
	$obj->debit=$shpgeneraljournals[$i]['debit'];
	$obj->credit=$shpgeneraljournals[$i]['credit'];

	$_SESSION['obj']=$obj;
}

$obj->iterator-=1;

//removes the identified row
$shpgeneraljournals1=array_slice($shpgeneraljournals,0,$i);
$shpgeneraljournals2=array_slice($shpgeneraljournals,$i+1);
$shpgeneraljournals=array_merge($shpgeneraljournals1,$shpgeneraljournals2);

$_SESSION['shpgeneraljournals']=$shpgeneraljournals;

$obj = str_replace('&','',serialize($obj));
$obj = str_replace("\"","'",$obj);

redirect("addgeneraljournals_proc.php?edit=1&obj=".$obj);
?>
