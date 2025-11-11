<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Rejecttypes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8597";//Edit
}
else{
	$auth->roleid="8595";//Add
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
	$rejecttypes=new Rejecttypes();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$rejecttypes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$rejecttypes=$rejecttypes->setObject($obj);
		if($rejecttypes->add($rejecttypes)){
			$error=SUCCESS;
			redirect("addrejecttypes_proc.php?id=".$rejecttypes->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$rejecttypes=new Rejecttypes();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$rejecttypes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$rejecttypes=$rejecttypes->setObject($obj);
		if($rejecttypes->edit($rejecttypes)){
			$error=UPDATESUCCESS;
			redirect("addrejecttypes_proc.php?id=".$rejecttypes->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$rejecttypes=new Rejecttypes();
	$where=" where id=$id ";
	$fields="prod_rejecttypes.id, prod_rejecttypes.name, prod_rejecttypes.remarks, prod_rejecttypes.ipaddress, prod_rejecttypes.createdby, prod_rejecttypes.createdon, prod_rejecttypes.lasteditedby, prod_rejecttypes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$rejecttypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$rejecttypes->fetchObject;

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
	
	
$page_title="Rejecttypes ";
include "addrejecttypes.php";
?>