<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Returnoutwarddetails_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../inv/items/Items_class.php");
require_once("../../inv/returnoutwards/Returnoutwards_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8389";//Edit
}
else{
	$auth->roleid="8387";//Add
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
	$returnoutwarddetails=new Returnoutwarddetails();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$returnoutwarddetails->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$returnoutwarddetails=$returnoutwarddetails->setObject($obj);
		if($returnoutwarddetails->add($returnoutwarddetails)){
			$error=SUCCESS;
			redirect("addreturnoutwarddetails_proc.php?id=".$returnoutwarddetails->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$returnoutwarddetails=new Returnoutwarddetails();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$returnoutwarddetails->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$returnoutwarddetails=$returnoutwarddetails->setObject($obj);
		if($returnoutwarddetails->edit($returnoutwarddetails)){
			$error=UPDATESUCCESS;
			redirect("addreturnoutwarddetails_proc.php?id=".$returnoutwarddetails->id."&error=".$error);
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


	$returnoutwards= new Returnoutwards();
	$fields="inv_returnoutwards.id, inv_returnoutwards.supplierid, inv_returnoutwards.storeid, inv_returnoutwards.documentno, inv_returnoutwards.purchaseno, inv_returnoutwards.purchasemodeid, inv_returnoutwards.returnedon, inv_returnoutwards.memo, inv_returnoutwards.remarks, inv_returnoutwards.createdby, inv_returnoutwards.createdon, inv_returnoutwards.lasteditedby, inv_returnoutwards.lasteditedon, inv_returnoutwards.ipaddress, inv_returnoutwards.projectid";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$returnoutwards->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$returnoutwarddetails=new Returnoutwarddetails();
	$where=" where id=$id ";
	$fields="inv_returnoutwarddetails.id, inv_returnoutwarddetails.returnoutwardid, inv_returnoutwarddetails.itemid, inv_returnoutwarddetails.quantity, inv_returnoutwarddetails.costprice, inv_returnoutwarddetails.tax, inv_returnoutwarddetails.discount, inv_returnoutwarddetails.total, inv_returnoutwarddetails.ipaddress, inv_returnoutwarddetails.createdby, inv_returnoutwarddetails.createdon, inv_returnoutwarddetails.lasteditedby, inv_returnoutwarddetails.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$returnoutwarddetails->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$returnoutwarddetails->fetchObject;

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
	
	
$page_title="Returnoutwarddetails ";
include "addreturnoutwarddetails.php";
?>