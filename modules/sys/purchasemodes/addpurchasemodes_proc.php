<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Purchasemodes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="150";//<img src="../edit.png" alt="edit" title="edit" />
}
else{
	$auth->roleid="148";//Add
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
	
	
if($obj->action=="Save"){
	$purchasemodes=new Purchasemodes();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$purchasemodes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$purchasemodes=$purchasemodes->setObject($obj);
		if($purchasemodes->add($purchasemodes)){
			$error=SUCCESS;
			redirect("addpurchasemodes_proc.php?id=".$purchasemodes->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$purchasemodes=new Purchasemodes();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$purchasemodes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$purchasemodes=$purchasemodes->setObject($obj);
		if($purchasemodes->edit($purchasemodes)){
			$error=UPDATESUCCESS;
			redirect("addpurchasemodes_proc.php?id=".$purchasemodes->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$purchasemodes=new Purchasemodes();
	$where=" where id=$id ";
	$fields="sys_purchasemodes.id, sys_purchasemodes.name, sys_purchasemodes.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$purchasemodes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$purchasemodes->fetchObject;

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
	
	
$page_title="Purchasemodes ";
include "addpurchasemodes.php";
?>