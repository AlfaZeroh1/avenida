<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../sys/submodules/Submodules_class.php");
require_once("Estimatedetails_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../inv/items/Items_class.php");
require_once("../../inv/unitofmeasures/Unitofmeasures_class.php");
require_once("../../bom/estimates/Estimates_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="11312";//Edit
}
else{
	$auth->roleid="11312";//Add
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
	$estimatedetails=new Estimatedetails();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$estimatedetails->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$estimatedetails=$estimatedetails->setObject($obj);
		if($estimatedetails->add($estimatedetails)){
			$error=SUCCESS;
			redirect("addestimatedetails_proc.php?id=".$estimatedetails->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$estimatedetails=new Estimatedetails();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$estimatedetails->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$estimatedetails=$estimatedetails->setObject($obj);
		if($estimatedetails->edit($estimatedetails)){
			$error=UPDATESUCCESS;
			redirect("addestimatedetails_proc.php?id=".$estimatedetails->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$items= new Items();
	$fields="inv_items.id, inv_items.code, inv_items.name, inv_items.departmentid, inv_items.departmentcategoryid, inv_items.categoryid, inv_items.manufacturer, inv_items.strength, inv_items.bales, inv_items.cartons, inv_items.costprice, inv_items.tradeprice, inv_items.retailprice, inv_items.size, inv_items.unitofmeasureid, inv_items.vatclasseid, inv_items.generaljournalaccountid, inv_items.generaljournalaccountid2, inv_items.discount, inv_items.deposit, inv_items.installments, inv_items.months, inv_items.reorderlevel, inv_items.reorderquantity, inv_items.quantity, inv_items.reducing, inv_items.status, inv_items.createdby, inv_items.createdon, inv_items.lasteditedby, inv_items.lasteditedon, inv_items.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$items->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$unitofmeasures= new Unitofmeasures();
	$fields="inv_unitofmeasures.id, inv_unitofmeasures.name, inv_unitofmeasures.description, inv_unitofmeasures.createdby, inv_unitofmeasures.createdon, inv_unitofmeasures.lasteditedby, inv_unitofmeasures.lasteditedon, inv_unitofmeasures.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$unitofmeasures->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$estimates= new Estimates();
	$fields="bom_estimates.id, bom_estimates.itemid, bom_estimates.itemdetailid, bom_estimates.createdby, bom_estimates.createdon, bom_estimates.lasteditedby, bom_estimates.lasteditedon, bom_estimates.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$estimates->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$estimatedetails=new Estimatedetails();
	$where=" where id=$id ";
	$fields="bom_estimatedetails.id, bom_estimatedetails.estimateid, bom_estimatedetails.itemid, bom_estimatedetails.quantity, bom_estimatedetails.unitid, bom_estimatedetails.createdby, bom_estimatedetails.createdon, bom_estimatedetails.lasteditedby, bom_estimatedetails.lasteditedon, bom_estimatedetails.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$estimatedetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$estimatedetails->fetchObject;

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
$where=" where name='bom_estimatedetails' and status=1" ;
$submodules->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$submodules=$submodules->fetchObject;
$page_title=$submodules->description;
include "addestimatedetails.php";
?>