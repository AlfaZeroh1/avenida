<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Confirmedorderdetails_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../pos/confirmedorders/Confirmedorders_class.php");
require_once("../../pos/items/Items_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8701";//Edit
}
else{
	$auth->roleid="8699";//Add
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
	$confirmedorderdetails=new Confirmedorderdetails();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$confirmedorderdetails->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$confirmedorderdetails=$confirmedorderdetails->setObject($obj);
		if($confirmedorderdetails->add($confirmedorderdetails)){
			$error=SUCCESS;
			redirect("addconfirmedorderdetails_proc.php?id=".$confirmedorderdetails->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$confirmedorderdetails=new Confirmedorderdetails();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$confirmedorderdetails->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$confirmedorderdetails=$confirmedorderdetails->setObject($obj);
		if($confirmedorderdetails->edit($confirmedorderdetails)){
			$error=UPDATESUCCESS;
			redirect("addconfirmedorderdetails_proc.php?id=".$confirmedorderdetails->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$confirmedorders= new Confirmedorders();
	$fields="pos_confirmedorders.id, pos_confirmedorders.orderno, pos_confirmedorders.customerid, pos_confirmedorders.orderedon, pos_confirmedorders.remarks, pos_confirmedorders.ipaddress, pos_confirmedorders.createdby, pos_confirmedorders.createdon, pos_confirmedorders.lasteditedby, pos_confirmedorders.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$confirmedorders->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$items= new Items();
	$fields="pos_items.id, pos_items.code, pos_items.name, pos_items.departmentid, pos_items.categoryid, pos_items.price, pos_items.tax, pos_items.stock, pos_items.itemstatusid, pos_items.remarks, pos_items.createdby, pos_items.createdon, pos_items.lasteditedby, pos_items.lasteditedon, pos_items.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$items->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$confirmedorderdetails=new Confirmedorderdetails();
	$where=" where id=$id ";
	$fields="pos_confirmedorderdetails.id, pos_confirmedorderdetails.itemid, pos_confirmedorderdetails.quantity, pos_confirmedorderdetails.memo, pos_confirmedorderdetails.ipaddress, pos_confirmedorderdetails.createdby, pos_confirmedorderdetails.createdon, pos_confirmedorderdetails.lasteditedby, pos_confirmedorderdetails.lasteditedon, pos_confirmedorderdetails.confirmedorderid";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$confirmedorderdetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$confirmedorderdetails->fetchObject;

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
	
	
$page_title="Confirmedorderdetails ";
include "addconfirmedorderdetails.php";
?>