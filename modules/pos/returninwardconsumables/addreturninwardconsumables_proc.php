<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Returninwardconsumables_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../inv/items/Items_class.php");
require_once("../../inv/unitofmeasures/Unitofmeasures_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="9384";//Edit
}
else{
	$auth->roleid="9384";//Add
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
	$returninwardconsumables=new Returninwardconsumables();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$returninwardconsumables->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$returninwardconsumables=$returninwardconsumables->setObject($obj);
		if($returninwardconsumables->add($returninwardconsumables)){
			$error=SUCCESS;
			redirect("addreturninwardconsumables_proc.php?id=".$returninwardconsumables->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$returninwardconsumables=new Returninwardconsumables();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$returninwardconsumables->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$returninwardconsumables=$returninwardconsumables->setObject($obj);
		if($returninwardconsumables->edit($returninwardconsumables)){
			$error=UPDATESUCCESS;
			redirect("addreturninwardconsumables_proc.php?id=".$returninwardconsumables->id."&error=".$error);
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


	$unitofmeasures= new Unitofmeasures();
	$fields="inv_unitofmeasures.id, inv_unitofmeasures.name, inv_unitofmeasures.description, inv_unitofmeasures.createdby, inv_unitofmeasures.createdon, inv_unitofmeasures.lasteditedby, inv_unitofmeasures.lasteditedon, inv_unitofmeasures.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$unitofmeasures->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$returninwardconsumables=new Returninwardconsumables();
	$where=" where id=$id ";
	$fields="pos_returninwardconsumables.id, pos_returninwardconsumables.itemid, pos_returninwardconsumables.unitofmeasureid, pos_returninwardconsumables.quantity, pos_returninwardconsumables.price, pos_returninwardconsumables.total, pos_returninwardconsumables.remarks, pos_returninwardconsumables.ipaddress, pos_returninwardconsumables.createdby, pos_returninwardconsumables.createdon, pos_returninwardconsumables.lasteditedby, pos_returninwardconsumables.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$returninwardconsumables->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$returninwardconsumables->fetchObject;

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
	
	
$page_title="Returninwardconsumables ";
include "addreturninwardconsumables.php";
?>