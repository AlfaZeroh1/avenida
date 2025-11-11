<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Deductiontypes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="1113";//Edit
}
else{
	$auth->roleid="1111";//Add
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
	$deductiontypes=new Deductiontypes();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$deductiontypes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$deductiontypes=$deductiontypes->setObject($obj);
		if($deductiontypes->add($deductiontypes)){
			$error=SUCCESS;
			redirect("adddeductiontypes_proc.php?id=".$deductiontypes->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$deductiontypes=new Deductiontypes();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$deductiontypes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$deductiontypes=$deductiontypes->setObject($obj);
		if($deductiontypes->edit($deductiontypes)){
			$error=UPDATESUCCESS;
			redirect("adddeductiontypes_proc.php?id=".$deductiontypes->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$deductiontypes=new Deductiontypes();
	$where=" where id=$id ";
	$fields="hrm_deductiontypes.id, hrm_deductiontypes.name, hrm_deductiontypes.repeatafter, hrm_deductiontypes.remarks, hrm_deductiontypes.createdby, hrm_deductiontypes.createdon, hrm_deductiontypes.lasteditedby, hrm_deductiontypes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$deductiontypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$deductiontypes->fetchObject;

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
	
	
$page_title="Deductiontypes ";
include "adddeductiontypes.php";
?>