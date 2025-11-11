<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Issuancedetails_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../inv/items/Items_class.php");
require_once("../../sys/transactions/Transactions_class.php");
require_once("../../fn/generaljournalaccounts/Generaljournalaccounts_class.php");
require_once("../../fn/generaljournals/Generaljournals_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8377";//Edit
}
else{
	$auth->roleid="8375";//Add
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
	$issuancedetails=new Issuancedetails();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$issuancedetails->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$issuancedetails=$issuancedetails->setObject($obj);
		if($issuancedetails->add($issuancedetails)){
			$error=SUCCESS;
			//redirect("addissuancedetails_proc.php?id=".$issuancedetails->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$issuancedetails=new Issuancedetails();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$issuancedetails->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$issuancedetails=$issuancedetails->setObject($obj);
		if($issuancedetails->edit($issuancedetails)){
			$error=UPDATESUCCESS;
			//redirect("addissuancedetails_proc.php?id=".$issuancedetails->id."&error=".$error);
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
	$issuancedetails=new Issuancedetails();
	$where=" where id=$id ";
	$fields="inv_issuancedetails.id, inv_issuancedetails.issuanceid, inv_issuancedetails.itemid, inv_issuancedetails.quantity, inv_issuancedetails.remarks, inv_issuancedetails.ipaddress, inv_issuancedetails.createdby, inv_issuancedetails.createdon, inv_issuancedetails.lasteditedby, inv_issuancedetails.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$issuancedetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$issuancedetails->fetchObject;

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
	
	
$page_title="Issuancedetails ";
include "addissuancedetails.php";
?>