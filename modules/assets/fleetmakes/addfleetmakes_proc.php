<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Fleetmakes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="7636";//Edit
}
else{
	$auth->roleid="7634";//Add
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
	$fleetmakes=new Fleetmakes();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$fleetmakes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$fleetmakes=$fleetmakes->setObject($obj);
		if($fleetmakes->add($fleetmakes)){
			$error=SUCCESS;
			redirect("addfleetmakes_proc.php?id=".$fleetmakes->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$fleetmakes=new Fleetmakes();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$fleetmakes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$fleetmakes=$fleetmakes->setObject($obj);
		if($fleetmakes->edit($fleetmakes)){
			$error=UPDATESUCCESS;
			redirect("addfleetmakes_proc.php?id=".$fleetmakes->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$fleetmakes=new Fleetmakes();
	$where=" where id=$id ";
	$fields="assets_fleetmakes.id, assets_fleetmakes.name, assets_fleetmakes.remarks, assets_fleetmakes.ipaddress, assets_fleetmakes.createdby, assets_fleetmakes.createdon, assets_fleetmakes.lasteditedby, assets_fleetmakes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$fleetmakes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$fleetmakes->fetchObject;

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
	
	
$page_title="Fleetmakes ";
include "addfleetmakes.php";
?>