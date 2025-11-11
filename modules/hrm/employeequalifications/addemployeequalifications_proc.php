<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Employeequalifications_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../hrm/qualifications/Qualifications_class.php");
require_once("../../hrm/employees/Employees_class.php");
require_once("../../hrm/gradings/Gradings_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4199";//Edit
}
else{
	$auth->roleid="4197";//Add
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
	
	
if($obj->action=="Save"){
	$employeequalifications=new Employeequalifications();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$employeequalifications->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$employeequalifications=$employeequalifications->setObject($obj);
		if($employeequalifications->add($employeequalifications)){
			$error=SUCCESS;
			redirect("addemployeequalifications_proc.php?id=".$employeequalifications->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$employeequalifications=new Employeequalifications();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$employeequalifications->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$employeequalifications=$employeequalifications->setObject($obj);
		if($employeequalifications->edit($employeequalifications)){
			$error=UPDATESUCCESS;
			redirect("addemployeequalifications_proc.php?id=".$employeequalifications->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$qualifications= new Qualifications();
	$fields="hrm_qualifications.id, hrm_qualifications.name, hrm_qualifications.remarks, hrm_qualifications.createdby, hrm_qualifications.createdon, hrm_qualifications.lasteditedby, hrm_qualifications.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$qualifications->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$employees= new Employees();
	$fields="hrm_employees.id, hrm_employees.pfnum, hrm_employees.firstname, hrm_employees.middlename, hrm_employees.lastname, hrm_employees.gender, hrm_employees.supervisorid, hrm_employees.startdate, hrm_employees.enddate, hrm_employees.dob, hrm_employees.idno, hrm_employees.passportno, hrm_employees.phoneno, hrm_employees.email, hrm_employees.officemail, hrm_employees.physicaladdress, hrm_employees.nationalityid, hrm_employees.countyid, hrm_employees.marital, hrm_employees.spouse, hrm_employees.spouseidno, hrm_employees.spousetel, hrm_employees.spouseemail, hrm_employees.nssfno, hrm_employees.nhifno, hrm_employees.pinno, hrm_employees.helbno, hrm_employees.bankid, hrm_employees.bankbrancheid, hrm_employees.bankacc, hrm_employees.clearingcode, hrm_employees.ref, hrm_employees.basic, hrm_employees.assignmentid, hrm_employees.gradeid, hrm_employees.statusid, hrm_employees.image, hrm_employees.createdby, hrm_employees.createdon, hrm_employees.lasteditedby, hrm_employees.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$gradings= new Gradings();
	$fields="hrm_gradings.id, hrm_gradings.name, hrm_gradings.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$gradings->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$employeequalifications=new Employeequalifications();
	$where=" where id=$id ";
	$fields="hrm_employeequalifications.id, hrm_employeequalifications.employeeid, hrm_employeequalifications.qualificationid, hrm_employeequalifications.title, hrm_employeequalifications.institution, hrm_employeequalifications.gradingid, hrm_employeequalifications.remarks, hrm_employeequalifications.createdby, hrm_employeequalifications.createdon, hrm_employeequalifications.lasteditedby, hrm_employeequalifications.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employeequalifications->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$employeequalifications->fetchObject;

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
	
	
$page_title="Employeequalifications ";
include "addemployeequalifications.php";
?>