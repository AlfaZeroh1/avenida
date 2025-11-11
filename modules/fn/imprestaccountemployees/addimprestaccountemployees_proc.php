<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Imprestaccountemployees_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../hrm/employees/Employees_class.php");
require_once("../../fn/imprestaccounts/Imprestaccounts_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="8123";//Edit
}
else{
	$auth->roleid="8123";//Add
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
	$imprestaccountemployees=new Imprestaccountemployees();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$imprestaccountemployees->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$imprestaccountemployees=$imprestaccountemployees->setObject($obj);
		if($imprestaccountemployees->add($imprestaccountemployees)){
			$error=SUCCESS;
			redirect("addimprestaccountemployees_proc.php?id=".$imprestaccountemployees->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$imprestaccountemployees=new Imprestaccountemployees();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$imprestaccountemployees->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$imprestaccountemployees=$imprestaccountemployees->setObject($obj);
		if($imprestaccountemployees->edit($imprestaccountemployees)){
			$error=UPDATESUCCESS;
			redirect("addimprestaccountemployees_proc.php?id=".$imprestaccountemployees->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$employees= new Employees();
	$fields="hrm_employees.id, hrm_employees.pfnum, hrm_employees.firstname, hrm_employees.middlename, hrm_employees.lastname, hrm_employees.gender, hrm_employees.bloodgroup, hrm_employees.rhd, hrm_employees.supervisorid, hrm_employees.startdate, hrm_employees.enddate, hrm_employees.dob, hrm_employees.idno, hrm_employees.passportno, hrm_employees.phoneno, hrm_employees.email, hrm_employees.officemail, hrm_employees.physicaladdress, hrm_employees.nationalityid, hrm_employees.countyid, hrm_employees.constituencyid, hrm_employees.location, hrm_employees.town, hrm_employees.marital, hrm_employees.spouse, hrm_employees.spouseidno, hrm_employees.spousetel, hrm_employees.spouseemail, hrm_employees.nssfno, hrm_employees.nhifno, hrm_employees.pinno, hrm_employees.helbno, hrm_employees.bankid, hrm_employees.bankbrancheid, hrm_employees.bankacc, hrm_employees.clearingcode, hrm_employees.ref, hrm_employees.basic, hrm_employees.assignmentid, hrm_employees.gradeid, hrm_employees.statusid, hrm_employees.image, hrm_employees.createdby, hrm_employees.createdon, hrm_employees.lasteditedby, hrm_employees.lasteditedon, hrm_employees.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$imprestaccounts= new Imprestaccounts();
	$fields="fn_imprestaccounts.id, fn_imprestaccounts.name, fn_imprestaccounts.employeeid, fn_imprestaccounts.remarks, fn_imprestaccounts.ipaddress, fn_imprestaccounts.createdby, fn_imprestaccounts.createdon, fn_imprestaccounts.lasteditedby, fn_imprestaccounts.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$imprestaccounts->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$imprestaccountemployees=new Imprestaccountemployees();
	$where=" where id=$id ";
	$fields="fn_imprestaccountemployees.id, fn_imprestaccountemployees.imprestaccountid, fn_imprestaccountemployees.employeeid, fn_imprestaccountemployees.addedon, fn_imprestaccountemployees.remarks, fn_imprestaccountemployees.ipaddress, fn_imprestaccountemployees.createdby, fn_imprestaccountemployees.createdon, fn_imprestaccountemployees.lasteditedby, fn_imprestaccountemployees.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$imprestaccountemployees->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$imprestaccountemployees->fetchObject;

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
	
	
$page_title="Imprestaccountemployees ";
include "addimprestaccountemployees.php";
?>