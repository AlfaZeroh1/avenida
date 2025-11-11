<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Loantypes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="138";//<img src="../edit.png" alt="edit" title="edit" />
}
else{
	$auth->roleid="136";//Add
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
	$loantypes=new Loantypes();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$loantypes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$loantypes=$loantypes->setObject($obj);
		if($loantypes->add($loantypes)){
			$error=SUCCESS;
			redirect("addloantypes_proc.php?id=".$loantypes->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$loantypes=new Loantypes();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$loantypes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$loantypes=$loantypes->setObject($obj);
		if($loantypes->edit($loantypes)){
			$error=UPDATESUCCESS;
			redirect("addloantypes_proc.php?id=".$loantypes->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$loantypes=new Loantypes();
	$where=" where id=$id ";
	$fields="sys_loantypes.id, sys_loantypes.name";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$loantypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$loantypes->fetchObject;

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
	
	
$page_title="Loantypes ";
include "addloantypes.php";
?>