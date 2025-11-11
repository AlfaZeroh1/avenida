<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Allowancetypes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4764";//Edit
}
else{
	$auth->roleid="4762";//Add
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
	$allowancetypes=new Allowancetypes();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$allowancetypes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$allowancetypes=$allowancetypes->setObject($obj);
		if($allowancetypes->add($allowancetypes)){
			$error=SUCCESS;
			redirect("addallowancetypes_proc.php?id=".$allowancetypes->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$allowancetypes=new Allowancetypes();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$allowancetypes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$allowancetypes=$allowancetypes->setObject($obj);
		if($allowancetypes->edit($allowancetypes)){
			$error=UPDATESUCCESS;
			redirect("addallowancetypes_proc.php?id=".$allowancetypes->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$allowancetypes=new Allowancetypes();
	$where=" where id=$id ";
	$fields="hrm_allowancetypes.id, hrm_allowancetypes.name, hrm_allowancetypes.repeatafter, hrm_allowancetypes.remarks, hrm_allowancetypes.createdby, hrm_allowancetypes.createdon, hrm_allowancetypes.lasteditedby, hrm_allowancetypes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$allowancetypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$allowancetypes->fetchObject;

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
	
	
$page_title="Allowancetypes ";
include "addallowancetypes.php";
?>