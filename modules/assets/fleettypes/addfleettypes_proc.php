<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Fleettypes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="7656";//Edit
}
else{
	$auth->roleid="7654";//Add
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
	$fleettypes=new Fleettypes();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$fleettypes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$fleettypes=$fleettypes->setObject($obj);
		if($fleettypes->add($fleettypes)){
			$error=SUCCESS;
			redirect("addfleettypes_proc.php?id=".$fleettypes->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$fleettypes=new Fleettypes();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$fleettypes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$fleettypes=$fleettypes->setObject($obj);
		if($fleettypes->edit($fleettypes)){
			$error=UPDATESUCCESS;
			redirect("addfleettypes_proc.php?id=".$fleettypes->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$fleettypes=new Fleettypes();
	$where=" where id=$id ";
	$fields="assets_fleettypes.id, assets_fleettypes.name, assets_fleettypes.remarks, assets_fleettypes.ipaddress, assets_fleettypes.createdby, assets_fleettypes.createdon, assets_fleettypes.lasteditedby, assets_fleettypes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$fleettypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$fleettypes->fetchObject;

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
	
	
$page_title="Fleettypes ";
include "addfleettypes.php";
?>