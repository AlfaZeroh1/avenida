<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Requisitiondetails_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../inv/items/Items_class.php");
require_once("../../prod/blocks/Blocks_class.php");
require_once("../../prod/sections/Sections_class.php");
require_once("../../prod/greenhouses/Greenhouses_class.php");
require_once("../../assets/fleets/Fleets_class.php");

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="9431";//Edit
}
else{
	$auth->roleid="9429";//Add
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
	$requisitiondetails=new Requisitiondetails();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$requisitiondetails->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$requisitiondetails=$requisitiondetails->setObject($obj);
		if($requisitiondetails->add($requisitiondetails)){
			$error=SUCCESS;
			redirect("addrequisitiondetails_proc.php?id=".$requisitiondetails->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$requisitiondetails=new Requisitiondetails();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$requisitiondetails->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$requisitiondetails=$requisitiondetails->setObject($obj);
		if($requisitiondetails->edit($requisitiondetails)){
			$error=UPDATESUCCESS;
			redirect("addrequisitiondetails_proc.php?id=".$requisitiondetails->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$items= new Items();
	$fields="inv_items.id, inv_items.code, inv_items.name, inv_items.departmentid, inv_items.departmentcategoryid, inv_items.categoryid, inv_items.manufacturer, inv_items.strength, inv_items.costprice, inv_items.tradeprice, inv_items.retailprice, inv_items.size, inv_items.unitofmeasureid, inv_items.vatclasseid, inv_items.generaljournalaccountid, inv_items.generaljournalaccountid2, inv_items.discount, inv_items.reorderlevel, inv_items.reorderquantity, inv_items.quantity, inv_items.reducing, inv_items.status, inv_items.createdby, inv_items.createdon, inv_items.lasteditedby, inv_items.lasteditedon, inv_items.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$items->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$blocks= new Blocks();
	$fields="prod_blocks.id, prod_blocks.name, prod_blocks.length, prod_blocks.width, prod_blocks.remarks, prod_blocks.ipaddress, prod_blocks.createdby, prod_blocks.createdon, prod_blocks.lasteditedby, prod_blocks.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$blocks->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$sections= new Sections();
	$fields="prod_sections.id, prod_sections.name, prod_sections.blockid, prod_sections.employeeid, prod_sections.remarks, prod_sections.ipaddress, prod_sections.createdby, prod_sections.createdon, prod_sections.lasteditedby, prod_sections.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$sections->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$greenhouses= new Greenhouses();
	$fields="prod_greenhouses.id, prod_greenhouses.name, prod_greenhouses.sectionid, prod_greenhouses.remarks, prod_greenhouses.ipaddress, prod_greenhouses.createdby, prod_greenhouses.createdon, prod_greenhouses.lasteditedby, prod_greenhouses.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$greenhouses->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$requisitiondetails=new Requisitiondetails();
	$where=" where id=$id ";
	$fields="inv_requisitiondetails.id, inv_requisitiondetails.requisitionid, inv_requisitiondetails.itemid, inv_requisitiondetails.quantity, inv_requisitiondetails.aquantity, inv_requisitiondetails.purpose, inv_requisitiondetails.memo, inv_requisitiondetails.blockid, inv_requisitiondetails.sectionid, inv_requisitiondetails.greenhouseid, inv_requisitiondetails.ipaddress, inv_requisitiondetails.createdby, inv_requisitiondetails.createdon, inv_requisitiondetails.lasteditedby, inv_requisitiondetails.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$requisitiondetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$requisitiondetails->fetchObject;

	//for autocompletes
	$items = new Items();
	$fields=" * ";
	$where=" where id='$obj->itemid'";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$items->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$auto=$items->fetchObject;

	$obj->itemname=$auto->name;
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
	
	
$page_title="Requisitiondetails ";
include "addrequisitiondetails.php";
?>