<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Saledetails_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../pos/sales/Sales_class.php");
require_once("../../inv/items/Items_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8333";//Edit
}
else{
	$auth->roleid="8331";//Add
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
	$saledetails=new Saledetails();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$saledetails->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$saledetails=$saledetails->setObject($obj);
		if($saledetails->add($saledetails)){
			$error=SUCCESS;
			redirect("addsaledetails_proc.php?id=".$saledetails->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$saledetails=new Saledetails();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$saledetails->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$saledetails=$saledetails->setObject($obj);
		if($saledetails->edit($saledetails)){
			$error=UPDATESUCCESS;
			redirect("addsaledetails_proc.php?id=".$saledetails->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$sales= new Sales();
	$fields="pos_sales.id, pos_sales.documentno, pos_sales.customerid, pos_sales.agentid, pos_sales.employeeid, pos_sales.remarks, pos_sales.mode, pos_sales.soldon, pos_sales.expirydate, pos_sales.memo, pos_sales.createdby, pos_sales.createdon, pos_sales.lasteditedby, pos_sales.lasteditedon, pos_sales.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$sales->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$items= new Items();
	$fields="inv_items.id, inv_items.code, inv_items.name, inv_items.departmentid, inv_items.departmentcategoryid, inv_items.categoryid, inv_items.manufacturer, inv_items.strength, inv_items.costprice, inv_items.tradeprice, inv_items.retailprice, inv_items.size, inv_items.unitofmeasureid, inv_items.vatclasseid, inv_items.generaljournalaccountid, inv_items.generaljournalaccountid2, inv_items.discount, inv_items.reorderlevel, inv_items.reorderquantity, inv_items.quantity, inv_items.reducing, inv_items.status, inv_items.createdby, inv_items.createdon, inv_items.lasteditedby, inv_items.lasteditedon, inv_items.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$items->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$saledetails=new Saledetails();
	$where=" where id=$id ";
	$fields="pos_saledetails.id, pos_saledetails.saleid, pos_saledetails.itemid, pos_saledetails.quantity, pos_saledetails.costprice, pos_saledetails.tradeprice, pos_saledetails.retailprice, pos_saledetails.discount, pos_saledetails.tax, pos_saledetails.bonus, pos_saledetails.profit, pos_saledetails.total, pos_saledetails.ipaddress, pos_saledetails.createdby, pos_saledetails.createdon, pos_saledetails.lasteditedby, pos_saledetails.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$saledetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$saledetails->fetchObject;

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
	
	
$page_title="Saledetails ";
include "addsaledetails.php";
?>