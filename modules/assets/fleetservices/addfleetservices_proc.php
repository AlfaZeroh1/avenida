<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Fleetservices_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="7652";//Edit
}
else{
	$auth->roleid="7650";//Add
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
	$fleetservices=new Fleetservices();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$fleetservices->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$fleetservices=$fleetservices->setObject($obj);
		if($fleetservices->add($fleetservices)){
			$error=SUCCESS;
			redirect("addfleetservices_proc.php?id=".$fleetservices->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$fleetservices=new Fleetservices();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$fleetservices->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$fleetservices=$fleetservices->setObject($obj);
		if($fleetservices->edit($fleetservices)){
			$error=UPDATESUCCESS;
			redirect("addfleetservices_proc.php?id=".$fleetservices->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$fleetservices=new Fleetservices();
	$where=" where id=$id ";
	$fields="assets_fleetservices.id, assets_fleetservices.fleetid, assets_fleetservices.description, assets_fleetservices.supplierid, assets_fleetservices.cost, assets_fleetservices.odometer, assets_fleetservices.remarks, assets_fleetservices.ipaddress, assets_fleetservices.createdby, assets_fleetservices.createdon, assets_fleetservices.lasteditedby, assets_fleetservices.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$fleetservices->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$fleetservices->fetchObject;

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
	
	
$page_title="Fleetservices ";
include "addfleetservices.php";
?>