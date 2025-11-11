<?php
session_start();
require_once("../../../lib.php");

$action=$_GET['action'];
$i=$_GET['i'];
$edit=$_GET['edit'];
$url=$_GET['url'];
$batch=$_GET['batch'];

$obj = preg_replace('!s:(\d+):"(.*?)";!e', "'s:'.strlen('$2').':\"$2\";'", $_GET['obj']);

$obj = str_replace("\\","",$obj);
$obj=unserialize($obj);

$shplandlordpayments=$_SESSION['shplandlordpayments'];

if($action=="edit"){
	$obj->paymenttermid=$shplandlordpayments[$i]['paymenttermid'];
	$obj->amount=$shplandlordpayments[$i]['amount'];
	$obj->plotid=$shplandlordpayments[$i]['plotid'];
	$obj->plotname=$shplandlordpayments[$i]['plotname'];
	if(!empty($batch)){
	  $obj->landlordid=$shplandlordpayments[$i]['landlordid'];
	  $obj->landlordname=$shplandlordpayments[$i]['landlordname'];
	}
	$obj->month=$shplandlordpayments[$i]['month'];
	$obj->year=$shplandlordpayments[$i]['year'];
	$obj->remarks=$shplandlordpayments[$i]['remarks'];

}

$obj->iterator-=1;

//removes the identified row
$shplandlordpayments1=array_slice($shplandlordpayments,0,$i);
$shplandlordpayments2=array_slice($shplandlordpayments,$i+1);
$shplandlordpayments=array_merge($shplandlordpayments1,$shplandlordpayments2);

$_SESSION['shplandlordpayments']=$shplandlordpayments;

$obj = str_replace('&','',serialize($obj));
$obj = str_replace("\"","'",$obj);

redirect("$url?edit=1&retrieve=1&obj=".$obj);
?>
