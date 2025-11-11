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

$shpinctransactions=$_SESSION['shpinctransactions'];

if($action=="edit"){
	$obj->incomeid=$shpinctransactions[$i]['incomeid'];
	$obj->quantity=$shpinctransactions[$i]['quantity'];
	$obj->tax=$shpinctransactions[$i]['tax'];
	$obj->discount=$shpinctransactions[$i]['discount'];
	$obj->amount=$shpinctransactions[$i]['amount'];
	$obj->memo=$shpinctransactions[$i]['memo'];
	$obj->plotid=$shpinctransactions[$i]['plotid'];
	$obj->paymenttermid=$shpinctransactions[$i]['paymenttermid'];
	$obj->month=$shpinctransactions[$i]['month'];
	$obj->year=$shpinctransactions[$i]['year'];
}

$obj->iterator-=1;

//removes the identified row
$shpinctransactions1=array_slice($shpinctransactions,0,$i);
$shpinctransactions2=array_slice($shpinctransactions,$i+1);
$shpinctransactions=array_merge($shpinctransactions1,$shpinctransactions2);

$_SESSION['shpinctransactions']=$shpinctransactions;

$obj = str_replace('&','',serialize($obj));
$obj = str_replace("\"","'",$obj);

redirect("addinctransactions_proc.php?edit=1&obj=".$obj);
?>
