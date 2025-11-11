<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Requisitiondetails_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../proc/requisitions/Requisitions_class.php");
require_once("../../inv/items/Items_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8369";//Edit
}
else{
	$auth->roleid="8367";//Add
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

	$requisitions= new Requisitions();
	$fields="proc_requisitions.id, proc_requisitions.documentno, proc_requisitions.type, proc_requisitions.projectid, proc_requisitions.requisitiondate, proc_requisitions.remarks, proc_requisitions.status, proc_requisitions.file, proc_requisitions.ipaddress, proc_requisitions.createdby, proc_requisitions.createdon, proc_requisitions.lasteditedby, proc_requisitions.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$requisitions->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$items= new Items();
	$fields="inv_items.id, inv_items.code, inv_items.name, inv_items.departmentid, inv_items.departmentcategoryid, inv_items.categoryid, inv_items.manufacturer, inv_items.strength, inv_items.costprice, inv_items.tradeprice, inv_items.retailprice, inv_items.size, inv_items.unitofmeasureid, inv_items.vatclasseid, inv_items.generaljournalaccountid, inv_items.generaljournalaccountid2, inv_items.discount, inv_items.reorderlevel, inv_items.reorderquantity, inv_items.quantity, inv_items.reducing, inv_items.status, inv_items.createdby, inv_items.createdon, inv_items.lasteditedby, inv_items.lasteditedon, inv_items.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$items->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$requisitiondetails=new Requisitiondetails();
	$where=" where id=$id ";
	$fields="proc_requisitiondetails.id, proc_requisitiondetails.requisitionid, proc_requisitiondetails.itemid, proc_requisitiondetails.quantity, proc_requisitiondetails.costprice, proc_requisitiondetails.total, proc_requisitiondetails.memo, proc_requisitiondetails.requiredon, proc_requisitiondetails.ipaddress, proc_requisitiondetails.createdby, proc_requisitiondetails.createdon, proc_requisitiondetails.lasteditedby, proc_requisitiondetails.lasteditedon";
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