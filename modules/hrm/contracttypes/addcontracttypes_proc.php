<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Contracttypes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4183";//Edit
}
else{
	$auth->roleid="4181";//Add
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
	$contracttypes=new Contracttypes();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$contracttypes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$contracttypes=$contracttypes->setObject($obj);
		if($contracttypes->add($contracttypes)){
			$error=SUCCESS;
			redirect("addcontracttypes_proc.php?id=".$contracttypes->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$contracttypes=new Contracttypes();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$contracttypes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$contracttypes=$contracttypes->setObject($obj);
		if($contracttypes->edit($contracttypes)){
			$error=UPDATESUCCESS;
			redirect("addcontracttypes_proc.php?id=".$contracttypes->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$contracttypes=new Contracttypes();
	$where=" where id=$id ";
	$fields="hrm_contracttypes.id, hrm_contracttypes.name, hrm_contracttypes.remarks, hrm_contracttypes.createdby, hrm_contracttypes.createdon, hrm_contracttypes.lasteditedby, hrm_contracttypes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$contracttypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$contracttypes->fetchObject;

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
	
	
$page_title="Contracttypes ";
include "addcontracttypes.php";
?>