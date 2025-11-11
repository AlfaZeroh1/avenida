<?php 
session_start();
require_once("../../../DB.php");
require_once("../../../lib.php");
require_once("Employeeloans_class.php");
require_once("../../auth/rules/Rules_class.php");


if(empty($_SESSION['userid'])){;
	redirect("../../auth/users/login.php");
}

require_once("../../hrm/loans/Loans_class.php");
require_once("../../hrm/employees/Employees_class.php");
//Authorization.
if(!empty($_GET['id'])){
	$auth->roleid="1137";//Edit
}
else{
	$auth->roleid="1135";//Add
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
	$employeeloans=new Employeeloans();
	$obj->createdby=$_SESSION['userid'];
	$obj->createdon=date("Y-m-d H:i:s");
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");
	$obj->ipaddress=$_SERVER['REMOTE_ADDR'];
	$error=$employeeloans->validate($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$employeeloans=$employeeloans->setObject($obj);
		if($employeeloans->add($employeeloans)){
			$error=SUCCESS;
			redirect("addemployeeloans_proc.php?id=".$employeeloans->id."&error=".$error);
		}
		else{
			$error=FAILURE;
		}
	}
}
	
if($obj->action=="Update"){
	$employeeloans=new Employeeloans();
	$obj->lasteditedby=$_SESSION['userid'];
	$obj->lasteditedon=date("Y-m-d H:i:s");

	$error=$employeeloans->validates($obj);
	if(!empty($error)){
		$error=$error;
	}
	else{
		$employeeloans=$employeeloans->setObject($obj);
		if($employeeloans->edit($employeeloans)){
			$error=UPDATESUCCESS;
			redirect("addemployeeloans_proc.php?id=".$employeeloans->id."&error=".$error);
		}
		else{
			$error=UPDATEFAILURE;
		}
	}
}
if(empty($obj->action)){

	$loans= new Loans();
	$fields="hrm_loans.id, hrm_loans.name, hrm_loans.method, hrm_loans.description, hrm_loans.createdby, hrm_loans.createdon, hrm_loans.lasteditedby, hrm_loans.lasteditedon, hrm_loans.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$loans->retrieve($fields,$join,$where,$having,$groupby,$orderby);


	$employees= new Employees();
	$fields="hrm_employees.id, hrm_employees.pfnum, hrm_employees.firstname, hrm_employees.middlename, hrm_employees.lastname, hrm_employees.gender, hrm_employees.bloodgroup, hrm_employees.rhd, hrm_employees.supervisorid, hrm_employees.startdate, hrm_employees.enddate, hrm_employees.dob, hrm_employees.idno, hrm_employees.passportno, hrm_employees.phoneno, hrm_employees.email, hrm_employees.officemail, hrm_employees.physicaladdress, hrm_employees.nationalityid, hrm_employees.countyid, hrm_employees.constituencyid, hrm_employees.location, hrm_employees.town, hrm_employees.marital, hrm_employees.spouse, hrm_employees.spouseidno, hrm_employees.spousetel, hrm_employees.spouseemail, hrm_employees.nssfno, hrm_employees.nhifno, hrm_employees.pinno, hrm_employees.helbno, hrm_employees.employeebankid, hrm_employees.bankbrancheid, hrm_employees.bankacc, hrm_employees.clearingcode, hrm_employees.ref, hrm_employees.basic, hrm_employees.assignmentid, hrm_employees.gradeid, hrm_employees.statusid, hrm_employees.image, hrm_employees.createdby, hrm_employees.createdon, hrm_employees.lasteditedby, hrm_employees.lasteditedon, hrm_employees.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);

}

if(!empty($id)){
	$employeeloans=new Employeeloans();
	$where=" where id=$id ";
	$fields="hrm_employeeloans.id, hrm_employeeloans.loanid, hrm_employeeloans.employeeid, hrm_employeeloans.principal, hrm_employeeloans.method, hrm_employeeloans.initialvalue, hrm_employeeloans.payable, hrm_employeeloans.duration, hrm_employeeloans.interesttype, hrm_employeeloans.interest, hrm_employeeloans.month, hrm_employeeloans.year, hrm_employeeloans.createdby, hrm_employeeloans.createdon, hrm_employeeloans.lasteditedby, hrm_employeeloans.lasteditedon, hrm_employeeloans.ipaddress";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employeeloans->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$obj=$employeeloans->fetchObject;

	//for autocompletes
	$employees = new Employees();
	$fields=" concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) name ";
	$where=" where id='$obj->employeeid'";
	$join="";
	$having="";
	$groupby="";
	$orderby="";
	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);
	$auto=$employees->fetchObject;

	$obj->employeename=$auto->name;
}

// if(!empty($ob->loanid) and !empty($ob->employeeid))
// {
// $employeeloans=new Employeeloans();
// 	$where=" where loanid='$ob->loanid' and employeeid='$ob->employeeid' ";
// 	$fields="hrm_employeeloans.id, hrm_employeeloans.loanid, hrm_employeeloans.employeeid, hrm_employeeloans.principal, hrm_employeeloans.method, hrm_employeeloans.initialvalue, hrm_employeeloans.payable, hrm_employeeloans.duration, hrm_employeeloans.interesttype, hrm_employeeloans.interest, hrm_employeeloans.month, hrm_employeeloans.year, hrm_employeeloans.createdby, hrm_employeeloans.createdon, hrm_employeeloans.lasteditedby, hrm_employeeloans.lasteditedon, hrm_employeeloans.ipaddress";
// 	$join="";
// 	$having="";
// 	$groupby="";
// 	$orderby="";
// 	$employeeloans->retrieve($fields,$join,$where,$having,$groupby,$orderby);
// 	$obj=$employeeloans->fetchObject;
// 
// 	//for autocompletes
// 	$employees = new Employees();
// 	$fields=" concat(hrm_employees.firstname,' ',concat(hrm_employees.middlename,' ',hrm_employees.lastname)) name ";
// 	$where=" where id='$obj->employeeid'";
// 	$join="";
// 	$having="";
// 	$groupby="";
// 	$orderby="";
// 	$employees->retrieve($fields,$join,$where,$having,$groupby,$orderby);
// 	$auto=$employees->fetchObject;
// 
// 	$obj->employeename=$auto->name;
// 	$obj->loanid=$ob->loanid;
// 	$obj->employeeid=$ob->employeeid;
// 
// }

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
	
	
$page_title="Employeeloans ";
include "addemployeeloans.php";
?>