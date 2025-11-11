<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../sys/submodules/Submodules_class.php");
require_once("Leavesections_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="9984";//Edit
}
else{
	$auth->roleid="9982";//Add
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
	$leavesections=new Leavesections();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$leavesections->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$leavesections=$leavesections->setObject($obj);
		if($leavesections->add($leavesections)){
			$error=SUCCESS;
			redirect("addleavesections_proc.php?id=".$leavesections->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$leavesections=new Leavesections();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$leavesections->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$leavesections=$leavesections->setObject($obj);
		if($leavesections->edit($leavesections)){
			$error=UPDATESUCCESS;
			redirect("addleavesections_proc.php?id=".$leavesections->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$leavesections=new Leavesections();
	$where=" where id=$id ";
	$fields="hrm_leavesections.id, hrm_leavesections.name, hrm_leavesections.remarks, hrm_leavesections.ipaddress, hrm_leavesections.createdby, hrm_leavesections.createdon, hrm_leavesections.lasteditedby, hrm_leavesections.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$leavesections->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$leavesections->fetchObject;

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
$where=" where name='hrm_leavesections' and status=1" ;
$submodules->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$submodules=$submodules->fetchObject;
$page_title=$submodules->description;
include "addleavesections.php";
?>