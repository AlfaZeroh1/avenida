<?php
session_start();
require_once("../../../lib.php");

$action=$_GET['action'];
$i=$_GET['i'];
$edit=$_GET['edit'];

$obj = preg_replace('!s:(\d+):"(.*?)";!e', "'s:'.strlen('$2').':\"$2\";'", $_GET['obj']);

$obj=unserialize($obj);

$shppayables=$_SESSION['shppayables'];

if($action=="edit"){
	$obj->paymenttermid=$shppayables[$i]['paymenttermid'];
	$obj->paymenttermname=$shppayables[$i]['paymenttermname'];
	$obj->total=$shppayables[$i]['total'];
	$obj->quantity=$shppayables[$i]['quantity'];
	$obj->amount=$shppayables[$i]['amount'];
	$obj->remarks=$shppayables[$i]['remarks'];

}

$obj->iterator-=1;

//removes the identified row
$shppayables1=array_slice($shppayables,0,$i);
$shppayables2=array_slice($shppayables,$i+1);
$shppayables=array_merge($shppayables1,$shppayables2);

$_SESSION['shppayables']=$shppayables;

$obj = str_replace('&','',serialize($obj));
$obj = str_replace("\"","'",$obj);

redirect("addpayables_proc.php?edit=1&retrieve=1&obj=".$obj);
?>
