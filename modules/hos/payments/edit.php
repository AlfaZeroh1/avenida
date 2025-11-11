<?php
session_start();
require_once("../../../lib.php");

$obj=$_SESSION['obj'];
$action=$_GET['action'];
$i=$_GET['i'];
$edit=$_GET['edit'];

$shppayments=$_SESSION['shppayments'];

if($action=="edit"){
	$obj->transactionid=$shppayments[$i]['transactionid'];
	$obj->amount=$shppayments[$i]['amount'];
	$obj->remarks=$shppayments[$i]['remarks'];

	$_SESSION['obj']=$obj;
}

$obj->iterator-=1;

//removes the identified row
$shppayments1=array_slice($shppayments,0,$i);
$shppayments2=array_slice($shppayments,$i+1);
$shppayments=array_merge($shppayments1,$shppayments2);

$_SESSION['shppayments']=$shppayments;

redirect("addpayments_proc.php?edit=1");
?>
