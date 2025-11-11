<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Schedulers_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="1187";//Edit
}
else{
	$auth->roleid="1185";//Add
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
	$schedulers=new Schedulers();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$schedulers->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$schedulers=$schedulers->setObject($obj);
		if($schedulers->add($schedulers)){
			$error=SUCCESS;
			redirect("addschedulers_proc.php?id=".$schedulers->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$schedulers=new Schedulers();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$schedulers->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$schedulers=$schedulers->setObject($obj);
		if($schedulers->edit($schedulers)){
			$error=UPDATESUCCESS;
			redirect("addschedulers_proc.php?id=".$schedulers->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$schedulers=new Schedulers();
	$where=" where id=$id ";
	$fields="hrm_schedulers.id, hrm_schedulers.employeeid, hrm_schedulers.assignmentid, hrm_schedulers.scheduledate, hrm_schedulers.remarks, hrm_schedulers.createby, hrm_schedulers.createdon, hrm_schedulers.lasteditedby, hrm_schedulers.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$schedulers->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$schedulers->fetchObject;

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
	
	
$page_title="Schedulers ";
include "addschedulers.php";
?>