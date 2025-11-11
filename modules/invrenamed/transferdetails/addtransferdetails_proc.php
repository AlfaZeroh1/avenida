<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Transferdetails_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../inv/transfers/Transfers_class.php");
require_once("../../inv/items/Items_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="9491";//Edit
}
else{
	$auth->roleid="9489";//Add
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
	$transferdetails=new Transferdetails();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$transferdetails->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$transferdetails=$transferdetails->setObject($obj);
		if($transferdetails->add($transferdetails)){
			$error=SUCCESS;
			redirect("addtransferdetails_proc.php?id=".$transferdetails->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$transferdetails=new Transferdetails();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$transferdetails->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$transferdetails=$transferdetails->setObject($obj);
		if($transferdetails->edit($transferdetails)){
			$error=UPDATESUCCESS;
			redirect("addtransferdetails_proc.php?id=".$transferdetails->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$transfers= new Transfers();
	$fields="inv_transfers.id, inv_transfers.documentno, inv_transfers.brancheid, inv_transfers.tobrancheid, inv_transfers.remarks, inv_transfers.transferedon, inv_transfers.status, inv_transfers.ipaddress, inv_transfers.createdby, inv_transfers.createdon, inv_transfers.lasteditedby, inv_transfers.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$transfers->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$items= new Items();
	$fields="inv_items.id, inv_items.code, inv_items.name, inv_items.departmentid, inv_items.departmentcategoryid, inv_items.categoryid, inv_items.manufacturer, inv_items.strength, inv_items.costprice, inv_items.tradeprice, inv_items.retailprice, inv_items.size, inv_items.unitofmeasureid, inv_items.vatclasseid, inv_items.generaljournalaccountid, inv_items.generaljournalaccountid2, inv_items.discount, inv_items.reorderlevel, inv_items.reorderquantity, inv_items.quantity, inv_items.reducing, inv_items.status, inv_items.createdby, inv_items.createdon, inv_items.lasteditedby, inv_items.lasteditedon, inv_items.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$items->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$transferdetails=new Transferdetails();
	$where=" where id=$id ";
	$fields="inv_transferdetails.id, inv_transferdetails.transferid, inv_transferdetails.itemid, inv_transferdetails.code, inv_transferdetails.quantity, inv_transferdetails.costprice, inv_transferdetails.total, inv_transferdetails.memo, inv_transferdetails.ipaddress, inv_transferdetails.createdby, inv_transferdetails.createdon, inv_transferdetails.lasteditedby, inv_transferdetails.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$transferdetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$transferdetails->fetchObject;

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
	
	
$page_title="Transferdetails ";
include "addtransferdetails.php";
?>