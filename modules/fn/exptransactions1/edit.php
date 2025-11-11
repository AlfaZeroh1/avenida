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

$shpexptransactions=$_SESSION['shpexptransactions'];

if($action=="edit"){
	$obj->expenseid=$shpexptransactions[$i]['expenseid'];
	$obj->quantity=$shpexptransactions[$i]['quantity'];
	$obj->tax=$shpexptransactions[$i]['tax'];
	$obj->discount=$shpexptransactions[$i]['discount'];
	$obj->amount=$shpexptransactions[$i]['amount'];
	$obj->memo=$shpexptransactions[$i]['memo'];
	$obj->plotid=$shpexptransactions[$i]['plotid'];
	$obj->paymenttermid=$shpexptransactions[$i]['paymenttermid'];
	$obj->month=$shpexptransactions[$i]['month'];
	$obj->year=$shpexptransactions[$i]['year'];
}

$obj->iterator-=1;

//removes the identified row
$shpexptransactions1=array_slice($shpexptransactions,0,$i);
$shpexptransactions2=array_slice($shpexptransactions,$i+1);
$shpexptransactions=array_merge($shpexptransactions1,$shpexptransactions2);

$_SESSION['shpexptransactions']=$shpexptransactions;

$obj = str_replace('&','',serialize($obj));
$obj = str_replace("\"","'",$obj);

redirect("addexptransactions_proc.php?edit=1&obj=".$obj);
?>
