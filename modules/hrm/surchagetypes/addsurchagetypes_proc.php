<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Surchagetypes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4810";//Edit
}
else{
	$auth->roleid="4810";//Add
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
	$surchagetypes=new Surchagetypes();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$surchagetypes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$surchagetypes=$surchagetypes->setObject($obj);
		if($surchagetypes->add($surchagetypes)){
			$error=SUCCESS;
			redirect("addsurchagetypes_proc.php?id=".$surchagetypes->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$surchagetypes=new Surchagetypes();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$surchagetypes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$surchagetypes=$surchagetypes->setObject($obj);
		if($surchagetypes->edit($surchagetypes)){
			$error=UPDATESUCCESS;
			redirect("addsurchagetypes_proc.php?id=".$surchagetypes->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$surchagetypes=new Surchagetypes();
	$where=" where id=$id ";
	$fields="hrm_surchagetypes.id, hrm_surchagetypes.name, hrm_surchagetypes.repeatafter, hrm_surchagetypes.remarks, hrm_surchagetypes.createdby, hrm_surchagetypes.createdon, hrm_surchagetypes.lasteditedby, hrm_surchagetypes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$surchagetypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$surchagetypes->fetchObject;

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
	
	
$page_title="Surchagetypes ";
include "addsurchagetypes.php";
?>