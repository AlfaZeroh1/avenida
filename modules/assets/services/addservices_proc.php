<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Services_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../assets/assets/Assets_class.php");
require_once("../../assets/serviceschedules/Serviceschedules_class.php");
require_once("../../proc/suppliers/Suppliers_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="7709";//Edit
}
else{
	$auth->roleid="7707";//Add
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
	$services=new Services();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$services->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$services=$services->setObject($obj);
		if($services->add($services)){
			$error=SUCCESS;
			redirect("addservices_proc.php?id=".$services->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$services=new Services();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$services->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$services=$services->setObject($obj);
		if($services->edit($services)){
			$error=UPDATESUCCESS;
			redirect("addservices_proc.php?id=".$services->id."&error=".$error);
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


	$serviceschedules= new Serviceschedules();
	$fields="assets_serviceschedules.id, assets_serviceschedules.assetid, assets_serviceschedules.servicedate, assets_serviceschedules.servicetypeid, assets_serviceschedules.description, assets_serviceschedules.recommendations, assets_serviceschedules.remarks, assets_serviceschedules.ipaddress, assets_serviceschedules.createdby, assets_serviceschedules.createdon, assets_serviceschedules.lasteditedby, assets_serviceschedules.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$serviceschedules->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$suppliers= new Suppliers();
	$fields="proc_suppliers.id, proc_suppliers.code, proc_suppliers.name, proc_suppliers.suppliercategoryid, proc_suppliers.regionid, proc_suppliers.subregionid, proc_suppliers.contact, proc_suppliers.physicaladdress, proc_suppliers.tel, proc_suppliers.fax, proc_suppliers.email, proc_suppliers.cellphone, proc_suppliers.status, proc_suppliers.createdby, proc_suppliers.createdon, proc_suppliers.lasteditedby, proc_suppliers.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$suppliers->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$services=new Services();
	$where=" where id=$id ";
	$fields="assets_services.id, assets_services.assetid, assets_services.servicescheduleid, assets_services.supplierid, assets_services.documentno, assets_services.servicedon, assets_services.servicetype, assets_services.description, assets_services.recommendations, assets_services.remarks, assets_services.ipaddress, assets_services.createdby, assets_services.createdon, assets_services.lasteditedby, assets_services.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$services->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$services->fetchObject;

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
	
	
$page_title="Services ";
include "addservices.php";
?>