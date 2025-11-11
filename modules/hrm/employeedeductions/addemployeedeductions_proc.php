<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Employeedeductions_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../hrm/deductiontypes/Deductiontypes_class.php");
require_once("../../hrm/employees/Employees_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="1133";//Edit
}
else{
	$auth->roleid="1131";//Add
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
	$employeedeductions=new Employeedeductions();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$employeedeductions->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$employeedeductions=$employeedeductions->setObject($obj);
		if($employeedeductions->add($employeedeductions)){
			$error=SUCCESS;
			redirect("addemployeedeductions_proc.php?id=".$employeedeductions->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$employeedeductions=new Employeedeductions();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$employeedeductions->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$employeedeductions=$employeedeductions->setObject($obj);
		if($employeedeductions->edit($employeedeductions)){
			$error=UPDATESUCCESS;
			redirect("addemployeedeductions_proc.php?id=".$employeedeductions->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$deductiontypes= new Deductiontypes();
	$fields="hrm_deductiontypes.id, hrm_deductiontypes.name, hrm_deductiontypes.repeatafter, hrm_deductiontypes.remarks, hrm_deductiontypes.createdby, hrm_deductiontypes.createdon, hrm_deductiontypes.lasteditedby, hrm_deductiontypes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$deductiontypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$employees= new Employees();
	$fields="hrm_employees.id, hrm_employees.pfnum, hrm_employees.firstname, hrm_employees.middlename, hrm_employees.lastname, hrm_employees.gender, hrm_employees.dob, hrm_employees.idno, hrm_employees.passportno, hrm_employees.phoneno, hrm_employees.email, hrm_employees.physicaladdress, hrm_employees.nationalityid, hrm_employees.countyid, hrm_employees.marital, hrm_employees.spouse, hrm_employees.nssfno, hrm_employees.nhifno, hrm_employees.pinno, hrm_employees.helbno, hrm_employees.employeebankid, hrm_employees.bankbrancheid, hrm_employees.bankacc, hrm_employees.clearingcode, hrm_employees.ref, hrm_employees.basic, hrm_employees.assignmentid, hrm_employees.gradeid, hrm_employees.statusid, hrm_employees.image, hrm_employees.createdby, hrm_employees.createdon, hrm_employees.lasteditedby, hrm_employees.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$employeedeductions=new Employeedeductions();
	$where=" where id=$id ";
	$fields="hrm_employeedeductions.id, hrm_employeedeductions.deductionid, hrm_employeedeductions.amount, hrm_employeedeductions.deductiontypeid, hrm_employeedeductions.frommonth, hrm_employeedeductions.fromyear, hrm_employeedeductions.tomonth, hrm_employeedeductions.toyear, hrm_employeedeductions.remarks, hrm_employeedeductions.employeeid, hrm_employeedeductions.createdby, hrm_employeedeductions.createdon, hrm_employeedeductions.lasteditedby, hrm_employeedeductions.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employeedeductions->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$employeedeductions->fetchObject;

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
	
	
$page_title="Employeedeductions ";
include "addemployeedeductions.php";
?>