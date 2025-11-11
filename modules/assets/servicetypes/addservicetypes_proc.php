<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Servicetypes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="7717";//Edit
}
else{
	$auth->roleid="7715";//Add
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
	$servicetypes=new Servicetypes();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$servicetypes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$servicetypes=$servicetypes->setObject($obj);
		if($servicetypes->add($servicetypes)){
			$error=SUCCESS;
			redirect("addservicetypes_proc.php?id=".$servicetypes->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$servicetypes=new Servicetypes();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$servicetypes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$servicetypes=$servicetypes->setObject($obj);
		if($servicetypes->edit($servicetypes)){
			$error=UPDATESUCCESS;
			redirect("addservicetypes_proc.php?id=".$servicetypes->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$servicetypes=new Servicetypes();
	$where=" where id=$id ";
	$fields="assets_servicetypes.id, assets_servicetypes.name, assets_servicetypes.duration, assets_servicetypes.durationtype, assets_servicetypes.remarks, assets_servicetypes.ipaddress, assets_servicetypes.createdby, assets_servicetypes.createdon, assets_servicetypes.lasteditedby, assets_servicetypes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$servicetypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$servicetypes->fetchObject;

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
	
	
$page_title="Servicetypes ";
include "addservicetypes.php";
?>