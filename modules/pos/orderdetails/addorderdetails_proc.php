<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Orderdetails_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../pos/orders/Orders_class.php");
require_once("../../pos/items/Items_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8661";//Edit
}
else{
	$auth->roleid="8659";//Add
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
	$orderdetails=new Orderdetails();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$orderdetails->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$orderdetails=$orderdetails->setObject($obj);
		if($orderdetails->add($orderdetails)){
			$error=SUCCESS;
			redirect("addorderdetails_proc.php?id=".$orderdetails->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$orderdetails=new Orderdetails();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$orderdetails->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$orderdetails=$orderdetails->setObject($obj);
		if($orderdetails->edit($orderdetails)){
			$error=UPDATESUCCESS;
			redirect("addorderdetails_proc.php?id=".$orderdetails->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$orders= new Orders();
	$fields="pos_orders.id, pos_orders.orderno, pos_orders.customerid, pos_orders.orderedon, pos_orders.remarks, pos_orders.ipaddress, pos_orders.createdby, pos_orders.createdon, pos_orders.lasteditedby, pos_orders.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$orders->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$items= new Items();
	$fields="pos_items.id, pos_items.code, pos_items.name, pos_items.departmentid, pos_items.categoryid, pos_items.costprice, pos_items.tradeprice, pos_items.retailprice, pos_items.discount, pos_items.tax, pos_items.stock, pos_items.reorderlevel, pos_items.itemstatusid, pos_items.remarks, pos_items.createdby, pos_items.createdon, pos_items.lasteditedby, pos_items.lasteditedon, pos_items.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$items->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$orderdetails=new Orderdetails();
	$where=" where id=$id ";
	$fields="pos_orderdetails.id, pos_orderdetails.itemid, pos_orderdetails.quantity, pos_orderdetails.memo, pos_orderdetails.ipaddress, pos_orderdetails.createdby, pos_orderdetails.createdon, pos_orderdetails.lasteditedby, pos_orderdetails.lasteditedon, pos_orderdetails.orderid";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$orderdetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$orderdetails->fetchObject;

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
	
	
$page_title="Orderdetails ";
include "addorderdetails.php";
?>