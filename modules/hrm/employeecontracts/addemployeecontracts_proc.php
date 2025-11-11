<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Employeecontracts_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../hrm/employees/Employees_class.php");
require_once("../../hrm/contracttypes/Contracttypes_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4757";//Edit
}
else{
	$auth->roleid="4757";//Add
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
	$employeecontracts=new Employeecontracts();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$employeecontracts->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$employeecontracts=$employeecontracts->setObject($obj);
		if($employeecontracts->add($employeecontracts)){
			$error=SUCCESS;
			redirect("addemployeecontracts_proc.php?id=".$employeecontracts->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$employeecontracts=new Employeecontracts();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$employeecontracts->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$employeecontracts=$employeecontracts->setObject($obj);
		if($employeecontracts->edit($employeecontracts)){
			$error=UPDATESUCCESS;
			redirect("addemployeecontracts_proc.php?id=".$employeecontracts->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$employees= new Employees();
	$fields="hrm_employees.id, hrm_employees.pfnum, hrm_employees.firstname, hrm_employees.middlename, hrm_employees.lastname, hrm_employees.gender, hrm_employees.dob, hrm_employees.idno, hrm_employees.phoneno, hrm_employees.email, hrm_employees.physicaladdress, hrm_employees.nationalityid, hrm_employees.countyid, hrm_employees.marital, hrm_employees.spouse, hrm_employees.nssfno, hrm_employees.nhifno, hrm_employees.pinno, hrm_employees.helbno, hrm_employees.employeebankid, hrm_employees.bankbrancheid, hrm_employees.bankacc, hrm_employees.clearingcode, hrm_employees.ref, hrm_employees.basic, hrm_employees.assignmentid, hrm_employees.gradeid, hrm_employees.statusid, hrm_employees.image, hrm_employees.createdby, hrm_employees.createdon, hrm_employees.lasteditedby, hrm_employees.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$contracttypes= new Contracttypes();
	$fields="hrm_contracttypes.id, hrm_contracttypes.name, hrm_contracttypes.remarks, hrm_contracttypes.createdby, hrm_contracttypes.createdon, hrm_contracttypes.lasteditedby, hrm_contracttypes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$contracttypes->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$employeecontracts=new Employeecontracts();
	$where=" where id=$id ";
	$fields="hrm_employeecontracts.id, hrm_employeecontracts.contracttypeid, hrm_employeecontracts.startdate, hrm_employeecontracts.confirmationdate, hrm_employeecontracts.probation, hrm_employeecontracts.contractperiod, hrm_employeecontracts.status, hrm_employeecontracts.remarks, hrm_employeecontracts.employeeid, hrm_employeecontracts.createdby, hrm_employeecontracts.createdon, hrm_employeecontracts.lasteditedby, hrm_employeecontracts.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employeecontracts->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$employeecontracts->fetchObject;

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
	
	
$page_title="Employeecontracts ";
include "addemployeecontracts.php";
?>