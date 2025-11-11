<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../sys/submodules/Submodules_class.php");
require_once("Employeeoffs_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="12041";//Edit
}
else{
	$auth->roleid="12041";//Add
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
	$employeeoffs=new Employeeoffs();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$employeeoffs->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$employeeoffs=$employeeoffs->setObject($obj);
		if($employeeoffs->add($employeeoffs)){
			$error=SUCCESS;
			redirect("addemployeeoffs_proc.php?id=".$employeeoffs->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$employeeoffs=new Employeeoffs();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$employeeoffs->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$employeeoffs=$employeeoffs->setObject($obj);
		if($employeeoffs->edit($employeeoffs)){
			$error=UPDATESUCCESS;
			redirect("addemployeeoffs_proc.php?id=".$employeeoffs->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$employeeoffs=new Employeeoffs();
	$where=" where id=$id ";
	$fields="hrm_employeeoffs.id, hrm_employeeoffs.employeeid, hrm_employeeoffs.day, hrm_employeeoffs.ipaddress, hrm_employeeoffs.createdby, hrm_employeeoffs.createdon, hrm_employeeoffs.lasteditedby, hrm_employeeoffs.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employeeoffs->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$employeeoffs->fetchObject;

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
$where=" where name='hrm_employeeoffs' and status=1" ;
$submodules->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$submodules=$submodules->fetchObject;
$page_title=$submodules->description;
include "addemployeeoffs.php";
?>