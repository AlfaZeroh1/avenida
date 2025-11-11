<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Documents_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../tender/tenders/Tenders_class.php");
require_once("../../dms/documenttypes/Documenttypes_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="7737";//Edit
}
else{
	$auth->roleid="7735";//Add
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
	$documents=new Documents();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
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

	$tenders= new Tenders();
	$fields="tender_tenders.id, tender_tenders.proposalno, tender_tenders.name, tender_tenders.tendertypeid, tender_tenders.datereceived, tender_tenders.actionplandate, tender_tenders.dateofreview, tender_tenders.dateofsubmission, tender_tenders.employeeid, tender_tenders.Statusid, tender_tenders.remarks, tender_tenders.ipaddress, tender_tenders.createdby, tender_tenders.createdon, tender_tenders.lasteditedby, tender_tenders.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$tenders->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$documenttypes= new Documenttypes();
	$fields="dms_documenttypes.id, dms_documenttypes.name, dms_documenttypes.moduleid, dms_documenttypes.remarks, dms_documenttypes.ipaddress, dms_documenttypes.createdby, dms_documenttypes.createdon, dms_documenttypes.lasteditedby, dms_documenttypes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$documenttypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$documents=new Documents();
	$where=" where id=$id ";
	$fields="tender_documents.id, tender_documents.tenderid, tender_documents.documenttypeid, tender_documents.title, tender_documents.file, tender_documents.remarks, tender_documents.ipaddress, tender_documents.createdby, tender_documents.createdon, tender_documents.lasteditedby, tender_documents.lasteditedon";
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