<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Inspections_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../assets/assets/Assets_class.php");
require_once("../../assets/inspectionitems/Inspectionitems_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8483";//Edit
}
else{
	$auth->roleid="8483";//Add
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
	$inspections=new Inspections();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$inspections->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$inspections=$inspections->setObject($obj);
		if($inspections->add($inspections)){
			$error=SUCCESS;
			redirect("addinspections_proc.php?id=".$inspections->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$inspections=new Inspections();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$inspections->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$inspections=$inspections->setObject($obj);
		if($inspections->edit($inspections)){
			$error=UPDATESUCCESS;
			redirect("addinspections_proc.php?id=".$inspections->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$assets= new Assets();
	$fields="assets_assets.id, assets_assets.name, assets_assets.photo, assets_assets.documentno, assets_assets.categoryid, assets_assets.value, assets_assets.salvagevalue, assets_assets.purchasedon, assets_assets.supplierid, assets_assets.lpono, assets_assets.deliveryno, assets_assets.remarks, assets_assets.memo, assets_assets.ipaddress, assets_assets.createdby, assets_assets.createdon, assets_assets.lasteditedby, assets_assets.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$assets->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$inspectionitems= new Inspectionitems();
	$fields="assets_inspectionitems.id, assets_inspectionitems.name, assets_inspectionitems.categoryid, assets_inspectionitems.remarks, assets_inspectionitems.ipaddress, assets_inspectionitems.createdby, assets_inspectionitems.createdon, assets_inspectionitems.lasteditedby, assets_inspectionitems.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$inspectionitems->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$inspections=new Inspections();
	$where=" where id=$id ";
	$fields="assets_inspections.id, assets_inspections.assetid, assets_inspections.inspectionitemid, assets_inspections.value, assets_inspections.remarks, assets_inspections.inspectedon, assets_inspections.ipaddress, assets_inspections.createdby, assets_inspections.createdon, assets_inspections.lasteditedby, assets_inspections.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$inspections->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$inspections->fetchObject;

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
	
	
$page_title="Inspections ";
include "addinspections.php";
?>