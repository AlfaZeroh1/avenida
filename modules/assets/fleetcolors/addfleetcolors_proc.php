<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Fleetcolors_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="7628";//Edit
}
else{
	$auth->roleid="7626";//Add
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
	$fleetcolors=new Fleetcolors();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$fleetcolors->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$fleetcolors=$fleetcolors->setObject($obj);
		if($fleetcolors->add($fleetcolors)){
			$error=SUCCESS;
			redirect("addfleetcolors_proc.php?id=".$fleetcolors->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$fleetcolors=new Fleetcolors();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$fleetcolors->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$fleetcolors=$fleetcolors->setObject($obj);
		if($fleetcolors->edit($fleetcolors)){
			$error=UPDATESUCCESS;
			redirect("addfleetcolors_proc.php?id=".$fleetcolors->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$fleetcolors=new Fleetcolors();
	$where=" where id=$id ";
	$fields="assets_fleetcolors.id, assets_fleetcolors.name, assets_fleetcolors.remarks, assets_fleetcolors.ipaddress, assets_fleetcolors.createdby, assets_fleetcolors.createdon, assets_fleetcolors.lasteditedby, assets_fleetcolors.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$fleetcolors->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$fleetcolors->fetchObject;

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
	
	
$page_title="Fleetcolors ";
include "addfleetcolors.php";
?>