<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Itemdetails_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../pos/items/Items_class.php");
require_once("../../pos/schemes/Schemes_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="2154";//Edit
}
else{
	$auth->roleid="2152";//Add
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
	$fields="pos_items.id, pos_items.code, pos_items.name, pos_items.departmentid, pos_items.categoryid, pos_items.costprice, pos_items.tradeprice, pos_items.retailprice, pos_items.discount, pos_items.tax, pos_items.stock, pos_items.reorderlevel, pos_items.itemstatusid, pos_items.remarks, pos_items.createdby, pos_items.createdon, pos_items.lasteditedby, pos_items.lasteditedon, pos_items.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$items->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$schemes= new Schemes();
	$fields="pos_schemes.id, pos_schemes.name, pos_schemes.location, pos_schemes.description, pos_schemes.createdby, pos_schemes.createdon, pos_schemes.lasteditedby, pos_schemes.lasteditedon, pos_schemes.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$schemes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$itemdetails=new Itemdetails();
	$where=" where id=$id ";
	$fields="pos_itemdetails.id, pos_itemdetails.itemid, pos_itemdetails.schemeid, pos_itemdetails.parcelno, pos_itemdetails.groundno, pos_itemdetails.status, pos_itemdetails.createdby, pos_itemdetails.createdon, pos_itemdetails.lasteditedby, pos_itemdetails.lasteditedon, pos_itemdetails.ipaddress";
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
	
	
$page_title="Itemdetails ";
include "additemdetails.php";
?>