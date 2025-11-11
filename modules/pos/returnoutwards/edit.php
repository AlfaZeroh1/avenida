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
	$obj->itemname=$shpreturnoutwards[$i]['itemname'];
	$obj->code=$shpreturnoutwards[$i]['code'];
	$obj->tax=$shpreturnoutwards[$i]['tax'];
	$obj->discount=$shpreturnoutwards[$i]['discount'];
	$obj->costprice=$shpreturnoutwards[$i]['costprice'];
	$obj->tradeprice=$shpreturnoutwards[$i]['tradeprice'];
	$obj->total=$shpreturnoutwards[$i]['total'];
	$obj->quantity=$shpreturnoutwards[$i]['quantity'];

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
