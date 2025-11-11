<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Configs_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../dms/documentss/Documentss_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8439";//Edit
}
else{
	$auth->roleid="8439";//Add
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
	$configs=new Configs();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$configs->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$configs=$configs->setObject($obj);
		if($configs->add($configs)){
			$error=SUCCESS;
			redirect("addconfigs_proc.php?id=".$configs->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$configs=new Configs();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$configs->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$configs=$configs->setObject($obj);
		if($configs->edit($configs)){
			$error=UPDATESUCCESS;
			redirect("addconfigs_proc.php?id=".$configs->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$documentss= new Documentss();
	$fields="dms_documentss.id, dms_documentss.routeid, dms_documentss.documentno, dms_documentss.documenttypeid, dms_documentss.departmentid, dms_documentss.departmentcategoryid, dms_documentss.categoryid, dms_documentss.hrmdepartmentid, dms_documentss.document, dms_documentss.link, dms_documentss.status, dms_documentss.expirydate, dms_documentss.description, dms_documentss.remarks, dms_documentss.ipaddress, dms_documentss.createdby, dms_documentss.createdon, dms_documentss.lasteditedby, dms_documentss.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$documentss->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$configs=new Configs();
	$where=" where id=$id ";
	$fields="tender_configs.id, tender_configs.name, tender_configs.documentsid, tender_configs.remarks, tender_configs.ipaddress, tender_configs.createdby, tender_configs.createdon, tender_configs.lasteditedby, tender_configs.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$configs->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$configs->fetchObject;

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
	
	
$page_title="Configs ";
include "addconfigs.php";
?>