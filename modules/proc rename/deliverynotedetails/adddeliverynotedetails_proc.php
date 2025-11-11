<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Deliverynotedetails_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../proc/deliverynotes/Deliverynotes_class.php");
require_once("../../inv/items/Items_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8357";//Edit
}
else{
	$auth->roleid="8355";//Add
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
	$deliverynotedetails=new Deliverynotedetails();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$deliverynotedetails->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$deliverynotedetails=$deliverynotedetails->setObject($obj);
		if($deliverynotedetails->add($deliverynotedetails)){
			$error=SUCCESS;
			redirect("adddeliverynotedetails_proc.php?id=".$deliverynotedetails->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$deliverynotedetails=new Deliverynotedetails();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$deliverynotedetails->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$deliverynotedetails=$deliverynotedetails->setObject($obj);
		if($deliverynotedetails->edit($deliverynotedetails)){
			$error=UPDATESUCCESS;
			redirect("adddeliverynotedetails_proc.php?id=".$deliverynotedetails->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$deliverynotes= new Deliverynotes();
	$fields="proc_deliverynotes.id, proc_deliverynotes.documentno, proc_deliverynotes.lpono, proc_deliverynotes.projectid, proc_deliverynotes.supplierid, proc_deliverynotes.deliveredon, proc_deliverynotes.remarks, proc_deliverynotes.file, proc_deliverynotes.ipaddress, proc_deliverynotes.createdby, proc_deliverynotes.createdon, proc_deliverynotes.lasteditedby, proc_deliverynotes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$deliverynotes->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$items= new Items();
	$fields="inv_items.id, inv_items.code, inv_items.name, inv_items.departmentid, inv_items.departmentcategoryid, inv_items.categoryid, inv_items.manufacturer, inv_items.strength, inv_items.costprice, inv_items.tradeprice, inv_items.retailprice, inv_items.size, inv_items.unitofmeasureid, inv_items.vatclasseid, inv_items.generaljournalaccountid, inv_items.generaljournalaccountid2, inv_items.discount, inv_items.reorderlevel, inv_items.reorderquantity, inv_items.quantity, inv_items.reducing, inv_items.status, inv_items.createdby, inv_items.createdon, inv_items.lasteditedby, inv_items.lasteditedon, inv_items.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$items->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$deliverynotedetails=new Deliverynotedetails();
	$where=" where id=$id ";
	$fields="proc_deliverynotedetails.id, proc_deliverynotedetails.deliverynoteid, proc_deliverynotedetails.itemid, proc_deliverynotedetails.quantity, proc_deliverynotedetails.costprice, proc_deliverynotedetails.total, proc_deliverynotedetails.memo, proc_deliverynotedetails.ipaddress, proc_deliverynotedetails.createdby, proc_deliverynotedetails.createdon, proc_deliverynotedetails.lasteditedby, proc_deliverynotedetails.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$deliverynotedetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$deliverynotedetails->fetchObject;

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
	
	
$page_title="Deliverynotedetails ";
include "adddeliverynotedetails.php";
?>