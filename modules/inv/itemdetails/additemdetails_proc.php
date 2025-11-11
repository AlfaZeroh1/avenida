<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../sys/submodules/Submodules_class.php");
require_once("Itemdetails_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../inv/items/Items_class.php");
require_once("../../sys/branches/Branches_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="9943";//Edit
}
else{
	$auth->roleid="9941";//Add
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
	$itemdetails=new Itemdetails();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$itemdetails->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$itemdetails=$itemdetails->setObject($obj);
		if($itemdetails->add($itemdetails)){
			$error=SUCCESS;
			redirect("additemdetails_proc.php?id=".$itemdetails->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$itemdetails=new Itemdetails();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$itemdetails->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$itemdetails=$itemdetails->setObject($obj);
		if($itemdetails->edit($itemdetails)){
			$error=UPDATESUCCESS;
			redirect("additemdetails_proc.php?id=".$itemdetails->id."&error=".$error);
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


	$branches= new Branches();
	$fields="sys_branches.id, sys_branches.name, sys_branches.remarks, sys_branches.ipaddress, sys_branches.createdby, sys_branches.createdon, sys_branches.lasteditedby, sys_branches.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$branches->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$itemdetails=new Itemdetails();
	$where=" where id=$id ";
	$fields="inv_itemdetails.id, inv_itemdetails.itemid, inv_itemdetails.brancheid, inv_itemdetails.serialno, inv_itemdetails.documentno, inv_itemdetails.status, inv_itemdetails.remarks, inv_itemdetails.ipaddress, inv_itemdetails.createdby, inv_itemdetails.createdon, inv_itemdetails.lasteditedby, inv_itemdetails.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$itemdetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$itemdetails->fetchObject;

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
	
	
$submodules = new Submodules();
$fields=" * ";
$join="";
$groupby="";
$having="";
$where=" where name='inv_itemdetails' and status=1" ;
$submodules->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$submodules=$submodules->fetchObject;
$page_title=$submodules->description;
include "additemdetails.php";
?>