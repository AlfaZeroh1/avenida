<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Departmentdoctors_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../hos/departments/Departments_class.php");
require_once("../../hrm/employees/Employees_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8499";//Edit
}
else{
	$auth->roleid="8499";//Add
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
	$departmentdoctors=new Departmentdoctors();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$departmentdoctors->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$departmentdoctors=$departmentdoctors->setObject($obj);
		if($departmentdoctors->add($departmentdoctors)){
			$error=SUCCESS;
			redirect("adddepartmentdoctors_proc.php?id=".$departmentdoctors->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$departmentdoctors=new Departmentdoctors();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$departmentdoctors->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$departmentdoctors=$departmentdoctors->setObject($obj);
		if($departmentdoctors->edit($departmentdoctors)){
			$error=UPDATESUCCESS;
			redirect("adddepartmentdoctors_proc.php?id=".$departmentdoctors->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$departments= new Departments();
	$fields="hos_departments.id, hos_departments.name, hos_departments.remarks";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$departments->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$employees= new Employees();
	$fields="hrm_employees.id, hrm_employees.pfnum, hrm_employees.firstname, hrm_employees.middlename, hrm_employees.lastname, hrm_employees.gender, hrm_employees.bloodgroup, hrm_employees.rhd, hrm_employees.supervisorid, hrm_employees.startdate, hrm_employees.enddate, hrm_employees.dob, hrm_employees.idno, hrm_employees.passportno, hrm_employees.phoneno, hrm_employees.email, hrm_employees.officemail, hrm_employees.physicaladdress, hrm_employees.nationalityid, hrm_employees.countyid, hrm_employees.constituencyid, hrm_employees.location, hrm_employees.town, hrm_employees.marital, hrm_employees.spouse, hrm_employees.spouseidno, hrm_employees.spousetel, hrm_employees.spouseemail, hrm_employees.nssfno, hrm_employees.nhifno, hrm_employees.pinno, hrm_employees.helbno, hrm_employees.employeebankid, hrm_employees.bankbrancheid, hrm_employees.bankacc, hrm_employees.clearingcode, hrm_employees.ref, hrm_employees.basic, hrm_employees.assignmentid, hrm_employees.gradeid, hrm_employees.statusid, hrm_employees.image, hrm_employees.createdby, hrm_employees.createdon, hrm_employees.lasteditedby, hrm_employees.lasteditedon, hrm_employees.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$departmentdoctors=new Departmentdoctors();
	$where=" where id=$id ";
	$fields="hos_departmentdoctors.id, hos_departmentdoctors.departmentid, hos_departmentdoctors.employeeid, hos_departmentdoctors.remarks, hos_departmentdoctors.ipaddress, hos_departmentdoctors.createdby, hos_departmentdoctors.createdon, hos_departmentdoctors.lasteditedby, hos_departmentdoctors.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$departmentdoctors->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$departmentdoctors->fetchObject;

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
	
	
$page_title="Departmentdoctors ";
include "adddepartmentdoctors.php";
?>