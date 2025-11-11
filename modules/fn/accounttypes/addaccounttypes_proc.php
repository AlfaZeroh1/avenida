<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Accounttypes_class.php");
require_once("../../auth/rules/Rules_class.php");
require_once("../../fn/acctypes/Acctypes_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="9456";//Edit
}
else{
	$auth->roleid="9456";//Add
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
	$accounttypes=new Accounttypes();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$accounttypes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$accounttypes=$accounttypes->setObject($obj);
		if($accounttypes->add($accounttypes)){
			$error=SUCCESS;
			redirect("addaccounttypes_proc.php?id=".$accounttypes->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$accounttypes=new Accounttypes();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$accounttypes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$accounttypes=$accounttypes->setObject($obj);
		if($accounttypes->edit($accounttypes)){
			$error=UPDATESUCCESS;
			redirect("addaccounttypes_proc.php?id=".$accounttypes->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$accounttypes=new Accounttypes();
	$where=" where id=$id ";
	$fields="fn_accounttypes.id, fn_accounttypes.name, fn_accounttypes.remarks, fn_accounttypes.balance";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$accounttypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$accounttypes->fetchObject;

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
	
	
$page_title="Accounttypes ";
include "addaccounttypes.php";
?>