<?php
session_start();
require_once("../../../lib.php");

$obj=$_SESSION['obj'];
$action=$_GET['action'];
$i=$_GET['i'];
$edit=$_GET['edit'];

$shpconfirmedorders=$_SESSION['shpconfirmedorders'];

if($action=="edit"){
	$obj->itemid=$shpconfirmedorders[$i]['itemid'];
	$obj->sizeid=$shpconfirmedorders[$i]['sizeid'];
	$obj->quantity=$shpconfirmedorders[$i]['quantity'];
	$obj->memo=$shpconfirmedorders[$i]['memo'];

	$_SESSION['obj']=$obj;
}

$obj->iterator-=1;

//removes the identified row
$shpconfirmedorders1=array_slice($shpconfirmedorders,0,$i);
$shpconfirmedorders2=array_slice($shpconfirmedorders,$i+1);
$shpconfirmedorders=array_merge($shpconfirmedorders1,$shpconfirmedorders2);

$_SESSION['shpconfirmedorders']=$shpconfirmedorders;

redirect("addconfirmedorders_proc.php?edit=1");
?>
