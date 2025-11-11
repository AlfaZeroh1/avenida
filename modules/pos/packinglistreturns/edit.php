<?php
session_start();
require_once("../../../lib.php");

$obj=$_SESSION['obj'];
$action=$_GET['action'];
$i=$_GET['i'];
$edit=$_GET['edit'];

$shppackinglists=$_SESSION['shppackinglists'];

if($action=="edit"){
	$obj->remarks=$shppackinglists[$i]['remarks'];
	$obj->itemid=$shppackinglists[$i]['itemid'];
	$obj->quantity=$shppackinglists[$i]['quantity'];
	$obj->memo=$shppackinglists[$i]['memo'];

	$_SESSION['obj']=$obj;
}

$obj->iterator-=1;

//removes the identified row
$shppackinglists1=array_slice($shppackinglists,0,$i);
$shppackinglists2=array_slice($shppackinglists,$i+1);
$shppackinglists=array_merge($shppackinglists1,$shppackinglists2);

$_SESSION['shppackinglists']=$shppackinglists;

redirect("addpackinglists_proc.php?edit=1");
?>
