<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Employeedocuments_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../hrm/employees/Employees_class.php");
require_once("../../dms/documenttypes/Documenttypes_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4195";//Edit
}
else{
	$auth->roleid="4193";//Add
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
	$employeedocuments=new Employeedocuments();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$employeedocuments->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$employeedocuments=$employeedocuments->setObject($obj);
		if($employeedocuments->add($employeedocuments)){
			$error=SUCCESS;
			redirect("addemployeedocuments_proc.php?id=".$employeedocuments->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$employeedocuments=new Employeedocuments();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$employeedocuments->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$employeedocuments=$employeedocuments->setObject($obj);
		if($employeedocuments->edit($employeedocuments)){
			$error=UPDATESUCCESS;
			redirect("addemployeedocuments_proc.php?id=".$employeedocuments->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$employees= new Employees();
	$fields="hrm_employees.id, hrm_employees.pfnum, hrm_employees.firstname, hrm_employees.middlename, hrm_employees.lastname, hrm_employees.gender, hrm_employees.bloodgroup, hrm_employees.rhd, hrm_employees.supervisorid, hrm_employees.startdate, hrm_employees.enddate, hrm_employees.dob, hrm_employees.idno, hrm_employees.passportno, hrm_employees.phoneno, hrm_employees.email, hrm_employees.officemail, hrm_employees.physicaladdress, hrm_employees.nationalityid, hrm_employees.countyid, hrm_employees.constituencyid, hrm_employees.location, hrm_employees.town, hrm_employees.marital, hrm_employees.spouse, hrm_employees.spouseidno, hrm_employees.spousetel, hrm_employees.spouseemail, hrm_employees.nssfno, hrm_employees.nhifno, hrm_employees.pinno, hrm_employees.helbno, hrm_employees.employeebankid, hrm_employees.bankbrancheid, hrm_employees.bankacc, hrm_employees.clearingcode, hrm_employees.ref, hrm_employees.basic, hrm_employees.assignmentid, hrm_employees.gradeid, hrm_employees.statusid, hrm_employees.image, hrm_employees.createdby, hrm_employees.createdon, hrm_employees.lasteditedby, hrm_employees.lasteditedon, hrm_employees.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$documenttypes= new Documenttypes();
	$fields="dms_documenttypes.id, dms_documenttypes.name, dms_documenttypes.moduleid, dms_documenttypes.remarks, dms_documenttypes.ipaddress, dms_documenttypes.createdby, dms_documenttypes.createdon, dms_documenttypes.lasteditedby, dms_documenttypes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$documenttypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$employeedocuments=new Employeedocuments();
	$where=" where id=$id ";
	$fields="hrm_employeedocuments.id, hrm_employeedocuments.employeeid, hrm_employeedocuments.documenttypeid, hrm_employeedocuments.file, hrm_employeedocuments.remarks, hrm_employeedocuments.createdby, hrm_employeedocuments.createdon, hrm_employeedocuments.lasteditedby, hrm_employeedocuments.lasteditedon, hrm_employeedocuments.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employeedocuments->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$employeedocuments->fetchObject;

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
	
	
$page_title="Employeedocuments ";
include "addemployeedocuments.php";
?>