<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Items_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../pos/itemstatuss/Itemstatuss_class.php");
require_once("../../pos/departments/Departments_class.php");
require_once("../../pos/categorys/Categorys_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="2162";//Edit
}
else{
	$auth->roleid="2160";//Add
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
	$items=new Items();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$items->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$items=$items->setObject($obj);
		if($items->add($items)){
			$error=SUCCESS;
			redirect("additems_proc.php?id=".$items->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$items=new Items();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$items->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$items=$items->setObject($obj);
		if($items->edit($items)){
			$error=UPDATESUCCESS;
			redirect("additems_proc.php?id=".$items->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$itemstatuss= new Itemstatuss();
	$fields="pos_itemstatuss.id, pos_itemstatuss.name, pos_itemstatuss.ipaddress, pos_itemstatuss.createdby, pos_itemstatuss.createdon, pos_itemstatuss.lasteditedby, pos_itemstatuss.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$itemstatuss->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$departments= new Departments();
	$fields="pos_departments.id, pos_departments.name, pos_departments.remarks, pos_departments.ipaddress, pos_departments.createdby, pos_departments.createdon, pos_departments.lasteditedby, pos_departments.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$departments->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$categorys= new Categorys();
	$fields="pos_categorys.id, pos_categorys.name, pos_categorys.remarks, pos_categorys.ipaddress, pos_categorys.createdby, pos_categorys.createdon, pos_categorys.lasteditedby, pos_categorys.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$categorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$items=new Items();
	$where=" where id=$id ";
	$fields="pos_items.id, pos_items.code, pos_items.name, pos_items.departmentid, pos_items.categoryid, pos_items.price, pos_items.tax, pos_items.stock, pos_items.itemstatusid, pos_items.remarks, pos_items.type, pos_items.createdby, pos_items.createdon, pos_items.lasteditedby, pos_items.lasteditedon, pos_items.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$items->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$items->fetchObject;

	//for autocompletes
}
if(empty($id) and empty($obj->action)){
	if(empty($_GET['edit'])){
		$obj->action="Save";
		$obj->mixedbox="No";
	}
	else{
		$obj=$_SESSION['obj'];
	}
	$obj->departmentid="1";
	$obj->categoryid="1";
	$obj->itemstatusid="1";
}	
elseif(!empty($id) and empty($obj->action)){
	$obj->action="Update";
}
	
	
$page_title="Items ";
include "additems.php";
?>