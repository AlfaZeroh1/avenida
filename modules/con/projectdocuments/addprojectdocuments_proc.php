<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Projectdocuments_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../con/projects/Projects_class.php");
require_once("../../dms/documenttypes/Documenttypes_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8163";//Edit
}
else{
	$auth->roleid="8163";//Add
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
	$fields="con_projects.id, con_projects.tenderid, con_projects.name, con_projects.projecttypeid, con_projects.customerid, con_projects.employeeid, con_projects.regionid, con_projects.subregionid, con_projects.contractno, con_projects.physicaladdress, con_projects.scope, con_projects.value, con_projects.dateawarded, con_projects.acceptanceletterdate, con_projects.contractsignedon, con_projects.orderdatetocommence, con_projects.startdate, con_projects.expectedenddate, con_projects.actualenddate, con_projects.liabilityperiodtype, con_projects.liabilityperiod, con_projects.remarks, con_projects.statusid, con_projects.ipaddress, con_projects.createdby, con_projects.createdon, con_projects.lasteditedby, con_projects.lasteditedon";
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
	$fields="con_projectdocuments.id, con_projectdocuments.projectid, con_projectdocuments.documenttypeid, con_projectdocuments.file, con_projectdocuments.remarks, con_projectdocuments.documentdate, con_projectdocuments.ipaddress, con_projectdocuments.createdby, con_projectdocuments.createdon, con_projectdocuments.lasteditedby, con_projectdocuments.lasteditedon";
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