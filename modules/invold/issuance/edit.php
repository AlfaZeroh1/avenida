<?php
session_start();
require_once("../../../lib.php");

$obj=$_SESSION['obj'];
$action=$_GET['action'];
$i=$_GET['i'];
$edit=$_GET['edit'];

$shpissuance=$_SESSION['shpissuance'];

if($action=="edit"){
	$obj->quantity=$shpissuance[$i]['quantity'];
	$obj->remarks=$shpissuance[$i]['remarks'];
	$obj->itemid=$shpissuance[$i]['itemid'];
	$obj->itemname=$shpissuance[$i]['itemname'];
	$obj->costprice=$shpissuance[$i]['costprice'];
	$obj->code=$shpissuance[$i]['code'];
	$obj->total=$shpissuance[$i]['total'];

	$_SESSION['obj']=$obj;
}

$obj->iterator-=1;

//removes the identified row
$shpissuance1=array_slice($shpissuance,0,$i);
$shpissuance2=array_slice($shpissuance,$i+1);
$shpissuance=array_merge($shpissuance1,$shpissuance2);

$_SESSION['shpissuance']=$shpissuance;

redirect("addissuance_proc.php?edit=1");
?>
