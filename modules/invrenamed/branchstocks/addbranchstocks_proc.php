<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../sys/submodules/Submodules_class.php");
require_once("Branchstocks_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../inv/items/Items_class.php");
require_once("../../sys/branches/Branches_class.php");
require_once("../../sys/transactions/Transactions_class.php");
require_once("../../inv/itemdetails/Itemdetails_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="9495";//Edit
}
else{
	$auth->roleid="9493";//Add
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
	$branchstocks=new Branchstocks();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$branchstocks->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$branchstocks=$branchstocks->setObject($obj);
		if($branchstocks->add($branchstocks)){
			$error=SUCCESS;
			redirect("addbranchstocks_proc.php?id=".$branchstocks->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$branchstocks=new Branchstocks();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$branchstocks->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$branchstocks=$branchstocks->setObject($obj);
		if($branchstocks->edit($branchstocks)){
			$error=UPDATESUCCESS;
			redirect("addbranchstocks_proc.php?id=".$branchstocks->id."&error=".$error);
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
	$fields="sys_branches.id, sys_branches.name, sys_branches.remarks, sys_branches.type, sys_branches.ipaddress, sys_branches.createdby, sys_branches.createdon, sys_branches.lasteditedby, sys_branches.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$branches->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$transactions= new Transactions();
	$fields="sys_transactions.id, sys_transactions.name, sys_transactions.moduleid";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$transactions->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$itemdetails= new Itemdetails();
	$fields="inv_itemdetails.id, inv_itemdetails.itemid, inv_itemdetails.brancheid, inv_itemdetails.serialno, inv_itemdetails.documentno, inv_itemdetails.status, inv_itemdetails.remarks, inv_itemdetails.ipaddress, inv_itemdetails.createdby, inv_itemdetails.createdon, inv_itemdetails.lasteditedby, inv_itemdetails.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$itemdetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$branchstocks=new Branchstocks();
	$where=" where inv_branchstocks.id=$id ";
	$fields="inv_branchstocks.id, inv_branchstocks.brancheid,inv_branchstocks.itemid,sys_branches.name as branchname, inv_items.name itemname,inv_branchstocks.quantity ";
	$join=" left join sys_branches on inv_branchstocks.brancheid=sys_branches.id  left join inv_items on inv_branchstocks.itemid=inv_items.id ";
	$having="";
	$groupby="";
	$orderby="";
	$branchstocks->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$branchstocks->fetchObject;

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
$where=" where name='inv_branchstocks' and status=1" ;
$submodules->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$submodules=$submodules->fetchObject;
$page_title=$submodules->description;
include "addbranchstocks.php";
?>