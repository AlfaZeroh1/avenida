<?php
session_start();
require_once("../../../lib.php");

$action=$_GET['action'];
$i=$_GET['i'];
$edit=$_GET['edit'];

$obj = preg_replace('!s:(\d+):"(.*?)";!e', "'s:'.strlen('$2').':\"$2\";'", $_GET['obj']);

$obj=unserialize($obj);

$shpplotexpenses=$_SESSION['shpplotexpenses'];

if($action=="edit"){
	$obj->expenseid=$shpplotexpenses[$i]['expenseid'];
	$obj->quantity=$shpplotexpenses[$i]['quantity'];
	$obj->amount=$shpplotexpenses[$i]['amount'];
	$obj->total=$shpplotexpenses[$i]['total'];
	$obj->remarks=$shpplotexpenses[$i]['remarks'];
}


$obj->iterator-=1;

//removes the identified row
$shpplotexpenses1=array_slice($shpplotexpenses,0,$i);
$shpplotexpenses2=array_slice($shpplotexpenses,$i+1);
$shpplotexpenses=array_merge($shpplotexpenses1,$shpplotexpenses2);

$_SESSION['shpplotexpenses']=$shpplotexpenses;

$obj = str_replace('&','',serialize($obj));
$obj = str_replace("\"","'",$obj);

redirect("addplotexpenses_proc.php?retrieve=1&edit=1&obj=".$obj);
?>
