<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Itemprices_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../pos/items/Items_class.php");
require_once("../../pos/prices/Prices_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="2158";//Edit
}
else{
	$auth->roleid="2156";//Add
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
	$itemprices=new Itemprices();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$itemprices->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$itemprices=$itemprices->setObject($obj);
		if($itemprices->add($itemprices)){
			$error=SUCCESS;
			redirect("additemprices_proc.php?id=".$itemprices->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$itemprices=new Itemprices();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$itemprices->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$itemprices=$itemprices->setObject($obj);
		if($itemprices->edit($itemprices)){
			$error=UPDATESUCCESS;
			redirect("additemprices_proc.php?id=".$itemprices->id."&error=".$error);
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


	$prices= new Prices();
	$fields="pos_prices.id, pos_prices.name, pos_prices.remarks, pos_prices.ipaddress, pos_prices.createdby, pos_prices.createdon, pos_prices.lasteditedby, pos_prices.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$prices->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$itemprices=new Itemprices();
	$where=" where id=$id ";
	$fields="pos_itemprices.id, pos_itemprices.priceid, pos_itemprices.itemid, pos_itemprices.amount, pos_itemprices.remarks, pos_itemprices.createdby, pos_itemprices.createdon, pos_itemprices.lasteditedby, pos_itemprices.lasteditedon, pos_itemprices.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$itemprices->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$itemprices->fetchObject;

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
	
	
$page_title="Itemprices ";
include "additemprices.php";
?>