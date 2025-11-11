<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Projectdocuments_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../pm/projects/Projects_class.php");
require_once("../../dms/documenttypes/Documenttypes_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="9041";//Edit
}
else{
	$auth->roleid="9039";//Add
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
	$projectdocuments=new Projectdocuments();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$projectdocuments->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$projectdocuments=$projectdocuments->setObject($obj);
		if($projectdocuments->add($projectdocuments)){
			$error=SUCCESS;
			redirect("addprojectdocuments_proc.php?id=".$projectdocuments->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$projectdocuments=new Projectdocuments();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$projectdocuments->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$projectdocuments=$projectdocuments->setObject($obj);
		if($projectdocuments->edit($projectdocuments)){
			$error=UPDATESUCCESS;
			redirect("addprojectdocuments_proc.php?id=".$projectdocuments->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$projects= new Projects();
	$fields="pm_projects.id, pm_projects.customerid, pm_projects.name, pm_projects.description, pm_projects.startdate, pm_projects.expectedcompletion, pm_projects.actualcompletion, pm_projects.remarks, pm_projects.ipaddress, pm_projects.createdby, pm_projects.createdon, pm_projects.lasteditedby, pm_projects.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$projects->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$documenttypes= new Documenttypes();
	$fields="dms_documenttypes.id, dms_documenttypes.name, dms_documenttypes.moduleid, dms_documenttypes.remarks, dms_documenttypes.ipaddress, dms_documenttypes.createdby, dms_documenttypes.createdon, dms_documenttypes.lasteditedby, dms_documenttypes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$documenttypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$projectdocuments=new Projectdocuments();
	$where=" where id=$id ";
	$fields="pm_projectdocuments.id, pm_projectdocuments.projectid, pm_projectdocuments.documenttypeid, pm_projectdocuments.file, pm_projectdocuments.uploadedon, pm_projectdocuments.type, pm_projectdocuments.remarks, pm_projectdocuments.ipaddress, pm_projectdocuments.createdby, pm_projectdocuments.createdon, pm_projectdocuments.lasteditedby, pm_projectdocuments.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$projectdocuments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$projectdocuments->fetchObject;

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
	
	
$page_title="Projectdocuments ";
include "addprojectdocuments.php";
?>