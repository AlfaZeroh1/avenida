<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Reportprogress_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../assets/reports/Reports_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8849";//Edit
}
else{
	$auth->roleid="8849";//Add
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
	$reportprogress=new Reportprogress();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$reportprogress->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$reportprogress=$reportprogress->setObject($obj);
		if($reportprogress->add($reportprogress)){
			$error=SUCCESS;
			redirect("addreportprogress_proc.php?id=".$reportprogress->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$reportprogress=new Reportprogress();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$reportprogress->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$reportprogress=$reportprogress->setObject($obj);
		if($reportprogress->edit($reportprogress)){
			$error=UPDATESUCCESS;
			redirect("addreportprogress_proc.php?id=".$reportprogress->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$reports= new Reports();
	$fields="assets_reports.id, assets_reports.assetid, assets_reports.employeeid, assets_reports.reportedon, assets_reports.description, assets_reports.remarks, assets_reports.ipaddress, assets_reports.createdby, assets_reports.createdon, assets_reports.lasteditedby, assets_reports.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$reports->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$reportprogress=new Reportprogress();
	$where=" where id=$id ";
	$fields="assets_reportprogress.id, assets_reportprogress.reportid, assets_reportprogress.status, assets_reportprogress.remarks, assets_reportprogress.ipaddress, assets_reportprogress.createdby, assets_reportprogress.createdon, assets_reportprogress.lasteditedby, assets_reportprogress.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$reportprogress->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$reportprogress->fetchObject;

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
	
	
$page_title="Reportprogress ";
include "addreportprogress.php";
?>