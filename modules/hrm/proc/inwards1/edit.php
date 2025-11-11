<?php
session_start();
require_once("../../../lib.php");

$obj=$_SESSION['obj'];
$action=$_GET['action'];
$i=$_GET['i'];
$edit=$_GET['edit'];

$shpinwards=$_SESSION['shpinwards'];

if($action=="edit"){
        $obj->id=$shpinwards[$i]['id'];
	$obj->remarks=$shpinwards[$i]['remarks'];
	$obj->itemid=$shpinwards[$i]['itemid'];
	$obj->itemname=$shpinwards[$i]['itemname'];echo 
	$obj->quantity=$shpinwards[$i]['quantity'];
	$obj->costprice=$shpinwards[$i]['costprice'];
	$obj->memo=$shpinwards[$i]['memo'];
	$obj->total=$shpinwards[$i]['total'];

	$_SESSION['obj']=$obj;
}

$obj->iterator-=1;

//removes the identified row
$shpinwards1=array_slice($shpinwards,0,$i);
$shpinwards2=array_slice($shpinwards,$i+1);
$shpinwards=array_merge($shpinwards1,$shpinwards2);

$_SESSION['shpinwards']=$shpinwards;

redirect("addinwards_proc.php?edit=1");
?>
