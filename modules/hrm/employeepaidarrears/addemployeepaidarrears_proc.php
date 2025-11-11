<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Employeepaidarrears_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../hrm/arrears/Arrears_class.php");
require_once("../../hrm/employees/Employees_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="9376";//Edit
}
else{
	$auth->roleid="9376";//Add
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
	$employeepaidarrears=new Employeepaidarrears();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$employeepaidarrears->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$employeepaidarrears=$employeepaidarrears->setObject($obj);
		if($employeepaidarrears->add($employeepaidarrears)){
			$error=SUCCESS;
			redirect("addemployeepaidarrears_proc.php?id=".$employeepaidarrears->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$employeepaidarrears=new Employeepaidarrears();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$employeepaidarrears->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$employeepaidarrears=$employeepaidarrears->setObject($obj);
		if($employeepaidarrears->edit($employeepaidarrears)){
			$error=UPDATESUCCESS;
			redirect("addemployeepaidarrears_proc.php?id=".$employeepaidarrears->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$arrears= new Arrears();
	$fields="hrm_arrears.id, hrm_arrears.name, hrm_arrears.percentaxable, hrm_arrears.status, hrm_arrears.remarks, hrm_arrears.createdby, hrm_arrears.createdon, hrm_arrears.lasteditedby, hrm_arrears.lasteditedon, hrm_arrears.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$arrears->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$employees= new Employees();
	$fields="hrm_employees.id, hrm_employees.pfnum, hrm_employees.payrollno, hrm_employees.firstname, hrm_employees.middlename, hrm_employees.lastname, hrm_employees.gender, hrm_employees.bloodgroup, hrm_employees.rhd, hrm_employees.supervisorid, hrm_employees.startdate, hrm_employees.enddate, hrm_employees.dob, hrm_employees.idno, hrm_employees.passportno, hrm_employees.phoneno, hrm_employees.email, hrm_employees.officemail, hrm_employees.physicaladdress, hrm_employees.nationalityid, hrm_employees.countyid, hrm_employees.constituencyid, hrm_employees.location, hrm_employees.town, hrm_employees.marital, hrm_employees.spouse, hrm_employees.spouseidno, hrm_employees.spousetel, hrm_employees.spouseemail, hrm_employees.nssfno, hrm_employees.nhifno, hrm_employees.pinno, hrm_employees.helbno, hrm_employees.employeebankid, hrm_employees.bankbrancheid, hrm_employees.bankacc, hrm_employees.clearingcode, hrm_employees.ref, hrm_employees.basic, hrm_employees.assignmentid, hrm_employees.gradeid, hrm_employees.statusid, hrm_employees.image, hrm_employees.createdby, hrm_employees.createdon, hrm_employees.lasteditedby, hrm_employees.lasteditedon, hrm_employees.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$employeepaidarrears=new Employeepaidarrears();
	$where=" where id=$id ";
	$fields="hrm_employeepaidarrears.id, hrm_employeepaidarrears.arrearid, hrm_employeepaidarrears.employeeid, hrm_employeepaidarrears.month, hrm_employeepaidarrears.year, hrm_employeepaidarrears.remarks, hrm_employeepaidarrears.ipaddress, hrm_employeepaidarrears.createdby, hrm_employeepaidarrears.createdon, hrm_employeepaidarrears.lasteditedby, hrm_employeepaidarrears.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employeepaidarrears->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$employeepaidarrears->fetchObject;

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
	
	
$page_title="Employeepaidarrears ";
include "addemployeepaidarrears.php";
?>