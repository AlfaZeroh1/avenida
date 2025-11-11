<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Insurers_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="7664";//Edit
}
else{
	$auth->roleid="7662";//Add
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
	$insurers=new Insurers();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$insurers->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$insurers=$insurers->setObject($obj);
		if($insurers->add($insurers)){
			$error=SUCCESS;
			redirect("addinsurers_proc.php?id=".$insurers->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$insurers=new Insurers();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$insurers->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$insurers=$insurers->setObject($obj);
		if($insurers->edit($insurers)){
			$error=UPDATESUCCESS;
			redirect("addinsurers_proc.php?id=".$insurers->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$insurers=new Insurers();
	$where=" where id=$id ";
	$fields="assets_insurers.id, assets_insurers.name, assets_insurers.physicaladdress, assets_insurers.contactperson, assets_insurers.contacttel, assets_insurers.remarks, assets_insurers.ipaddress, assets_insurers.createdby, assets_insurers.createdon, assets_insurers.lasteditedby, assets_insurers.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$insurers->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$insurers->fetchObject;

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
	
	
$page_title="Insurers ";
include "addinsurers.php";
?>