<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Freights_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8997";//Edit
}
else{
	$auth->roleid="8997";//Add
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
	$freights=new Freights();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$freights->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$freights=$freights->setObject($obj);
		if($freights->add($freights)){
			$error=SUCCESS;
			redirect("addfreights_proc.php?id=".$freights->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$freights=new Freights();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$freights->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$freights=$freights->setObject($obj);
		if($freights->edit($freights)){
			$error=UPDATESUCCESS;
			redirect("addfreights_proc.php?id=".$freights->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$freights=new Freights();
	$where=" where id=$id ";
	$fields="pos_freights.id, pos_freights.name, pos_freights.remarks, pos_freights.ipaddress, pos_freights.createdby, pos_freights.createdon, pos_freights.lasteditedby, pos_freights.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$freights->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$freights->fetchObject;

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
	
	
$page_title="Freights ";
include "addfreights.php";
?>