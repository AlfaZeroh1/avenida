<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Assetconsumables_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../assets/assets/Assets_class.php");
require_once("../../assets/consumables/Consumables_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="9399";//Edit
}
else{
	$auth->roleid="9399";//Add
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
	$assetconsumables=new Assetconsumables();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$assetconsumables->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$assetconsumables=$assetconsumables->setObject($obj);
		if($assetconsumables->add($assetconsumables)){
			$error=SUCCESS;
			redirect("addassetconsumables_proc.php?id=".$assetconsumables->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$assetconsumables=new Assetconsumables();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$assetconsumables->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$assetconsumables=$assetconsumables->setObject($obj);
		if($assetconsumables->edit($assetconsumables)){
			$error=UPDATESUCCESS;
			redirect("addassetconsumables_proc.php?id=".$assetconsumables->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$assets= new Assets();
	$fields="assets_assets.id, assets_assets.name, assets_assets.photo, assets_assets.documentno, assets_assets.categoryid, assets_assets.departmentid, assets_assets.employeeid, assets_assets.value, assets_assets.salvagevalue, assets_assets.purchasedon, assets_assets.supplierid, assets_assets.lpono, assets_assets.deliveryno, assets_assets.remarks, assets_assets.memo, assets_assets.ipaddress, assets_assets.createdby, assets_assets.createdon, assets_assets.lasteditedby, assets_assets.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$assets->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$consumables= new Consumables();
	$fields="assets_consumables.id, assets_consumables.name, assets_consumables.categoryid, assets_consumables.remarks, assets_consumables.ipaddress, assets_consumables.createdby, assets_consumables.createdon, assets_consumables.lasteditedby, assets_consumables.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$consumables->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$assetconsumables=new Assetconsumables();
	$where=" where id=$id ";
	$fields="assets_assetconsumables.id, assets_assetconsumables.assetid, assets_assetconsumables.consumableid, assets_assetconsumables.serialno, assets_assetconsumables.fittedon, assets_assetconsumables.startmileage, assets_assetconsumables.currentmileage, assets_assetconsumables.remarks, assets_assetconsumables.ipaddress, assets_assetconsumables.createdby, assets_assetconsumables.createdon, assets_assetconsumables.lasteditedby, assets_assetconsumables.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$assetconsumables->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$assetconsumables->fetchObject;

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
	
	
$page_title="Assetconsumables ";
include "addassetconsumables.php";
?>