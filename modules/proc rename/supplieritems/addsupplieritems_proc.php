<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Supplieritems_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../proc/suppliers/Suppliers_class.php");
require_once("../../inv/items/Items_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8081";//Edit
}
else{
	$auth->roleid="8079";//Add
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
	$supplieritems=new Supplieritems();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$supplieritems->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$supplieritems=$supplieritems->setObject($obj);
		if($supplieritems->add($supplieritems)){
			$error=SUCCESS;
			redirect("addsupplieritems_proc.php?id=".$supplieritems->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$supplieritems=new Supplieritems();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$supplieritems->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$supplieritems=$supplieritems->setObject($obj);
		if($supplieritems->edit($supplieritems)){
			$error=UPDATESUCCESS;
			redirect("addsupplieritems_proc.php?id=".$supplieritems->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$suppliers= new Suppliers();
	$fields="proc_suppliers.id, proc_suppliers.code, proc_suppliers.name, proc_suppliers.suppliercategoryid, proc_suppliers.regionid, proc_suppliers.subregionid, proc_suppliers.contact, proc_suppliers.physicaladdress, proc_suppliers.tel, proc_suppliers.fax, proc_suppliers.email, proc_suppliers.cellphone, proc_suppliers.status, proc_suppliers.createdby, proc_suppliers.createdon, proc_suppliers.lasteditedby, proc_suppliers.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$suppliers->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$items= new Items();
	$fields="inv_items.id, inv_items.code, inv_items.name, inv_items.departmentid, inv_items.departmentcategoryid, inv_items.categoryid, inv_items.manufacturer, inv_items.strength, inv_items.costprice, inv_items.tradeprice, inv_items.retailprice, inv_items.size, inv_items.unitofmeasureid, inv_items.vatclasseid, inv_items.generaljournalaccountid, inv_items.generaljournalaccountid2, inv_items.discount, inv_items.reorderlevel, inv_items.reorderquantity, inv_items.quantity, inv_items.reducing, inv_items.status, inv_items.createdby, inv_items.createdon, inv_items.lasteditedby, inv_items.lasteditedon, inv_items.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$items->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$supplieritems=new Supplieritems();
	$where=" where id=$id ";
	$fields="proc_supplieritems.id, proc_supplieritems.itemid, proc_supplieritems.supplierid, proc_supplieritems.price, proc_supplieritems.remarks, proc_supplieritems.ipaddress, proc_supplieritems.createdby, proc_supplieritems.createdon, proc_supplieritems.lasteditedby, proc_supplieritems.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$supplieritems->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$supplieritems->fetchObject;

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
	
	
$page_title="Supplieritems ";
include "addsupplieritems.php";
?>