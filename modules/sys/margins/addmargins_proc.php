<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Margins_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="9407";//Edit
}
else{
	$auth->roleid="9407";//Add
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
	$margins=new Margins();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$margins->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$margins=$margins->setObject($obj);
		if($margins->add($margins)){
			$error=SUCCESS;
			redirect("addmargins_proc.php?id=".$margins->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$margins=new Margins();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$margins->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$margins=$margins->setObject($obj);
		if($margins->edit($margins)){
			$error=UPDATESUCCESS;
			redirect("addmargins_proc.php?id=".$margins->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$margins=new Margins();
	$where=" where id=$id ";
	$fields="sys_margins.id, sys_margins.name, sys_margins.value, sys_margins.remarks, sys_margins.ipaddress, sys_margins.createdby, sys_margins.createdon, sys_margins.lasteditedby, sys_margins.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$margins->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$margins->fetchObject;

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
	
	
$page_title="Margins ";
include "addmargins.php";
?>