<?php
session_start();
require_once("../../../lib.php");

$obj=$_SESSION['obj'];
$action=$_GET['action'];
$i=$_GET['i'];
$edit=$_GET['edit'];

$shppaymentvouchers=$_SESSION['shppaymentvouchers'];

if($action=="edit"){
	$obj->cashrequisitionid=$shppaymentvouchers[$i]['cashrequisitionid'];
	$obj->paymentrequisitionid=$shppaymentvouchers[$i]['paymentrequisitionid'];
	$obj->amount=$shppaymentvouchers[$i]['amount'];
	$obj->remarks=$shppaymentvouchers[$i]['remarks'];

	$_SESSION['obj']=$obj;
}

$obj->iterator-=1;

//removes the identified row
$shppaymentvouchers1=array_slice($shppaymentvouchers,0,$i);
$shppaymentvouchers2=array_slice($shppaymentvouchers,$i+1);
$shppaymentvouchers=array_merge($shppaymentvouchers1,$shppaymentvouchers2);

$_SESSION['shppaymentvouchers']=$shppaymentvouchers;

redirect("addpaymentvouchers_proc.php?edit=1");
?>
