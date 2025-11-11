<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Packinglistdetails_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../pos/packinglists/Packinglists_class.php");
require_once("../../pos/items/Items_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8669";//Edit
}
else{
	$auth->roleid="8667";//Add
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
	$packinglistdetails=new Packinglistdetails();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$packinglistdetails->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$packinglistdetails=$packinglistdetails->setObject($obj);
		if($packinglistdetails->add($packinglistdetails)){
			$error=SUCCESS;
			redirect("addpackinglistdetails_proc.php?id=".$packinglistdetails->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$packinglistdetails=new Packinglistdetails();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$packinglistdetails->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$packinglistdetails=$packinglistdetails->setObject($obj);
		if($packinglistdetails->edit($packinglistdetails)){
			$error=UPDATESUCCESS;
			redirect("addpackinglistdetails_proc.php?id=".$packinglistdetails->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$packinglists= new Packinglists();
	$fields="pos_packinglists.id, pos_packinglists.documentno, pos_packinglists.orderno, pos_packinglists.boxno, pos_packinglists.customerid, pos_packinglists.packedon, pos_packinglists.fleetid, pos_packinglists.employeeid, pos_packinglists.remarks, pos_packinglists.ipaddress, pos_packinglists.createdby, pos_packinglists.createdon, pos_packinglists.lasteditedby, pos_packinglists.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$packinglists->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$items= new Items();
	$fields="pos_items.id, pos_items.code, pos_items.name, pos_items.departmentid, pos_items.categoryid, pos_items.price, pos_items.tax, pos_items.stock, pos_items.itemstatusid, pos_items.remarks, pos_items.createdby, pos_items.createdon, pos_items.lasteditedby, pos_items.lasteditedon, pos_items.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$items->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$packinglistdetails=new Packinglistdetails();
	$where=" where id=$id ";
	$fields="pos_packinglistdetails.id, pos_packinglistdetails.packinglistid, pos_packinglistdetails.itemid, pos_packinglistdetails.quantity, pos_packinglistdetails.memo, pos_packinglistdetails.ipaddress, pos_packinglistdetails.createdby, pos_packinglistdetails.createdon, pos_packinglistdetails.lasteditedby, pos_packinglistdetails.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$packinglistdetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$packinglistdetails->fetchObject;

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
	
	
$page_title="Packinglistdetails ";
include "addpackinglistdetails.php";
?>