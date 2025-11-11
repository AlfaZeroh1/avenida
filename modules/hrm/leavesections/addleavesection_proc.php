<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Leavesection_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4243";//Edit
}
else{
	$auth->roleid="4241";//Add
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
$sectionid=$_GET['sectionid'];
$error=$_GET['error'];
if(!empty($_GET['retrieve'])){
	$obj->retrieve=$_GET['retrieve'];
}
	
	
if($obj->action=="Save"){
	$leavesection=new Leavesection();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$leavesection->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$leavesection=$leavesection->setObject($obj);
		if($leavesection->add($leavesection)){
			$error=SUCCESS;
			redirect("addleavesection_proc.php?id=".$leavesection->sectionid."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$leavesection=new Leavesection();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$leavesection->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$leavesection=$leavesection->setObject($obj);
		if($leavesection->edit($leavesection)){
			$error=UPDATESUCCESS;
			redirect("addleavesection_proc.php?id=".$leavesection->sectionid."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(!empty($id)){
	$leavesection=new Leavesection();
	$where=" where id=$id ";
	$fields="hrm_leavesections.sectionid, hrm_leavesections.sectionname,hrm_leavesections.createdby, hrm_leavesections.createdon, hrm_leavesections.lasteditedby, hrm_leavesections.lasteditedon, hrm_leavesections.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$leavesection->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$leavesection->fetchObject;

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
	
	
$page_title="Leavesection ";
include "addleavesection.php";
?>