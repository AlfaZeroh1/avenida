<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Suppliers_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="2222";//Edit
}
else{
	$auth->roleid="2220";//Add
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
	$suppliers=new Suppliers();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$suppliers->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$suppliers=$suppliers->setObject($obj);
		if($suppliers->add($suppliers)){
			$error=SUCCESS;
			redirect("addsuppliers_proc.php?id=".$suppliers->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$suppliers=new Suppliers();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$suppliers->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$suppliers=$suppliers->setObject($obj);
		if($suppliers->edit($suppliers)){
			$error=UPDATESUCCESS;
			redirect("addsuppliers_proc.php?id=".$suppliers->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$suppliers=new Suppliers();
	$where=" where id=$id ";
	$fields="pos_suppliers.id, pos_suppliers.code, pos_suppliers.name, pos_suppliers.contact, pos_suppliers.address, pos_suppliers.telephone, pos_suppliers.fax, pos_suppliers.email, pos_suppliers.mobile, pos_suppliers.status, pos_suppliers.createdby, pos_suppliers.createdon, pos_suppliers.lasteditedby, pos_suppliers.lasteditedon, pos_suppliers.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$suppliers->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$suppliers->fetchObject;

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
	
	
$page_title="Suppliers ";
include "addsuppliers.php";
?>