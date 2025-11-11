<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Constituencys_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="7761";//Edit
}
else{
	$auth->roleid="7759";//Add
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
	$constituencys=new Constituencys();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$constituencys->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$constituencys=$constituencys->setObject($obj);
		if($constituencys->add($constituencys)){
			$error=SUCCESS;
			redirect("addconstituencys_proc.php?id=".$constituencys->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$constituencys=new Constituencys();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$constituencys->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$constituencys=$constituencys->setObject($obj);
		if($constituencys->edit($constituencys)){
			$error=UPDATESUCCESS;
			redirect("addconstituencys_proc.php?id=".$constituencys->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$constituencys=new Constituencys();
	$where=" where id=$id ";
	$fields="sys_constituencys.id, sys_constituencys.name";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$constituencys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$constituencys->fetchObject;

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
	
	
$page_title="Constituencys ";
include "addconstituencys.php";
?>