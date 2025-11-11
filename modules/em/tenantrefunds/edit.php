<?php
session_start();
require_once("../../../lib.php");

$obj=$_SESSION['obj'];
$action=$_GET['action'];
$i=$_GET['i'];
$edit=$_GET['edit'];

$shptenantrefunds=$_SESSION['shptenantrefunds'];

if($action=="edit"){
	$obj->paymenttermid=$shptenantrefunds[$i]['paymenttermid'];
	$obj->amount=$shptenantrefunds[$i]['amount'];
	$obj->houseid=$shptenantrefunds[$i]['houseid'];
	$obj->month=$shptenantrefunds[$i]['month'];
	$obj->year=$shptenantrefunds[$i]['year'];
	$obj->remarks=$shptenantrefunds[$i]['remarks'];

	$_SESSION['obj']=$obj;
}

$obj->iterator-=1;

//removes the identified row
$shptenantrefunds1=array_slice($shptenantrefunds,0,$i);
$shptenantrefunds2=array_slice($shptenantrefunds,$i+1);
$shptenantrefunds=array_merge($shptenantrefunds1,$shptenantrefunds2);

$_SESSION['shptenantrefunds']=$shptenantrefunds;

redirect("addtenantrefunds_proc.php?edit=1");
?>
