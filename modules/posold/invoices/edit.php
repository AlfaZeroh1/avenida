<?php
session_start();
require_once("../../../lib.php");

$obj=$_SESSION['obj'];
$action=$_GET['action'];
$i=$_GET['i'];
$edit=$_GET['edit'];

$shpconsumables=$_SESSION['shpconsumables'];//print_r($shpconsumables);

if($action=="edit"){
	$obj->itemid=$shpconsumables[$i]['itemid'];
	$obj->itemname=$shpconsumables[$i]['itemname'];
	$obj->unitofmeasureid=$shpconsumables[$i]['unitofmeasureid'];
	$obj->unitofmeasurename=$shpconsumables[$i]['unitofmeasurename'];
	$obj->quantity=$shpconsumables[$i]['quantity'];
	$obj->price=$shpconsumables[$i]['price'];
        $obj->total=$shpconsumables[$i]['total'];
        
	$_SESSION['obj']=$obj;
}

$obj->iterators-=1;;

//removes the identified row
$shpconsumables1=array_slice($shpconsumables,0,$i);
$shpconsumables2=array_slice($shpconsumables,$i+1);
$shpconsumables=array_merge($shpconsumables1,$shpconsumables2);

$_SESSION['shpconsumables']=$shpconsumables;//print_r($shpconsumables);echo $obj->iterators;

redirect("addinvoices_proc.php?edit=1");
?>
