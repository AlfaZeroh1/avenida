<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Returninwarddetails_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../pos/returninwards/Returninwards_class.php");
require_once("../../pos/items/Items_class.php");
require_once("../../sys/vatclasses/Vatclasses_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8653";//Edit
}
else{
	$auth->roleid="8651";//Add
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
	$returninwarddetails=new Returninwarddetails();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$returninwarddetails->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$returninwarddetails=$returninwarddetails->setObject($obj);
		if($returninwarddetails->add($returninwarddetails)){
			$error=SUCCESS;
			redirect("addreturninwarddetails_proc.php?id=".$returninwarddetails->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$returninwarddetails=new Returninwarddetails();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$returninwarddetails->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$returninwarddetails=$returninwarddetails->setObject($obj);
		if($returninwarddetails->edit($returninwarddetails)){
			$error=UPDATESUCCESS;
			redirect("addreturninwarddetails_proc.php?id=".$returninwarddetails->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$returninwards= new Returninwards();
	$fields="pos_returninwards.id, pos_returninwards.documentno, pos_returninwards.packingno, pos_returninwards.customerid, pos_returninwards.agentid, pos_returninwards.remarks, pos_returninwards.soldon, pos_returninwards.memo, pos_returninwards.createdby, pos_returninwards.createdon, pos_returninwards.lasteditedby, pos_returninwards.lasteditedon, pos_returninwards.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$returninwards->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$items= new Items();
	$fields="pos_items.id, pos_items.code, pos_items.name, pos_items.departmentid, pos_items.categoryid, pos_items.costprice, pos_items.tradeprice, pos_items.retailprice, pos_items.discount, pos_items.tax, pos_items.stock, pos_items.reorderlevel, pos_items.itemstatusid, pos_items.remarks, pos_items.createdby, pos_items.createdon, pos_items.lasteditedby, pos_items.lasteditedon, pos_items.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$items->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$returninwarddetails=new Returninwarddetails();
	$where=" where id=$id ";
	$fields="pos_returninwarddetails.id, pos_returninwarddetails.returninwardid, pos_returninwarddetails.itemid, pos_returninwarddetails.quantity, pos_returninwarddetails.price, pos_returninwarddetails.discount, pos_returninwarddetails.tax, pos_returninwarddetails.bonus, pos_returninwarddetails.profit, pos_returninwarddetails.total, pos_returninwarddetails.ipaddress, pos_returninwarddetails.createdby, pos_returninwarddetails.createdon, pos_returninwarddetails.lasteditedby, pos_returninwarddetails.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$returninwarddetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$returninwarddetails->fetchObject;

	//for autocompletes
	$items = new Items();
	$fields=" * ";
	$where=" where id='$obj->itemid'";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$items->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$auto=$items->fetchObject;

	$obj->itemname=$auto->name;
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
	
	
$page_title="Returninwarddetails ";
include "addreturninwarddetails.php";
?>