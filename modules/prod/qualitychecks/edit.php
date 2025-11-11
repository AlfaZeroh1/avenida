<?php
session_start();
require_once("../../../lib.php");

$obj=$_SESSION['obj'];
$action=$_GET['action'];
$i=$_GET['i'];
$edit=$_GET['edit'];

$shpqualitychecks=$_SESSION['shpqualitychecks'];

if($action=="edit"){
	$obj->checkitemid=$shpqualitychecks[$i]['checkitemid'];
	$obj->varietyid=$shpqualitychecks[$i]['varietyid'];
	$obj->findings=$shpqualitychecks[$i]['findings'];
	$obj->remarks=$shpqualitychecks[$i]['remarks'];

	$_SESSION['obj']=$obj;
}

$obj->iterator-=1;

//removes the identified row
$shpqualitychecks1=array_slice($shpqualitychecks,0,$i);
$shpqualitychecks2=array_slice($shpqualitychecks,$i+1);
$shpqualitychecks=array_merge($shpqualitychecks1,$shpqualitychecks2);

$_SESSION['shpqualitychecks']=$shpqualitychecks;

redirect("addqualitychecks_proc.php?edit=1");
?>
