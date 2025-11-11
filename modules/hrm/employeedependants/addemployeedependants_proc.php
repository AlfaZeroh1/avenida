<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Employeedependants_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../hrm/employees/Employees_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="4191";//Edit
}
else{
	$auth->roleid="4189";//Add
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
	$employeedependants=new Employeedependants();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$error=$employeedependants->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$employeedependants=$employeedependants->setObject($obj);
		if($employeedependants->add($employeedependants)){
			$error=SUCCESS;
			redirect("addemployeedependants_proc.php?id=".$employeedependants->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$employeedependants=new Employeedependants();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$employeedependants->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$employeedependants=$employeedependants->setObject($obj);
		if($employeedependants->edit($employeedependants)){
			$error=UPDATESUCCESS;
			redirect("addemployeedependants_proc.php?id=".$employeedependants->id."&error=".$error);
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

}

if(!empty($id)){
	$employeedependants=new Employeedependants();
	$where=" where id=$id ";
	$fields="hrm_employeedependants.id, hrm_employeedependants.employeeid, hrm_employeedependants.name, hrm_employeedependants.dob, hrm_employeedependants.createdby, hrm_employeedependants.createdon, hrm_employeedependants.lasteditedby, hrm_employeedependants.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employeedependants->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$employeedependants->fetchObject;

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
	
	
$page_title="Employeedependants ";
include "addemployeedependants.php";
?>