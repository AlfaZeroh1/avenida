<?php
session_start();
require_once("../../../lib.php");

$obj=$_SESSION['obj'];
$action=$_GET['action'];
$i=$_GET['i'];
$edit=$_GET['edit'];

$shpreturnoutwards=$_SESSION['shpreturnoutwards'];

if($action=="edit"){
	$obj->itemid=$shpreturnoutwards[$i]['itemid'];
	$obj->quantity=$shpreturnoutwards[$i]['quantity'];
	$obj->costprice=$shpreturnoutwards[$i]['costprice'];
	$obj->tax=$shpreturnoutwards[$i]['tax'];
	$obj->discount=$shpreturnoutwards[$i]['discount'];
	$obj->total=$shpreturnoutwards[$i]['total'];
	$obj->remarks=$shpreturnoutwards[$i]['remarks'];

	$_SESSION['obj']=$obj;
}

$obj->iterator-=1;

//removes the identified row
$shpreturnoutwards1=array_slice($shpreturnoutwards,0,$i);
$shpreturnoutwards2=array_slice($shpreturnoutwards,$i+1);
$shpreturnoutwards=array_merge($shpreturnoutwards1,$shpreturnoutwards2);

$_SESSION['shpreturnoutwards']=$shpreturnoutwards;

redirect("addreturnoutwards_proc.php?edit=1");
?>
