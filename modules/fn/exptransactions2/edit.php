<?php
session_start();
require_once("../../../lib.php");

$obj=$_SESSION['obj'];
$action=$_GET['action'];
$i=$_GET['i'];
$edit=$_GET['edit'];


$shpexptransactions=$_SESSION['shpexptransactions'];

if($action=="edit"){
	$obj->expenseid=$shpexptransactions[$i]['expenseid'];
	$obj->assetid=$shpexptransactions[$i]['assetid'];
	$obj->liabilityid=$shpexptransactions[$i]['liabilityid'];
	if(!empty($obj->assetid)){
	$obj->typeid=1;
	}
	if(!empty($obj->expenseid)){
	$obj->typeid=2;
	}
	if(!empty($obj->liabilityid)){
	$obj->typeid=3;
	} 
	$obj->quantity=$shpexptransactions[$i]['quantity'];
	$obj->vatclasseid=$shpexptransactions[$i]['vatclasseid'];
	$obj->taxamount=$shpexptransactions[$i]['taxamount'];
	$obj->tax=$shpexptransactions[$i]['tax'];
	$obj->total=$shpexptransactions[$i]['total'];
	$obj->discount=$shpexptransactions[$i]['discount'];
	$obj->amount=$shpexptransactions[$i]['amount'];
	$obj->memo=$shpexptransactions[$i]['memo'];
        $obj->id=$shpexptransactions[$i]['id'];
	$_SESSION['obj']=$obj;
}

$obj->iterator-=1;

//removes the identified row
$shpexptransactions1=array_slice($shpexptransactions,0,$i);
$shpexptransactions2=array_slice($shpexptransactions,$i+1);
$shpexptransactions=array_merge($shpexptransactions1,$shpexptransactions2);

$_SESSION['shpexptransactions']=$shpexptransactions;


redirect("addexptransactions_proc.php?edit=1");
?>
