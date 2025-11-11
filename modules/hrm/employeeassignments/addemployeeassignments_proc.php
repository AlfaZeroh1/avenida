<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Employeeassignments_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="1125";//Edit
}
else{
	$auth->roleid="1123";//Add
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
	
	
if($obj->action=="Save"){
	$employeeassignments=new Employeeassignments();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$employeeassignments->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$employeeassignments=$employeeassignments->setObject($obj);
		if($employeeassignments->add($employeeassignments)){
			$error=SUCCESS;
			redirect("addemployeeassignments_proc.php?id=".$employeeassignments->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$employeeassignments=new Employeeassignments();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$employeeassignments->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$employeeassignments=$employeeassignments->setObject($obj);
		if($employeeassignments->edit($employeeassignments)){
			$error=UPDATESUCCESS;
			redirect("addemployeeassignments_proc.php?id=".$employeeassignments->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$employeeassignments=new Employeeassignments();
	$where=" where id=$id ";
	$fields="hrm_employeeassignments.id, hrm_employeeassignments.employeeid, hrm_employeeassignments.assignmentid, hrm_employeeassignments.fromdate, hrm_employeeassignments.todate, hrm_employeeassignments.createdby, hrm_employeeassignments.createdon, hrm_employeeassignments.lasteditedby, hrm_employeeassignments.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employeeassignments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$employeeassignments->fetchObject;

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
	
	
$page_title="Employeeassignments ";
include "addemployeeassignments.php";
?>