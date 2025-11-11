<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Maintenanceschedules_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../assets/maintenancetypes/Maintenancetypes_class.php");
require_once("../../assets/assets/Assets_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8979";//Edit
}
else{
	$auth->roleid="8977";//Add
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
	$maintenanceschedules=new Maintenanceschedules();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$maintenanceschedules->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$maintenanceschedules=$maintenanceschedules->setObject($obj);
		if($maintenanceschedules->add($maintenanceschedules)){
			$error=SUCCESS;
			redirect("addmaintenanceschedules_proc.php?id=".$maintenanceschedules->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$maintenanceschedules=new Maintenanceschedules();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$maintenanceschedules->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$maintenanceschedules=$maintenanceschedules->setObject($obj);
		if($maintenanceschedules->edit($maintenanceschedules)){
			$error=UPDATESUCCESS;
			redirect("addmaintenanceschedules_proc.php?id=".$maintenanceschedules->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$maintenancetypes= new Maintenancetypes();
	$fields="assets_maintenancetypes.id, assets_maintenancetypes.name, assets_maintenancetypes.duration, assets_maintenancetypes.durationtype, assets_maintenancetypes.remarks, assets_maintenancetypes.ipaddress, assets_maintenancetypes.createdby, assets_maintenancetypes.createdon, assets_maintenancetypes.lasteditedby, assets_maintenancetypes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$maintenancetypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$assets= new Assets();
	$fields="assets_assets.id, assets_assets.name, assets_assets.photo, assets_assets.documentno, assets_assets.categoryid, assets_assets.departmentid, assets_assets.employeeid, assets_assets.value, assets_assets.salvagevalue, assets_assets.purchasedon, assets_assets.supplierid, assets_assets.lpono, assets_assets.deliveryno, assets_assets.remarks, assets_assets.memo, assets_assets.ipaddress, assets_assets.createdby, assets_assets.createdon, assets_assets.lasteditedby, assets_assets.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$assets->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$maintenanceschedules=new Maintenanceschedules();
	$where=" where id=$id ";
	$fields="assets_maintenanceschedules.id, assets_maintenanceschedules.maintenancetypeid, assets_maintenanceschedules.assetid, assets_maintenanceschedules.nextinspection, assets_maintenanceschedules.remarks, assets_maintenanceschedules.ipaddress, assets_maintenanceschedules.createdby, assets_maintenanceschedules.createdon, assets_maintenanceschedules.lasteditedby, assets_maintenanceschedules.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$maintenanceschedules->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$maintenanceschedules->fetchObject;

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
	
	
$page_title="Maintenanceschedules ";
include "addmaintenanceschedules.php";
?>