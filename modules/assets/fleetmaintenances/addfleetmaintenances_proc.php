<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Fleetmaintenances_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../assets/assets/Assets_class.php");
require_once("../../proc/suppliers/Suppliers_class.php");
require_once("../../sys/purchasemodes/Purchasemodes_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8471";//Edit
}
else{
	$auth->roleid="8471";//Add
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
	$fleetmaintenances=new Fleetmaintenances();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$fleetmaintenances->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$fleetmaintenances=$fleetmaintenances->setObject($obj);
		if($fleetmaintenances->add($fleetmaintenances)){
			$error=SUCCESS;
			redirect("addfleetmaintenances_proc.php?id=".$fleetmaintenances->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$fleetmaintenances=new Fleetmaintenances();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$fleetmaintenances->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$fleetmaintenances=$fleetmaintenances->setObject($obj);
		if($fleetmaintenances->edit($fleetmaintenances)){
			$error=UPDATESUCCESS;
			redirect("addfleetmaintenances_proc.php?id=".$fleetmaintenances->id."&error=".$error);
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


	$suppliers= new Suppliers();
	$fields="proc_suppliers.id, proc_suppliers.code, proc_suppliers.name, proc_suppliers.suppliercategoryid, proc_suppliers.regionid, proc_suppliers.subregionid, proc_suppliers.contact, proc_suppliers.physicaladdress, proc_suppliers.tel, proc_suppliers.fax, proc_suppliers.email, proc_suppliers.cellphone, proc_suppliers.status, proc_suppliers.createdby, proc_suppliers.createdon, proc_suppliers.lasteditedby, proc_suppliers.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$suppliers->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$purchasemodes= new Purchasemodes();
	$fields="sys_purchasemodes.id, sys_purchasemodes.name, sys_purchasemodes.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$purchasemodes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$fleetmaintenances=new Fleetmaintenances();
	$where=" where id=$id ";
	$fields="assets_fleetmaintenances.id, assets_fleetmaintenances.assetid, assets_fleetmaintenances.maintenanceon, assets_fleetmaintenances.startmileage, assets_fleetmaintenances.endmileage, assets_fleetmaintenances.supplierid, assets_fleetmaintenances.purchasemodeid, assets_fleetmaintenances.oiladded, assets_fleetmaintenances.oilcost, assets_fleetmaintenances.fueladded, assets_fleetmaintenances.fuelcost, assets_fleetmaintenances.remarks, assets_fleetmaintenances.ipaddress, assets_fleetmaintenances.createdby, assets_fleetmaintenances.createdon, assets_fleetmaintenances.lasteditedby, assets_fleetmaintenances.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$fleetmaintenances->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$fleetmaintenances->fetchObject;

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
	
	
$page_title="Fleetmaintenances ";
include "addfleetmaintenances.php";
?>