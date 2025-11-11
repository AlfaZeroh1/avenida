<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Itemstocks_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../pos/items/Items_class.php");
require_once("../../crm/customers/Customers_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8691";//Edit
}
else{
	$auth->roleid="8691";//Add
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
	$itemstocks=new Itemstocks();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$itemstocks->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$itemstocks=$itemstocks->setObject($obj);
		if($itemstocks->add($itemstocks)){
			$error=SUCCESS;
			redirect("additemstocks_proc.php?id=".$itemstocks->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$itemstocks=new Itemstocks();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$itemstocks->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$itemstocks=$itemstocks->setObject($obj);
		if($itemstocks->edit($itemstocks)){
			$error=UPDATESUCCESS;
			redirect("additemstocks_proc.php?id=".$itemstocks->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$items= new Items();
	$fields="pos_items.id, pos_items.code, pos_items.name, pos_items.departmentid, pos_items.categoryid, pos_items.price, pos_items.tax, pos_items.stock, pos_items.itemstatusid, pos_items.remarks, pos_items.createdby, pos_items.createdon, pos_items.lasteditedby, pos_items.lasteditedon, pos_items.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$items->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$customers= new Customers();
	$fields="crm_customers.id, crm_customers.name, crm_customers.agentid, crm_customers.departmentid, crm_customers.categorydepartmentid, crm_customers.categoryid, crm_customers.employeeid, crm_customers.idno, crm_customers.pinno, crm_customers.address, crm_customers.tel, crm_customers.fax, crm_customers.email, crm_customers.contactname, crm_customers.contactphone, crm_customers.nextofkin, crm_customers.nextofkinrelation, crm_customers.nextofkinaddress, crm_customers.nextofkinidno, crm_customers.nextofkinpinno, crm_customers.nextofkintel, crm_customers.creditlimit, crm_customers.creditdays, crm_customers.discount, crm_customers.showlogo, crm_customers.statusid, crm_customers.remarks, crm_customers.createdby, crm_customers.createdon, crm_customers.lasteditedby, crm_customers.lasteditedon, crm_customers.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$customers->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$itemstocks=new Itemstocks();
	$where=" where id=$id ";
	$fields="pos_itemstocks.id, pos_itemstocks.documentno,pos_itemstocks.datecode, pos_itemstocks.itemid, pos_itemstocks.customerid, pos_itemstocks.transaction, pos_itemstocks.quantity, pos_itemstocks.remain, pos_itemstocks.recordedon, pos_itemstocks.actedon, pos_itemstocks.ipaddress, pos_itemstocks.createdby, pos_itemstocks.createdon, pos_itemstocks.lasteditedby, pos_itemstocks.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$itemstocks->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$itemstocks->fetchObject;

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
	
	
$page_title="Itemstocks ";
include "additemstocks.php";
?>