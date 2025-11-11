<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Documents_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4215";//Edit
}
else{
	$auth->roleid="4213";//Add
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
	$documents=new Documents();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$documents->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$documents=$documents->setObject($obj);
		if($documents->add($documents)){
			$error=SUCCESS;
			redirect("adddocuments_proc.php?id=".$documents->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$documents=new Documents();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$documents->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$documents=$documents->setObject($obj);
		if($documents->edit($documents)){
			$error=UPDATESUCCESS;
			redirect("adddocuments_proc.php?id=".$documents->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){
}

if(!empty($id)){
	$documents=new Documents();
	$where=" where id=$id ";
	$fields="hrm_documents.id, hrm_documents.name, hrm_documents.remarks, hrm_documents.createdby, hrm_documents.createdon, hrm_documents.lasteditedby, hrm_documents.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$documents->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$documents->fetchObject;

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
	
	
$page_title="Documents ";
include "adddocuments.php";
?>