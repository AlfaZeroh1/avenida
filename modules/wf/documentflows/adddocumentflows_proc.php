<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Documentflows_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../wf/documents/Documents_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="7464";//Edit
}
else{
	$auth->roleid="7462";//Add
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
	$documentflows=new Documentflows();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$documentflows->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$documentflows=$documentflows->setObject($obj);
		if($documentflows->add($documentflows)){
			$error=SUCCESS;
			redirect("adddocumentflows_proc.php?id=".$documentflows->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$documentflows=new Documentflows();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$documentflows->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$documentflows=$documentflows->setObject($obj);
		if($documentflows->edit($documentflows)){
			$error=UPDATESUCCESS;
			redirect("adddocumentflows_proc.php?id=".$documentflows->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$documents= new Documents();
	$fields="";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$documents->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$documentflows=new Documentflows();
	$where=" where id=$id ";
	$fields="wf_documentflows.id, wf_documentflows.documentid, wf_documentflows.remarks, wf_documentflows.status, wf_documentflows.document, wf_documentflows.link, wf_documentflows.ipaddress, wf_documentflows.createdby, wf_documentflows.createdon, wf_documentflows.lasteditedby, wf_documentflows.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$documentflows->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$documentflows->fetchObject;

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
	
	
$page_title="Documentflows ";
include "adddocumentflows.php";
?>