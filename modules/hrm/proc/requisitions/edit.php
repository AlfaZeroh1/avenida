<?php
session_start();
require_once("../../../lib.php");

$obj=$_SESSION['obj'];
$action=$_GET['action'];
$i=$_GET['i'];
$edit=$_GET['edit'];

$shprequisitions=$_SESSION['shprequisitions'];

if($action=="edit"){
	$obj->remarks=$shprequisitions[$i]['remarks'];
	$obj->itemid=$shprequisitions[$i]['itemid'];
	$obj->itemid=$shprequisitions[$i]['itemid'];
	$obj->itemname=$shprequisitions[$i]['itemname'];
	$obj->categoryid=$shprequisitions[$i]['categoryid'];
	$obj->assetname=$shprequisitions[$i]['assetname'];
	if(!empty($obj->itemid))
	{
	$obj->typeid=2;
	}else{
	$obj->typeid=1;
	}
	$obj->itemname=$shprequisitions[$i]['itemname'];
	$obj->quantity=$shprequisitions[$i]['quantity'];
	$obj->requiredon=$shprequisitions[$i]['requiredon'];
	$obj->costprice=$shprequisitions[$i]['costprice'];
	$obj->total=$shprequisitions[$i]['total'];

	$_SESSION['obj']=$obj;
}

$obj->iterator-=1;

//removes the identified row
$shprequisitions1=array_slice($shprequisitions,0,$i);
$shprequisitions2=array_slice($shprequisitions,$i+1);
$shprequisitions=array_merge($shprequisitions1,$shprequisitions2);

$_SESSION['shprequisitions']=$shprequisitions;

redirect("addrequisitions_proc.php?edit=1");
?>
