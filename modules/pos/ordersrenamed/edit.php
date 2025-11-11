<?php
session_start();
require_once("../../../lib.php");

$obj=$_SESSION['obj'];
$action=$_GET['action'];
$i=$_GET['i'];
$edit=$_GET['edit'];

$shporders=$_SESSION['shporders'];

if($action=="edit"){
	$obj->itemid=$shporders[$i]['itemid'];
	$obj->sizeid=$shporders[$i]['sizeid'];
	$obj->itemname=$shporders[$i]['itemname'];
	$obj->total=$shporders[$i]['total'];
	$obj->quantity=$shporders[$i]['quantity'];
	$obj->memo=$shporders[$i]['memo'];
	
	$_SESSION['obj']=$obj;
}

$obj->iterator-=1;

//removes the identified row
$shporders1=array_slice($shporders,0,$i);
$shporders2=array_slice($shporders,$i+1);
$shporders=array_merge($shporders1,$shporders2);

$_SESSION['shporders']=$shporders;

redirect("addorders_proc.php?edit=1");
?>
