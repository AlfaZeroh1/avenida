<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../sys/submodules/Submodules_class.php");
require_once("Estimations_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../inv/items/Items_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="11368";//Edit
}
else{
	$auth->roleid="11368";//Add
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
	$estimations=new Estimations();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$estimations->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$estimations=$estimations->setObject($obj);
		if($estimations->add($estimations)){
			$error=SUCCESS;
			redirect("addestimations_proc.php?id=".$estimations->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$estimations=new Estimations();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$estimations->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$estimations=$estimations->setObject($obj);
		if($estimations->edit($estimations)){
			$error=UPDATESUCCESS;
			redirect("addestimations_proc.php?id=".$estimations->id."&error=".$error);
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

}

if(!empty($id)){
	$estimations=new Estimations();
	$where=" where id=$id ";
	$fields="bom_estimations.id, bom_estimations.name, bom_estimations.itemid, bom_estimations.createdby, bom_estimations.createdon, bom_estimations.lasteditedby, bom_estimations.lasteditedon, bom_estimations.ipaddress,bom_estimations.prc";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$estimations->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$estimations->fetchObject;

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
$where=" where name='bom_estimations' and status=1" ;
$submodules->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$submodules=$submodules->fetchObject;
$page_title=$submodules->description;
include "addestimations.php";
?>