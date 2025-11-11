<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Breakdowns_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="7616";//Edit
}
else{
	$auth->roleid="7614";//Add
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
	$breakdowns=new Breakdowns();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$breakdowns->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$breakdowns=$breakdowns->setObject($obj);
		if($breakdowns->add($breakdowns)){
			$error=SUCCESS;
			redirect("addbreakdowns_proc.php?id=".$breakdowns->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$breakdowns=new Breakdowns();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$breakdowns->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$breakdowns=$breakdowns->setObject($obj);
		if($breakdowns->edit($breakdowns)){
			$error=UPDATESUCCESS;
			redirect("addbreakdowns_proc.php?id=".$breakdowns->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$breakdowns=new Breakdowns();
	$where=" where id=$id ";
	$fields="assets_breakdowns.id, assets_breakdowns.assetid, assets_breakdowns.description, assets_breakdowns.brokedownon, assets_breakdowns.reactivatedon, assets_breakdowns.cost, assets_breakdowns.refno, assets_breakdowns.remarks, assets_breakdowns.ipaddress, assets_breakdowns.createdby, assets_breakdowns.createdon, assets_breakdowns.lasteditedby, assets_breakdowns.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$breakdowns->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$breakdowns->fetchObject;

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
	
	
$page_title="Breakdowns ";
include "addbreakdowns.php";
?>