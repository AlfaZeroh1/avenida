<?php
session_start();
require_once("../../../lib.php");

$action=$_GET['action'];
$i=$_GET['i'];
$edit=$_GET['edit'];

$obj = preg_replace('!s:(\d+):"(.*?)";!e', "'s:'.strlen('$2').':\"$2\";'", $_GET['obj']);

$obj = str_replace("\\","",$obj);
$obj=unserialize($obj);

$shptenantpayments=$_SESSION['shptenantpayments'];

if($action=="edit"){
	$obj->paymenttermid=$shptenantpayments[$i]['paymenttermid'];
	$obj->paymenttermname=$shptenantpayments[$i]['paymenttermname'];
	$obj->total=$shptenantpayments[$i]['total'];
	$obj->amount=$shptenantpayments[$i]['amount'];
	$obj->remarks=$shptenantpayments[$i]['remarks'];
	$obj->month=$shptenantpayments[$i]['month'];
	$obj->year=$shptenantpayments[$i]['year'];
}

$obj->iterator-=1;

//removes the identified row
$shptenantpayments1=array_slice($shptenantpayments,0,$i);
$shptenantpayments2=array_slice($shptenantpayments,$i+1);
$shptenantpayments=array_merge($shptenantpayments1,$shptenantpayments2);

$_SESSION['shptenantpayments']=$shptenantpayments;

$obj = str_replace('&','',serialize($obj));
$obj = str_replace("\"","'",$obj);

redirect("addtenantpayments_proc.php?edit=1&obj=".$obj);
?>
