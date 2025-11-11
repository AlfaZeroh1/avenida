<?php
session_start();
require_once("../../../lib.php");

$obj=$_SESSION['obj'];
$action=$_GET['action'];
$i=$_GET['i'];
$edit=$_GET['edit'];


$shppurchaseorders=$_SESSION['shppurchaseorders'];

if($action=="edit"){
	$obj->quantity=$shppurchaseorders[$i]['quantity'];
	$obj->itemid=$shppurchaseorders[$i]['itemid'];
	$obj->itemname=$shppurchaseorders[$i]['itemname'];
	$obj->remarks=$shppurchaseorders[$i]['remarks'];
	$obj->costprice=$shppurchaseorders[$i]['costprice'];
	$obj->tradeprice=$shppurchaseorders[$i]['tradeprice'];
	$obj->total=$shppurchaseorders[$i]['total'];
	$obj->unitofmeasureid=$shppurchaseorders[$i]['unitofmeasureid'];
	$obj->unitofmeasurename=$shppurchaseorders[$i]['unitofmeasurename'];
	$obj->tax = $shppurchaseorders[$i]['tax'];
	$obj->taxamount = $shppurchaseorders[$i]['taxamount'];
	$obj->vatclasseid = $shppurchaseorders[$i]['vatclasseid'];
	$obj->total = $shppurchaseorders[$i]['total'];
	$obj->i=$i;

	$_SESSION['obj']=$obj;
}
else{
  $obj->iterator-=1;

  //removes the identified row
  $shppurchaseorders1=array_slice($shppurchaseorders,0,$i);
  $shppurchaseorders2=array_slice($shppurchaseorders,$i+1);
  $shppurchaseorders=array_merge($shppurchaseorders1,$shppurchaseorders2);
}
$_SESSION['shppurchaseorders']=$shppurchaseorders;

redirect("addpurchaseorders_proc.php?edit=1");
?>
