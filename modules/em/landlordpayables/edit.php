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

$shplandlordpayables=$_SESSION['shplandlordpayables'];

if($action=="edit"){
	$obj->paymenttermid=$shplandlordpayables[$i]['paymenttermid'];
	$obj->amount=$shplandlordpayables[$i]['amount'];
	$obj->plotid=$shplandlordpayables[$i]['plotid'];
	$obj->plotname=$shplandlordpayables[$i]['plotname'];
	if(!empty($batch)){
	  $obj->landlordid=$shplandlordpayables[$i]['landlordid'];
	  $obj->landlordname=$shplandlordpayables[$i]['landlordname'];
	}
	$obj->month=$shplandlordpayables[$i]['month'];
	$obj->year=$shplandlordpayables[$i]['year'];
	$obj->remarks=$shplandlordpayables[$i]['remarks'];

}

$obj->iterator-=1;

//removes the identified row
$shplandlordpayables1=array_slice($shplandlordpayables,0,$i);
$shplandlordpayables2=array_slice($shplandlordpayables,$i+1);
$shplandlordpayables=array_merge($shplandlordpayables1,$shplandlordpayables2);

$_SESSION['shplandlordpayables']=$shplandlordpayables;

$obj = str_replace('&','',serialize($obj));
$obj = str_replace("\"","'",$obj);

redirect("$url?edit=1&retrieve=1&obj=".$obj);
?>
