<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../sys/submodules/Submodules_class.php");
require_once("Shifts_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="11334";//Edit
}
else{
	$auth->roleid="11334";//Add
}
$auth->levelid=$_SESSION['level'];
auth($auth);


//connect to db
$db=new DB();
$obj=(object)$_POST;
$ob=(object)$_GET;

$mode=$_GET['mode'];
if(!empty($mode)){
	$obj->mode=$mode;
}
$id=$_GET['id'];
$error=$_GET['error'];
if(!empty($_GET['retrieve'])){
	$obj->retrieve=$_GET['retrieve'];
}
	
	
if($obj->action=="Save"){
	$shifts=new Shifts();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$shifts->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$shifts=$shifts->setObject($obj);
		if($shifts->add($shifts)){
			$error=SUCCESS;
			redirect("addshifts_proc.php?id=".$shifts->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Close Shift"){
	$shifts=new Shifts();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$shifts->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$shifts=$shifts->setObject($obj);
		if($shifts->edit($shifts)){
			$error=UPDATESUCCESS;
			
			//after closing shift, open new one
			if($obj->type=="day")
			  $obj->type="night";
			else
			  $obj->type="day";
			  
			  
			$obj->starttime=$obj->enddate;
			$obj->enddate="";
			$obj->id="";
			$shifts = new Shifts();
			$shifts=$shifts->setObject($obj);
			$shifts->add($shifts);
			
			redirect("addshifts_proc.php?id=".$shifts->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$shifts=new Shifts();
	$where=" where id=$id ";
	$fields="hos_shifts.id, hos_shifts.type, hos_shifts.starttime, hos_shifts.enddate, hos_shifts.remarks, hos_shifts.ipaddress, hos_shifts.createdby, hos_shifts.createdon, hos_shifts.lasteditedby, hos_shifts.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$shifts->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$shifts->fetchObject;

	//for autocompletes
}
if(empty($id) and empty($obj->action)){
	if(empty($_GET['edit'])){
		$obj->action="Close Shift";
		$obj->enddate=date("Y-m-d H:i:s");
	}
	else{
		$obj=$_SESSION['obj'];
	}
}	
elseif(!empty($id) and empty($obj->action)){
	$obj->action="Update";
	$obj->action="Close Shift";
	$obj->enddate=date("Y-m-d H:i:s");
}
	
	
$submodules = new Submodules();
$fields=" * ";
$join="";
$groupby="";
$having="";
$where=" where name='hos_shifts' and status=1" ;
$submodules->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$submodules=$submodules->fetchObject;
$page_title=$submodules->description;
include "addshifts.php";
?>