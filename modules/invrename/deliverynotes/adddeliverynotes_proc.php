<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Deliverynotes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../fn/suppliers/Suppliers_class.php");
require_once("../../inv/items/Items_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="7500";//Edit
}
else{
	$auth->roleid="7498";//Add
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
	$deliverynotes=new Deliverynotes();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$deliverynotes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$deliverynotes=$deliverynotes->setObject($obj);
		if($deliverynotes->add($deliverynotes)){
			$error=SUCCESS;
			redirect("adddeliverynotes_proc.php?id=".$deliverynotes->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$deliverynotes=new Deliverynotes();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$deliverynotes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$deliverynotes=$deliverynotes->setObject($obj);
		if($deliverynotes->edit($deliverynotes)){
			$error=UPDATESUCCESS;
			redirect("adddeliverynotes_proc.php?id=".$deliverynotes->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$suppliers= new Suppliers();
	$fields="fn_suppliers.id, fn_suppliers.code, fn_suppliers.name, fn_suppliers.contact, fn_suppliers.physicaladdress, fn_suppliers.tel, fn_suppliers.fax, fn_suppliers.email, fn_suppliers.cellphone, fn_suppliers.status, fn_suppliers.createdby, fn_suppliers.createdon, fn_suppliers.lasteditedby, fn_suppliers.lasteditedon, fn_suppliers.suppliercategoryid";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$suppliers->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$items= new Items();
	$fields="inv_items.id, inv_items.code, inv_items.name, inv_items.departmentid, inv_items.departmentcategoryid, inv_items.categoryid, inv_items.manufacturer, inv_items.strength, inv_items.costprice, inv_items.tradeprice, inv_items.retailprice, inv_items.size, inv_items.unitofmeasureid, inv_items.vatclasseid, inv_items.generaljournalaccountid, inv_items.generaljournalaccountid2, inv_items.discount, inv_items.reorderlevel, inv_items.reorderquantity, inv_items.quantity, inv_items.reducing, inv_items.status, inv_items.createdby, inv_items.createdon, inv_items.lasteditedby, inv_items.lasteditedon, inv_items.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$items->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$deliverynotes=new Deliverynotes();
	$where=" where id=$id ";
	$fields="inv_deliverynotes.id, inv_deliverynotes.documentno, inv_deliverynotes.lpono, inv_deliverynotes.supplierid, inv_deliverynotes.deliveredon, inv_deliverynotes.itemid, inv_deliverynotes.quantity, inv_deliverynotes.remarks, inv_deliverynotes.ipaddress, inv_deliverynotes.createdby, inv_deliverynotes.createdon, inv_deliverynotes.lasteditedby, inv_deliverynotes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$deliverynotes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$deliverynotes->fetchObject;

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
	
	
$page_title="Deliverynotes ";
include "adddeliverynotes.php";
?>