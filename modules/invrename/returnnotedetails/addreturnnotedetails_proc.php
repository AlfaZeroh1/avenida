<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Returnnotedetails_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../inv/items/Items_class.php");
require_once("../../inv/returnnotes/Returnnotes_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8385";//Edit
}
else{
	$auth->roleid="8383";//Add
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
	$returnnotedetails=new Returnnotedetails();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$returnnotedetails->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$returnnotedetails=$returnnotedetails->setObject($obj);
		if($returnnotedetails->add($returnnotedetails)){
			$error=SUCCESS;
			redirect("addreturnnotedetails_proc.php?id=".$returnnotedetails->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$returnnotedetails=new Returnnotedetails();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$returnnotedetails->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$returnnotedetails=$returnnotedetails->setObject($obj);
		if($returnnotedetails->edit($returnnotedetails)){
			$error=UPDATESUCCESS;
			redirect("addreturnnotedetails_proc.php?id=".$returnnotedetails->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$items= new Items();
	$fields="inv_items.id, inv_items.code, inv_items.name, inv_items.departmentid, inv_items.departmentcategoryid, inv_items.categoryid, inv_items.manufacturer, inv_items.strength, inv_items.costprice, inv_items.tradeprice, inv_items.retailprice, inv_items.size, inv_items.unitofmeasureid, inv_items.vatclasseid, inv_items.generaljournalaccountid, inv_items.generaljournalaccountid2, inv_items.discount, inv_items.reorderlevel, inv_items.reorderquantity, inv_items.quantity, inv_items.reducing, inv_items.status, inv_items.createdby, inv_items.createdon, inv_items.lasteditedby, inv_items.lasteditedon, inv_items.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$items->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$returnnotes= new Returnnotes();
	$fields="inv_returnnotes.id, inv_returnnotes.supplierid, inv_returnnotes.documentno, inv_returnnotes.purchaseno, inv_returnnotes.purchasemodeid, inv_returnnotes.returnedon, inv_returnnotes.memo, inv_returnnotes.remarks, inv_returnnotes.createdby, inv_returnnotes.createdon, inv_returnnotes.lasteditedby, inv_returnnotes.lasteditedon, inv_returnnotes.ipaddress, inv_returnnotes.projectid";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$returnnotes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$returnnotedetails=new Returnnotedetails();
	$where=" where id=$id ";
	$fields="inv_returnnotedetails.id, inv_returnnotedetails.returnnoteid, inv_returnnotedetails.itemid, inv_returnnotedetails.quantity, inv_returnnotedetails.costprice, inv_returnnotedetails.tax, inv_returnnotedetails.discount, inv_returnnotedetails.total, inv_returnnotedetails.ipaddress, inv_returnnotedetails.createdby, inv_returnnotedetails.createdon, inv_returnnotedetails.lasteditedby, inv_returnnotedetails.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$returnnotedetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$returnnotedetails->fetchObject;

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
	
	
$page_title="Returnnotedetails ";
include "addreturnnotedetails.php";
?>