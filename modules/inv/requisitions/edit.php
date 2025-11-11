<?php
session_start();
require_once("../../../lib.php");

$obj=$_SESSION['obj'];
$action=$_GET['action'];
$i=$_GET['i'];
$edit=$_GET['edit'];

$shprequisitions=$_SESSION['shprequisitions'];

if($action=="edit"){
	$obj->itemid=$shprequisitions[$i]['itemid'];
	$obj->quantity=$shprequisitions[$i]['quantity'];
	$obj->aquantity=$shprequisitions[$i]['aquantity'];
	$obj->memo=$shprequisitions[$i]['memo'];

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
