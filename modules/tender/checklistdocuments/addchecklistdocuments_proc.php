<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Checklistdocuments_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../dms/documenttypes/Documenttypes_class.php");
require_once("../../tender/checklists/Checklists_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="7729";//Edit
}
else{
	$auth->roleid="7727";//Add
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
	$checklistdocuments=new Checklistdocuments();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$checklistdocuments->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$checklistdocuments=$checklistdocuments->setObject($obj);
		if($checklistdocuments->add($checklistdocuments)){
			$error=SUCCESS;
			
			redirect("addchecklistdocuments_proc.php?id=".$checklistdocuments->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$checklistdocuments=new Checklistdocuments();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$checklistdocuments->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$checklistdocuments=$checklistdocuments->setObject($obj);
		if($checklistdocuments->edit($checklistdocuments)){
			$error=UPDATESUCCESS;
			redirect("addchecklistdocuments_proc.php?id=".$checklistdocuments->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$documenttypes= new Documenttypes();
	$fields="dms_documenttypes.id, dms_documenttypes.name, dms_documenttypes.moduleid, dms_documenttypes.remarks, dms_documenttypes.ipaddress, dms_documenttypes.createdby, dms_documenttypes.createdon, dms_documenttypes.lasteditedby, dms_documenttypes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$documenttypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$checklists= new Checklists();
	$fields="tender_checklists.id, tender_checklists.action, tender_checklists.checklistcategoryid, tender_checklists.tenderid, tender_checklists.description, tender_checklists.deadline, tender_checklists.status, tender_checklists.doneon, tender_checklists.completedon, tender_checklists.remarks, tender_checklists.ipaddress, tender_checklists.createdby, tender_checklists.createdon, tender_checklists.lasteditedby, tender_checklists.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$checklists->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$checklistdocuments=new Checklistdocuments();
	$where=" where id=$id ";
	$fields="tender_checklistdocuments.id, tender_checklistdocuments.title, tender_checklistdocuments.checklistid, tender_checklistdocuments.documenttypeid, tender_checklistdocuments.file, tender_checklistdocuments.remarks, tender_checklistdocuments.ipaddress, tender_checklistdocuments.createdby, tender_checklistdocuments.createdon, tender_checklistdocuments.lasteditedby, tender_checklistdocuments.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$checklistdocuments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$checklistdocuments->fetchObject;

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
	
	
$page_title="Checklistdocuments ";
include "addchecklistdocuments.php";
?>