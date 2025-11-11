<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Employeeovertimes_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../hrm/overtimes/Overtimes_class.php");
require_once("../../hrm/employees/Employees_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="9388";//Edit
}
else{
	$auth->roleid="9388";//Add
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
	$employeeovertimes=new Employeeovertimes();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$employeeovertimes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$employeeovertimes=$employeeovertimes->setObject($obj);
		if($employeeovertimes->add($employeeovertimes)){
			$error=SUCCESS;
			redirect("addemployeeovertimes_proc.php?id=".$employeeovertimes->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$employeeovertimes=new Employeeovertimes();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$employeeovertimes->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$employeeovertimes=$employeeovertimes->setObject($obj);
		if($employeeovertimes->edit($employeeovertimes)){
			$error=UPDATESUCCESS;
			redirect("addemployeeovertimes_proc.php?id=".$employeeovertimes->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$overtimes= new Overtimes();
	$fields="hrm_overtimes.id, hrm_overtimes.name, hrm_overtimes.value, hrm_overtimes.remarks, hrm_overtimes.ipaddress, hrm_overtimes.createdby, hrm_overtimes.createdon, hrm_overtimes.lasteditedby, hrm_overtimes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$overtimes->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$employees= new Employees();
	$fields="hrm_employees.id, hrm_employees.pfnum, hrm_employees.payrollno, hrm_employees.firstname, hrm_employees.middlename, hrm_employees.lastname, hrm_employees.gender, hrm_employees.bloodgroup, hrm_employees.rhd, hrm_employees.supervisorid, hrm_employees.startdate, hrm_employees.enddate, hrm_employees.dob, hrm_employees.idno, hrm_employees.passportno, hrm_employees.phoneno, hrm_employees.email, hrm_employees.officemail, hrm_employees.physicaladdress, hrm_employees.nationalityid, hrm_employees.countyid, hrm_employees.constituencyid, hrm_employees.location, hrm_employees.town, hrm_employees.marital, hrm_employees.spouse, hrm_employees.spouseidno, hrm_employees.spousetel, hrm_employees.spouseemail, hrm_employees.nssfno, hrm_employees.nhifno, hrm_employees.pinno, hrm_employees.helbno, hrm_employees.employeebankid, hrm_employees.bankbrancheid, hrm_employees.bankacc, hrm_employees.clearingcode, hrm_employees.ref, hrm_employees.basic, hrm_employees.assignmentid, hrm_employees.gradeid, hrm_employees.statusid, hrm_employees.image, hrm_employees.createdby, hrm_employees.createdon, hrm_employees.lasteditedby, hrm_employees.lasteditedon, hrm_employees.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$employeeovertimes=new Employeeovertimes();
	$where=" where id=$id ";
	$fields="hrm_employeeovertimes.id, hrm_employeeovertimes.employeeid, hrm_employeeovertimes.overtimeid, hrm_employeeovertimes.hours, hrm_employeeovertimes.fromdate, hrm_employeeovertimes.todate, hrm_employeeovertimes.month, hrm_employeeovertimes.year, hrm_employeeovertimes.remarks, hrm_employeeovertimes.ipaddress, hrm_employeeovertimes.createdby, hrm_employeeovertimes.createdon, hrm_employeeovertimes.lasteditedby, hrm_employeeovertimes.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employeeovertimes->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$employeeovertimes->fetchObject;

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
	
	
$page_title="Employeeovertimes ";
include "addemployeeovertimes.php";
?>