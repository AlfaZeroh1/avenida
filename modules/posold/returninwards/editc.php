<?php
session_start();
require_once("../../../lib.php");


$obj=$_SESSION['obj'];
$action=$_GET['action'];
$i=$_GET['i'];
$edit=$_GET['edit'];

$obj = preg_replace('!s:(\d+):"(.*?)";!e', "'s:'.strlen('$2').':\"$2\";'", $_GET['obj']);

$obj = str_replace("\\","",$obj);
$obj=unserialize($obj);

$shpconsumables=$_SESSION['shpconsumables'];

if($action=="edit"){
        $obj->itemname=$shpconsumables[$i]['itemname'];
	$obj->itemid=$shpconsumables[$i]['itemid'];
	$obj->quantity=$shpconsumables[$i]['quantity'];
	$obj->price=$shpconsumables[$i]['price'];
	$obj->discount=$shpconsumables[$i]['discount'];
	$obj->bonus=$shpconsumables[$i]['bonus'];
}

$obj->iterators-=1;

//removes the identified row
$shpconsumables1=array_slice($shpconsumables,0,$i);
$shpconsumables2=array_slice($shpconsumables,$i+1);
$shpconsumables=array_merge($shpconsumables1,$shpconsumables2);

$_SESSION['shpconsumables']=$shpconsumables;


$obj = str_replace('&','',serialize($obj));
$obj = str_replace("\"","'",$obj);

redirect("addreturninwards_proc.php?edit=1&obj=".$obj);
?>
