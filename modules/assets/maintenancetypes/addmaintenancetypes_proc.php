<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Maintenancetypes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8983";//Edit
}
else{
	$auth->roleid="8981";//Add
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
	$maintenancetypes=new Maintenancetypes();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$maintenancetypes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$maintenancetypes=$maintenancetypes->setObject($obj);
		if($maintenancetypes->add($maintenancetypes)){
			$error=SUCCESS;
			redirect("addmaintenancetypes_proc.php?id=".$maintenancetypes->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$maintenancetypes=new Maintenancetypes();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$maintenancetypes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$maintenancetypes=$maintenancetypes->setObject($obj);
		if($maintenancetypes->edit($maintenancetypes)){
			$error=UPDATESUCCESS;
			redirect("addmaintenancetypes_proc.php?id=".$maintenancetypes->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$maintenancetypes=new Maintenancetypes();
	$where=" where id=$id ";
	$fields="assets_maintenancetypes.id, assets_maintenancetypes.name, assets_maintenancetypes.duration, assets_maintenancetypes.durationtype, assets_maintenancetypes.remarks, assets_maintenancetypes.ipaddress, assets_maintenancetypes.createdby, assets_maintenancetypes.createdon, assets_maintenancetypes.lasteditedby, assets_maintenancetypes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$maintenancetypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$maintenancetypes->fetchObject;

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
	
	
$page_title="Maintenancetypes ";
include "addmaintenancetypes.php";
?>