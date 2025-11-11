<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Tendertypes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="7749";//Edit
}
else{
	$auth->roleid="7747";//Add
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
	$tendertypes=new Tendertypes();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$tendertypes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$tendertypes=$tendertypes->setObject($obj);
		if($tendertypes->add($tendertypes)){
			$error=SUCCESS;
			redirect("addtendertypes_proc.php?id=".$tendertypes->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$tendertypes=new Tendertypes();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$tendertypes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$tendertypes=$tendertypes->setObject($obj);
		if($tendertypes->edit($tendertypes)){
			$error=UPDATESUCCESS;
			redirect("addtendertypes_proc.php?id=".$tendertypes->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$tendertypes=new Tendertypes();
	$where=" where id=$id ";
	$fields="tender_tendertypes.id, tender_tendertypes.name, tender_tendertypes.description, tender_tendertypes.remarks, tender_tendertypes.ipaddress, tender_tendertypes.createdby, tender_tendertypes.createdon, tender_tendertypes.lasteditedby, tender_tendertypes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$tendertypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$tendertypes->fetchObject;

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
	
	
$page_title="Tendertypes ";
include "addtendertypes.php";
?>