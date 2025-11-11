<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Purchaseorderdetails_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../inv/items/Items_class.php");
require_once("../../proc/purchaseorders/Purchaseorders_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8365";//Edit
}
else{
	$auth->roleid="8363";//Add
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
	$purchaseorderdetails=new Purchaseorderdetails();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$purchaseorderdetails->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$purchaseorderdetails=$purchaseorderdetails->setObject($obj);
		if($purchaseorderdetails->add($purchaseorderdetails)){
			$error=SUCCESS;
			redirect("addpurchaseorderdetails_proc.php?id=".$purchaseorderdetails->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$purchaseorderdetails=new Purchaseorderdetails();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$purchaseorderdetails->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$purchaseorderdetails=$purchaseorderdetails->setObject($obj);
		if($purchaseorderdetails->edit($purchaseorderdetails)){
			$error=UPDATESUCCESS;
			redirect("addpurchaseorderdetails_proc.php?id=".$purchaseorderdetails->id."&error=".$error);
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


	$purchaseorders= new Purchaseorders();
	$fields="proc_purchaseorders.id, proc_purchaseorders.projectid, proc_purchaseorders.documentno, proc_purchaseorders.requisitionno, proc_purchaseorders.supplierid, proc_purchaseorders.remarks, proc_purchaseorders.orderedon, proc_purchaseorders.file, proc_purchaseorders.createdby, proc_purchaseorders.createdon, proc_purchaseorders.lasteditedby, proc_purchaseorders.lasteditedon, proc_purchaseorders.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$purchaseorders->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$purchaseorderdetails=new Purchaseorderdetails();
	$where=" where id=$id ";
	$fields="proc_purchaseorderdetails.id, proc_purchaseorderdetails.purchaseorderid, proc_purchaseorderdetails.itemid, proc_purchaseorderdetails.quantity, proc_purchaseorderdetails.costprice, proc_purchaseorderdetails.tradeprice, proc_purchaseorderdetails.tax, proc_purchaseorderdetails.total, proc_purchaseorderdetails.memo, proc_purchaseorderdetails.ipaddress, proc_purchaseorderdetails.createdby, proc_purchaseorderdetails.createdon, proc_purchaseorderdetails.lasteditedby, proc_purchaseorderdetails.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$purchaseorderdetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$purchaseorderdetails->fetchObject;

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
	
	
$page_title="Purchaseorderdetails ";
include "addpurchaseorderdetails.php";
?>