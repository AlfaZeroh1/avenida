<?php
session_start();
require_once("../../../lib.php");

$obj=$_SESSION['obj'];
$action=$_GET['action'];
$i=$_GET['i'];
$edit=$_GET['edit'];

$shpimprests=$_SESSION['shpimprests'];

if($action=="edit"){

        $obj->imprestaccountid=$shpimprests[$i]['imprestaccountid'];
        $obj->imprestaccountname=$shpimprests[$i]['imprestaccountname'];
        $obj->employeeid=$shpimprests[$i]['employeeid'];
        $obj->employeename=$shpimprests[$i]['employeename'];
        $obj->amount=$shpimprests[$i]['amount'];
        $obj->remarks=$shpimprests[$i]['remarks'];
       // $obj->id=$shpimprests[$i]['id'];
	$_SESSION['obj']=$obj;
}

$obj->iterator-=1;

//removes the identified row
$shpimprests1=array_slice($shpimprests,0,$i);
$shpimprests2=array_slice($shpimprests,$i+1);
$shpimprests=array_merge($shpimprests1,$shpimprests2);

$_SESSION['shpimprests']=$shpimprests;


redirect("addimprests_proc.php?edit=1");
?>
