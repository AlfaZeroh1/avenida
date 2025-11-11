<?php
session_start();
require_once("../../../lib.php");

$obj=$_SESSION['obj'];
$action=$_GET['action'];
$i=$_GET['i'];
$edit=$_GET['edit'];

$shppurchases=$_SESSION['shppurchases'];

if($action=="edit"){
	$obj->quantity=$shppurchases[$i]['quantity'];
	$obj->itemid=$shppurchases[$i]['itemid'];
	$obj->assetid=$shppurchases[$i]['assetid'];
	$obj->assetname=$shppurchases[$i]['assetname'];
	$obj->remarks=$shppurchases[$i]['remarks'];
	$obj->inwarddetailid=$shppurchases[$i]['inwarddetailid'];

	$_SESSION['obj']=$obj;
}

$obj->iterator-=1;

//removes the identified row
$shppurchases1=array_slice($shppurchases,0,$i);
$shppurchases2=array_slice($shppurchases,$i+1);
$shppurchases=array_merge($shppurchases1,$shppurchases2);

$_SESSION['shppurchases']=$shppurchases;

redirect("addpurchases_proc.php?edit=1");
?>
