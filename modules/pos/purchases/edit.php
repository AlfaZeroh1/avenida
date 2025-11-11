<?php
session_start();
require_once("../../../lib.php");

$obj=$_SESSION['obj'];
$action=$_GET['action'];
$i=$_GET['i'];
$edit=$_GET['edit'];

$shppurchases=$_SESSION['shppurchases'];

if($action=="edit"){
	$obj->itemid=$shppurchases[$i]['itemid'];
	$obj->itemname=$shppurchases[$i]['itemname'];
	$obj->code=$shppurchases[$i]['code'];
	$obj->tax=$shppurchases[$i]['tax'];
	$obj->discount=$shppurchases[$i]['discount'];
	$obj->costprice=$shppurchases[$i]['costprice'];
	$obj->tradeprice=$shppurchases[$i]['tradeprice'];
	$obj->total=$shppurchases[$i]['total'];
	$obj->quantity=$shppurchases[$i]['quantity'];

	$_SESSION['obj']=$obj;
}

$obj->iterator-=1;

//removes the identified row
$shppurchases1=array_slice($shppurchases,0,$i);
$shppurchases2=array_slice($shppurchases,$i+1);
$shppurchases=array_merge($shppurchases1,$shppurchases2);

$_SESSION['shppurchases']=$shppurchases;

redirect("addpurchases_proc.php?edit=1");
?>
