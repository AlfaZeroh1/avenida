<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Fleetodometertypes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="7644";//Edit
}
else{
	$auth->roleid="7642";//Add
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
	$fleetodometertypes=new Fleetodometertypes();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$fleetodometertypes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$fleetodometertypes=$fleetodometertypes->setObject($obj);
		if($fleetodometertypes->add($fleetodometertypes)){
			$error=SUCCESS;
			redirect("addfleetodometertypes_proc.php?id=".$fleetodometertypes->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$fleetodometertypes=new Fleetodometertypes();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$fleetodometertypes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$fleetodometertypes=$fleetodometertypes->setObject($obj);
		if($fleetodometertypes->edit($fleetodometertypes)){
			$error=UPDATESUCCESS;
			redirect("addfleetodometertypes_proc.php?id=".$fleetodometertypes->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$fleetodometertypes=new Fleetodometertypes();
	$where=" where id=$id ";
	$fields="assets_fleetodometertypes.id, assets_fleetodometertypes.name, assets_fleetodometertypes.remarks, assets_fleetodometertypes.ipaddress, assets_fleetodometertypes.createdby, assets_fleetodometertypes.createdon, assets_fleetodometertypes.lasteditedby, assets_fleetodometertypes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$fleetodometertypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$fleetodometertypes->fetchObject;

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
	
	
$page_title="Fleetodometertypes ";
include "addfleetodometertypes.php";
?>