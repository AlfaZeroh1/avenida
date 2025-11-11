<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Agenttypes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8417";//Edit
}
else{
	$auth->roleid="8415";//Add
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
	$agenttypes=new Agenttypes();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$agenttypes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$agenttypes=$agenttypes->setObject($obj);
		if($agenttypes->add($agenttypes)){
			$error=SUCCESS;
			redirect("addagenttypes_proc.php?id=".$agenttypes->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$agenttypes=new Agenttypes();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$agenttypes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$agenttypes=$agenttypes->setObject($obj);
		if($agenttypes->edit($agenttypes)){
			$error=UPDATESUCCESS;
			redirect("addagenttypes_proc.php?id=".$agenttypes->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$agenttypes=new Agenttypes();
	$where=" where id=$id ";
	$fields="reg_agenttypes.id, reg_agenttypes.name, reg_agenttypes.remarks, reg_agenttypes.ipaddress, reg_agenttypes.createdby, reg_agenttypes.createdon, reg_agenttypes.lasteditedby, reg_agenttypes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$agenttypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$agenttypes->fetchObject;

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
	
	
$page_title="Agenttypes ";
include "addagenttypes.php";
?>