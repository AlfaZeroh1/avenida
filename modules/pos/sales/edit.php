<?php
session_start();
require_once("../../../lib.php");

$obj=$_SESSION['obj'];
$action=$_GET['action'];
$i=$_GET['i'];
$edit=$_GET['edit'];

$shpsales=$_SESSION['shpsales'];

if($action=="edit"){
	$obj->quantity=$shpsales[$i]['quantity'];
	$obj->itemid=$shpsales[$i]['itemid'];
	$obj->memo=$shpsales[$i]['memo'];

	$_SESSION['obj']=$obj;
}

$obj->iterator-=1;

//removes the identified row
$shpsales1=array_slice($shpsales,0,$i);
$shpsales2=array_slice($shpsales,$i+1);
$shpsales=array_merge($shpsales1,$shpsales2);

$_SESSION['shpsales']=$shpsales;print_r($_SESSION['shpsales']);

//redirect("addsales_proc.php?edit=1");
?>
