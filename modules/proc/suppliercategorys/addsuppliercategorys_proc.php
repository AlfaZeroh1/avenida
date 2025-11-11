<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Suppliercategorys_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8077";//Edit
}
else{
	$auth->roleid="8075";//Add
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
	$suppliercategorys=new Suppliercategorys();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$suppliercategorys->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$suppliercategorys=$suppliercategorys->setObject($obj);
		if($suppliercategorys->add($suppliercategorys)){
			$error=SUCCESS;
			redirect("addsuppliercategorys_proc.php?id=".$suppliercategorys->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$suppliercategorys=new Suppliercategorys();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$suppliercategorys->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$suppliercategorys=$suppliercategorys->setObject($obj);
		if($suppliercategorys->edit($suppliercategorys)){
			$error=UPDATESUCCESS;
			redirect("addsuppliercategorys_proc.php?id=".$suppliercategorys->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$suppliercategorys=new Suppliercategorys();
	$where=" where id=$id ";
	$fields="proc_suppliercategorys.id, proc_suppliercategorys.name, proc_suppliercategorys.remarks, proc_suppliercategorys.createdby, proc_suppliercategorys.createdon, proc_suppliercategorys.lasteditedby, proc_suppliercategorys.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$suppliercategorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$suppliercategorys->fetchObject;

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
	
	
$page_title="Suppliercategorys ";
include "addsuppliercategorys.php";
?>