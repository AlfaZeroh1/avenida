<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Serviceschedules_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../assets/servicetypes/Servicetypes_class.php");
require_once("../../assets/assets/Assets_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="7713";//Edit
}
else{
	$auth->roleid="7711";//Add
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
	$serviceschedules=new Serviceschedules();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$serviceschedules->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$serviceschedules=$serviceschedules->setObject($obj);
		if($serviceschedules->add($serviceschedules)){
			$error=SUCCESS;
			redirect("addserviceschedules_proc.php?id=".$serviceschedules->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$serviceschedules=new Serviceschedules();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$serviceschedules->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$serviceschedules=$serviceschedules->setObject($obj);
		if($serviceschedules->edit($serviceschedules)){
			$error=UPDATESUCCESS;
			redirect("addserviceschedules_proc.php?id=".$serviceschedules->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$servicetypes= new Servicetypes();
	$fields="assets_servicetypes.id, assets_servicetypes.name, assets_servicetypes.duration, assets_servicetypes.durationtype, assets_servicetypes.remarks, assets_servicetypes.ipaddress, assets_servicetypes.createdby, assets_servicetypes.createdon, assets_servicetypes.lasteditedby, assets_servicetypes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$servicetypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$assets= new Assets();
	$fields="assets_assets.id, assets_assets.name, assets_assets.photo, assets_assets.documentno, assets_assets.categoryid, assets_assets.value, assets_assets.salvagevalue, assets_assets.purchasedon, assets_assets.supplierid, assets_assets.lpono, assets_assets.deliveryno, assets_assets.remarks, assets_assets.memo, assets_assets.ipaddress, assets_assets.createdby, assets_assets.createdon, assets_assets.lasteditedby, assets_assets.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$assets->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$serviceschedules=new Serviceschedules();
	$where=" where id=$id ";
	$fields="assets_serviceschedules.id, assets_serviceschedules.assetid, assets_serviceschedules.servicedate, assets_serviceschedules.servicetypeid, assets_serviceschedules.description, assets_serviceschedules.recommendations, assets_serviceschedules.remarks, assets_serviceschedules.ipaddress, assets_serviceschedules.createdby, assets_serviceschedules.createdon, assets_serviceschedules.lasteditedby, assets_serviceschedules.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$serviceschedules->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$serviceschedules->fetchObject;

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
	
	
$page_title="Serviceschedules ";
include "addserviceschedules.php";
?>