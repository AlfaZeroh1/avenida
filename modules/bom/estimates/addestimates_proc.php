<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("../../sys/submodules/Submodules_class.php");
require_once("Estimates_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../pos/itemss/Itemss_class.php");
require_once("../../pos/itemsdetails/Itemsdetails_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="11318";//Edit
}
else{
	$auth->roleid="11316";//Add
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
	$estimates=new Estimates();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$estimates->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$estimates=$estimates->setObject($obj);
		if($estimates->add($estimates)){
			$error=SUCCESS;
			redirect("addestimates_proc.php?id=".$estimates->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$estimates=new Estimates();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$estimates->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$estimates=$estimates->setObject($obj);
		if($estimates->edit($estimates)){
			$error=UPDATESUCCESS;
			redirect("addestimates_proc.php?id=".$estimates->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$itemss= new Itemss();
	$fields="pos_itemss.id, pos_itemss.code, pos_itemss.name, pos_itemss.remarks, pos_itemss.ipaddress, pos_itemss.createdby, pos_itemss.createdon, pos_itemss.lasteditedby, pos_itemss.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$itemss->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$itemsdetails= new Itemsdetails();
	$fields="pos_itemsdetails.id, pos_itemsdetails.code, pos_itemsdetails.itemid, pos_itemsdetails.departmentid, pos_itemsdetails.package, pos_itemsdetails.units, pos_itemsdetails.costpice, pos_itemsdetails.tradeprice, pos_itemsdetails.retailprice, pos_itemsdetails.dprice, pos_itemsdetails.vatable, pos_itemsdetails.quantity, pos_itemsdetails.status, pos_itemsdetails.createdby, pos_itemsdetails.createdon, pos_itemsdetails.lasteditedby, pos_itemsdetails.lasteditedon, pos_itemsdetails.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$itemsdetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$estimates=new Estimates();
	$where=" where id=$id ";
	$fields="bom_estimates.id, bom_estimates.itemid, bom_estimates.itemdetailid, bom_estimates.createdby, bom_estimates.createdon, bom_estimates.lasteditedby, bom_estimates.lasteditedon, bom_estimates.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$estimates->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$estimates->fetchObject;

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
$where=" where name='bom_estimates' and status=1" ;
$submodules->retrieve($fields, $join, $where, $having, $groupby, $orderby);
$submodules=$submodules->fetchObject;
$page_title=$submodules->description;
include "addestimates.php";
?>