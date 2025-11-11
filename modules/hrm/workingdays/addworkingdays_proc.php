<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../sys/submodules/Submodules_class.php");
require_once("Workingdays_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="1199";//Edit
}
else{
	$auth->roleid="1197";//Add
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
	$workingdays=new Workingdays();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$workingdays->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$workingdays=$workingdays->setObject($obj);
		if($workingdays->add($workingdays)){
			$error=SUCCESS;
			redirect("addworkingdays_proc.php?id=".$workingdays->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$workingdays=new Workingdays();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$workingdays->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$workingdays=$workingdays->setObject($obj);
		if($workingdays->edit($workingdays)){
			$error=UPDATESUCCESS;
			redirect("addworkingdays_proc.php?id=".$workingdays->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$workingdays=new Workingdays();
	$where=" where id=$id ";
	$fields="hrm_workingdays.id, hrm_workingdays.name, hrm_workingdays.remarks, hrm_workingdays.ipaddress, hrm_workingdays.createdby, hrm_workingdays.createdon, hrm_workingdays.lasteditedby, hrm_workingdays.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$workingdays->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$workingdays->fetchObject;

	//for autocompletes
}
if(empty($id) and empty($obj->action)){
	if(empty($_GET['edit'])){
		$obj->action="Save";
	}
	else{
		$obj=$_SESSION['obj'];
	}
}	
elseif(!empty($id) and empty($obj->action)){
	$obj->action="Update";
}
	
	
$submodules = new Submodules();
$fields=" * ";
$join="";
$groupby="";
$having="";
$where=" where name='hrm_workingdays' and status=1" ;
$submodules->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$submodules=$submodules->fetchObject;
$page_title=$submodules->description;
include "addworkingdays.php";
?>