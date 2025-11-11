<?php
session_start();
require_once("../../../lib.php");

$obj=$_SESSION['obj'];
$action=$_GET['action'];
$i=$_GET['i'];
$edit=$_GET['edit'];

$shpsaleorders=$_SESSION['shpsaleorders'];

if($action=="edit"){
	$obj->quantity=$shpsaleorders[$i]['quantity'];
	$obj->itemid=$shpsaleorders[$i]['itemid'];
	$obj->itemname=$shpsaleorders[$i]['itemname'];
	$obj->code=$shpsaleorders[$i]['code'];
	$obj->stock=$shpsaleorders[$i]['stock'];
	$obj->tax=$shpsaleorders[$i]['tax'];
	$obj->discount=$shpsaleorders[$i]['discount'];
	$obj->retailprice=$shpsaleorders[$i]['retailprice'];
	$obj->tradeprice=$shpsaleorders[$i]['tradeprice'];
	$obj->total=$shpsaleorders[$i]['total'];

	$_SESSION['obj']=$obj;
}

$obj->iterator-=1;

//removes the identified row
$shpsaleorders1=array_slice($shpsaleorders,0,$i);
$shpsaleorders2=array_slice($shpsaleorders,$i+1);
$shpsaleorders=array_merge($shpsaleorders1,$shpsaleorders2);

$_SESSION['shpsaleorders']=$shpsaleorders;

redirect("addsaleorders_proc.php?edit=1");
?>
