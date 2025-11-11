<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Projectstatus_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../con/projects/Projects_class.php");
require_once("../../con/statuss/Statuss_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="7584";//Edit
}
else{
	$auth->roleid="7582";//Add
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
	$projectstatus=new Projectstatus();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$projectstatus->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$projectstatus=$projectstatus->setObject($obj);
		if($projectstatus->add($projectstatus)){
			$error=SUCCESS;
			redirect("addprojectstatus_proc.php?id=".$projectstatus->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$projectstatus=new Projectstatus();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$projectstatus->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$projectstatus=$projectstatus->setObject($obj);
		if($projectstatus->edit($projectstatus)){
			$error=UPDATESUCCESS;
			redirect("addprojectstatus_proc.php?id=".$projectstatus->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$projects= new Projects();
	$fields="con_projects.id, con_projects.name, con_projects.projecttypeid, con_projects.customerid, con_projects.employeeid, con_projects.regionid, con_projects.subregionid, con_projects.contractno, con_projects.physicaladdress, con_projects.scope, con_projects.value, con_projects.dateawarded, con_projects.acceptanceletterdate, con_projects.contractsignedon, con_projects.orderdatetocommence, con_projects.startdate, con_projects.expectedenddate, con_projects.actualenddate, con_projects.liabilityperiodtype, con_projects.liabilityperiod, con_projects.remarks, con_projects.statusid, con_projects.ipaddress, con_projects.createdby, con_projects.createdon, con_projects.lasteditedby, con_projects.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$projects->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$statuss= new Statuss();
	$fields="con_statuss.id, con_statuss.name, con_statuss.remarks, con_statuss.ipaddress, con_statuss.createdby, con_statuss.createdon, con_statuss.lasteditedby, con_statuss.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$statuss->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$projectstatus=new Projectstatus();
	$where=" where id=$id ";
	$fields="con_projectstatus.id, con_projectstatus.projectid, con_projectstatus.statusid, con_projectstatus.changedon, con_projectstatus.remarks, con_projectstatus.ipaddress, con_projectstatus.createdby, con_projectstatus.createdon, con_projectstatus.lasteditedby, con_projectstatus.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$projectstatus->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$projectstatus->fetchObject;

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
	
	
$page_title="Projectstatus ";
include "addprojectstatus.php";
?>