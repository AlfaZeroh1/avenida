<?php
session_start();
require_once("../../../lib.php");

$obj=$_SESSION['obj'];
$action=$_GET['action'];
$i=$_GET['i'];
$edit=$_GET['edit'];

$shpdeliverynotes=$_SESSION['shpdeliverynotes'];

if($action=="edit"){
	$obj->remarks=$shpdeliverynotes[$i]['remarks'];
	$obj->itemid=$shpdeliverynotes[$i]['itemid'];
	$obj->itemname=$shpdeliverynotes[$i]['itemname'];
	$obj->quantity=$shpdeliverynotes[$i]['quantity'];
	$obj->costprice=$shpdeliverynotes[$i]['costprice'];
	$obj->total=$shpdeliverynotes[$i]['total'];

	$_SESSION['obj']=$obj;
}

$obj->iterator-=1;

//removes the identified row
$shpdeliverynotes1=array_slice($shpdeliverynotes,0,$i);
$shpdeliverynotes2=array_slice($shpdeliverynotes,$i+1);
$shpdeliverynotes=array_merge($shpdeliverynotes1,$shpdeliverynotes2);

$_SESSION['shpdeliverynotes']=$shpdeliverynotes;

redirect("adddeliverynotes_proc.php?edit=1");
?>
