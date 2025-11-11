<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Employeepaidallowances_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../hrm/employeepayments/Employeepayments_class.php");
require_once("../../hrm/allowances/Allowances_class.php");
require_once("../../hrm/employees/Employees_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="1141";//Edit
}
else{
	$auth->roleid="1139";//Add
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
	$employeepaidallowances=new Employeepaidallowances();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$employeepaidallowances->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$employeepaidallowances=$employeepaidallowances->setObject($obj);
		if($employeepaidallowances->add($employeepaidallowances)){
			$error=SUCCESS;
			redirect("addemployeepaidallowances_proc.php?id=".$employeepaidallowances->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$employeepaidallowances=new Employeepaidallowances();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$employeepaidallowances->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$employeepaidallowances=$employeepaidallowances->setObject($obj);
		if($employeepaidallowances->edit($employeepaidallowances)){
			$error=UPDATESUCCESS;
			redirect("addemployeepaidallowances_proc.php?id=".$employeepaidallowances->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$employeepayments= new Employeepayments();
	$fields="hrm_employeepayments.id, hrm_employeepayments.employeeid, hrm_employeepayments.assignmentid, hrm_employeepayments.paymentmodeid, hrm_employeepayments.bankid, hrm_employeepayments.employeebankid, hrm_employeepayments.bankbrancheid, hrm_employeepayments.bankacc, hrm_employeepayments.clearingcode, hrm_employeepayments.ref, hrm_employeepayments.month, hrm_employeepayments.year, hrm_employeepayments.basic, hrm_employeepayments.allowances, hrm_employeepayments.deductions, hrm_employeepayments.netpay, hrm_employeepayments.paidon, hrm_employeepayments.ipaddress, hrm_employeepayments.createdby, hrm_employeepayments.createdon, hrm_employeepayments.lasteditedby, hrm_employeepayments.lasteditedon";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employeepayments->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$allowances= new Allowances();
	$fields="hrm_allowances.id, hrm_allowances.name, hrm_allowances.amount, hrm_allowances.percentaxable, hrm_allowances.allowancetypeid, hrm_allowances.overall, hrm_allowances.frommonth, hrm_allowances.fromyear, hrm_allowances.tomonth, hrm_allowances.toyear, hrm_allowances.status, hrm_allowances.createdby, hrm_allowances.createdon, hrm_allowances.lasteditedby, hrm_allowances.lasteditedon, hrm_allowances.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$allowances->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$employees= new Employees();
	$fields="hrm_employees.id, hrm_employees.pfnum, hrm_employees.firstname, hrm_employees.middlename, hrm_employees.lastname, hrm_employees.gender, hrm_employees.bloodgroup, hrm_employees.rhd, hrm_employees.supervisorid, hrm_employees.startdate, hrm_employees.enddate, hrm_employees.dob, hrm_employees.idno, hrm_employees.passportno, hrm_employees.phoneno, hrm_employees.email, hrm_employees.officemail, hrm_employees.physicaladdress, hrm_employees.nationalityid, hrm_employees.countyid, hrm_employees.constituencyid, hrm_employees.location, hrm_employees.town, hrm_employees.marital, hrm_employees.spouse, hrm_employees.spouseidno, hrm_employees.spousetel, hrm_employees.spouseemail, hrm_employees.nssfno, hrm_employees.nhifno, hrm_employees.pinno, hrm_employees.helbno, hrm_employees.employeebankid, hrm_employees.bankbrancheid, hrm_employees.bankacc, hrm_employees.clearingcode, hrm_employees.ref, hrm_employees.basic, hrm_employees.assignmentid, hrm_employees.gradeid, hrm_employees.statusid, hrm_employees.image, hrm_employees.createdby, hrm_employees.createdon, hrm_employees.lasteditedby, hrm_employees.lasteditedon, hrm_employees.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$employeepaidallowances=new Employeepaidallowances();
	$where=" where id=$id ";
	$fields="hrm_employeepaidallowances.id, hrm_employeepaidallowances.employeepaymentid, hrm_employeepaidallowances.allowanceid, hrm_employeepaidallowances.employeeid, hrm_employeepaidallowances.amount, hrm_employeepaidallowances.month, hrm_employeepaidallowances.year, hrm_employeepaidallowances.paidon, hrm_employeepaidallowances.createdby, hrm_employeepaidallowances.createdon, hrm_employeepaidallowances.lasteditedby, hrm_employeepaidallowances.lasteditedon, hrm_employeepaidallowances.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employeepaidallowances->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$employeepaidallowances->fetchObject;

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
	
	
$page_title="Employeepaidallowances ";
include "addemployeepaidallowances.php";
?>