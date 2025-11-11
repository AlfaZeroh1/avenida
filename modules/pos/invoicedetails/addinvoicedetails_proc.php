<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Invoicedetails_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../pos/invoices/Invoices_class.php");
require_once("../../pos/items/Items_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8653";//Edit
}
else{
	$auth->roleid="8651";//Add
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
	$invoicedetails=new Invoicedetails();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$invoicedetails->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$invoicedetails=$invoicedetails->setObject($obj);
		if($invoicedetails->add($invoicedetails)){
			$error=SUCCESS;
			redirect("addinvoicedetails_proc.php?id=".$invoicedetails->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$invoicedetails=new Invoicedetails();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$invoicedetails->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$invoicedetails=$invoicedetails->setObject($obj);
		if($invoicedetails->edit($invoicedetails)){
			$error=UPDATESUCCESS;
			redirect("addinvoicedetails_proc.php?id=".$invoicedetails->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$invoices= new Invoices();
	$fields="pos_invoices.id, pos_invoices.documentno, pos_invoices.packingno, pos_invoices.customerid, pos_invoices.agentid, pos_invoices.remarks, pos_invoices.soldon, pos_invoices.memo, pos_invoices.createdby, pos_invoices.createdon, pos_invoices.lasteditedby, pos_invoices.lasteditedon, pos_invoices.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$invoices->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$items= new Items();
	$fields="pos_items.id, pos_items.code, pos_items.name, pos_items.departmentid, pos_items.categoryid, pos_items.costprice, pos_items.tradeprice, pos_items.retailprice, pos_items.discount, pos_items.tax, pos_items.stock, pos_items.reorderlevel, pos_items.itemstatusid, pos_items.remarks, pos_items.createdby, pos_items.createdon, pos_items.lasteditedby, pos_items.lasteditedon, pos_items.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$items->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$invoicedetails=new Invoicedetails();
	$where=" where id=$id ";
	$fields="pos_invoicedetails.id, pos_invoicedetails.invoiceid, pos_invoicedetails.itemid, pos_invoicedetails.quantity, pos_invoicedetails.price, pos_invoicedetails.discount, pos_invoicedetails.tax, pos_invoicedetails.bonus, pos_invoicedetails.profit, pos_invoicedetails.total, pos_invoicedetails.ipaddress, pos_invoicedetails.createdby, pos_invoicedetails.createdon, pos_invoicedetails.lasteditedby, pos_invoicedetails.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$invoicedetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$invoicedetails->fetchObject;

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
	
	
$page_title="Invoicedetails ";
include "addinvoicedetails.php";
?>