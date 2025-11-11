<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Checklistcategorys_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="7757";//Edit
}
else{
	$auth->roleid="7755";//Add
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
	$checklistcategorys=new Checklistcategorys();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$checklistcategorys->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$checklistcategorys=$checklistcategorys->setObject($obj);
		if($checklistcategorys->add($checklistcategorys)){
			$error=SUCCESS;
			redirect("addchecklistcategorys_proc.php?id=".$checklistcategorys->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$checklistcategorys=new Checklistcategorys();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$checklistcategorys->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$checklistcategorys=$checklistcategorys->setObject($obj);
		if($checklistcategorys->edit($checklistcategorys)){
			$error=UPDATESUCCESS;
			redirect("addchecklistcategorys_proc.php?id=".$checklistcategorys->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$checklistcategorys=new Checklistcategorys();
	$where=" where id=$id ";
	$fields="tender_checklistcategorys.id, tender_checklistcategorys.name, tender_checklistcategorys.remarks, tender_checklistcategorys.ipaddress, tender_checklistcategorys.createdby, tender_checklistcategorys.createdon, tender_checklistcategorys.lasteditedby, tender_checklistcategorys.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$checklistcategorys->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$checklistcategorys->fetchObject;

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
	
	
$page_title="Checklistcategorys ";
include "addchecklistcategorys.php";
?>