<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Ipaddress_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="9289";//Edit
}
else{
	$auth->roleid="9289";//Add
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
	$ipaddress=new Ipaddress();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$ipaddress->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$ipaddress=$ipaddress->setObject($obj);
		if($ipaddress->add($ipaddress)){
			$error=SUCCESS;
			redirect("addipaddress_proc.php?id=".$ipaddress->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$ipaddress=new Ipaddress();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$ipaddress->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$ipaddress=$ipaddress->setObject($obj);
		if($ipaddress->edit($ipaddress)){
			$error=UPDATESUCCESS;
			redirect("addipaddress_proc.php?id=".$ipaddress->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$ipaddress=new Ipaddress();
	$where=" where id=$id ";
	$fields="sys_ipaddress.id, sys_ipaddress.task, sys_ipaddress.ipaddress, sys_ipaddress.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$ipaddress->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$ipaddress->fetchObject;

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
	
	
$page_title="Ipaddress ";
include "addipaddress.php";
?>