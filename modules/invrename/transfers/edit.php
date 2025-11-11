<?php
session_start();
require_once("../../../lib.php");

$obj=$_SESSION['obj'];
$action=$_GET['action'];
$i=$_GET['i'];
$edit=$_GET['edit'];

$shptransfers=$_SESSION['shptransfers'];

if($action=="edit"){
	$obj->itemid=$shptransfers[$i]['itemid'];
	$obj->itemname=$shptransfers[$i]['itemname'];
	$obj->serialno=$shptransfers[$i]['serialno'];
	$obj->quantity=$shptransfers[$i]['quantity'];
	$obj->itemdetailid=$shptransfers[$i]['itemdetailid'];
	$obj->costprice=$shptransfers[$i]['costprice'];
	$obj->stock=$shptransfers[$i]['stock'];
	$obj->memo=$shptransfers[$i]['memo'];
	$obj->total=$shptransfers[$i]['costprice'];

	$_SESSION['obj']=$obj;
}

$obj->iterator-=1;
//removes the identified row
$shptransfers1=array_slice($shptransfers,0,$i);
$shptransfers2=array_slice($shptransfers,$i+1);
$shptransfers=array_merge($shptransfers1,$shptransfers2);

$_SESSION['shptransfers']=$shptransfers;//print_r($_SESSION['shptransfers']);

redirect("addtransfers_proc.php?edit=1");
?>
