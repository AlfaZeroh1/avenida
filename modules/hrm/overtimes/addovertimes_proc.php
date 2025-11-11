<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Overtimes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="9392";//Edit
}
else{
	$auth->roleid="9392";//Add
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
	$overtimes=new Overtimes();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$overtimes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$overtimes=$overtimes->setObject($obj);
		if($overtimes->add($overtimes)){
			$error=SUCCESS;
			redirect("addovertimes_proc.php?id=".$overtimes->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$overtimes=new Overtimes();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$overtimes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$overtimes=$overtimes->setObject($obj);
		if($overtimes->edit($overtimes)){
			$error=UPDATESUCCESS;
			redirect("addovertimes_proc.php?id=".$overtimes->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$overtimes=new Overtimes();
	$where=" where id=$id ";
	$fields="hrm_overtimes.id, hrm_overtimes.name, hrm_overtimes.value, hrm_overtimes.remarks, hrm_overtimes.ipaddress, hrm_overtimes.createdby, hrm_overtimes.createdon, hrm_overtimes.lasteditedby, hrm_overtimes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$overtimes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$overtimes->fetchObject;

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
	
	
$page_title="Overtimes ";
include "addovertimes.php";
?>