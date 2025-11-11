<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Fleetaccidents_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="7624";//Edit
}
else{
	$auth->roleid="7622";//Add
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
	$fleetaccidents=new Fleetaccidents();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$fleetaccidents->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	
	else{
		$fleetaccidents=$fleetaccidents->setObject($obj);
		if($fleetaccidents->add($fleetaccidents)){
			$error=SUCCESS;
			redirect("addfleetaccidents_proc.php?id=".$fleetaccidents->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$fleetaccidents=new Fleetaccidents();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$fleetaccidents->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$fleetaccidents=$fleetaccidents->setObject($obj);
		if($fleetaccidents->edit($fleetaccidents)){
			$error=UPDATESUCCESS;
			redirect("addfleetaccidents_proc.php?id=".$fleetaccidents->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$fleetaccidents=new Fleetaccidents();
	$where=" where id=$id ";
	$fields="assets_fleetaccidents.id, assets_fleetaccidents.fleetid, assets_fleetaccidents.description, assets_fleetaccidents.accidentdate, assets_fleetaccidents.ipaddress, assets_fleetaccidents.createdby, assets_fleetaccidents.createdon, assets_fleetaccidents.lasteditedby, assets_fleetaccidents.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$fleetaccidents->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$fleetaccidents->fetchObject;

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
	
	
$page_title="Fleetaccidents ";
include "addfleetaccidents.php";
?>