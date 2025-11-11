<?php
session_start();
require_once("../../../lib.php");

$obj=$_SESSION['obj'];
$action=$_GET['action'];
$i=$_GET['i'];
$edit=$_GET['edit'];

$shpimpresttransactions=$_SESSION['shpimpresttransactions'];

if($action=="edit"){
	$obj->expenseid=$shpimpresttransactions[$i]['expenseid'];
	$obj->quantity=$shpimpresttransactions[$i]['quantity'];
	$obj->amount=$shpimpresttransactions[$i]['amount'];
	$obj->incurredon=$shpimpresttransactions[$i]['incurredon'];
	$obj->remarks=$shpimpresttransactions[$i]['remarks'];

	$_SESSION['obj']=$obj;
}

$obj->iterator-=1;

//removes the identified row
$shpimpresttransactions1=array_slice($shpimpresttransactions,0,$i);
$shpimpresttransactions2=array_slice($shpimpresttransactions,$i+1);
$shpimpresttransactions=array_merge($shpimpresttransactions1,$shpimpresttransactions2);

$_SESSION['shpimpresttransactions']=$shpimpresttransactions;

redirect("addimpresttransactions_proc.php?edit=1");
?>
