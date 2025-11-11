<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Types_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8609";//Edit
}
else{
	$auth->roleid="8607";//Add
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
	$types=new Types();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$types->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$types=$types->setObject($obj);
		if($types->add($types)){
			$error=SUCCESS;
			redirect("addtypes_proc.php?id=".$types->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$types=new Types();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$types->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$types=$types->setObject($obj);
		if($types->edit($types)){
			$error=UPDATESUCCESS;
			redirect("addtypes_proc.php?id=".$types->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$types=new Types();
	$where=" where id=$id ";
	$fields="prod_types.id, prod_types.name, prod_types.remarks, prod_types.ipaddress, prod_types.createdby, prod_types.createdon, prod_types.lasteditedby, prod_types.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$types->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$types->fetchObject;

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
	
	
$page_title="Types ";
include "addtypes.php";
?>