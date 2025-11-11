<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Itemvarietys_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../pos/items/Items_class.php");
require_once("../../prod/varietys/Varietys_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8683";//Edit
}
else{
	$auth->roleid="8683";//Add
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

if(!empty($ob->itemid)){
  $obj->itemid=$ob->itemid;
}
	
	
if($obj->action=="Save"){
	$itemvarietys=new Itemvarietys();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$itemvarietys->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$itemvarietys=$itemvarietys->setObject($obj);
		if($itemvarietys->add($itemvarietys)){
			$error=SUCCESS;
			redirect("additemvarietys_proc.php?id=".$itemvarietys->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$itemvarietys=new Itemvarietys();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$itemvarietys->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$itemvarietys=$itemvarietys->setObject($obj);
		if($itemvarietys->edit($itemvarietys)){
			$error=UPDATESUCCESS;
			redirect("additemvarietys_proc.php?id=".$itemvarietys->id."&error=".$error);
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


	$varietys= new Varietys();
	$fields="prod_varietys.id, prod_varietys.name, prod_varietys.typeid, prod_varietys.colourid, prod_varietys.duration, prod_varietys.remarks, prod_varietys.ipaddress, prod_varietys.createdby, prod_varietys.createdon, prod_varietys.lasteditedby, prod_varietys.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$varietys->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$itemvarietys=new Itemvarietys();
	$where=" where id=$id ";
	$fields="pos_itemvarietys.id, pos_itemvarietys.itemid, pos_itemvarietys.varietyid, pos_itemvarietys.quantity, pos_itemvarietys.remarks, pos_itemvarietys.ipaddress, pos_itemvarietys.createdby, pos_itemvarietys.createdon, pos_itemvarietys.lasteditedby, pos_itemvarietys.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$itemvarietys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$itemvarietys->fetchObject;

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
	
	
$page_title="Itemvarietys ";
include "additemvarietys.php";
?>