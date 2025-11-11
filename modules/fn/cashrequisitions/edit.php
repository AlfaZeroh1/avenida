<?php
session_start();
require_once("../../../lib.php");

$obj=$_SESSION['obj'];
$action=$_GET['action'];
$i=$_GET['i'];
$edit=$_GET['edit'];

$shpcashrequisitions=$_SESSION['shpcashrequisitions'];

if($action=="edit"){
	$obj->expenseid=$shpcashrequisitions[$i]['expenseid'];
	$obj->quantity=$shpcashrequisitions[$i]['quantity'];
	$obj->amount=$shpcashrequisitions[$i]['amount'];

	$_SESSION['obj']=$obj;
}

$obj->iterator-=1;

//removes the identified row
$shpcashrequisitions1=array_slice($shpcashrequisitions,0,$i);
$shpcashrequisitions2=array_slice($shpcashrequisitions,$i+1);
$shpcashrequisitions=array_merge($shpcashrequisitions1,$shpcashrequisitions2);

$_SESSION['shpcashrequisitions']=$shpcashrequisitions;

redirect("addcashrequisitions_proc.php?edit=1");
?>
