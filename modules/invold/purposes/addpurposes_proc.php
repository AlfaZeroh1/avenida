<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../sys/submodules/Submodules_class.php");
require_once("Purposes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="704";//Edit
}
else{
	$auth->roleid="704";//Add
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
	$purposes=new Purposes();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$purposes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$purposes=$purposes->setObject($obj);
		if($purposes->add($purposes)){
			$error=SUCCESS;
			redirect("addpurposes_proc.php?id=".$purposes->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$purposes=new Purposes();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$purposes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$purposes=$purposes->setObject($obj);
		if($purposes->edit($purposes)){
			$error=UPDATESUCCESS;
			redirect("addpurposes_proc.php?id=".$purposes->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$purposes=new Purposes();
	$where=" where id=$id ";
	$fields="inv_purposes.id, inv_purposes.name, inv_purposes.remarks, inv_purposes.createdby, inv_purposes.createdon, inv_purposes.lasteditedby, inv_purposes.lasteditedon, inv_purposes.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$purposes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$purposes->fetchObject;

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
$where=" where name='inv_purposes' and status=1" ;
$submodules->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$submodules=$submodules->fetchObject;
$page_title=$submodules->description;
include "addpurposes.php";
?>