<?php
session_start();
require_once("../../../lib.php");

$obj=$_SESSION['obj'];
$action=$_GET['action'];
$i=$_GET['i'];
$edit=$_GET['edit'];

$shpbreederdeliverys=$_SESSION['shpbreederdeliverys'];

if($action=="edit"){
	$obj->varietyid=$shpbreederdeliverys[$i]['varietyid'];
	$obj->quantity=$shpbreederdeliverys[$i]['quantity'];
	$obj->memo=$shpbreederdeliverys[$i]['memo'];

	$_SESSION['obj']=$obj;
}

$obj->iterator-=1;

//removes the identified row
$shpbreederdeliverys1=array_slice($shpbreederdeliverys,0,$i);
$shpbreederdeliverys2=array_slice($shpbreederdeliverys,$i+1);
$shpbreederdeliverys=array_merge($shpbreederdeliverys1,$shpbreederdeliverys2);

$_SESSION['shpbreederdeliverys']=$shpbreederdeliverys;

redirect("addbreederdeliverys_proc.php?edit=1");
?>
