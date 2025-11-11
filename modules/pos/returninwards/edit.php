<?php
session_start();
require_once("../../../lib.php");

$obj=$_SESSION['obj'];
$action=$_GET['action'];
$i=$_GET['i'];
$edit=$_GET['edit'];

$shpreturninwards=$_SESSION['shpreturninwards'];

if($action=="edit"){
	$obj->itemid=$shpreturninwards[$i]['itemid'];
	$obj->quantity=$shpreturninwards[$i]['quantity'];
	$obj->price=$shpreturninwards[$i]['price'];
	$obj->discount=$shpreturninwards[$i]['discount'];
	$obj->bonus=$shpreturninwards[$i]['bonus'];

	$_SESSION['obj']=$obj;
}

$obj->iterator-=1;

//removes the identified row
$shpreturninwards1=array_slice($shpreturninwards,0,$i);
$shpreturninwards2=array_slice($shpreturninwards,$i+1);
$shpreturninwards=array_merge($shpreturninwards1,$shpreturninwards2);

$_SESSION['shpreturninwards']=$shpreturninwards;

redirect("addreturninwards_proc.php?edit=1");
?>
