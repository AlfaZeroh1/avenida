<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Levels_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="7476";//Edit
}
else{
	$auth->roleid="7474";//Add
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
	$levels=new Levels();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$levels->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$levels=$levels->setObject($obj);
		if($levels->add($levels)){
			$error=SUCCESS;
			//window.location.reload();
			redirect("addlevels_proc.php?id=".$levels->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$levels=new Levels();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$levels->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$levels=$levels->setObject($obj);
		if($levels->edit($levels)){
			$error=UPDATESUCCESS;
			redirect("addlevels_proc.php?id=".$levels->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$levels=new Levels();
	$where=" where id=$id ";
	$fields="hrm_levels.id, hrm_levels.name, hrm_levels.overallno, hrm_levels.deptno, hrm_levels.follows, hrm_levels.remarks, hrm_levels.ipaddress, hrm_levels.createdby, hrm_levels.createdon, hrm_levels.lasteditedby, hrm_levels.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$levels->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$levels->fetchObject;

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
	
	
$page_title="Levels ";
include "addlevels.php";
?>