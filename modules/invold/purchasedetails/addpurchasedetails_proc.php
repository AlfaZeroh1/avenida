<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Purchasedetails_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../inv/items/Items_class.php");
require_once("../../inv/assets/Assets_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8373";//Edit
}
else{
	$auth->roleid="8371";//Add
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
	$purchasedetails=new Purchasedetails();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$purchasedetails->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$purchasedetails=$purchasedetails->setObject($obj);
		if($purchasedetails->add($purchasedetails)){
			$error=SUCCESS;
			redirect("addpurchasedetails_proc.php?id=".$purchasedetails->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$purchasedetails=new Purchasedetails();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$purchasedetails->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$purchasedetails=$purchasedetails->setObject($obj);
		if($purchasedetails->edit($purchasedetails)){
			$error=UPDATESUCCESS;
			redirect("addpurchasedetails_proc.php?id=".$purchasedetails->id."&error=".$error);
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

}

if(!empty($id)){
	$purchasedetails=new Purchasedetails();
	$where=" where id=$id ";
	$fields="inv_purchasedetails.id, inv_purchasedetails.purchaseid, inv_purchasedetails.itemid, inv_purchasedetails.quantity, inv_purchasedetails.costprice, inv_purchasedetails.discount, inv_purchasedetails.tax, inv_purchasedetails.bonus, inv_purchasedetails.total, inv_purchasedetails.memo, inv_purchasedetails.ipaddress, inv_purchasedetails.createdby, inv_purchasedetails.createdon, inv_purchasedetails.lasteditedby, inv_purchasedetails.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$purchasedetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$purchasedetails->fetchObject;

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
	
	
$page_title="Purchasedetails ";
include "addpurchasedetails.php";
?>