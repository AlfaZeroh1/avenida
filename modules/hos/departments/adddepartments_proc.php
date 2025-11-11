<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Departments_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4491";//Edit
}
else{
	$auth->roleid="4491";//Add
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
	$departments=new Departments();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$departments->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$departments=$departments->setObject($obj);
		if($departments->add($departments)){
			$error=SUCCESS;
			redirect("adddepartments_proc.php?id=".$departments->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$departments=new Departments();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$departments->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$departments=$departments->setObject($obj);
		if($departments->edit($departments)){
			$error=UPDATESUCCESS;
			redirect("adddepartments_proc.php?id=".$departments->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$departments=new Departments();
	$where=" where id=$id ";
	$fields="hos_departments.id, hos_departments.name, hos_departments.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$departments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$departments->fetchObject;

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
	
	
$page_title="Departments ";
include "adddepartments.php";
?>