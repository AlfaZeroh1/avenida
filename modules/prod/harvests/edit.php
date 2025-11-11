<?php
session_start();
require_once("../../../lib.php");

$obj=$_SESSION['obj'];
$action=$_GET['action'];
$i=$_GET['i'];
$edit=$_GET['edit'];

$shpharvests=$_SESSION['shpharvests'];

if($action=="edit"){
	$obj->varietyid=$shpharvests[$i]['varietyid'];
	$obj->sizeid=$shpharvests[$i]['sizeid'];
	$obj->plantingdetailid=$shpharvests[$i]['plantingdetailid'];
	$obj->greenhouseid=$shpharvests[$i]['greenhouseid'];
	$obj->quantity=$shpharvests[$i]['quantity'];

	$_SESSION['obj']=$obj;
}

$obj->iterator-=1;

//removes the identified row
$shpharvests1=array_slice($shpharvests,0,$i);
$shpharvests2=array_slice($shpharvests,$i+1);
$shpharvests=array_merge($shpharvests1,$shpharvests2);

$_SESSION['shpharvests']=$shpharvests;

redirect("addharvests_proc.php?edit=1");
?>
