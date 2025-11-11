<?php
session_start();
require_once("../../../lib.php");

$obj=$_SESSION['obj'];
$action=$_GET['action'];
$i=$_GET['i'];
$edit=$_GET['edit'];

$shpassets=$_SESSION['shpassets'];

if($action=="edit"){
	$obj->name=$shpassets[$i]['name'];
	$obj->photo=$shpassets[$i]['photo'];
	$obj->categoryid=$shpassets[$i]['categoryid'];
	$obj->value=$shpassets[$i]['value'];
	$obj->salvagevalue=$shpassets[$i]['salvagevalue'];
	$obj->deliveryno=$shpassets[$i]['deliveryno'];
	$obj->remarks=$shpassets[$i]['remarks'];

	$_SESSION['obj']=$obj;
}

$obj->iterator-=1;

//removes the identified row
$shpassets1=array_slice($shpassets,0,$i);
$shpassets2=array_slice($shpassets,$i+1);
$shpassets=array_merge($shpassets1,$shpassets2);

$_SESSION['shpassets']=$shpassets;

redirect("addassets_proc.php?edit=1");
?>
