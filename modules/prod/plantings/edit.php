<?php
session_start();
require_once("../../../lib.php");

$obj=$_SESSION['obj'];
$action=$_GET['action'];
$i=$_GET['i'];
$edit=$_GET['edit'];

$shpplantings=$_SESSION['shpplantings'];

if($action=="edit"){
	$obj->varietyid=$shpplantings[$i]['varietyid'];
	$obj->areaid=$shpplantings[$i]['areaid'];
	$obj->quantity=$shpplantings[$i]['quantity'];
	$obj->memo=$shpplantings[$i]['memo'];

	$_SESSION['obj']=$obj;
}

$obj->iterator-=1;

//removes the identified row
$shpplantings1=array_slice($shpplantings,0,$i);
$shpplantings2=array_slice($shpplantings,$i+1);
$shpplantings=array_merge($shpplantings1,$shpplantings2);

$_SESSION['shpplantings']=$shpplantings;

redirect("addplantings_proc.php?edit=1");
?>
