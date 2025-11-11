<?php
session_start();
require_once("../../../lib.php");

$obj=$_SESSION['obj'];
$action=$_GET['action'];
$i=$_GET['i'];
$edit=$_GET['edit'];

$shpgraded=$_SESSION['shpgraded'];

if($action=="edit"){
	$obj->sizeid=$shpgraded[$i]['sizeid'];
	$obj->varietyid=$shpgraded[$i]['varietyid'];
	$obj->quantity=$shpgraded[$i]['quantity'];
	$obj->employeeid=$shpgraded[$i]['employeeid'];
	$obj->employeename=$shpgraded[$i]['employeename'];
	$obj->total=$shpgraded[$i]['total'];

	$_SESSION['obj']=$obj;
}

$obj->iterator-=1;

//removes the identified row
$shpgraded1=array_slice($shpgraded,0,$i);
$shpgraded2=array_slice($shpgraded,$i+1);
$shpgraded=array_merge($shpgraded1,$shpgraded2);

$_SESSION['shpgraded']=$shpgraded;

redirect("addgraded_proc.php?edit=1");
?>
