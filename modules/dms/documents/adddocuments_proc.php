<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Documents_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../dms/documenttypes/Documenttypes_class.php");
require_once("../../wf/routes/Routes_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="7564";//Edit
}
else{
	$auth->roleid="7562";//Add
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

	$documenttypes= new Documenttypes();
	$fields="dms_documenttypes.id, dms_documenttypes.name, dms_documenttypes.moduleid, dms_documenttypes.remarks, dms_documenttypes.ipaddress, dms_documenttypes.createdby, dms_documenttypes.createdon, dms_documenttypes.lasteditedby, dms_documenttypes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$documenttypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$routes= new Routes();
	$fields="wf_routes.id, wf_routes.name, wf_routes.moduleid, wf_routes.remarks, wf_routes.ipaddress, wf_routes.createdby, wf_routes.createdon, wf_routes.lasteditedby, wf_routes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$routes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$documents=new Documents();
	$where=" where id=$id ";
	$fields="dms_documents.id, dms_documents.routeid, dms_documents.documentno, dms_documents.documenttypeid, dms_documents.departmentid, dms_documents.departmentcategoryid, dms_documents.categoryid, dms_documents.hrmdepartmentid, dms_documents.document, dms_documents.link, dms_documents.status, dms_documents.description, dms_documents.remarks, dms_documents.ipaddress, dms_documents.createdby, dms_documents.createdon, dms_documents.lasteditedby, dms_documents.lasteditedon";
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