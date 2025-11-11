<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Projectreviews_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../con/projects/Projects_class.php");
require_once("../../hrm/employees/Employees_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="7576";//Edit
}
else{
	$auth->roleid="7574";//Add
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
	$projectreviews=new Projectreviews();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$projectreviews->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$projectreviews=$projectreviews->setObject($obj);
		if($projectreviews->add($projectreviews)){
			$error=SUCCESS;
			redirect("addprojectreviews_proc.php?id=".$projectreviews->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$projectreviews=new Projectreviews();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$projectreviews->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$projectreviews=$projectreviews->setObject($obj);
		if($projectreviews->edit($projectreviews)){
			$error=UPDATESUCCESS;
			redirect("addprojectreviews_proc.php?id=".$projectreviews->id."&error=".$error);
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


	$employees= new Employees();
	$fields="hrm_employees.id, hrm_employees.pfnum, hrm_employees.firstname, hrm_employees.middlename, hrm_employees.lastname, hrm_employees.gender, hrm_employees.bloodgroup, hrm_employees.rhd, hrm_employees.supervisorid, hrm_employees.startdate, hrm_employees.enddate, hrm_employees.dob, hrm_employees.idno, hrm_employees.passportno, hrm_employees.phoneno, hrm_employees.email, hrm_employees.officemail, hrm_employees.physicaladdress, hrm_employees.nationalityid, hrm_employees.countyid, hrm_employees.constituencyid, hrm_employees.location, hrm_employees.town, hrm_employees.marital, hrm_employees.spouse, hrm_employees.spouseidno, hrm_employees.spousetel, hrm_employees.spouseemail, hrm_employees.nssfno, hrm_employees.nhifno, hrm_employees.pinno, hrm_employees.helbno, hrm_employees.bankid, hrm_employees.bankbrancheid, hrm_employees.bankacc, hrm_employees.clearingcode, hrm_employees.ref, hrm_employees.basic, hrm_employees.assignmentid, hrm_employees.gradeid, hrm_employees.statusid, hrm_employees.image, hrm_employees.createdby, hrm_employees.createdon, hrm_employees.lasteditedby, hrm_employees.lasteditedon, hrm_employees.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$projectreviews=new Projectreviews();
	$where=" where id=$id ";
	$fields="con_projectreviews.id, con_projectreviews.projectid, con_projectreviews.employeeid, con_projectreviews.findings, con_projectreviews.recommendations, con_projectreviews.reviewedon, con_projectreviews.remarks, con_projectreviews.ipaddress, con_projectreviews.createdby, con_projectreviews.createdon, con_projectreviews.lasteditedby, con_projectreviews.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$projectreviews->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$projectreviews->fetchObject;

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
	
	
$page_title="Projectreviews ";
include "addprojectreviews.php";
?>