<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Paymentmodes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="146";//Edit
}
else{
	$auth->roleid="144";//Add
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
	$paymentmodes=new Paymentmodes();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$paymentmodes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$paymentmodes=$paymentmodes->setObject($obj);
		if($paymentmodes->add($paymentmodes)){
			$error=SUCCESS;
			redirect("addpaymentmodes_proc.php?id=".$paymentmodes->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$paymentmodes=new Paymentmodes();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$paymentmodes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$paymentmodes=$paymentmodes->setObject($obj);
		if($paymentmodes->edit($paymentmodes)){
			$error=UPDATESUCCESS;
			redirect("addpaymentmodes_proc.php?id=".$paymentmodes->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$paymentmodes=new Paymentmodes();
	$where=" where id=$id ";
	$fields="sys_paymentmodes.id, sys_paymentmodes.name, sys_paymentmodes.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$paymentmodes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$paymentmodes->fetchObject;

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
	
	
$page_title="Paymentmodes ";
include "addpaymentmodes.php";
?>