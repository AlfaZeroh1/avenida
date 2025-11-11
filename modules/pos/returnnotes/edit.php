<?php
session_start();
require_once("../../../lib.php");

$obj=$_SESSION['obj'];
$action=$_GET['action'];
$i=$_GET['i'];
$edit=$_GET['edit'];

$shpreturnnotes=$_SESSION['shpreturnnotes'];

if($action=="edit"){
	$obj->itemid=$shpreturnnotes[$i]['itemid'];
	$obj->itemname=$shpreturnnotes[$i]['itemname'];
	$obj->total=$shpreturnnotes[$i]['total'];
	$obj->quantity=$shpreturnnotes[$i]['quantity'];
	$obj->costprice=$shpreturnnotes[$i]['costprice'];
	$obj->tax=$shpreturnnotes[$i]['tax'];
	$obj->discount=$shpreturnnotes[$i]['discount'];
	$obj->total=$shpreturnnotes[$i]['total'];
	$obj->remarks=$shpreturnnotes[$i]['remarks'];

	$_SESSION['obj']=$obj;
}

$obj->iterator-=1;

//removes the identified row
$shpreturnnotes1=array_slice($shpreturnnotes,0,$i);
$shpreturnnotes2=array_slice($shpreturnnotes,$i+1);
$shpreturnnotes=array_merge($shpreturnnotes1,$shpreturnnotes2);

$_SESSION['shpreturnnotes']=$shpreturnnotes;

redirect("addreturnnotes_proc.php?edit=1");
?>
