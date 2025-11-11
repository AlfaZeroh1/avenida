<?php
session_start();
require_once("../../../lib.php");

$obj=$_SESSION['obj'];
$action=$_GET['action'];
$i=$_GET['i'];
$edit=$_GET['edit'];

$shpquotations=$_SESSION['shpquotations'];

if($action=="edit"){
	$obj->quantity=$shpquotations[$i]['quantity'];
	$obj->itemid=$shpquotations[$i]['itemid'];
	$obj->itemname=$shpquotations[$i]['itemname'];
	$obj->code=$shpquotations[$i]['code'];
	$obj->tax=$shpquotations[$i]['tax'];
	$obj->discount=$shpquotations[$i]['discount'];
	$obj->retailprice=$shpquotations[$i]['retailprice'];
	$obj->tradeprice=$shpquotations[$i]['tradeprice'];
	$obj->total=$shpquotations[$i]['total'];

	$_SESSION['obj']=$obj;
}

$obj->iterator-=1;

//removes the identified row
$shpquotations1=array_slice($shpquotations,0,$i);
$shpquotations2=array_slice($shpquotations,$i+1);
$shpquotations=array_merge($shpquotations1,$shpquotations2);

$_SESSION['shpquotations']=$shpquotations;

redirect("addquotations_proc.php?edit=1");
?>
